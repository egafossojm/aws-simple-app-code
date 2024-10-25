<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Class representing a list of redirect types.
 */
class WPSEO_Redirect_Types
{
    const TEMPORARY = 307;

    const UNAVAILABLE = 451;

    const DELETED = 410;

    const FOUND = 302;

    const PERMANENT = 301;

    /**
     * Returns the redirect types.
     *
     * @return array Array with the redirect types.
     */
    public function get()
    {
        $redirect_types = [
            '301' => __('301 Moved Permanently', 'wordpress-seo-premium'),
            '302' => __('302 Found', 'wordpress-seo-premium'),
            '307' => __('307 Temporary Redirect', 'wordpress-seo-premium'),
            '410' => __('410 Content Deleted', 'wordpress-seo-premium'),
            '451' => __('451 Unavailable For Legal Reasons', 'wordpress-seo-premium'),
        ];

        return apply_filters('wpseo_premium_redirect_types', $redirect_types);
    }

    /**
     * Checks whether the given value is a valid redirect type.
     *
     * @param  string  $value  Value to check.
     * @return bool True if a redirect type, false otherwise.
     */
    public function has($value)
    {
        $types = $this->get();

        return isset($types[$value]);
    }
}
