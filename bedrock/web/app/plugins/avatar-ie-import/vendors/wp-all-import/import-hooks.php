<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('aii_hooks_on_save')) {
    function aii_hooks_on_save($post_id)
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

        /* For import of Articles */
        if (substr($actual_import, 0, strlen('import_article')) === 'import_article') {
            aii_add_link_to_CPT_authors($post_id);
            aii_set_main_sub_category($post_id);

            if ($actual_import == 'import_article_brand_knowledge') {
                aii_link_article_to_its_brand($post_id);
            } elseif ($actual_import == 'import_article_tools') {
                aii_ajust_category_and_subcategory_for_tools($post_id);
            } elseif ($actual_import == 'import_article_back_issue') {
                aii_add_link_to_back_issue_date($post_id);
            }

        } elseif ($actual_import == 'inside_track') {
            aii_add_link_to_CPT_authors($post_id);
        } elseif ($actual_import == 'authors') {
            aii_set_ACF_author_column($post_id);
        } elseif ($actual_import == 'import_features') {
            $in_depth_cat_id = aii_adjust_features_parent_sub_category($post_id);
            aii_link_articles_to_its_feature($post_id, $in_depth_cat_id);
        } elseif ($actual_import == 'import_web_users') {
            aii_adjust_web_user($post_id);
        }

        //aii_get_img_from_content($post_id);

        /*TEST POUR VOIR POURQUOI CERTAINES FEATURE IMAGE NE S'IMPORTE PAS EN QA (MARCHE EN DEV)
        print_r( '<br>has_post_thumbnail: ') ;
        print_r( has_post_thumbnail($post_id) );

        print_r( '<br>get_the_post_thumbnail_url: ') ;
        print_r( get_the_post_thumbnail_url($post_id) );

        print_r( '<br>image exists: ') ;
        if (@getimagesize( get_the_post_thumbnail_url($post_id) )) {
            echo  'image exists';
        } else {
            echo  'image does not exist';
        }*/

    }
    add_action('pmxi_saved_post', 'aii_hooks_on_save', 10, 1);
}

if (! function_exists('aii_ajust_category_and_subcategory_for_tools')) {

    function aii_ajust_category_and_subcategory_for_tools($user_id) {}
}
/**
 * Web Users
 */
if (! function_exists('aii_adjust_web_user')) {

    function aii_adjust_web_user($user_id)
    {

        global $wpdb;
        $blog_list = get_sites();
        $current_blog_id = get_current_blog_id();

        $role = get_field('acf_wp_all_import_role_list', 'user_'.$user_id);
        $password = get_field('acf_wp_all_import_password', 'user_'.$user_id);

        $user_login = current_time('timestamp').'ie'.wp_rand(1, 99999);
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

        if (isset($role)) {
            $roles = explode(',', $role);
            //error_log(print_r($roles, true));
            if (count($roles) == 1 && in_array('User', $roles)) {
                $role = 'subscriber';
            } else {
                $role = 'newspaper';
            }
        } else {
            $role = 'subscriber';
        }

        foreach ($blog_list as $key => $blog) {
            $blog_id = $blog->blog_id;
            $role_curr = $current_blog_id == $blog_id ? $role : 'subscriber';
            $result = add_user_to_blog($blog_id, $user_id, $role_curr);
        }

        // $password = get_field('acf_wp_all_import_password', 'user_' . $user_id);
        // //error_log($password);
        // //error_log($user_id);
        // //wp_set_password( $password, $user_id );
        // //update_user_meta($user_id, 'user_pass', $password);
        // //wp_update_user( array ('ID' => $user_id, 'user_pass' => $password) ) ;

        // global $wpdb;
        // $user_login = current_time( 'timestamp' ).'avt'.wp_rand( 1, 99999 );
        // $result = $wpdb->update( $wpdb->users, array( 'user_pass' => $password , 'user_login' => $user_login), array( 'ID' => $user_id ) );

        // //error_log('|' . print_r($result, true) . '|');
        // $role_list = get_field('acf_wp_all_import_role_list', 'user_' . $user_id);
        // //error_log($role_list);
        // if(isset($role_list)) {
        //     $roles = explode(',', $role_list);
        //     //error_log(print_r($roles, true));
        //     if (count($roles) == 1 && in_array('User', $roles)) {
        //         $role = 'subscriber';
        //     } else {
        //         $role = 'newspaper';
        //     }
        //     $user = get_user_by('id', $user_id);
        //     $user->set_role( $role );

        // } else {
        // 	$role = 'subscriber';
        // }

        // $blog_list = get_sites();
        // $current_blog_id = get_current_blog_id();

        // foreach ($blog_list as $key => $blog) {
        //     $meta = array( 'add_to_blog' => $blog['blog_id'], 'new_role' => ($current_blog_id == $blog['blog_id'] ? $role :'subscriber'));
        //     $result = add_new_user_to_blog( $user_id, null, $meta );
        // }
    }
}

