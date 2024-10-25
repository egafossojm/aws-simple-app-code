<?php

/**
 * Custom Functions for M32
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 *  Set main header tags for M32
 * ============================================================*/
if (! function_exists('at_m32_variables')) {

    function at_m32_variables()
    {

        // M32 Tags
        global $wp, $post, $current_user;
        //variables initialization
        $data_tc_post_id = $data_tc_section = $data_tc_category = $data_tc_pagename = $data_tc_device =
            $data_tc_language = $data_tc_slug = $data_tc_content_type = $data_tc_page_type = $data_tc_url =
            $category = $data_tc_tag_names = $category_names =
            $data_tc_categories_names = $data_tc_company_names = $data_tc_column_names =
            $data_tc_brand_topic_names = $data_tc_sponsor_names = $data_author = '';

        $data_tc_pagename = wp_title('', false);
        $data_tc_device = wp_is_mobile() ? 'mobile' : 'desktop';
        $data_tc_language = get_locale();
        $data_tc_url = home_url($wp->request);
        //$data_tc_user 		= is_user_logged_in() ? $current_user->user_login : 'guest';

        //current post type variables
        if (is_singular(['writer', 'feature', 'brand', 'newspaper'])) {
            $data_tc_content_type = 'sectionhome';
            $data_tc_post_id = $post->ID;
            $data_tc_pagename = get_the_title();
            if (is_singular('writer')) {
                $data_tc_page_type = 'writer';
            }
            if (is_singular('feature')) {
                $data_tc_page_type = 'feature';
            }
            if (is_singular('brand')) {
                $data_tc_page_type = 'brand';
                $data_tc_content_type = 'subhome';
            }
            if (is_singular('newspaper')) {
                $data_tc_page_type = 'newspaper';
            }
        } elseif (is_single()) {
            //current post type : single article

            $cur_main_sub_cat_id = get_field('article_side_main_subcategory', $data_tc_post_id);

            if ($cur_main_sub_cat_id) {

                // Get current main sub category obj
                $cur_main_sub_cat_obj = get_category($cur_main_sub_cat_id);

                if ($cur_main_sub_cat_obj) {

                    $data_tc_category = $cur_main_sub_cat_obj->name;

                    // Get current main parent category obj
                    $cur_main_sub_cat_par_obj = get_category($cur_main_sub_cat_obj->category_parent);

                    if ($cur_main_sub_cat_par_obj) {

                        $data_tc_section = $cur_main_sub_cat_par_obj->name;
                    }
                }
            }

            $data_tc_content_type = 'content';
            $data_tc_page_type = 'post';
            $data_tc_post_id = $post->ID;
            $data_tc_pagename = $post->post_title;
            $data_tc_slug = $post->post_name;
            // optional
            $authors_list = get_field('acf_article_author');
            if ($authors_list) {
                foreach ($authors_list as $author) {
                    $data_author = [];
                    if (is_object($author)) {
                        $data_author[] = get_the_title($author->ID);
                    }
                }
            }
            $data_tc_tag_names = wp_get_object_terms($data_tc_post_id, 'post_tag', ['fields' => 'names']);
            $data_tc_categories_names = wp_get_object_terms($data_tc_post_id, 'category', ['fields' => 'names']);
            $data_tc_company_names = wp_get_object_terms($data_tc_post_id, 'post_company', ['fields' => 'names']);
            $data_tc_column_names = wp_get_object_terms($data_tc_post_id, 'post_column', ['fields' => 'names']);
            $data_tc_brand_topic_names = wp_get_object_terms($data_tc_post_id, 'post_brand_topic', ['fields' => 'names']);
            $data_tc_sponsor_names = wp_get_object_terms($data_tc_post_id, 'post_sponsor', ['fields' => 'names']);

            switch ($post->post_type) {
                case 'microsite':
                    $data_dtmcustom = get_field('acf_microsite_dtm_custom', $data_tc_post_id);
                    $data_tc_categories_names = 'Microsite';
                    $data_tc_section = 'microsite';
                    break;
                default:
                    $data_dtmcustom = get_field('acf_article_dtm_custom', $data_tc_post_id);
                    break;
            }
        } elseif (is_category($category)) {
            //current post type : category pages
            $current_category_id = get_query_var('cat');
            $current_category_object = get_category($current_category_id);

            $data_tc_page_type = 'category';
            $data_tc_pagename = $current_category_object->nav_menu_description;
            $data_tc_section = $current_category_object->name;
            if ($current_category_object->category_parent == 0) {
                //is parent category
                $data_tc_content_type = 'sectionhome';
            } else {
                $data_tc_content_type = 'subhome';
                $data_tc_section = get_cat_name($current_category_object->category_parent);
            }
        } elseif (is_front_page()) {
            //current post type : homepage - page
            $data_tc_content_type = 'homepage';
            $data_tc_page_type = 'home';
            $data_tc_section = 'homepage';
        } elseif (is_page()) {
            //current post type : page
            $data_tc_content_type = 'sectionhome';
            $data_tc_page_type = 'page';
            $data_tc_pagename = $post->post_title;
            $data_tc_section = $post->post_title;
            if ($post->post_parent) {
                $data_tc_section = get_the_title($post->post_parent);
            }
        } elseif (is_tag()) {
            $object = get_term_by('name', single_tag_title('', false), 'post_tag');
            $data_tc_content_type = 'sectionhome';
            $data_tc_page_type = 'tag';
            $data_tc_pagename = single_tag_title('', false);

            $data_dtmcustom = get_field('acf_keyword_dtm_custom', $object);
        } elseif (is_search()) {
            $data_tc_content_type = 'sectionhome';
            $data_tc_page_type = 'search';
            $data_tc_pagename = get_search_query();
        } elseif (is_tax()) {
            $site_id = get_current_blog_id();
            $data_tc_categories_names = $site_id == 4 ? 'Gestionnaires en direct' : 'Advisor To Go';
            switch (get_taxonomy(get_queried_object()->taxonomy)->name) {
                case 'post_sponsor':
                    $data_tc_categories_names .= $site_id == 4 ? ',Compagnie' : ',Company';
                    $data_tc_section = $site_id == 4 ? 'gestionnaires-en-direct' : 'advisor-to-go';
                    $sponsor = get_term_by('slug', get_query_var('post_sponsor'), 'post_sponsor');
                    $acf_sponsor_type = get_field('acf_sponsor_type', $sponsor);
                    if ($acf_sponsor_type != 'podcast') {
                        $data_tc_categories_names = 'company';
                    }
                    break;
                case 'post_region':
                    $data_tc_categories_names .= $site_id == 4 ? ',Région' : ',Region';
                    $data_tc_section = $site_id == 4 ? 'gestionnaires-en-direct' : 'advisor-to-go';
                    break;
            }
        }

        $m32_array_variables = [

            'data_tc_section' => $data_tc_section,
            'data_tc_category' => $data_tc_category,
            'data_tc_pagename' => $data_tc_pagename,
            'data_tc_content_type' => $data_tc_content_type,
            'data_tc_page_type' => $data_tc_page_type,
            'data_tc_device' => $data_tc_device,
            'data_tc_language' => $data_tc_language,
            'data_tc_url' => $data_tc_url,
            'data_tc_slug' => $data_tc_slug,
            //'data_tc_user'		    =>	$data_tc_user,
            'data_tc_tags' => $data_tc_tag_names,
            'data_tc_categories' => $data_tc_categories_names,
            'data_tc_company' => $data_tc_company_names,
            'data_tc_column' => $data_tc_column_names,
            'data_tc_brand_topic' => $data_tc_brand_topic_names,
            'data_tc_sponsors' => $data_tc_sponsor_names,
            'data_authors' => $data_author,
            'data_tc_pid' => $data_tc_post_id,
        ];
        if (! empty($data_dtmcustom) && trim($data_dtmcustom) !== '') {
            $m32_array_variables['data_dtmcustom'] = $data_dtmcustom;
        }

        return $m32_array_variables;
    }
}

