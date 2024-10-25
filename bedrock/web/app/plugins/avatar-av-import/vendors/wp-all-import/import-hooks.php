<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('aav_hooks_on_save')) {
    function aav_hooks_on_save($post_id)
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

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'term_'.$post_id);
        }

        if (! isset($actual_import)) {
            $actual_import = get_field('acf_wp_all_import_id', 'user_'.$post_id);
        }

        $import_article = 'import_article';

        /* For import of Articles */
        if (substr($actual_import, 0, strlen($import_article)) === $import_article) {
            // Set article common fields
            aav_set_common_article_fields($post_id);
            aav_add_link_to_authors($post_id);

        } else {

            $main_cat_id = get_field('article_side_main_subcategory', $post_id);
            error_log('MAIN: '.$main_cat_id);
            $category_list = get_field('acf_wp_all_import_categories', $post_id);
            $category_array = explode('|', $category_list);
            foreach ($category_array as $cat_name) {
                error_log($cat_name);
                if ($cat_name == 'Nouvelles') {
                    $cat_id = get_cat_id('Nouvelles');
                }
                if ($cat_name == 'education du partenaire') {
                    $cat_id = get_cat_id('Dossiers');
                }
                if ($cat_name == 'Retraite') {
                    $cat_id = get_cat_id('Accumulation de capital');
                }
                if ($cat_name == 'Avantages sociaux') {
                    $cat_id = get_cat_id('Mieux-être');
                }
                if ($cat_name == 'PME') {
                    $cat_id = get_cat_id('Avantages-sociaux');
                }
                if ($cat_name == 'Nominations') {
                    $cat_id = get_cat_id('Avis');
                }

                error_log(print_r($cat_id, true));
                wp_set_post_categories($post_id, $cat_id, true);
            }
        }

    }
    add_action('pmxi_saved_post', 'aav_hooks_on_save', 10, 1);
}

if (! function_exists('aav_set_common_article_fields')) {
    function aav_set_common_article_fields($post_id)
    {
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category
        $category_list = get_field('acf_wp_all_import_categories', $post_id);
        $category_array = explode('|', $category_list);
        error_log('CATLIST '.$category_list);

        $title = get_the_title($post_id);
        error_log('TITLE '.$title);

        // WARNING The order is important as the priority for the category is Nominations > PME > Nomination (il faut cree toutes les sous-categories)

        if (in_array('Nouvelles', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('nouvelles', $post_id);
        }
        if (in_array('education du partenaire', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('dossiers', $post_id);
        }
        if (in_array('Retraite', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('accumulation-de-capital', $post_id);
        }
        if (in_array('Avantages sociaux', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('mieux-etre', $post_id);
        }
        if (in_array('PME', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('avantages-sociaux', $post_id);
        }
        if (in_array('Nominations', $category_array, true)) {
            $main_sub_category_id = aav_set_sub_category('avis', $post_id);
        }

        if (isset($main_sub_category_id)) {
            update_field('article_side_main_subcategory', $main_sub_category_id, $post_id);
            update_field('_yoast_wpseo_primary_category', $main_sub_category_id, $post_id);
        }

        // Set fields to display
        update_field('acf_article_date_show', true, $post_id);
        update_field('acf_article_category_show', true, $post_id);
        update_field('acf_article_thumbnail_show', true, $post_id);

        $thumbnail_url = get_field('acf_wp_all_import_featured_image', $post_id);
        aav_remove_featured_image_from_article_body($post_id, $thumbnail_url);

        aav_include_html_in_body($post_id);

    }
}

if (! function_exists('aav_include_html_in_body')) {

    function aav_include_html_in_body($post_id)
    {
        $html_to_include = get_field('acf_wp_all_import_html_include', $post_id);
        $html_wp = get_post($post_id)->post_content;
        $html_augmented = str_replace('[bigbox2]', '', str_replace('[bigbox]', '', str_replace('[html-include]', $html_to_include, $html_wp)));

        // Update WP content
        //------------------------
        wp_update_post(
            [
                'ID' => $post_id,
                'post_content' => $html_augmented,
            ]
        );
    }
}

if (! function_exists('aav_set_sub_category')) {

    function aav_set_sub_category($sub_category_slug, $post_id)
    {

        $child = get_category_by_slug($sub_category_slug);
        $child_id = $child->term_id;

        $parent_cat_id = $child->parent; //from your child category, grab parent ID
        wp_set_post_categories($post_id, $child_id, true);

        return $child_id;

    }

}

if (! function_exists('aav_add_link_to_authors')) {
    function aav_add_link_to_authors($articleId)
    {

        $author_name = get_post_meta($articleId, 'acf_wp_all_import_author_name', false);
        error_log('..... '.print_r($author_name, true));
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

            update_field('acf_article_author', $author_list, $articleId);
            update_field('acf_article_author_show', true, $articleId);
        }

    }
}

if (! function_exists('aav_add_link_to_brand')) {
    function aav_add_link_to_brand($articleId)
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

if (! function_exists('aav_add_brightcove')) {
    function aav_add_brightcove($articleId)
    {
        $brightcoveId = get_post_meta($articleId, 'acf_wp_all_import_asset_id', true);

        if (isset($brightcoveId)) {
            update_field('acf_article_video', $brightcoveId, $articleId);
            update_field('acf_article_video_show', true, $articleId);
        }
    }
}

if (! function_exists('aav_set_author')) {
    function aav_set_author($articleId, $authorName)
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
if (! function_exists('aav_adjust_web_user')) {

    function aav_adjust_web_user($user_id)
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

if (! function_exists('aav_remove_featured_image_from_article_body')) {
    function aav_remove_featured_image_from_article_body($post_id, $thumbnail_url)
    {

        // Get all Content that was just saved
        $html_wp = get_post($post_id)->post_content;

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        //aav_remove_all_attributes($doc);

        $imgs_extracted = $doc->getElementsByTagName('img');

        // Check if we have images
        if ($imgs_extracted->length > 0) {
            // Extract images
            $img_in_body_url = $imgs_extracted[0]->getAttribute('src');

            if (! (strpos($img_in_body_url, '?') === false)) {
                $img_in_body_url = substr($img_in_body_url, 0, strpos($img_in_body_url, '?'));
            }
            error_log('-- '.$img_in_body_url);

            if (aav_is_same_image($thumbnail_url, $img_in_body_url)) {
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

            }

        }

    }

}

if (! function_exists('aav_is_same_image')) {
    function aav_is_same_image($thumbnail_url, $img_in_body_url)
    {

        $thumbnail_name = explode('.', $thumbnail_url)[0];
        $img_in_body_name = explode('.', $img_in_body_url)[0];

        if ($thumbnail_name == $img_in_body_name || substr($img_in_body_name, 0, strlen($thumbnail_name)) === $thumbnail_name) {
            return true;
        }

    }
}

if (! function_exists('aav_remove_all_attributes')) {
    function aav_remove_all_attributes(DOMNode $domNode)
    {
        foreach ($domNode->childNodes as $node) {

            $attributes = $node->attributes;
            while ($attributes->length) {
                $node->removeAttribute($attributes->item(0)->name);
            }
            if ($node->hasChildNodes()) {
                aav_remove_all_attributes($node);
            }
        }
    }
}

/**
 * SET MAIN SUB CATEGORY
 */
if (! function_exists('aav_set_main_sub_category')) {
    function aav_set_main_sub_category($post_id, $cat_id)
    {

        update_field('article_side_main_subcategory', $cat_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $cat_id, $post_id);

    }
}
