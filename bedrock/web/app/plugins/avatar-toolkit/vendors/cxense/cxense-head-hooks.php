<?php
/* -------------------------------------------------------------
 * cXsense meta data for Article
 * ============================================================*/

if (! function_exists('at_cxsense_meta_tag')) {

    function at_cxsense_meta_tag()
    {

        if (is_singular('post')) {

            global $post;

            $article_id = $post->ID;
            $title = $post->post_title;

            if (! empty($title)) {
                $meta_array = '<meta name="cxenseparse:tcm-title" content="'.$title.'" />'."\r\n";
                $meta_array .= '<meta name="cxenseparse:title" content="'.$title.'" />'."\r\n";

            }
            $meta_array .= '<meta name="cxenseparse:tcm-pagetype" content="article" />'."\r\n";

            $current_main_sub_category_id = get_field('article_side_main_subcategory', $article_id);
            $current_main_sub_category_name = '';
            $current_main_category_parent_name = '';
            if (! empty($current_main_sub_category_id)) {
                $current_main_sub_category_object = get_category($current_main_sub_category_id);
                $current_main_sub_category_name = $current_main_sub_category_object->name;

                $meta_array .= '<meta name="cxenseparse:tcm-sitesubsection" content="'.$current_main_sub_category_name.'" />'."\r\n";

                $current_main_category_parent_id = $current_main_sub_category_object->category_parent;
                if (! empty($current_main_category_parent_id)) {
                    $current_main_category_parent_object = get_category($current_main_category_parent_id);
                    $current_main_category_parent_name = $current_main_category_parent_object->name;

                    $meta_array .= '<meta name="cxenseparse:tcm-sitesection" content="'.$current_main_category_parent_name.'" />'."\r\n";
                }
            }

            $author_names = '';
            $obj_authors = get_field('acf_article_author', $article_id);
            if (! empty($obj_authors) && count($obj_authors) > 0) {
                foreach ($obj_authors as $author) {
                    $author_names .= ', '.$author->post_title;
                }
                $author_names = substr($author_names, 2);
                $meta_array .= '<meta name="cxenseparse:tcm-author" content="'.$author_names.'" />'."\r\n";
            }
            $description = get_the_excerpt($article_id);

            $meta_array .= '<meta name="cxenseparse:tcm-description" content="'.$description.'" />'."\r\n";
            $posttags = get_the_tags($article_id);

            $output = '';
            if (! empty($posttags)) {
                foreach ($posttags as $tag) {
                    $output .= ', '.$tag->name;
                }
            }
            if (strlen($output) > 2) {
                $tags = substr($output, 2);
                $meta_array .= '<meta name="cxenseparse:tcm-keywords" content="'.$tags.'" />'."\r\n";
            }

            $post_date = $post->post_date;
            $publish_date = '';
            if (! empty($post_date)) {
                $publish_date = date('Y-m-d\TH:i:s', strtotime($post_date));
                $meta_array .= '<meta name="cxenseparse:recs:publishtime" content="'.$publish_date.'" />'."\r\n";
            }

            $thumbnail_url = get_the_post_thumbnail_url($article_id, 'large');

            if (! empty($thumbnail_url)) {
                $meta_array .= '<meta name="cxenseparse:recs:image" content="'.$thumbnail_url.'" />'."\r\n";
            }
            $meta_array .= '<meta name="cxenseparse:recs:recommendable" content="true" />'."\r\n";
            $meta_array .= '<meta name="cxenseparse:recs:recommending" content="true" />'."\r\n";
            $meta_array .= '<meta name="cxenseparse:recs:articleid" content="'.$article_id.'" />'."\r\n";
            if (! empty($current_main_sub_category_name)) {
                $meta_array .= '<meta name="cxenseparse:recs:category" content="'.$current_main_sub_category_name.'" />'."\r\n";
            }
            echo $meta_array;
        }
    }

    add_action('wp_head', 'at_cxsense_meta_tag', 0);

}