/* -------------------------------------------------------------
 * Insert this data in page (JavaScript Obj)
 * ============================================================*/
if (! function_exists('at_m32_vars')) {

    function at_m32_vars()
    {
        $at_js_code = get_field('acf_ad_code_site', 'option');

        if (! $at_js_code) {
            return;
        }
        $at_js_obj = [];
        $m32_variables = at_m32_variables();

        // M32
        $at_js_obj['ai'] = esc_attr($m32_variables['data_tc_pid']);
        $at_js_obj['atitle'] = esc_attr($m32_variables['data_tc_slug']);
        $at_js_obj['cat'] = $m32_variables['data_tc_categories'];
        $at_js_obj['pg'] = esc_attr($m32_variables['data_tc_content_type']);
        if ($at_js_obj['cat'] == 'Microsite') {
            if (at_m32_get_ss() == '-') {
                $at_js_obj['ss'] = $at_js_obj['atitle'];
            } else {
                $at_js_obj['ss'] = at_m32_get_ss();
            }
        } else {
            $at_js_obj['ss'] = at_m32_get_ss();
        }
        $at_js_obj['section'] = sanitize_title($m32_variables['data_tc_section']);

        // Ours
        $at_js_obj['avt-ad-code-site'] = esc_attr($at_js_code);
        $at_js_obj['avt-language'] = esc_attr($m32_variables['data_tc_language']);
        $at_js_obj['avt-category'] = $m32_variables['data_tc_category'];
        $at_js_obj['avt-page-title'] = esc_attr($m32_variables['data_tc_pagename']);
        $at_js_obj['avt-url'] = esc_attr($m32_variables['data_tc_url']);
        $at_js_obj['avt-device'] = esc_attr($m32_variables['data_tc_device']);
        $at_js_obj['avt-page-type'] = esc_attr($m32_variables['data_tc_page_type']);
        $at_js_obj['avt-tags'] = $m32_variables['data_tc_tags'];
        $at_js_obj['avt-company'] = $m32_variables['data_tc_company'];
        $at_js_obj['avt-column'] = $m32_variables['data_tc_column'];
        $at_js_obj['avt-brand_topic'] = $m32_variables['data_tc_brand_topic'];
        $at_js_obj['avt-sponsor'] = $m32_variables['data_tc_sponsors'];
        $at_js_obj['avt-author'] = $m32_variables['data_authors'];
        if (isset($m32_variables['data_dtmcustom'])) {
            $at_js_obj['sponsid'] = $m32_variables['data_dtmcustom'];
        }

        //$at_js_obj['avt-user']			= esc_attr( $m32_variables['data_tc_user'] );

        // Old tags, we dont use
        // $at_js_obj['dcove'] 			= esc_attr( $m32_variables['data_tc_dcove'] );

        $at_js_obj = array_filter($at_js_obj);
        $at_json_data = wp_json_encode($at_js_obj);

        return 'var m32_context ='.$at_json_data;
    }
}

