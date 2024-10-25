<?php

defined('ABSPATH') || exit('Cheatin\' uh?');

/**
 * Clear cache when ACF options page is updated.
 *
 * @since 2.10.7
 *
 * @author Remy Perona
 *
 * @param  string  $post_id  ACF options page ID is 'options'.
 */
function rocket_clear_cache_on_acf_options_save($post_id)
{
    if ($post_id === 'options') {
        rocket_clean_domain();
    }
}
add_action('acf/save_post', 'rocket_clear_cache_on_acf_options_save');
