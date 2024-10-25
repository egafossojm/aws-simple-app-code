<?php

// Add role class to body
function add_role_to_admin_body($classes)
{
    global $current_user;
    $user_role = array_shift($current_user->roles);

    $classes .= 'role-'.$user_role;

    return $classes;
}
add_filter('admin_body_class', 'add_role_to_admin_body');

// Remove role before in order to update
//remove_role( 'supereditor' );

// Add a custom user role
$result = add_role(
    'supereditor',
    __('Back - Super Editor'),
    [
        // CAN DO
        //---------------------------------------
        // Dashboard
        'edit_dashboard' => true,

        // Post
        'delete_others_posts' => true,
        'delete_posts' => true,
        'delete_private_posts' => true,
        'delete_published_posts' => true,
        'edit_others_posts' => true,
        'edit_posts' => true,
        'edit_private_posts' => true,
        'edit_published_posts' => true,
        'publish_posts' => true,
        'read_private_posts' => true,

        // Page
        'edit_others_pages' => true,
        'edit_pages' => true,
        'edit_private_pages' => true,
        'edit_published_pages' => true,
        'publish_pages' => true,
        'read_private_pages' => true,

        // User
        'list_users' => true,

        // Other
        'manage_categories' => true,
        'read' => true,
        'upload_files' => true,
        'edit_files' => true,
        'unfiltered_html' => true,

        // CANNOT DO
        //---------------------------------------
        // Pages
        'delete_others_pages' => false,
        'delete_pages' => false,
        'delete_private_pages' => false,
        'delete_published_pages' => false,

        // User
        'promote_users' => false,
        'remove_users' => false,
        'edit_users' => false,
        'create_users' => false,
        'delete_users' => false,

        // Plugin
        'activate_plugins' => false,
        'update_plugins' => false,
        'install_plugins' => false,
        'upload_plugins' => false,
        'delete_plugins' => false,
        'edit_plugins' => false,

        // Theme
        'edit_theme_options' => false,
        'switch_themes' => false,
        'update_themes' => false,
        'install_themes' => false,
        'upload_themes' => false,
        'delete_themes' => false,
        'edit_themes' => false,

        // Tools
        'export' => false,
        'import' => false,

        // Other
        'manage_options' => true,
        'moderate_comments' => false,
        'customize' => false,
        'update_core' => false,
        'manage_links' => false,

        // Super admin right
        'create_sites' => false,
        'delete_sites' => false,
        'manage_network' => false,
        'manage_sites' => false,
        'manage_network_users' => false,
        'manage_network_plugins' => false,
        'manage_network_themes' => false,
        'manage_network_options' => false,
        'upgrade_network' => false,
        'setup_network' => false,
        'delete_site' => false,
        'ms-delete-site' => false,
    ]
);

// Remove role before in order to update (just for dev)
//remove_role( 'salescoordinator' );

// Add a custom user role
$result = add_role(
    'salescoordinator',
    __('Back - Sales Coordinator'),
    [
        // CAN DO
        //---------------------------------------
        // Dashboard
        'edit_dashboard' => true,

        // Post
        'delete_others_posts' => true,
        'delete_posts' => true,
        'delete_private_posts' => true,
        'delete_published_posts' => true,
        'edit_others_posts' => true,
        'edit_posts' => true,
        'edit_private_posts' => true,
        'edit_published_posts' => true,
        'publish_posts' => true,
        'read_private_posts' => true,

        // Page
        'edit_others_pages' => true,
        'edit_pages' => true,
        'edit_private_pages' => true,
        'edit_published_pages' => true,
        'publish_pages' => true,
        'read_private_pages' => true,

        // User
        'list_users' => true,

        // Other
        'manage_categories' => true,
        'read' => true,
        'upload_files' => true,
        'edit_files' => true,
        'unfiltered_html' => true,

        // CANNOT DO
        //---------------------------------------
        // Pages
        'delete_others_pages' => false,
        'delete_pages' => false,
        'delete_private_pages' => false,
        'delete_published_pages' => false,

        // User
        'promote_users' => false,
        'remove_users' => false,
        'edit_users' => false,
        'create_users' => false,
        'delete_users' => false,

        // Plugin
        'activate_plugins' => false,
        'update_plugins' => false,
        'install_plugins' => false,
        'upload_plugins' => false,
        'delete_plugins' => false,
        'edit_plugins' => false,

        // Theme
        'edit_theme_options' => false,
        'switch_themes' => false,
        'update_themes' => false,
        'install_themes' => false,
        'upload_themes' => false,
        'delete_themes' => false,
        'edit_themes' => false,

        // Tools
        'export' => false,
        'import' => false,

        // Other
        'manage_options' => false,
        'moderate_comments' => false,
        'customize' => false,
        'update_core' => false,
        'manage_links' => false,

        // Super admin right
        'create_sites' => false,
        'delete_sites' => false,
        'manage_network' => false,
        'manage_sites' => false,
        'manage_network_users' => false,
        'manage_network_plugins' => false,
        'manage_network_themes' => false,
        'manage_network_options' => false,
        'upgrade_network' => false,
        'setup_network' => false,
        'delete_site' => false,
        'ms-delete-site' => false,
    ]
);

