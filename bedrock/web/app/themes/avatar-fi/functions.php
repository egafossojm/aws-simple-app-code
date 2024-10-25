<?php

if (! function_exists('avatarfi_theme_enqueue_styles')) {
    function avatarfi_theme_enqueue_styles()
    {
        wp_enqueue_style('avatar-tcm_parent', trailingslashit(get_template_directory_uri()).'style.css', ['avatar-vendors']);
    }
    add_action('wp_enqueue_scripts', 'avatarfi_theme_enqueue_styles', 1);
}

/*function my_class_names($classes) {
    // add 'class-name' to the $classes array
    $classes[] = 'advisor-website';
    // return the $classes array
    return $classes;
}

//Now add test class to the filter
add_filter('body_class','my_class_names');*/

/* -------------------------------------------------------------
 * Fallback for old Passwords from FI site
 * ============================================================*/

if (! function_exists('avatarfi_fallback_to_old_password')) {

    function avatarfi_fallback_to_old_password($check, $password, $hash, $user_id)
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
    add_filter('check_password', 'avatarfi_fallback_to_old_password', 10, 4);
}

/* -------------------------------------------------------------
 * Load JavaScript for DI
 * ============================================================*/

if (! function_exists('avatarfi_include_js')) {
    function avatarfi_include_js()
    {

        wp_enqueue_script('avatar-ofsys', 'https://t.ofsys.com/js/Journey/1/pwMAAHEzY1Q5aX4aAAB2QklPMm6EAQAA/DI.Journey-min.js', ['avatar-main'], '', 'footer');

    }
    add_action('wp_enqueue_scripts', 'avatarfi_include_js');
}

/* -------------------------------------------------------------
 * Load FI environments config
 * ============================================================*/

if (! function_exists('avatarie_load_config')) {

    function avatarfi_load_config()
    {
        include_once 'config/environments.php';

    }

    add_action('after_setup_theme', 'avatarfi_load_config');
}

if (! function_exists('avatarie_initiate_files')) {

    function avatarie_initiate_files()
    {
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/open_x.php';
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/liveintent.php';
    }

}

add_action('after_setup_theme', 'avatarie_initiate_files');
