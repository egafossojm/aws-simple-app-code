<?php

/**
 * Template Name: Microsite Page full width with header/footer
 * Template Post Type: microsite
 * The template for displaying all pages
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
		<!-- Microsite Page full width with header/footer -->
		<div class="row">
			<section class="col-md-12 article-body">
				<div class="row equal-col-md">
					<div class="col-md-12">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
		</div>
	</article>
<?php }
get_footer(); ?>