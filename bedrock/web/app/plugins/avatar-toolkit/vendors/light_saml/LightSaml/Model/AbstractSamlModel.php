<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Model;

use LightSaml\Error\LightSamlXmlException;
use LightSaml\Model\Context\DeserializationContext;
use LightSaml\Model\Context\SerializationContext;

abstract class AbstractSamlModel implements SamlElementInterface
{
    /**
     * @param  string  $name
     * @param  null|string  $namespace
     * @return \DOMElement
     */
    protected function createElement($name, $namespace, \DOMNode $parent, SerializationContext $context)
    {
        if ($namespace) {
            $result = $context->getDocument()->createElementNS($namespace, $name);
        } else {
            $result = $context->getDocument()->createElement($name);
        }
        $parent->appendChild($result);

        return $result;
    }

    /**
     * @param  string  $name
     * @param  string|null  $namespace
     *
     * @throws \LogicException
     */
    private function oneElementToXml($name, \DOMNode $parent, SerializationContext $context, $namespace = null)
    {
        $value = $this->getPropertyValue($name);
        if ($value == null) {
            return;
        }
        if ($value instanceof SamlElementInterface) {
            $value->serialize($parent, $context);
        } elseif (is_string($value)) {
            if ($namespace) {
                $node = $context->getDocument()->createElementNS($namespace, $name, $value);
            } else {
                $node = $context->getDocument()->createElement($name, $value);
            }
            $parent->appendChild($node);
        } else {
            throw new \LogicException(sprintf("Element '%s' must implement SamlElementInterface or be a string", $name));
        }
    }

    /**
     * @param  array|string[]  $names
     * @param  string|null  $namespace
     */
    protected function singleElementsToXml(array $names, \DOMNode $parent, SerializationContext $context, $namespace = null)
    {
        foreach ($names as $name) {
            $this->oneElementToXml($name, $parent, $context, $namespace);
        }
    }

    /**
     * @param  array|null  $value
     * @param  null|string  $nodeName
     * @param  null|string  $namespaceUri
     *
     * @throws \LogicException
     */
    protected function manyElementsToXml($value, \DOMNode $node, SerializationContext $context, $nodeName = null, $namespaceUri = null)
    {
        if ($value == false) {
            return;
        }

        if (is_array($value) == false) {
            throw new \LogicException('value must be array or null');
        }

        foreach ($value as $object) {
            if ($object instanceof SamlElementInterface) {
                if ($nodeName) {
                    throw new \LogicException('nodeName should not be specified when serializing array of SamlElementInterface');
                }
                $object->serialize($node, $context);
            } elseif ($nodeName) {
                if ($namespaceUri) {
                    $child = $context->getDocument()->createElementNS($namespaceUri, $nodeName, (string) $object);
                } else {
                    $child = $context->getDocument()->createElement($nodeName, (string) $object);
                }
                $node->appendChild($child);
            } else {
                throw new \LogicException('Can handle only array of AbstractSamlModel or strings with nodeName parameter specified');
            }
        }
    }

    /**
     * @param  string  $nodeName
     * @param  string|null  $namespacePrefix
     * @param  string  $class
     * @param  string  $methodName
     *
     * @throws \LogicException
     */
    protected function manyElementsFromXml(\DOMElement $node, DeserializationContext $context, $nodeName, $namespacePrefix, $class, $methodName)
    {
        if ($namespacePrefix) {
            $query = sprintf('%s:%s', $namespacePrefix, $nodeName);
        } else {
            $query = sprintf('%s', $nodeName);
        }

        foreach ($context->getXpath()->query($query, $node) as $xml) {
            /* @var \DOMElement $xml */
            if ($class) {
                /** @var SamlElementInterface $object */
                $object = new $class;
                if ($object instanceof SamlElementInterface == false) {
                    throw new \LogicException(sprintf("Node '%s' class '%s' must implement SamlElementInterface", $nodeName, $class));
                }
                $object->deserialize($xml, $context);
                $this->{$methodName}($object);
            } else {
                $object = $xml->textContent;
                $this->{$methodName}($object);
            }
        }
    }

