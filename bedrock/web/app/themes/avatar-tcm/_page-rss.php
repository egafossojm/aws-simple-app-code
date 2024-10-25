<?php
/**
 * Template Name: RSS Feeds
 *
 * This is the template that displays all RSS feeds
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header();

$feed_for_categories = get_categories(
    [
        'taxonomy' => 'category',
        'hierarchical' => false,
        'parent' => 0, // Only parent category
        'hide_empty' => true,
        'orderby' => 'name',
        'exclude' => [1], // Uncategorized
    ]
);

if (is_array($feed_for_categories)) {
    $html_feed = '<ul class="rss">';
    foreach ($feed_for_categories as $cat => $value) {
        $html_feed .= '<li><a href="'.get_term_feed_link($value->term_id).'">'.esc_html($value->name).'</a></li>';
    }
    $html_feed .= '</ul>';
}

echo $html_feed;
?>



<?php get_footer(); ?>
