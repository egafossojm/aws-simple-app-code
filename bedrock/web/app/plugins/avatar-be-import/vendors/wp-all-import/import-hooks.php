<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('abe_hooks_on_save')) {
    function abe_hooks_on_save($post_id)
    {
        /**
         * Get the value of the actual import
         *
         * ACF
         * The procedure, is to create a custom field (with ACF) with the name (id) "acf_wp_all_import_id"
         * (Add the class "hidden" to be sure it doesnt show in the admin)
         * (This field is only use for import)
         *
         * WP ALL IMPORT
         * For each different scripts, write an identificable name like "import_article", "import_author", etc...
         * So during the import, it will be possible to identify the actual script running and apply different functions for each script
         */
        $actual_import = get_field('acf_wp_all_import_id', $post_id);
        error_log('Init import id: '.$actual_import);
        if (isset($actual_import) && $actual_import == 'import_post_topics') {
            $actual_import = get_field('acf_wp_all_import_id', 'post_tag_'.$post_id);
        }
        error_log('Post import id: '.$actual_import);

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'term_'.$post_id);
            error_log('Term import id: '.$actual_import);

        }

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'user_'.$post_id);
            error_log('User import id: '.$actual_import);

        }

        $import_article = 'import_article';

        error_log('ACTUAL IMPORT: '.$actual_import);
        /* For import of Articles */
        if (substr($actual_import, 0, strlen($import_article)) === $import_article || $actual_import === 'import_magazines' || $actual_import === 'import_blogs' || $actual_import === 'import_cir_articles') {
            // Set article common fields
            abe_set_common_article_fields($post_id);
            if ($actual_import === 'import_blogs') {

                $author_name = abe_add_link_to_CPT_authors($post_id);

                if (isset($author_name)) {
                    error_log('Found Columnist: '.$author_name);
                    $child_id = get_cat_id($author_name);
                    error_log('ChildId: '.$child_id);
                    $child = get_category($child_id); //firstly, load data for your child category
                    $parent_cat_id = $child->parent; //from your child category, grab parent ID
                    error_log('ParentId: '.$parent_cat_id);
                    wp_set_post_categories($post_id, [$child->term_id, $parent_cat_id], true);
                    $main_cat_id = get_field('article_side_main_subcategory', $post_id);
                    $main_cat = get_category($main_cat_id);
                    error_log(print_r($main_cat, true));
                    if ($main_cat->name === 'All Uncategorized') {
                        update_field('article_side_main_subcategory', $child_id, $post_id);
                    }
                } else {
                    error_log('Not a columnist');
                }

            } else {

                $obj_author = abe_add_link_to_authors($post_id);
            }

            if ($actual_import === 'import_magazines') {
                abe_add_link_to_back_issue_date($post_id);

                $child = get_category_by_slug('benefits-canada-archive'); //firstly, load data for your child category
                $parent_cat_id = $child->parent; //from your child category, grab parent ID
                wp_set_post_categories($post_id, [$child->term_id, $parent_cat_id], true);
            }

        } elseif ($actual_import == 'content_only_cir') {

            abe_remove_featured_image_from_content_cir($post_id);

        } elseif ($actual_import == 'content_only_be') {
            abe_remove_featured_image_from_content_be($post_id);
        } elseif ($actual_import == 'authors') {

            abe_set_ACF_author_column($post_id);

        } elseif ($actual_import == 'di_web_users_be' || $actual_import == 'di_web_users_cir') {

            $user_email = get_field('acf_user_email', 'user_'.$post_id);
            $user_first_name = get_field('acf_user_first_name', 'user_'.$post_id);
            $user_last_name = get_field('acf_user_last_name', 'user_'.$post_id);

            $obfuscation_string = get_field('acf_obfuscation_string', 'user_'.$post_id);

            error_log(print_r($user_email, true));
            error_log($user_first_name);
            error_log($user_last_name);

            $user_fields = [];

            $user_fields['f_EMail'] = $obfuscation_string.$user_email;
            $user_fields['f_FirstName'] = $user_first_name;
            $user_fields['f_LastName'] = $user_last_name;

            abe_extract_user_fields($user_fields, $post_id, $actual_import);

            error_log('userFields: '.print_r($user_fields, true));

            //Send to DI
            $send_to_di = avatar_create_user_di($user_fields, 'Insert');

            error_log('DI: '.print_r($send_to_di, true));

            $user_id = $post_id;

            $meta = ['add_to_blog' => $blog_id, 'new_role' => 'subscriber'];

            // Add user to all blogs
            $blog_list = get_sites();
            foreach ($blog_list as $key => $blog) {
                if ($blog->blog_id == $blog_id) {
                    // Add new user to site (blog)
                    $result = add_new_user_to_blog($user_id, null, $meta);
                } else {
                    $result = add_user_to_blog($blog->blog_id, $user_id, 'subscriber');
                }
            }

        } elseif ($actual_import == 'di_web_users_old_cir' || $actual_import == 'di_web_users_old_be') {
            $user_email = get_field('acf_user_email', 'post_tag_'.$post_id);
            $existing_user = get_user_by('email', $user_email);
            $user_id = $existing_user->ID;
            $get_users_obj_blog_be = get_users(['blog_id' => 7, 'search' => $user_id]);
            $roles = $get_users_obj_blog_be[0]->roles;

            error_log('EMAIL: '.$user_email);

            $user_first_name = get_field('acf_user_first_name', 'post_tag_'.$post_id);
            $user_last_name = get_field('acf_user_last_name', 'post_tag_'.$post_id);
            $obfuscation_string = get_field('acf_obfuscation_string', 'post_tag_'.$post_id);

            $user_fields = [];

            $user_fields['f_EMail'] = $obfuscation_string.$user_email;
            $user_fields['f_FirstName'] = $user_first_name;
            $user_fields['f_LastName'] = $user_last_name;

            abe_extract_user_fields($user_fields, $post_id, $actual_import);
            error_log(print_r($user_fields, true));
            //Send to DI
            $send_to_di = avatar_create_user_di($user_fields, 'Insert');
            error_log('DI: '.print_r($send_to_di, true));

            if (isset($roles)) {
                error_log('Already in blog 7, skipping...');

                return; //already in blog benefits
            }

            $user_roles = [];
            $blog_list = get_sites();

            foreach ($blog_list as $key => $blog) {
                $get_users_obj = get_users(['blog_id' => $blog->blog_id, 'search' => $user_id]);
                array_push($user_roles, $get_users_obj[0]->roles[0]);
            }

            if (in_array('administrator', $user_roles)) {
                $role = 'administrator';
            } elseif (in_array('webeditor', $user_roles)) {
                $role = 'webeditor';
            } elseif (in_array('salescoordinator', $user_roles)) {
                $role = 'salescoordinator';
            } elseif (in_array('newspaper', $user_roles)) {
                $role = 'newspaper';
            } else {
                $role = 'subscriber';
            }

            $result = add_user_to_blog(7, $user_id, $role);
        }

    }
    add_action('pmxi_saved_post', 'abe_hooks_on_save', 10, 1);
}

