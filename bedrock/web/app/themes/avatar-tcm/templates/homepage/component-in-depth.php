<?php
/*
* Location : HomePage
* In Depth Component
* Displays a list of 4 manual selection of custom post type Features
* Admin : Editor's section [Featured In-Depth]
*/
/* -------------------------------------------------------------
 *  Get Feature ID's from Option page
 * ============================================================*/
$avatar_featured_indepth_options = get_field('featured_indepth_features', 'option');
$avatar_indepth_page_obj = get_field('acf_in_depth_breadcrumb', 'option');
if (! $avatar_indepth_page_obj) {
    error_log('$avatar_indepth_page_obj is not object');

    return;
}
$avatar_indepth_page_color_class = avatar_get_cat_page_color($avatar_indepth_page_obj->ID);

// Test if array exist and create new array with ID only
if (is_array($avatar_featured_indepth_options)) {
    $avatar_featured_indepth_array = [];
    foreach ($avatar_featured_indepth_options as $key => $value) {
        $avatar_featured_indepth_array[] = $value['featured_indepth_feature'];
    }
} else {
    error_log('$avatar_featured_indepth_options is not array');

    return;
}

// WP_Query arguments
$avatar_featured_indepth_args = [
    'post_type' => 'feature',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'post__in' => $avatar_featured_indepth_array,
    'orderby' => 'post__in',
];

// The Query
$avatar_featured_indepth_cpt_query = new WP_Query($avatar_featured_indepth_args);

if ($avatar_featured_indepth_cpt_query->post_count == 0) {
    return;
}
// Get In Dept page
?>
<div class="component component-home component-home-in-depth <?php echo esc_attr($avatar_indepth_page_color_class); ?>">

	<?php if ($avatar_indepth_page_obj) { ?>
		<h2 class="bloc-title bloc-title--no-margin-bottom">
			<a href="<?php echo esc_url(get_page_link($avatar_indepth_page_obj->ID)); ?>"
				   title="<?php echo get_the_title($avatar_indepth_page_obj->ID); ?>">
				   <?php echo get_the_title($avatar_indepth_page_obj->ID); ?>
			</a>
			<i class="bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
		</h2>
	<?php } ?>

	<div class="row equal-col entity-listing">
		<?php
            if ($avatar_featured_indepth_cpt_query->have_posts()) {
                $total_posts = count($avatar_featured_indepth_cpt_query->posts);
                while ($avatar_featured_indepth_cpt_query->have_posts()) {
                    $avatar_featured_indepth_cpt_query->the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-3 col-sm-3 col-xs-6 text-center col-sub'); ?>>

						<a href="<?php the_permalink(); ?>">
							<?php if (has_post_thumbnail()) { ?>
								<div class="col-in-depth-thumbnail">
									<?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'component-home-in-depth__image']); ?>
								</div>
							<?php } ?>
							<h3 class="component-home-in-depth__name">
								<?php the_title(); ?>
							</h3>
						</a>

					</div>
				<?php } ?>
		<?php } else { ?>
				<?php _e('No Feature found.', 'avatar-tcm'); ?>
		<?php } ?>
	</div>
</div>