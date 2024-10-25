<?php
/* -------------------------------------------------------------
 * Theme setup
 * ============================================================*/
if (! function_exists('avatar_theme_setup')) {

    function avatar_theme_setup()
    {

        // This feature allows themes to add document title tag to HTML <head>
        add_theme_support('title-tag');

        // Add possibility to upload Featured image with this theme (and child)
        add_theme_support('post-thumbnails');

        update_option('thumbnail_size_w', 250);
        update_option('thumbnail_size_h', 0);

        update_option('medium_size_w', 750);
        update_option('medium_size_h', 0);
        update_option('medium_crop', 0);

        update_option('medium_large_size_w', 750);
        update_option('medium_large_size_h', 0);
        update_option('medium_large_crop', 0);

        update_option('large_size_w', 1200);
        update_option('large_size_h', 0);
        update_option('large_crop', 0);

        // This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption.
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);

        // Add Menu
        add_theme_support('menus');

        // Add RSS
        add_theme_support('automatic-feed-links');

        // Custom Logo
        add_theme_support('custom-logo');

        // Remove version info from head and feeds (dont want to help hackers) & clean header
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');

        // Remove the WordPress Emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');

    }

    add_action('after_setup_theme', 'avatar_theme_setup');
}

/* -------------------------------------------------------------
 * Hide Toolbar when viewing site for all users (except for admins)
 * ============================================================*/
if (! function_exists('avatar_hide_admin_bar')) {
    /**
     * @return bool
     */
    function avatar_hide_admin_bar()
    {

        return $bar = (! (current_user_can('webeditor') || current_user_can('supereditor') || current_user_can('salescoordinator') || current_user_can('administrator'))) ? false : true;

    }
    add_filter('show_admin_bar', 'avatar_hide_admin_bar');
}