    /**
     * @param  string  $name
     * @return bool True if property value is not empty and attribute was set to the element
     *
     * @throws \LogicException
     */
    protected function singleAttributeToXml($name, \DOMElement $element)
    {
        $value = $this->getPropertyValue($name);
        if ($value !== null && $value !== '') {
            if (is_bool($value)) {
                $element->setAttribute($name, $value ? 'true' : 'false');
            } else {
                $element->setAttribute($name, $value);
            }

            return true;
        }

        return false;
    }

    /**
     * @param  array|string[]  $names
     */
    protected function attributesToXml(array $names, \DOMElement $element)
    {
        foreach ($names as $name) {
            $this->singleAttributeToXml($name, $element);
        }
    }

    /**
     * @param  string  $expectedName
     * @param  string  $expectedNamespaceUri
     */
    protected function checkXmlNodeName(\DOMNode &$node, $expectedName, $expectedNamespaceUri)
    {
        if ($node instanceof \DOMDocument) {
            $node = $node->firstChild;
        }
        while ($node && $node instanceof \DOMComment) {
            $node = $node->nextSibling;
        }
        if ($node === null) {
            throw new LightSamlXmlException(sprintf(
                "Unable to find expected '%s' xml node and '%s' namespace",
                $expectedName,
                $expectedNamespaceUri
            ));
        } elseif ($node->localName != $expectedName || $node->namespaceURI != $expectedNamespaceUri) {
            throw new LightSamlXmlException(sprintf(
                "Expected '%s' xml node and '%s' namespace but got node '%s' and namespace '%s'",
                $expectedName,
                $expectedNamespaceUri,
                $node->localName,
                $node->namespaceURI
            ));
        }
    }

    /**
     * @param  string  $attributeName
     */
    protected function singleAttributeFromXml(\DOMElement $node, $attributeName)
    {
        $value = $node->getAttribute($attributeName);
        if ($value !== '') {
            $setter = 'set'.$attributeName;
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }

    /**
     * @param  string  $elementName
     * @param  string  $class
     * @param  string  $namespacePrefix
     *
     * @throws \LogicException
     */
    protected function oneElementFromXml(\DOMElement $node, DeserializationContext $context, $elementName, $class, $namespacePrefix)
    {
        if ($namespacePrefix) {
            $query = sprintf('./%s:%s', $namespacePrefix, $elementName);
        } else {
            $query = sprintf('./%s', $elementName);
        }
        $arr = $context->getXpath()->query($query, $node);
        $value = $arr->length > 0 ? $arr->item(0) : null;

        if ($value) {
            $setter = 'set'.$elementName;
            if (method_exists($this, $setter) == false) {
                throw new \LogicException(sprintf(
                    "Unable to find setter for element '%s' in class '%s'",
                    $elementName,
                    get_class($this)
                ));
            }

            if ($class) {
                /** @var AbstractSamlModel $object */
                $object = new $class;
                if ($object instanceof \LightSaml\Model\SamlElementInterface == false) {
                    throw new \LogicException(sprintf(
                        "Specified class '%s' for element '%s' must implement SamlElementInterface",
                        $class,
                        $elementName
                    ));
                }

                $object->deserialize($value, $context);
            } else {
                $object = $value->textContent;
            }

            $this->{$setter}($object);
        }
    }

    /**
     * @param  array  $options  elementName=>class
     */
    protected function singleElementsFromXml(\DOMElement $node, DeserializationContext $context, array $options)
    {
        foreach ($options as $elementName => $info) {
            $this->oneElementFromXml($node, $context, $elementName, $info[1], $info[0]);
        }
    }

    protected function attributesFromXml(\DOMElement $node, array $attributeNames)
    {
        foreach ($attributeNames as $attributeName) {
            $this->singleAttributeFromXml($node, $attributeName);
        }
    }

    /**
     * @param  string  $name
     * @return mixed
     *
     * @throws \LogicException
     */
    private function getPropertyValue($name)
    {
        if (($pos = strpos($name, ':')) !== false) {
            $name = substr($name, $pos + 1);
        }
        $getter = 'get'.$name.'String';
        if (method_exists($this, $getter) == false) {
            $getter = 'get'.$name;
        }
        if (method_exists($this, $getter) == false) {
            throw new \LogicException(sprintf(
                "Unable to find getter method for '%s' on '%s'",
                $name,
                get_class($this)
            ));
        }
        $value = $this->{$getter}();

        return $value;
    }
}
