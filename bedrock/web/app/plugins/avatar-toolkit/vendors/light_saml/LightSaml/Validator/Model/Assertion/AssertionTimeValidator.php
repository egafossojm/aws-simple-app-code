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

use LightSaml\Error\LightSamlValidationException;
use LightSaml\Helper;
use LightSaml\Model\Assertion\Assertion;

class AssertionTimeValidator implements AssertionTimeValidatorInterface
{
    /**
     * @param  int  $now
     * @param  int  $allowedSecondsSkew
     * @return void
     *
     * @throws \LightSaml\Error\LightSamlValidationException
     */
    public function validateTimeRestrictions(Assertion $assertion, $now, $allowedSecondsSkew)
    {
        if ($allowedSecondsSkew < 0) {
            $allowedSecondsSkew = -1 * $allowedSecondsSkew;
        }

        $this->validateConditions($assertion, $now, $allowedSecondsSkew);
        $this->validateAuthnStatements($assertion, $now, $allowedSecondsSkew);
        $this->validateSubject($assertion, $now, $allowedSecondsSkew);
    }

    /**
     * @param  int  $now
     * @param  int  $allowedSecondsSkew
     */
    protected function validateConditions(Assertion $assertion, $now, $allowedSecondsSkew)
    {
        if ($assertion->getConditions() == false) {
            return;
        }

        if (Helper::validateNotBefore($assertion->getConditions()->getNotBeforeTimestamp(), $now, $allowedSecondsSkew) == false) {
            throw new LightSamlValidationException('Conditions.NotBefore must not be in the future');
        }

        if (Helper::validateNotOnOrAfter($assertion->getConditions()->getNotOnOrAfterTimestamp(), $now, $allowedSecondsSkew) == false) {
            throw new LightSamlValidationException('Conditions.NotOnOrAfter must not be in the past');
        }
    }

    /**
     * @param  int  $now
     * @param  int  $allowedSecondsSkew
     */
    protected function validateAuthnStatements(Assertion $assertion, $now, $allowedSecondsSkew)
    {
        if ($assertion->getAllAuthnStatements() == false) {
            return;
        }

        foreach ($assertion->getAllAuthnStatements() as $authnStatement) {
            if (Helper::validateNotOnOrAfter($authnStatement->getSessionNotOnOrAfterTimestamp(), $now, $allowedSecondsSkew) == false) {
                throw new LightSamlValidationException('AuthnStatement attribute SessionNotOnOrAfter MUST be in the future');
            }
            // TODO: Consider validating that authnStatement.AuthnInstant is in the past
        }
    }

    /**
     * @param  int  $now
     * @param  int  $allowedSecondsSkew
     */
    protected function validateSubject(Assertion $assertion, $now, $allowedSecondsSkew)
    {
        if ($assertion->getSubject() == false) {
            return;
        }

        foreach ($assertion->getSubject()->getAllSubjectConfirmations() as $subjectConfirmation) {
            if ($subjectConfirmation->getSubjectConfirmationData()) {
                if (Helper::validateNotBefore($subjectConfirmation->getSubjectConfirmationData()->getNotBeforeTimestamp(), $now, $allowedSecondsSkew) == false) {
                    throw new LightSamlValidationException('SubjectConfirmationData.NotBefore must not be in the future');
                }
                if (Helper::validateNotOnOrAfter($subjectConfirmation->getSubjectConfirmationData()->getNotOnOrAfterTimestamp(), $now, $allowedSecondsSkew) == false) {
                    throw new LightSamlValidationException('SubjectConfirmationData.NotOnOrAfter must not be in the past');
                }
            }
        }
    }
}
