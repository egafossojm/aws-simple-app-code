<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Model\Assertion;

use LightSaml\Credential\CredentialInterface;
use LightSaml\Error\LightSamlSecurityException;
use LightSaml\Error\LightSamlXmlException;
use LightSaml\Model\Context\DeserializationContext;
use LightSaml\Model\Context\SerializationContext;
use RobRichards\XMLSecLibs\XMLSecEnc;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class EncryptedElementReader extends EncryptedElement
{
    /** @var XMLSecEnc */
    protected $xmlEnc;

    /** @var XMLSecurityKey */
    protected $symmetricKey;

    /** @var XMLSecurityKey */
    protected $symmetricKeyInfo;

    /**
     * @return XMLSecurityKey
     */
    public function getSymmetricKey()
    {
        return $this->symmetricKey;
    }

    /**
     * @return XMLSecurityKey
     */
    public function getSymmetricKeyInfo()
    {
        return $this->symmetricKeyInfo;
    }

    /**
     * @return void
     *
     * @throws \LogicException
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        throw new \LogicException('EncryptedElementReader can not be used for serialization');
    }

    public function deserialize(\DOMNode $node, DeserializationContext $context)
    {
        $list = $context->getXpath()->query('xenc:EncryptedData', $node);
        if ($list->length == 0) {
            throw new LightSamlXmlException('Missing encrypted data in <saml:EncryptedAssertion>');
        }
        if ($list->length != 1) {
            throw new LightSamlXmlException('More than one encrypted data element in <saml:EncryptedAssertion>');
        }

        /** @var \DOMElement $encryptedData */
        $encryptedData = $list->item(0);
        $this->xmlEnc = new XMLSecEnc;
        $this->xmlEnc->setNode($encryptedData);
        $this->xmlEnc->type = $encryptedData->getAttribute('Type');

        $this->symmetricKey = $this->loadSymmetricKey();

        $this->symmetricKeyInfo = $this->loadSymmetricKeyInfo($this->symmetricKey);
    }

    /**
     * @param  XMLSecurityKey[]  $inputKeys
     * @return \DOMElement
     *
     * @throws \LogicException
     * @throws \LightSaml\Error\LightSamlXmlException
     * @throws \LightSaml\Error\LightSamlSecurityException
     */
    public function decryptMulti(array $inputKeys)
    {
        /** @var \LogicException $lastException */
        $lastException = null;

        foreach ($inputKeys as $key) {
            if ($key instanceof CredentialInterface) {
                $key = $key->getPrivateKey();
            }
            if ($key instanceof XMLSecurityKey == false) {
                throw new \InvalidArgumentException('Expected XMLSecurityKey');
            }

            try {
                return $this->decrypt($key);
            } catch (\Exception $ex) {
                $lastException = $ex;
            }
        }

        if ($lastException) {
            throw $lastException;
        }

        throw new LightSamlSecurityException('No key provided for decryption');
    }

    /**
     * @return \DOMElement
     *
     * @throws \LogicException
     * @throws \LightSaml\Error\LightSamlXmlException
     * @throws \LightSaml\Error\LightSamlSecurityException
     */
    public function decrypt(XMLSecurityKey $inputKey)
    {
        $this->symmetricKey = $this->loadSymmetricKey();
        $this->symmetricKeyInfo = $this->loadSymmetricKeyInfo($this->symmetricKey);

        if ($this->symmetricKeyInfo->isEncrypted) {
            $this->decryptSymmetricKey($inputKey);
        } else {
            $this->symmetricKey = $inputKey;
        }

        $decrypted = $this->decryptCipher();

        $result = $this->buildXmlElement($decrypted);

        return $result;
    }

    /**
     * @param  string  $decrypted
     * @return \DOMElement
     */
    protected function buildXmlElement($decrypted)
    {
        /*
         * This is a workaround for the case where only a subset of the XML
         * tree was serialized for encryption. In that case, we may miss the
         * namespaces needed to parse the XML.
         */
        $xml = sprintf(
            '<root xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">%s</root>',
            $decrypted
        );
        $newDoc = new \DOMDocument;
        if (@$newDoc->loadXML($xml) == false) {
            throw new LightSamlXmlException('Failed to parse decrypted XML. Maybe the wrong sharedkey was used?');
        }
        $decryptedElement = $newDoc->firstChild->firstChild;
        if ($decryptedElement == null) {
            throw new LightSamlSecurityException('Missing encrypted element.');
        }

        if ($decryptedElement instanceof \DOMElement == false) {
            throw new LightSamlXmlException('Decrypted element was not actually a DOMElement.');
        }

        return $decryptedElement;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    protected function decryptCipher()
    {
        $decrypted = $this->xmlEnc->decryptNode($this->symmetricKey, false);
        if (is_string($decrypted) == false) {
            throw new \LogicException('Expected decrypted string');
        }

        return $decrypted;
    }

    /**
     * @throws \Exception
     */
    protected function decryptSymmetricKey(XMLSecurityKey $inputKey)
    {
        /** @var XMLSecEnc $encKey */
        $encKey = $this->symmetricKeyInfo->encryptedCtx;
        $this->symmetricKeyInfo->key = $inputKey->key;

        $keySize = $this->symmetricKey->getSymmetricKeySize();
        if ($keySize === null) {
            // To protect against "key oracle" attacks, we need to be able to create a
            // symmetric key, and for that we need to know the key size.
            throw new LightSamlSecurityException(sprintf(
                "Unknown key size for encryption algorithm: '%s'",
                $this->symmetricKey->type
            ));
        }

        /** @var string $key */
        $key = $encKey->decryptKey($this->symmetricKeyInfo);
        if (is_string($key) == false) {
            throw new \LogicException('Expected string');
        }
        if (strlen($key) != $keySize) {
            throw new LightSamlSecurityException(sprintf(
                "Unexpected key size of '%s' bits for encryption algorithm '%s', expected '%s' bits size",
                strlen($key) * 8,
                $this->symmetricKey->type,
                $keySize
            ));
        }

        $this->symmetricKey->loadkey($key);
    }

    /**
     * @return XMLSecurityKey
     *
     * @throws \LightSaml\Error\LightSamlXmlException
     */
    protected function loadSymmetricKey()
    {
        $symmetricKey = $this->xmlEnc->locateKey();
        if ($symmetricKey == false) {
            throw new LightSamlXmlException('Could not locate key algorithm in encrypted data');
        }

        return $symmetricKey;
    }

    /**
     * @return XMLSecurityKey
     *
     * @throws \LightSaml\Error\LightSamlXmlException
     */
    protected function loadSymmetricKeyInfo(XMLSecurityKey $symmetricKey)
    {
        $symmetricKeyInfo = $this->xmlEnc->locateKeyInfo($symmetricKey);
        if ($symmetricKeyInfo == false) {
            throw new LightSamlXmlException('Could not locate <dsig:KeyInfo> for the encrypted key');
        }

        return $symmetricKeyInfo;
    }
}
