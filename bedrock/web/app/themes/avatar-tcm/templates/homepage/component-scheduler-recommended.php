<?php
/*
* Location : HomePage
* Recommended scheduler Component
* Displays a list of Recommended's campaigns
* Admin : Sale's section [Recommended]
*/
?>
<?php if (have_rows('acf_scheduler_recommended_campaigns', 'option')) { ?>
	<div class="component sponsor-bg row row--no-margin">
			<?php while (have_rows('acf_scheduler_recommended_campaigns', 'option')) {
			    the_row();
			    $avatar_sh_campaigns_articles = avatar_get_scheduler_campaigns_articles_id(get_sub_field('articles')); ?>
			<?php if (! empty($avatar_sh_campaigns_articles)) {
			    $campaign_url = get_sub_field('homepage_recommended_campaign_url'); ?>
			<div class="row--relative col-sm-12 col-md-12">
				<h2 class="sponsor-title">
					<?php if ($campaign_url) { ?>
						<a class="sponsor-title__link" href="<?php echo esc_url($campaign_url); ?>" target="_blank">
							<?php echo esc_html(get_sub_field('name')); ?>
						</a>
					<?php } else { ?>
					 	<?php echo esc_html(get_sub_field('name')); ?>
					 <?php } ?>
					<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
				</h2>
				<div class="row row--sponsorPad ">
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
			            $the_query->the_post();
			            $conditional_col_css = 'col-md-12 col-sm-12' ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php if (has_post_thumbnail()) {
								    $conditional_col_css = 'col-md-6 col-sm-6'; ?>
									<figure class="col-md-6 col-sm-6 col-xs-12 col-col-no-padding-right col-no-padding-right">
										<a href="<?php the_permalink(); ?>">
											<div>
												<?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive text-content__image-full text-content']); ?>
											</div>
										</a>
									</figure>
								<?php } ?>
								<div class="<?php echo esc_attr($conditional_col_css); ?> col-xs-12">
									<div class="text-content">
										<h3 class="text-content__title text-content__title--big icons <?php echo avatar_article_get_icon(get_the_id()); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
							</div>
						<?php } ?>
					<?php } wp_reset_postdata(); ?>
				</div>
			</div>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>