if (! function_exists('abe_extract_user_fields')) {
    function abe_extract_user_fields(&$user_fields, $post_id, $actual_import)
    {
        //BENEFITS CANADA FIELDS

        if ($actual_import === 'di_web_users_old_be' || $actual_import === 'di_web_users_old_cir') {
            $post_type = 'post_tag_';
        } else {
            $post_type = 'user_';
        }

        if ($actual_import === 'di_web_users_be' || $actual_import === 'di_web_users_old_be') {
            error_log('----BE-----');
            $field_breaking_news = get_field('acf_user_optin_benefit_breaking_news', $post_type.$post_id);
            $field_confhighlights = get_field('acf_user_optin_benefit_confhighlights', $post_type.$post_id);
            $field_digitaledition = get_field('acf_user_optin_benefit_digitaledition', $post_type.$post_id);
            $field_events = get_field('acf_user_optin_benefit_events', $post_type.$post_id);
            $field_free_content = get_field('acf_user_optin_benefit_free_content', $post_type.$post_id);
            $field_newsletter = get_field('acf_user_optin_benefit_newsletter', $post_type.$post_id);
            $field_specoffers = get_field('acf_user_optin_benefit_specoffers', $post_type.$post_id);
            $field_tp_sponso = get_field('acf_user_optin_benefit_tp_sponso', $post_type.$post_id);
            $field_research = get_field('acf_user_optin_benefit_research', $post_type.$post_id);

            $field_breaking_news_date = get_field('acf_user_date_optin_benefit_breaking_news', $post_type.$post_id);
            $field_confhighlights_date = get_field('acf_user_date_optin_benefit_confhighlights', $post_type.$post_id);
            $field_digitaledition_date = get_field('acf_user_date_optin_benefit_digitaledition', $post_type.$post_id);
            $field_events_date = get_field('acf_user_date_optin_benefit_events', $post_type.$post_id);
            $field_free_content_date = get_field('acf_user_date_optin_benefit_free_content', $post_type.$post_id);
            $field_newsletter_date = get_field('acf_user_date_optin_benefit_newsletter', $post_type.$post_id);
            $field_specoffers_date = get_field('acf_user_date_optin_benefit_specoffers', $post_type.$post_id);
            $field_tp_sponso_date = get_field('acf_user_date_optin_benefit_tp_sponso', $post_type.$post_id);
            $field_research_date = get_field('acf_user_date_optin_benefit_research', $post_type.$post_id);

            if (isset($field_newsletter) && $field_newsletter != '') {
                $user_fields['optin_optin_BECA_Newsletter'] = $field_newsletter;
            }
            if (isset($field_newsletter_date) && $field_newsletter_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Newsletter'] = $field_newsletter_date;
            }
            if (isset($field_tp_sponso) && $field_tp_sponso != '') {
                $user_fields['optin_optin_BECA_3rd_Part_Spons'] = $field_tp_sponso;
            }
            if (isset($field_tp_sponso_date) && $field_tp_sponso_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_3rd_Pt_Spons'] = $field_tp_sponso_date;
            }
            if (isset($field_events) && $field_events != '') {
                $user_fields['optin_optin_BECA_Events'] = $field_events;
            }
            if (isset($field_events_date) && $field_events_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Events'] = $field_events_date;
            }
            if (isset($field_free_content) && $field_free_content != '') {
                $user_fields['optin_optin_BECA_Free_Content'] = $field_free_content;
            }
            if (isset($field_free_content_date) && $field_free_content_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Free_Content'] = $field_free_content_date;
            }
            if (isset($field_research) && $field_research != '') {
                $user_fields['optin_optin_BECA_Research'] = $field_research;
            }
            if (isset($field_research_date) && $field_research_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Research'] = $field_research_date;
            }
            if (isset($field_specoffers) && $field_specoffers != '') {
                $user_fields['optin_optin_BECA_Special_Offers'] = $field_specoffers;
            }
            if (isset($field_specoffers_date) && $field_specoffers_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Spl_Offers'] = $field_specoffers_date;
            }
            if (isset($field_confhighlights) && $field_confhighlights != '') {
                $user_fields['optin_optin_BECA_Conf_Hl'] = $field_confhighlights;
            }
            if (isset($field_confhighlights_date) && $field_confhighlights_date != '') {
                $user_fields['dtOptin_dtOptin_BECA_Conf_Hl'] = $field_confhighlights_date;
            }

        } elseif ($actual_import === 'di_web_users_cir' || $actual_import === 'di_web_users_old_cir') {

            error_log('----CIR-----');

            //CIR FIELDS
            $field_confhighlights_cir = get_field('acf_user_optin_cir_confhighlights', $post_type.$post_id);
            $field_digitaledition_cir = get_field('acf_user_optin_cir_digitaledition', $post_type.$post_id);
            $field_events_cir = get_field('acf_user_optin_cir_events', $post_type.$post_id);
            $field_free_content_cir = get_field('acf_user_optin_cir_free_content', $post_type.$post_id);
            $field_newsletter_cir = get_field('acf_user_optin_cir_newsletter', $post_type.$post_id);
            $field_specoffers_cir = get_field('acf_user_optin_cir_specoffers', $post_type.$post_id);
            $field_tp_sponso_cir = get_field('acf_user_optin_cir_tp_sponso', $post_type.$post_id);
            $field_research_cir = get_field('acf_user_optin_cir_research', $post_type.$post_id);

            $field_confhighlights_date_cir = get_field('acf_user_date_optin_cir_confhighlights', $post_type.$post_id);
            $field_digitaledition_date_cir = get_field('acf_user_date_optin_cir_digitaledition', $post_type.$post_id);
            $field_events_date_cir = get_field('acf_user_date_optin_cir_events', $post_type.$post_id);
            $field_free_content_date_cir = get_field('acf_user_date_optin_cir_free_content', $post_type.$post_id);
            $field_newsletter_date_cir = get_field('acf_user_date_optin_cir_newsletter', $post_type.$post_id);
            $field_specoffers_date_cir = get_field('acf_user_date_optin_cir_specoffers', $post_type.$post_id);
            $field_tp_sponso_date_cir = get_field('acf_user_date_optin_cir_tp_sponso', $post_type.$post_id);
            $field_research_date_cir = get_field('acf_user_date_optin_cir_research', $post_type.$post_id);

            if (isset($field_newsletter_cir) && $field_newsletter_cir != '') {
                $user_fields['optin_optin_CIR_Newsletter'] = $field_newsletter_cir;
            }
            if (isset($field_newsletter_date_cir) && $field_newsletter_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_Newsletter'] = $field_newsletter_date_cir;
            }
            if (isset($field_tp_sponso_cir) && $field_tp_sponso_cir != '') {
                $user_fields['optin_optin_CIR_3rd_Party_Spon'] = $field_tp_sponso_cir;
            }
            if (isset($field_tp_sponso_date_cir) && $field_tp_sponso_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_3rd_Party_Spon'] = $field_tp_sponso_date_cir;
            }
            if (isset($field_events_cir) && $field_events_cir != '') {
                $user_fields['optin_optin_CIR_Events'] = $field_events_cir;
            }
            if (isset($field_events_date_cir) && $field_events_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_Events'] = $field_events_date_cir;
            }
            if (isset($field_free_content_cir) && $field_free_content_cir != '') {
                $user_fields['optin_optin_CIR_Free_Content'] = $field_free_content_cir;
            }
            if (isset($field_free_content_date_cir) && $field_free_content_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_Free_Content'] = $field_free_content_date_cir;
            }
            if (isset($field_research_cir) && $field_research_cir != '') {
                $user_fields['optin_optin_CIR_Research'] = $field_research_cir;
            }
            if (isset($field_research_date_cir) && $field_research_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_Research'] = $field_research_date_cir;
            }
            if (isset($field_specoffers_cir) && $field_specoffers_cir != '') {
                $user_fields['optin_optin_CIR_Special_Offers'] = $field_specoffers_cir;
            }
            if (isset($field_specoffers_date_cir) && $field_specoffers_date_cir != '') {
                $user_fields['dtOptin_dtOptin_CIR_Special_Offers'] = $field_specoffers_date_cir;
            }
            if (isset($field_confhighlights_cir) && $field_confhighlights_cir != '') {
                $user_fields['optin_optin_CIR_Conf_Highlights'] = $field_confhighlights_cir;
            }
            if (isset($field_confhighlights_date_cir) && $field_confhighlights_date_cir != '') {
                $user_fields['dtOptin_CIR_Conf_Highlights'] = $field_confhighlights_date_cir;
            }

        }

    }
}

