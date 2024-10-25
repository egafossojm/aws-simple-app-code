<?php

if (! function_exists('avatarco_theme_enqueue_styles')) {
    function avatarco_theme_enqueue_styles()
    {
        wp_enqueue_style('avatar-tcm_parent', trailingslashit(get_template_directory_uri()).'style.css', ['avatar-vendors']);
    }
    add_action('wp_enqueue_scripts', 'avatarco_theme_enqueue_styles', 1);
}

function my_class_names($classes)
{
    // add 'class-name' to the $classes array
    $classes[] = 'advisor-website dark-nav';

    // return the $classes array
    return $classes;
}

//Now add test class to the filter
add_filter('body_class', 'my_class_names');

/* -------------------------------------------------------------
 * Fallback for old Passwords from FI site
 * ============================================================*/

if (! function_exists('avatarco_fallback_to_old_password')) {

    function avatarco_fallback_to_old_password($check, $password, $hash, $user_id)
    {

        $inputed_password_hash = wp_hash_password($password);
        if ($inputed_password_hash == $hash) {
            return $check;
        } else {
            $old_encoding = md5($password, true);
            if ($old_encoding == $hash) {
                error_log('reset');
                wp_set_password($password, $user_id);

                return true;
            }
        }

        return $check;
    }
    add_filter('check_password', 'avatarco_fallback_to_old_password', 10, 4);
}

/* -------------------------------------------------------------
 * Load JavaScript for DI
 * ============================================================*/

if (! function_exists('avatarco_include_js')) {
    function avatarco_include_js() {}
    add_action('wp_enqueue_scripts', 'avatarco_include_js');
}

/* -------------------------------------------------------------
 * Load CO environments config
 * ============================================================*/

if (! function_exists('avatarco_load_config')) {

    function avatarco_load_config()
    {
        include_once 'config/environments.php';

    }

    add_action('after_setup_theme', 'avatarco_load_config');
}

if (! function_exists('avatarco_initiate_files')) {

    function avatarco_initiate_files()
    {
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/open_x.php';
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/liveintent.php';
    }

}

add_action('after_setup_theme', 'avatarco_initiate_files');

/* -------------------------------------------------------------
 * Override default sub-category template for ToGo
 * ============================================================*/

function avatarad_togo_subcategory_template($template)
{

    $cat = get_queried_object();
    if ($cat->category_parent > 0) {

        $parent_category = get_the_category_by_ID($cat->category_parent);

        if ($parent_category == 'Gestionnaires en direct') {
            $template = locate_template('page-audio-subpage.php');
        }
    }

    return $template;
}

add_filter('category_template', 'avatarad_togo_subcategory_template');
