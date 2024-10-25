<?php
/**
 * Template Name: Brand Knowledge: IndexPage
 *
 * This is the template that displays Brand Knowledge section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php get_header(); ?>
<div class="landing-sponsor sponsor-bg">
   <div class="row row--sponsorPad">
	  <div class="col-sm-3">
		 <h1 class="sponsor-title sponsor-title--landing">
		 	<?php echo esc_html(get_field('acf_brand_knowledge_info_title', 'option')); ?>
		 </h1>
	  </div>
	  <div class="col-sm-9">
		 <p class="landing-sponsor__description">
			<?php echo wp_kses_post(get_field('acf_brand_knowledge_info_desc', 'option')); ?>
		 </p>
	  </div>
   </div>
</div>
<?php
    $avatar_brand_args = [
        'post_type' => 'brand',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'meta_query' => [
            'brand_date' => [
                'key' => 'acf_brand_published_date',
                'type' => 'NUMERIC',
            ],
        ],
        'orderby' => [
            'brand_date' => 'DESC',
        ],
    ];
$avatar_brand_cpt_query = new WP_Query($avatar_brand_args);
?>



<?php if ($avatar_brand_cpt_query->have_posts()) { ?>
		<div class="col-md-12">
	<?php while ($avatar_brand_cpt_query->have_posts()) {
	    $avatar_brand_cpt_query->the_post(); ?>

		<?php
	        $avatar_brand_args = [
	            'post_type' => 'post',
	            'posts_per_page' => 4,
	            'post_status' => 'publish',
	            'meta_query' => [
	                'relation' => 'AND',
	                [
	                    'key' => 'acf_article_type',
	                    'value' => 'brand',
	                    'compare' => '=',
	                ],
	                [
	                    'key' => 'acf_article_brand',
	                    'value' => get_the_ID(),
	                    'compare' => '=',
	                ],

	            ],
	            'order' => 'DESC',
	            'orderby' => 'date',
	        ];
	    $wp_query_brand_articles = new WP_Query($avatar_brand_args);
	    $avatar_count_brand_posts = $wp_query_brand_articles->found_posts;
	    $avatar_brand_found_posts = sprintf(_n('%s Article', '%s Articles', $avatar_count_brand_posts, 'avatar-tcm'), $avatar_count_brand_posts);
	    ?>


			<?php if ($avatar_count_brand_posts != 0) { ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('brand-bloc'); ?>>
			   <div class="row brand-bloc__header equal-col-xs sponsor-bg">
				  <div class="brand-bloc__logo col-md-6 col-xs-12">
					<?php if (has_post_thumbnail()) { ?>
						<h2 class="brand-bloc__logo-title">
				 			<figure>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail([
									    200,
									    100], [
									        'alt' => get_the_title(),
									    ]); ?>
								</a>
							</figure>
						</h2 class="brand-bloc__logo-title">
					<?php } else { ?>
						<h2 class="brand-bloc__title">
							<a class="brand-bloc__link" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
					<?php } ?>
				  </div>
				  <div class="brand-bloc__infos col-md-6 col-xs-12 text-right ">
					 <div class="brand-bloc__count">
					 	<a href="<?php the_permalink(); ?>">
					 		<span class="brand-bloc__count-text"><?php echo wp_kses_post($avatar_brand_found_posts); ?></span>
					 	</a>
					 	<i class="brand-bloc__count-caret fa fa-caret-right" aria-hidden="true"></i>
					 </div>
				  </div>
			   </div>
			   <div class="row brand-bloc__content sponsor-bg ">
				  <div class="col-md-4 col-no-padding-right">
					 <div class="text-content text-content__excerpt"><?php the_content(); ?></div>
				  </div>
				<?php if ($wp_query_brand_articles->have_posts()) {
				    $i = 0;
				    $total_posts = $wp_query_brand_articles->post_count; ?>
					<?php while ($wp_query_brand_articles->have_posts()) {
					    $wp_query_brand_articles->the_post(); ?>
						<?php $curr_post_id = get_the_ID(); ?>
						<?php $i++;
					    $text_content_extra_class_noPadT = has_post_thumbnail() ? 'no-padding-top' : ''; ?>
						<?php if ($i == 1) { ?>
							  <div class="col-sm-6 col-md-4 col-no-padding-right">
								 <div class="mid-article">
									<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
											<figure class="no-padding-bottom">
												<a href="<?php the_permalink(); ?>">
													<div class="article-thumbnail">
														<?php the_post_thumbnail('medium_large', ['class' => 'img-responsive']); ?>
													</div>
												</a>
											</figure>
										<?php } ?>
									   <div class="text-content no-padding-top">
										  <h3 class="text-content__title text-content__title--big"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										  <ul class="pub-details">
											<?php avatar_display_post_date($curr_post_id, $single = false); ?>
										  </ul>
										  <p class="text-content__excerpt">
											<?php echo get_the_excerpt(); ?>
										  </p>
									   </div>
									</div>
								 </div><!-- end 1st article -->
							  </div>
						<?php } ?>

						<?php if ($i >= 2) { ?>
							<?php if ($i == 2) { ?>
								<div class="col-sm-6 col-md-4">
							<?php } ?>
								 <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="text-content no-padding-bottom">
									   <h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									   <p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
										<ul class="pub-details">
										   <?php avatar_display_post_source($curr_post_id, $single = false); ?>
										   <?php avatar_display_post_date($curr_post_id, $single = false); ?>
										</ul>
									</div>
								 </div> <!-- end artcle <?php the_ID(); ?> -->

							<?php if ($i == 4 or $i == $total_posts) { ?>
								</div> <!-- end artcile container -->
							<?php } ?>

						<?php } ?>

					<?php } ?>
				<?php } ?>

			   </div><!-- end sponsor-bg -->
			</div><!-- end brand <?php the_ID(); ?> -->
			<?php } //hide if has 0 posts?>
	<?php } ?>
	</div><!-- end brand-listing-container -->

	<?php wp_reset_postdata(); ?>
<?php } else { ?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'avatar-tcm'); ?></p>
<?php } ?>


<?php get_footer(); ?>
