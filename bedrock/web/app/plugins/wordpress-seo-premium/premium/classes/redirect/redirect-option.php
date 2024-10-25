<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Class handling the redirect options.
 */
class WPSEO_Redirect_Option
{
    /**
     * The plain redirect option before 3.1.
     */
    const OLD_OPTION_PLAIN = 'wpseo-premium-redirects';

    /**
     * The regex redirect option before 3.1.
     */
    const OLD_OPTION_REGEX = 'wpseo-premium-redirects-regex';

    /**
     * The option which contains the redirects base.
     *
     * @since 3.1
     */
    const OPTION = 'wpseo-premium-redirects-base';

    /**
     * The option which contains the  plain redirects.
     *
     * @since 3.1
     */
    const OPTION_PLAIN = 'wpseo-premium-redirects-export-plain';

    /**
     * The option which contains the regex redirects.
     *
     * @since 3.1
     */
    const OPTION_REGEX = 'wpseo-premium-redirects-export-regex';

    /**
     * List of redirects.
     *
     * @var WPSEO_Redirect[]
     */
    private $redirects = [];

    /**
     * Constructor.
     *
     * @param  bool  $retrieve_redirects  Whether to retrieve the redirects on construction.
     */
    public function __construct($retrieve_redirects = true)
    {
        if ($retrieve_redirects) {
            $this->redirects = $this->get_all();
        }
    }

    /**
     * Getting the array with all the redirects.
     *
     * @return WPSEO_Redirect[]
     */
    public function get_all()
    {
        $redirects = $this->get_from_option();

        array_walk($redirects, [$this, 'map_option_to_object']);

        return $redirects;
    }

    /**
     * Check if the old redirect doesn't exist already, if not it will be added.
     *
     * @param  WPSEO_Redirect  $redirect  The redirect object to save.
     * @return bool
     */
    public function add(WPSEO_Redirect $redirect)
    {
        if ($this->search($redirect->get_origin()) === false) {
            $this->run_redirects_modified_action($redirect);

            $this->redirects[] = $redirect;

            return true;
        }

        return false;
    }

    /**
     * Check if the $current_redirect exists and remove it if so.
     *
     * @param  WPSEO_Redirect  $current_redirect  The current redirect value.
     * @param  WPSEO_Redirect  $redirect  The redirect object to save.
     * @return bool
     */
    public function update(WPSEO_Redirect $current_redirect, WPSEO_Redirect $redirect)
    {
        $found = $this->search($current_redirect->get_origin());
        if ($found !== false) {
            $this->run_redirects_modified_action($redirect);

            $this->redirects[$found] = $redirect;

            return true;
        }

        return false;
    }

    /**
     * Deletes the given redirect from the array.
     *
     * @param  WPSEO_Redirect  $current_redirect  The redirect that will be removed.
     * @return bool
     */
    public function delete(WPSEO_Redirect $current_redirect)
    {
        $found = $this->search($current_redirect->get_origin());
        if ($found !== false) {
            $this->run_redirects_modified_action($current_redirect);

            unset($this->redirects[$found]);

            return true;
        }

        return false;
    }

    /**
     * Get a redirect from the array.
     *
     * @param  string  $origin  The redirects origin to search for.
     * @return WPSEO_Redirect|bool
     */
    public function get($origin)
    {
        $found = $this->search($origin);
        if ($found !== false) {
            return $this->redirects[$found];
        }

        return false;
    }

    /**
     * Check if the $origin already exists as a key in the array.
     *
     * @param  string  $origin  The redirect to search for.
     * @return int|bool
     */
    public function search($origin)
    {
        foreach ($this->redirects as $redirect_key => $redirect) {
            if ($redirect->origin_is($origin)) {
                return $redirect_key;
            }
        }

        return false;
    }

    /**
     * Saving the redirects.
     *
     * @param  bool  $retry_upgrade  Whether or not to retry the 3.1 upgrade. Used to prevent infinite recursion.
     */
    public function save($retry_upgrade = true)
    {
        $redirects = $this->redirects;

        // Retry the 3.1 upgrade routine to make sure we're always dealing with valid redirects.
        $upgrade_manager = new WPSEO_Upgrade_Manager;
        if ($retry_upgrade && $upgrade_manager->should_retry_upgrade_31()) {
            $upgrade_manager->retry_upgrade_31(true);
            $redirects = array_merge($redirects, $this->get_all());
        }

        array_walk($redirects, [$this, 'map_object_to_option']);

        // Update the database option.
        update_option(self::OPTION, apply_filters('wpseo_premium_save_redirects', $redirects), false);
    }

    /**
     * Setting the redirects property.
     *
     * @param  string  $option_name  The target option name.
     * @return array
     */
    public function get_from_option($option_name = self::OPTION)
    {
        $redirects = apply_filters('wpseo_premium_get_redirects', get_option($option_name));
        if (! is_array($redirects)) {
            $redirects = [];
        }

        return $redirects;
    }

    /**
     * Runs the redirects modified hook with the altered redirect as input.
     *
     * @param  WPSEO_Redirect  $redirect  The redirect that has been altered.
     * @return void
     */
    protected function run_redirects_modified_action(WPSEO_Redirect $redirect)
    {
        /**
         * Filter: wpseo_premium_redirects_modified - Allow developers run actions when the redirects are modified.
         *
         * @api   string $origin The redirect origin.
         *
         * @param  string  $target  The redirect target.
         * @param  int  $type  The redirect type (301, 404, 410, etc).
         */
        do_action('wpseo_premium_redirects_modified', $redirect->get_origin(), $redirect->get_target(), $redirect->get_type());
    }

    /**
     * Maps the array values to a redirect object.
     *
     * @param  array  $redirect_values  The data for the redirect option.
     */
    private function map_option_to_object(array &$redirect_values)
    {
        $redirect_values = new WPSEO_Redirect($redirect_values['origin'], $redirect_values['url'], $redirect_values['type'], $redirect_values['format']);
    }

    /**
     * Maps a redirect object to an array option.
     *
     * @param  WPSEO_Redirect  $redirect  The redirect to map.
     */
    private function map_object_to_option(WPSEO_Redirect &$redirect)
    {
        $redirect = [
            'origin' => $redirect->get_origin(),
            'url' => $redirect->get_target(),
            'type' => $redirect->get_type(),
            'format' => $redirect->get_format(),
        ];
    }
}
