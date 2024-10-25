<?php
/**
 * WPSEO plugin file.
 *
 * @since   1.8.0
 */

/**
 * Customizes user profile.
 */
class WPSEO_Admin_User_Profile
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        add_action('show_user_profile', [$this, 'user_profile']);
        add_action('edit_user_profile', [$this, 'user_profile']);
        add_action('personal_options_update', [$this, 'process_user_option_update']);
        add_action('edit_user_profile_update', [$this, 'process_user_option_update']);

        add_action('update_user_meta', [$this, 'clear_author_sitemap_cache'], 10, 3);
    }

    /**
     * Clear author sitemap cache when settings are changed.
     *
     * @since 3.1
     *
     * @param  int  $meta_id  The ID of the meta option changed.
     * @param  int  $object_id  The ID of the user.
     * @param  string  $meta_key  The key of the meta field changed.
     */
    public function clear_author_sitemap_cache($meta_id, $object_id, $meta_key)
    {
        if ($meta_key === '_yoast_wpseo_profile_updated') {
            WPSEO_Sitemaps_Cache::clear(['author']);
        }
    }

    /**
     * Filter POST variables.
     *
     * @param  string  $var_name  Name of the variable to filter.
     * @return mixed
     */
    private function filter_input_post($var_name)
    {
        $val = filter_input(INPUT_POST, $var_name);
        if ($val) {
            return WPSEO_Utils::sanitize_text_field($val);
        }

        return '';
    }

    /**
     * Updates the user metas that (might) have been set on the user profile page.
     *
     * @param  int  $user_id  User ID of the updated user.
     */
    public function process_user_option_update($user_id)
    {
        update_user_meta($user_id, '_yoast_wpseo_profile_updated', time());

        $nonce_value = $this->filter_input_post('wpseo_nonce');

        if (empty($nonce_value)) { // Submit from alternate forms.
            return;
        }

        check_admin_referer('wpseo_user_profile_update', 'wpseo_nonce');

        update_user_meta($user_id, 'wpseo_title', $this->filter_input_post('wpseo_author_title'));
        update_user_meta($user_id, 'wpseo_metadesc', $this->filter_input_post('wpseo_author_metadesc'));
        update_user_meta($user_id, 'wpseo_noindex_author', $this->filter_input_post('wpseo_noindex_author'));
        update_user_meta($user_id, 'wpseo_content_analysis_disable', $this->filter_input_post('wpseo_content_analysis_disable'));
        update_user_meta($user_id, 'wpseo_keyword_analysis_disable', $this->filter_input_post('wpseo_keyword_analysis_disable'));
    }

    /**
     * Add the inputs needed for SEO values to the User Profile page.
     *
     * @param  WP_User  $user  User instance to output for.
     */
    public function user_profile($user)
    {
        wp_nonce_field('wpseo_user_profile_update', 'wpseo_nonce');

        require_once WPSEO_PATH.'admin/views/user-profile.php';
    }
}
