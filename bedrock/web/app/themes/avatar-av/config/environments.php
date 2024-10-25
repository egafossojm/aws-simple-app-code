<?php

// Get the hostname
$http_host = $_SERVER['HTTP_HOST'];
define('SHOW_HOMEPAGE_VIDEO_WIDGET', true);
define('SHOW_HOMEPAGE_PODCAST_WIDGET', false);
define('SHOW_HOMEPAGE_RETIREMENT_WIDGET', false);
define('SHOW_HOMEPAGE_TOPSTORY_CLASSIC', false);
define('SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET', true);

define('NEWSLETTER_TYPE_ADS', 'liveintent');

switch ($http_host) {
    case 'localhost':
    case 'qa-avatar.avantages.ca':
    case 'stg-avatar.avantages.ca':
    case 'uat-cumulus.avantages.ca':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.avantages.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'etcmcontact.ca@kckglobal.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_av_vosnouvellesdumardi' => 'Avantages - Vos nouvelles',
            'template_av_vosnouvellesdujeudi' => 'Avantages - Vos nouvelles',
            'template_av_vosnouvellesprefereesdumois' => 'Avantages - Vos nouvelles préférées du mois',
            'template_av_editionspeciale' => 'Avantages - Édition spéciale',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7980');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '20435');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'DO9Ed7gwEBIKeIdpYfLpHgvHH8KzOOB2');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_av');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESDUMARDI', '53958');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESDUJEUDI', '53958');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESPREFEREESDUMOIS', '53959');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_EDITIONSPECIALE', '53960');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206146');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/AV/SAML?language=fr');
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

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.avantages.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'etcmcontact.ca@kckglobal.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_av_vosnouvellesdumardi' => 'Avantages - Vos nouvelles',
            'template_av_vosnouvellesdujeudi' => 'Avantages - Vos nouvelles',
            'template_av_vosnouvellesprefereesdumois' => 'Avantages - Vos nouvelles préférées du mois',
            'template_av_editionspeciale' => 'Avantages - Édition spéciale',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7291');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '19960');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'j2DYdUMyyfvZNjliiAlhMuBhUyx0D212');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_co');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESDUMARDI', '51724');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESDUJEUDI', '51724');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_VOSNOUVELLESPREFEREESDUMOIS', '51725');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_EDITIONSPECIALE', '51726');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206144');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/AV/SAML?language=fr');
        define('AVATAR_EQUISOFT_AUDIENCE', 'wealthelements.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://www.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name', 'avatar-av'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name', 'avatar-av'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-subscribe-social.php');

        break;
}

switch ($http_host) {
    case 'localhost':
        define('AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com');
        break;
    case 'qa-avatar.avantages.ca':
        define('AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com');
        break;
    case 'stg-avatar.avantages.ca':
        define('AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com');
        break;
    default:
        //prod environment
        define('AVATAR_CE_PLACE_URL', 'https://www.espaceformationcontinue.com');
        break;
}
