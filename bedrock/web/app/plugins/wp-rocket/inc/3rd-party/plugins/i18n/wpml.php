<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

if (defined('ICL_SITEPRESS_VERSION') && ICL_SITEPRESS_VERSION) {
    /**
     * Conflict with WPML: Clear the homepage when the "Use directory for default language" option is activated.
     *
     * @since 2.6.8
     */
    function rocket_clean_directory_for_default_language_on_wpml()
    {
        $option = get_option('icl_sitepress_settings');

        if ($option['language_negotiation_type'] === 1 && $option['urls']['directory_for_default_language']) {
            rocket_clean_files(home_url());
        }
    }
    add_action('after_rocket_clean_domain', 'rocket_clean_directory_for_default_language_on_wpml');
}
