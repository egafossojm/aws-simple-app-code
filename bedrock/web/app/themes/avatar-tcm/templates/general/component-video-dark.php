<?php
/*
* Location : General (see design)
* Video dark themed Component
* Displays a list of most recent videos from IE TV
*/
$avatar_video_featured_ids = avatar_get_featured_video_articles_id();
$avatar_video_featured_page_id = get_field('acf_featured_video_page', 'option');
$avatar_video_featured_args = [
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__in' => $avatar_video_featured_ids,
    'orderby' => 'post__in',
];
$avatar_video_featured_args_query = new WP_Query($avatar_video_featured_args);

?>

<?php if ($avatar_video_featured_args_query->have_posts() && $avatar_video_featured_ids) { ?>
	<div class="component component-ie-tv color_bg_dark_navy col-sm-6 col-md-12">
		<div class="col-md-12">
			<h2 class="featured-videos-title">
				<a class="featured-videos-title__link" href="<?php echo esc_url(get_page_link($avatar_video_featured_page_id)); ?>">
					<?php echo get_the_title($avatar_video_featured_page_id); ?>
				</a>
				<i class="featured-videos-title__icon fa fa-video-camera"></i>
				<!--<a href="<?php echo esc_url(get_page_link($avatar_video_featured_page_id)); ?>" title="FI TV">
					<?php _e('More Videos', 'avatar-tcm'); ?>
				</a>-->
			</h2>
		</div>
	<div class="row">
		<?php while ($avatar_video_featured_args_query->have_posts()) {
		    $avatar_video_featured_args_query->the_post(); ?>
			<?php $curr_post_id = get_the_ID(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('col-xs-12 col-md-12'); ?>>
					<?php if (has_post_thumbnail()) { ?>
					<figure class="text-content no-padding-bottom col-md-6 col-sm-6 col-xs-12 col-no-padding-right">
					  <a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full', 'title' => get_the_title()]); ?>
					  	<i class="videos-caret fa fa-caret-right" aria-hidden="true"></i>
					  </a>
					</figure>
					<?php }?>
					<div class="text-content no-padding-bottom <?php echo esc_attr($css = has_post_thumbnail() ? 'col-md-6 col-sm-6 col-xs-12' : 'col-md-12'); ?>">
						<h3 class="text-content__title">
							<a class="text-content__link text-content__link--text-lightest" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						 </h3>
						 <!--<span><?php the_excerpt(); ?></span>-->
					</div>
				</div>
		<?php } ?>
	</div>
</div>
<?php } wp_reset_postdata(); ?>