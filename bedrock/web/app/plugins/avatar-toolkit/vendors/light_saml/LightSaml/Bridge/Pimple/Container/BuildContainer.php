<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Bridge\Pimple\Container;

use LightSaml\Build\Container\BuildContainerInterface;
use LightSaml\Build\Container\CredentialContainerInterface;
use LightSaml\Build\Container\OwnContainerInterface;
use LightSaml\Build\Container\PartyContainerInterface;
use LightSaml\Build\Container\ProviderContainerInterface;
use LightSaml\Build\Container\ServiceContainerInterface;
use LightSaml\Build\Container\StoreContainerInterface;
use LightSaml\Build\Container\SystemContainerInterface;

class BuildContainer extends AbstractPimpleContainer implements BuildContainerInterface
{
    /** @var SystemContainerInterface */
    private $systemContainer;

    /** @var PartyContainerInterface */
    private $partyContainer;

    /** @var StoreContainerInterface */
    private $storeContainer;

    /** @var ProviderContainerInterface */
    private $providerContainer;

    /** @var CredentialContainerInterface */
    private $credentialContainer;

    /** @var ServiceContainerInterface */
    private $serviceContainer;

    /** @var OwnContainerInterface */
    private $ownContainer;

    /**
     * @return SystemContainerInterface
     */
    public function getSystemContainer()
    {
        if ($this->systemContainer == null) {
            $this->systemContainer = new SystemContainer($this->pimple);
        }

        return $this->systemContainer;
    }

    /**
     * @return PartyContainerInterface
     */
    public function getPartyContainer()
    {
        if ($this->partyContainer == null) {
            $this->partyContainer = new PartyContainer($this->pimple);
        }

        return $this->partyContainer;
    }

    /**
     * @return StoreContainerInterface
     */
    public function getStoreContainer()
    {
        if ($this->storeContainer == null) {
            $this->storeContainer = new StoreContainer($this->pimple);
        }

        return $this->storeContainer;
    }

    /**
     * @return ProviderContainerInterface
     */
    public function getProviderContainer()
    {
        if ($this->providerContainer == null) {
            $this->providerContainer = new ProviderContainer($this->pimple);
        }

        return $this->providerContainer;
    }

    /**
     * @return CredentialContainerInterface
     */
    public function getCredentialContainer()
    {
        if ($this->credentialContainer == null) {
            $this->credentialContainer = new CredentialContainer($this->pimple);
        }

        return $this->credentialContainer;
    }

    /**
     * @return ServiceContainerInterface
     */
    public function getServiceContainer()
    {
        if ($this->serviceContainer == null) {
            $this->serviceContainer = new ServiceContainer($this->pimple);
        }

        return $this->serviceContainer;
    }

    /**
     * @return OwnContainerInterface
     */
    public function getOwnContainer()
    {
        if ($this->ownContainer == null) {
            $this->ownContainer = new OwnContainer($this->pimple);
        }

        return $this->ownContainer;
    }
}
