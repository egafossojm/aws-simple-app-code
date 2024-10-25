<?php
/* -------------------------------------------------------------
 * Manual related article into body of article - AVAIE-308
 * ============================================================*/

/* -------------------------------------------------------------
 * Setup Read Also Button
 * ============================================================*/

if (! function_exists('avatar_mce_read_also_setup')) {
    function avatar_mce_read_also_setup()
    {

        // Registers an editor stylesheet
        // Style is in editorstyle.css global (theme)

        // TinyMCE Button
        add_action('init', 'avatar_mce_read_also_buttons');
    }

    add_action('after_setup_theme', 'avatar_mce_read_also_setup');
}

/* -------------------------------------------------------------
 * Create Button for TME
 * ============================================================*/

if (! function_exists('avatar_mce_read_also_buttons')) {
    function avatar_mce_read_also_buttons()
    {

        if (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        add_filter('mce_external_plugins', 'avatar_mce_read_also_add_buttons');
        add_filter('mce_buttons', 'avatar_mce_read_also_register_buttons');
    }
}

/* -------------------------------------------------------------
  * Add custom plugin for MCE
  * ============================================================*/

if (! function_exists('avatar_mce_read_also_add_buttons')) {
    function avatar_mce_read_also_add_buttons($plugin_array)
    {

        $plugin_array['avatar_read_also_btn'] = AVATK_URI.'assets/javascripts/mce_read_also_btn.js';

        return $plugin_array;
    }
}

/* -------------------------------------------------------------
  * Add button to botton list in MCE
  * ============================================================*/

if (! function_exists('avatar_mce_read_also_register_buttons')) {
    function avatar_mce_read_also_register_buttons($buttons)
    {
        siteorigin_widgets_array_insert($buttons, 3, 'underline');
        siteorigin_widgets_array_insert($buttons, 4, 'fontsizeselect');
        siteorigin_widgets_array_insert($buttons, 5, 'forecolor');
        siteorigin_widgets_array_insert($buttons, 6, 'backcolor');

        array_push($buttons, 'avatar_read_also_btn');

        return $buttons;
    }
}
