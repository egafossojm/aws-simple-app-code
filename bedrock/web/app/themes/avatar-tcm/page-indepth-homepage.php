<?php
/**
 * Template Name: In Depth : IndexPage
 *
 * This is the template that displays In Depth section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php get_header();
/* -------------------------------------------------------------
 *  Get Feature ID's from Option page
 * ============================================================*/
$avatar_featured_indepth_options = get_field('featured_indepth_features', 'option');
$avatar_indepth_categories_id = get_field('acf_in_depth_categories', 'option');

// Test if array exist and create new array with ID only
if (is_array($avatar_featured_indepth_options)) {
    $avatar_featured_indepth_array = [];
    foreach ($avatar_featured_indepth_options as $key => $value) {
        $avatar_featured_indepth_array[] = $value['featured_indepth_feature'];
    }
} else {
    new WP_Error('empty', __('In Depth Options are empty', 'avatar-tcm'));
}

// WP_Query arguments
$avatar_featured_indepth_args = [
    'post_type' => 'feature',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'post__in' => $avatar_featured_indepth_array,
    'orderby' => 'post__in',
];

// The Query
$avatar_featured_indepth_cpt_query = new WP_Query($avatar_featured_indepth_args);
$i = 0;
?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main">
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
					<h1 class="bloc-title bloc-title--no-margin-bottom">
						<span class="bloc-title__text--color"><?php _e('Featured', 'avatar-tcm'); ?> </span>
						<span><?php _e('In Depth', 'avatar-tcm'); ?></span>
					</h1>
					<div>
						<?php
                            if ($avatar_featured_indepth_cpt_query->have_posts()) {
                                $total_posts = $avatar_featured_indepth_cpt_query->post_count;
                                while ($avatar_featured_indepth_cpt_query->have_posts()) {
                                    $avatar_featured_indepth_cpt_query->the_post(); ?>
									<?php if ($i % 2 == 0) { ?>
									<div class="row equal-col">
									<?php }?>
										<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-6 col-sm-6'); ?>>
											<div>
												<div class="text-content <?php if ($i > 1) { ?> text-content--border-top <?php } ?>">
													<?php if (has_post_thumbnail()) { ?>
														<figure>
															<a href="<?php the_permalink(); ?>">
																<div class="article-thumbnail">
																	<?php the_post_thumbnail($size = 'large'); ?>
																</div>
															</a>
														</figure>
													<?php } ?>
													<h2 class="text-content__title text-content__title--big"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<p class="text-content__excerpt">
														<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
													</p>

												</div>
											</div>
										</div>

									<?php if (($i++ % 2 == 1) or ($total_posts == $i)) { ?>
									</div>
									<?php }
									}
                            } else {
                                _e('No Feature found.', 'avatar-tcm');
                            }
?>
					</div>
						</div>
						<aside class="primary col-md-4">
		                	<?php //include Quick subscribe newsletters component
     avatar_include_subscription_module();
?>
							<?php include locate_template('templates/category/component-partner-report.php'); ?>
							<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
							<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'kv' => [
                'pos' => [
                    'atf',
                    'but1',
                    'right_bigbox',
                    'top_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center',
        ]
    );
?>
							</div>
		                    <?php //include tools and resources component
    include locate_template('templates/tools/component-tools-and-ressources.php');
?>
						</aside>
					</section>
					<div class="row">
						<div class="col-md-12 leaderboard-fullwrap top-border">
							<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'kv' => [
                'pos' => [
                    'btf',
                    'but1',
                    'middle_leaderboard',
                    'mid_leaderboard',
                ],
            ],
            'sizes' => '[ [728,90], [970,250], [980,200] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90], [970,250], [980,200]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'leaderboard',
        ]
    );
?>
						</div>
					</div>
					<section class="row equal-col-md">
						<div class="col-md-8 left-content">
