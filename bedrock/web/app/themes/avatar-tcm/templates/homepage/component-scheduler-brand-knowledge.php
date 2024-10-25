<?php
/*
* Location : HomePage
* Brand knowledge scheduler Component
* Displays a list of Brand knowledge's campaigns
* Admin : Sale's section [Brand Knowledge]
*/
?>
<?php if (have_rows('acf_scheduler_brandknowledge_campaigns', 'option')) { ?>
	<?php while (have_rows('acf_scheduler_brandknowledge_campaigns', 'option')) {
	    the_row();
	    $avatar_sh_campaigns_articles = avatar_get_scheduler_campaigns_articles_id(get_sub_field('articles')); ?>
		<?php if (! empty($avatar_sh_campaigns_articles)) {
		    //AIESE-628 Brand Knowledge widget on homepage-
		    $campaign_url = get_sub_field('url'); ?>
			<div class="component component-sponsor-scheduler sponsor-bg">
				<h2 class="sponsor-title sponsor-title--home-no-neg-margin">
					<?php if ($campaign_url) { ?>
						<a class="sponsor-title__link" href="<?php echo esc_url($campaign_url); ?>" target="_blank">
							<?php echo esc_html(get_sub_field('name')); ?>
						</a>
					<?php } else {
					    echo esc_html(get_sub_field('name'));
					} ?>
					<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
				</h2>
				<div class="row row--sponsorPad">
					<div class="col-md-12">
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
		        $i = 0;
		        while ($the_query->have_posts()) {
		            $the_query->the_post();
		            $i++;

		            $col_conditional_width = (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) ? 'col-md-7 col-sm-7 col-xs-12' : 'col-md-12';

		            ?>
									<div id="post-<?php the_ID(); ?>" <?php post_class('row no-padding'); ?>>
										<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
											<figure class="text-content no-padding-bottom col-md-5 col-sm-5 col-xs-12 col-no-padding-right">
												<a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>"></a></a>
											</figure>
										<?php }?>
										<div class="text-content no-padding-bottom <?php echo esc_attr($col_conditional_width); ?>">
											<h3 class="text-content__title icons <?php echo avatar_article_get_icon(get_the_id()); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<ul class="pub-details">
												<?php avatar_display_post_author(get_the_id(), $single = false); ?>
												<?php avatar_display_post_source(get_the_id(), $single = false); ?>
												<?php avatar_display_post_date(get_the_id(), $single = false); ?>
											</ul>
										</div>
									</div>
							<?php } ?>
						<?php } wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>