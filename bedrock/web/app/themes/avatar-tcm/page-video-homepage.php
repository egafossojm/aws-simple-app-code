<?php
/**
 * Template Name: Video: IndexPage
 *
 * This is the template that displays IE TV section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php
$i = 1;
$curr_page_id = get_the_ID();
$avatar_video_cat_id = avatar_get_cat_by_page($curr_page_id);
$avatar_video_featured_ids = avatar_get_featured_video_articles_id();

$avatar_video_featured_args = [
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__in' => $avatar_video_featured_ids,
    'orderby' => 'post__in',
];
$avatar_video_featured_query = new WP_Query($avatar_video_featured_args);

// Subcategories options
$avatar_subcategory_args = [
    'taxonomy' => ['category'],
    'meta_key' => 'category_sub_cat_order',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'child_of' => $avatar_video_cat_id,
];
$avatar_subcategory_query = new WP_Term_Query($avatar_subcategory_args);
?>
<?php get_header(); ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main">

		<?php // featured video section?>
		<?php if ($avatar_video_featured_query->have_posts()) { ?>
			<section class="row row--no-margin">
				<div class="col-md-12 color_bg_dark_navy text-content">
			<?php while ($avatar_video_featured_query->have_posts()) {
			    $avatar_video_featured_query->the_post(); ?>
				<?php $curr_post_id = get_the_id(); ?>
				<?php if ($i == 1) { ?>
				<!-- 1 first video $i == 1 -->
				<div class="row">
					<div class="col-md-8 col-sm-6">
						<div class="text-right">
								<span class="featured-videos-title">
									<?php _e('Featured videos', 'avatar-tcm'); ?>
								</span>
								<span class="featured-videos-title featured-videos-title--thin">
									<?php _e('On ', 'avatar-tcm'); ?>
								</span>
								<h1 class="featured-videos-title"><?php echo get_the_title($curr_page_id); ?></h1>
								<i class="featured-videos-title__icon fa fa-video-camera"></i>
							</h1>
						</div>
						<?php if (has_post_thumbnail()) { ?>
							<figure class="figure-relative text-content no-padding-bottom">
								<a class="featured-video" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive text-content__image-full']); ?>
									<div class="kxo"><i class="videos-caret videos-caret--featured fa fa-caret-right" aria-hidden="true"></i></div>
								</a>
							</figure>
						<?php } ?>
						<div class="text-content no-padding-bottom">
							<h2 class="text-content__title text-content__title--big">
								<a class="text-content__link text-content__link--text-lightest" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<p class="text-content__excerpt text-content__excerpt--text-gray">
								<?php echo wp_trim_words(get_the_excerpt(), 35); ?>
							</p>
							<ul class="pub-details pub-details--light">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<?php
			                at_get_the_m32banner(
			                    $arr_m32_vars = [
			                        'kv' => [
			                            'pos' => [
			                                'atf',
			                                'but1',
			                                'right_bigbox',
			                                'top_right_bigbox',
			                            ],
			                        ],
			                        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
			                        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
			                    ],
			                    $arr_avt_vars = [
			                        'class' => 'bigbox text-center',
			                    ]
			                );
				    ?>
					</div>
				</div>
				<?php } ?>

				<?php if ($i > 1 && $i <= 4) { ?>
					<?php if ($i == 2) { ?>
						<!-- 2 - 3 - 4 videos -->
						<div class="row">
					<?php } ?>
						<div class="col-md-4 col-sm-4"><!-- video-<?php the_ID(); ?>  -->
							<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
							<?php if (has_post_thumbnail()) { ?>
								<figure class="figure-relative text-content no-padding-bottom  col-md-5 col-sm-12 col-xs-12 ">
									<a href="<?php the_permalink(); ?>"><!--CONFIRM CR-->
										<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full']); ?>
										<i class="videos-caret fa fa-caret-right" aria-hidden="true"></i>
									</a>
								</figure>
							<?php } ?>
								<?php $css_content_video_ = has_post_thumbnail() ? 'col-md-7 col-sm-12 col-xs-12' : 'col-md-12'; ?>
								<div class="text-content no-padding-bottom <?php echo esc_attr($css_content_video_); ?> col-no-padding-right <?php if ($i > 2) {
								    echo 'col-no-padding-left';
								} ?>">
								  <h2 class="text-content__title">
									<a class="text-content__link text-content__link--text-lightest" href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								  </h2>
								<ul class="pub-details pub-details--light">
									<?php avatar_display_post_author($curr_post_id, $single = false); ?>
									<?php avatar_display_post_date($curr_post_id, $single = false); ?>
								</ul>
							   </div>
							</div>
						</div>
					<?php if ($i == 4 or $i == $avatar_video_featured_query->post_count) { ?>
						</div><!-- end 2 - 3 - 4 videos -->
					<?php } ?>
				<?php } $i++; ?>
			<?php } ?>
			</div>
		</section>
		<?php } wp_reset_postdata(); ?>
		<?php // end featured video section?>


		<?php // subcategory video sections?>

					<section class="row"><!-- Latest Videos -->
		<?php if (is_array($avatar_subcategory_query->terms)) { ?>
			<?php foreach ($avatar_subcategory_query->terms as $sub_category) { ?>
				<?php

                    $avatar_video_page_id = avatar_get_page_by_cat($sub_category->term_id);

			    $avatar_video_featured_subcat_args = [
			        'post_status' => 'publish',
			        'post_type' => 'post',
			        'posts_per_page' => 6,
			        'cat' => $sub_category->term_id,
			        'post__not_in' => $avatar_video_featured_ids,
			    ];
			    $avatar_video_featured_subcat_query = new WP_Query($avatar_video_featured_subcat_args);

			    ?>
			<?php if ($avatar_video_featured_subcat_query->post_count > 0) { ?>

				<div class=" category-video-listing row row--no-margin">
					<div class="col-md-12">
						<h2 class="bloc-title bloc-title--no-margin-bottom">
							<a class="bloc-title__link" href="<?php echo esc_url(get_page_link($avatar_video_page_id)); ?>">
								<span class="bloc-title__text--color"><?php _e('Latest', 'avatar-tcm'); ?> </span>
								<span><?php echo get_the_title($avatar_video_page_id); ?></span>
							</a>
							<i class="bloc-title__caret bloc-title__caret--small fa fa-caret-right" aria-hidden="true"></i>
						</h2>
					</div>
					 <?php while ($avatar_video_featured_subcat_query->have_posts()) {
					     $avatar_video_featured_subcat_query->the_post(); ?>
					 	<?php
					        $curr_post_id = get_the_id();
					     $avatar_video_featured_ids[] = $curr_post_id;
					     ?>
						<div class="col-md-4 col-sm-6">
							<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
							   <?php if (has_post_thumbnail()) { ?>
							   <figure class="figure-relative text-content no-padding-bottom col-md-5 col-sm-5 col-xs-12 col-no-padding-right">
								  <a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full']); ?>
								  	<i class="videos-caret fa fa-caret-right" aria-hidden="true"></i>
								  </a>
							   </figure>
							   <?php } ?>
								<?php $css_content_video = has_post_thumbnail() ? 'col-md-7 col-sm-7 col-xs-12' : 'col-md-12'; ?>
							   <div class="text-content no-padding-bottom col-no-padding-right col-no-padding-right <?php echo esc_attr($css_content_video); ?> ">
								  <h3 class="text-content__title">
									<a class="text-content__link text-content__link--text-hover-base" href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								  </h3>
									<ul class="pub-details">
										<?php avatar_display_post_author($curr_post_id, $single = false); ?>
										<?php avatar_display_post_date($curr_post_id, $single = false); ?>
									</ul>
							   </div>
							</div>
						</div>
					<?php } ?>

				</div>

			<?php } ?>


			 <?php } ?>
		<?php } ?>
	</section>
		<?php // endn subcategory video sections?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer(); ?>