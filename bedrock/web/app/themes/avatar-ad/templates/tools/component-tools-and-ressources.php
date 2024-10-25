<?php

$avatar_tools_ceplace_login = get_field('acf_tools_ce_place_login_link', 'options');
$avatar_advisor_retirement_resource_center = get_field('acf_advisor_retirement_resource_center_link', 'options');
$avatar_advisor_to_go = get_field('acf_advisor_to_go_link', 'options');
$avatar_advisor_to_client = get_field('acf_advisor_to_client_link', 'options');

// exit the file if no settins
if (! ($avatar_advisor_retirement_resource_center && $avatar_tools_ceplace_login && $avatar_advisor_to_go) && $avatar_advisor_to_client) {
    return;
}

$wp_query_articles_arg = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 2,
    'cat' => $avatar_advisor_to_client->term_id,
];
$wp_query_articles = new WP_Query($wp_query_articles_arg);
?>

<div class="col-sm-6 col-md-12 tools-module tools-module--tools-resources">
<!--
	<div class="row">
		<div class="bloc">
	<div class="row head">
		<div class="col-md-12">
			<?php if ($avatar_tools_resources != null) { ?>
				<h2>
					<a class="text-content__link" href="<?php the_permalink($avatar_tools_resources); ?>">
						<?php echo get_the_title($avatar_tools_resources); ?>
					</a>
				</h2>
			<?php } ?>
		</div>
	</div>
<?php if ($wp_query_articles && $avatar_advisor_to_client != null) { ?>
<div class="row">
		<div class="col-md-12">
			<h2 class="letters">
				<a class="text-content__link" href="<?php echo get_category_link($avatar_advisor_to_client->term_id); ?>"><?php echo wp_kses_post($avatar_advisor_to_client->name); ?></a>
			</h2>
		</div>
	</div>
	<ul class="row webinar-list">
		<?php
        // List of articles
        while ($wp_query_articles->have_posts()) {
            $wp_query_articles->the_post();
            ?>
			<li class="col-sm-12">
				<div <?php post_class('bg'); ?>>

						<div class="col-sm-6 text">
							<ul class="pub-details">
								<?php avatar_display_post_date(get_the_ID(), $single = false); ?>
							</ul>
							<h3>
								<a class="text-content__link" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h3>

							<?php avatar_display_post_sponsor(get_the_ID(), $single = false); ?>
						</div>
						<?php // Thumbnail
                       if (has_post_thumbnail()) { ?>
							<figure class="col-sm-6 thumb">
								<a class="text-content__link" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), $size = 'medium', ['class' => 'img-responsive wp-post-image']); ?></a>
							</figure>
						<?php
                       }

            // Date?>
				</div>
			</li>
		<?php } wp_reset_postdata(); ?>
	</ul>

<?php } ?>
-->
	<div class="row foot">
				<div class="component col-md-12" style="width: 100%">
					<div class="col-md-12">
						<figure style="display: block; margin-left: auto; margin-right: auto; width: 91%;"> 
							<a href="https://www.advisor.ca/microsite/events/"><img src="https://www.advisor.ca/wp-content/uploads/sites/5/2019/04/Events-gif-AE.gif" alt="Events" class="img-responsive text-content__image-full rrc_homewidget lazyloading" data-was-processed="true"> </a>
						</figure>
					</div>
				</div>
			</div>

	<div class="row foot">
		<?php if ($avatar_tools_ceplace_login) { ?>
		<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>" target="_blank" class="col-xs-4 ce-place text-content__link">
			<span><?php _e('CE Corner', 'avatar-tcm'); ?></span>
		</a>
		<?php } ?>
	

	<?php if ($avatar_advisor_to_go != null) { ?>
		<a href="<?php the_permalink($avatar_advisor_to_go); ?>" target="_blank" class="col-xs-4 headphones text-content__link">
			<span>Advisor <i>ToGo</i> Podcasts</span>
		</a>
		<?php } ?>

		<?php if ($avatar_advisor_retirement_resource_center != null) { ?>
			<a href="<?php the_permalink($avatar_advisor_retirement_resource_center); ?>" class="col-xs-4 retirement text-content__link">
				<span><?php echo get_the_title($avatar_advisor_retirement_resource_center); ?></span>
			</a>
		<?php } ?>
	</div>	
</div>
	