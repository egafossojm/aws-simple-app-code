<?php
/* -------------------------------------------------------------
 * Add Theme Styles in FrontEnd
 * ============================================================*/
if (! function_exists('avatar_include_css')) {

    function avatar_include_css()
    {

        //Vendors style
        wp_enqueue_style('avatar-vendors', get_template_directory_uri().'/assets/css/vendors.min.css', [], '1.0.2', 'all');

        // Main style CSS
        wp_enqueue_style('avatar-tcm', get_stylesheet_uri(), ['avatar-vendors'], '1.1.7', 'all');
    }

    add_action('wp_enqueue_scripts', 'avatar_include_css', 1);
}

/* -------------------------------------------------------------
 * Add Theme Styles in BackEnd
 * ============================================================*/

if (! function_exists('avatar_include_admin_css')) {

    function avatar_include_admin_css()
    {

        //Admin style
        wp_enqueue_style('avatar-adminstyle', get_template_directory_uri().'/assets/css/admin.min.css', [], '1.0.0', 'all');
    }

    add_action('admin_enqueue_scripts', 'avatar_include_admin_css');
}

/* -------------------------------------------------------------
 * Add Theme JavaScripts in FrontEnd
 * ============================================================*/
if (! function_exists('avatar_include_js')) {

    function avatar_include_js()
    {

        //Include jQuery
        wp_enqueue_script('jquery');

        //Include Vendors JavaScripts
        wp_enqueue_script('avatar-vendors', get_template_directory_uri().'/assets/javascripts/vendors.min.js', ['jquery'], '', 'footer');

        //JS Translation
        $translation_array = [
            'get_template_directory_uri' => __(get_template_directory_uri(), 'avatar-tcm'),
            'next_news' => __('View More', 'avatar-tcm'),
            //'previous_news' => __( 'Previous News', 'plugin-domain' ) Not used at the time
        ];
        wp_localize_script('avatar-vendors', 'translated_string', $translation_array);

        //Include Main JavaScripts
        wp_enqueue_script('avatar-main', get_template_directory_uri().'/assets/javascripts/main.min.js', ['avatar-vendors'], '', 'footer');

        //Enable usage of wordpress theme url in JS files ... usage : var x = avatar_theme_url.theme_directory;
        wp_localize_script('avatar-main', 'avatar_theme_url', [
            'theme_directory' => get_template_directory_uri(),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('avatar'.wp_rand(1, 999)),
        ]);
        if ((get_current_view_context() && get_current_view_context() === 'cir') && at_m32_cir_vars()) {
            wp_add_inline_script('avatar-main', at_m32_cir_vars());
        } elseif (at_m32_vars()) {
            wp_add_inline_script('avatar-main', at_m32_vars());
        }

        // Include Brightcove Players JavaScript
        // see avatar_the_video_player() function

        // Include JavaScript for Google reCaptcha
        if (is_page_template('page-user-register.php') or is_page_template('page-user-login.php')) {
            wp_enqueue_script('avatar-recaptcha', 'https://www.google.com/recaptcha/api.js?hl='.get_locale(), [], '', 'footer');
        }
    }

    add_action('wp_enqueue_scripts', 'avatar_include_js');
}

/* -------------------------------------------------------------
 * Add Theme JavaScripts in BackEnd
 * ============================================================*/
if (! function_exists('avatar_include_admin_js')) {

    function avatar_include_admin_js()
    {

        //Include Admin JavaScripts
        wp_enqueue_script('avatar-admin', get_template_directory_uri().'/assets/javascripts/admin.min.js', ['jquery'], '', 'footer');

        wp_localize_script('avatar-admin', 'avatar_admin_url', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('avatar'.wp_rand(1, 999)),
        ]);
    }
    add_action('admin_enqueue_scripts', 'avatar_include_admin_js');
}

/* -------------------------------------------------------------
 * Add inlinde style for authors
 * ============================================================*/
if (! function_exists('avatar_author_styles')) {

    function avatar_author_styles()
    {

        global $post;
        $custom_css = '';

        // For posts
        if (is_single()) {
            // Single post Authors
            if ($post->post_type == 'writer') {
                $color_author = get_field('acf_author_banner_color', $post->ID);
                $custom_css .= "
					.single-writer .entity-header { background-color: {$color_author};}
				";
            }
            // Single post (on columnist)
            if (get_field('acf_article_author', $post->ID)) {
                $author_arr = get_field('acf_article_author', $post->ID);
                foreach ($author_arr as $key => $value) {
                    $color_author = get_field('acf_author_banner_color', $value->ID);
                    $custom_css .= "
						.entity-header{ background-color: {$color_author}!important; }
					";
                }
            }
            // Single post (Feature Partner)
            if (get_field('acf_article_feature', $post->ID)) {

                $feature_object = get_field('acf_article_feature', $post->ID);
                $thumbnail = get_field('acf_feature_banner', $feature_object->ID);
                if ($thumbnail) {
                    $custom_css .= "
						  .entity-header { background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0, 0.5) 100%),url('".$thumbnail['url']."'); background-size:cover; background-position:center center; }";
                }
            }
            // Single post (Brand)
            if (get_field('acf_article_brand', $post->ID)) {

                $brand_object = get_field('acf_article_brand', $post->ID);
                $thumbnail = get_field('acf_brand_banner', $brand_object->ID);
                if ($thumbnail) {
                    $custom_css .= "
						  .entity-header { background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0, 0.5) 100%),url('".$thumbnail['url']."'); background-size:cover; background-position:center center; }";
                }
            }
            if ($post->post_type == 'feature') {
                //For feature
                $thumbnail = get_field('acf_feature_banner', $post);
                if ($thumbnail) {
                    $custom_css .= "
						 .entity-header { background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0, 0.5) 100%),url('".$thumbnail['url']."'); background-size:cover; background-position:center center; }";
                }
            }
            if ($post->post_type == 'brand') {
                //For brand
                $thumbnail = get_field('acf_brand_banner', $post);
                if ($thumbnail) {
                    $custom_css .= "
						 .entity-header { background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0, 0.5) 100%),url('".$thumbnail['url']."'); background-size:cover; background-position:center center; }";
                }
            }
        }

        wp_add_inline_style('avatar-tcm', $custom_css);
    }
    add_action('wp_enqueue_scripts', 'avatar_author_styles');
}
