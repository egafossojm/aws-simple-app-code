<?php
/**
 * Custom Functions for posts (articles)
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 * Content filter, insert pub and right coll in the_content
 * @see AVAIE-323
 * ============================================================*/

if (! function_exists('avatar_split_post')) {
    function avatar_split_post($content)
    {
        $closing_p = '</p>';
        $paragraphs = explode($closing_p, $content);
        foreach ($paragraphs as $index => $paragraph) {

            if (trim($paragraph)) {
                $paragraphs[$index] .= $closing_p;
            }
        }
        $split_content[] = implode('', array_slice($paragraphs, 0, 2));
        $split_content[] = implode('', array_slice($paragraphs, 2, count($paragraphs)));

        return $split_content;
    }
}

if (! function_exists('avatar_add_sponsored_keyword')) {
    function avatar_add_sponsored_keyword($post_id, $content)
    {
        $content_array = [];
        $tags = get_the_tags($post_id);
        if (! empty($tags)) {

            foreach ($tags as $tag) {
                $sponsor_id = get_field('acf_keyword_sponsor', $tag);
                if (! empty($sponsor_id)) {
                    $sponsor = get_term_by('id', $sponsor_id, 'post_sponsor');
                    $type = get_field('acf_sponsor_type', $sponsor);
                    $keyword = $tag->name;

                    if ($type == 'keyword') {
                        $replacement = '<span class="keypop-trigger" id="keypop-trigger" tabindex="0" role="button" href="#" data-toggle="popover" data-popover-content="#myPopover">'.'$1'.'</span>';
                        $content_array[0] = true;
                        $content_array[1] = preg_replace("/($keyword)/i", $replacement, $content, 1);
                        $content_array[2] = $tag;
                        $content_array[3] = get_field('acf_custom_popup_html', $tag);

                        return $content_array;

                    }
                }

            }

        }
        $content_array[0] = false;
        $content_array[1] = $content;

        return $content_array;

    }
}

/* -------------------------------------------------------------
 * Gets a nicely formatted string for the published date.
 * ============================================================*/

if (! function_exists('avatar_display_post_date')) {

    function avatar_display_post_date($post_id, $single = true)
    {

        if (! is_int($post_id)) {
            return;
        }

        $time_string = '<li class="pub-details__item"><span class="published">%1$s</span>
		<span class="updated">%4$s</span></li><li class="pub-details__item">%2$s</li>';

        $time_string = sprintf($time_string,
            get_the_date('', $post_id),
            get_the_date('H:i', $post_id),
            get_the_date('c', $post_id),
            get_the_modified_date('', $post_id),
            get_the_modified_date('c', $post_id)
        );
        // Return the time string
        if ($single or get_field('acf_article_date_show', $post_id)) {
            // Data is escaped
            echo $time_string;
        }
    }
}

/* -------------------------------------------------------------
 * Gets a nicely formatted string for the published date only, no time.
 * ============================================================*/

if (! function_exists('avatar_display_post_date_only')) {

    function avatar_display_post_date_only($post_id, $single = true)
    {

        if (! is_int($post_id)) {
            return;
        }

        $time_string = '<li class="pub-details__item"><span class="published">%1$s</span>
		<span class="updated">%4$s</span></li>';

        $time_string = sprintf($time_string,
            get_the_date('', $post_id),
            get_the_date('H:i', $post_id),
            get_the_date('c', $post_id),
            get_the_modified_date('', $post_id),
            get_the_modified_date('c', $post_id)
        );
        // Return the time string
        if ($single or get_field('acf_article_date_show', $post_id)) {
            // Data is escaped
            echo $time_string;
        }
    }
}

/* -------------------------------------------------------------
 * Gets Article Authors
 * ============================================================*/

if (! function_exists('avatar_display_post_author')) {

    function avatar_display_post_author($post_id, $single = true, $by = 'By: ')
    {

        if (! is_int($post_id)) {
            return;
        }

        $authors_list = get_field('acf_article_author', $post_id);
        $brand_object = get_field('acf_article_brand', $post_id);
        $feature_object = get_field('acf_article_feature', $post_id);
        $partner_object = $feature_object ? get_field('acf_feature_partner', $feature_object->ID) : null;
        $partner_url = $partner_object ? get_field('acf_partner_website', $partner_object->ID) : null;
        $author_html = false;

        if (is_object($brand_object)) {
            $author_html = '<a href="'.get_permalink($brand_object->ID).'"><span>'.get_the_title($brand_object->ID).'</span></a>';
        } elseif (is_object($partner_object)) {
            $author_html = '<a target="_blank" href="'.$partner_url.'"><span>'.get_the_title($partner_object->ID).'</span></a>';
        } elseif ($authors_list) {

            $author_list = [];
            foreach ($authors_list as $author) {
                if (is_object($author)) {
                    $author_list[] = '<a href="'.get_permalink($author->ID).'"><span>'.get_the_title($author->ID).'</span></a>';
                }
            }
            $author_html = implode(', ', $author_list);

        }

        if ($author_html && ($single or get_field('acf_article_author_show', $post_id))) {
            printf('<li class="pub-details__item">%1$s %2$s</li>',
                _x($by, 'Used before authors files.', 'avatar-tcm'),
                $author_html
            );
        }

    }
}

/* -------------------------------------------------------------
 * Gets Article Authors
 * ============================================================*/

if (! function_exists('avatar_display_post_brand')) {

    function avatar_display_post_brand($post_id)
    {

        if (! is_int($post_id)) {
            return;
        }

        $brand_object = get_field('acf_article_brand');

        if ($brand_object) {
            $brand = '<a href="'.get_permalink($brand_object->ID).'"><span>'.get_the_title($brand_object->ID).'</span></a>';
            if (get_field('acf_article_author_show', $post_id)) {
                printf('<li class="pub-details__item">%1$s %2$s</li>',
                    _x('By: ', 'Used before brand name.', 'avatar-tcm'),
                    $brand
                );
            }
        } else {
            error_log('Brand do not exist');
        }
    }
}

/* -------------------------------------------------------------
 * Gets Article Source
 * ============================================================*/