// Remove role before in order to update (just for dev)
//remove_role( 'webeditor' );

// Add a custom user role
$result = add_role(
    'webeditor',
    __('Back - Web Editor'),
    [
        // CAN DO
        //---------------------------------------
        // Dashboard
        'edit_dashboard' => true,

        // Post
        'delete_others_posts' => true,
        'delete_posts' => true,
        'delete_private_posts' => true,
        'delete_published_posts' => true,
        'edit_others_posts' => true,
        'edit_posts' => true,
        'edit_private_posts' => true,
        'edit_published_posts' => true,
        'publish_posts' => true,
        'read_private_posts' => true,

        // Page
        'edit_others_pages' => true,
        'edit_pages' => true,
        'edit_private_pages' => true,
        'edit_published_pages' => true,
        'publish_pages' => true,
        'read_private_pages' => true,

        // User
        'list_users' => true,

        // Other
        'manage_categories' => true,
        'read' => true,
        'upload_files' => true,
        'edit_files' => true,
        'unfiltered_html' => true,

        // CANNOT DO
        //---------------------------------------
        // Pages
        'delete_others_pages' => false,
        'delete_pages' => false,
        'delete_private_pages' => false,
        'delete_published_pages' => false,

        // User
        'promote_users' => false,
        'remove_users' => false,
        'edit_users' => false,
        'create_users' => false,
        'delete_users' => false,

        // Plugin
        'activate_plugins' => false,
        'update_plugins' => false,
        'install_plugins' => false,
        'upload_plugins' => false,
        'delete_plugins' => false,
        'edit_plugins' => false,

        // Theme
        'edit_theme_options' => false,
        'switch_themes' => false,
        'update_themes' => false,
        'install_themes' => false,
        'upload_themes' => false,
        'delete_themes' => false,
        'edit_themes' => false,

        // Tools
        'export' => false,
        'import' => false,

        // Other
        'manage_options' => true,
        'moderate_comments' => false,
        'customize' => false,
        'update_core' => false,
        'manage_links' => false,

        // Super admin right
        'create_sites' => false,
        'delete_sites' => false,
        'manage_network' => false,
        'manage_sites' => false,
        'manage_network_users' => false,
        'manage_network_plugins' => false,
        'manage_network_themes' => false,
        'manage_network_options' => false,
        'upgrade_network' => false,
        'setup_network' => false,
        'delete_site' => false,
        'ms-delete-site' => false,
    ]
);

// Remove role before in order to update (just for dev)
//remove_role( 'newspaper' );

