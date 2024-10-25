<?php
$avatar_webinars = get_field('acf_tools_webinars_link', 'options');
$avatar_foryourclients = get_field('acf_tools_foryourclients_link', 'options');
$avatar_advisorcentral = get_field('acf_tools_advisorcentral_link', 'options');
$avatar_tools_resources = get_field('acf_tools_resources_link', 'options');
$avatar_tools_ceplace_login = get_field('acf_tools_ce_place_login_link', 'options');

// exit the file if no settins
if (! ($avatar_webinars && $avatar_foryourclients && $avatar_advisorcentral && $avatar_tools_resources)) {
    return;
}

$wp_query_articles_arg = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 2,
    'cat' => $avatar_webinars->term_id,
];
$wp_query_articles = new WP_Query($wp_query_articles_arg);
?>
<div class="col-sm-6 col-md-12 tools-module tools-module--tools-resources">
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
<?php if ($wp_query_articles && $avatar_webinars != null) { ?>
<div class="row">
		<div class="col-md-12">
			<h2 class="webinars">
				<a class="text-content__link" href="<?php echo get_category_link($avatar_webinars->term_id); ?>"><?php echo wp_kses_post($avatar_webinars->name); ?></a>
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
				<div <?php post_class((avatar_is_brand(get_the_ID()) ? 'sponsor-bg ' : '').'bg'); ?>>

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
	<div class="row foot">
	    <?php if ($avatar_tools_ceplace_login) { ?>
		<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>" target="_blank" class="col-xs-4 ce-place text-content__link">
			<span><?php echo get_the_title($avatar_tools_ceplace_login); ?></span>
		</a>
		<?php } ?>
		
		<?php if ($avatar_foryourclients != null) { ?>
			<a href="<?php echo esc_url(get_category_link($avatar_foryourclients->term_id)); ?>" class="col-xs-4 whitebook text-content__link">
				<span><?php echo wp_kses_post($avatar_foryourclients->name); ?></span>
			</a>
		<?php } ?>
	</div>
</div>
	</div>
</div>