if (! function_exists('avatar_display_post_source')) {

    function avatar_display_post_source($post_id, $single = true)
    {

        if (! is_int($post_id)) {
            return;
        }

        $source = '';
        if (get_field('acf_article_source', $post_id) && get_field('acf_article_source_url', $post_id)) {
            $source = '<a href="'.get_field('acf_article_source_url', $post_id).'">'.get_field('acf_article_source', $post_id).'</a>';
        } elseif (get_field('acf_article_source', $post_id)) {
            $source = get_field('acf_article_source', $post_id);
        }

        if (($single or get_field('acf_article_source_show', $post_id)) && ($source != '')) {
            printf('<li class="pub-details__item">%1$s %2$s</li>',
                _x('Source :', 'Used before source.', 'avatar-tcm'),
                $source
            );
        }
    }
}

/* -------------------------------------------------------------
 * Gets Article Type and add different classes for listing only - (Partner/Brand)
 * ============================================================*/

if (! function_exists('avatar_display_sponsor_header_title')) {

    function avatar_display_sponsor_header_title($post_id)
    {

        // Article types validations
        $article_type = get_field('acf_article_type', $post_id);
        $sponsor_header_title_html = '';
        $sponsor_header = false;
        if ($article_type == 'feature') {

            $sponsor_object = get_field('acf_article_feature', $post_id);
            $is_partner = get_field('acf_feature_ispartner', $sponsor_object->ID);
            if ($is_partner) {
                $partner_page_id = get_field('acf_in_depth_partner_report', 'option');
                if (is_int($partner_page_id)) {
                    $sponsor_header_title_html = '<p class="sponsor-title sponsor-title--marginNL"><a href="'.esc_url(get_page_link($partner_page_id)).'" class="sponsor-title__link">'.get_the_title($partner_page_id).'</a></p>';
                }
            }
        } elseif ($article_type == 'brand') {
            $brand_page_id = get_field('acf_brand_knowledge_page', 'option');
            if (is_int($brand_page_id->ID)) {
                $sponsor_header_title_html = '<p class="sponsor-title sponsor-title--marginNL"><a href="'.esc_url(get_page_link($brand_page_id)).'" class="sponsor-title__link">'.get_the_title($brand_page_id).'</a></p>';
            }
        }
        // Data is escaped
        echo $sponsor_header_title_html;

    }
}

/* -------------------------------------------------------------
 * Gets Article Category
 * ============================================================*/

if (! function_exists('avatar_display_post_category')) {

    function avatar_display_post_category($post_id, $single = true)
    {

        if (! is_int($post_id)) {
            return;
        }

        $main_category = '';
        $cat_id = get_field('article_side_main_subcategory', $post_id);
        $main_site = get_field('imported_site_origin', $post_id);

        // we should not decide of the color of the category depending of a child property...
        if ($main_site === 'CIR') {
            $color_cir = 'cir-color';
        } else {
            $color_cir = '';
        }

        if ($cat_id) {
            $page_id = avatar_get_page_by_cat($cat_id);
            if ($page_id) {
                $curr_url = get_page_link($page_id);
                $curr_name = get_the_title($page_id);
            } else {
                $curr_url = get_category_link($cat_id);
                $curr_name = get_the_category_by_ID($cat_id);

            }
            $category_origin = get_field(
                'acf_category_site_origin',
                get_category(
                    get_cat_ID(
                        $curr_name
                    )
                )
            );

            if (! empty($category_origin) && strcmp($category_origin, 'CIR') === 0) {
                $color_cir = 'cir-color';
            }

            $main_category = '<span class="text-content__category-label"><a class="'.$color_cir.'" href="'.esc_url($curr_url).'" title="'.wp_kses_post($curr_name).'">'.$curr_name.'</a></span>';
        }

        if ($single or get_field('acf_article_category_show', $post_id)) {
            // Data is escaped
            echo $main_category;
        }
    }
}

/* -------------------------------------------------------------
 * Add support for special tag (iframe,...) in Editor
 * ============================================================*/

if (! function_exists('avatar_add_allowed_tags')) {

    function avatar_add_allowed_tags($tags)
    {
        if (current_user_can('webeditor') || current_user_can('supereditor') || current_user_can('salescoordinator') || current_user_can('administrator')) {
            $tags['embed'] = [
                'src' => true,
                'width' => true,
                'height' => true,
                'id' => true,
                'class' => true,
                'name' => true,
            ];
            $tags['iframe'] = [
                'src' => true,
                'width' => true,
                'height' => true,
                'frameborder' => true,
                'marginwidth' => true,
                'marginheight' => true,
                'scrolling' => true,
                'title' => true,
            ];
            $tags['div'] = [
                'align' => true,
                'dir' => true,
                'lang' => true,
                'xml:lang' => true,
                'class' => true,
                'data' => true,
                'style' => true,
                'data-options' => true,
                'data-m32-ad' => true,
            ];
            $tags['script'] = [
                'type' => true,
                'src' => true,
            ];
            $tags['style'] = [
                'type' => true,
            ];
        }

        return $tags;
    }
    add_filter('wp_kses_allowed_html', 'avatar_add_allowed_tags', 10, 2);
}

/* -------------------------------------------------------------
 * Delete empty lines in Editor
 * ============================================================*/

if (! function_exists('avatar_remove_empty_lines')) {

    function avatar_remove_empty_lines($content)
    {

        // replace empty lines
        $content = preg_replace('/&nbsp;/', '', $content);

        return $content;
    }

    add_action('content_save_pre', 'avatar_remove_empty_lines');
    add_action('save_post', 'avatar_remove_empty_lines');
    add_action('pmxi_saved_post', 'avatar_remove_empty_lines');
}

/* -------------------------------------------------------------
 *  Prints HTML with tags for current post.
 * ============================================================*/

