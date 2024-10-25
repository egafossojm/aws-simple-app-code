<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Keeps track of the prominent words version.
 */
class WPSEO_Premium_Prominent_Words_Versioning implements WPSEO_WordPress_Integration
{
    const VERSION_NUMBER = 1;

    const VERSION_NUMBER_FT_INTERNAL_LINKING = 2;

    const POST_META_NAME = '_yst_prominent_words_version';

    const COLLECTION_PARAM = 'yst_prominent_words_is_unindexed';

    /**
     * Determines the version number of prominent words analysis based on the value of the feature flag.
     */
    public static function determine_version_number()
    {
        $features = WPSEO_Utils::retrieve_enabled_features();
        if (in_array('improvedInternalLinking', $features, true)) {
            return self::VERSION_NUMBER_FT_INTERNAL_LINKING;
        }

        return self::VERSION_NUMBER;
    }

    /**
     * {@inheritdoc}
     */
    public function register_hooks()
    {
        if (! $this->can_retrieve_data()) {
            return;
        }

        add_action('rest_api_init', [$this, 'register_rest_argument']);
    }

    /**
     * Registers REST arguments for all relevant post types.
     *
     * This has to be done at init, to make sure all plugins have registered their post types.
     */
    public function register_rest_argument()
    {
        foreach ($this->get_post_types() as $post_type) {
            add_filter('rest_'.$post_type.'_query', [$this, 'rest_add_query_args'], 10, 2);
            add_filter('rest_'.$post_type.'_collection_params', [$this, 'rest_register_collection_param']);
        }
    }

    /**
     * Saves the version number as a meta.
     *
     * @param  int  $post_id  The post ID to save the version number for.
     */
    public function save_version_number($post_id)
    {
        // Add the post meta field if it does not exist yet, update it if it does.
        if (! add_post_meta($post_id, self::POST_META_NAME, self::determine_version_number(), true)) {
            update_post_meta($post_id, self::POST_META_NAME, self::determine_version_number());
        }
    }

    /**
     * Adds our collection param to the array of params.
     *
     * @param  array  $query_params  The previous query params.
     * @return array The altered query params.
     */
    public function rest_register_collection_param($query_params)
    {
        $query_params[self::COLLECTION_PARAM] = [
            'description' => __('Limit result set to items that are unindexed.', 'wordpress-seo-premium'),
            'type' => 'boolean',
            'default' => false,
        ];

        return $query_params;
    }

    /**
     * Adds query args to the query to get all rows that needs to be recalculated.
     *
     * @param  array  $args  The previous arguments.
     * @param  WP_REST_Request  $request  The current request object.
     * @return array $args The altered arguments.
     */
    public function rest_add_query_args($args, WP_REST_Request $request)
    {
        if ($request->get_param(self::COLLECTION_PARAM) === true) {

            $limit = 10;
            if (! empty($args['posts_per_page'])) {
                $limit = $args['posts_per_page'];
            }

            $prominent_words = new WPSEO_Premium_Prominent_Words_Unindexed_Post_Query;
            $post_ids = $prominent_words->get_unindexed_post_ids($args['post_type'], $limit);

            // Make sure WP_Query uses our list, especially when it's empty!
            if (empty($post_ids)) {
                $post_ids = [0];
            }

            $args['post__in'] = $post_ids;
        }

        return $args;
    }

    /**
     * Determines if the current user is allowed to use this endpoint.
     *
     * @return bool
     */
    public function can_retrieve_data()
    {
        return current_user_can(WPSEO_Premium_Prominent_Words_Endpoint::CAPABILITY_RETRIEVE);
    }

    /**
     * Renames the meta key for the prominent words version. It was a public meta field and it has to be private.
     */
    public static function upgrade_4_7()
    {
        global $wpdb;

        // The meta key has to be private, so prefix it.
        $wpdb->query(
            $wpdb->prepare(
                'UPDATE '.$wpdb->postmeta.' SET meta_key = %s WHERE meta_key = "yst_prominent_words_version"',
                self::POST_META_NAME
            )
        );
    }

    /**
     * Removes the meta key for the prominent words version for the unsupported languages that might have this value
     * set.
     */
    public static function upgrade_4_8()
    {
        $language_support = new WPSEO_Premium_Prominent_Words_Language_Support;

        if ($language_support->is_language_supported(WPSEO_Language_Utils::get_language(get_locale()))) {
            return;
        }

        global $wpdb;

        // The remove all post metas.
        $wpdb->query(
            $wpdb->prepare(
                'DELETE FROM '.$wpdb->postmeta.' WHERE meta_key = %s',
                self::POST_META_NAME
            )
        );
    }

    /**
     * Returns a list of supported post types.
     *
     * @return array The supported post types.
     */
    private function get_post_types()
    {
        $prominent_words_support = new WPSEO_Premium_Prominent_Words_Support;

        return $prominent_words_support->get_supported_post_types();
    }
}
