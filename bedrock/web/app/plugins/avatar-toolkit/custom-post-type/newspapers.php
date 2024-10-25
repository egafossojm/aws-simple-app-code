<?php
/**
 * The default Custom Post Type for newspapers
 *
 * @since Avatar 1.0.0
 */
class AK_Newspaper
{
    /**
     * Construct
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        /* Add Custom Post Types */
        add_action('init', [$this, 'at_newspaper_cpt'], 0);

        /* Add Taxomomy Custom Post Types */
        add_action('init', [$this, 'at_newspaper_taxomomy'], 0);

        /* Add Meta Boxes Custom Post Types*/
        add_action('admin_init', [$this, 'at_newspaper_meta_boxes']);
    }

    /**
     * Get CPT parameters from Theme Option
     *
     * @since 1.0.0
     */
    public function at_get_rewrite_url()
    {
        $url = (class_exists('acf') and get_field('acf_newspaper_slug', 'option')) ? get_field('acf_newspaper_slug', 'option') : 'newspaper-date';

        return $url;
    }

    public function at_get_category_url_rewrite()
    {
        return 'newspaper-category';
    }

    public function at_get_name_singular()
    {
        return __('Newspaper Date', 'avatar-toolkit');
    }

    public function at_get_name_plural()
    {
        return __('Newspaper Dates', 'avatar-toolkit');
    }

    /**
     * Register Custom Post Type
     *
     * @since 1.0.0
     */
    public function at_newspaper_cpt()
    {

        $labels = [
            'name' => $this->at_get_name_plural(),
            'singular_name' => $this->at_get_name_singular(),
            'menu_name' => $this->at_get_name_plural(),
            'name_admin_bar' => $this->at_get_name_singular(),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'all_items' => sprintf(_x('All %1$s', 'Plural name', 'avatar-toolkit'), $this->at_get_name_plural()),
            'add_new_item' => sprintf(_x('Add New %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'add_new' => sprintf(_x('Add a %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'new_item' => sprintf(_x('New %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'edit_item' => sprintf(_x('Edit %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'update_item' => sprintf(_x('Update %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'view_item' => sprintf(_x('View %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'search_items' => sprintf(_x('Search %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'not_found' => __('Not found', 'avatar-toolkit'),
            'not_found_in_trash' => __('Not found in Trash', 'avatar-toolkit'),
        ];

        $rewrite = [
            'slug' => $this->at_get_rewrite_url(),
            'with_front' => true,
            'pages' => true,
            'feeds' => false,
        ];

        $args = [
            'label' => $this->at_get_name_singular(),
            'description' => sprintf(_x('Add New %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
            'labels' => $labels,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'entities',
            'menu_position' => 5,
            'menu_icon' => 'dashicons-media-text',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        ];
        register_post_type('newspaper', $args);
        // flush_rewrite_rules();
    }

    /**
     * Register Custom Taxonomy
     *
     * @since 1.0.0
     */
    public function at_newspaper_taxomomy() {}

    /**
     * Register Meta Boxes
     *
     * @since 1.0.0
     */
    public function at_newspaper_meta_boxes() {}
}

//Init the Class
new AK_Newspaper;
