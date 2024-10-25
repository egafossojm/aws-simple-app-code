<?php
/**
 * Custom Functions for homepage
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 * Return array of news for Homepage (data from options)
 * ============================================================*/
if (! function_exists('avatar_get_news_homepage')) {

    function avatar_get_news_homepage($fields_arr)
    {

        if (! is_array($fields_arr)) {
            return;
        }
        $output = [];
        foreach ($fields_arr as $key2 => $value) {

            if ($value['article']) {
                $current_post_id = $value['article'];
                $output[$key2]['article']['id'] = $current_post_id;
                if (get_field('acf_article_thumbnail_show', $current_post_id) && has_post_thumbnail($current_post_id)) {
                    $output[$key2]['article']['featured_image'] = wp_get_attachment_url(get_post_thumbnail_id($current_post_id));
                }
            }
            if (is_array($value['homepage_r_linked_article'])) {
                foreach ($value['homepage_r_linked_article'] as $key_linked_article => $value_linked_article) {
                    $article_id = $value_linked_article['homepage_linked_article'];
                    if (get_post_status($article_id) == 'publish') {
                        $output[$key2]['homepage_r_linked_article'][$key_linked_article]['id'] = $article_id;
                    }
                }
            }
        }

        return $output;
    }
}
