<?php
$avatar_cat_partnersplace = get_field('acf_tools_partnersplace_link', 'option');
$acf_partners_place_repeater = get_field('acf_partners_place_repeater', 'option');

// Test if array exist and create new array with ID only
if (is_array($acf_partners_place_repeater)) {
    $acf_partners_place_repeater_array = [];
    foreach ($acf_partners_place_repeater as $key => $value) {
        $acf_partners_place_repeater_array[] = $value['acf_partners_place_article'];
    }
} else {
    new WP_Error('empty', __('Partners Place Options are empty', 'avatar-tcm'));
}

$wp_query_articles_arg = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'post__in' => $acf_partners_place_repeater_array,
    'orderby' => 'post__in',
];
$wp_query_articles = new WP_Query($wp_query_articles_arg);

if ($wp_query_articles->have_posts()) {
    // Calculate number of articles to get the number of bootstraps columns necessary
    $bootstrap_col = esc_attr(12 / $wp_query_articles->post_count);
    ?>
	<div class="bloc bloc-tools-partners_place">
		<div class="row">
			<div class="col-md-12">
				<h2>
					<a class="text-content__link" href="<?php echo get_category_link($avatar_cat_partnersplace->term_id); ?>"><?php echo wp_kses_post($avatar_cat_partnersplace->name); ?></a>
					<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
				</h2>
			</div>
		</div>
		<ul class="row equal-col horiz-list">
			<?php
            // List of articles
            while ($wp_query_articles->have_posts()) {
                $wp_query_articles->the_post();
                ?>

				<li class="col-sm-<?php echo $bootstrap_col; // Data is escaped?>">
					<div <?php post_class('bg text-content'); ?>>
						<div class="row">
						<?php // Thumbnail
                       if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
							<figure class="col-md-12 thumb">
								<a class="text-content__link" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), $size = 'medium', ['class' => 'img-responsive wp-post-image']); ?></a>
							</figure>
						<?php
                       } ?>
							<div class="col-md-12 text text--half-bloc">
								<?php // Title?>
								<h3><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

								<?php // Excerpt?>
								<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>

								<?php avatar_display_post_sponsor(get_the_ID(), $single = false); ?>
							</div>
						</div>
					</div>
				</li>
			<?php
            }
    wp_reset_postdata(); ?>
		</ul>
	</div>
<?php
}
?>