if (! function_exists('abe_set_common_article_fields')) {
    function abe_set_common_article_fields($post_id)
    {

        $id_to_category = [
            '1' => 'Uncategorized',
            '4' => 'Benefits Canada News',
            '5' => 'Benefits',
            '6' => 'Health Benefits',
            '7' => 'Disability management',
            '8' => 'Health/Wellness',
            '9' => 'Other',
            '10' => 'Investments',
            '11' => 'Alternatives',
            '12' => 'Asset classes',
            '13' => 'Emerging &amp; global markets',
            '14' => 'Other',
            '15' => 'Pensions',
            '18' => 'Governance/legislation',
            '19' => 'Other',
            '1949' => 'Partner education',
            '1954' => 'ETFs',
            '1956' => 'Photo Gallery',
            '1957' => 'Equities',
            '1958' => 'Fixed income',
            '1959' => 'Strategies',
            '1972' => 'Defined benefit pensions',
            '1973' => 'Capital accumulation plans',
            '1974' => 'Human resources',
            '1975' => 'Legal issues',
            '1976' => 'Legal issues',
            '1977' => 'Blogs',
            '1978' => 'Absence management',
            '1979' => 'Communication',
            '1980' => 'Communication',
            '1981' => 'Communication',
            '1982' => 'Retirement',
            '1983' => 'Other',
            '1984' => 'Education',
            '1985' => 'SmallBiz'];

        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category

        $title = get_the_title($post_id);

        $main_cat_id_old = get_field('import_wp_all_import_main_sub_category', $post_id);

        if ($main_cat_id_old === '@@PARSE_CAT_LIST@@') {
            $category_list_string = get_field('acf_wp_all_import_categories', $post_id);
            $category_list_array = explode('|', $category_list_string);

            error_log('CATLIST: '.print_r($category_list_array, true));
            if (in_array('Analysis &amp; Research', $category_list_array) || in_array('Analysis & Research', $category_list_array)) {
                $main_cat_name = 'Research & Markets';
            } elseif (in_array('Expert Opinion', $category_list_array)) {
                $main_cat_name = 'All Uncategorized';
            } elseif (in_array('News', $category_list_array)) {
                $main_cat_name = 'Canadian Investment Review News';
            } elseif (in_array('Events', $category_list_array)) {
                $main_cat_name = 'Conferences';
            } else {
                $main_cat_name = 'All Uncategorized';
            }
            $main_sub_category_id = get_cat_ID($main_cat_name);

        } else {
            if ($main_cat_id_old == 'Uncategorized' || empty($main_cat_id_old)) {
                $main_sub_category_id = 'All Uncategorized';
            } else {
                $main_sub_category_id = get_cat_ID($id_to_category[$main_cat_id_old]);
            }

        }

        if (isset($main_sub_category_id)) {
            update_field('article_side_main_subcategory', $main_sub_category_id, $post_id);
            update_field('_yoast_wpseo_primary_category', $main_sub_category_id, $post_id);
        }

        abe_add_featured_image($post_id);

        // Set fields to display
        update_field('acf_article_date_show', true, $post_id);
        update_field('acf_article_category_show', true, $post_id);
        update_field('acf_article_thumbnail_show', true, $post_id);

    }
}