if (! function_exists('avatar_article_taxonomies_tags')) {

    function avatar_article_taxonomies_tags()
    {

        $tags_list = get_the_tags();
        if ($tags_list) {
            $tags_html = '<dl class="related-news-module tags-links taxonomies-links col-sm-6 col-md-12">';
            $tags_html .= '<dt class="related-news-module__title">';
            $tags_html .= _x('Keywords', 'Used before tag names.', 'avatar-tcm');
            $tags_html .= '</dt>';
            $tag_i = 0;
            $tag_max = count($tags_list) - 1;
            foreach ($tags_list as $tag) {
                $tag_html[] = '<dd class="taxonomies-links__description"><span class="related-news-module__link">
				<a href="'.esc_url(get_tag_link($tag->term_id)).'" rel="tag">'.ucfirst($tag->name).($tag_i < $tag_max ? ',' : '').'</a></span></dd>';
                $tag_i++;
            }
            $tags_html .= implode('&nbsp;', $tag_html);
            $tags_html .= '</dl>';
            // Data is escaped
            echo $tags_html;
        }
    }
}

/* -------------------------------------------------------------
 *  Prints HTML for Career for current post.
 * ============================================================*/

if (! function_exists('avatar_article_career_info')) {

    function avatar_article_career_info($post_id, $aside = '-aside')
    {

        $location = get_field('acf_location_career', $post_id);
        $date_posted = get_field('acf_date_posted_career', $post_id);
        $date_closed = get_field('acf_date_closed_career', $post_id);

        $field = get_field_object('acf_employment_status', $post_id);
        $value = $field['value'];
        $employment_status = $field['choices'][$value];

        $website = get_field('acf_website_career', $post_id);
        $site_id = get_current_blog_id();

        echo '<dl class="career-module">';
        echo '<dl class="row row--no-margin">';
        echo '<dl class="details-career-module col-sm-6 col-md-12">';

        if ($aside == '-aside') {
            printf('<dl class="related-news-module__description career-module"><dt>%1$s</dt>', 'Career');
        }

        printf('<dd><span class="module-career-label module-career-label%1$s">%2$s</span><span class="module-career-value">%3$s</span></dd>', $aside, __('LOCATION: ', $site_id, 'avatar-tcm'), $location);
        if ($date_posted != '') {
            printf('<dd><span class="module-career-label module-career-label%1$s">%2$s</span><span class="module-career-value">%3$s</span></dd>', $asid, __('DATE POSTED: ', $site_id, 'avatar-tcm'), $date_posted);
        }
        if ($date_closed != '') {
            printf('<dd><span class="module-career-label module-career-label%1$s">%2$s</span><span class="module-career-value">%3$s</span></dd>', $asid, __('DATE CLOSED: ', 'avatar-tcm'), $date_closed);
        }
        printf('<dd><span class="module-career-label module-career-label%1$s">%2$s</span><span class="module-career-value">%3$s</span></dd>', $asid, __('EMPLOYMENT STATUS: ', $site_id, 'avatar-tcm'), $employment_status);
        if ($website != '') {
            printf('<dd><span class="module-career-label module-career-label%1$s">%2$s</span><a class="module-career-value module-career-value-web" href="%3$s" target="_blank" >%4$s</a></dd></dl>', $asid, __('WEBSITE: ', $site_id, 'avatar-tcm'), $website, __('Access job posting here', $site_id, 'avatar-tcm'));
        }
    }
}

/* -------------------------------------------------------------
 *  Prints HTML for Companies for current post.
 * ============================================================*/

if (! function_exists('avatar_company_taxonomies_tags')) {

    function avatar_company_taxonomies_tags()
    {

        if (taxonomy_exists('post_company')) {

            $company_list = get_the_term_list('', 'post_company', '', _x(', ', 'Used between list items, there is a space after the comma.', 'avatar-tcm'));
            if ($company_list) {
                printf('<dl class="related-news-module company-links taxonomies-links col-sm-6 col-md-12"><dt><h2 class="related-news-module__title">%1$s</h2></dt> <dd class="related-news-module__description taxonomies-links__description"><span class="related-news-module__link">%2$s</span></dd></dl>',
                    _x('Companies', 'Used before companies names.', 'avatar-tcm'),
                    $company_list
                );
            }
        }
    }
}

/* -------------------------------------------------------------
 *  Prints HTML for Documents for current post.
 * ============================================================*/

if (! function_exists('avatar_article_documents')) {

    function avatar_article_documents()
    {
        $document_list = '';

        $article_media = get_field('acf_article_media');

        if (is_array($article_media) && in_array('docs', $article_media) && have_rows('acf_article_pdf')) {

            while (have_rows('acf_article_pdf')) {
                the_row();
                // Get the "file" field and make it a variable
                $attachment_id = get_sub_field('acf_article_pdf_url');
                if (! $attachment_id) {
                    return;
                }
                // Get the attached file in the field and determine the file size
                $filesize = filesize(get_attached_file($attachment_id));
                $filesize = size_format($filesize, 2);
                //Get the attached file in the field and determine the url
                $url = wp_get_attachment_url($attachment_id);

                $document_list .= '<dd><a href="'.$url.'" target="_blank">'.get_sub_field('acf_article_pdf_title').' ('.$filesize.')</a></dd>';
            }

            printf('<dl class="related-news-module documents-pdf"><dt>%1$s</dt> %2$s</dl>',
                _x('Documents', 'Used before Documents files.', 'avatar-tcm'),
                $document_list
            );
        }

    }
}

/* -------------------------------------------------------------
 * Get the icon class of the post
 * ============================================================*/

if (! function_exists('avatar_article_get_icon')) {

    function avatar_article_get_icon($post_id = null)
    {

        $icon_class = '';
        $colors = get_field('acf_article_media', $post_id);

        if (is_array($colors) && $colors) {
            if (in_array('docs', $colors)) {
                $icon_class = 'icon-docs';
            }
            if (in_array('chart', $colors)) {
                $icon_class = 'icon-chart';
            }
            if (in_array('slideshow', $colors)) {
                $icon_class = 'icon-slideshow';
            }
            if (in_array('video', $colors)) {
                $icon_class = 'icon-video';
            }
            if (in_array('podcast', $colors)) {
                $icon_class = 'icon-headphones';
            }

            return $icon_class;
        }

    }
}

/* -------------------------------------------------------------
 * Add post date to Author CPT (writer) and Feature CTP (feature)
 * used for WP_Query
 * ============================================================*/

