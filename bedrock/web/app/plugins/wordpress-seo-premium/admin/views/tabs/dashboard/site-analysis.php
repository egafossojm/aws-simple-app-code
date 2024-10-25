<?php
/**
 * WPSEO plugin file.
 *
 *
 * @uses Yoast_Form $yform Form object.
 */
if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

/**
 * Fires when displaying the site wide analysis tab.
 *
 * @param  Yoast_Form  $yform  The yoast form object.
 */
do_action('wpseo_settings_tab_site_analysis', $yform);
