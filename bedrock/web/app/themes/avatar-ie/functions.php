<?php

if (! function_exists('avatarie_theme_enqueue_styles')) {
    function avatarie_theme_enqueue_styles()
    {
        wp_enqueue_style('avatar-tcm_parent', trailingslashit(get_template_directory_uri()).'style.css', ['avatar-vendors']);
    }
    add_action('wp_enqueue_scripts', 'avatarie_theme_enqueue_styles', 1);
}

function my_class_names($classes)
{
    // add 'class-name' to the $classes array
    $classes[] = 'ie-website';

    // return the $classes array
    return $classes;
}

//Now add test class to the filter
add_filter('body_class', 'my_class_names');

/* -------------------------------------------------------------
 * Load environments config
 * ============================================================*/

if (! function_exists('avatarie_load_config')) {

    function avatarie_load_config()
    {
        include_once 'config/environments.php';

    }

    add_action('after_setup_theme', 'avatarie_load_config');
}

/* -------------------------------------------------------------
 * Load JavaScript for DI
 * ============================================================*/

if (! function_exists('avatarie_include_js')) {
    function avatarie_include_js()
    {

        wp_enqueue_script('avatar-ofsys', 'https://t.ofsys.com/js/Journey/1/owMAAGhVRGZ5VnAaAABLcWdTeGOGAQAA/DI.Journey-min.js', ['avatar-main'], '', 'footer');

    }
    add_action('wp_enqueue_scripts', 'avatarie_include_js');
}

/* -------------------------------------------------------------
 * Fallback for old Passwords from IE site
 * ============================================================*/

if (! function_exists('avatarie_fallback_to_old_password')) {

    function avatarie_fallback_to_old_password($check, $password, $hash, $user_id)
    {

        $inputed_password_hash = wp_hash_password($password);
        if ($inputed_password_hash == $hash) {
            return $check;
        } else {
            $old_encoding = base64_encode(sha1($password, true));
            if ($old_encoding == $hash) {
                error_log('reset');
                wp_set_password($password, $user_id);

                return true;
            }
        }

        return $check;
    }
    add_filter('check_password', 'avatarie_fallback_to_old_password', 10, 4);
}

if (! function_exists('avatarie_initiate_files')) {

    function avatarie_initiate_files()
    {
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/open_x.php';
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/liveintent.php';
    }

}

add_action('after_setup_theme', 'avatarie_initiate_files');
