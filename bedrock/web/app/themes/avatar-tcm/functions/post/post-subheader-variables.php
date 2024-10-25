<?php
/* -------------------------------------------------------------
 * Gather all the conditional variables for an article (single.php)
 * ============================================================*/

//Initiliaziation
$post_id = get_the_ID();
$is_columnist = $sponsor_object = $is_brand = $is_partner = $is_regular_feature = false;

// Columnist informations

if ($author_id = avatar_is_columnist($post_id)) {
    $is_columnist = true;
    $author_obj = get_post($author_id);
    $author_name = $author_obj->post_title;
    //to be at single author
    $columns = get_term(get_field('acf_author_column', $author_id), 'post_column');
    $author_link = get_permalink($author_id);
}

// Feature informations
if (avatar_is_feature($post_id)) {
    $feature_object = get_field('acf_article_feature');
    $is_regular_feature = true;
    //Gather Feature Informations
    $feature_id = $feature_object->ID;
    $feature_title = $feature_object->post_title;
    $sponsor_link = get_permalink($feature_id);
    $sponsor_image = get_field('acf_feature_image1', $feature_id);
    $sponsor_title = get_field('acf_feature_image_alt', $feature_id);
    $sponsor_website = get_field('acf_feature_website', $feature_id);
    if ($is_partner = avatar_is_partner($post_id)) {
        $is_regular_feature = false;
        //Gather Partner Informations
        $sponsor_title_box = get_field('acf_in_depth_partner_report_info_title', 'option');
        $sponsor_desc_box = get_field('acf_in_depth_partner_report_info_desc', 'option');
        $partner_id = get_field('acf_in_depth_partner_report', 'option');
        $partner_page_title = $partner_id ? get_the_title($partner_id) : '';

        $sponsor_object = get_field('acf_feature_partner', $feature_id);
        $sponsor_id = $sponsor_object->ID;
        $sponsor_title = $sponsor_object->post_title;
        $sponsor_image = get_the_post_thumbnail_url($sponsor_id);
        $sponsor_website = get_field('acf_partner_website', $sponsor_id);
        $sponsor_linkedin = get_field('acf_partner_linkedin', $sponsor_id);
        $sponsor_twitter = get_field('acf_partner_twitter', $sponsor_id);
        $sponsor_facebook = get_field('acf_partner_facebook', $sponsor_id);
    }
}

// Brand informations
if (avatar_is_brand($post_id)) {
    $is_brand = true;
    $sponsor_title_box = get_field('acf_brand_knowledge_info_title', 'option');
    $sponsor_desc_box = get_field('acf_brand_knowledge_info_desc', 'option');
    $brand_page_obj = get_field('acf_brand_knowledge_page', 'option');
    $brand_page_title = $brand_page_obj ? get_the_title($brand_page_obj->ID) : '';
}

//Microsite information
if (avatar_is_microsite($post_id)) {
    $is_microsite = true;
    $microsite_object = get_field('acf_article_microsite');
    $microsite_id = $microsite_object->ID;
    $microsite_title = $microsite_object->post_title;
    $microsite_excerpt = $microsite_object->post_excerpt;
    $microsite_link = get_permalink($microsite_id);

    /*if (has_post_thumbnail($microsite_id ) ){
        $avatar_thumbnail_caption = get_the_post_thumbnail_caption( $microsite_id  );
        $microsite_banner = wp_get_attachment_image_url( get_post_thumbnail_id( $microsite_id ), $size = 'medium_large' );

    }*/

    $partner_banner = get_field('acf_microsite_partner_banner', $microsite_id);

    $partner_logo = get_field('acf_microsite_partner_logo', $microsite_id);
    $partner_link = get_field('acf_microsite_partner_url', $microsite_id);
    $partner_name = get_field('acf_microsite_partner_name', $microsite_id);
    $partner_background = get_field('acf_microsite_banner_color_picker', $microsite_id);

}
