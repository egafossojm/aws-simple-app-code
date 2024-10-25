<?php
// Get acf_newspaper_page ID
$newspaper_page_id = get_field('acf_newspaper_page', 'options');

// Get the last Newspaper Date
$newspaper_args = [
    'post_type' => 'newspaper',
    'post_status' => 'publish',
    'posts_per_page' => 1,
];
$newspaper_obj = new WP_Query($newspaper_args);

// Get all news ID
$get_newspaper_arr = get_field('acf_homepage_newspaper', 'options');

if (is_array($get_newspaper_arr)) {
    foreach ($get_newspaper_arr as $id) {
        $get_newspaper_ids[] = $id['news'];
    }

    $get_newspaper_args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'post__in' => $get_newspaper_ids,
        'orderby' => 'post__in',
    ];
    $get_newspaper_posts_obj = new WP_Query($get_newspaper_args);
} else {
    error_log('get_newspaper_arr is not array');

    return;
}

?>
<?php if ($newspaper_page_id && $get_newspaper_posts_obj->have_posts()) { ?>
	<div class="component component-newspaper component-home">
		<h2 class="bloc-title">
			<a class="bloc-title__link" href="<?php the_permalink($newspaper_page_id); ?>"><?php echo get_field('acf_homepage_newspaper_bloc_title', 'option'); ?></a>
			<i class=" bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
		</h2>

		<div class="row">
			<?php if ($newspaper_obj->have_posts()) {  ?>
				<?php while ($newspaper_obj->have_posts()) {
				    $newspaper_obj->the_post(); ?>
					<?php $css_col = has_post_thumbnail() ? 'col-sm-9' : 'col-sm-12'; ?>
					<?php if (has_post_thumbnail()) {  ?>
						<div class="col-sm-3">
							<figure class="text-content">
								<a href="<?php the_permalink($newspaper_page_id); ?>">
									<div>
										<?php the_post_thumbnail('medium_large', ['class' => 'img-responsive text-content__image-full']); ?>
									</div>
									</a>
							</figure>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } wp_reset_postdata(); ?>

			<?php if ($get_newspaper_posts_obj->have_posts()) {  ?>
				<div class="<?php echo esc_attr($css_col); ?>">
				<?php while ($get_newspaper_posts_obj->have_posts()) {
				    $get_newspaper_posts_obj->the_post(); ?>
					<div <?php post_class(); ?>>
						<div class="text-content ">
							<h3 class="text-content__title icons <?php echo avatar_article_get_icon(get_the_id()); ?> ">
								<a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<ul class="pub-details">
								<?php avatar_display_post_author(get_the_id(), $single = false); ?>
							</ul>
						</div>
					</div>
				<?php } wp_reset_postdata(); ?>

				</div>
			<?php } ?>

		<div class="col-sm-12">
		
			<div class="text-center component-newspaper__btn">
				<a href="<?php the_permalink($newspaper_page_id); ?>" class=" btn btn-lg user-form__btn-submit no-border-radius component-quick-subscribe-newsletters__button"><?php _e('More articles', 'avatar-tcm') ?></a>
				<div class="component-newspaper__btn_required"><?php _e('Login Required', 'avatar-tcm'); ?></div>
			</div>
		</div>
	</div>
</div>
<?php } ?>