/**
 * IN-DEPTH - FEATURES
 */
if (! function_exists('aii_adjust_features_parent_sub_category')) {
    /* UPDATE article with In-Depth pages) */
    function aii_adjust_features_parent_sub_category($post_id)
    {
        $name = get_the_title($post_id);

        if (strpos($name, 'Report Card') !== false) {
            $in_depth_page_id = 28040; //'Report Cards page ID';
            $in_depth_cat_id = 5006;
        } elseif (strpos($name, 'Partner Report') !== false) {
            $in_depth_page_id = 28047; //'Partner Reports page ID';
            $in_depth_cat_id = 5005;
        } elseif (strpos($name, 'ETF Guide') !== false || strpos($name, 'CRM2') !== false) {
            $in_depth_page_id = 28043; //'Magazines page ID';
            $in_depth_cat_id = 5004;
        } else {
            $in_depth_page_id = 28037; //'Special Reports page ID';
            $in_depth_cat_id = 5007;
        }

        update_field('acf_feature_parent_sub_category', $in_depth_page_id, $post_id);

        return $in_depth_cat_id;
    }
}

if (! function_exists('aii_link_articles_to_its_feature')) {
    function aii_link_articles_to_its_feature($feature_post_id, $in_depth_cat_id)
    {
        // List of all Liferay IDs of articles linked to this feature
        $assetListString = get_field('acf_wp_all_import_asset_list', $feature_post_id);

        //error_log('Feature title: ' . get_the_title($feature_post_id));
        if (isset($assetListString)) {
            $featurePost = get_post($feature_post_id);
            $most_recent_date = '0';
            $assetList = explode(',', $assetListString);
            // For each, get the wordpress post ID
            foreach ($assetList as $assetId) {
                $query = new WP_Query([
                    'meta_query' => [
                        [
                            'key' => 'acf_wp_all_import_asset_id',
                            'value' => [$assetId],
                        ],
                    ],
                    'posts_per_page' => 1,
                ]);

                if ($query->have_posts()) {

                    $query->the_post();
                    $asset_post_id = get_the_ID();
                    $the_asset_date = get_the_date('Y-m-d H:i:s');

                    if (strcmp($the_asset_date, $most_recent_date) > 0) {
                        $most_recent_date = $the_asset_date;
                    }
                    // Update feature
                    update_field('acf_article_feature', $feature_post_id, $asset_post_id);

                    // Update article type
                    update_field('acf_article_type', 'feature', $asset_post_id);

                    // Update Main Sub Category (ACF and Yoast)
                    update_field('article_side_main_subcategory', $in_depth_cat_id, $asset_post_id);
                    update_field('_yoast_wpseo_primary_category', $in_depth_cat_id, $asset_post_id);
                    error_log('Update main sub category');

                    // Update Categories (wordpress default categories)
                    $child = get_category($in_depth_cat_id); //firstly, load data for your child category
                    $parent_cat_id = $child->parent; //from your child category, grab parent ID
                    $test = wp_set_post_categories($asset_post_id, [$in_depth_cat_id, $parent_cat_id], true);

                }
                wp_reset_query();
            }
            update_field('acf_feature_published_date', strtotime($most_recent_date), $feature_post_id);
        }
    }
}

/**
 * COLUMNS
 */
if (! function_exists('aii_set_ACF_author_column')) {
    function aii_set_ACF_author_column($post_id)
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

/**
 * WRITER (AUTHORS)
 */
if (! function_exists('aii_add_link_to_CPT_authors')) {
    function aii_add_link_to_CPT_authors($id)
    {

        /**
         * Article (post) has been created here by WP All Import (nothing to do)
         */

        /**
         * Import Authors (Custom post type)
         */

        //$authors = get_post_meta( $id, 'import_authors_full_name', false);
        $authors = get_post_meta($id, 'acf_wp_all_import_author_name', false);
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($id), $id);

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
                    update_field('acf_article_author', [$autherId], $id);
                    update_field('acf_author_first_name', $firstName, $autherId);
                    update_field('acf_author_last_name', $lastName, $autherId);
                } else {

                    update_field('acf_article_author', [$obj_authors_id_register->ID], $id);
                    update_field('acf_author_first_name', $firstName, $obj_authors_id_register->ID);
                    update_field('acf_author_last_name', $lastName, $obj_authors_id_register->ID);
                }

                //get_field('acf_article_author_show', $id)
                update_field('acf_article_author_show', true, $id);
                update_field('acf_article_date_show', true, $id);
                update_field('acf_article_category_show', true, $id);
                update_field('acf_article_thumbnail_show', true, $id);
            }
        }
    }
}

