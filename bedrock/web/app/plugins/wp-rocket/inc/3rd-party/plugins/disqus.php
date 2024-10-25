<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

if (defined('DISQUS_VERSION')) {
    /**
     * Excludes Disqus scripts from JS minification
     *
     * @since 2.9
     *
     * @author Remy Perona
     *
     * @param  array  $excluded_js  An array of JS handles enqueued in WordPress.
     * @return array the updated array of handles
     */
    function rocket_exclude_js_disqus($excluded_js)
    {
        $excluded_js[] = str_replace(home_url(), '', plugins_url('/disqus-comment-system/media/js/disqus.js'));
        $excluded_js[] = str_replace(home_url(), '', plugins_url('/disqus-comment-system/media/js/count.js'));

        return $excluded_js;
    }
    add_filter('rocket_exclude_js', 'rocket_exclude_js_disqus');
}
