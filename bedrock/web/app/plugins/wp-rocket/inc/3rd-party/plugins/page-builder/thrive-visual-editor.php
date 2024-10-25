<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

if (function_exists('tve_editor_url')) {
    /**
     * Forces Thrive Visual Editor’s bot detection to assume a human visitor.
     *
     * @since 2.8.11
     *
     * @author Remy Perona
     *
     * @param  bool|int  $bot_detection  1|0 when crawler has|not been detected, FALSE when user agent string is unavailable
     * @return int
     */
    add_filter('tve_dash_is_crawler', '__return_zero', PHP_INT_MAX);
}
