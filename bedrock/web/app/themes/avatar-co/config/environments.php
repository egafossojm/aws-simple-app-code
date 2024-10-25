<?php

// Get the hostname
$http_host = $_SERVER['HTTP_HOST'];
define('SHOW_HOMEPAGE_VIDEO_WIDGET', true);
define('SHOW_HOMEPAGE_PODCAST_WIDGET', true);
define('SHOW_HOMEPAGE_RETIREMENT_WIDGET', true);
define('SHOW_HOMEPAGE_MICROSITE_WIDGET', true);
define('SHOW_HOMEPAGE_TOPSTORY_CLASSIC', false);
define('SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET', true);

define('NEWSLETTER_TYPE_ADS', 'liveintent');

switch ($http_host) {
    case 'localhost':
    case 'qa-avatar.conseiller.ca':
    case 'stg-avatar.conseiller.ca':
    case 'uat-cumulus.conseiller.ca':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.conseiller.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'contact@tc.conseiller.ca');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_co_ambulletin' => 'Conseiller.ca Vos nouvelles du matin',
            'template_co_pmbulletin' => 'Conseiller.ca Vos nouvelles du soir',
            'template_co_specialoffers' => 'Conseiller.ca Édition spéciale',
            'template_co_weekinreview' => 'Conseiller.ca Vos nouvelles préférées de la semaine',
            'template_co_endirect' => 'Conseiller.ca en direct',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7980');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '20435');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'DO9Ed7gwEBIKeIdpYfLpHgvHH8KzOOB2');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_co');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AMBULLETIN', '53939');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PMBULLETIN', '53940');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_SPECIALOFFERS', '53943');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKINREVIEW', '53941');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ENDIRECT', '53938');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206146');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/CO/SAML?language=fr');
        define('AVATAR_EQUISOFT_AUDIENCE', '03.uat.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://stg.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-subscribe-social.php');

        break;

    default:
        //prod environment
        $is_prod = true;

        //Dialog Insight PROD config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.conseiller.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'contact@tc.conseiller.ca');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_co_ambulletin' => 'Conseiller.ca Vos nouvelles du matin',
            'template_co_pmbulletin' => 'Conseiller.ca Vos nouvelles du soir',
            'template_co_specialoffers' => 'Conseiller.ca Édition spéciale',
            'template_co_weekinreview' => 'Conseiller.ca Vos nouvelles préférées de la semaine',
            'template_co_endirect' => 'Conseiller.ca en direct',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7291');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '19960');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'j2DYdUMyyfvZNjliiAlhMuBhUyx0D212');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_co');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AMBULLETIN', '51705');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PMBULLETIN', '51706');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_SPECIALOFFERS', '51709');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKINREVIEW', '51707');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ENDIRECT', '51704');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206144');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/CO/SAML?language=fr');
        define('AVATAR_EQUISOFT_AUDIENCE', 'wealthelements.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://www.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name', 'avatar-co'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name', 'avatar-co'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-subscribe-social.php');

        break;
}

switch ($http_host) {
    case 'localhost':
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
    case 'qa-avatar.conseiller.ca':
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
    case 'stg-avatar.conseiller.ca':
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
    default:
        //prod environment
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
}
