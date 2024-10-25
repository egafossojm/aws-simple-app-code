<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Registers the prominent words as a taxonomy.
 */
class WPSEO_Premium_Prominent_Words_Registration implements WPSEO_WordPress_Integration
{
    const TERM_NAME = 'yst_prominent_words';

    /**
     * {@inheritdoc}
     */
    public function register_hooks()
    {
        add_action('init', [$this, 'register'], 20);
        add_action('admin_init', [$this, 'unregister']);
    }

    /**
     * Removes the taxonomy from the registration.
     *
     * This makes sure that no unneeded queries are done relating these private terms.
     */
    public function unregister()
    {
        if (! $this->is_visible()) {
            unregister_taxonomy(self::TERM_NAME);
        }
    }

    /**
     * Registers the prominent words taxonomy.
     */
    public function register()
    {
        $prominent_words_support = new WPSEO_Premium_Prominent_Words_Support;
        $prominent_words_post_types = $prominent_words_support->get_supported_post_types();

        if ($prominent_words_post_types === []) {
            return;
        }

        // REST API expects a numbered list of post types.
        $post_types = array_values($prominent_words_post_types);

        register_taxonomy(self::TERM_NAME, $post_types, $this->get_args());
    }

    /**
     * Retrieves the labels for the taxonomy.
     *
     * @return array The labels for the taxonomy.
     */
    private function get_labels()
    {
        return [
            'name' => _x('Prominent words', 'Taxonomy General Name', 'wordpress-seo-premium'),
            'singular_name' => _x('Prominent word', 'Taxonomy Singular Name', 'wordpress-seo-premium'),
            'menu_name' => __('Prominent words', 'wordpress-seo-premium'),
            'all_items' => __('All prominent words', 'wordpress-seo-premium'),
            'new_item_name' => __('New prominent word', 'wordpress-seo-premium'),
            'add_new_item' => __('Add new prominent word', 'wordpress-seo-premium'),
            'edit_item' => __('Edit prominent word', 'wordpress-seo-premium'),
            'update_item' => __('Update prominent word', 'wordpress-seo-premium'),
            'view_item' => __('View prominent word', 'wordpress-seo-premium'),
            'separate_items_with_commas' => __('Separate prominent words with commas', 'wordpress-seo-premium'),
            'add_or_remove_items' => __('Add or remove prominent words', 'wordpress-seo-premium'),
            'choose_from_most_used' => __('Choose from the most used', 'wordpress-seo-premium'),
            'popular_items' => __('Popular prominent words', 'wordpress-seo-premium'),
            'search_items' => __('Search prominent words', 'wordpress-seo-premium'),
            'not_found' => __('Not Found', 'wordpress-seo-premium'),
            'no_terms' => __('No prominent words', 'wordpress-seo-premium'),
            'items_list' => __('Prominent words list', 'wordpress-seo-premium'),
            'items_list_navigation' => __('Prominent words list navigation', 'wordpress-seo-premium'),
        ];
    }

    /**
     * Retrieves the arguments for the taxonomy registration.
     *
     * @return array The arguments for the registration to WordPress.
     */
    private function get_args()
    {
        return [
            'labels' => $this->get_labels(),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => $this->is_visible(),
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'show_in_rest' => true,
            'capabilities' => ['edit_terms' => 'edit_posts'],
        ];
    }

    /**
     * Determines if the prominent words should be visible in the menu.
     *
     * @return bool True if the prominent words should be shown.
     */
    private function is_visible()
    {
        return defined('WPSEO_DEBUG') && WPSEO_DEBUG;
    }
}
