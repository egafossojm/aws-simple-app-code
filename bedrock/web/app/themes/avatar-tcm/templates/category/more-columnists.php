<?php
/*
* Location : Writer single
* More columnists Component
* Displays a list of more columnists
*/
$avatar_current_columnist = $post_id;
//order inside track
$avatar_columnist_args = [
    'post_type' => 'writer',
    'post_status' => 'publish',
    'posts_per_page' => 20,
    'orderby' => 'ID',
    'meta_query' => [
        'relation' => 'AND',
        'is_columnist' => [
            'key' => 'acf_author_is_columnist',
            'value' => 1,
        ],
        'author_published_date' => [
            'key' => 'acf_author_published_date',
        ],
    ],
    'orderby' => [
        'author_published_date' => 'DESC',
    ],
];

$avatar_columnists = new WP_Query($avatar_columnist_args);

// For colors

$avatar_columnist_page_obj = get_field('acf_inside_track_breadcrumb', 'option');
$avatar_columnist_page_color_class = avatar_get_cat_page_color($avatar_columnist_page_obj->ID);
?>

<section class="columnist-listing col-md-8 <?php echo esc_attr($avatar_columnist_page_color_class); ?>">
	<div class="cat-title cat-title-inside-track col-md-12">
		<h3 class="bloc-title bloc-title--no-margin-bottom">
			<span><?php _e('More columnists', 'avatar-tcm'); ?> </span>
		</h3>
	</div>
	<div>
		<?php
           if ($avatar_columnists->have_posts() && $avatar_columnists->post_count !== 0) {
               $i = 0;
               while ($avatar_columnists->have_posts()) {
                   $avatar_columnists->the_post();
                   $curr_author_id = get_the_ID();
                   $conditional_col = ($i % 2 == 0) ? '' : 'col-no-padding-right';

                   if ($avatar_current_columnist != $curr_author_id) {
                       $columns = get_term(get_field('acf_author_column'), 'post_column');
                       ?>
						<div class="col-md-6 <?php echo esc_attr($conditional_col); ?>">
							<div class="columnist-listing__head">
								<div class="entity-figure ">
									<?php if (has_post_thumbnail()) { ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail($size = 'small', $attr = ['class' => 'img-responsive entity-figure__img']); ?>
										</a>
									<?php }?>
								</div>

								<div class="entity-title">
									<span class="entity-title__columnist-tag entity-title__columnist-tag--black">
										<?php
                                           if (is_wp_error($columns)) {
                                               echo wp_kses_post($columns->get_error_message());
                                           } else {
                                               echo wp_kses_post($columns->name);
                                           }
                       ?>
									</span>
									<h2 class="entity-title__name">
										<a class="entity-title__link entity-title__link--black" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
								</div>
							 	<span class="hidden-xs hidden-md">
							 		<a href="<?php the_permalink(); ?>" class="entity-title__link-caret">
							 			<i class="entity-title__caret fa fa-caret-right" aria-hidden="true"></i>
					 				</a>
					 			</span>
							</div>
							<?php

                                $articles_args = [
                                    'post_type' => 'post',
                                    'posts_per_page' => 4,
                                    'meta_query' => [
                                        [
                                            'key' => 'acf_article_author',
                                            'value' => '"'.$curr_author_id.'"',
                                            'compare' => 'LIKE',
                                        ],
                                    ],
                                    'orderby' => 'date',
                                ];
                       $articles = new WP_Query($articles_args);
                       if ($articles->have_posts() && $articles->post_count !== 0) {
                           while ($articles->have_posts()) {
                               $articles->the_post();
                               $curr_post_id = get_the_ID();
                               ?>
									 <div>
										<div class="text-content no-padding-bottom">
											<h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
											<ul class="pub-details">
												<?php avatar_display_post_source($curr_post_id, $single = false); ?>
												<?php avatar_display_post_date($curr_post_id, $single = false); ?>
											</ul>
										</div>
									</div>
									<?php } wp_reset_postdata(); ?>
								<?php }  ?>
						</div>
					<?php } ?>
				<?php $i++;
               } wp_reset_postdata(); ?>
			<?php }?>
	</div>
</section>