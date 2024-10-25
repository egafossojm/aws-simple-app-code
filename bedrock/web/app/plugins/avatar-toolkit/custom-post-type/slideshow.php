<?php
/**
* The default Custom Post Type  for slideshow
*
* @since Avatar 1.0.0
*/
if (! defined('ABSPATH')) {
    exit;
}
if (! class_exists('AT_Slideshow')) {

    /**
     * Class AT_Slideshow
     */
    class AT_Slideshow
    {
        /**
         * AT_Slideshow constructor.
         */
        public function __construct()
        {

            add_action('admin_enqueue_scripts', [&$this, 'at_backend_enqueue_scripts']);
            add_action('init', [&$this, 'at_slideshow_ctp']);

            if (is_admin()) {
                add_action('admin_head', [&$this, 'at_shortcode_button_init']);
                add_action('wp_ajax_at_get_slideshow', [&$this, 'at_get_slideshow']);
            }

            add_shortcode('slideshow', [&$this, 'at_get_slideshow_frontend']);
        }

        /**
         * Get CPT parameters from Theme Option
         *
         * @since 1.0.0
         */
        public function at_get_rewrite_url()
        {
            return 'slideshow';
        }

        public function at_get_category_url_rewrite()
        {
            return 'slideshow-category';
        }

        public function at_get_name_singular()
        {
            return __('Slideshow', 'avatar-toolkit');
        }

        public function at_get_name_plural()
        {
            return __('Slideshows', 'avatar-toolkit');
        }

        /**
         * Load back end scripts
         */
        public function at_backend_enqueue_scripts()
        {

            wp_enqueue_script('at-admin-slideshow', AVATK_URI.'assets/javascripts/mce_slideshow_ajax.js', ['jquery'], time(), true);

            wp_localize_script('at-admin-slideshow', 'ajax_backend', ['ajax_url' => admin_url('admin-ajax.php')]);
        }

        /**
         * Register CPT smart
         */
        public function at_slideshow_ctp()
        {

            $labels = [
                'name' => $this->at_get_name_plural(),
                'singular_name' => $this->at_get_name_singular(),
                'menu_name' => $this->at_get_name_plural(),
                'name_admin_bar' => $this->at_get_name_singular(),
                'parent_item_colon' => __('Parent Item:', 'avatar-toolkit'),
                'all_items' => sprintf(_x('%1$s', 'Plural name', 'avatar-toolkit'), $this->at_get_name_plural()),
                'add_new_item' => sprintf(_x('Add New %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
                'add_new' => sprintf(_x('Add %1$s', 'Singular name', 'avatar-toolkit'), $this->at_get_name_singular()),
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
                'description' => __('Add Slideshow.', 'avatar-toolkit'),
                'labels' => $labels,
                'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
                'hierarchical' => true,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => 'upload.php',
                'menu_position' => 5,
                'menu_icon' => 'dashicons-admin-users',
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'rewrite' => $rewrite,
                'capability_type' => 'post',
            ];

            register_post_type('slideshow', $args);
            // flush_rewrite_rules();

        }

        /**
         * Add button in TinyMCE
         */
        public function at_shortcode_button_init()
        {
            global $typenow;
            if (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
                return;
            }
            if (! in_array($typenow, ['post', 'page'])) {
                return;
            }
            // Check if WYSIWYG is enabled
            if (get_user_option('rich_editing') === 'true') {
                // Add a callback to regiser our TinyMCE plugin
                add_filter('mce_external_plugins', [&$this, 'at_register_slideshow_plugin']);
                // Add a callback to add our button to the TinyMCE toolbar
                add_filter('mce_buttons', [&$this, 'at_add_slideshow_tinymce_button']);
            }
        }

        /**
         * Declare script for button
         *
         *
         * @return mixed
         */
        public function at_register_slideshow_plugin($plugin_array)
        {
            $plugin_array['at_add_shortcode_button'] = AVATK_URI.'assets/javascripts/mce_slideshow_btn.js';

            return $plugin_array;
        }

        /**
         * Register button
         *
         *
         * @return array
         */
        public function at_add_slideshow_tinymce_button($buttons)
        {
            array_push($buttons, 'at_add_shortcode_button');

            return $buttons;
        }

        /**
         * Load slider categories
         */
        public function at_get_slideshow()
        {

            $args = [
                'post_type' => 'slideshow',
                'order' => 'DESC',
                'orderby' => 'post_date',
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
                'posts_per_page' => -1,

            ];

            $at_slideshow_query = new WP_Query($args);

            $slideshow_list = [];

            if ($at_slideshow_query->have_posts()) {

                while ($at_slideshow_query->have_posts()) {

                    $at_slideshow_query->the_post();
                    $slideshow_list[] = ['text' => get_the_title(), 'value' => get_the_ID()];
                }
                /* Restore original Post Data */
                wp_reset_postdata();
            }

            echo wp_json_encode($slideshow_list);

            wp_die();
        }

        /**
         * Shortcode
         *
         * @return string
         */
        public function at_get_slideshow_frontend($atts)
        {

            $ad_div_bigbox = at_get_m32banner(
                $arr_m32_vars = [
                    'kv' => [
                        'pos' => [
                            'atf',
                            'but1',
                            'slideshow_bigbox',
                        ],
                    ],
                    'pos' => 'atf,but1,slideshow_bigbox',
                    'sizes' => '[ [300,250] ]',
                    'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
                ],
                $arr_avt_vars = [
                    'class' => 'js_slideshow_bigbox',
                ]
            );
            $ad_div_leaderboard = at_get_m32banner(
                $arr_m32_vars = [
                    'kv' => [
                        'pos' => [
                            'atf',
                            'but1',
                            'slideshow_leaderboard',
                        ],
                    ],
                    'pos' => 'atf,but1,slideshow_leaderboard',
                    'sizes' => '[ [728,90] ]',
                    'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90]]] ]',
                ],
                $arr_avt_vars = [
                    'class' => 'js_slideshow_leaderboard',
                ]
            );
            $output = '';
            $get_current_url = get_permalink(get_the_ID());

            /* Set up the default arguments. */
            $defaults = [
                'id' => '',
            ];
            /* Parse the arguments. */
            extract(shortcode_atts($defaults, $atts));
            remove_filter('acf_the_content', 'wpautop');
            $at_slidershow_id = $atts['id'];
            if (! empty($at_slidershow_id)) {
                $args = [
                    'p' => $at_slidershow_id,
                    'post_type' => 'slideshow',
                    'post_status' => 'publish',
                    'order' => 'ASC',
                ];
                $posts = new WP_Query($args);

                if ($posts->have_posts()) {
                    while ($posts->have_posts()) {
                        $posts->the_post();
                        $at_slidershow_main_title = get_the_title($at_slidershow_id);
                        $at_slidershow_slides = get_field('slideshow_name', $at_slidershow_id);

                        if (! $at_slidershow_slides) {
                            return;
                        }

                        $output .= '
					<div  title="'.$at_slidershow_main_title.'" class="slideshow_trigger" data-toggle="modal" data-target="#myModal_'.$at_slidershow_id.'">
					<span><i class="fa fa-picture-o" aria-hidden="true"></i> '.get_the_title().'</span><br>
					<figure><i class="fa fa-play" aria-hidden="true"></i><img src="'.get_the_post_thumbnail_url().'"></figure>
					</div>

					<div class="modal fade modalAvatar" id="myModal_'.$at_slidershow_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="container">
						<div class="slideshow-tools">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
						</div>';
                        $output .= '<div class="slideshow-top-ads col-md-12 text-center">'
                            .$ad_div_leaderboard.
                        '</div>
						<ul class="bxslider_article row" id="mySlideshow_'.$at_slidershow_id.'">';

                        foreach ($at_slidershow_slides as $key => $value) {
                            //Verify empty data

                            $author = $value['slideshow_author'] ? __('Author: ', 'avatar-tcm').$value['slideshow_author'] : '';
                            $source = $value['slideshow_source'] ? __('Source: ', 'avatar-tcm').$value['slideshow_source'] : '';
                            $copyright = $value['slideshow_copyright'] ? __('Copyright: ', 'avatar-tcm').$value['slideshow_copyright'] : '';

                            $output .= '
							<li>
							<div class="slideshow-header col-md-12">
							<h2 class="slideshow-title">'.esc_html($at_slidershow_main_title).'</h2>
							</div>
							<div class="slideshow-left col-md-8 col-xs-12">
							<img class="slide-photo" src="'.esc_url($value['slideshow_photo']).'">
							</div>
							<div class="slideshow-right col-md-4 col-xs-12 ">
							<div class="slide-text-content">
							<h2 class="slide-title">'.esc_html($value['slideshow_title']).'</h2>
							<div>'.$value['slideshow_description'].'</div>
							<div class="slide-sources">
							<span>'.esc_html($author).'</span>
							<span>'.esc_html($source).'</span>
							<span>'.esc_html($copyright).'</span>
							</div>
							</div>
							</div>
							</li>';
                        }
                        $output .= '
					</ul>
					<div class="row">
						<div class="col-md-8">
							<div id="bx-pager" class="bx-pager text-center hidden-xs ">
								<span id="slider-prev"></span>
								<span id="slider-next"></span>

								<ul class="slide-thumbnail">';
                        $i = -1;
                        foreach ($at_slidershow_slides as $key => $value) {
                            $i++;
                            $output .= '


									<li>
									<a data-slide-index="'.$i.'" href="">
									<img src="'.esc_url($value['slideshow_photo']).'" />
									</a>
									</li>
									';
                        }
                        $output .= '
								</ul>
								<span id="pager-prev"></span>
								<span id="pager-next"></span>
								</div>
								</div>
								<div class="col-md-4 slideshow-bottom-ads text-center">'
                         .$ad_div_bigbox.
                        '</div>
							</div>
						</div>
					</div>';
                    }
                }
                wp_reset_postdata();
            }

            return $output;
        }
    }
}
$wpr_cpt_scroll = new AT_Slideshow;