/* -------------------------------------------------------------
 * Create m32 variable for banner
 * ============================================================*/

if (! function_exists('at_get_m32banner')) {

    function at_get_m32banner($arr_m32_vars = [], $arr_avt_vars = [], $datam32ad = 'data-m32-ad')
    {

        if (empty($arr_m32_vars)) {
            return;
        }

        $avatar_css = array_key_exists('class', $arr_avt_vars) ? $arr_avt_vars['class'] : '';
        $avatar_id = array_key_exists('id', $arr_avt_vars) ? $arr_avt_vars['id'] : '';

        $arr_m32_vars_default = [
            'dfpId' => '4916', // it's the same for all TC-Media sites
            'dfpAdUnitPath' => get_field('acf_ad_code_site', 'option').'/'.at_m32_get_ss(),
        ];
        $args = wp_parse_args($arr_m32_vars, $arr_m32_vars_default);
        $data_options = json_encode($args, JSON_UNESCAPED_SLASHES);

        $ad_div = "<div class='".esc_attr($avatar_css)."' ".($avatar_id !== '' ? " id='".$avatar_id."'" : '').$datam32ad." data-options='".$data_options."'></div>";

        return $ad_div;
    }
}

/* -------------------------------------------------------------
 * Display m32 HTML for banner
 * ============================================================*/

if (! function_exists('at_get_the_m32banner')) {
    function at_get_the_m32banner($arr_m32_vars = [], $arr_avt_vars = [], $datam32ad = 'data-m32-ad')
    {
        $html_banner = at_get_m32banner($arr_m32_vars, $arr_avt_vars, $datam32ad);
        echo $html_banner;
    }
}

/* -------------------------------------------------------------
 * ss - is m32 parameter for SubDirectory
 * ============================================================*/

