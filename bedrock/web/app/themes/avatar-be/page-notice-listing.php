<?php

/**
 * Template Name: Notice Listing
 */
get_header();
$thiscat = get_category(get_query_var('cat'));
$catid = $thiscat->cat_ID; //Current category ID
$current_cat_name = $thiscat->name; //Current category name
$current_cat_slug = $thiscat->slug;
$parent = 'people-watch'; //Current category parent
$page_id = (get_query_var('paged')) ? get_query_var('paged') : 1;

$avatar_article_site_origin = get_field('acf_category_site_origin', $thiscat);
$target_category = get_field('target_category');
$sponsored_category = get_field('sponsored_category');

$i = $j = 0;
if ($parent == 0) {
    $is_parent = true;
    $posts_per_page = -1;
    if ($page_id > 1) {
        $i = 4;
    }
} else {
    $is_parent = false;
    if ($page_id > 1) {
        $i = 4;
    }
    $posts_per_page = 4;
    $parent_object = get_category($parent);
    $parent_slug = $parent_object->slug;
}

// Exclude ID's
$avatar_exclude_ids = [];

// Arguments
$default_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $target_category->slug,
        ],
    ],
];
if ($sponsored_category) {
    $sponsored_args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $sponsored_category->slug,
            ],
        ],
    ];
} else {
    $sponsored_args = [
        'post_type' => 'post',
        'post__in' => [0], // force empty
    ];
}

$people_watch = new WP_Query($default_args);
$people_watch_sponsored = new WP_Query($sponsored_args);
$people_watch_sponsored_count = 0;

?>
<div class="wrap">
	<div id="primary" class="content-area<?php
                                            if (($parent_object->slug === 'advisor-to-client') or ($current_cat_slug === 'advisor-to-client')) {
                                                echo ' adv-cat';
                                            } elseif (($parent_object->slug === 'investments') or ($current_cat_slug === 'investments')) {
                                                echo ' cir-cat';
                                            }
