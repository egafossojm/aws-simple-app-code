<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

/**
 * Allow to purge the Varnish cache
 *
 * @since 2.6.8
 *
 * @param bool true will force the Varnish purge
 */
if (apply_filters('do_rocket_varnish_http_purge', false) || get_rocket_option('varnish_auto_purge', 0)) {
    /**
     * Purge all the domain
     *
     * @since 2.6.8
     *
     * @param  string  $root  The path of home cache file.
     * @param  string  $lang  The current lang to purge.
     * @param  string  $url  The home url.
     */
    function rocket_varnish_clean_domain($root, $lang, $url)
    {
        rocket_varnish_http_purge(trailingslashit($url).'?vregex');
    }
    add_action('before_rocket_clean_domain', 'rocket_varnish_clean_domain', 10, 3);

    /**
     * Purge a specific page
     *
     * @since 2.6.8
     *
     * @param  string  $url  The url to purge.
     */
    function rocket_varnish_clean_file($url)
    {
        rocket_varnish_http_purge(trailingslashit($url).'?vregex');
    }
    add_action('before_rocket_clean_file', 'rocket_varnish_clean_file');

    /**
     * Purge the homepage and its pagination
     *
     * @since 2.6.8
     *
     * @param  string  $root  The path of home cache file.
     * @param  string  $lang  The current lang to purge.
     */
    function rocket_varnish_clean_home($root, $lang)
    {
        $home_url = trailingslashit(get_rocket_i18n_home_url($lang));
        $home_pagination_url = $home_url.trailingslashit($GLOBALS['wp_rewrite']->pagination_base).'?vregex';

        rocket_varnish_http_purge($home_url);
        rocket_varnish_http_purge($home_pagination_url);
    }
    add_action('before_rocket_clean_home', 'rocket_varnish_clean_home', 10, 2);
}
