<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_Export.
 *
 * Class with functionality to export the WP SEO settings.
 */
class WPSEO_Export
{
    /**
     * @var string
     */
    const NONCE_ACTION = 'wpseo_export';

    /**
     * @var string
     */
    private $export = '';

    /**
     * @var string
     */
    private $error = '';

    /**
     * @var bool
     */
    public $success;

    /**
     * Handles the export request.
     */
    public function export()
    {
        check_admin_referer(self::NONCE_ACTION);
        $this->export_settings();
        $this->output();
    }

    /**
     * Outputs the export.
     */
    public function output()
    {
        if (! WPSEO_Capability_Utils::current_user_can('wpseo_manage_options')) {
            esc_html_e('You do not have the required rights to export settings.', 'wordpress-seo');

            return;
        }

        echo '<p>';
        printf(
            /* translators: %1$s expands to Import settings */
            esc_html__(
                'Copy all these settings to another site\'s %1$s tab and click "%1$s" there.',
                'wordpress-seo'
            ),
            esc_html__(
                'Import settings',
                'wordpress-seo'
            )
        );
        echo '</p>';
        echo '<textarea id="wpseo-export" rows="20" cols="100">'.$this->export.'</textarea>';
    }

    /**
     * Returns true when the property error has a value.
     *
     * @return bool
     */
    public function has_error()
    {
        return  $this->error !== '';
    }

    /**
     * Sets the error hook, to display the error to the user.
     */
    public function set_error_hook()
    {
        /* translators: %1$s expands to Yoast SEO */
        $message = sprintf(__('Error creating %1$s export: ', 'wordpress-seo'), 'Yoast SEO').$this->error;

        printf(
            '<div class="notice notice-error"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Exports the current site's WP SEO settings.
     */
    private function export_settings()
    {
        $this->export_header();

        foreach (WPSEO_Options::get_option_names() as $opt_group) {
            $this->write_opt_group($opt_group);
        }
    }

    /**
     * Writes the header of the export.
     */
    private function export_header()
    {
        $header = sprintf(
            /* translators: %1$s expands to Yoast SEO, %2$s expands to Yoast.com */
            esc_html__('These are settings for the %1$s plugin by %2$s', 'wordpress-seo'),
            'Yoast SEO',
            'Yoast.com'
        );
        $this->write_line('; '.$header);
    }

    /**
     * Writes a line to the export.
     *
     * @param  string  $line  Line string.
     * @param  bool  $newline_first  Boolean flag whether to prepend with new line.
     */
    private function write_line($line, $newline_first = false)
    {
        if ($newline_first) {
            $this->export .= PHP_EOL;
        }
        $this->export .= $line.PHP_EOL;
    }

    /**
     * Writes an entire option group to the export.
     *
     * @param  string  $opt_group  Option group name.
     */
    private function write_opt_group($opt_group)
    {

        $this->write_line('['.$opt_group.']', true);

        $options = get_option($opt_group);

        if (! is_array($options)) {
            return;
        }

        foreach ($options as $key => $elem) {
            if (is_array($elem)) {
                $count = count($elem);
                for ($i = 0; $i < $count; $i++) {
                    $this->write_setting($key.'[]', $elem[$i]);
                }
            } else {
                $this->write_setting($key, $elem);
            }
        }
    }

    /**
     * Writes a settings line to the export.
     *
     * @param  string  $key  Key string.
     * @param  string  $val  Value string.
     */
    private function write_setting($key, $val)
    {
        if (is_string($val)) {
            $val = '"'.$val.'"';
        }
        $this->write_line($key.' = '.$val);
    }
}