if (! function_exists('at_m32_get_ss')) {
    function at_m32_get_ss()
    {
        global $post;
        $data_tc_ad_zone = '-';

        if (is_singular(['writer', 'feature', 'brand', 'newspaper'])) {
            $data_tc_ad_zone = sanitize_title(get_the_title());
        } elseif (is_single()) {

            $cur_main_sub_cat_id = get_field('article_side_main_subcategory', get_the_ID());

            if ($cur_main_sub_cat_id && $cur_main_sub_cat_obj = get_category($cur_main_sub_cat_id)) {

                $data_tc_ad_zone = $cur_main_sub_cat_obj->slug;
            }
        } elseif (is_category()) {
            //current post type : category pages
            $current_category_id = get_query_var('cat');
            $current_category_object = get_category($current_category_id);
            $data_tc_ad_zone = $current_category_object->slug;
        } elseif (is_front_page()) {
            $data_tc_ad_zone = 'home';
        } elseif (is_page()) {
            $data_tc_ad_zone = sanitize_title($post->post_title);
        } elseif (is_tag()) {
            $data_tc_ad_zone = sanitize_title(single_tag_title('', false));
        } elseif (is_search()) {
            $data_tc_ad_zone = sanitize_title(get_search_query());
        } elseif (is_tax()) {
            $data_tc_ad_zone = str_replace(' ', '-', strtolower(single_cat_title('', false)));
        }

        return $data_tc_ad_zone;
    }
}

if (! function_exists('get_correct_banner_ads')) {
    function get_correct_banner_ads($category_list, $site_id, $id, $wp_query, $arr_m32_vars = [], $arr_avt_vars = [], $is_cir_author = 0, $datam32ad = 'data-m32-ad')
    {

        $pagename = get_query_var('pagename');
        $post_categories_id_list = null;
        $queried_object_id = $wp_query->get_queried_object_id();
        $author_origin = get_field('acf_columnist_site_source', $queried_object_id);
        $cir_author = false;
        $cir_microsite = find_cir_microsites($queried_object_id) === true;

        if (($author_origin && strcmp('CIR blog', $author_origin) === 0) || $is_cir_author) {
            $cir_author = true;
        }

        if (! $pagename && $id > 0) {
            $post = $wp_query->get_queried_object();
            $pagename = $post->post_name;
            $post_categories_id_list = wp_get_post_categories($post->ID);
        }

        //OLD IF BENCAN
        /*(($site_id == 3) || (!find_multiple_category_in_array($category_list, [1141, 3087, 23112])
        && !find_multiple_category_in_array($post_categories_id_list, [1141, 3087, 23112])
        && $queried_object_id !== 23112
        && strcmp($pagename, 'canadian-investment-review-expert') !== 0
        && strcmp($pagename, 'canadian-investment-review-partner-content') !== 0
        && !$cir_author
        && !$cir_microsite)) */

        if (get_current_view_context() && get_current_view_context() === 'cir') {
            // echo 'cir';
            return at_get_the_cir_m32banner(
                $arr_m32_vars,
                $arr_avt_vars
            );
        } elseif (get_current_view_context() && (get_current_view_context() === 'bencan' || get_current_view_context() === 'ava')) {
            // echo 'ben';
            return at_get_the_m32banner(
                $arr_m32_vars,
                $arr_avt_vars
            );
        } else {
            return;
        }
    }
}

if (! function_exists('find_category_in_array')) {
    function find_category_in_array($category_list, $to_find_category_id)
    {
        if (isset($category_list)) {
            foreach ($category_list as $current_category) {
                if (isset($current_category->term_id)) {
                    $to_compare_cat_id = $current_category->term_id;
                } else {
                    $to_compare_cat_id = $current_category;
                }
                if ($to_compare_cat_id == $to_find_category_id) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (! function_exists('find_multiple_category_in_array')) {
    function find_multiple_category_in_array($category_list, $to_find_category_id_list)
    {
        foreach ($to_find_category_id_list as $current_category) {
            if (find_category_in_array($category_list, $current_category) === true) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('find_cir_microsites')) {
    function find_cir_microsites($post_id)
    {
        $tmp_id = $post_id;
        while ($tmp_id) {
            $current_post = get_post($tmp_id);

            if (! $current_post) {
                return false;
            }

            $tmp_id = $current_post->post_parent;
            // var_dump($current_post->post_name);
            if (
                strcmp('microsite-cir', $current_post->post_name) === 0
                || strcmp('canadian-investment-review', $current_post->post_name) === 0
            ) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('is_microsite')) {
    function is_microsite($post)
    {
        return get_post_type($post) == 'microsite';
    }
}
