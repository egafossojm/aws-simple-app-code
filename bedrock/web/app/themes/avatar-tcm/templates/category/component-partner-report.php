<?php
/*
* Location : In Depth main and sub categories except Partners Reports
* Partners Reports Component
* Displays a list of campaigns from Partners Reports
* Admin : Sale's section -> Schedule areas for Feature -> [Featured]
*/
?>
<?php if (have_rows('acf_scheduler_featured_campaigns', 'option')) { ?>
<div class="component component-partner-report">
			<?php
            while (have_rows('acf_scheduler_featured_campaigns', 'option')) {
                the_row();
                $avatar_sh_campaigns_articles = avatar_get_scheduler_campaigns_articles_id(get_sub_field('articles')); ?>
			<?php if (! empty($avatar_sh_campaigns_articles)) {
			    $campaign_url = get_sub_field('in_depth_partners_campaign_url'); ?>
				<h2 class="sponsor-title">
					<?php if ($campaign_url) { ?>
						<a class="sponsor-title__link" href="<?php echo esc_url($campaign_url); ?>" target="_blank">
							<?php echo esc_html(get_sub_field('name')); ?>
						</a>
					<?php } else {
					    echo esc_html(get_sub_field('name'));
					} ?>
					 <i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
				</h2>
				<div class="row row--sponsorPad component-partner-report__listing">

					<?php
					$args = [
					    'post_status' => 'publish',
					    'post_type' => 'post',
					    'posts_per_page' => 20,
					    'post__in' => $avatar_sh_campaigns_articles,
					    'orderby' => 'post__in',
					];
			    $the_query = new WP_Query($args);
			    if ($the_query->have_posts()) {

			        $last_index = count($avatar_sh_campaigns_articles);
			        while ($the_query->have_posts()) {
			            $the_query->the_post(); ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class('text-content no-padding-bottom  text-content--sponsorPad'); ?>>
							<?php if (has_post_thumbnail()) { ?>
								<figure class="col-md-12 col-sm-6 col-xs-12">
									<a href="<?php the_permalink(); ?>">
										<div class="article-thumbnail">
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive']); ?></a>
										</div>
									</a>
								</figure>
							<?php }?>
								<div class="col-md-12 col-sm-6 col-xs-12">
									<div>
										<h3 class="text-content__title text-content__title--big icons <?php echo avatar_article_get_icon(get_the_id()); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
		<?php } ?>
	<?php } ?>
</div>
<?php } ?>