?>">

		<main id="main">
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
					<?php
                    if (($parent_object->slug === 'advisor-to-client') or ($current_cat_slug === 'advisor-to-client')) { ?>
						<div class="adv-head">
							<?php
                            if (! $is_parent) {
                                echo '<a href="..">';
                            }
                        ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-atc-main.png" class="img-responsive" alt="Advisor to client">
							<?php
                        if (! $is_parent) {
                            echo '</a>';
                        }
                        ?>
						</div>
					<?php } elseif ($avatar_article_site_origin === 'CIR') { ?>
						<div id="js-sticky-banner" class="adv-head-cir">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Vertical.png" class="img-responsive" alt="CIR news">
						</div>
					<?php } ?>
					<!---->
					<h1 class="bloc-title bloc-title">
						<span class="bloc-title__text--color"><?php echo the_title(); ?></span>
					</h1>

					<div id="js-regular-listing-container" class="category-listing">
						<div class="people-watch-flex-grid">

							<?php if ($people_watch_sponsored->have_posts() && $people_watch_sponsored->post_count !== 0) { ?>
								<?php while ($people_watch_sponsored->have_posts()) {
								    $people_watch_sponsored->the_post();
								    $people_watch_sponsored_count++;
								    $curr_post_id = get_the_ID();
								    $avatar_exclude_ids[] = $curr_post_id;
								    $article_type = get_field('acf_article_type', $curr_post_id);
								    $subtitle = get_field('sub-title');
								    $logo = get_field('logo');
								    ?>



									<!-- <div class="col-sm-6 col-no-padding-right">
											<div id="post-<?php the_ID(); ?>" <?php post_class('text-content'); ?>>
												<?php avatar_display_sponsor_header_title($curr_post_id); ?>
												<div class="after-clear">
													<?php if (has_post_thumbnail()) { ?>
														<figure>
															<a href="<?php the_permalink(); ?>">
																<div class="top-image">
																	<?php the_post_thumbnail($size = 'medium_large', $attr = ['class' => 'img-responsive']); ?>
																</div>
															</a>
														</figure>
													<?php } ?>
													<div class="text-content no-padding-bottom">
														<h2 class="text-content__title"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 5); ?></a></h2>
														<p class="text-content__title"><?php echo wp_trim_words($subtitle, 10); ?></p>
														<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
													</div>
													<?php if ($logo) { ?>
														<div>
															<img height="40px" src="<?php echo $logo; ?>">
														</div>
													<?php } ?>
													<?php avatar_display_post_sponsor($curr_post_id, $single = false); ?>
                                                </div>
                                        	</div>
										</div> -->
									<div class="col-sm-6 col-no-padding-right">
										<div id="post-<?php the_ID(); ?>" <?php post_class('text-content'); ?>>
											<div class="after-clear">
												<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
													<figure class="text-content__figure-right list-img">
														<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'img-responsive']); ?></a>
													</figure>
												<?php } ?>
												<h2 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>">
													<a class="text-content__link" href="<?php the_permalink($curr_post_id); ?>"><?php echo wp_trim_words(get_the_title(), 5); ?></a>
												</h2>
												<p class="text-content__title"><?php echo wp_trim_words($subtitle, 10); ?></p>
												<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
												<ul class="pub-details">
													<?php avatar_display_post_author($curr_post_id, $single = false); ?>
													<?php avatar_display_post_source($curr_post_id, $single = false); ?>
													<?php avatar_display_post_date($curr_post_id, $single = false); ?>

												</ul>
												<?php if ($logo) { ?>
													<div>
														<img height="40px" src="<?php echo $logo; ?>">
													</div>
												<?php } ?>

												<?php avatar_display_post_sponsor($curr_post_id, $single = false); ?>
											</div>
										</div>
									</div>

							<?php }
								}  ?>




							<?php if ($people_watch->have_posts() && $people_watch->post_count !== 0) { ?>
								<?php while ($people_watch->have_posts()) {
								    $people_watch->the_post();
								    $curr_post_id = get_the_ID();
								    $avatar_exclude_ids[] = $curr_post_id;
								    $article_type = get_field('acf_article_type', $curr_post_id);
								    $subtitle = get_field('sub-title');
								    $logo = get_field('logo');
								    // }
								    ?>
									<div class="col-sm-6 split ">
										<div id="post-<?php the_ID(); ?>" <?php post_class('text-content'); ?>>
											<?php avatar_display_sponsor_header_title($curr_post_id); ?>
											<div class="after-clear">
												<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
													<figure class="text-content__figure-right list-img">
														<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'img-responsive']); ?></a>
													</figure>
												<?php } ?>
												<?php avatar_display_post_category($curr_post_id, $single = false); ?>
												<h2 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>">
													<a class="text-content__link" href="<?php the_permalink($curr_post_id); ?>"><?php echo wp_trim_words(get_the_title(), 5); ?></a>
												</h2>
												<p class="text-content__title"><?php echo wp_trim_words($subtitle, 10); ?></p>
												<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
												<ul class="pub-details">
													<?php avatar_display_post_author($curr_post_id, $single = false); ?>
													<?php avatar_display_post_source($curr_post_id, $single = false); ?>
													<?php avatar_display_post_date($curr_post_id, $single = false); ?>

												</ul>

												<?php avatar_display_post_sponsor($curr_post_id, $single = false); ?>
											</div>
										</div>
									</div>
							<?php }
								} ?>
							<?php wp_reset_postdata(); ?>


						</div> <?php // End
								    ?>
						<div class="pagination">
							<?php next_posts_link(); ?>
						</div>
					</div>
				</div>

				<aside class="col-md-4 primary">
					<?php
                    if ($is_parent) { //if this is the parent category page, insert these components in first aside bloc
                        ?>
						<?php //include Quick subscribe newsletters component
                            avatar_include_subscription_module();
                        ?>
						<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
							<?php
                            $arr_m32_vars = [
                                'kv' => [
                                    'pos' => [
                                        'btf',
                                        'but1',
                                        'right_bigbox',
                                        'top_right_bigbox',
                                    ],
                                ],
                                'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                                'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
                            ];
                        $arr_avt_vars = [
                            'class' => 'bigbox text-center',
                        ];

                        get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

                        ?>
						</div>

						<!-- <?php // Include Microsite Block
                            // avatar_include_template_conditionally( 'templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
                        ?> -->

						<?php //include tools and resources component
                        include locate_template('templates/tools/component-tools-and-ressources.php');
                        ?>
					<?php } else { //if this is NOT the parent (sub-category) insert these components in aside bloc
					    ?>
						<?php //include Quick subscribe newsletters component
					        avatar_include_subscription_module();
					    ?>
						<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
							<?php
					        $arr_m32_vars = [
					            'kv' => [
					                'pos' => [
					                    'btf',
					                    'but1',
					                    'right_bigbox',
					                    'top_right_bigbox',
					                ],
					            ],
					            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
					            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
					        ];
					    $arr_avt_vars = [
					        'class' => 'bigbox text-center',
					    ];

					    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

					    ?>
						</div>

						<?php // Include Microsite Block
					    // $avatar_microsite_template = $avatar_article_site_origin === 'CIR' ? 'templates/cir/microsite/component-microsite-cir-block.php' : 'templates/microsite/component-microsite-block.php';
					    // avatar_include_template_conditionally( $avatar_microsite_template, 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
					    ?>


						<?php //include tools and resources component
					    include locate_template('templates/tools/component-tools-and-ressources.php');
					    ?>
						<?php //include Cxense most popular/shared component
					    include locate_template('templates/general/component-cxense-most.php');
					    ?>
						<?php
					    $arr_m32_vars = [
					        'sticky' => true,
					        'staySticky' => true,
					        'kv' => [
					            'pos' => [
					                'btf',
					                'but1',
					                'right_bigbox_last',
					                'bottom_right_bigbox',
					            ],
					        ],
					        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
					        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
					    ];
					    $arr_avt_vars = [
					        'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
					    ];

					    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

					    ?>
					<?php } ?>
				</aside>
			</section>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer(); ?>