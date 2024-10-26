<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Saving the redirects from a single file into two smaller options files.
 */
class WPSEO_Redirect_Option_Exporter implements WPSEO_Redirect_Exporter
{
    /**
     * This method will split the redirects in separate arrays and store them in an option.
     *
     * @param  WPSEO_Redirect[]  $redirects  The redirects to export.
     * @return bool
     */
    public function export($redirects)
    {
        $formatted_redirects = [
            WPSEO_Redirect_Formats::PLAIN => [],
            WPSEO_Redirect_Formats::REGEX => [],
        ];

        foreach ($redirects as $redirect) {
            $formatted_redirects[$redirect->get_format()][$redirect->get_origin()] = $this->format($redirect);
        }

        // Save the plain redirects. No need to autoload, since the option is fetched straight from the DB.
        update_option(WPSEO_Redirect_Option::OPTION_PLAIN, $formatted_redirects[WPSEO_Redirect_Formats::PLAIN], 'no');

        // Save the regex redirects. No need to autoload, since the option is fetched straight from the DB.
        update_option(WPSEO_Redirect_Option::OPTION_REGEX, $formatted_redirects[WPSEO_Redirect_Formats::REGEX], 'no');

        return true;
    }

    /**
     * Formats a redirect for use in the export.
     *
     * @param  WPSEO_Redirect  $redirect  The redirect to format.
     * @return mixed
     */
    public function format(WPSEO_Redirect $redirect)
    {
        return [
            'url' => $redirect->get_target(),
            'type' => $redirect->get_type(),
        ];
    }
}
