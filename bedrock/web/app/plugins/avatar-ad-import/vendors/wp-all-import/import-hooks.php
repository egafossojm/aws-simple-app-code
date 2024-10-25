<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('aad_hooks_on_save')) {
    function aad_hooks_on_save($post_id)
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
        error_log('@@@@@@@@@@@@@@');
        $actual_import = get_field('acf_wp_all_import_id', $post_id);
        error_log('---ActualImport: '.$actual_import);
        if (isset($actual_import) && $actual_import == 'update_date_only') {
            error_log('PostId: '.$post_id.' ActionStepTitle: '.print_r(get_sub_field('acf_action_step_article_title', $post_id), true).' ### '.print_r(get_sub_field('acf_article_action_step_advisor_to_client', $post_id), true));

            return;
        }
        $categories_list_string = get_field('acf_wp_all_import_categories', $post_id);
        error_log('&&'.print_r($categories_list_string, true));
        if (strpos($categories_list_string, 'My Practice') !== false || strpos($categories_list_string, 'My practice') !== false) {
            error_log('****************practice');

            if (strpos($categories_list_string, 'Technology') !== false) {
                $child_id = get_cat_id('Technology');
            } else {
                $child_id = get_cat_id('Conversations');
            }

            $child = get_category($child_id); //firstly, load data for your child category
            $parent_cat_id = $child->parent; //from your child category, grab parent ID
            wp_set_post_categories($post_id, [$child_id, $parent_cat_id], true);
            //            wp_set_post_categories($post_id,get_cat_id('Practice'), true);
            //            wp_set_post_categories($post_id,get_cat_id('Conversations'), true);
        }

        // If we lose the main category, rerun the import with import id = update_main_category_only
        if (isset($actual_import) && $actual_import == 'update_main_category_only') {
            $main_cat_id_old = get_field('import_wp_all_import_main_sub_category', $post_id);
            error_log('---CAT: '.$main_cat_id_old);
            $category_id = aad_get_main_cat_id($main_cat_id_old, $actual_import);
            update_field('article_side_main_subcategory', $category_id, $post_id);
            update_field('_yoast_wpseo_primary_category', $category_id, $post_id);

            return;
        }

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'term_'.$post_id);
        }

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'user_'.$post_id);
        }
        error_log('--IMPORT  '.$actual_import);

        $import_article = 'import_article';

        /* For import of Articles */
        if (substr($actual_import, 0, strlen($import_article)) === $import_article) {
            // Set main sub category
            error_log('  article common fields');
            aad_set_article_main_sub_category($post_id, $actual_import);

            // Authors

            aad_add_link_to_authors($post_id);

        } elseif ($actual_import == 'import_podcast') {
            //set main sub catgory
            aad_set_podcast_main_sub_category($post_id);
            //aad_add_link_to_authors($post_id);
            aad_add_link_to_related_audio($post_id);
            aad_add_link_to_related_article($post_id);

        } elseif ($actual_import == 'import_authors') {
            aad_add_link_to_authors($post_id);
        } elseif ($actual_import == 'import_web_users') {
            aad_adjust_web_user($post_id);
        } elseif ($actual_import == 'authors') {
            aad_set_ACF_author_column($post_id);
        } elseif ($actual_import == 'aad_link_to_columnist') {
            aad_link_to_columnist_and_set_main_sub_cat($post_id);
            error_log('---out');
        } elseif ($actual_import == 'aad_set_ACF_author_fund') {
            aad_set_ACF_author_fund($post_id);
        }

        //aad_get_img_from_content($post_id);

    }
    add_action('pmxi_saved_post', 'aad_hooks_on_save', 10, 1);
}

if (! function_exists('aad_add_link_to_related_article')) {

    function aad_add_link_to_related_article($post_id)
    {

        $related_article_url = get_field('acf_wp_all_import_related_article_podcast', $post_id);
        error_log('RELATED: '.$related_article_url);
        if (preg_match('/[=\-]([0-9]+)$/', $related_article_url, $matches)) {
            $articleId = $matches[1];
            error_log('AssetID: '.$articleId);
            $query = new WP_Query([
                'meta_query' => [
                    [
                        'key' => 'acf_wp_all_import_asset_id',
                        'value' => [$articleId],
                    ],
                ],
                'posts_per_page' => 1,
            ]);

            if ($query->have_posts()) {
                error_log('Found article');
                $query->the_post();
                $article_post_id = get_the_ID();
                error_log('RelatedId: '.$article_post_id);
                update_field('acf_podcast_related_article', $article_post_id, $post_id);

            }
            wp_reset_query();
        }
    }

    //sub catgory
}

