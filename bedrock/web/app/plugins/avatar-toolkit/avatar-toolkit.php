<?php
/*
 * Plugin Name: Avatar Toolkit
 * Plugin URI: https://tc.cc
 * Description: Avatar main plugin for Avatar WordPress theme
 * Text Domain: avatar-toolkit
 * Domain Path: /languages
 * Version: 1.1.0
 * Author: Valeriu Tihai
 * Contributors: valeriutihai
 */
defined('ABSPATH') or exit('Plugin file cannot be accessed directly.');
// No direct access
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Main Class - Avatar Plugin
 *
 * @since 1.0.0
 */
class AvatarToolkit
{
    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        // Define constants
        add_action('plugins_loaded', [&$this, 'at_define_constants'], 1);

        // Load language file
        add_action('plugins_loaded', [&$this, 'at_load_textdomain'], 2);

        // Load settings
        add_action('plugins_loaded', [&$this, 'at_settings'], 1);

        // Load file for Avatar Theme
        add_action('after_setup_theme', [&$this, 'at_includes'], 3);

    }

    /**
     * Defines constants used by the plugin.
     *
     * @since 1.0.0
     */
    public function at_define_constants()
    {

        /* Set constant URI */
        define('AVATK_URI', trailingslashit(plugin_dir_url(__FILE__)));
        //define( 'AVATK_URI', WPMU_PLUGIN_URL . '/avatar-main/' );

        /* Set constant path to the plugin directory. */
        define('AVATK_DIR', trailingslashit(plugin_dir_path(__FILE__)));
    }

    /**
     * Load language file
     *
     * This will load the MO file for the current locale.
     * The translation file must be named analytics-tracker-$locale.mo.
     *
     * @since 1.0.0
     */
    public function at_load_textdomain()
    {
        load_plugin_textdomain('avatar-main', false, dirname(plugin_basename(__FILE__)).'/languages/');
    }

    /**
     * Settings
     *
     * @return array with all settings
     *
     * @since 1.0.0
     */
    public function at_settings() {}

    /**
     * Include all files for theme
     *
     * @since 1.0.0
     */
    public function at_includes()
    {

        // Include cXense meta tags
        include_once AVATK_DIR.'vendors/cxense/cxense-head-hooks.php';
        include_once AVATK_DIR.'vendors/cxense/cxense-most-popular.php';
        include_once AVATK_DIR.'vendors/cxense/cxense-most-shared.php';

        // Ads
        include_once AVATK_DIR.'ads/ads-m32.php';
        include_once AVATK_DIR.'ads/ads-m32-cir.php';
        include_once AVATK_DIR.'ads/adstxt.php';

        // Include Custom Post Types
        require_once AVATK_DIR.'custom-post-type/authors.php';
        require_once AVATK_DIR.'custom-post-type/slideshow.php';
        require_once AVATK_DIR.'custom-post-type/brands.php';
        require_once AVATK_DIR.'custom-post-type/features.php';
        require_once AVATK_DIR.'custom-post-type/partners.php';
        require_once AVATK_DIR.'custom-post-type/newsletters.php';
        require_once AVATK_DIR.'custom-post-type/microsites.php';
        require_once AVATK_DIR.'custom-post-type/newspapers.php';

        // Include Custom Taxonomy for posts
        require_once AVATK_DIR.'post/post-taxonomy.php';

        // Include Custom Style for Visual Editor
        require_once AVATK_DIR.'visual-editor/mce_read_also.php';

        // Include function for vendors
        require_once AVATK_DIR.'vendors/acf/acf.php';

        // Dialog Insight
        require_once AVATK_DIR.'vendors/dialog-insight/DialogInsight.php';
        require_once AVATK_DIR.'vendors/dialog-insight/DIProfile.php';
        require_once AVATK_DIR.'vendors/dialog-insight/functions.php';

        // Cedrom (import xml files)
        require_once AVATK_DIR.'vendors/cedrom/cedrom-ftp-xml.php';

        // Auth Equisoft
        // require_once AVATK_DIR.'vendors/light_saml/include_light_saml.php';

        // HTML Purifier
        // require_once AVATK_DIR.'../libraries/HTMLPurifier.standalone.php';

    }
}

// Instantiate the main class
new AvatarToolkit;
