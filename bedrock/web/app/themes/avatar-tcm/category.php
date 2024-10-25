<?php get_header();
/*
* This file is for the Main category and sub categories pages
* i.e News | News -> Industry News | Etc...
*/
$thiscat = get_category(get_query_var('cat'));
$catid = $thiscat->cat_ID; //Current category ID
$current_cat_name = $thiscat->name; //Current category name
$current_cat_slug = $thiscat->slug;
$parent = $thiscat->category_parent; //Current category parent
$page_id = (get_query_var('paged')) ? get_query_var('paged') : 1;

$avatar_article_site_origin = get_field('acf_category_site_origin', $thiscat);

$i = $j = 0;
if ($parent == 0) {
    $is_parent = true;
    $posts_per_page = 13;
    if ($page_id > 1) {
        $i = 4;
    }
} else {
    $is_parent = false;
    if ($page_id > 1) {
        $i = 4;
    }
    $posts_per_page = 25;
    $parent_object = get_category($parent);
    $parent_slug = $parent_object->slug;
}

// Exclude ID's
$avatar_exclude_ids = [];

// Arguments
$default_args = [
    'post_type' => 'post',
    'cat' => $catid,
    'order' => 'DESC',
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'order_by' => 'post_date',
    'paged' => $page_id,
    'posts_per_page' => $posts_per_page,
];

$articles = new WP_Query($default_args);

?>
<div class="wrap">
	<div id="primary" class="content-area<?php
                                            if (! empty($parent_object) && ($parent_object->slug === 'advisor-to-client') or ($current_cat_slug === 'advisor-to-client')) {
                                                echo ' adv-cat';
                                            } elseif (! empty($parent_object) && ($parent_object->slug === 'investments') or ($current_cat_slug === 'investments')) {
                                                echo ' cir-cat';
                                            }
?>">

		<main id="main">
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
					<!--if advisor to client section or subsection, insert little head image-->
					<?php
                    if (! empty($parent_object) && ($parent_object->slug === 'advisor-to-client') or ($current_cat_slug === 'advisor-to-client')) { ?>
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
					<?php } elseif (get_current_view_context() == 'cir') { ?>
						<div id="js-sticky-banner" class="adv-head-cir">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR news">
						</div>
					<?php } ?>
					<h1 class="bloc-title bloc-title">
						<span class="bloc-title__text--color">
							<?php
                        if ($is_parent) {
                            _e('Top Stories', 'avatar-tcm');
                        } else {
                            _e('Latest news', 'avatar-tcm');
                        } ?>
						</span>
						<span><?php _e(' in ', 'avatar-tcm');
