<?php

/**
 * Template Name: Sponsored content CIR
 *
 * This is the template that displays the Special content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="homepage">
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
					<div id="js-sticky-banner" class="adv-head-cir">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR news">
					</div>
					<?php
                    include locate_template('templates/general/component-sponsored-content-cir.php');
?>
				</div>
				<aside class="primary col-md-4">
					<?php
//include Quick subscribe newsletters component

avatar_include_subscription_module();

//include( locate_template( 'templates/homepage/component-quick-subscribe-newsletters.php' ) );
?>
					<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
						<?php
    if (SHOW_HOMEPAGE_BIGBOXBEFOREMICROSITE_WIDGET) {

        $arr_m32_vars = [
            'kv' => [
                'pos' => [
                    'btf',
                    'but1',
                    'right_bigbox',
                    'top_right_bigbox',
                    'home_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ];
        $arr_avt_vars = [
            'class' => 'bigbox text-center',
        ];
        get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);
    }
?>
					</div>
					<?php
                    // Include Microsite Block
                    // avatar_include_template_conditionally( 'templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
                    // avatar_include_template_conditionally( 'templates/cir/microsite/component-microsite-cir-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
                    // Include podcast widget
                    if (SHOW_HOMEPAGE_PODCAST_WIDGET) {
                        include locate_template('templates/general/component-podcast-dark.php');
                    }
if (SHOW_HOMEPAGE_RETIREMENT_WIDGET) {
    //include( locate_template( 'templates/general/component-retirement-center.php' ) );
    include locate_template('templates/general/component-sunlife-retirement.php');
}

//include tools and resources component
include locate_template('templates/tools/component-tools-and-ressources.php');

if (($site_id == 3) || ($site_id == 7)) {
    $arr_m32_vars = [
        'sticky' => true,
        'staySticky' => true,
        'kv' => [
            'pos' => [
                'btf',
                'but2',
                'right_bigbox',
                'home_bigbox',
                'mid_right_bigbox',
            ],
        ],
        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
        'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
    ];
    $arr_avt_vars = [
        'class' => 'bigbox text-center bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
    ];

    $parent_title = get_the_title($post->post_parent);

    at_get_the_cir_m32banner(
        $arr_m32_vars,
        $arr_avt_vars
    );
}

// Include video widget for FI
if (SHOW_HOMEPAGE_VIDEO_WIDGET) {
    include locate_template('templates/general/component-video-dark.php');
}

?>
				</aside>
			</section>

		</main>
		<!-- #main -->
	</div><!-- #primary -->
</div>
<!-- .wrap -->

<?php get_footer(); ?>