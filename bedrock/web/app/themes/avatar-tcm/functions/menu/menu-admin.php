<?php
/* -------------------------------------------------------------
 * Custom admin menu
 * ============================================================*/
if (! function_exists('avatar_customize_admin_menu')) {

    function avatar_customize_admin_menu()
    {
        global $menu;
        global $submenu;

        // To rename a section Post in Article and change dashicons
        $menu[5][0] = __('Articles', 'avatar-tcm');
        $menu[5][6] = 'dashicons-format-aside';
        // Rename "All posts"
        $submenu['edit.php'][5][0] = __('All Articles', 'avatar-tcm');
        // Rename "Tags"
        $submenu['edit.php'][16][0] = __('Keywords', 'avatar-tcm');
        // Removes "Add new" from menu, can be accessible from the page list of posts)
        remove_submenu_page('edit.php', 'post-new.php');

        // Remove "Settings" page if user in not admin
        if (! current_user_can('administrator')) {
            remove_menu_page('options-general.php');
        }

        // Add Submenu page Import XML News
        add_submenu_page('top_stories', 'Theme Options', __('Import XML News', 'avatar-tcm'), 'webeditor', '/options-general.php?page=at_cedrom_ftp_xml_2_post');

        // Add 'Entities' section for authors, companies, brands, partner
        add_menu_page(
            __('Entities', 'avatar-tcm'),
            __('Entities', 'avatar-tcm'),
            'edit_posts',
            'entities',
            '',
            'dashicons-groups',
            5
        );

        // MEDIA
        // Remove "ADD NEW" in submenu
        unset($submenu['upload.php'][10]);
        // Remove original plugin link (easy Charts)
        remove_menu_page('edit.php?post_type=easy_charts');
        // Remove Newsletter if not web editor
        if (! (current_user_can('webeditor') || current_user_can('supereditor') || current_user_can('administrator'))) {
            remove_menu_page('edit.php?post_type=newsletter');
        }
        // Remove Short URL when web editor
        if (current_user_can('webeditor') && (! (current_user_can('supereditor') || current_user_can('administrator')))) {
            remove_submenu_page('tools.php', 'tools.php');
            remove_submenu_page('tools.php', 'import.php');
            remove_submenu_page('tools.php', 'export.php');
            remove_submenu_page('tools.php', 'ms-delete-site.php');

            remove_menu_page('loco');
            remove_menu_page('pmxi-admin-home');
            remove_menu_page('plugins.php');
        }
        // Remove Tools and acf if not admin
        if (! (current_user_can('administrator'))) {
            if (! current_user_can('webeditor')) {
                remove_menu_page('tools.php');
            }
            remove_menu_page('edit.php?post_type=acf-field-group');

        }
        // Then place it under Media menu section
        add_submenu_page(
            'upload.php',
            __('Charts', 'avatar-tcm'),
            __('Charts', 'avatar-tcm'),
            'edit_posts',
            'edit.php?post_type=easy_charts'
        );

    }
    add_action('admin_menu', 'avatar_customize_admin_menu', 999);
}

/* -------------------------------------------------------------
 * Add Option Page to menu (this function create menu and the page)
 * ============================================================*/
