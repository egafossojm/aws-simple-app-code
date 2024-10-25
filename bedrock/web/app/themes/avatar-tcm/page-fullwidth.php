<?php
/**
 * Template Name: Full Width Page
 * Template Post Type: page
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
			<header>
				<h1><?php the_title(); ?> </h1>
			</header>
			<div class="row">
				<section class="col-md-12 article-body">
					<?php if (has_post_thumbnail()) { ?>
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
			</div>
		</article>
<?php } get_footer(); ?>
