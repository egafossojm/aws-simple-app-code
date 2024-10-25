<?php

// Get the hostname
$http_host = $_SERVER['HTTP_HOST'];
define('SHOW_HOMEPAGE_VIDEO_WIDGET', true);
define('SHOW_HOMEPAGE_PODCAST_WIDGET', false);
define('SHOW_HOMEPAGE_RETIREMENT_WIDGET', false);
define('SHOW_HOMEPAGE_TOPSTORY_CLASSIC', true);
define('SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET', true);

define('NEWSLETTER_TYPE_ADS', 'liveintent');

switch ($http_host) {
    case 'localhost':
    case 'qa-avatar.finance-investissement.com':
    case 'stg-avatar.finance-investissement.com':
    case 'uat-cumulus.finance-investissement.com':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'bulletin@tc.finance-investissement.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'abonnement@finance-investissement.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_fi_quotidien' => 'Infolettre Finance et Investissement',
            'template_fi_specialefnb' => 'Infolettre Spéciale FNB',
            'template_fi_hebdo' => 'Infolettre Hebdomadaire Finance et Investissement',
            'template_fi_mensuel' => 'Infolettre Mensuelle Finance et Investissement',
            'template_fi_fireleve' => 'Finance et Investissement – FI Relève',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '6783');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '16581');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'PO53ruXSup3edh3sYNVMk8sWNgLLZEM4');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_fi');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ALERTES', '47931');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_FIRELEVE', '47934');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_SPECIALEFNB', '53484');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_HEBDO', '47930');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_QUOTIDIEN', '47929');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MENSUEL', '47930');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PARTENAIRES', '47933');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_TRANSCONTINENTAL', '48766');

        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '182159');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/IE/SAML?language=fr');
        define('AVATAR_EQUISOFT_AUDIENCE', '03.uat.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://stg.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/homepage/component-quick-subscribe-newsletters.php');

        break;

    default:
        //prod environment
        $is_prod = true;

        //Dialog Insight PROD config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'bulletin@tc.finance-investissement.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'abonnement@finance-investissement.com');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_fi_quotidien' => 'Infolettre Finance et Investissement',
            'template_fi_specialefnb' => 'Infolettre Spéciale FNB',
            'template_fi_hebdo' => 'Infolettre Hebdomadaire Finance et Investissement',
            'template_fi_mensuel' => 'Infolettre Mensuelle Finance et Investissement',
            'template_fi_fireleve' => 'Finance et Investissement – FI Relève',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '6782');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '16779');
        define('AVATAR_DIALOG_INSIGHT_KEY', '7qZbHG9iTmIAFtNCCNVZGzRU3r7YhImM');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_fi');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ALERTES', '47923');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_FIRELEVE', '47926');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_SPECIALEFNB', '53574');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_HEBDO', '47922');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_QUOTIDIEN', '47921');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MENSUEL', '47922');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PARTENAIRES', '47925');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_TRANSCONTINENTAL', '48767');
        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '182207');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/IE/SAML?language=fr');
        define('AVATAR_EQUISOFT_AUDIENCE', 'wealthelements.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://www.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name', 'avatar-ie'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name', 'avatar-ie'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/homepage/component-quick-subscribe-newsletters.php');

        break;
}
switch ($http_host) {
    case 'localhost':
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;

    case 'uat-cumulus.finance-investissement.com':
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
    default:
        //prod environment
        define('AVATAR_CE_PLACE_URL', 'http://www.carnetfc.ca/');
        break;
}
