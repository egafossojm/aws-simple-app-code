<?php
/**
 * Template Name: Default Microsite Page with header/footer and sidebar
 * Template Post Type: microsite
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header(); ?>
	<?php while (have_posts()) {
	    the_post(); ?>

			<article class="base-article">
            <?php if (is_singular('microsite')) { ?>
                <div>
					<section class="col-md-12 article-body">
            <?php } else { ?>
                <div class="row equal-col-md">
					<section class="col-md-8 article-body">
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
                    <?php if (! avatar_acf_value(get_the_id(), 'acf_microsite_no_publicity', false)) {
                        at_get_the_m32banner(
                            $arr_m32_vars = [
                                'sticky' => true,
                                'staySticky' => true,
                                'kv' => [
                                    'pos' => [
                                        'atf',
                                        'but1',
                                        'right_bigbox_last',
                                    ],
                                ],
                                'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                                'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
                            ],
                            $arr_avt_vars = [
                                'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
                            ]
                        );
                    }
                        ?>
					</aside>
                    <?php } ?>
				</div>
			</article>

	<?php } ?>
<?php get_footer(); ?>
