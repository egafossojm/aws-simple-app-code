<?php
/*
* Location : Feature single
* Latest In Depth Component
* Displays a list of most recent feature form the current sub category of the Feature
*/
$current_feature_id_arr[] = $post_id; //from single
$avatar_depth_subcat_id = get_post_meta($post_id, 'acf_feature_parent_sub_category', true);

if ($avatar_depth_subcat_id > 0) {
    // WP_Query arguments

    $avatar_depth_subcat_args = [
        'post_type' => 'feature',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'post__not_in' => $current_feature_id_arr,

        'meta_query' => [

            'subcat' => [
                'key' => 'acf_feature_parent_sub_category',
                'value' => $avatar_depth_subcat_id,
                'compare' => '=',
            ],
            'feature_date' => [
                'key' => 'acf_feature_published_date',
                'type' => 'NUMERIC',
            ],
        ],
        'orderby' => [
            'feature_date' => 'DESC',
        ],
    ];

    // The Term Query
    $avatar_depth_subcat_post_query = new WP_Query($avatar_depth_subcat_args);
    $i = 0;
    ?>


		<div class="cat-title cat-title-in-depth ">
			<h2 class="bloc-title bloc-title--no-margin-bottom">
				<a class="bloc-title__link" href="<?php echo get_permalink($avatar_depth_subcat_id); ?>">
					<?php _e('Latest', 'avatar-tcm'); ?>
					<?php echo get_the_title($avatar_depth_subcat_id); ?>
				</a>
				<i class="bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
			</h2>
	    </div>
		<div class="rows-multiple" >
			<?php

           if ($avatar_depth_subcat_post_query->have_posts()) {

               $total_posts = count($avatar_depth_subcat_post_query->posts); ?>
					<?php while ($avatar_depth_subcat_post_query->have_posts()) {
					    $avatar_depth_subcat_post_query->the_post(); ?>
							<?php if ($i % 2 == 0) { ?>
								<div class="row equal-col text-content">
									<?php }?>
									<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-6 col-sm-6 '); ?>>
										<div>
											<div>
											<?php if (has_post_thumbnail()) { ?>
												<figure class="text-content__figure">
													<a href="<?php the_permalink(); ?>">
														<div class="article-thumbnail">
															<?php the_post_thumbnail($size = 'thumbnail'); ?>
														</div>
													</a>
												</figure>
											<?php } ?>
												<h3 class="text-content__title text-content__title--big">
													<a class="text-content__link" href="<?php the_permalink(); ?>">
														<?php the_title(); ?>
													</a>
												</h3>
												<p class="text-content__excerpt">
													<?php echo wp_trim_words(wp_kses_post(get_the_excerpt()), 25); ?>
												</p>
											</div>
										</div>
									</div>
							<?php if (($i++ % 2 == 1) or ($total_posts == $i)) { ?>
								</div>
							<?php }?>
					<?php } ?>
				<?php } else { ?>
					<?php _e('No Latest Feature found.', 'avatar-tcm'); ?>
				<?php } ?>


		</div>
<?php } ?>