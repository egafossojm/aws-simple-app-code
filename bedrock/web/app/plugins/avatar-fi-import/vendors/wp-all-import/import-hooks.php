<?php
/* -------------------------------------------------------------
 * HOOKS FOR WP ALL IMPORT
 *
 * This one apply after updating or creating a post ("save_post", WordPress hook)
 * If we want to apply modification before updating or creating, we will use the filter ("wp_insert_post", WordPress hook)
 * ============================================================*/

if (! function_exists('afi_hooks_on_save')) {
    function afi_hooks_on_save($post_id)
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
        error_log('IMPORT  '.$actual_import);

        $import_article = 'import_article';
        $import_article_zone_experts = 'import_article_zone_experts';
        $import_article_savoir_d_entreprise = 'import_article_savoir_d_entreprise';
        $import_article_fi_tv = 'import_article_fi_tv';
        $import_dossier = 'import_dossiers';

        /* For import of Articles */
        if (substr($actual_import, 0, strlen($import_article)) === $import_article) {
            // Set article common fields
            afi_set_common_article_fields($post_id);

            // Authors
            if (substr($actual_import, 0, strlen($import_article_zone_experts)) === $import_article_zone_experts) {
                // Article of Zone Experts
                afi_add_link_to_authors($post_id);
            } elseif (substr($actual_import, 0, strlen($import_article_fi_tv)) === $import_article_fi_tv) {
                afi_set_author($post_id, 'FI TV');
            } else {
                afi_add_link_to_authors($post_id);
            }

            //Brand knwoledge
            if (substr($actual_import, 0, strlen($import_article_savoir_d_entreprise)) === $import_article_savoir_d_entreprise) {
                afi_add_link_to_brand($post_id);
            }

            //Brightcove
            if (substr($actual_import, 0, strlen($import_article_fi_tv)) === $import_article_fi_tv) {
                afi_add_brightcove($post_id);
            }

        } elseif (substr($actual_import, 0, strlen($import_dossier)) === $import_dossier) {
            afi_set_feature_attributes($post_id);
        } elseif ($actual_import == 'import_web_users') {
            afi_adjust_web_user($post_id);
        }

        //afi_get_img_from_content($post_id);

    }
    add_action('pmxi_saved_post', 'afi_hooks_on_save', 10, 1);
}

if (! function_exists('afi_set_common_article_fields')) {
    function afi_set_common_article_fields($articleId)
    {
        update_field('_yoast_wpseo_metadesc', get_the_excerpt($articleId), $articleId);

        // Set the main sub-category
        $category_array = get_the_category($articleId);
        echo 'Categories length: '.count($category_array);
        foreach ($category_array as $category_detail) {
            if ($category_detail->parent > 0) {
                echo 'Setting category '.$category_detail->cat_ID.' for article '.$articleId.'<br/>';
                update_field('article_side_main_subcategory', $category_detail->cat_ID, $articleId);
                update_field('_yoast_wpseo_primary_category', $category_detail->cat_ID, $articleId);
            }

        }

        // Set fields to display
        update_field('acf_article_date_show', true, $articleId);
        update_field('acf_article_category_show', true, $articleId);
        update_field('acf_article_thumbnail_show', true, $articleId);
    }
}

if (! function_exists('afi_add_link_to_authors')) {
    function afi_add_link_to_authors($articleId)
    {

        $author_name = get_post_meta($articleId, 'acf_wp_all_import_author_name', false);
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
            error_log('Author names: '.$author_name[0]);
            error_log('Authors: '.print_r($author_list, true));
            update_field('acf_article_author', $author_list, $articleId);
            update_field('acf_article_author_show', true, $articleId);
        }

    }
}

