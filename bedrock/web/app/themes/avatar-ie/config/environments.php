<?php

// Get the hostname
$http_host = $_SERVER['HTTP_HOST'];
define('SHOW_HOMEPAGE_VIDEO_WIDGET', false);
define('SHOW_HOMEPAGE_PODCAST_WIDGET', false);
define('SHOW_HOMEPAGE_RETIREMENT_WIDGET', false);
define('SHOW_HOMEPAGE_TOPSTORY_CLASSIC', true);
define('SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET', true);

define('NEWSLETTER_TYPE_ADS', 'liveintent');

switch ($http_host) {
    case 'localhost':
    case 'qa-avatar.investmentexecutive.com':
    case 'stg-avatar.investmentexecutive.com':
    case 'uat-cumulus.investmentexecutive.com':
        $is_prod = false;

        //Dialog Insight Sandbox config

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'newsletter@tc.investmentexecutive.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'subs@investmentexecutive.com');
        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_ie_am' => 'Investment Executive Newsletter AM',
            'template_ie_pm' => 'Investment Executive Newsletter PM',
            'template_ie_weekly' => 'Investment Executive Weekly Newsletter and Alerts',
            'template_ie_monthly' => 'Investment Executive Newsletter Monthly',
            'template_ie_etf' => 'Investment Executive ETF Newsletter']
        );
        //
        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '6769');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '16580');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'P2i7nUU06FWrCQhj4cC6RugdzVW4eLHN');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_ie');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AM', '47834');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PM', '47835');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKLY', '47840');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PARTNERS', '47838');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_OFFERS', '47836');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MONTHLY', '52642');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ETF', '54064');
        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '173952');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://03.uat.equisoft.com/WealthElements/release/IE/SAML');
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

        define('AVATAR_DIALOG_INSIGHT_SENDER_EMAIL', 'newsletter@tc.investmentexecutive.com');
        define('AVATAR_DIALOG_INSIGHT_REPLY_TO_EMAIL', 'subs@investmentexecutive.com');
        define('AVATAR_DIALOG_INSIGHT_SENDER_NAME', [
            'template_ie_am' => 'Investment Executive Newsletter AM',
            'template_ie_pm' => 'Investment Executive Newsletter PM',
            'template_ie_weekly' => 'Investment Executive Weekly Newsletter and Alerts',
            'template_ie_monthly' => 'Investment Executive Newsletter Monthly',
            'template_ie_etf' => 'Investment Executive ETF Newsletter']
        );
        //
        define('AVATAR_DIALOG_INSIGHT_PROJECT_ID', '6768');
        define('AVATAR_DIALOG_INSIGHT_KEY_ID', '16580');
        define('AVATAR_DIALOG_INSIGHT_KEY', 'P2i7nUU06FWrCQhj4cC6RugdzVW4eLHN');

        // key used in our database In DataBase
        define('AVATAR_DIALOG_INSIGHT_BD_ID', 'acf_dialoginsight_id_ie');

        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_AM', '47827');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PM', '47828');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_WEEKLY', '47833');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_PARTNERS', '47831');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_OFFERS', '47829');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_MONTHLY', '53077');
        define('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_ETF', '53905');
        define('AVATAR_DIALOG_INSIGHT_TEST_FILTER', '181893');

        // EquiSoft config
        define('AVATAR_EQUISOFT_DESTINATION', 'https://wealthelements.equisoft.com/app/IE/SAML?language=en');
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
        define('AVATAR_CE_PLACE_URL', 'http://qa-ceplace.investmentexecutive.com/ce-place');
        break;
    case 'qa-avatar.investmentexecutive.com':
        define('AVATAR_CE_PLACE_URL', 'http://qa-ceplace.investmentexecutive.com/ce-place');
        break;
    case 'stg-avatar.investmentexecutive.com':
        define('AVATAR_CE_PLACE_URL', 'http://stg-ceplace.investmentexecutive.com/ce-place');
        break;
    default:
        //prod environment
        define('AVATAR_CE_PLACE_URL', 'https://ceplace.investmentexecutive.com/ce-place');
        break;
}
