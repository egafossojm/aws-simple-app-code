<?php
/*
* Location : HomePage
* Building Your Business Component
* Displays a list of posts from the category Building Your Business
* Admin : Content options [Home Page] - Featured category 1
*/
$avatar_featured_category = get_field('homepage_featured_category_1', 'option');
$avatar_featured_category_nr = get_field('homepage_featured_category_1_nr', 'option');
if (! ($avatar_featured_category && $avatar_featured_category_nr)) {
    error_log('$avatar_featured_category or $avatar_featured_category_nr return false');

    return;
}
$avatar_featured_category_object = get_category($avatar_featured_category);
$avatar_featured_category_color_class = avatar_get_cat_page_color($avatar_featured_category);

?>
<div class="component component-building-your-buisness-home row <?php echo esc_attr($avatar_featured_category_color_class); ?>">
	<div class="col-md-12">
		<div>
			<div>
				<h2 class="bloc-title bloc-title--no-margin-bottom">
					<a class="bloc-title__link" href="<?php echo get_category_link($avatar_featured_category); ?>" title="<?php echo esc_attr($avatar_featured_category_object->cat_name); ?>">
						<?php echo wp_kses_post($avatar_featured_category_object->cat_name); ?>
					</a>
					<i class="bloc-title__caret fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
				</h2>
			</div>
			<?php $avatar_byb_args = ['
				post_type' => 'post',
			    'post_status' => 'publish',
			    'cat' => $avatar_featured_category,
			    'order' => 'DESC',
			    'order_by' => 'post_date',
			    'posts_per_page' => $avatar_featured_category_nr,
			];

$wp_query_byb_articles = new WP_Query($avatar_byb_args); ?>
			<div class="row row-text-content-listing">
				<?php
    if ($wp_query_byb_articles->have_posts()) {
        $i = 0;
        while ($wp_query_byb_articles->have_posts()) {
            $wp_query_byb_articles->the_post();
            $curr_post_id = get_the_ID();
            $i++;
            $text_content_extra_class = has_post_thumbnail() ? 'no-padding-top' : '';
            $text_content_extra_class_border = ($i > 2) ? 'text-content--border-top' : '';
            ?>
				<?php if ($i == 1) { ?>
				<div class="col-sm-6">
					<div>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if (has_post_thumbnail()) { ?>
							<figure class="text-content">
								<a href="<?php the_permalink(); ?>">
									<div>
										<?php the_post_thumbnail('medium_large', ['class' => 'img-responsive text-content__image-full']); ?>
									</div>
							</figure>
							<?php } ?>
							<div class="text-content <?php echo esc_attr($text_content_extra_class); ?>">
								<h3 class="text-content__title text-content__title--big"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="text-content__excerpt">
									<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
								</p>
							</div>
						</div>
					</div>
					<!-- end 1st article -->
				</div>
				<?php } ?>
				<?php if ($i >= 2) { ?>
				<?php if ($i == 2) { ?>
				<div class="col-sm-6">
					<?php } ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="text-content <?php echo esc_attr($text_content_extra_class_border); ?>">
							<h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="text-content__excerpt">
								<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
							</p>
							<ul class="pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_source($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
						</div>
					</div>
					<!-- end artcle <?php the_ID(); ?> -->
					<?php if ($i == 4) { ?>
				</div>
				<!-- end artcile container -->
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</div>
			<!-- end  -->
		</div>
		<!-- end brand <?php the_ID(); ?> -->
	</div>
</div>