if (! function_exists('abe_add_link_to_brand')) {
    function abe_add_link_to_brand($articleId)
    {
        $brandName = get_post_meta($articleId, 'acf_wp_all_import_brand_name', true);

        if (isset($brandName)) {
            $brand = get_page_by_title($brandName, 'OBJECT', 'brand');
        }

        if (isset($brand)) {
            update_field('acf_article_brand', $brand->ID, $articleId);
            update_field('acf_article_type', 'brand', $articleId);

        }
    }
}

if (! function_exists('abe_add_brightcove')) {
    function abe_add_brightcove($articleId)
    {
        $brightcoveId = get_post_meta($articleId, 'acf_wp_all_import_asset_id', true);

        if (isset($brightcoveId)) {
            update_field('acf_article_video', $brightcoveId, $articleId);
            update_field('acf_article_video_show', true, $articleId);
        }
    }
}

if (! function_exists('abe_set_author')) {
    function abe_set_author($articleId, $authorName)
    {
        $articleAuthors = [];
        $obj_authors_id_register = get_page_by_title($authorName, 'OBJECT', 'writer');
        if (! isset($obj_authors_id_register)) {
            $authorId = wp_insert_post(['post_title' => $authorName, 'post_type' => 'writer', 'post_status' => 'publish']);
            array_push($articleAuthors, $authorId);
        } else {
            array_push($articleAuthors, $obj_authors_id_register->ID);
        }

        if (count($articleAuthors) > 0) {
            update_field('acf_article_author', $articleAuthors, $articleId);
            update_field('acf_article_author_show', true, $articleId);
        }
    }
}

