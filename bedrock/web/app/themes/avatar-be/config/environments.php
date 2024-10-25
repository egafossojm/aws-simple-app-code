<?php

// Get the hostname
$http_host = $_SERVER['HTTP_HOST'];
define('SHOW_HOMEPAGE_VIDEO_WIDGET', false);
define('SHOW_HOMEPAGE_PODCAST_WIDGET', false);
define('SHOW_HOMEPAGE_RETIREMENT_WIDGET', false);
define('SHOW_HOMEPAGE_TOPSTORY_CLASSIC', false);
define('SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET', true);

define('NEWSLETTER_TYPE_ADS', 'liveintent');

switch ($http_host) {
    case 'localhost':
    case 'qa-avatar.benefitscanada.com':
    case 'stg-avatar.benefitscanada.com':
    case 'uat-cumulus.benefitscanada.com':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.benefitscanada.com');
        define('CIR_AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.investmentreview.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'etcmcontact.ca@kckglobal.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_beca_beca-newsletter' => 'Benefits Canada Daily Newsletters',
            'template_beca_beca-3rd-party-sponsored' => 'Benefits Canada Partners',
            'template_beca_beca-events' => 'Benefits Canada Conference Alerts',
            'template_beca_beca-special-offers' => 'Benefits Canada Offers',
            'template_cir_cir-newsletter' => 'Canadian Investment Review News Update',
            'template_cir_cir-3rd-party_sponsored' => 'Canadian Investment Review Partners',
            'template_cir_cir-events' => 'Canadian Investment Review  Conference Alerts',
            'template_cir_cir-special-offers' => 'Canadian Investment Review Offers',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7980');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '20435');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'DO9Ed7gwEBIKeIdpYfLpHgvHH8KzOOB2');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_be');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-NEWSLETTER', '53949');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-3RD-PARTY-SPONSORED', '54852');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-EVENTS', '54853');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-FREE-CONTENT', '54856');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-RESEARCH', '54854');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-SPECIAL-OFFERS', '54855');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-CONF-HIGHLIGHTS', '54850');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-NEWSLETTER', '53975');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-3RD-PARTY-SPONSORED', '53976');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-EVENTS', '53977');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-FREE-CONTENT', '53980');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-RESEARCH', '53977');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-SPECIAL-OFFERS', '53979');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206146');

        // EquiSoft config
        // define( 'AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/AV/SAML?language=fr' );
        // define( 'AVATAR_EQUISOFT_AUDIENCE', '03.uat.equisoft.com' );
        // define( 'AVATAR_EQUISOFT_ISSUER', 'http://stg.transcontinental.com' );
        // define( 'AVATAR_EQUISOFT_CERT_CRT', trailingslashit( get_stylesheet_directory() ) . 'config/equisoft-cert/server.crt' );
        // define( 'AVATAR_EQUISOFT_CERT_KEY', trailingslashit( get_stylesheet_directory() ) . 'config/equisoft-cert/server.key' );
        // define( 'AVATAR_EQUISOFT_LAST_NAME', __( 'Last Name' ) );
        // define( 'AVATAR_EQUISOFT_FIRST_NAME', __( 'First Name' ) );

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-quick-subscribe-newsletters-and-social.php');

        break;

    default:
        //prod environment
        $is_prod = true;

        //Dialog Insight PROD config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.benefitscanada.com');
        define('CIR_AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.investmentreview.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'etcmcontact.ca@kckglobal.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_beca_beca-newsletter' => 'Benefits Canada Daily Newsletters',
            'template_beca_beca-3rd-party-sponsored' => 'Benefits Canada Partners',
            'template_beca_beca-events' => 'Benefits Canada Conference Alerts',
            'template_beca_beca-special-offers' => 'Benefits Canada Offers',
            'template_cir_cir-newsletter' => 'Canadian Investment Review News Update',
            'template_cir_cir-3rd-party_sponsored' => 'Canadian Investment Review Partners',
            'template_cir_cir-events' => 'Canadian Investment Review  Conference Alerts',
            'template_cir_cir-special-offers' => 'Canadian Investment Review Offers',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7291');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '19960');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'j2DYdUMyyfvZNjliiAlhMuBhUyx0D212');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_be');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-NEWSLETTER', '58587');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-3RD-PARTY-SPONSORED', '58627');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-EVENTS', '58588');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-FREE-CONTENT', '58589');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-RESEARCH', '58594');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-SPECIAL-OFFERS', '58595');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BECA-CONF-HIGHLIGHTS', '58628');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-NEWSLETTER', '58718');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-3RD-PARTY-SPONSORED', '58629');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-EVENTS', '58712');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-FREE-CONTENT', '58593');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-RESEARCH', '58594');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_CIR-SPECIAL-OFFERS', '58595');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '280604');

        // 			// EquiSoft config
        // 			define( 'AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/AV/SAML?language=fr' );
        // 			define( 'AVATAR_EQUISOFT_AUDIENCE', 'wealthelements.equisoft.com' );
        // 			define( 'AVATAR_EQUISOFT_ISSUER', 'http://www.transcontinental.com' );
        // 			define( 'AVATAR_EQUISOFT_CERT_CRT', trailingslashit( get_stylesheet_directory() ) . 'config/equisoft-cert/server.crt' );
        // 			define( 'AVATAR_EQUISOFT_CERT_KEY', trailingslashit( get_stylesheet_directory() ) . 'config/equisoft-cert/server.key' );
        // 			define( 'AVATAR_EQUISOFT_LAST_NAME', __( 'Last Name', 'avatar-av' ) );
        // 			define( 'AVATAR_EQUISOFT_FIRST_NAME', __( 'First Name', 'avatar-av' ) );

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-quick-subscribe-newsletters-and-social.php');

        break;
}

// switch ( $http_host ) {
// 	case 'localhost':
// 		define( 'AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com' );
// 		break;
// 	case 'qa-avatar.benefitscanada.com':
// 		define( 'AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com' );
// 		break;
// 	case 'stg-avatar.benefitscanada.com':
// 		define( 'AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com' );
// 		break;
// 	default:
// 		//prod environment
// 		define( 'AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com' );
// 		break;
// }