if (function_exists('acf_add_options_page')) {

    /* Main Settings */

    // Add subsection for Settings Menu
    acf_add_options_page([
        'page_title' => __('Theme Options', 'avatar-tcm'),
        'menu_slug' => 'avatar_theme_options',
        'parent_slug' => 'options-general.php',
    ]);

    // Add subsection for Settings Menu
    acf_add_options_page([
        'page_title' => __('API Keys', 'avatar-tcm'),
        'menu_slug' => 'avatar_api_key',
        'parent_slug' => 'options-general.php',
    ]);

    // Add subsection for Settings Menu
    acf_add_options_page([
        'page_title' => __('Users', 'avatar-tcm'),
        'menu_slug' => 'avatar_user_profile',
        'parent_slug' => 'options-general.php',
    ]);

    // Add subsection for Settings Menu
    acf_add_options_page([
        'page_title' => __('Content Options', 'avatar-tcm'),
        'menu_slug' => 'avatar_content_options',
        'parent_slug' => 'options-general.php',
    ]);

    // Add parent section
    if (current_user_can('webeditor') || current_user_can('supereditor') || current_user_can('administrator')) {
        acf_add_options_page([
            'page_title' => __('Editor\'s section', 'avatar-tcm'),
            'menu_slug' => 'editor_section',
            'position' => 0,
            'icon_url' => 'dashicons-edit',
            'capability' => 'edit_posts',
        ]);

        // Add subsections for HomePage
        acf_add_options_page([
            'page_title' => __('Top Stories (HomePage)', 'avatar-tcm'),
            'menu_slug' => 'top_stories',
            'parent_slug' => 'editor_section',
        ]);

        acf_add_options_page([
            'page_title' => __('Event Widget Links', 'avatar-tcm'),
            'menu_slug' => 'event_widget',
            'parent_slug' => 'editor_section',
        ]);

        acf_add_options_page([
            'page_title' => __('Job Posting Widget Links', 'avatar-tcm'),
            'menu_slug' => 'job_posting_widget',
            'parent_slug' => 'editor_section',
        ]);

        // Add subsection for Featured In-Depth settings
        acf_add_options_page([
            'page_title' => __('Featured Reports', 'avatar-tcm'),
            'menu_slug' => 'featured_reports',
            'parent_slug' => 'editor_section',
        ]);

        // Add subsection for Featured Video
        acf_add_options_page([
            'page_title' => __('Featured Video', 'avatar-tcm'),
            'menu_slug' => 'featured_video',
            'parent_slug' => 'editor_section',
        ]);

        // Add subsection for Featured Multisite
        acf_add_options_page([
            'page_title' => __('Promotion Microsite', 'avatar-tcm'),
            'menu_slug' => 'promotion_microsite',
            'parent_slug' => 'editor_section',
        ]);

        if (get_current_blog_id() == 7) {
            // Add subsection for Featured Multisite
            acf_add_options_page([
                'page_title' => __('Promotion Microsite CIR', 'avatar-tcm'),
                'menu_slug' => 'promotion_microsite_cir',
                'parent_slug' => 'editor_section',
            ]);
        }

        // Add subsection for Featured Podcast
        acf_add_options_page([
            'page_title' => __('Featured Podcast', 'avatar-tcm'),
            'menu_slug' => 'featured_podcast',
            'parent_slug' => 'editor_section',
        ]);

        // Add subsection for Newspaper
        acf_add_options_page([
            'page_title' => __('Newspaper (HomePage)', 'avatar-tcm'),
            'menu_slug' => 'newspaper',
            'parent_slug' => 'editor_section',
        ]);

        // Add subsections for HomePage
        acf_add_options_page([
            'page_title' => __('Partners Place', 'avatar-tcm'),
            'menu_slug' => 'partners_place',
            'parent_slug' => 'editor_section',
        ]);
    }

    // Sales's special section
    if (current_user_can('salescoordinator') || current_user_can('supereditor') || current_user_can('administrator')) {
        acf_add_options_page([
            'page_title' => __('Sale\'s section', 'avatar-tcm'),
            'menu_slug' => 'sale_section',
            'position' => 0,
            'icon_url' => 'dashicons-calendar-alt',
            'capability' => 'edit_posts',
        ]);

        // Add subsections for Brand Knowledge and Partners Report Scheduler
        acf_add_options_page([
            'page_title' => __('Sponsor Scheduler', 'avatar-tcm'),
            'menu_slug' => 'sponsor_scheduler',
            'parent_slug' => 'sale_section',
        ]);

        // Add subsections for Brand Knowledge and Partners Report Scheduler
        acf_add_options_page([
            'page_title' => __('Newsletter Scheduler', 'avatar-tcm'),
            'menu_slug' => 'newsletter_scheduler',
            'parent_slug' => 'sale_section',
        ]);
    }

}
