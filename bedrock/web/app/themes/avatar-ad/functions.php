<?php

if (! function_exists('avatarad_theme_enqueue_styles')) {
    function avatarad_theme_enqueue_styles()
    {
        wp_enqueue_style('avatar-tcm_parent', trailingslashit(get_template_directory_uri()).'style.css', ['avatar-vendors']);
    }
    add_action('wp_enqueue_scripts', 'avatarad_theme_enqueue_styles', 1);
}

function my_class_names($classes)
{
    // add 'class-name' to the $classes array
    $classes[] = 'advisor-website dark-nav adv-only';

    // return the $classes array
    return $classes;
}

//Now add test class to the filter
add_filter('body_class', 'my_class_names');

/* -------------------------------------------------------------
 * Fallback for old Passwords from AD site
 * ============================================================*/

if (! function_exists('avatarad_fallback_to_old_password')) {

    function avatarad_fallback_to_old_password($check, $password, $hash, $user_id)
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
    add_filter('check_password', 'avatarad_fallback_to_old_password', 10, 4);
}

/* -------------------------------------------------------------
 * Load JavaScript for DI
 * ============================================================*/

if (! function_exists('avatarad_include_js')) {
    function avatarad_include_js() {}
    add_action('wp_enqueue_scripts', 'avatarad_include_js');
}

/* -------------------------------------------------------------
 * Load AD environments config
 * ============================================================*/

if (! function_exists('avatarad_load_config')) {

    function avatarad_load_config()
    {
        include_once 'config/environments.php';

    }

    add_action('after_setup_theme', 'avatarad_load_config');
}

if (! function_exists('avatarad_initiate_files')) {

    function avatarad_initiate_files()
    {
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/open_x.php';
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/liveintent.php';

    }

}

add_action('after_setup_theme', 'avatarad_initiate_files');

/* -------------------------------------------------------------
 * Override default sub-category template for ToGo
 * ============================================================*/

function avatarad_togo_subcategory_template($template)
{

    $cat = get_queried_object();
    if ($cat->category_parent > 0) {

        $parent_category = get_the_category_by_ID($cat->category_parent);

        if ($parent_category == 'Advisor To Go') {
            $template = locate_template('page-audio-subpage.php');
        }
    }

    return $template;
}

add_filter('category_template', 'avatarad_togo_subcategory_template');