/**
 * Web Users
 */
if (! function_exists('abe_adjust_web_user')) {

    function abe_adjust_web_user($user_id)
    {

        global $wpdb;
        $blog_list = get_sites();
        $current_blog_id = get_current_blog_id();

        $role = get_field('acf_wp_all_import_role_list', 'user_'.$user_id);
        $password = get_field('acf_wp_all_import_password', 'user_'.$user_id);

        $user_login = current_time('timestamp').'fi'.wp_rand(1, 99999);
        $user_nick = update_user_meta($user_id, 'nickname', $user_login);
        $user_primary_blog = update_user_meta($user_id, 'primary_blog', $current_blog_id);

        $result = $wpdb->update(
            $wpdb->users,
            [
                'user_pass' => $password,
                'user_login' => $user_login,
                'user_nicename' => $user_login,
            ],
            ['ID' => $user_id]);

        foreach ($blog_list as $key => $blog) {
            $blog_id = $blog->blog_id;
            $role_curr = $current_blog_id == $blog_id ? $role : 'subscriber';
            $result = add_user_to_blog($blog_id, $user_id, $role_curr);
        }

    }
}

///**
//
// * GET ALL IMAGES FROM CONTENT
// *
// */

if (! function_exists('abe_add_featured_image')) {
    function abe_add_featured_image($post_id)
    {

        $featuredImage_url_request = get_field('acf_wp_all_import_featured_image', $post_id);

        if ($featuredImage_url_request === '@@IN_CONTENT@@') {
            $featuredImage_url = abe_extract_featured_image_from_content($post_id);
        } else {
            $featuredImage_url = $featuredImage_url_request;
        }

        if (! empty($featuredImage_url)) {
            error_log('## '.$featuredImage_url);
            //$extension = image_type_to_extension(getimagesize($featuredImage_url)[2]);
            $upload_dir = wp_upload_dir();
            error_log('UploadDir: '.print_r($upload_dir, true));
            $filename = sanitize_file_name(basename($featuredImage_url));
            error_log($filename);
            if ($featuredImage_url_request === '@@IN_CONTENT@@') {
                $file = $upload_dir['basedir'].'/'.substr($featuredImage_url, 61);
            } else {
                $file = $upload_dir['basedir'].'/'.substr($featuredImage_url, 49);
            }
            error_log('Image Local Path: '.$image_local_path);

            error_log('File: '.$file);
            // Check if file exists before upload
            if (! file_exists($file)) {
                error_log('--- NOT EXISTS '.$featuredImage_url);

                $image_data = file_get_contents($featuredImage_url);

                if ($image_data === false) {
                    error_log('---Not data found');
                }
                // Create upload folder if doesnt exist
                if (wp_mkdir_p($upload_dir['path'])) {
                    $file = $upload_dir['path'].'/'.$filename;
                    error_log('PATH: '.$file);
                } else {
                    $file = $upload_dir['basedir'].'/'.$filename;
                    error_log('BASEDIR: '.$file);
                }

                // Check if file exists before upload
                if (! file_exists($file)) {
                    error_log('==============');
                    file_put_contents($file, $image_data);
                }
            }

            // Create a wordpress attachment for the image
            $wp_filetype = wp_check_filetype($filename, null);
            $title = get_the_title($post_id);

            $attachment = [
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit',
            ];
            $attach_id = wp_insert_attachment($attachment, $file, $post_id);
            update_post_meta($attach_id, '_wp_attachment_image_alt', $title);
            require_once ABSPATH.'wp-admin/includes/image.php';
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);

            set_post_thumbnail($post_id, $attach_id);
        }

    }
}

