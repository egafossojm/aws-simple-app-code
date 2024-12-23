<?php
/*
 * Plugin Name: Avatar Import 'Conseiller'
 * Plugin URI: https://tc.cc
 * Description: Avatar import from WCM Feeds (using WP-All-Import Plugin)
 * Text Domain: avatar-co-import
 * Domain Path: /languages
 * Version: 1.0.0

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
class AvatarCOImport
{
    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // Define constants
        add_action('plugins_loaded', [&$this, 'aco_define_constants'], 1);

        // Load language file
        add_action('plugins_loaded', [&$this, 'aco_load_textdomain'], 2);

        // Load settings
        add_action('plugins_loaded', [&$this, 'aco_settings'], 1);

        // Load file for Avatar Theme
        add_action('after_setup_theme', [&$this, 'aco_includes'], 3);
    }

    /**
     * Defines constants used by the plugin.
     *
     * @since 1.0.0
     */
    public function aco_define_constants()
    {
        /* Set constant URI */
        define('AVATAR_IMPORT_CO_URI', trailingslashit(plugin_dir_url(__FILE__)));

        /* Set constant path to the plugin directory. */
        define('AVATAR_IMPORT_CO', trailingslashit(plugin_dir_path(__FILE__)));
    }

    /**
     * Load language file
     *
     * This will load the MO file for the current locale.
     * The translation file must be named analytics-tracker-$locale.mo.
     *
     * @since 1.0.0
     */
    public function aco_load_textdomain()
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
    public function aco_settings() {}

    /**
     * Include all files for theme
     *
     * @since 1.0.0
     */
    public function aco_includes()
    {
        // Include function for vendors
        require_once AVATAR_IMPORT_CO.'vendors/wp-all-import/import-hooks.php';
    }
}

// Instantiate the main class
new AvatarCOImport;
