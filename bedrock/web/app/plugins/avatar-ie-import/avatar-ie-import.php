<?php
/*
 * Plugin Name: Avatar Import 'Investment executive'
 * Plugin URI: https://tc.cc
 * Description: Avatar import from Liferay Feeds (using WP-All-Import Plugin)
 * Text Domain: avatar-import-ie
 * Domain Path: /languages
 * Version: 1.1.0
 * Author: Julien Noel, Valeriu Tihai
 * Contributors: noelja, valeriutihai
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
class AvatarIEImport
{
    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // Define constants
        add_action('plugins_loaded', [&$this, 'aii_define_constants'], 1);

        // Load language file
        add_action('plugins_loaded', [&$this, 'aii_load_textdomain'], 2);

        // Load settings
        add_action('plugins_loaded', [&$this, 'aii_settings'], 1);

        // Load file for Avatar Theme
        add_action('after_setup_theme', [&$this, 'aii_includes'], 3);
    }

    /**
     * Defines constants used by the plugin.
     *
     * @since 1.0.0
     */
    public function aii_define_constants()
    {
        /* Set constant URI */
        define('AVATAR_IMPORT_IE_URI', trailingslashit(plugin_dir_url(__FILE__)));

        /* Set constant path to the plugin directory. */
        define('AVATAR_IMPORT_IE', trailingslashit(plugin_dir_path(__FILE__)));
    }

    /**
     * Load language file
     *
     * This will load the MO file for the current locale.
     * The translation file must be named analytics-tracker-$locale.mo.
     *
     * @since 1.0.0
     */
    public function aii_load_textdomain()
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
    public function aii_settings() {}

    /**
     * Include all files for theme
     *
     * @since 1.0.0
     */
    public function aii_includes()
    {
        // Include function for vendors
        require_once AVATAR_IMPORT_IE.'vendors/wp-all-import/import-hooks.php';
    }
}

// Instantiate the main class
new AvatarIEImport;