if (! function_exists('avatar_add_last_published_date_cpt')) {

    function avatar_add_last_published_date_cpt($post_id)
    {

        //global $post;

        if (! is_int($post_id)) {
            return;
        }

        // If this is just a revision, don't send add the date
        if (wp_is_post_revision($post_id)) {
            return;
        }

        $post_date = get_the_date('Y-m-d H:i:s', $post_id);

        if (get_the_date('U', $post_id) <= get_the_modified_date('U', $post_id)) {
            $post_date = get_the_modified_date('Y-m-d H:i:s', $post_id);
        }

        // Test Author and add the date
        $authors_list = get_field('acf_article_author', $post_id);

        if ($authors_list) {

            //            foreach( $authors_list as $author ) {
            //         				//add last publiched date to autortc CPT
            //         				update_post_meta( $author->ID, 'acf_author_published_date', $post_date  );
            //         	}

            foreach ($authors_list as $author) {
                //add last publiched date to autortc CPT
                $is_columnist = get_field('acf_author_is_columnist', $author->ID);

                if ($is_columnist) {

                    $author_articles_args = [
                        'post_type' => 'post',
                        'posts_per_page' => 1,
                        'post_status' => 'publish',
                        'meta_query' => [
                            [
                                'key' => 'acf_article_author',
                                'value' => '"'.$author->ID.'"',
                                'compare' => 'LIKE',
                            ],
                        ],
                        'order' => 'DESC',
                        'orderby' => 'date',

                    ];
                    $author_articles_query = new WP_Query($author_articles_args);
                    if ($author_articles_query->post_count) {

                        update_post_meta($author->ID, 'acf_author_published_date', strtotime($author_articles_query->post->post_date));
                    }

                }
            }
        }

        // Test Feature field and add the Date of Article
        $feature_id = get_field('acf_article_feature', $post_id);
        if ($feature_id->ID) {
            $feature_articles_args = [
                'post_type' => 'post',
                'posts_per_page' => 1,
                'post_status' => 'publish',
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'acf_article_type',
                        'value' => 'feature',
                        'compare' => '=',
                    ],
                    [
                        'key' => 'acf_article_feature',
                        'value' => $feature_id->ID,
                        'compare' => '=',
                    ],
                ],
                'order' => 'DESC',
                'orderby' => 'date',

            ];
            $feature_articles_query = new WP_Query($feature_articles_args);
            if ($feature_articles_query->post_count) {
                update_post_meta($feature_id->ID, 'acf_feature_published_date', strtotime($feature_articles_query->post->post_date));
            }

        }

        // Test Brand field  and add the Date of Article
        $brand_id = get_field('acf_article_brand', $post_id);

        if (is_object($brand_id)) {
            $a = update_post_meta($brand_id->ID, 'acf_brand_published_date', strtotime(get_the_date('Y-m-d H:i:s', $post_id)));
        }
    }
    add_action('save_post', 'avatar_add_last_published_date_cpt');
}

/* ------------------------------------------------------------------
 * Use Brightcove API to create featured image when none was selected
 * ================================================================*/

if (! function_exists('avatar_add_default_featured_image_for_video')) {

    function avatar_add_default_featured_image_for_video($post_id)
    {

        $article_media = get_field('acf_article_media', $post_id);

        if (is_array($article_media) && in_array('video', $article_media) && ! has_post_thumbnail($post_id)) {
            // Get an access token from Brightcove to access data from cms API
            $access_token = avatar_get_brightcove_access_token();

            if (isset($access_token)) {
                $brightcove_video_id = get_field('acf_article_video', $post_id);

                // Use Brightcove cms API to obtain the video image url
                $featured_image_url = avatar_get_brightcove_video_image_url($access_token, $brightcove_video_id);

                if (isset($featured_image_url)) {
                    // Set the post featured image
                    avatar_add_featured_image_to_post($featured_image_url, $post_id);
                }
            }

        }

    }
    add_action('save_post', 'avatar_add_default_featured_image_for_video');
}

/* -------------------------------------------------------------
 * Get brightcove Access Token
 * ============================================================*/

if (! function_exists('avatar_get_brightcove_access_token')) {

    function avatar_get_brightcove_access_token()
    {

        // Build Brightcove token request call
        $endpoint = get_field('acf_brightcove_endpoint', 'option');
        $client_id = get_field('acf_brightcove_client_id', 'option');
        $client_secret = get_field('acf_brightcove_client_secret', 'option');

        $http_headers = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => sprintf('Basic %s', base64_encode($client_id.':'.$client_secret)),
            ],
        ];

        $request = wp_remote_post($endpoint, $http_headers);

        $response_code = wp_remote_retrieve_response_code($request);

        if ($response_code == '200') {
            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body);

            if (isset($data->access_token)) {
                return $data->access_token;
            }
        }
    }
}

/* -------------------------------------------------------------
 * Get Brightcove video image URL
 * ============================================================*/

if (! function_exists('avatar_get_brightcove_video_image_url')) {

    function avatar_get_brightcove_video_image_url($access_token, $brightcove_video_id)
    {

        // Build a Brightcove cms API call
        $account_id = get_field('acf_brightcove_account_id', 'option');
        $endpoint = esc_url_raw('https://cms.api.brightcove.com/v1/accounts/'.$account_id.'/videos/'.$brightcove_video_id);

        $http_headers = [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $access_token),
            ],
        ];
        $request = wp_remote_get($endpoint, $http_headers);
        $response_code = wp_remote_retrieve_response_code($request);

        if ($response_code == '200') {
            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body);

            if (isset($data->images)) {
                $images = $data->images;
                if (isset($images->poster)) {
                    $poster = $images->poster;
                    if (isset($poster)) {
                        // Extract and return the video big image url
                        $featured_image = $poster->src;

                        return $featured_image;
                    }
                }
            }
        }
    }
}

/* -------------------------------------------------------------
 * Add featured (brightcove) image to post
 * ============================================================*/

