<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('aco_hooks_on_save')) {
    function aco_hooks_on_save($post_id)
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

        error_log('CO IMPORT: '.$actual_import.' POST_Id: '.$post_id);

        /* For import of Articles */
        if (substr($actual_import, 0, strlen($import_article)) === $import_article) {
            // Set article common fields
            aco_set_common_article_fields($post_id, $actual_import);
            aco_add_link_to_authors($post_id);

        } elseif ($actual_import == 'aco_add_featured_image') {
            aco_add_featured_image($post_id);
        } elseif ($actual_import == 'import_web_users') {
            aco_adjust_web_user($post_id);
        } elseif ($actual_import == 'authors') {
            aco_set_ACF_author_column($post_id);
        } elseif ($actual_import == 'inside_track') {
            aco_add_link_to_CPT_authors($post_id);
        } elseif ($actual_import == 'aco_link_to_columnist') {
            aco_link_to_columnist_and_set_main_sub_cat($post_id);
            error_log('---out');
        } elseif ($actual_import == 'import_podcast') {
            //set main sub catgory acf_podcast_related_article    acf_wp_all_import_related_article_podcast
            aco_set_podcast_main_sub_category($post_id);
            aco_add_link_to_authors($post_id);
            aco_add_link_to_related_article($post_id);

        } elseif ($actual_import == 'import_authors') {
            aco_add_link_to_authors($post_id);
        } elseif ($actual_import == 'import_dossiers') {
            aco_extract_elements_from_content($post_id);
        } elseif ($actual_import == 'aco_set_ACF_author_fund') {
            aco_set_ACF_author_fund($post_id);
        }

        //aco_get_img_from_content($post_id);

    }
    add_action('pmxi_saved_post', 'aco_hooks_on_save', 10, 1);
}

