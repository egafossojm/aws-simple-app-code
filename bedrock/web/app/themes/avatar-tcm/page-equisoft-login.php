<?php
/**
 * Template Name: Advisor Central (EquiSoft)
 *
 * This is the template that displays Advisor Central
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php
if (is_user_logged_in()) {
    $avatar_user_obj = wp_get_current_user();

    if ($avatar_user_obj->ID != 0) {
        $avatar_fristname = $avatar_user_obj->user_firstname;
        $avatar_lastname = $avatar_user_obj->user_lastname;
        $avatar_equisoft_id = get_user_meta($avatar_user_obj->ID, 'acf_user_uid_advisor_central', true);

        if (! avatar_is_valid_uuid_v4($avatar_equisoft_id)) {
            $avatar_equisoft_id = add_user_meta($avatar_user_obj->ID, 'acf_user_uid_advisor_central', avatar_uuid_v4(), true);
        }
        //$avatar_equisoft_id = 'a577ec77-8591-47a9-b50a-81389a9f66ba';

        if (avatar_is_valid_uuid_v4($avatar_equisoft_id)) {
            if ((defined('AVATAR_EQUISOFT_DESTINATION') && AVATAR_EQUISOFT_DESTINATION) &&
                 (defined('AVATAR_EQUISOFT_AUDIENCE') && AVATAR_EQUISOFT_AUDIENCE) &&
                 (defined('AVATAR_EQUISOFT_ISSUER') && AVATAR_EQUISOFT_ISSUER) &&
                 (defined('AVATAR_EQUISOFT_CERT_CRT') && AVATAR_EQUISOFT_CERT_CRT) &&
                 (defined('AVATAR_EQUISOFT_CERT_KEY') && AVATAR_EQUISOFT_CERT_KEY) &&
                 (defined('AVATAR_EQUISOFT_LAST_NAME') && AVATAR_EQUISOFT_LAST_NAME) &&
                 (defined('AVATAR_EQUISOFT_FIRST_NAME') && AVATAR_EQUISOFT_FIRST_NAME)) {

                $certificate = \LightSaml\Credential\X509Certificate::fromFile(AVATAR_EQUISOFT_CERT_CRT);
                $privateKey = \LightSaml\Credential\KeyHelper::createPrivateKey(AVATAR_EQUISOFT_CERT_KEY, '', true);

                $response = new \LightSaml\Model\Protocol\Response;
                $response
                    ->addAssertion($assertion = new \LightSaml\Model\Assertion\Assertion)
                    ->setID(\LightSaml\Helper::generateID())
                    ->setIssueInstant(new \DateTime)
                    ->setDestination(AVATAR_EQUISOFT_DESTINATION);

                $assertionSubject = new \LightSaml\Model\Assertion\Subject;
                $assertionCondition = new \LightSaml\Model\Assertion\Conditions;
                $attributeStatement = new \LightSaml\Model\Assertion\AttributeStatement;
                $authStatement = new \LightSaml\Model\Assertion\AuthnStatement;
                $subjectConfirmation = new \LightSaml\Model\Assertion\SubjectConfirmation;
                $subjectConfirmationData = new \LightSaml\Model\Assertion\SubjectConfirmationData;
                $authContext = new \LightSaml\Model\Assertion\AuthnContext;
                $audienceArray = [AVATAR_EQUISOFT_AUDIENCE];

                $assertion
                    ->setId(\LightSaml\Helper::generateID())
                    ->setIssueInstant(new \DateTime)
                    ->setIssuer(new \LightSaml\Model\Assertion\Issuer(AVATAR_EQUISOFT_ISSUER))
                    ->setSubject(
                        $assertionSubject
                            ->setNameID(new \LightSaml\Model\Assertion\NameID($avatar_equisoft_id, \LightSaml\SamlConstants::NAME_ID_FORMAT_EMAIL))
                            ->addSubjectConfirmation(
                                $subjectConfirmation
                                    ->setMethod(\LightSaml\SamlConstants::CONFIRMATION_METHOD_BEARER)
                                    ->setSubjectConfirmationData(
                                        $subjectConfirmationData
                                            ->setNotOnOrAfter(new \DateTime('+3 MINUTE'))
                                    )
                            )
                    )
                    ->setConditions(
                        $assertionCondition
                            ->setNotBefore(new \DateTime)
                            ->setNotOnOrAfter(new \DateTime('+3 MINUTE'))
                            ->addItem(
                                new \LightSaml\Model\Assertion\AudienceRestriction($audienceArray)
                            )
                    )
                    ->addItem(
                        $attributeStatement
                            ->addAttribute(new \LightSaml\Model\Assertion\Attribute(AVATAR_EQUISOFT_FIRST_NAME, $avatar_fristname))
                            ->addAttribute(new \LightSaml\Model\Assertion\Attribute(AVATAR_EQUISOFT_LAST_NAME, $avatar_lastname))
                    )
                    ->addItem(
                        $authStatement
                            ->setAuthnInstant(new \DateTime('-10 MINUTE'))
                            ->setAuthnContext(
                                $authContext
                                    ->setAuthnContextClassRef(\LightSaml\SamlConstants::AUTHN_CONTEXT_PASSWORD_PROTECTED_TRANSPORT)
                            )
                    );

                $assertion->setSignature(new \LightSaml\Model\XmlDSig\SignatureWriter($certificate, $privateKey));
                $response->setSignature(new \LightSaml\Model\XmlDSig\SignatureWriter($certificate, $privateKey));

                $serializationContext = new \LightSaml\Model\Context\SerializationContext;
                $response->serialize($serializationContext->getDocument(), $serializationContext);

                $base64Response = base64_encode($serializationContext->getDocument()->saveXML());
            } else {
                error_log('EQUISOFT Constants are not defined');
            }
        } else {
            error_log('EQUISOFT uuid is not valid');
        }

    } else {
        error_log('Current_user ID = 0');
    }
} else {
    error_log('User is not logged');
}
?>
<?php if ($base64Response) { ?>
<!DOCTYPE html>
<html>
<head>
<script>
	window.onload = function() {
		document.getElementById('equisoft_auth').submit();
	};
</script>
</head>
<body>
<form id="equisoft_auth" action="<?php echo esc_url(AVATAR_EQUISOFT_DESTINATION) ?>/?language=en-US" method="POST">
	<input type="hidden" name="samlResponse" value="<?php echo esc_attr($base64Response); ?>">
</form>
</body>
</html>
<?php } else { ?>
	<?php _e('Cannot connect to EquiSoft, please try later again.', 'avatar-tcm'); ?>
<?php } ?>