if (! function_exists('aii_add_link_to_back_issue_date')) {
    function aii_add_link_to_back_issue_date($post_id)
    {

        aii_set_main_sub_category($post_id);

        $back_issue_date_title = get_field('acf_wp_all_import_back_issue_date', $post_id);
        $back_issue_date_title_no_mid = str_replace('Mid-', '', $back_issue_date_title);

        if (strlen($back_issue_date_title) > strlen($back_issue_date_title_no_mid)) {
            $adjusted_date = $back_issue_date_title_no_mid.' '.'15';
        } else {
            $adjusted_date = $back_issue_date_title_no_mid.' '.'01';
        }

        print_r('---adjusted date: '.$adjusted_date);
        $dateobj = DateTime::createFromFormat('F Y d', $adjusted_date);

        $mysql_date = $dateobj->format('Y-m-d H:i:s');

        $newspaper_date_id = get_page_by_title($back_issue_date_title, 'OBJECT', 'newspaper');

        if (! isset($newspaper_date_id)) {
            /* Create the Back Issue Date as it doesn't exist yet */
            $newspaper_date_id = wp_insert_post(['post_title' => $back_issue_date_title, 'post_type' => 'newspaper', 'post_status' => 'publish', 'post_date' => $mysql_date]);

        }
        update_field('acf_article_newspaper', $newspaper_date_id, $post_id);
    }
}

/**
 * BRANDS
 */
if (! function_exists('aii_link_article_to_its_brand')) {
    function aii_link_article_to_its_brand($post_id)
    {
        $brand_name_title = get_post_meta($post_id, 'acf_wp_all_import_brand_name', false);

        if (isset($brand_name_title)) {
            $obj_brand = get_page_by_title($brand_name_title[0], 'OBJECT', 'brand');
        }

        if (isset($obj_brand)) {
            update_field('acf_article_brand', $obj_brand->ID, $post_id, true);

            // Update article type
            update_field('acf_article_type', 'brand', $post_id);
            update_field('acf_article_author_show', false, $post_id);
            update_field('acf_article_date_show', false, $post_id);
        } //should always be set
    }
}

/**
 * SET MAIN SUB CATEGORY
 */
if (! function_exists('aii_set_main_sub_category')) {
    function aii_set_main_sub_category($post_id)
    {

        $category_array = get_the_category($post_id); //$post->ID
        foreach ($category_array as $category_detail) {
            if ($category_detail->parent > 0) {
                update_field('article_side_main_subcategory', $category_detail->cat_ID, $post_id);
                update_field('_yoast_wpseo_primary_category', $category_detail->cat_ID, $post_id);

                return false; // to ensure we update juste once
            }
        }
    }
}

/**
 * GET ALL IMAGES FROM CONTENT
 */
//$actual_server_import = 'qa';

if (! function_exists('aii_get_img_from_content')) {
    function aii_get_img_from_content($post_id)
    {

        error_log('---------');
        $featuredImage_url_liferay = get_field('acf_wp_all_import_featured_image', $post_id);
        $featuredImage_url_liferay = substr($featuredImage_url_liferay, 0, strpos($featuredImage_url_liferay, '?'));

        // Get all Content that was just saved
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
            foreach ($imgs_extracted as $img_extracted) {
                (has_post_thumbnail($post_id)) ? $has_thumbnail = 1 : $has_thumbnail = 0;
                $img_original_src = $img_extracted->getAttribute('src');
                $img_original_src = substr($img_original_src, 0, strpos($img_original_src, '?'));
                // 1- Change all URLs
                //------------------------
                // Get the image on live website to avoid password managing
                $image_url_liferay = str_replace('qa.', 'www.', $img_original_src);

                // Get the extension of the file
                $extension = image_type_to_extension(getimagesize($image_url_liferay)[2]);
                $upload_dir = wp_upload_dir();
                $filename = sanitize_file_name(basename($image_url_liferay.$extension));
                $image_data = file_get_contents($image_url_liferay);

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

                // Replace img src in wp content
                $img_extracted->setAttribute('src', wp_get_attachment_url($attach_id));

                // 2- If this image is the same than Featured Image
                //------------------------
                // Avoid the delete image from content specifically for the section 'For your clients'
                if (get_field('acf_wp_all_import_id', $post_id) != 'import_article_for_your_client') {
                    if ($img_original_src === $featuredImage_url_liferay) {
                        echo "Images identiques \ il faut retiré cette image du content pour ne garder que le feature image<br>";
                        $img_extracted->parentNode->removeChild($img_extracted);
                    }

                    // 3- If no Featured Image yet
                    //------------------------
                    if (! $has_thumbnail) {
                        set_post_thumbnail($post_id, $attach_id);
                        $has_thumbnail = 1;
                    }
                }

                // 4- Save new document
                //------------------------
                //$doc->removeChild($doc->doctype);
                //$doc->replaceChild($doc->firstChild->firstChild, $doc->firstChild);
                $WpContent = $doc->saveHTML();
            }

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
