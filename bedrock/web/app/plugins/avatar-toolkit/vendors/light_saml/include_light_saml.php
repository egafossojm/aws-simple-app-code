<?php
/**
 * Created by IntelliJ IDEA.
 * User: jutrasj
 * Date: 17-11-14
 * Time: 9:04 AM
 */

require_once dirname(__FILE__).'/robrichards/xmlseclibs/src/XMLSecEnc.php';
require_once dirname(__FILE__).'/robrichards/xmlseclibs/src/XMLSecurityDSig.php';
require_once dirname(__FILE__).'/robrichards/xmlseclibs/src/XMLSecurityKey.php';
require_once dirname(__FILE__).'/LightSaml/SamlConstants.php';
require_once dirname(__FILE__).'/LightSaml/Helper.php';
require_once dirname(__FILE__).'/MyDateTime.php';
require_once dirname(__FILE__).'/LightSaml/ClaimTypes.php';

require_once dirname(__FILE__).'/LightSaml/Model/SamlElementInterface.php';
require_once dirname(__FILE__).'/LightSaml/Model/AbstractSamlModel.php';
require_once dirname(__FILE__).'/LightSaml/Model/Context/SerializationContext.php';
require_once dirname(__FILE__).'/LightSaml/Model/SamlElementInterface.php';
require_once dirname(__FILE__).'/LightSaml/Model/XmlDSig/Signature.php';
require_once dirname(__FILE__).'/LightSaml/Model/XmlDSig/SignatureWriter.php';

require_once dirname(__FILE__).'/LightSaml/Model/Protocol/SamlMessage.php';
require_once dirname(__FILE__).'/LightSaml/Model/Protocol/StatusResponse.php';
require_once dirname(__FILE__).'/LightSaml/Model/Protocol/Response.php';

require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AbstractStatement.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AttributeStatement.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/Assertion.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/Subject.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/Conditions.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AuthnStatement.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AuthnContext.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/SubjectConfirmation.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/SubjectConfirmationData.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AbstractNameID.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/Issuer.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/NameID.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AbstractCondition.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/AudienceRestriction.php';
require_once dirname(__FILE__).'/LightSaml/Model/Assertion/Attribute.php';

require_once dirname(__FILE__).'/LightSaml/Error/LightSamlException.php';
require_once dirname(__FILE__).'/LightSaml/Error/LightSamlModelException.php';
require_once dirname(__FILE__).'/LightSaml/Error/LightSamlSecurityException.php';
require_once dirname(__FILE__).'/LightSaml/Error/LightSamlXmlException.php';

require_once dirname(__FILE__).'/LightSaml/Credential/KeyHelper.php';
require_once dirname(__FILE__).'/LightSaml/Credential/X509Certificate.php';
