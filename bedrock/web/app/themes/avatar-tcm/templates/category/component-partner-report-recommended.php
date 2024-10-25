<?php
/* -------------------------------------------------------------
 * Location : In Depth sub category Partners Reports
 * Partners Reports scheduler recommended Component
 * Displays a recommended campaign from Partners Reports
 * Admin : Sale's section -> Schedule areas for Feature -> [Recommended]
 * ============================================================*/
?>
<?php if (have_rows('acf_scheduler_recommended_feature_campaigns', 'option')) { ?>
		<?php while (have_rows('acf_scheduler_recommended_feature_campaigns', 'option')) {
		    the_row();
		    $avatar_sh_campaigns_articles = avatar_get_scheduler_campaigns_articles_id(get_sub_field('articles'));
		    $campaign_url = get_sub_field('in_depth_recommended_campaign_url');
		    ?>

			<?php if (! empty($avatar_sh_campaigns_articles)) { ?>
<div class="component component-partner-report-recommended sponsor-bg">

	
			<div class="row--relative">


				<div class="row row--sponsorPad">
					<?php
		                $args = [
		                    'post_status' => 'publish',
		                    'post_type' => 'post',
		                    'posts_per_page' => 1,
		                    'post__in' => $avatar_sh_campaigns_articles,
		                    'orderby' => 'post__in',
		                ];
			    $the_query = new WP_Query($args);
			    if ($the_query->have_posts()) {
			        while ($the_query->have_posts()) {
			            $the_query->the_post(); ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								
								<?php if (has_post_thumbnail()) { ?>
								<figure class="col-md-6 col-sm-6 col-xs-12 col-no-padding-right min-height-small">
									<?php if ($campaign_url) { ?>
										<a class="sponsor-title__link" href="<?php echo esc_url($campaign_url); ?>" target="_blank">
											<p class="sponsor-title sponsor-title--absolute sponsor-title--recommended">
												<?php echo esc_html(get_sub_field('name')); ?>
											</p>
										</a>
									<?php } else {
									    ?>
									 	<p class="sponsor-title sponsor-title--absolute sponsor-title--recommended">
											<?php echo esc_html(get_sub_field('name')); ?>
										</p>
									 	<?php
									} ?>
									<a href="<?php the_permalink(); ?>">
										<div>
											<?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive text-content no-padding-bottom']); ?>
										</div>
									</a>
								</figure>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text-content no-padding-bottom">
										<h2 class="text-content__title text-content__title--big icons <?php echo avatar_article_get_icon(get_the_id()); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<p class="text-content__excerpt">
											<?php
									           if (has_excerpt()) {
									               echo wp_trim_words(get_the_excerpt(), 25);
									           } else {
									               echo strip_shortcodes(wp_trim_words(get_the_content(), 25));
									           }
								    ?>
										</p>
										<ul class="pub-details">
											<?php avatar_display_post_author(get_the_id(), $single = false); ?>
											<?php avatar_display_post_source(get_the_id(), $single = false); ?>
											<?php avatar_display_post_date(get_the_id(), $single = false); ?>
										</ul>
									</div>
								</div>
								<?php } else {?>
									<figure class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-no-padding-right min-height-small">
										<?php if ($campaign_url) { ?>
											<a class="sponsor-title__link" href="<?php echo esc_url($campaign_url); ?>" target="_blank">
												<p class="sponsor-title sponsor-title--recommended">
													<?php echo esc_html(get_sub_field('name')); ?>
												</p>
											</a>
										<?php } else {
										    ?>
										 	<p class="sponsor-title sponsor-title--absolute sponsor-title--recommended">
												<?php echo esc_html(get_sub_field('name')); ?>
											</p>
										 	<?php
										} ?>
									</figure>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="text-content no-padding-bottom">
											<h2 class="text-content__title text-content__title--big icons <?php echo avatar_article_get_icon(get_the_id()); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
											<p class="text-content__excerpt">
												<?php
										           if (has_excerpt()) {
										               echo wp_trim_words(get_the_excerpt(), 25);
										           } else {
										               echo strip_shortcodes(wp_trim_words(get_the_content(), 25));
										           }
								    ?>
											</p>
											<ul class="pub-details">
												<?php avatar_display_post_author(get_the_id(), $single = false); ?>
												<?php avatar_display_post_source(get_the_id(), $single = false); ?>
												<?php avatar_display_post_date(get_the_id(), $single = false); ?>
											</ul>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } wp_reset_postdata(); ?>
				</div>
			</div>
		
</div>
<?php } ?>
	<?php } ?>
<?php } ?>