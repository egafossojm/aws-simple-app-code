<?php
/**
 * Template Name: Video: SubPage
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
$curr_page_id = get_the_ID();
$avatar_exclude_video_ids = avatar_get_featured_video_articles_id();
$avatar_video_cat_id = avatar_get_cat_by_page($curr_page_id);

// Arguments
$avatar_first_video_subcat_arrg = [
    'post_type' => 'post',
    'cat' => $avatar_video_cat_id,
    'post__not_in' => $avatar_exclude_video_ids,
    'order' => 'DESC',
    'order_by' => 'post_date',
    'posts_per_page' => 1,
];

$avatar_first_video_subcat_query = new WP_Query($avatar_first_video_subcat_arrg);

?>
<?php get_header(); ?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main">
		<?php // featured video section?>
		<?php if ($avatar_first_video_subcat_query->have_posts()) { ?>
			<?php while ($avatar_first_video_subcat_query->have_posts()) {
			    $avatar_first_video_subcat_query->the_post(); ?>
				<?php $curr_post_id = get_the_id(); ?>
				<?php $avatar_exclude_video_ids[] = $curr_post_id; ?>

			<section class="row row--no-margin"><!-- Featured Video -->

				<div class="col-md-12 color_bg_dark_navy text-content">
				<div class="row">
					<div class="col-md-8 col-sm-5">
						<div class="text-right">

                            <span class=featured-videos-title>
                    				<?php _e('Latest video', 'avatar-tcm'); ?>
                    			</span>
                                <span class=featured-videos-title>
                                    <?php echo esc_attr(_x('On ', 'keep the space after the word', 'avatar-tcm')); ?>
                    			</span>
								<span class="featured-videos-title featured-videos-title--thin">

									<h1 class="featured-videos-title">
										<?php echo get_the_title($curr_page_id); ?>
									</h1>
									<i class="featured-videos-title__icon fa fa-video-camera"></i>
								</span>
							</h1>
						</div>
						<?php if (has_post_thumbnail()) { ?>
							<figure class="figure-relative text-content no-padding-bottom">
								<a class="featured-video" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive text-content__image-full']); ?>
									<i class="videos-caret videos-caret--featured fa fa-caret-right" aria-hidden="true"></i>
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
					<div class="col-md-4 col-sm-7">
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

				</div>
			</section>
			<?php } ?>
		<?php } wp_reset_postdata(); // end have_posts?>
		<?php //end 1 video?>


		<?php
            // video 2-9
            $page_id = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 8;
$avatar_video_subcat_arrg = [
    'post_type' => 'post',
    'cat' => $avatar_video_cat_id,
    'post__not_in' => $avatar_exclude_video_ids,
    'order' => 'DESC',
    'order_by' => 'post_date',
    'paged' => $page_id,
    'posts_per_page' => $posts_per_page,
];

$avatar_video_subcat_query = new WP_Query($avatar_video_subcat_arrg);
?>


		<?php if ($avatar_video_subcat_query->have_posts()) { ?>
				<section class="col-md-8">
					<div class="row category-regular-listing" id="js-regular-listing-container" >
			<?php while ($avatar_video_subcat_query->have_posts()) {
			    $avatar_video_subcat_query->the_post(); ?>
				<?php $curr_post_id = get_the_id(); ?>
				<div class="col-md-6 col-sm-6 js-regular-listing"><!-- LOOP  -->
					<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
						<?php if (has_post_thumbnail()) { ?>
						<figure class="figure-relative text-content no-padding-bottom col-md-5 col-sm-5 col-xs-12 col-no-padding-xs-left col-no-padding-xs-right">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full']); ?>
							<i class="videos-caret videos-caret--listing fa fa-caret-right" aria-hidden="true"></i>
							</a>
						</figure>
						<?php }?>
						<?php $css_content_video = has_post_thumbnail() ? 'col-md-7 col-sm-7 col-xs-12' : 'col-md-12'; ?>
						<div class="text-content no-padding-bottom  <?php echo esc_attr($css_content_video); ?> ">
							<h2 class="text-content__title">
								<a class="text-content__link text-content__link--text-hover-base" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<ul class="pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>
				</div>
					<div class="pagination pagination--video">
						<?php next_posts_link('Older Entries', $avatar_video_subcat_query->max_num_pages); ?>
					</div>
				</section>
		<?php } else { ?>
			<section class="col-md-8"></section>
		<?php } wp_reset_postdata(); // end have_posts?>


			<aside class="col-md-4 video-subpage">
            <?php //include Quick subscribe newsletters component
              avatar_include_subscription_module();
?>
				<?php //include Video Component
include locate_template('templates/general/component-video-light.php');
?>
			</aside>

		<?php // endn subcategory video sections?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>