// Add a custom user role
$result = add_role(
    'newspaper',
    __('Front - Newspaper'),
    [
        // CANNOT DO NOTHING!!! Koin
        //---------------------------------------
        // Dashboard
        'edit_dashboard' => false,

        // Post
        'delete_others_posts' => false,
        'delete_posts' => false,
        'delete_private_posts' => false,
        'delete_published_posts' => false,
        'edit_others_posts' => false,
        'edit_posts' => false,
        'edit_private_posts' => false,
        'edit_published_posts' => false,
        'publish_posts' => false,
        'read_private_posts' => false,

        // Page
        'edit_others_pages' => false,
        'edit_pages' => false,
        'edit_private_pages' => false,
        'edit_published_pages' => false,
        'publish_pages' => false,
        'read_private_pages' => false,

        // User
        'list_users' => false,

        // Other
        'manage_categories' => false,
        'read' => false,
        'upload_files' => false,
        'edit_files' => false,
        'unfiltered_html' => false,

        // Pages
        'delete_others_pages' => false,
        'delete_pages' => false,
        'delete_private_pages' => false,
        'delete_published_pages' => false,

        // User
        'promote_users' => false,
        'remove_users' => false,
        'edit_users' => false,
        'create_users' => false,
        'delete_users' => false,

        // Plugin
        'activate_plugins' => false,
        'update_plugins' => false,
        'install_plugins' => false,
        'upload_plugins' => false,
        'delete_plugins' => false,
        'edit_plugins' => false,

        // Theme
        'edit_theme_options' => false,
        'switch_themes' => false,
        'update_themes' => false,
        'install_themes' => false,
        'upload_themes' => false,
        'delete_themes' => false,
        'edit_themes' => false,

        // Tools
        'export' => false,
        'import' => false,

        // Other
        'manage_options' => false,
        'moderate_comments' => false,
        'customize' => false,
        'update_core' => false,
        'manage_links' => false,

        // Super admin right
        'create_sites' => false,
        'delete_sites' => false,
        'manage_network' => false,
        'manage_sites' => false,
        'manage_network_users' => false,
        'manage_network_plugins' => false,
        'manage_network_themes' => false,
        'manage_network_options' => false,
        'upgrade_network' => false,
        'setup_network' => false,
        'delete_site' => false,
        'ms-delete-site' => false,
    ]
);

// Remove role before in order to update (just for dev)
//remove_role( 'subscriber' );

// Add a custom user role
$result = add_role(
    'subscriber',
    __('Front - Subscriber'),
    [
        // CANNOT DO NOTHING!!! Koin
        //---------------------------------------
        // Dashboard
        'edit_dashboard' => false,

        // Post
        'delete_others_posts' => false,
        'delete_posts' => false,
        'delete_private_posts' => false,
        'delete_published_posts' => false,
        'edit_others_posts' => false,
        'edit_posts' => false,
        'edit_private_posts' => false,
        'edit_published_posts' => false,
        'publish_posts' => false,
        'read_private_posts' => false,

        // Page
        'edit_others_pages' => false,
        'edit_pages' => false,
        'edit_private_pages' => false,
        'edit_published_pages' => false,
        'publish_pages' => false,
        'read_private_pages' => false,

        // User
        'list_users' => false,

        // Other
        'manage_categories' => false,
        'read' => false,
        'upload_files' => false,
        'edit_files' => false,
        'unfiltered_html' => false,

        // Pages
        'delete_others_pages' => false,
        'delete_pages' => false,
        'delete_private_pages' => false,
        'delete_published_pages' => false,

        // User
        'promote_users' => false,
        'remove_users' => false,
        'edit_users' => false,
        'create_users' => false,
        'delete_users' => false,

        // Plugin
        'activate_plugins' => false,
        'update_plugins' => false,
        'install_plugins' => false,
        'upload_plugins' => false,
        'delete_plugins' => false,
        'edit_plugins' => false,

        // Theme
        'edit_theme_options' => false,
        'switch_themes' => false,
        'update_themes' => false,
        'install_themes' => false,
        'upload_themes' => false,
        'delete_themes' => false,
        'edit_themes' => false,

        // Tools
        'export' => false,
        'import' => false,

        // Other
        'manage_options' => false,
        'moderate_comments' => false,
        'customize' => false,
        'update_core' => false,
        'manage_links' => false,

        // Super admin right
        'create_sites' => false,
        'delete_sites' => false,
        'manage_network' => false,
        'manage_sites' => false,
        'manage_network_users' => false,
        'manage_network_plugins' => false,
        'manage_network_themes' => false,
        'manage_network_options' => false,
        'upgrade_network' => false,
        'setup_network' => false,
        'delete_site' => false,
        'ms-delete-site' => false,
    ]
);