if (! function_exists('aco_set_ACF_author_fund')) {
    function aco_set_ACF_author_fund($post_id)
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

if (! function_exists('aco_add_link_to_related_article')) {

    function aco_add_link_to_related_article($post_id)
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

if (! function_exists('aco_extract_elements_from_content')) {

    function aco_extract_elements_from_content($post_id)
    {
        //prod
        $category_id = 21071;
        $dossier_page_id = 59785;

        //stg
        //$category_id = 15935;
        //$dossier_page_id = 61252;

        update_field('acf_feature_parent_sub_category', $dossier_page_id, $post_id);

        update_field('article_side_main_subcategory', $category_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $category_id, $post_id);

        $html = get_post($post_id)->post_content;

        $auto_loaded = spl_autoload_register(['HTMLPurifier_Bootstrap', 'autoload']);
        $config = HTMLPurifier_Config::createDefault();
        $config->set('AutoFormat.RemoveEmpty', false); // remove empty elements
        $config->set('HTML.Doctype', 'XHTML 1.0 Strict'); // valid XML output (?)
        $config->set('HTML.AllowedElements', ['p', 'div', 'a', 'br', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'ul', 'ol', 'li', 'b', 'i']);
        $config->set('HTML.AllowedAttributes', ['a.href']); // remove all attributes except a.href
        $config->set('CSS.AllowedProperties', []); // remove all CSS

        $purifier = new HTMLPurifier($config);

        $html_wp = $purifier->purify($html);
        //error_log('++++'.print_r($html_wp,true));

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        $lis_extracted = $doc->getElementsByTagName('a');

        error_log('TITLE: '.get_post($post_id)->post_title);
        $articleIds = [];
        $node_array = [];
        //error_log(print_r($lis_extracted, true));
        foreach ($lis_extracted as $li_element) {
            error_log('**'.print_r($li_element, true));
            //if ($li_element->hasChildNodes()) {
            //foreach ($li_element->childNodes as $childNode) {
            //error_log('@@@@@'.print_r($childNode,true));
            //if ($childNode->tagName == 'a') {
            $attributes = $li_element->attributes;
            //error_log('attr '.print_r($attributes, true));
            if (isset($attributes) && count($attributes) > 0) {
                foreach ($attributes as $attribute) {
                    //error_log('^^^'.print_r($attribute, true));
                    if ($attribute->name == 'href') {
                        $value = $attribute->value;
                        error_log('VAL: '.print_r($value, true));
                        if (preg_match('/[=\-]([0-9]+)$/', $value, $matches)) {
                            array_push($articleIds, $matches[1]);
                            array_push($node_array, $li_element);
                            //$li_element->parentNode->removeChild($li_element);
                            //error_log('*** Remove: ' . print_r($value, true));
                        }

                    }
                }
            }

            //}
            // }
            //}

        }
        error_log('-----Asset Ids: '.print_r($articleIds, true));
        foreach ($articleIds as $articleId) {
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

                $query->the_post();
                $article_post_id = get_the_ID();

                //error_log('+++ArticlePostId: ' . $article_post_id);
                // Update article's feature
                update_field('acf_article_feature', $post_id, $article_post_id);

                // Update article type
                update_field('acf_article_type', 'feature', $article_post_id);

            }
            wp_reset_query();
        }

        //        $uls = $doc->getElementsByTagName('ul');
        //        foreach ($uls as $ul) {
        //            $ul->parentNode->removeChild($ul);
        //        }

        foreach ($node_array as $node) {
            $node->parentNode->removeChild($node);
        }
        $wp_content = $doc->saveHTML();
        //error_log('Content: '. print_r($wp_content,true));
        // 5- Update WP content
        //------------------------
        wp_update_post(
            [
                'ID' => $post_id,
                'post_content' => $wp_content,
            ]
        );

        error_log('-------------------------------------');

    }

}

if (! function_exists('aco_set_podcast_main_sub_category')) {
    function aco_set_podcast_main_sub_category($post_id)
    {

        error_log('------------');
        //update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category
        $main_cat_name = get_field('import_wp_all_import_main_sub_category', $post_id);
        if (empty($main_cat_name)) {
            error_log('EMPTY');
            $category = get_category_by_slug('autres-gestionnaires-en-direct');
            error_log(print_r($category, true));
            $category_id = $category->term_id;
            wp_set_post_categories($post_id, $category_id, true);
        } else {
            error_log('CAT_NAME: '.$main_cat_name);
            $category_id = get_cat_id($main_cat_name);
        }

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

if (! function_exists('aco_link_to_columnist_and_set_main_sub_cat')) {
    function aco_link_to_columnist_and_set_main_sub_cat($post_id)
    {

        $author_name = get_post_meta($post_id, 'acf_wp_all_import_author_name', true);
        error_log('AuthorName: '.$author_name);
        $result = aco_get_columnist_by_page_title($author_name);
        error_log('!!!'.print_r($result, true));
        if (! empty($result)) {
            update_field('acf_article_author', $result, $post_id);
        }

        //$parent_cat_name = 'Blogues';
        //wp_set_post_categories($post_id,get_cat_id($parent_cat_name), true);

        $sub_cat_id = get_cat_ID($author_name);
        wp_set_post_categories($post_id, $sub_cat_id, true);
        error_log('---CAT: '.$sub_cat_id);
        update_field('article_side_main_subcategory', $sub_cat_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $sub_cat_id, $post_id);
    }
}

if (! function_exists('aco_get_columnist_by_page_title')) {

    function aco_get_columnist_by_page_title($page_title, $post_type = false, $output = OBJECT)
    {
        global $wpdb;

        //Handle specific post type?
        $post_type_where = $post_type ? 'AND post_type = %s' : '';

        //Query all columns so as not to use get_post()
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s $post_type_where AND post_status = 'publish'", $page_title, $post_type ? $post_type : ''));

        error_log(print_r($results, true));
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

if (! function_exists('aco_set_common_article_fields')) {
    function aco_set_common_article_fields($post_id, $actual_import)
    {
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        // Set the main sub-category
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        $thumbnail_url = get_field('acf_wp_all_import_featured_image', $post_id);
        aco_remove_featured_image_from_article_body($post_id, $thumbnail_url);
        aco_include_html_in_body($post_id);

        // Set the main sub-category
        $category_list = get_field('acf_wp_all_import_categories', $post_id);

        $category_array = explode('|', $category_list);

        error_log('CATLIST: '.$category_list);
        // WARNING The order is important as the priority for the category is Nouvelles > Ma pratique > Produit

        if ($actual_import == 'import_article_pme') {
            $main_sub_category_id = aco_category_name_to_id_pme($category_array, $post_id);
        } elseif ($actual_import == 'import_article_sun_life') {
            $query = 'Retraite-Sunlife';
            foreach ($category_array as $parent_sub) {
                if (substr($parent_sub, 0, strlen($query)) === $query) {
                    $parent_cat_array = explode('>', $parent_sub);
                    if (count($parent_cat_array) == 2) {
                        $main_sub_category_id = get_cat_ID($parent_cat_array[1]);
                    }
                }
            }
        } else {
            $main_sub_category_id = aco_category_name_to_id_conseiller($category_array, $post_id);
        }

        if (isset($main_sub_category_id)) {
            error_log('MAIN: '.$main_sub_category_id);
            update_field('article_side_main_subcategory', $main_sub_category_id, $post_id);
            update_field('_yoast_wpseo_primary_category', $main_sub_category_id, $post_id);
        } else {
            error_log('NOT SET');
        }

        // error_log('>>>>>'.print_r(wp_get_post_categories($post_id),true));
        // Set fields to display
        update_field('acf_article_date_show', true, $post_id);
        update_field('acf_article_category_show', true, $post_id);
        update_field('acf_article_thumbnail_show', true, $post_id);

    }
}

if (! function_exists('aco_category_name_to_id_pme')) {

    function aco_category_name_to_id_pme($category_array, $post_id)
    {

        if (in_array("Conseillers d'affaires", $category_array, true)) {
            error_log("Conseillers d'affaires");
            $main_sub_category_id = aco_set_sub_category("Conseillers d'affaires", $post_id);
        }
        if (in_array('Régimes de retraite', $category_array, true)) {
            error_log('Régimes de retraite');
            $main_sub_category_id = aco_set_sub_category('Régimes de retraite', $post_id);
        }
        if (in_array('Avantages sociaux', $category_array, true)) {
            error_log('Avantages sociaux');
            $main_sub_category_id = aco_set_sub_category('Avantages sociaux', $post_id);
        }
        if (in_array('Le coin des experts', $category_array, true)) {
            error_log('Le coin des experts');
            $main_sub_category_id = aco_set_sub_category('Le coin des experts', $post_id);
        }

        if (in_array('Ma pratique', $category_array, true)) {
            error_log('Ma pratique');
            $category = get_category_by_slug('ma-pratique-pme');
            error_log(print_r($category, true));
            $main_sub_category_id = $category->term_id;
            wp_set_post_categories($post_id, $main_sub_category_id, true);
        }
        if (in_array('Nouvelles', $category_array, true)) {
            error_log('Nouvelles');
            $category = get_category_by_slug('nouvelles-pme');
            $main_sub_category_id = $category->term_id;
            wp_set_post_categories($post_id, $main_sub_category_id, true);
            error_log($main_sub_category_id);
        }

        return $main_sub_category_id;
    }
}

if (! function_exists('aco_category_name_to_id_conseiller')) {

    function aco_category_name_to_id_conseiller($category_array, $post_id)
    {

        $title = get_the_title($post_id);

        if (in_array('Produits', $category_array, true)) {

            if (strpos(strtolower($title), 'assurance') !== false) {
                error_log('===Assurance');
                $child_id = get_cat_id('Assurance');
                wp_set_post_categories($post_id, $child_id, true);
                $main_sub_category_id = aco_set_sub_category('Assurance', $post_id);
            } else {
                error_log('===Placement');
                $child_id = get_cat_id('Placement');
                wp_set_post_categories($post_id, $child_id, true);
                $main_sub_category_id = aco_set_sub_category('Placement', $post_id);
            }
        }

        if (in_array('Ma pratique', $category_array, true)) {
            $child_id = get_cat_id('Carrière');
            wp_set_post_categories($post_id, $child_id, true);
            $main_sub_category_id = aco_set_sub_category('Carrière', $post_id);
        }
        if (in_array('Nouvelles', $category_array, true)) {

            if (strpos(strtolower($title), 'fiscalité') !== false) {
                $child_id = get_cat_id('Fiscalité');
                wp_set_post_categories($post_id, $child_id, true);
                $main_sub_category_id = aco_set_sub_category('Fiscalité', $post_id);
            } else {
                $child_id = get_cat_id('Industrie');
                wp_set_post_categories($post_id, $child_id, true);
                $main_sub_category_id = aco_set_sub_category('Industrie', $post_id);
            }

        }
        if (in_array('Audio Conseiller', $category_array, true)) {
            $child_id = get_cat_id('Balados');
            $child = get_category($child_id); //firstly, load data for your child category
            //$parent_cat_id = $child->parent; //from your child category, grab parent ID
            wp_set_post_categories($post_id, $child_id, true);
            //wp_set_post_categories( $post_id, $parent_cat_id, true );
            $main_sub_category_id = aco_set_sub_category('Balados', $post_id);
        }

        return $main_sub_category_id;
    }
}

if (! function_exists('aco_include_html_in_body')) {

    function aco_include_html_in_body($post_id)
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

if (! function_exists('aco_set_sub_category')) {

    function aco_set_sub_category($sub_category_name, $post_id)
    {
        $sub_cat_id = get_cat_ID($sub_category_name);
        if ($sub_cat_id) {
            error_log('ID is : '.$sub_cat_id);
            wp_set_post_categories($post_id, $sub_cat_id, true);
        }

        return $sub_cat_id;

    }

}

if (! function_exists('aco_add_link_to_authors')) {
    function aco_add_link_to_authors($post_id)
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

if (! function_exists('aco_select_author')) {

    function aco_select_author($post_id_in)
    {

        $asset_id = get_field('acf_wp_all_import_asset_id', $post_id_in);
        //error_log('ASSET ID: ' . $asset_id);
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
            error_log('Found article');
            $query->the_post();
            $post_id = get_the_ID();

            $authors = get_field('acf_article_author', $post_id);

            if (is_array($authors)) {
                foreach ($authors as $author) {
                    $arr_authors_id_register = aco_get_selected_author($author->post_title, 'writer');
                    //error_log(print_r($arr_authors_id_register, true));
                }
            } else {
                error_log('----NOT AN author------');
            }

        } else {
            error_log('----No Post Found-----');
        }
        wp_reset_query();

    }
}

if (! function_exists('aco_get_selected_author')) {

    function aco_get_selected_author($page_title, $post_type)
    {
        global $wpdb;

        //Handle specific post type?
        $post_type_where = $post_type ? 'AND post_type = %s' : '';

        //Query all columns so as not to use get_post()
        $results = $wpdb->get_results($wpdb->prepare("SELECT id FROM $wpdb->posts WHERE post_title = %s $post_type_where AND post_status = 'publish'", $page_title, $post_type ? $post_type : ''));

        if ($results) {
            $output = [];
            foreach ($results as $post) {

                $is_columnist = get_field('acf_author_is_columnist');
                $is_speaker = get_field('acf_author_is_speaker');
                $rank = 0;
                if ($is_columnist) {
                    $rank++;
                }
                if ($is_speaker) {
                    $rank++;
                }
                $object = (object) ['id' => $post->id, 'columnist' => $is_columnist, 'speaker' => $is_speaker, 'rank' => $rank];
                array_push($output, $object);
            }

            if (count($output) > 1) {
                error_log(print_r($output, true));
                error_log('--------------------------------');
            }

            return $output;
        }

        return null;
    }
}

if (! function_exists('aco_add_link_to_brand')) {
    function aco_add_link_to_brand($articleId)
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

if (! function_exists('aco_add_brightcove')) {
    function aco_add_brightcove($articleId)
    {
        $brightcoveId = get_post_meta($articleId, 'acf_wp_all_import_asset_id', true);

        if (isset($brightcoveId)) {
            update_field('acf_article_video', $brightcoveId, $articleId);
            update_field('acf_article_video_show', true, $articleId);
        }
    }
}

if (! function_exists('aco_set_author')) {
    function aco_set_author($articleId, $authorName)
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
if (! function_exists('aco_adjust_web_user')) {

    function aco_adjust_web_user($user_id)
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

if (! function_exists('aco_remove_featured_image_from_article_body')) {
    function aco_remove_featured_image_from_article_body($post_id, $thumbnail_url)
    {

        error_log('++ '.$thumbnail_url);

        // Get all Content that was just saved
        $html_wp = get_post($post_id)->post_content;

        // Transform to DOM based document
        $doc = new DOMDocument('1.0', 'UTF-8');
        $fragment = $doc->createDocumentFragment();
        $fragment->appendXML($html_wp);
        $doc->appendChild($fragment);

        //aco_remove_all_attributes($doc);

        $imgs_extracted = $doc->getElementsByTagName('img');

        // Check if we have images
        if ($imgs_extracted->length > 0) {
            // Extract images
            $img_in_body_url = $imgs_extracted[0]->getAttribute('src');

            if (! (strpos($img_in_body_url, '?') === false)) {
                $img_in_body_url = substr($img_in_body_url, 0, strpos($img_in_body_url, '?'));
            }
            error_log('-- '.$img_in_body_url);

            if (aco_is_same_image($thumbnail_url, $img_in_body_url)) {
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

if (! function_exists('aco_is_same_image')) {
    function aco_is_same_image($thumbnail_url, $img_in_body_url)
    {

        $thumbnail_name = explode('.', $thumbnail_url)[0];
        $img_in_body_name = explode('.', $img_in_body_url)[0];

        if ($thumbnail_name == $img_in_body_name || substr($img_in_body_name, 0, strlen($thumbnail_name)) === $thumbnail_name) {
            return true;
        }

    }
}

if (! function_exists('aco_remove_all_attributes')) {
    function aco_remove_all_attributes(DOMNode $domNode)
    {
        foreach ($domNode->childNodes as $node) {

            $attributes = $node->attributes;
            while ($attributes->length) {
                $node->removeAttribute($attributes->item(0)->name);
            }
            if ($node->hasChildNodes()) {
                aco_remove_all_attributes($node);
            }
        }
    }
}

/**
 * SET MAIN SUB CATEGORY
 */
if (! function_exists('aco_set_main_sub_category')) {
    function aco_set_main_sub_category($post_id, $cat_id)
    {

        update_field('article_side_main_subcategory', $cat_id, $post_id);
        update_field('_yoast_wpseo_primary_category', $cat_id, $post_id);

    }
}

/**
 * COLUMNS
 */
if (! function_exists('aco_set_ACF_author_column')) {
    function aco_set_ACF_author_column($post_id)
    {

        $column_and_author = get_the_title($post_id);
        error_log('Author|Column: '.$column_and_author);
        $array_col_author = explode('|', $column_and_author);

        switch (count($array_col_author)) {
            case 1:
                $author_name = $array_col_author[0];
                break;
            case 2:
                $author_name = $array_col_author[1];
                $columnName = $array_col_author[0];
                break;
            default:
                return;
        }

        $my_post = [
            'ID' => $post_id,
            'post_title' => $author_name,
        ];

        // Update the post into the database
        wp_update_post($my_post);

        if (isset($columnName)) {
            $term = get_term_by('name', $columnName, 'post_column');

            if (! empty($term)) {
                update_field('acf_author_column', $term->term_id, $post_id);
            } else {
                $term_ids = wp_insert_term($columnName, 'post_column');
                $term_id = $term_ids['term_id'];
                if (isset($term_id)) {
                    update_field('acf_author_column', $term_id, $post_id);
                }
            }
        }

    }
}

/**
 * WRITER (AUTHORS)
 */
if (! function_exists('aco_add_link_to_CPT_authors')) {
    function aco_add_link_to_CPT_authors($post_id)
    {

        /**
         * Article (post) has been created here by WP All Import (nothing to do)
         */

        /**
         * Import Authors (Custom post type)
         */

        //$authors = get_post_meta( $id, 'import_authors_full_name', false);
        $authors = get_post_meta($post_id, 'acf_wp_all_import_author_name', false);
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($post_id), $post_id);

        if (isset($authors)) {
            $authors_name_register_array = explode(',', $authors[0]);

            foreach ($authors_name_register_array as $author_title) {

                $obj_authors_id_register = get_page_by_title($author_title, 'OBJECT', 'writer');

                $authors_first_and_last_name_array = explode(' ', $author_title);
                $firstName = array_shift($authors_first_and_last_name_array);
                $lastName = implode(' ', $authors_first_and_last_name_array);

                if (! isset($obj_authors_id_register)) {
                    /* Create the author if it doesn't already exist */
                    $autherId = wp_insert_post(['post_title' => $author_title, 'post_type' => 'writer', 'post_status' => 'publish']);
                    update_field('acf_article_author', [$autherId], $post_id);
                    update_field('acf_author_first_name', $firstName, $autherId);
                    update_field('acf_author_last_name', $lastName, $autherId);
                } else {

                    update_field('acf_article_author', [$obj_authors_id_register->ID], $post_id);
                    update_field('acf_author_first_name', $firstName, $obj_authors_id_register->ID);
                    update_field('acf_author_last_name', $lastName, $obj_authors_id_register->ID);
                }

                //get_field('acf_article_author_show', $id)
                update_field('acf_article_author_show', true, $post_id);
                update_field('acf_article_date_show', true, $post_id);
                update_field('acf_article_category_show', true, $post_id);
                update_field('acf_article_thumbnail_show', true, $post_id);
            }
        }

        $main_sub_categorie = get_field('import_wp_all_import_main_sub_category', $post_id);
        $main_sub_category_id = aco_set_sub_category($main_sub_categorie, $post_id);
        update_field('article_side_main_subcategory', $main_sub_category_id, $post_id);
    }
}

if (! function_exists('aco_add_featured_image')) {
    function aco_add_featured_image($post_id)
    {

        $featuredImage_url = get_field('acf_wp_all_import_featured_image', $post_id);
        //error_log('URL: ' . $featuredImage_url);

        if (strpos($featuredImage_url, '800x600') == false) {
            $prod_url = preg_replace('/-[0-9][0-9[0-9]x[0-9][0-9][0-9]\.jpg$/', '.jpg', $featuredImage_url);
        } else {
            $prod_url = preg_replace('/800x600.*\.jpg$/', '800x600.jpg', $featuredImage_url);
        }

        $size = getimagesize($prod_url);

        if (! (is_array($size) && count($size) > 1 && $size[0] > 798 && $size[1] > 558)) {
            //error_log(print_r($size, true));
            //error_log('isArray: ' . is_array($size) . 'count: ' . count($size) . ' ' . ($size[0] > 798) . ' ' . ($size[1] > 558));
            return;
        }

        error_log('URL clean: '.$prod_url);
        $extension = image_type_to_extension(getimagesize($prod_url)[2]);
        $upload_dir = wp_upload_dir();
        $filename = sanitize_file_name(basename($prod_url.$extension));

        $image_data = file_get_contents($prod_url);

        if ($image_data === false) {
            return;
        }
        // Create upload folder if doesnt exist
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'].'/'.$filename;
        } else {
            $file = $upload_dir['basedir'].'/'.$filename;
        }
        //error_log('File: ' . $file);
        // Check if file exists before upload
        if (! file_exists($file)) {
            //error_log('putting content');
            file_put_contents($file, $image_data);
        }

        // Create a wordpress attachment for the image
        $wp_filetype = wp_check_filetype($filename, null);
        $title = get_the_title($post_id);
        error_log('Title: '.$title);
        $attachment = [
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit',
        ];
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        error_log('Attachement ID: '.$attach_id);
        update_post_meta($attach_id, '_wp_attachment_image_alt', $title);
        require_once ABSPATH.'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        //error_log('TT: ' . print_r($attach_data,true));
        wp_update_attachment_metadata($attach_id, $attach_data);

        set_post_thumbnail($post_id, $attach_id);
    }
}