//Old way to Import the columnists
/*if (!function_exists('afi_add_link_to_columnist')) {
    function afi_add_link_to_columnist($articleId) {

        $authorName = get_post_meta($articleId, 'acf_wp_all_import_author_name', true);
        $authorNameSplit = explode('--', $authorName);
        $authorId = $authorNameSplit[0];
        $columnName = $authorNameSplit[1];
error_log(print_r($authorName,true));
        $columnists = get_posts(
            array(
                'numberposts' => 1,
                'post_type' => 'writer',
                'meta_key' => 'acf_wp_all_import_columnist_id',
                'meta_value' => $authorId
            )
        );

        if (count($columnists) == 0) {
            echo 'No columnist found for ID "' . $authorId . '"';
        } else if (count($columnists) > 1) {
            echo 'More than 1 columnist found for ID "' . $authorId . '"';
        } else {
            $columnist = current($columnists);

            update_field('acf_article_author', array($columnist->ID), $articleId);
            update_field('acf_article_author_show', true, $articleId);

            echo "Column name = '$columnName'";
            $term = get_term_by('name', $columnName, 'post_column');
            if ($term === FALSE) {
                echo "Term does not exist, adding it";
                $termId = wp_insert_term($columnName, 'post_column');
                echo $termId;
                update_field('acf_author_column', $termId, $columnist->ID);
            } else {
                echo "Term exists -> '" . $term->term_id . "'";
                update_field('acf_author_column', $term->term_id, $columnist->ID);
            }
        }
    }
}*/