if (! function_exists('aad_add_link_to_related_audio')) {

    function aad_add_link_to_related_audio($post_id)
    {
        error_log('#################');
        $related_url = get_field('acf_wp_all_import_audio_related', $post_id);
        error_log($related_url);
        if (preg_match('/[=\-]([0-9]+)$/', $related_url, $matches)) {
            $asset_id = $matches[1];

            $query = new WP_Query([
                'meta_query' => [
                    [
                        'key' => 'acf_wp_all_import_asset_id',
                        'value' => [$asset_id],
                    ],
                ],
                'posts_per_page' => 1,
            ]);

            if ($query->have_posts()) {
                error_log('**has post);');
                $query->the_post();
                $related_article_post_id = get_the_ID();

                update_field('acf_audio_related_article', $post_id, $related_article_post_id);

            } else {
                error_log('** no POST');
            }
            wp_reset_query();

        }

    }
}
/**
 * COLUMNS
 */
if (! function_exists('aad_set_ACF_author_column')) {
    function aad_set_ACF_author_column($post_id)
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

if (! function_exists('aad_set_ACF_author_fund')) {
    function aad_set_ACF_author_fund($post_id)
    {
        $title = get_the_title($post_id);
        $fund_name_list = get_field('acf_wp_all_import_fund_list', $post_id);

        wp_delete_post($post_id, true);

        error_log('Author: '.$title);
        error_log('Fund: '.$fund_name_list);

        $obj_author_by_name = get_page_by_title($title, 'OBJECT', 'writer');
        error_log('AuthorId: '.$obj_author_by_name->ID);
        error_log(print_r($obj_author_by_name, true));

        $fund_name_array = explode(',', $fund_name_list);

        $fund_term_list = [];

        foreach ($fund_name_array as $fund_name) {

            $term = get_term_by('name', $fund_name, 'post_fund');
            error_log('!'.print_r($term, true));
            if (! empty($term)) {
                array_push($fund_term_list, $term->term_id);
                error_log('TermId: '.$term->term_id);
            }
        }
        update_field('acf_author_is_speaker', true, $obj_author_by_name->ID);
        update_field('acf_author_fund', $fund_term_list, $obj_author_by_name->ID);

    }
}

if (! function_exists('aad_set_podcast_main_sub_category')) {
    function aad_set_podcast_main_sub_category($post_id)
    {

        error_log('------------');
        //update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category
        $main_cat_name = get_field('import_wp_all_import_main_sub_category', $post_id);
        if (empty($main_cat_name)) {
            error_log('EMPTY');
            $main_cat_name = 'Economy';
            wp_set_post_categories($post_id, get_cat_id($main_cat_name), true);
        }
        error_log('CAT_NAME: '.$main_cat_name);
        $category_id = get_cat_id($main_cat_name);
        error_log('CAT_ID: '.$category_id);
        update_field('article_side_main_subcategory', $category_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $category_id, $post_id);

        error_log('^^^^^^^^^^^^'.print_r(wp_get_post_categories($post_id), true));
        // Set fields to display
        update_field('acf_article_date_show', true, $post_id);
        update_field('acf_article_category_show', true, $post_id);
        update_field('acf_article_thumbnail_show', false, $post_id);

    }
}

if (! function_exists('aad_set_article_main_sub_category')) {
    function aad_set_article_main_sub_category($post_id, $actual_import)
    {

        // Set the main sub-category
        $main_cat_id_old = get_field('import_wp_all_import_main_sub_category', $post_id);
        error_log('CAT: '.$main_cat_id_old);
        $category_id = aad_get_main_cat_id($main_cat_id_old, $actual_import);

        update_field('article_side_main_subcategory', $category_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $category_id, $post_id);

        // Set fields to display
        update_field('acf_article_date_show', true, $post_id);
        update_field('acf_article_category_show', true, $post_id);
        update_field('acf_article_thumbnail_show', true, $post_id);

        aad_add_featured_image($post_id);
    }
}

if (! function_exists('aad_get_main_cat_id')) {

    function aad_get_main_cat_id($main_cat_id, $actual_import)
    {

        error_log('***ACTUAL IMPORT: '.$actual_import);

        if ($actual_import == 'import_article_advisor_to_client') {
            switch ($main_cat_id) {
                case 2:
                    $main_cat = 'Financial Planning';
                    break;
                case 3:
                    $main_cat = 'Investing';
                    break;
                case 4:
                    $main_cat = 'Tax';
                    $category = get_category_by_slug('tax-advisor-to-client');
                    error_log('TAX: '.print_r($category->term_id, true));

                    return $category->term_id;
                    break;
                case 5:
                    $main_cat = 'Risk Management';
                    break;
                default:
                    break;

            }
        } else {

            switch ($main_cat_id) {
                case 4:
                    $main_cat = 'Economic';
                    break;
                case 5:
                    $main_cat = 'Industry News';
                    break;
                case 6:
                    $main_cat = 'ETFs';
                    break;
                case 8:
                    $main_cat = 'Conversations';
                    break;
                case 10:
                    $main_cat = 'Market Insights';
                    break;
                case 11:
                    $main_cat = 'Alternative Investments';
                    break;
                case 13:
                    $main_cat = 'Tax News';
                    break;
                case 14:
                    $main_cat = 'Estate Planning';
                    break;
                case 16:
                    $main_cat = 'Life';
                    break;
                case 17:
                    $main_cat = 'Living Benefits';
                    break;
                case 18:
                    $main_cat = 'Special Reports';
                    break;
                case 1205:
                    $main_cat = 'Your Clients';
                    break;
                case 1206:
                    $main_cat = 'Your Practice';
                    break;
                case 1207:
                    $main_cat = 'Your Inspiration';
                    break;
                case 1255:
                    $main_cat = 'Retirement';
                    break;
                case 1279:
                    $main_cat = 'Retirement Case Studies';
                    break;
                case 1280:
                    $main_cat = 'Retirement Hot Topics';
                    break;
                case 1281:
                    $main_cat = 'Retirement News';
                    break;
                case 1287:
                    $main_cat = 'Retirement Expert Opinion';
                    break;
                case 1289:
                    $main_cat = 'A Global View';
                    break;
                case 1209:
                    $main_cat = 'Technology';
                    break;
                case 1294:
                    $main_cat = 'Expert opinions';
                    break;
                case 1295:
                    $main_cat = 'Insurance';
                    break;
                case 1296:
                    $main_cat = 'Investments and income';
                    break;
                case 1297:
                    $main_cat = 'Tax and estate planning';
                    break;
                case 1298:
                    $main_cat = 'Market Insights';
                    break;
                case 1299:
                    $main_cat = 'Life events';
                    break;
                case 1227:
                    $main_cat = 'Continuing Education';
                    break;
                default:
                    $main_cat = 'Uncategorized';
                    break;
            }
        }
        error_log('MAIN CAT: '.$main_cat);
        $cat_id = get_cat_id($main_cat);
        error_log('MAIN CAT ID: '.$cat_id);

        return $cat_id;
    }
}

if (! function_exists('update_ACF_action_steps')) {
    function update_ACF_action_steps($post_id)
    {
        if (get_field('acf_market_watch', $post_id)) {

            while (has_sub_field('acf_market_watch', $post_id)) {
                $marketName = get_sub_field('acf_market_entity_name', $post_id);
                $marketValue = (float) get_sub_field('acf_market_entity_value', $post_id);
                $marketVariation = (float) get_sub_field('acf_market_entity_variation', $post_id);
                if ($marketName == 'NASDAQ Composite') {
                    //set to NASDAQ only
                    update_sub_field('acf_market_entity_name', 'NASDAQ', $post_id);
                }
                if ($marketName == 'Canadian Dollar/U.S. Dollar') {
                    update_sub_field('acf_market_entity_name', 'Dollars (US)', $post_id);
                    update_sub_field('acf_market_entity_variation', number_format(round($marketVariation, 4), 4), $post_id);
                    update_sub_field('acf_market_entity_value', number_format(round($marketValue, 4), 4), $post_id);
                } else {
                    update_sub_field('acf_market_entity_variation', number_format(round($marketVariation, 2), 2), $post_id);
                    update_sub_field('acf_market_entity_value', number_format(round($marketValue, 2), 2), $post_id);
                }

                if ($marketVariation > 0) {
                    //set direction to Equal
                    update_sub_field('acf_market_entity_direction', 'up', $post_id);
                } elseif ($marketVariation < 0) {
                    //set direction to Up
                    update_sub_field('acf_market_entity_direction', 'down', $post_id);
                } else {
                    //set direction to Down
                    update_sub_field('acf_market_entity_direction', 'equal', $post_id);
                }

            }
        }
    }
}

if (! function_exists('aad_add_link_to_authors')) {
    function aad_add_link_to_authors($post_id)
    {

        $author_name = get_post_meta($post_id, 'acf_wp_all_import_author_name', false);
        error_log('AUTHORS..... '.print_r($author_name, true));
        // we don't try to split the free form field for authors
        if (! empty($author_name)) {
            $obj_author_by_name = get_page_by_title($author_name[0], 'OBJECT', 'writer');

            if ($obj_author_by_name == null) {
                // author dosent exist, create new and get ID
                $author_bi_id = wp_insert_post(['post_title' => $author_name[0], 'post_type' => 'writer', 'post_status' => 'publish']);
            } else {
                // author exist
                $author_bi_id = $obj_author_by_name->ID;
            }
            $author_list = [];
            array_push($author_list, $author_bi_id);

            error_log('AUTHORS Array: '.print_r($author_list, true));
            update_field('acf_article_author', $author_list, $post_id);
            update_field('acf_article_author_show', true, $post_id);
        }

    }
}

if (! function_exists('aad_get_columnist_by_page_title')) {

    function aad_get_columnist_by_page_title($page_title, $post_type = false, $output = OBJECT)
    {
        global $wpdb;

        //Handle specific post type?
        $post_type_where = $post_type ? 'AND post_type = %s' : '';

        //Query all columns so as not to use get_post()
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s $post_type_where AND post_status = 'publish'", $page_title, $post_type ? $post_type : ''));

        if ($results) {
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

if (! function_exists('aad_link_to_columnist_and_set_main_sub_cat')) {
    function aad_link_to_columnist_and_set_main_sub_cat($post_id)
    {

        $author_name = get_post_meta($post_id, 'acf_wp_all_import_author_name', true);
        $result = aad_get_columnist_by_page_title($author_name);
        error_log('!!!'.print_r($result, true));
        if (! empty($result)) {
            update_field('acf_article_author', $result, $post_id);
        }

        $parent_cat_name = 'Columnists';
        wp_set_post_categories($post_id, get_cat_id($parent_cat_name), true);

        $sub_cat_id = get_cat_ID($author_name);
        wp_set_post_categories($post_id, $sub_cat_id, true);
        error_log('---CAT: '.$sub_cat_id);
        update_field('article_side_main_subcategory', $sub_cat_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $sub_cat_id, $post_id);
    }
}

if (! function_exists('aad_add_link_to_brand')) {
    function aad_add_link_to_brand($articleId)
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

if (! function_exists('aad_add_brightcove')) {
    function aad_add_brightcove($articleId)
    {
        $brightcoveId = get_post_meta($articleId, 'acf_wp_all_import_asset_id', true);

        if (isset($brightcoveId)) {
            update_field('acf_article_video', $brightcoveId, $articleId);
            update_field('acf_article_video_show', true, $articleId);
        }
    }
}

if (! function_exists('aad_set_author')) {
    function aad_set_author($articleId, $authorName)
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
if (! function_exists('aad_adjust_web_user')) {

    function aad_adjust_web_user($user_id)
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

if (! function_exists('aad_add_featured_image')) {
    function aad_add_featured_image($post_id)
    {

        $featuredImage_url = get_field('acf_wp_all_import_featured_image', $post_id);
        $extension = image_type_to_extension(getimagesize($featuredImage_url)[2]);
        $upload_dir = wp_upload_dir();
        $filename = sanitize_file_name(basename($featuredImage_url.$extension));

        $prod_url = 'http://www'.substr($featuredImage_url, 16);
        error_log($prod_url);
        $image_data = file_get_contents($prod_url);

        if ($image_data === false) {
            error_log('---Not data found');
        } else {
            error_log('---Found');
        }
        // Create upload folder if doesnt exist
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'].'/'.$filename;
        } else {
            $file = $upload_dir['basedir'].'/'.$filename;
        }

        // Check if file exists before upload
        if (! file_exists($file)) {
            file_put_contents($file, $image_data);
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

    }
}

if (! function_exists('aad_remove_all_attributes')) {
    function aad_remove_all_attributes(DOMNode $domNode)
    {
        foreach ($domNode->childNodes as $node) {

            $attributes = $node->attributes;
            while ($attributes->length) {
                $node->removeAttribute($attributes->item(0)->name);
            }
            if ($node->hasChildNodes()) {
                aad_remove_all_attributes($node);
            }
        }
    }
}