if (! function_exists('avatar_add_featured_image_to_post')) {

    function avatar_add_featured_image_to_post($image_url, $post_id)
    {
        // Extract a clean image name from Brightcove's image url
        $url_parts = explode('/', $image_url);
        $imageName = end($url_parts);
        $imageName = explode('?', $imageName);
        $imageName = $imageName[0];

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);

        $filename = basename($imageName);
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'].'/'.$filename;
        } else {
            $file = $upload_dir['basedir'].'/'.$filename;
        }
        // Save the image in the upload folder
        file_put_contents($file, $image_data);

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

/* -------------------------------------------------------------
 * Make main subcategory primary category for yoast breadcrumbs
 * ============================================================*/

if (! function_exists('avatar_make_mainsubcategory_primary_yoast_category')) {

    function avatar_make_mainsubcategory_primary_yoast_category($post_id)
    {

        if (! is_int($post_id)) {
            return;
        }

        // If this is just a revision, don't send add the date
        if (wp_is_post_revision($post_id)) {
            return;
        }
        $mainsubcategory_id = get_post_meta($post_id, 'article_side_main_subcategory', true);
        $primary_yoast_category_id = get_post_meta($post_id, '_yoast_wpseo_primary_category', true);
        if ($mainsubcategory_id != $primary_yoast_category_id) {
            update_post_meta($post_id, '_yoast_wpseo_primary_category', $mainsubcategory_id);
        }
    }
    add_action('save_post', 'avatar_make_mainsubcategory_primary_yoast_category');
}

/* -------------------------------------------------------------
 * Add class and rel 'next' for pagination
 * ============================================================*/

if (! function_exists('avatar_posts_link_attributes_next')) {

    function avatar_posts_link_attributes_next()
    {
        return 'class="next" rel="next"';
    }
    add_filter('next_posts_link_attributes', 'avatar_posts_link_attributes_next');
}

/* -------------------------------------------------------------
 * Disable Redirect on Author and Feature CPT (use for btn more) AVAIE-536
 * ============================================================*/

if (! function_exists('avatar_disable_redirect_single_cpt')) {

    function avatar_disable_redirect_single_cpt($redirect_url)
    {
        if (is_singular('writer') or is_singular('feature') or is_singular('brand') or is_singular('newspaper')) {
            $redirect_url = false;
        }

        return $redirect_url;
    }
    add_filter('redirect_canonical', 'avatar_disable_redirect_single_cpt');
}

/* -------------------------------------------------------------
 * Get All topics for specific Brand
 * ============================================================*/

