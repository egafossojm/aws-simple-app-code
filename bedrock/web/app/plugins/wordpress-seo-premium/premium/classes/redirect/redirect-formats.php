<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Class representing a list of redirect formats.
 */
class WPSEO_Redirect_Formats
{
    const PLAIN = 'plain';

    const REGEX = 'regex';

    /**
     * Returns the redirect formats.
     *
     * @return array Array with the redirect formats.
     */
    public function get()
    {
        return [
            self::PLAIN => __('Redirects', 'wordpress-seo-premium'),
            self::REGEX => __('Regex Redirects', 'wordpress-seo-premium'),
        ];
    }

    /**
     * Checks whether the given value is a valid redirect format.
     *
     * @param  string  $value  Value to check.
     * @return bool True if a redirect format, false otherwise.
     */
    public function has($value)
    {
        $formats = $this->get();

        return isset($formats[$value]);
    }
}
