<?php
/* -------------------------------------------------------------
 * Remove from menu "Edit Comments"
 * ============================================================*/
if (! function_exists('avatar_remove_menu')) {

    function avatar_remove_menu()
    {
        remove_menu_page('edit-comments.php');
    }

    add_action('admin_menu', 'avatar_remove_menu');
}

/* -------------------------------------------------------------
 * Create navigation menus.
 * ============================================================*/

if (! function_exists('avatar_register_menu')) {

    function avatar_register_menu()
    {
        register_nav_menus(
            [
                'header_main' => __('Header : Main navigation', 'avatar-tcm'),
                'header_user' => __('Header : User Log Off', 'avatar-tcm'),
                'header_user_in' => __('Header : User Log In', 'avatar-tcm'),
                'header_user_in_newspaper' => __('Header : User Log In, Newspaper', 'avatar-tcm'),
                'header_second' => __('Header : Second navigation', 'avatar-tcm'),
                'copyright' => __('Copyright', 'avatar-tcm'),
                'promotion_bar' => __('Header : Promotion menu', 'avatar-tcm'),
                'mobile' => __('Header : mobile', 'avatar-tcm'),
            ]
        );
    }
    add_action('init', 'avatar_register_menu');

}

/* -------------------------------------------------------------
 * Enable shortcodes in text widget for display the menu
 * ============================================================*/

if (! function_exists('avatar_print_menu_shortcode')) {

    function avatar_print_menu_shortcode($atts, $content = null)
    {
        extract(shortcode_atts(['name' => null, 'class' => null], $atts));

        return wp_nav_menu(['menu' => $name, 'menu_class' => $class, 'echo' => false]);
    }
    add_shortcode('menu', 'avatar_print_menu_shortcode');
    // Enable shortcodes in text widgets
    add_filter('widget_text', 'do_shortcode');

}

/* -------------------------------------------------------------
 * Adding CSS classes to nav menu
 * ============================================================*/

if (! function_exists('avatar_nav_class')) {
    function avatar_nav_class($classes, $item, $args)
    {

        $curr_nav_id = $item->object_id;
        $curr_id = $curr_parent_id = 0;

        // AVAIE-1889
        if (is_page_template('page-homepage.php')) {
            // add css class to item menu : homepage-template
            if (in_array('homepage-template', $item->classes)) {
                $classes[] = 'current-nav-parent mobile-open';
            }
        }

        if (is_category()) {
            // Get IDs for category

            $curr_cat_obj = get_category(get_query_var('cat'));
            $curr_id = $curr_cat_obj->cat_ID;
            $curr_parent_id = $curr_cat_obj->category_parent;
            // Bypass for Tools or sections with 'Page has parent' then 'subcategories
            if (avatar_get_page_by_cat($curr_parent_id)) {
                $curr_parent_id = avatar_get_page_by_cat($curr_parent_id);
            }

        } elseif (is_singular('page')) {
            // Get IDs page
            $curr_id = get_the_ID();
            // Fixes AVAIE-2291
            // Bypass for Tools or sections with 'Page has parent' then 'subcategories
            if (avatar_get_cat_by_page($curr_id)) {
                $curr_parent_id = wp_get_post_parent_id($curr_id);

            } else {
                //$curr_parent_id = wp_get_post_parent_id( $curr_id );
            }

        } elseif (is_singular('feature')) {
            // Get IDs for singular feature
            $curr_id = get_post_meta(get_the_ID(), 'acf_feature_parent_sub_category', true);
            $curr_parent_id = wp_get_post_parent_id($curr_id);

        } elseif (is_singular('writer')) {
            // Get IDs for singular author
            $author_origin = get_field('acf_columnist_site_source', get_the_ID());

            if (strcmp('CIR blog', $author_origin) === 0) {
                $page_obj = get_field('acf_inside_track_breadcrumb_cir', 'option');
            } else {
                $page_obj = get_field('acf_inside_track_breadcrumb', 'option');
            }

            $curr_id = $page_obj->ID;
            $curr_parent_id = wp_get_post_parent_id($curr_id);

        } elseif (is_singular('brand')) {
            // Get IDs for singular brand
            $page_obj = get_field('acf_brand_knowledge_page', 'option');
            $curr_id = $page_obj->ID;
            $curr_parent_id = wp_get_post_parent_id($curr_id);

        } elseif (is_singular('post')) {
            // Get IDs for singular post

            if (get_field('acf_article_type') == 'brand' && get_field('acf_article_brand')) {
                // Get IDs for singular post type brand

                $page_obj = get_field('acf_brand_knowledge_page', 'option');
                $curr_id = $page_obj->ID;
                $curr_parent_id = wp_get_post_parent_id($curr_id);

            } elseif (get_field('acf_article_type') == 'feature' && get_field('acf_article_feature') && (! get_field('acf_article_video'))) {
                // Get IDs for singular post type feature

                $curr_feature_id = (get_field('acf_article_feature'));

                $curr_id = get_post_meta($curr_feature_id->ID, 'acf_feature_parent_sub_category', true);
                $curr_parent_id = wp_get_post_parent_id($curr_id);

            } elseif (get_field('acf_article_type') == 'columnist') {
                // Get IDs for singular post type columnist

                $page_obj = get_field('acf_inside_track_breadcrumb', 'option');
                $curr_id = $page_obj->ID;
                $curr_parent_id = wp_get_post_parent_id($curr_id);

            } elseif (get_field('acf_article_video') && get_field('acf_article_media')) {
                $main_subcat = get_field('article_side_main_subcategory');

                $curr_id = avatar_get_page_by_cat($main_subcat);
                $curr_parent_id = wp_get_post_parent_id($curr_id);

            } else {
                // Get IDs for singular post type default

                $curr_id = get_field('article_side_main_subcategory');
                $curr_parent_cat_arr = get_ancestors($curr_id, 'category', 'taxonomy');
                $curr_parent_id = $curr_parent_cat_arr ? $curr_parent_cat_arr[0] : 0;

                // Bypass for Tools if there is a pageID instead of categoryID, we'll compare pageID.
                if (avatar_get_page_by_cat($curr_parent_id)) {
                    $curr_parent_id = avatar_get_page_by_cat($curr_parent_id);
                }
            }
        }

        // Test all variables and add nesesary class to menu item
        if ($curr_nav_id == $curr_parent_id or ($curr_nav_id == $curr_id and ! $curr_parent_id)) {
            $classes[] = 'current-nav-parent mobile-open';
        }

        if ($curr_nav_id == $curr_parent_id and $curr_parent_id != $curr_id) {
            $classes[] = 'current-nav-parent-has-child';
        }

        if ($curr_nav_id == $curr_id and $curr_parent_id) {
            $classes[] = 'current-nav-child';
        }

        return $classes;
    }

    add_filter('nav_menu_css_class', 'avatar_nav_class', 11, 3);
}

/* -------------------------------------------------------------
 * Changing custom logo CSS classes
 * ============================================================*/

if (! function_exists('avatar_change_custom_logo_class')) {

    function avatar_change_custom_logo_class($html)
    {

        $html = str_replace('custom-logo', 'site-header__logo', $html);
        $html = str_replace('custom-logo-link', 'site-header__link-logo', $html);

        return $html;
    }
    add_filter('get_custom_logo', 'avatar_change_custom_logo_class');
}