if (! function_exists('avatar_get_all_topics_brand_cpt')) {

    function avatar_get_all_topics_brand_cpt($post_id)
    {
        $avatar_brand_args_all = [
            'post_type' => 'post',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_article_type',
                    'value' => 'brand',
                    'compare' => '=',
                ],
                [
                    'key' => 'acf_article_brand',
                    'value' => $post_id,
                    'compare' => '=',
                ],
            ],
        ];

        $wp_query_all = new WP_Query($avatar_brand_args_all);
        $topics_array = [];
        if ($wp_query_all->have_posts()) {
            while ($wp_query_all->have_posts()) {
                $wp_query_all->the_post();
                $post_meta_topic = get_post_meta(get_the_ID(), 'acf_article_brand_topic');
                if (is_array($post_meta_topic)) {
                    if (isset($post_meta_topic['0'])) {
                        $topic_id = $post_meta_topic[0];
                        if (! array_key_exists($topic_id, $topics_array) and $topic_id) {
                            $term = get_term($topic_id);
                            $topics_array[$topic_id] = '';
                            $topics_array[$topic_id] .= $term->name;
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
        asort($topics_array);

        return $topics_array;
    }
}

/* -------------------------------------------------------------
 * Get All category for specific Newspaper date
 * ============================================================*/

if (! function_exists('avatar_get_all_category_newspaper_cpt')) {

    function avatar_get_all_category_newspaper_cpt($cpt_post_id)
    {
        $avatar_newspaper_args_all = [
            'post_type' => 'post',
            'posts_per_page' => 200,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => 'acf_article_newspaper',
                    'value' => $cpt_post_id,
                    'compare' => '=',
                ],
            ],
        ];

        $wp_query_all = new WP_Query($avatar_newspaper_args_all);

        $topics_array = $cat_final_array = [];
        if ($wp_query_all->have_posts()) {
            while ($wp_query_all->have_posts()) {
                $wp_query_all->the_post();
                $post_meta_topic = get_post_meta(get_the_ID(), 'article_side_main_subcategory', true);
                if ($post_meta_topic) {
                    $topics_array[] = (int) $post_meta_topic;
                }
            }
            $topics_array = array_unique($topics_array, SORT_NUMERIC);
        }
        wp_reset_postdata();

        foreach ($topics_array as $value) {
            $cat_order = get_field('category_sub_cat_order', 'category_'.$value);
            $cat_order_val = $cat_order == null ? 99 : $cat_order;
            $cat_final_array[$value] = (int) $cat_order_val;
        }

        asort($cat_final_array, SORT_NUMERIC | SORT_FLAG_CASE | SORT_NATURAL);

        return $cat_final_array;
    }
}

/* -------------------------------------------------------------
 * Add CSS classes to post
 * ============================================================*/

if (! function_exists('avatar_sponsor_post')) {
    function avatar_sponsor_post($classes)
    {
        global $post;
        $article_type = get_field('acf_article_type', $post->ID);
        if ($article_type == 'feature') {
            $feature_object = get_field('acf_article_feature', $post->ID);
            if (is_object($feature_object)) {
                $is_partner = get_field('acf_feature_ispartner', $feature_object->ID);
                if ($is_partner) {
                    $classes[] .= 'sponsor_feature';
                    $classes[] .= 'sponsor_content';
                    $classes[] .= 'sponsor-bg-post';
                }
            }
        }
        if ($article_type == 'brand') {
            $classes[] .= 'sponsor_brand';
            $classes[] .= 'sponsor_content';
            $classes[] .= 'sponsor-bg-post';
        }

        return $classes;
    }
    add_filter('post_class', 'avatar_sponsor_post');
}

/* -------------------------------------------------------------
 * Remove WordPress hentry Class
 * ============================================================*/

if (! function_exists('avatar_remove_hentry')) {
    function avatar_remove_hentry($classes)
    {

        $classes = array_diff($classes, ['hentry']);

        return $classes;
    }
    add_filter('post_class', 'avatar_remove_hentry');
}

/* -------------------------------------------------------------
 * Call the the Featured Image Alt
 * ============================================================*/

if (! function_exists('avatar_get_the_post_thumbnail_alt')) {

    function avatar_get_the_post_thumbnail_alt($post_id)
    {
        return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
    }
}

/* -------------------------------------------------------------
 * Dispplay the the Featured Image Alt
 * ============================================================*/

if (! function_exists('avatar_the_post_thumbnail_alt')) {

    function avatar_the_post_thumbnail_alt($post_id)
    {
        echo avatar_get_the_post_thumbnail_alt($post_id);
    }
}

/* -------------------------------------------------------------
 * Get artciles ID for scheduler campaigns
 * ============================================================*/

if (! function_exists('avatar_get_scheduler_campaigns_articles_id')) {

    function avatar_get_scheduler_campaigns_articles_id($scheduler_campaigns_options)
    {
        if (! is_array($scheduler_campaigns_options)) {
            return;
        }
        $date_now = strtotime(date('Y-m-d H:i:s', current_time('timestamp', 0)));
        $article_list = [];

        foreach ($scheduler_campaigns_options as $key => $value) {

            if (is_int($value['article'])) {

                $campane_date_start = strtotime($value['start']);
                $campane_date_end = strtotime($value['end']);

                if (! (empty($campane_date_start) or empty($campane_date_end))) {
                    if (($campane_date_start <= $date_now) and ($campane_date_end >= $date_now)) {
                        $article_list[] = $value['article'];
                    }
                }
            }
        }

        return $article_list;
    }
}

/* -------------------------------------------------------------
 * Get the video account ID
 * ============================================================*/

if (! function_exists('avatar_get_video_brightcove_account_id')) {

    function avatar_get_video_brightcove_account_id()
    {

        return get_field('acf_brightcove_account_id', 'option');
    }
}

/* -------------------------------------------------------------
 * Get the video player ID
 * ============================================================*/

if (! function_exists('avatar_get_video_brightcove_player_id')) {

    function avatar_get_video_brightcove_player_id()
    {

        return get_field('acf_brightcove_player_id', 'option');
    }
}

/* -------------------------------------------------------------
 * Get the video vastUrl
 * ============================================================*/

if (! function_exists('avatar_get_video_brightcove_vast_url')) {

    function avatar_get_video_brightcove_vast_url()
    {

        return get_field('acf_brightcove_vast_url', 'option');
    }
}

/* -------------------------------------------------------------
 * Display the Brightcove video player
 * ============================================================*/

if (! function_exists('avatar_the_video_player')) {

    function avater_the_video_player($video_id)
    {
        $account_id = avatar_get_video_brightcove_account_id();
        $player_id = avatar_get_video_brightcove_player_id();
        $vastUrl = avatar_get_video_brightcove_vast_url();

        if (! ($account_id and $video_id)) {
            return;
        }

        if (! $player_id) {
            $player_id = 'default';
        }

        wp_enqueue_script('avatar-brightcove', 'https://players.brightcove.net/'.esc_attr($account_id).'/'.esc_attr($player_id).'_default/index.min.js', ['avatar-main'], '', 'footer');

        ?>

		<div class="video-brightcove-iframe">
			<div class="player">
				<video data-m32-vast-element data-options='{"vastUrl": "<?php echo esc_attr($vastUrl); ?>"}' style="width: 100%; height: 100%; position: absolute; top: 0px; bottom: 0px; right: 0px; left: 0px;" data-video-id="<?php echo esc_attr($video_id); ?>" data-account="<?php echo esc_attr($account_id); ?>" data-player="<?php echo esc_attr($player_id); ?>" data-embed="default" class="video-js" controls></video>
			</div>
		</div>

	<?php }
    }

/* -------------------------------------------------------------
 * Display the Brightcove video player
 * ============================================================*/

if (! function_exists('avater_the_podcast_player')) {

    function avater_the_podcast_player($podcast_url)
    {
        ?>

		<iframe width="100%" height="166" scrolling="no" frameborder="no" class="pod-player" allow="autoplay" src="<?php echo esc_attr($podcast_url); ?>&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
<?php }

    }

/* -------------------------------------------------------------
 * Get artciles ID for Featured Video
 * ============================================================*/

if (! function_exists('avatar_get_featured_video_articles_id')) {

    function avatar_get_featured_video_articles_id()
    {

        $get_video_arr = get_field('acf_featured_video', 'option');

        if (! is_array($get_video_arr)) {
            return;
        }

        foreach ($get_video_arr as $key => $value) {
            $get_video_ids[] = $value['article'];
        }

        return $get_video_ids;
    }
}

/* -------------------------------------------------------------
 * Get artciles ID for Featured Podcast
 * ============================================================*/

if (! function_exists('avatar_get_featured_podcast_articles_id')) {

    function avatar_get_featured_podcast_articles_id()
    {

        $get_podcast_arr = get_field('acf_featured_podcast', 'option');

        if (! is_array($get_podcast_arr)) {
            return;
        }

        foreach ($get_podcast_arr as $key => $value) {
            $get_podcast_ids[] = $value['article'];
        }

        return $get_podcast_ids;
    }
}

/* -------------------------------------------------------------
 *  Move Yost Meta Box to end
 * ============================================================*/

if (! function_exists('avatar_yoast_metabox_order')) {

    function avatar_yoast_metabox_order($order, $param, $user)
    {

        if (isset($order['normal'])) {
            $order_normal = $order['normal'];

            $order_normal_arr = explode(',', $order_normal);

            foreach ($order_normal_arr as $key => $val) {

                if ($val == 'wpseo_meta') {

                    $item = $order_normal_arr[$key];
                    unset($order_normal_arr[$key]);
                    array_push($order_normal_arr, $item);
                    break;
                }
            }

            return ['normal' => implode(',', $order_normal_arr)];
        } else {
            add_user_meta($user->ID, 'meta-box-order_post', '');
        }
    }
    add_filter('get_user_option_meta-box-order_post', 'avatar_yoast_metabox_order', 10, 3);
    add_filter('get_user_option_meta-box-order_page', 'avatar_yoast_metabox_order', 10, 3);
}

/* -------------------------------------------------------------
 * Get the first Year of Newspaper
 * ============================================================*/

if (! function_exists('avatar_get_first_year')) {

    function avatar_get_first_year()
    {
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'ASC',
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        $date_y = get_the_date('Y', $id_obj->posts[0]->ID);

        return $date_y;
    }
}

/* -------------------------------------------------------------
 * Get the first Year of Newspaper
 * ============================================================*/

if (! function_exists('avatar_get_first_year_by_type')) {

    function avatar_get_first_year_by_type($newspaper_type)
    {
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'ASC',

            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_newspaper_type',
                    'value' => $newspaper_type,
                    'compare' => '=',
                ],
            ],
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        $date_y = get_the_date('Y', $id_obj->posts[0]->ID);

        return $date_y;
    }
}

