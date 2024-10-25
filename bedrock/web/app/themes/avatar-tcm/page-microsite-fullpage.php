<?php

/**
 * Template Name: Microsite Full Page
 * Template Post Type: microsite
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="<?php echo esc_attr(substr(get_bloginfo('language'), 0, 2)); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body>

	<?php if (get_current_view_context() == 'cir') { ?>
		<div id="js-sticky-banner-single" class="adv-head-cir row">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR">
		</div>
	<?php } ?>

	<div class="container container-content container-w">
		<?php while (have_posts()) {
		    the_post(); ?>
			<article class="base-article">
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
		<?php } ?>
	</div>
	<?php wp_footer(); ?>
</body>

</html>