<!--cut here-->
				<?php
                    /* -------------------------------------------------------------
                     * Feature for Special Reports
                     * ============================================================*/

                    foreach ($avatar_indepth_categories_id as $key => $value) {
                        $i = 0;
                        if ($value['acf_in_depth_category']) {

                            $avatar_depth_subcat_args = [
                                'post_type' => 'feature',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'post__not_in' => $avatar_featured_indepth_array,

                                'meta_query' => [

                                    'subcat' => [
                                        'key' => 'acf_feature_parent_sub_category',
                                        'value' => $value['acf_in_depth_category'],
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

                            // The Query
                            $avatar_depth_subcat_cpt_query = new WP_Query($avatar_depth_subcat_args);
                            ?>
							<div class="cat-title">
								<h2 class="bloc-title bloc-title--no-margin-bottom">
									<a class="bloc-title__link" href="<?php echo get_permalink($value['acf_in_depth_category']); ?>">
										<span class="bloc-title__text--color"><?php _e('Latest', 'avatar-tcm'); ?></span>
										<span><?php echo get_the_title($value['acf_in_depth_category']); ?></span>
									</a>
									<i class="bloc-title__caret fa fa-caret-right" aria-hidden="true"></i>
								</h2>
							</div>
							<div>
								<?php
                                   if ($avatar_depth_subcat_cpt_query->have_posts()) {
                                       $total_posts = count($avatar_depth_subcat_cpt_query->posts);

                                       while ($avatar_depth_subcat_cpt_query->have_posts()) {
                                           $avatar_featured_indepth_array[] = get_the_ID();
                                           $avatar_depth_subcat_cpt_query->the_post(); ?>
											<?php if ($i % 2 == 0) { ?>
												<div class="row equal-col ">
											<?php }?>

												<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-6 col-sm-6'); ?>>
													<div>
														<div class="text-content <?php if ($i > 1) { ?> text-content--border-top <?php } ?>">
															<?php if (has_post_thumbnail()) { ?>
																<figure>
																	<a href="<?php the_permalink(); ?>">
																		<div class="article-thumbnail">
																			<?php the_post_thumbnail($size = 'large'); ?>
																		</div>
																	</a>
																</figure>
															<?php } ?>
															<h3 class="text-content__title text-content__title--big"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
															<p class="text-content__excerpt">
																<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
															</p>
															<?php $avatar_feature_date = get_field('acf_feature_published_date'); ?>
															<?php if ($avatar_feature_date) { ?>
																<ul class="pub-details">
																	<li class="pub-details__item"><span class="published">
																	<?php echo date_i18n(get_option('date_format'), strtotime(get_date_from_gmt(date('Y-m-d H:i:s', $avatar_feature_date), 'Y-m-d H:i:s'))); ?>					
																	</span></li>
																</ul>
															<?php } ?>
														</div>
													</div>
												</div>

											<?php if (($i++ % 2 == 1) or ($total_posts == $i)) { ?>
												</div>
											<?php }
											}
                                   } else {
                                       _e('No Feature found.', 'avatar-tcm');
                                   }
                            ?>
							</div>

						<?php }

                        }?>

				</div>
				<aside class="primary col-md-4">
					<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
					<?php
                            at_get_the_m32banner(
                                $arr_m32_vars = [
                                    'kv' => [
                                        'pos' => [
                                            'btf',
                                            'but2',
                                            'right_bigbox',
                                        ],
                                    ],
                                    'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                                    'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
                                ],
                                $arr_avt_vars = [
                                    'class' => 'bigbox text-center',
                                ]
                            );
?>
					</div>
					<?php
    //include Cxense most popular/shared component
    include locate_template('templates/general/component-cxense-most.php');
?>
					<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'sticky' => true,
            'staySticky' => true,
            'kv' => [
                'pos' => [
                    'btf',
                    'but2',
                    'right_bigbox_last',
                    'bottom_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
        ]
    );
?>
				</aside>
			</section>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer(); ?>