if (! function_exists('avatar_get_first_year_by_type_high')) {

    function avatar_get_first_year_by_type_high($newspaper_type)
    {
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'DESC',

            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_newspaper_type',
                    'value' => $newspaper_type,
                    'compare' => '=',
                ],
            ],
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        $date_y = get_the_date('Y', $id_obj->posts[0]->ID);

        return $date_y;
    }
}

if (! function_exists('avatar_is_year_by_type_exist')) {

    function avatar_is_year_by_type_exist($year, $newspaper_type)
    {
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'date_query' => [
                [
                    'year' => $year,
                ],
            ],

            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_newspaper_type',
                    'value' => $newspaper_type,
                    'compare' => '=',
                ],
            ],
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        $date_y = get_the_date('Y', $id_obj->posts[0]->ID);

        return $date_y;
    }
}

/* -------------------------------------------------------------
 * Get all Newspaper Date by Year
 * ============================================================*/

if (! function_exists('avatar_get_newspaper_by_year')) {

    function avatar_get_newspaper_by_year($year)
    {
        $newspaper_arr = [];
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 30,
            'date_query' => [
                [
                    'year' => $year,
                ],
            ],
            'orderby' => 'post_date',
            'order' => 'ASC',
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        if ($id_obj->have_posts()) {
            while ($id_obj->have_posts()) {
                $id_obj->the_post();
                $newspaper_arr[] = get_the_id();
            }
        }
        wp_reset_postdata();

        return $newspaper_arr;
    }
}

if (! function_exists('avatar_get_newspaper_by_cat')) {

    function avatar_get_newspaper_by_cat($cat_id, $year)
    {
        $newspaper_arr = [];
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 30,
            'cat' => $cat_id,
            'date_query' => [
                [
                    'year' => $year,
                ],
            ],
            /*'meta_query'        => array(
                'relation'		=> 'AND',
                array(
                'key' 		=> 'acf_newspaper_main_cat',
                'value'  	=> $cat_id,
                'compare' 	=> '='
                )
            ),*/
            'orderby' => 'post_date',
            'order' => 'ASC',
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        var_dump($id_obj);
        if ($id_obj->have_posts()) {
            while ($id_obj->have_posts()) {
                $id_obj->the_post();
                $newspaper_arr[] = get_the_id();
            }
        }
        wp_reset_postdata();

        return $newspaper_arr;
    }
}

if (! function_exists('avatar_get_newspaper_by_type')) {

    function avatar_get_newspaper_by_type($type, $year)
    {
        $newspaper_arr = [];
        $get_newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 30,
            'date_query' => [
                [
                    'year' => $year,
                ],
            ],
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_newspaper_type',
                    'value' => $type,
                    'compare' => '=',
                ],
            ],
            'orderby' => 'post_date',
            'order' => 'ASC',
        ];
        $id_obj = new WP_Query($get_newspaper_args);
        if ($id_obj->have_posts()) {
            while ($id_obj->have_posts()) {
                $id_obj->the_post();
                $newspaper_arr[] = get_the_id();
            }
        }
        wp_reset_postdata();

        return $newspaper_arr;
    }
}

/* -------------------------------------------------------------
 * Ajax function for display newspaper post by year
 * ============================================================*/

if (! function_exists('avatar_the_newspaper_year_select')) {

    function avatar_the_newspaper_year_select()
    {

        if (isset($_POST['newspaper'])) {
            $newspaper = $_POST['newspaper'];
            $newspaper_name = $_POST['newspaper_name'];
            if (($newspaper_name !== '') && ($newspaper_name !== null)) {
                $newspaper_arr = avatar_get_newspaper_by_type(stripslashes($newspaper_name), $newspaper);
            } else {
                $newspaper_arr = avatar_get_newspaper_by_year($newspaper);
            }
            echo '<option value="">'.__('Month', 'avatar-tcm').'</option>';
            foreach ($newspaper_arr as $key => $value) {
                echo '<option value="'.get_permalink($value).'">'.get_the_title($value).'</option>';
            }
        } else {
            wp_send_json_error(['message' => __('No Data', 'avatar-tcm')]);
        }
        exit;
    }
}

add_action('wp_ajax_nopriv_avatar-main', 'avatar_the_newspaper_year_select');
add_action('wp_ajax_avatar-main', 'avatar_the_newspaper_year_select');

/* -------------------------------------------------------------
 * Ajax function for display newspaper post by year
 * ============================================================*/

if (! function_exists('avatar_the_newslatter_val')) {

    function avatar_the_newslatter_val()
    {
        if (isset($_POST['newslatter_post_id'])) {
            $newsletter_id = $_POST['newslatter_post_id'];
            $newsletter_list = ['post_id' => $newsletter_id, 'title' => html_entity_decode(get_the_title($newsletter_id)), 'excerpt' => get_the_excerpt($newsletter_id)];
            wp_send_json($newsletter_list);
        } else {
            wp_send_json_error(['message' => __('No Data', 'avatar-tcm')]);
        }
        exit;
    }
}

add_action('wp_ajax_nopriv_avatar-admin', 'avatar_the_newslatter_val');
add_action('wp_ajax_avatar-admin', 'avatar_the_newslatter_val');

