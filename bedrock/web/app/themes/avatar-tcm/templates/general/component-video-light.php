<?php
/*
* Location : General (see design)
* Video light themed Component
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

<?php if ($avatar_video_featured_args_query->have_posts()) { ?>
	<div class="component component-ie-tv component-ie-tv--light">
		<div class="col-md-12 col-no-padding-left col-no-padding-right">
			<h2 class="bloc-title bloc-title--no-margin-bottom">
				<span><?php _e('Currently Featured', 'avatar-tcm'); ?></span>
			</h2>
		</div>
		<div class="row">
		<?php while ($avatar_video_featured_args_query->have_posts()) {
		    $avatar_video_featured_args_query->the_post(); ?>
		<?php $curr_post_id = get_the_id(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class('col-xs-12 col-sm-6 col-md-12 col-no-padding-left'); ?>>
				<?php if (has_post_thumbnail()) { ?>
				<figure class="text-content no-padding-bottom col-md-5 col-sm-5 col-xs-12 col-no-padding-right">
				  <a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full', 'alt' => get_the_title()]); ?>
				  	<i class="videos-caret fa fa-caret-right" aria-hidden="true"></i>
				  </a>
				</figure>
				<?php }?>
				<div class="text-content no-padding-bottom <?php echo esc_attr($css = has_post_thumbnail() ? 'col-md-7 col-sm-7 col-xs-12' : 'col-md-12'); ?>">
					<h3 class="text-content__title">
						<a class="text-content__link  text-content__link--text-hover-base" href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					 </h3>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php } wp_reset_postdata(); ?>