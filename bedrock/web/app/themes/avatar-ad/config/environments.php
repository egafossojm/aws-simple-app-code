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
    case 'qa-avatar.advisor.ca':
    case 'stg-avatar.advisor.ca':
    case 'uat-cumulus.advisor.ca':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.advisor.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'contact@tc.advisor.ca');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_ad_ambulletin' => 'Advisor AM Bulletin',
            'template_ad_midday' => 'Advisor Mid_Day Bulletin',
            'template_ad_pmbulletin' => 'Advisor PM Bulletin',
            'template_ad_breakingnews' => 'Advisor Special Edition',
            'template_ad_weekinreview' => 'Advisor Week In Review',
            'template_ad_bestofthemonth' => 'Advisor Best of the Month',
            'template_ad_togo' => 'Advisor To Go',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7980');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '20435');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'DO9Ed7gwEBIKeIdpYfLpHgvHH8KzOOB2');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_ad');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AMBULLETIN', '53926');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MIDDAY', '53927');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PMBULLETIN', '53928');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BREAKINGNEWS', '53929');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKINREVIEW', '53929');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BESTOFTHEMONTH', '53930');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_TOGO', '53925');

        // BE de DI: Contact-Group - «Send Test SODA»
        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206146');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/AD/SAML?language=en');
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

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'contact@tc.advisor.ca');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'contact@tc.advisor.ca');

        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_ad_ambulletin' => 'Advisor AM Bulletin',
            'template_ad_midday' => 'Advisor Mid_Day Bulletin',
            'template_ad_pmbulletin' => 'Advisor PM Bulletin',
            'template_ad_breakingnews' => 'Advisor Special Edition',
            'template_ad_weekinreview' => 'Advisor Week In Review',
            'template_ad_bestofthemonth' => 'Advisor Best of the Month',
            'template_ad_togo' => 'Advisor To Go',
        ]
        );

        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '7291');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '19960');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'j2DYdUMyyfvZNjliiAlhMuBhUyx0D212');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_ad');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AMBULLETIN', '51692');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MIDDAY', '51693');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PMBULLETIN', '51694');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BREAKINGNEWS', '51695');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKINREVIEW', '51695');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_BESTOFTHEMONTH', '51696');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_TOGO', '51691');
        // BE de DI: Contact-Group - «Send Test SODA»
        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '206144');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/AD/SAML?language=en');
        define('AVATAR_EQUISOFT_AUDIENCE', 'wealthelements.equisoft.com');
        define('AVATAR_EQUISOFT_ISSUER', 'http://www.transcontinental.com');
        define('AVATAR_EQUISOFT_CERT_CRT', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.crt');
        define('AVATAR_EQUISOFT_CERT_KEY', trailingslashit(get_stylesheet_directory()).'config/equisoft-cert/server.key');
        define('AVATAR_EQUISOFT_LAST_NAME', __('Last Name', 'avatar-ad'));
        define('AVATAR_EQUISOFT_FIRST_NAME', __('First Name', 'avatar-ad'));

        define('AVATAR_SUBSCRIPTION_MODULE', 'templates/general/component-subscribe-social.php');

        break;
}

switch ($http_host) {
    case 'localhost':
        define('AVATAR_CE_PLACE_URL', 'http://www.cecorner.ca/en/index.cfm');
        break;
    case 'qa-avatar.adivsor.ca':
        define('AVATAR_CE_PLACE_URL', 'http://www.cecorner.ca/en/index.cfm');
        break;
    case 'stg-avatar.advisor.ca':
        define('AVATAR_CE_PLACE_URL', 'http://www.cecorner.ca/en/index.cfm');
        break;
    default:
        //prod environment
        define('AVATAR_CE_PLACE_URL', 'http://www.cecorner.ca/en/index.cfm');
        break;
}