/* -------------------------------------------------------------
 * Get sponsor's information from an article
 * ============================================================*/

if (! function_exists('avatar_get_sponsor_info')) {
    function avatar_get_sponsor_info($post_id)
    {
        if (get_field('acf_article_sponsor', $post_id)) {
            //  Basic term object
            $sponsor = get_term(get_field('acf_article_sponsor', $post_id), 'post_sponsor');
            // Add 'External link' to object
            $sponsor->{'external_link'} = get_field('acf_sponsor_external_link', $sponsor->taxonomy.'_'.$sponsor->term_id);
            // Add 'Logo' to object
            $sponsor->{'logo'} = get_field('acf_sponsor_logo', $sponsor->taxonomy.'_'.$sponsor->term_id);

            return $sponsor;
        }
    }
}

/* -------------------------------------------------------------
 * Get sponsor's information from a category
 * ============================================================*/

if (! function_exists('avatar_get_sponsor_info_categ')) {
    function avatar_get_sponsor_info_categ($categ_obj)
    {
        if (get_field('acf_category_sponsor', $categ_obj)) {
            //  Basic term object
            $sponsor = get_term(get_field('acf_category_sponsor', $categ_obj), 'post_sponsor');
            // Add 'External link' to object
            $sponsor->{'external_link'} = get_field('acf_sponsor_external_link', $sponsor->taxonomy.'_'.$sponsor->term_id);
            // Add 'Logo' to object
            $sponsor->{'logo'} = get_field('acf_sponsor_logo', $sponsor->taxonomy.'_'.$sponsor->term_id);

            return $sponsor;
        }
    }
}

/* -------------------------------------------------------------
 * Add a class filter for post
 * ============================================================*/

if (! function_exists('avatar_set_row_post_class')) {
    /**
     * @return array
     */
    function avatar_set_row_post_class($classes, $class, $post_id)
    {

        $avatar_sponsor_obj = avatar_get_sponsor_info($post_id);
        if (is_object($avatar_sponsor_obj)) {
            $classes[] = 'sponsor_content sponsor-bg';
        }

        // Return the classes array
        return $classes;
    }
    add_filter('post_class', 'avatar_set_row_post_class', 10, 3);
}

if (! function_exists('hide_post_visibility_types')) {

    function hide_post_visibility_types($request)
    {
        unset($request['post_front']);
        unset($request['post_author']);
        unset($request['post_archive']);
        unset($request['post_recent']);
        unset($request['post_rel']);
        echo '<style>#hidepostdivpost .inside div div {display: none;}</style>';

        return $request;
    }

    add_filter('wphp_post_visibility_types', 'hide_post_visibility_types');
}

/* -------------------------------------------------------------
 * Display sponsor info for articles
 * ============================================================*/

if (! function_exists('avatar_display_post_sponsor')) {
    /**
     * @param  bool  $single
     */
    function avatar_display_post_sponsor($post_id, $single = true, $presented_by = 'Presented by:', $embedded = true)
    {

        $avatar_sponsor_obj = avatar_get_sponsor_info($post_id);

        if (is_object($avatar_sponsor_obj)) { ?>
			<?php if (! $single) {
			    if ($embedded) {
			        echo '<p class="text-content__excerpt sponsor-details">';
			    }
			    printf(__('Brought to you by: %s', 'avatar-tcm'), '<span>'.wp_kses_post($avatar_sponsor_obj->name).'<span>');
			    if ($embedded) {
			        echo '</p>';
			    }
			} else { ?>
				<div class="sponsor-logo">
					<?php if (trim($presented_by) != '') { ?>
					<span class="presented-label"><?php _e($presented_by, 'avatar-tcm'); ?></span>
					<?php } ?>
					<?php echo $avatar_sponsor_obj->external_link != '' ? "<a href='".esc_url($avatar_sponsor_obj->external_link)."' target='_blank'>" : ''; ?>
					<figure>
						<img src='<?php echo esc_url($avatar_sponsor_obj->logo['sizes']['thumbnail']); ?>' alt='<?php echo esc_attr($avatar_sponsor_obj->logo['name']); ?>' >
					</figure>
					<?php echo $avatar_sponsor_obj->external_link != '' ? '</a>' : ''; ?>
				</div>
			<?php } ?>
		<?php }
        }
}

if (! function_exists('avatar_display_speaker_campanie_name')) {

    function avatar_display_speaker_campanie_name($post_id)
    {

        $avatar_sponsor_obj = avatar_get_sponsor_info($post_id);
        if (! empty($avatar_sponsor_obj) && trim($avatar_sponsor_obj->name) !== '') {
            _e('From: ', 'avatar-tcm');
            echo $avatar_sponsor_obj->external_link != '' ? "<a href='".esc_url($avatar_sponsor_obj->external_link)."' target='_blank'>" : "<a href='".esc_url(get_tag_link($avatar_sponsor_obj->term_id))."'>";
            echo $avatar_sponsor_obj->name;
            echo '</a>';

            return true;
        }

        return false;
    }
}

/* -------------------------------------------------------------
 * Display fund for author by article
 * ============================================================*/

if (! function_exists('avatar_display_fund_by_article')) {
    /**
     * @param  bool  $single
     */
    function avatar_display_fund_by_article($post_id)
    {
        $authors_list = get_field('acf_article_author', $post_id);
        if ($authors_list) {
            foreach ($authors_list as $author) {
                if (is_object($author)) {
                    $isSpeaker = get_field('acf_author_is_speaker', $author->ID);
                    if (have_rows('acf_author_fund', $author->ID)) {
                        echo '<dl class="pub-details fund"><dt>';
                        _e('Funds:', 'avatar-tcm');
                        echo '</dt>';
                        while (have_rows('acf_author_fund', $author->ID)) {
                            $term = get_term(the_row());
                            $URL = get_field('acf_fund_url', $term);
                            echo '<dd>'.($URL !== '' ? '<a href="'.$URL.'" target="_blank">' : '').$term->name.($URL !== '' ? '</a>' : '').'</dd>';
                        }
                        echo '</dl>';
                    }
                }
            }
        }
    }
}
