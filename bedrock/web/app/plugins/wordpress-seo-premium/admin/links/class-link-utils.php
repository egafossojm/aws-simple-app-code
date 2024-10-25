<?php
/**
 * WPSEO plugin file.
 */

/**
 * Represents the utils for the links module.
 */
class WPSEO_Link_Utils
{
    /**
     * Returns the value that is part of the given url.
     *
     * @param  string  $url  The url to parse.
     * @param  string  $part  The url part to use.
     * @return string The value of the url part.
     */
    public static function get_url_part($url, $part)
    {
        $url_parts = wp_parse_url($url);

        if (isset($url_parts[$part])) {
            return $url_parts[$part];
        }

        return '';
    }
}
