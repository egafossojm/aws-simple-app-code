<?php

/**
 * Class for loading redirects from the Redirection plugin.
 */
class WPSEO_Redirect_Redirection_Loader extends WPSEO_Redirect_Abstract_Loader
{
    /**
     * @var wpdb A WordPress database object.
     */
    protected $wpdb;

    /**
     * WPSEO_Redirect_Redirection_Loader constructor.
     *
     * @param  wpdb  $wpdb  A WordPress database object.
     */
    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    /**
     * Loads redirects as WPSEO_Redirects from the Redirection plugin.
     *
     * @return WPSEO_Redirect[] The loaded redirects.
     */
    public function load()
    {
        // Get redirects.
        $items = $this->wpdb->get_results(
            "SELECT `url`, `action_data`, `regex`, `action_code`
				FROM {$this->wpdb->prefix}redirection_items
				WHERE `status` = 'enabled' AND `action_type` = 'url'"
        );

        $redirects = [];

        foreach ($items as $item) {
            $format = WPSEO_Redirect::FORMAT_PLAIN;
            if ((int) $item->regex === 1) {
                $format = WPSEO_Redirect::FORMAT_REGEX;
            }

            if (! $this->validate_status_code($item->action_code)) {
                continue;
            }

            $redirects[] = new WPSEO_Redirect($item->url, $item->action_data, $item->action_code, $format);
        }

        return $redirects;
    }
}
