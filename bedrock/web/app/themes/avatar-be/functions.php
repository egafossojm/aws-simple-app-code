<?php

if (! function_exists('avatarbe_theme_enqueue_styles')) {
    function avatarbe_theme_enqueue_styles()
    {
        wp_enqueue_style('avatar-tcm_parent', trailingslashit(get_template_directory_uri()).'style.css', ['avatar-vendors'], '2.4');
        //"album" taxonomy generates a gallery with fancybox via "album" shortcode
        global $post;
        if (has_shortcode($post->post_content, 'album')) {
            wp_enqueue_style('photo-albums-fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css');
            wp_enqueue_script('photo-albums-fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js');
            wp_enqueue_script('photo-albums-fancybox-init-js-parent', trailingslashit(get_template_directory_uri()).'functions/albums/album-init.js');
            wp_enqueue_script('photo-albums-fancybox-deploy-js-parent', trailingslashit(get_template_directory_uri()).'functions/albums/album-deployments.js', [], '1.3', true);
        }
    }
    add_action('wp_enqueue_scripts', 'avatarbe_theme_enqueue_styles', 1);
}

function my_class_names($classes)
{
    // add 'class-name' to the $classes array
    $classes[] = 'be-website advisor-website';

    // return the $classes array
    return $classes;
}

//Now add test class to the filter
add_filter('body_class', 'my_class_names');

/* -------------------------------------------------------------
 * Fallback for old Passwords from FI site
 * ============================================================*/

if (! function_exists('avatarbe_fallback_to_old_password')) {

    function avatarbe_fallback_to_old_password($check, $password, $hash, $user_id)
    {

        $inputed_password_hash = wp_hash_password($password);
        if ($inputed_password_hash == $hash) {
            return $check;
        } else {
            $old_encoding = md5($password, true);
            if ($old_encoding == $hash) {
                error_log('reset');
                wp_set_password($password, $user_id);

                return true;
            }
        }

        return $check;
    }
    add_filter('check_password', 'avatarbe_fallback_to_old_password', 10, 4);
}

/* -------------------------------------------------------------
 * Load JavaScript for DI
 * ============================================================*/

if (! function_exists('avatarbe_include_js')) {
    function avatarbe_include_js() {}
    add_action('wp_enqueue_scripts', 'avatarbe_include_js');
}

/* -------------------------------------------------------------
 * Load BE environments config
 * ============================================================*/

if (! function_exists('avatarbe_load_config')) {

    function avatarbe_load_config()
    {
        include_once 'config/environments.php';
    }

    add_action('after_setup_theme', 'avatarbe_load_config');
}

if (! function_exists('avatarbe_initiate_files')) {

    function avatarbe_initiate_files()
    {
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/open_x.php';
        include_once trailingslashit(get_stylesheet_directory()).'/functions/newsletter/liveintent.php';
    }
}

add_action('after_setup_theme', 'avatarbe_initiate_files');

// Our custom post type function
function create_cir_posttype()
{

    register_post_type(
        'cir-board-members',
        // CPT Options
        [
            'labels' => [
                'name' => __('CIR Board Members'),
                'singular_name' => __('CIR Board Member'),
                'add_new' => __('Add CIR Member'),
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'cir-board-member'],
            'show_in_rest' => true,
            'taxonomies' => ['category'],
            // 'menu_position' => 6,
            'menu_icon' => 'dashicons-analytics',

        ]
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_cir_posttype');

// Our custom post type function
function create_benefits_posttype()
{

    register_post_type(
        'benefits-b-members',
        // CPT Options
        [
            'labels' => [
                'name' => __('Benefits Canada’s Board'),
                'singular_name' => __('Benefits Canada’s Board'),
                'add_new' => __('Add Benefits Member'),
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'benefits-boards-member'],
            'show_in_rest' => true,
            'taxonomies' => ['category'],
            // 'menu_position' => 6,
            'menu_icon' => 'dashicons-analytics',

        ]
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_benefits_posttype');

//New album taxonoy for photo albums
function add_photo_taxonomy()
{
    // Add new "Albums" taxonomy to attachments
    register_taxonomy('album', 'attachment', [
        // Hierarchical taxonomy (like categories )
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => [
            'name' => _x('Albums', 'taxonomy general name'),
            'singular_name' => _x('Album', 'taxonomy singular name'),
            'search_items' => __('Search Albums'),
            'all_items' => __('All Albums'),
            'parent_item' => __('Parent Album'),
            'parent_item_colon' => __('Parent Album:'),
            'edit_item' => __('Edit Album'),
            'update_item' => __('Update Album'),
            'add_new_item' => __('Add New Album'),
            'new_item_name' => __('New Album Name'),
            'menu_name' => __('Albums'),
        ],
        // Control the slugs used for this taxonomy
        'rewrite' => [
            'slug' => 'albums', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/albums/"
            'hierarchical' => true, // This will allow URL's like "/albums/an-album-name/"
        ],
    ]);
}
add_action('init', 'add_photo_taxonomy', 0);

//Album shortcode
function album_gallery($atts)
{
    $default = [
        'name' => '',
    ];
    $album = shortcode_atts($default, $atts);
    $album_slug = $album['name'];

    if ($album_slug == '') {
        return;
    } elseif ($album_slug != '') {
        $album_term = get_term_by('slug', $album_slug, 'album');
        $album_term_id = $album_term->term_id;
        //$album_taxonomy = get_term_by("slug", $album_slug);
        //$album_taxonomy_id = $album_taxonomy->term_id;
        $album_args = [
            'post_type' => 'attachment',
            'post_status' => 'any',
            'hide_empty' => false,
            'post_mime_type' => 'image',
            'numberposts' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'album',
                    'field' => 'term_id',
                    'terms' => [$album_term_id],
                    'operator' => 'IN',
                ],
            ],
        ];
        $album_posts = get_posts($album_args);
        $initial_load_img_rows = 4;
        $img_per_row = 4;
        $hide_after = $initial_load_img_rows * $img_per_row;

        $album_gallery_html = "<div id='album-".$album_slug."' class='album-photo-gallery row equal-col-md' style='margin-left:-6px; margin-right:-6px;'>"; //start of .row
        foreach ($album_posts as $key_album_posts => $album_post) {
            $album_post_id = $album_post->ID;
            $album_post_url = wp_get_attachment_url($album_post_id);
            $album_post_caption = wp_get_attachment_caption($album_post_id);
            $album_gallery_html .= "<a href='#' data-fancybox='gallery' data-caption='".$album_post_caption."' data-src='".$album_post_url."' class='col-12 col-md-3 ".($key_album_posts > ($hide_after - 1) ? 'hide' : '')."' style='margin-bottom:12px; padding:0 6px; display:block;'><img src='".$album_post_url."' alt='".$album_post_caption."' title='".$album_post_caption."'></a>";
        }
        $album_gallery_html .= '</div>'; //end of .row

        if (count($album_posts) > $hide_after) {
            $album_gallery_html .= "<div style='width:100%;' class='row equal-col-md text-center micro-module'><button class='btn view-more-album-gallery' style=' display:flex; align-items:center; margin:0 auto; outline:none;' data-href='album-".$album_slug."'>View more <svg style='font-size:10px; margin-left:10px; width:10px; display:inline-block; fill:white;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d='M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z'/></svg></button></div>";
        }

        return $album_gallery_html;
    }
}
add_shortcode('album', 'album_gallery');