if (! function_exists('abe_set_ACF_author_column')) {
    function abe_set_ACF_author_column($post_id)
    {
        $columnName = get_field('acf_wp_all_import_column_value', $post_id);
        $term = get_term_by('name', $columnName, 'post_column');

        if (! empty($term)) {
            update_field('acf_author_column', $term->term_id, $post_id);
        } else {
            wp_insert_term($columnName, 'post_column');
        }
    }
}

if (! function_exists('abe_extract_featured_image_from_content')) {
    function abe_extract_featured_image_from_content($post_id)
    {
        $html_wp = get_post($post_id)->post_content;

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        $imgs_extracted = $doc->getElementsByTagName('img');

        // Check if we have images
        if ($imgs_extracted->length > 0) {
            // Extract images
            $img_in_body_url = $imgs_extracted[0]->getAttribute('src');
            error_log('IMG FROM BODY: '.$img_in_body_url);
            if (! (strpos($img_in_body_url, '?') === false)) {
                $img_in_body_url = substr($img_in_body_url, 0, strpos($img_in_body_url, '?'));
            }

            $img_in_body_url = str_replace('wp-content/uploads/sites/7', ' ', $img_in_body_url);
            $img_in_body_url = str_replace('investmentreview.com/files', ' ', $img_in_body_url);
            $img_in_body_url = str_replace('investmentreview.com/wp-content/blogs.dir/1/files', ' ', $img_in_body_url);
            $img_partial_file_path = explode(' ', $img_in_body_url);
            error_log('IMAGE-URL-PART: '.$img_partial_file_path[1]);

            // 4- Save new document
            //------------------------
            error_log('Removing thumbnail from content');
            $imgs_extracted[0]->parentNode->removeChild($imgs_extracted[0]);

            $WpContent = $doc->saveHTML();

            // 5- Update WP content
            //------------------------
            wp_update_post(
                [
                    'ID' => $post_id,
                    'post_content' => $WpContent,
                ]
            );

            return 'http://investmentreview.com/wp-content/blogs.dir/1/files'.$img_partial_file_path[1];

        }

    }
}

