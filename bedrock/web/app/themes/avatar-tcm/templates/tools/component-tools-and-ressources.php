<?php
$site_id = get_current_blog_id();
$avatar_webinars = get_field('acf_tools_webinars_link', 'options');
$avatar_events = get_field('acf_tools_events_link', 'options');
$avatar_foryourclients = get_field('acf_tools_foryourclients_link', 'options');
$avatar_advisorcentral = get_field('acf_tools_advisorcentral_link', 'options');
$avatar_tools_resources = get_field('acf_tools_resources_link', 'options');
$avatar_tools_ceplace_login = get_field('acf_tools_ce_place_login_link', 'options');

// exit the file if no settins
if (! ($avatar_webinars && $avatar_foryourclients && $avatar_advisorcentral && $avatar_tools_resources && $avatar_tools_ceplace_login)) {
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
	<?php switch ($site_id) {
	    case 3: // IE
	        ?>
			<div class="row foot">
				<div class="component col-md-12" style= "width:100%"> 
					<div class="col-md-12">
						<figure style="display: block; margin-left: auto; margin-right: auto; width: 91%;"> 
							<a href="https://www.investmentexecutive.com/microsite/events/"><img src="https://www.investmentexecutive.com/wp-content/uploads/sites/3/2019/05/Events-gif-IE.gif" alt="Events" class="img-responsive text-content__image-full rrc_homewidget lazyloading" data-was-processed="true"> </a>
						</figure>
					</div>
				</div>
			</div>
		<?php
        break;
	    case 4: // Conseiller
	        ?>
			<div class="row foot">
				<div class="component col-md-12">
					<div class="col-md-12">
						<figure style="display: block; margin-left: auto; margin-right: auto; width: 91%;"> 
							<a href="https://www.conseiller.ca/microsite/nos-evenements/"><img src="https://www.conseiller.ca/wp-content/uploads/sites/4/2019/05/Events-gifs-CZ.gif" alt="Événéments" class="img-responsive text-content__image-full rrc_homewidget lazyloading" data-was-processed="true"> </a>
						</figure>
					</div>
				</div>
			</div>			
			<?php
        break;
	    case 5: // Advisor
	        ?>
			<div class="row foot">
				<div class="component col-md-12">
					<div class="col-md-12">
						<figure style="display: block; margin-left: auto; margin-right: auto; width: 91%;"> 
							<a href="https://www.advisor.ca/microsite/events/"><img src="https://www.investmentexecutive.com/wp-content/uploads/sites/3/2019/05/Events-gif-IE.gif" alt="Events" class="img-responsive text-content__image-full rrc_homewidget lazyloading" data-was-processed="true"> </a>
						</figure>
					</div>
				</div>
			</div>			
			<?php
        break;
	} ?>
	
	<div class="row foot">
		<?php if ($avatar_tools_ceplace_login) { ?>
		<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>" target="_blank" class="col-xs-4 ce-place text-content__link">
			<span><?php _e('CE Corner', 'avatar-tcm'); ?></span>
		</a>
		<?php } ?>

		<?php if ($avatar_foryourclients != null) { ?>
			<a href="<?php echo esc_url(get_category_link($avatar_foryourclients->term_id)); ?>" class="col-xs-4 fyclients text-content__link">
				<span><?php echo wp_kses_post($avatar_foryourclients->name); ?></span>
			</a>
		<?php } ?>
		
		<?php if ($avatar_events != null) { ?>
			<a href="<?php echo esc_url($avatar_events); ?>" class="col-xs-4 eventsIE text-content__link">
				<span><?php _e('Events', 'avatar-tcm'); ?></span>
			</a>
		<?php } ?>
	</div>
</div>
	</div>
</div>