echo wp_kses_post($current_cat_name); ?></span>
					</h1>
					<?php if (($current_cat_slug === 'podcasts') || ($current_cat_slug === 'podcasts-directory')) {  /* Affichage "Indepth" */
					    $i = 0;
					    $total_posts = $articles->post_count;
					    ?>
						<div>
							<?php if ($articles->have_posts() && $articles->post_count !== 0) { ?>
								<?php while ($articles->have_posts()) {
								    $articles->the_post();
								    $curr_post_id = get_the_ID();
								    $avatar_exclude_ids[] = $curr_post_id;
								    $article_type = get_field('acf_article_type', $curr_post_id);
								    if ($article_type == 'brand' || $article_type == 'feature') {
								        $is_sponsor = true;
								    } else {
								        $is_sponsor = false;
								    }

								    ?>
									<?php if ($i % 2 == 0) { ?>
										<div class="row equal-col">
										<?php } ?>
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
													<h2 class="text-content__title text-content__title--big"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
			<?php } else { /* Affichage classique */ ?>
				<div id="js-regular-listing-container" class="category-listing">

					<?php if ($articles->have_posts() && $articles->post_count !== 0) { ?>
						<?php while ($articles->have_posts()) {
						    $articles->the_post();
						    $i++;
						    $curr_post_id = get_the_ID();
						    $avatar_exclude_ids[] = $curr_post_id;
						    $article_type = get_field('acf_article_type', $curr_post_id);
						    if ($article_type == 'brand' || $article_type == 'feature') {
						        $is_sponsor = true;
						    } else {
						        $is_sponsor = false;
						    }

						    ?>
							<?php if ($page_id == 1 && $i == 1) {
							    //1 first article
							    ?>
								<div class="category-listing-123">
									<div class="col-sm-6 col-no-padding-right">
										<div id="post-<?php the_ID(); ?>" <?php post_class('text-content first-item'); ?>>
											<?php avatar_display_sponsor_header_title($curr_post_id); ?>
											<div class="after-clear">
												<figure>
													<a href="<?php the_permalink(); ?>">
														<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
															<div class="top-image">
																<?php the_post_thumbnail($size = 'medium_large', $attr = ['class' => 'img-responsive']); ?>
															</div>
														<?php } else { ?>
															<?php
							                                    $img_id = $image_url = false;
														    $img_id_thiscat = get_field('acf_category_image', $thiscat);
														    if ($img_id_thiscat) {
														        $img_id = $img_id_thiscat;
														    } elseif ($parent) {
														        $img_id_parrentcat = get_field('acf_category_image', 'category_'.$parent);
														        $img_id = $img_id_parrentcat;
														    }

														    if ($img_id) {
														        $image_url = wp_get_attachment_image_url($img_id, $size = 'medium_large');
														    }
														    ?>
															<?php if ($image_url) { ?>
																<img class="img-responsive" src="<?php echo esc_url($image_url) ?>" alt="<?php echo wp_kses_post($current_cat_name); ?>">
															<?php } ?>
														<?php } ?>
													</a>
												</figure>
												<div class="text-content no-padding-bottom">
													<h2 class="text-content__title"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
												</div>
												<?php avatar_display_post_sponsor($curr_post_id, $single = false); ?>
											</div>
										</div>
									</div>

								<?php }  ?>
								<?php if ($page_id == 1 && $i > 1 && $i < 4) { // 2 - 3 articles
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
												<?php if ($is_parent && ! $is_sponsor) {
												    avatar_display_post_category($curr_post_id, $single = false);
												} ?>
												<h2 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>">
													<a class="text-content__link" href="<?php the_permalink($curr_post_id); ?>"><?php the_title(); ?></a>
												</h2>
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
								<?php } // end 2 - 3 articles
						    ?>

								<?php if ($page_id == 1 && $i === 3) {
								    $j = 0; // close top-articles123 div
								    ?>
								</div>
							<?php } ?>
							<?php if ($i > 3) {
							    $conditional_col = ($page_id % 2) ? (($i % 2 == 0) ? 'col-no-padding-right' : '') : (($i % 2 == 1) ? 'col-no-padding-right' : ''); ?>
								<div class="col-sm-6 <?php echo esc_attr($conditional_col); ?> js-regular-listing">
									<div id="post-<?php the_ID(); ?>" <?php post_class('text-content text-content--border-top '); ?>>
										<?php avatar_display_sponsor_header_title($curr_post_id); ?>
										<div class="after-clear">
											<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
												<figure class="text-content__figure-right list-img">
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'img-responsive']); ?></a>
												</figure>
											<?php } ?>
											<?php if ($is_parent && ! $is_sponsor) {
											    avatar_display_post_category($curr_post_id, $single = false);
											} ?>
											<h2 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>">
												<a class="text-content__link" href="<?php the_permalink(); ?>">
													<?php the_title(); ?>
												</a>
											</h2>
											<p class="text-content__excerpt">
												<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
											</p>
											<ul class="pub-details">
												<?php avatar_display_post_author($curr_post_id, $single = false); ?>
												<?php avatar_display_post_source($curr_post_id, $single = false); ?>
												<?php avatar_display_post_date($curr_post_id, $single = false); ?>
											</ul>
											<?php avatar_display_post_sponsor($curr_post_id, $single = false); ?>
										</div>
									</div>
								</div>
								<?php $j++; // End regular-listing
							    ?>

							<?php } ?>

						<?php } ?>
						<?php wp_reset_postdata(); ?>
					<?php } else { ?>
						<p>
						<div class="after-clear"><?php _e('There is currently no post for this Category', 'avatar-tcm'); ?></p>
						<?php } ?>

						<?php // Add pagination for Infinite Ajax Scroll (jQuery plugin)
                        ?>

						</div> <?php // End
							    ?>

						<div class="pagination">
							<?php next_posts_link(); ?>
						</div>
				</div>
			<?php }  /* Fin Affichage classique */ ?>
			<?php if ($articles->post_count <= 2) { //condition if articles has 2 or less articles close the div
			    ?>
	</div><?php } ?>
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
                        'atf',
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


		<?php
        // Include Microsite Block
        avatar_include_template_conditionally('templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
        ?>

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
	                    'atf',
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
	    $avatar_microsite_template = $avatar_article_site_origin === 'CIR' ? 'templates/cir/microsite/component-microsite-cir-block.php' : 'templates/microsite/component-microsite-block.php';
	    avatar_include_template_conditionally($avatar_microsite_template, 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
	    ?>


		<?php //include tools and resources component
	    include locate_template('templates/tools/component-tools-and-ressources.php');
	    ?>
		<?php //include Cxense most popular/shared component
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
	                    'but1',
	                    'right_bigbox_last',
	                    'bottom_right_bigbox',
	                ],
	            ],
	            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
	            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
	        ],
	        $arr_avt_vars = [
	            'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
	        ]
	    );
	    ?>
	<?php } ?>
</aside>
</section>

<?php
if ($is_parent) { //if this is the parent category page, split page and insert leaderboard and second aside
    ?>
	<div class="row">
		<div class="col-md-12 leaderboard-fullwrap top-border">
			<?php
                at_get_the_m32banner(
                    $arr_m32_vars = [
                        'kv' => [
                            'pos' => [
                                'btf',
                                'but2',
                                'middle_leaderboard',
                                'mid_leaderboard',
                            ],
                        ],
                        'sizes' => '[ [728,90], [970,250], [980,200] ]',
                        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90], [970,250], [980,200]]] ]',
                    ],
                    $arr_avt_vars = [
                        'class' => 'leaderboard text-center',
                    ]
                );
    ?>
		</div>
	</div>
	<section class="row equal-col-md">
		<div class="col-md-8 left-content">
			<?php
    //load subcategory template only for main category
    include locate_template('templates/subcategory-posts.php');
    ?>
		</div>
		<aside class="primary col-md-4">
			<?php //include Cxense most popular/shared component
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
            'class' => 'bigbox col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
        ]
    );
    ?>
		</aside>
	</section>
<?php } ?>
</main><!-- #main -->
</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer(); ?>
