<?php
/**
 * Custom Taxonomy for Post (Article)
 *
 * @since Avatar 1.0.0
*/
class AT_Post_Taxonomy
{
    /**
     * Construct
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        /* Add Taxomomy Custom Post Types */
        add_action('init', [$this, 'at_post_taxomomy'], 0);

        add_action('admin_init', [$this, 'at_hide_metabox'], 0);

        //add_action( 'admin_menu', array( $this, 'at_post_taxomomy_menu' ), 999 );

    }

    /**
     * Register Custom Taxonomy
     *
     * @since 1.0.0
     */
    public function at_post_taxomomy()
    {

        // Companies
        $labels_company = [
            'name' => __('Companies', 'avatar-toolkit'),
            'singular_name' => __('Company', 'avatar-toolkit'),
            'menu_name' => __('Companies', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Item', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search Items', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];
        $args_company = [
            'labels' => $labels_company,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];
        register_taxonomy('post_company', ['post'], $args_company);

        // Author/Column
        $labels_column = [
            'name' => __('Columns', 'avatar-toolkit'),
            'singular_name' => __('column', 'avatar-toolkit'),
            'menu_name' => __('Columns', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Column', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search in columns', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];
        $args_column = [
            'labels' => $labels_column,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];
        register_taxonomy('post_column', ['post'], $args_column);

        // Brand Knowledge Topics
        $labels_brand_topic = [
            'name' => __('Brand Knowledge Topics', 'avatar-toolkit'),
            'singular_name' => __('Brand Knowledge Topics', 'avatar-toolkit'),
            'menu_name' => __('Brand Knowledge Topics', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Item', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search Items', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];
        $args_brand_topic = [
            'labels' => $labels_brand_topic,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];
        register_taxonomy('post_brand_topic', ['post'], $args_brand_topic);

        // Funds
        $labels_fund = [
            'name' => __('Funds', 'avatar-toolkit'),
            'singular_name' => __('Fund', 'avatar-toolkit'),
            'menu_name' => __('Funds', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Item', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search Items', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];
        $args_fund = [
            'labels' => $labels_fund,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];
        register_taxonomy('post_fund', ['post'], $args_fund);

        // Sponsors
        $labels_sponsor = [
            'name' => __('Sponsors', 'avatar-toolkit'),
            'singular_name' => __('Sponsor', 'avatar-toolkit'),
            'menu_name' => __('Sponsors', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Item', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search Items', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];

        $site_id = get_blog_details($GLOBALS['blog_id'])->blog_id;
        $slug = [];
        switch ($site_id) {
            case 4:
                $slug = ['rewrite' => ['slug' => 'gestionnaires-en-direct/compagnie']];
                break;
            case 5:
                $slug = ['rewrite' => ['slug' => 'togo/company']];
                break;
            default:
                break;
        }

        $args_sponsor = [
            'labels' => $labels_sponsor,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];

        register_taxonomy('post_sponsor', ['post'], array_merge($args_sponsor, $slug));

        // Regions
        $labels_region = [
            'name' => __('Regions', 'avatar-toolkit'),
            'singular_name' => __('Region', 'avatar-toolkit'),
            'menu_name' => __('Regions', 'avatar-toolkit'),
            'all_items' => __('All Items', 'avatar-toolkit'),
            'parent_item' => __('Parent Item', 'avatar-toolkit'),
            'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
            'new_item_name' => __('New Item Name', 'avatar-toolkit'),
            'add_new_item' => __('Add New Item', 'avatar-toolkit'),
            'edit_item' => __('Edit Item', 'avatar-toolkit'),
            'update_item' => __('Update Item', 'avatar-toolkit'),
            'view_item' => __('View Item', 'avatar-toolkit'),
            'separate_items_with_commas' => __('Separate items with commas', 'avatar-toolkit'),
            'add_or_remove_items' => __('Add or remove items', 'avatar-toolkit'),
            'choose_from_most_used' => __('Choose from the most used', 'avatar-toolkit'),
            'popular_items' => __('Popular Items', 'avatar-toolkit'),
            'search_items' => __('Search Items', 'avatar-toolkit'),
            'not_found' => __('Not Found', 'avatar-toolkit'),
            'no_terms' => __('No items', 'avatar-toolkit'),
            'items_list' => __('Items list', 'avatar-toolkit'),
            'items_list_navigation' => __('Items list navigation', 'avatar-toolkit'),
        ];
        $rewrite = [];
        switch ($site_id) {
            case 4:
                $rewrite = ['rewrite' => ['slug' => 'gestionnaire-en-direct/region']];
                break;
            case 5:
                $rewrite = ['rewrite' => ['slug' => 'togo/region']];
                break;
            default:
                break;
        }
        $args_region = [
            'labels' => $labels_region,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ];
        register_taxonomy('post_region', ['post'], array_merge($args_region, $rewrite));
    }

    /**
     * Hide metabox
     *
     * @since 1.0.0
     */
    public function at_hide_metabox()
    {
        remove_meta_box('tagsdiv-post_company', 'post', 'normal');
        remove_meta_box('tagsdiv-post_newspaper_date', 'post', 'normal');
        remove_meta_box('tagsdiv-post_column', 'post', 'normal');
        remove_meta_box('tagsdiv-post_brand_topic', 'post', 'normal');
        remove_meta_box('tagsdiv-post_sponsor', 'post', 'normal');
        remove_meta_box('tagsdiv-post_region', 'post', 'normal');
    }

    public function at_post_taxomomy_menu()
    {

        // // Place it under Entities menu section
        // add_submenu_page(
        // 'entities',
        // __( 'Companies', 'avatar-toolkit' ),  // page title
        // __( 'Companies', 'avatar-toolkit' ),  // sub-menu title
        // 'edit_posts',                         // capability
        // 'edit-tags.php?taxonomy=post_company' // your menu menu slug
        // );

        // //Remove from Article Menu
        // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_company' );

        // // Place it under Entities menu section
        // add_submenu_page(
        // 'entities',
        // __( 'Tag Dates', 'avatar-toolkit' ),
        // __( 'Tag Dates', 'avatar-toolkit' ),
        // 'edit_posts',
        // 'edit-tags.php?taxonomy=post_tag_date'
        // );

        // //Remove from Article Menu
        // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag_date' );
    }
}
//Init the Class
new AT_Post_Taxonomy;
