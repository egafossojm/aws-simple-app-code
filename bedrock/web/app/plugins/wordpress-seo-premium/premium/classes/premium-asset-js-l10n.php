<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Localizes JavaScript files.
 */
final class WPSEO_Premium_Asset_JS_L10n
{
    /**
     * Localizes the given script with the JavaScript translations.
     *
     * @param  string  $script_handle  The script handle to localize for.
     * @return void
     */
    public function localize_script($script_handle)
    {
        $translations = [
            'wordpress-seo-premium' => $this->get_translations('wordpress-seo-premiumjs'),
        ];
        wp_localize_script($script_handle, 'wpseoPremiumJSL10n', $translations);
    }

    /**
     * Returns translations necessary for JS files.
     *
     * @param  string  $component  The component to retrieve the translations for.
     * @return object The translations in a Jed format for JS files.
     */
    protected function get_translations($component)
    {
        $locale = WPSEO_Language_Utils::get_user_locale();

        $file = plugin_dir_path(WPSEO_FILE).'premium/languages/'.$component.'-'.$locale.'.json';
        if (file_exists($file)) {
            $file = file_get_contents($file);
            if (is_string($file) && $file !== '') {
                return json_decode($file, true);
            }
        }

        return null;
    }
}
