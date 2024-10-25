<?php
/**
 * Custom Functions for categories
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 *  Add CSS class to body for category and subcategory,
 *	post type, page and default post
 * ============================================================*/

if (! function_exists('avatar_category_page_body_class')) {

    function avatar_category_page_body_class($classes)
    {

        $avatar_color_page_options = get_field('acf_body_css', 'option') ? get_field('acf_body_css', 'option') : false;
        $current_id = 0;

        if (! $avatar_color_page_options) {
            return $classes;
        }

        // Get the ID
        if (is_category()) {

            $curr_cat_obj = get_category(get_query_var('cat'));
            if ($curr_cat_obj) {
                // $curr_cat_obj->category_parent;
                $current_id = $curr_cat_obj->cat_ID;
            }

        } elseif (is_singular('page')) {

            $current_id = get_the_ID();

        } elseif (is_singular('post')) {

            if (get_field('article_side_main_subcategory') && get_the_ID()) {
                // Main subcategory ID
                $curr_main_subcat_id = get_field('article_side_main_subcategory');
                // Parent category ID
                $curr_main_cat_id = avatar_get_parent_cat($curr_main_subcat_id);

                $current_id = $curr_main_cat_id ? $curr_main_cat_id : $curr_main_subcat_id;
            }

        } elseif (is_singular('feature')) {

            $page_obj = get_field('acf_in_depth_breadcrumb', 'option');
            if ($page_obj) {
                $current_id = $page_obj->ID;
            }

        } elseif (is_singular('brand')) {

            $page_obj = get_field('acf_brand_knowledge_page', 'option');
            if ($page_obj) {
                $current_id = $page_obj->ID;
            }

        } elseif (is_singular('writer')) {

            $page_obj = get_field('acf_inside_track_breadcrumb', 'option');
            if ($page_obj) {
                $current_id = $page_obj->ID;
            }

        }

        if (! $current_id) {
            return $classes;
        }

        $classes[] .= avatar_get_cat_page_color($current_id, true);

        return $classes;
    }
    add_filter('body_class', 'avatar_category_page_body_class');

}

/* -------------------------------------------------------------
 * Return CSS class for body or a element from theme option
 * ============================================================*/

if (! function_exists('avatar_get_cat_page_color')) {

    function avatar_get_cat_page_color($cat_or_page_id, $body_class = false)
    {

        $avatar_featured_category_color_array = get_field('acf_body_css', 'option');
        if ($avatar_featured_category_color_array) {

            $css = '';

            foreach ($avatar_featured_category_color_array as $key => $value) {

                $page_ids = $value['page'] ? $value['page'] : [];
                $cat_ids = $value['category'] ? $value['category'] : [];

                $all_ids = array_merge($page_ids, $cat_ids);

                if (in_array($cat_or_page_id, $all_ids)) {
                    if ($body_class) {
                        $css = $value['class'];
                    } else {
                        $css = str_replace('_body_', '_', $value['class']);
                    }

                    return $css;
                }
            }
        }
    }
}

/* -------------------------------------------------------------
 *  Get current parent caregory by ID
 * ============================================================*/

if (! function_exists('avatar_get_parent_cat')) {

    function avatar_get_parent_cat($curr_main_subcat_id)
    {
        //Find parent category
        $curr_main_cat_arr = get_ancestors($curr_main_subcat_id, 'category');
        $curr_main_cat_id = 0;
        if (is_array($curr_main_cat_arr)) {
            foreach ($curr_main_cat_arr as $key) {
                $curr_main_cat_id = $key;
            }
        }

        return $curr_main_cat_id;
    }
}

/* -------------------------------------------------------------
 * Modifiy Yoast Open Graph Type for Page
 * ============================================================*/
if (! function_exists('avatar_modify_opengraph_type')) {
    function avatar_modify_opengraph_type($type)
    {
        if (is_front_page()) {
            $type = 'homepage';
        } elseif (is_page()) {
            $type = 'page';
        }

        return $type;
    }
    add_filter('wpseo_opengraph_type', 'avatar_modify_opengraph_type');
}

/* -------------------------------------------------------------
 * Get category ID by page ID (see Mapping : AVAIE-1020)
 * ============================================================*/
if (! function_exists('avatar_get_cat_by_page')) {

    function avatar_get_cat_by_page($cat_id)
    {

        $id = false;
        if ($avatar_page2cat_mapping = get_field('acf_page_to_cat', 'option')) {

            foreach ($avatar_page2cat_mapping as $key => $value) {

                if ($value['page'] == $cat_id) {
                    $id = $value['category'];
                }
            }
        }

        return $id;
    }
}

/* -------------------------------------------------------------
 * Get page ID by category ID (see Mapping : AVAIE-1020)
 * ============================================================*/
if (! function_exists('avatar_get_page_by_cat')) {

    function avatar_get_page_by_cat($page_id)
    {

        $id = false;
        if ($avatar_page2cat_mapping = get_field('acf_page_to_cat', 'option')) {

            foreach ($avatar_page2cat_mapping as $key => $value) {

                if ($value['category'] == $page_id) {
                    $id = $value['page'];
                }
            }
        }

        return $id;
    }
}