if (! function_exists('abe_remove_featured_image_from_content_be')) {
    function abe_remove_featured_image_from_content_be($post_id)
    {
        $featuredImage_url_request = get_field('acf_wp_all_import_featured_image', $post_id);

        $html_wp = get_post($post_id)->post_content;

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        $imgs_extracted = $doc->getElementsByTagName('img');

        if ($imgs_extracted->length > 0) {
            $img_in_body_url_array = explode('/', $imgs_extracted[0]->getAttribute('src'));
            $img_featured_url_array = explode('/', $featuredImage_url_request);
            $img1 = $img_in_body_url_array[count($img_in_body_url_array) - 1];
            $img2 = $img_featured_url_array[count($img_in_body_url_array) - 1];

            if (strlen($img1) > 0 && $img1 == $img2) {
                $imgs_extracted[0]->parentNode->removeChild($imgs_extracted[0]);

                $WpContent = $doc->saveHTML();

                // 5- Update WP content
                //------------------------
                wp_update_post(
                    [
                        'ID' => $post_id,
                        'post_content' => $WpContent,
                    ]
                );
            }

        }
    }
}

if (! function_exists('abe_remove_featured_image_from_content_cir')) {
    function abe_remove_featured_image_from_content_cir($post_id)
    {
        $html_wp = get_post($post_id)->post_content;

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        $imgs_extracted = $doc->getElementsByTagName('img');

        if ($imgs_extracted->length > 0) {
            $imgs_extracted[0]->parentNode->removeChild($imgs_extracted[0]);

            $WpContent = $doc->saveHTML();

            // 5- Update WP content
            //------------------------
            wp_update_post(
                [
                    'ID' => $post_id,
                    'post_content' => $WpContent,
                ]
            );

        }
    }
}

if (! function_exists('abe_remove_all_attributes')) {
    function abe_remove_all_attributes(DOMNode $domNode)
    {
        foreach ($domNode->childNodes as $node) {

            $attributes = $node->attributes;
            while ($attributes->length) {
                $node->removeAttribute($attributes->item(0)->name);
            }
            if ($node->hasChildNodes()) {
                abe_remove_all_attributes($node);
            }
        }
    }
}

/**
 * SET MAIN SUB CATEGORY
 */
if (! function_exists('abe_set_main_sub_category')) {
    function abe_set_main_sub_category($post_id, $cat_id)
    {

        update_field('article_side_main_subcategory', $cat_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $cat_id, $post_id);

    }
}

