<?php

$post_id = get_the_ID();

if (get_field('acf_article_type') == 'careers') {

    // Include Career
    avatar_article_career_info($post_id);
}

if (get_field('acf_article_type') == 'feature' and $feature_obj = get_field('acf_article_feature')) {

    // Include Related Featured Articles
    avatar_the_related_featured_articles($feature_obj->ID, $post_id);

} elseif (get_field('acf_article_type') == 'brand' and $brand_obj = get_field('acf_article_brand')) {

    // Include Related Partner Articles
    avatar_the_related_brand_articles($brand_obj->ID, $post_id);

} else {

    // Include Related Articles
    $main_sub_category_id = get_field('article_side_main_subcategory', $post_id);
    $posttags = get_the_tags();
    avatar_the_related_articles($post_id, $main_sub_category_id, $posttags);

}

// Include tags
avatar_article_taxonomies_tags();

//Include Comapnies
avatar_company_taxonomies_tags();

//Include Documents
avatar_article_documents();
