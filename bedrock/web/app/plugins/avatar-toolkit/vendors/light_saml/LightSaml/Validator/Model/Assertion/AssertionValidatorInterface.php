<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Validator\Model\Assertion;

use LightSaml\Model\Assertion\Assertion;

interface AssertionValidatorInterface
{
    /**
     * @return void
     *
     * @throws \LightSaml\Error\LightSamlValidationException
     */
    public function validateAssertion(Assertion $assertion);
}