if (! function_exists('abe_add_link_to_back_issue_date')) {
    function abe_add_link_to_back_issue_date($post_id)
    {

        $back_issue_id = get_field('acf_wp_all_import_edition_date', $post_id);

        if (! empty($back_issue_id)) {
            error_log('+++++backId: '.$back_issue_id);
            $query = new WP_Query([
                'post_type' => 'newspaper',
                'meta_query' => [
                    [
                        'key' => 'acf_wp_all_import_publication_id',
                        'value' => $back_issue_id,
                    ],
                ],
                'posts_per_page' => 1,
            ]);

            if ($query->have_posts()) {
                error_log('@@@@@@@@@@');
                $query->the_post();
                $publication_post_id = get_the_ID();

                update_field('acf_article_newspaper', $publication_post_id, $post_id);

            } else {
                error_log('---nope---');
            }
            wp_reset_query();

        }
    }
}

if (! function_exists('abe_add_link_to_authors')) {
    function abe_add_link_to_authors($articleId)
    {

        $author_name = get_post_meta($articleId, 'acf_wp_all_import_author_name', false);

        // we don't try to split the free form field for authors
        if (! empty($author_name)) {
            $obj_author_by_name = acir_get_non_columnist_by_page_title($authors, 'writer');

            if ($obj_author_by_name == null) {
                // author dosent exist, create new and get ID
                $author_bi_id = wp_insert_post(['post_title' => $author_name[0], 'post_type' => 'writer', 'post_status' => 'publish']);
            } else {
                // author exist
                $author_bi_id = $obj_author_by_name->ID;
            }
            $author_list = [];
            array_push($author_list, $author_bi_id);

            update_field('acf_article_author', $author_list, $articleId);
            update_field('acf_article_author_show', true, $articleId);

            return $obj_author_by_name;
        }

    }
}

if (! function_exists('abe_add_link_to_CPT_authors')) {
    function abe_add_link_to_CPT_authors($post_id)
    {

        /**
         * Article (post) has been created here by WP All Import (nothing to do)
         */

        /**
         * Import Authors (Custom post type)
         */

        //$authors = get_post_meta( $id, 'import_authors_full_name', false);
        $authors = get_post_meta($post_id, 'acf_wp_all_import_author_name', true);
        error_log('AuthorName: '.print_r($authors, true));

        $columnist_id = abe_get_columnist_by_page_title($authors, 'writer');
        error_log('ColumnistID: '.print_r($columnist_id, true));
        if (! empty($columnist_id)) {
            update_field('acf_article_author', $columnist_id, $post_id);

            return $authors;
        } else {
            abe_add_link_to_authors($post_id);
        }

    }
}

if (! function_exists('abe_get_columnist_by_page_title')) {

    function abe_get_columnist_by_page_title($page_title, $post_type = false, $output = OBJECT)
    {
        global $wpdb;

        //Handle specific post type?
        $post_type_where = $post_type ? 'AND post_type = %s' : '';

        //Query all columns so as not to use get_post()
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s $post_type_where AND post_status = 'publish'", $page_title, $post_type ? $post_type : ''));

        if ($results) {
            error_log();
            $output = [];
            foreach ($results as $post) {
                $is_columnist = get_field('acf_author_is_columnist', $post->ID);
                if ($is_columnist) {
                    $output[] = $post->ID;
                }
            }

            return $output;
        }

        return null;
    }
}

if (! function_exists('acir_get_non_columnist_by_page_title')) {

    function acir_get_non_columnist_by_page_title($page_title, $post_type = false, $output = OBJECT)
    {
        global $wpdb;

        //Handle specific post type?
        $post_type_where = $post_type ? 'AND post_type = %s' : '';

        //Query all columns so as not to use get_post()
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s $post_type_where AND post_status = 'publish'", $page_title, $post_type ? $post_type : ''));

        if ($results) {
            error_log();
            $output = [];
            foreach ($results as $post) {
                $is_columnist = get_field('acf_author_is_columnist', $post->ID);
                if (! $is_columnist) {
                    $output[] = $post->ID;
                }
            }

            return $output;
        }

        return null;
    }
}
