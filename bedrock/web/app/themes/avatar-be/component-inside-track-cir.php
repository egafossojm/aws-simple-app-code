<?php
/*
* Location : HomePage
* Inside Track Component
* Displays a list of the 4 (by default) most recent Columnist Authors that has written an Article
* Admin : Content options [Home Page] - Blogist
*/
$i = 0;
$avatar_columnist_cat_id = get_field('homepage_inside_track_category', 'option');
$avatar_columnist_nr = get_field('homepage_inside_track_posts_nr', 'option');

if (! ($avatar_columnist_cat_id and $avatar_columnist_nr)) {
    return;
}

$avatar_columnist_page_obj = get_field('acf_inside_track_breadcrumb_cir', 'option');
if (! is_object($avatar_columnist_page_obj)) {
    error_log('The page $avatar_columnist_page_obj is not added in theme option');

    return;
}
$avatar_columnist_page_color_class = avatar_get_cat_page_color($avatar_columnist_page_obj->ID);

$avatar_columnist_args = [
    'post_type' => 'writer',
    'post_status' => 'publish',
    'posts_per_page' => 20,
    'meta_key' => 'acf_author_published_date',
    'meta_query' => [
        'relation' => 'AND',
        'is_columnist' => [
            'key' => 'acf_author_is_columnist',
            'value' => 1,
        ],
    ],
    'tax_query' => [
        'relation' => 'AND',
        [
            'taxonomy' => 'post_column',
            'field' => 'slug',
            'terms' => 'Canadian Investment Review Experts',
            'compare' => 'LIKE',
        ],
    ],
    'orderby' => [
        'author_published_date' => 'DESC',
    ],
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
];
$avatar_columnists = new WP_Query($avatar_columnist_args);

if ($avatar_columnists->post_count == 0) {
    return;
}

?>
<?php if ($avatar_columnists->have_posts() && $avatar_columnists->post_count !== 0) { ?>
	<div class="component component-inside-track component-home <?php echo esc_attr($avatar_columnist_page_color_class); ?>">
		<?php if ($avatar_columnist_page_obj) { ?>
			<h2 class="bloc-title">
				<a class="bloc-title__link" href="<?php echo esc_url(get_page_link($avatar_columnist_page_obj->ID)); ?>"
					   title="<?php echo get_the_title($avatar_columnist_page_obj->ID); ?>">
					   <?php echo get_the_title($avatar_columnist_page_obj->ID); ?>
				</a>
				<i class=" bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
			</h2>
		<?php } ?>

		<div class="row equal-col component-inside-track__listing regular-listing">
			<?php // loop 4 columnist?>
			<?php while ($avatar_columnists->have_posts()) {
			    $avatar_columnists->the_post();

			    $curr_author_id = get_the_ID();
			    $columns = get_term(get_field('acf_author_column'), 'post_column'); ?>

				<?php if ($i < $avatar_columnist_nr) { ?>
					<div class="col-md-3 col-sm-3 col-xs-6 col-inside-track text-center">
						<?php if (has_post_thumbnail()) { ?>
							<div class="entity-figure">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail($size = 'small', $attr = ['class' => 'img-responsive entity-figure__img']); ?>
								</a>
							</div>
						<?php } ?>
						<h3 class="component-inside-track__auth-name">
							<a class="component-inside-track__auth-name-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php if (! is_wp_error($columns)) { ?>
							<span class="component-inside-track__column-name">
								 <?php echo wp_kses_post($columns->name); ?>
							</span>
						<?php } ?>
						<?php
			            // loop the articles
			            $articles_args = [
			                'post_type' => 'post',
			                'posts_per_page' => 1,
			                'meta_query' => [
			                    [
			                        'key' => 'acf_article_author',
			                        'value' => '"'.$curr_author_id.'"',
			                        'compare' => 'LIKE',
			                    ],
			                ],
			                'orderby' => 'date',
			            ];
				    $articles = new WP_Query($articles_args); ?>
						<?php if ($articles->have_posts()) { ?>

							<?php while ($articles->have_posts()) {
							    $articles->the_post(); ?>
								<div class="text-content">
									<h4 class="text-content__title">
										<a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h4>
								</div>
							<?php } wp_reset_postdata(); // end loop for articles?>
						<?php } ?>
					</div>
				<?php } $i++; ?>
			<?php } wp_reset_postdata(); // end loop 4 columnist?>
		</div>
	</div>
<?php } ?>