if (! function_exists('afi_add_link_to_brand')) {
    function afi_add_link_to_brand($articleId)
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

if (! function_exists('afi_add_brightcove')) {
    function afi_add_brightcove($articleId)
    {
        $brightcoveId = get_post_meta($articleId, 'acf_wp_all_import_asset_id', true);

        if (isset($brightcoveId)) {
            update_field('acf_article_video', $brightcoveId, $articleId);
            update_field('acf_article_video_show', true, $articleId);
        }
    }
}

if (! function_exists('afi_set_author')) {
    function afi_set_author($articleId, $authorName)
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

if (! function_exists('afi_set_feature_attributes')) {
    function afi_set_feature_attributes($featureId)
    {
        $name = get_the_title($featureId);
        // Set the correct page of the feature
        $dossierPageName = 'Dossier spéciaux';
        $dossierPageId = 355;
        $categoryId = 771;
        if (strpos(strtolower($name), 'pointage') !== false || strpos(strtolower($name), 'baromètre') !== false) {
            $dossierPageName = 'Études et sondages';
            $dossierPageId = 357;
            $categoryId = 772;
        } elseif (strpos(strtolower($name), 'guide') !== false || strpos(strtolower($name), 'fnb') !== false || strpos(strtolower($name), 'mrcc2') !== false) {
            $dossierPageName = 'Magazines';
            $dossierPageId = 359;
            $categoryId = 773;
        } elseif (strpos(strtolower($name), 'dossier partenaire') !== false) {
            $dossierPageName = 'Dossiers partenaires';
            $dossierPageId = 361;
            $categoryId = 774;
        }
        update_field('acf_feature_parent_sub_category', $dossierPageId, $featureId);

        // Link articles to the feature
        $articleIdList = get_field('acf_wp_all_import_asset_list', $featureId);

        if (isset($articleIdList)) {
            $articleIds = explode(',', $articleIdList);
            foreach ($articleIds as $articleId) {
                echo 'Article Asset ID: '.$articleId.'<br/>';
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
                    echo 'Article Found!'.'<br/>';
                    $query->the_post();
                    $articlePostId = get_the_ID();

                    // Update article's feature
                    update_field('acf_article_feature', $featureId, $articlePostId);

                    // Update article type
                    update_field('acf_article_type', 'feature', $articlePostId);

                    // Update main sub category
                    update_field('article_side_main_subcategory', $categoryId, $articlePostId);

                    // Update category
                    $category = get_category($categoryId);
                    $parentCategory = $category->parent;
                    wp_set_post_categories($articlePostId, [$categoryId, $parentCategory->ID], true);
                }
                wp_reset_query();
            }
        }

    }
}

/**
 * Web Users
 */
if (! function_exists('afi_adjust_web_user')) {

    function afi_adjust_web_user($user_id)
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
////$actual_server_import = 'qa';
//
//if ( ! function_exists( 'afi_get_img_from_content') ) {
//	function afi_get_img_from_content($post_id) {
//
//
//		$featuredImage_url_fi = get_field('acf_wp_all_import_featured_image', $post_id);
//		$featuredImage_url_fi = substr($featuredImage_url_fi, 0, strpos($featuredImage_url_fi, "?"));
//
//		// Get all Content that was just saved
//		$html_wp = get_post($post_id)->post_content;
//
//		// Transform to DOM based document
//		$doc = new DOMDocument( '1.0', 'UTF-8' );
//		$fragment = $doc->createDocumentFragment();
//		$fragment->appendXML($html_wp);
//		$doc->appendChild($fragment);
//		$imgs_extracted = $doc->getElementsByTagName('img');
//
//		// Check if we have images
//		if( $imgs_extracted->length > 0 ) {
//			// Extract images
//			foreach ( $imgs_extracted as $img_extracted ) {
//                error_log("IMG...");
//				( has_post_thumbnail($post_id) ) ? $has_thumbnail=1 : $has_thumbnail=0 ;
//				$img_original_src = $img_extracted->getAttribute('src');
//                if(! (strpos($img_original_src, "?") === false )) {
//                    $img_original_src = substr($img_original_src, 0, strpos($img_original_src, "?"));
//                }
//
//				// 1- Change all URLs
//				//------------------------
//				// Get the image on live website to avoid password managing
//				$image_url_local_site = str_replace('www.', 'stg.', $img_original_src );
//
//
//				// Get the extension of the file
//				$extension = image_type_to_extension(getimagesize($image_url_local_site)[2]);
//				$upload_dir = wp_upload_dir();
//				$filename = sanitize_file_name(basename($image_url_local_site.$extension));
//				$image_data = file_get_contents( $image_url_local_site );
//
//				// Create upload folder if doesnt exist
//				if ( wp_mkdir_p( $upload_dir['path'] ) )
//					$file = $upload_dir['path'] . '/' . $filename;
//				else
//					$file = $upload_dir['basedir'] . '/' . $filename;
//
//				// Check if file exists before upload
//				if( !file_exists($file)) {
//					file_put_contents( $file, $image_data );
//				}
//
//				// Create a wordpress attachment for the image
//				$wp_filetype = wp_check_filetype( $filename, null );
//				$title = get_the_title($post_id);
//
//				$attachment = array(
//					'post_mime_type' => $wp_filetype['type'],
//					'post_title' => sanitize_file_name( $filename ),
//					'post_content' => '',
//					'post_status' => 'inherit'
//				);
//				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
//				update_post_meta( $attach_id, '_wp_attachment_image_alt', $title );
//				require_once( ABSPATH . 'wp-admin/includes/image.php' );
//				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
//				wp_update_attachment_metadata( $attach_id, $attach_data );
//
//				// Replace img src in wp content
//				$img_extracted->setAttribute( 'src', wp_get_attachment_url($attach_id) );
//
//				// 2- If this image is the same than Featured Image
//				//------------------------
//				// Avoid the delete image from content specifically for the section 'For your clients'
//					if( $img_original_src  === $featuredImage_url_fi){
//						error_log("Images identiques -- il faut retiré cette image du content pour ne garder que le feature image");
//                        error_log($img_original_src);
//                        error_log($featuredImage_url_fi);
//						//$img_extracted->parentNode->removeChild($img_extracted);
//                        error_log("Image removed...");
//					}
//
//
//					// 3- If no Featured Image yet
//					//------------------------
//					if( !$has_thumbnail ){
//                        error_log("No thumbnail...");
//						set_post_thumbnail( $post_id, $attach_id );
//                        error_log("Thumbnail set...");
//						$has_thumbnail=1;
//					}
//
//				// 4- Save new document
//				//------------------------
//                error_log("Save Html...");
//				$WpContent = $doc->saveHTML();
//                error_log("Html saved...");
//			}
//
//
//			// 5- Update WP content
//			//------------------------
//			wp_update_post(
//				array(
//					'ID'			=> $post_id,
//					'post_content'	=> $WpContent
//				)
//			);
//            error_log("Post updated...");
//		}
//	}
//}
