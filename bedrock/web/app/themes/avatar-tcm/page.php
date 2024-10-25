<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header(); ?>

<?php if (get_current_view_context() == 'cir') { ?>
	<div id="js-sticky-banner-single" class="adv-head-cir row">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR">
	</div>
<?php } ?>

<?php while (have_posts()) {
    the_post(); ?>

	<article class="base-article">
		<?php if (is_singular('microsite')) { ?>
			<div>
				<section class="col-md-12 article-body">
				<?php } else { ?>
					<header>
						<h1><?php the_title(); ?> </h1>
					</header>
					<div class="row equal-col-md">
						<section class="col-md-8 article-body">
						<?php } ?>
						<?php
                            if (has_post_thumbnail()) { ?>
							<figure class="main post-thumbnail">
								<?php the_post_thumbnail('large', ['class' => 'img-responsive']); ?>
							</figure><!-- .post-thumbnail -->
						<?php } ?>
						<div class="row equal-col-md">
							<div class="col-md-12">
								<?php the_content(); ?>
							</div>
						</div>
						</section>
						<?php if (is_singular('microsite')) { ?>
						<?php } else { ?>
							<aside class="col-md-4 primary">
								<?php
                                    $arr_m32_vars = [
                                        'sticky' => true,
                                        'staySticky' => true,
                                        'kv' => [
                                            'pos' => [
                                                'atf',
                                                'but1',
                                                'right_bigbox_last',
                                                'bottom_right_bigbox',
                                            ],
                                        ],
                                        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                                        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
                                    ];
						    $arr_avt_vars = [
						        'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
						    ];

						    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);
						    ?>
							</aside>
						<?php } ?>
					</div>
	</article>

<?php } ?>
<?php get_footer(); ?>