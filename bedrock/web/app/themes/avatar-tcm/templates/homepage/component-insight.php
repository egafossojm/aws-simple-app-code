<?php
/*
* Location : HomePage
* Insight Component
* Displays a list of posts from the category Insight
* Admin : Content options [Home Page] - Featured category 2
*/
$avatar_featured_category = get_field('homepage_featured_category_2', 'option');
$avatar_featured_category_nr = get_field('homepage_featured_category_2_nr', 'option');
if (! ($avatar_featured_category && $avatar_featured_category_nr)) {
    error_log('$avatar_featured_category or $avatar_featured_category_nr return false');

    return;
}
$avatar_featured_category_object = get_category($avatar_featured_category);
$avatar_featured_category_color_class = avatar_get_cat_page_color($avatar_featured_category);

?>
<div class="component component-insight-home row <?php echo esc_attr($avatar_featured_category_color_class); ?>">
	<div class="col-md-12">
		<div>
			<div>
				<h2 class="bloc-title bloc-title--no-margin-top bloc-title--no-margin-bottom">
					<a class="bloc-title__link" href="<?php echo get_category_link($avatar_featured_category); ?>" title="<?php echo esc_attr($avatar_featured_category_object->cat_name); ?>">
						<?php echo wp_kses_post($avatar_featured_category_object->cat_name); ?>
					</a>
					<i class="bloc-title__caret fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
				</h2>
			</div>
			<?php
                $avatar_category_posts_args = [
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'cat' => $avatar_featured_category,
                    'order' => 'DESC',
                    'order_by' => 'post_date',
                    'posts_per_page' => $avatar_featured_category_nr,
                ];
$avatar_category_posts = new WP_Query($avatar_category_posts_args); ?>

			<?php if ($avatar_category_posts->have_posts() && $avatar_category_posts->post_count !== 0) { ?>
			<?php $i = 0; ?>

				<?php while ($avatar_category_posts->have_posts()) { ?>

					<?php
        $avatar_category_posts->the_post();
				    $curr_post_id = get_the_ID();
				    $i++;
				    $text_content_extra_class = ($i > 1) ? 'text-content--border-top' : '';
				    ?>
					<div>
						<div class="text-content <?php echo esc_attr($text_content_extra_class); ?>">
							<h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="text-content__excerpt"><?php echo get_the_excerpt($curr_post_id); ?></p>
							<ul class="pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_source($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
 		</div>
 	</div><!--end col-sub -->
</div>
<hr>