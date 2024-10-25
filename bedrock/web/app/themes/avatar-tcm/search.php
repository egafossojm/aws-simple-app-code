<?php

/**
 * The template for displaying search results pages.
 */
get_header();
global $wp_query;
?>
<section class="single-cpt">
	<?php if (have_posts()) { ?>
		<header>
			<div class="entity-header entity-header--gray entity-row row">
				<div>
					<div>
						<div class="entity-header__landing-box entity-header__landing-box--search col-md-8 col-md-offset-1">
							<h1 class="entity-header__name entity-header__name--block entity-header__name--small entity-header__name--no-capitalize entity-header__name--no-border-bottom">
								<div class="search-box-result">
									<span class="search-box-result__title">
										<?php _e('Search Results for:', 'avatar-tcm'); ?>
									</span>
									<form class="search-box-result__form form-inline">
										<input type="search" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php the_search_query(); ?>" class="search-box-result__input form-control form-control--small-width form-control--sticky no-border-radius" />
										<input type="hidden" name="post_type" value="post">
										<button type="submit" class="search-box-result__button btn btn-lg user-form__btn-submit no-border-radius component-quick-subscribe-newsletters__button" title="<?php esc_attr_e('Search', 'avatar-tcm'); ?>"><?php esc_attr_e('New search', 'avatar-tcm'); ?></button>
									</form>
								</div>
							</h1>
							<div class="text-content text-content__excerpt text-content__excerpt--text-lightest no-padding-top-xs">
								<span>
									<?php printf(_n('%s result found', '%s results found', $wp_query->found_posts, 'avatar-tcm'), $wp_query->found_posts); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="entity-content row equal-col-md">
			<section class="col-lg-8 col-md-7 col-no-padding-left-xs">
				<div class="row row--no-margin">
					<div class=" col-md-10 col-md-offset-2-calc-15">
						<div class="row">
							<div class="entity-box-listing col-xs-12">
								<div id="js-regular-listing-container">

									<?php
                                    $keys = explode(' ', $s);
	    array_multisort(array_map('strlen', $keys), SORT_DESC, $keys);
	    $keys_to_replace = '/('.implode('|', $keys).')/iu';
	    //error_log($keys_to_replace);
	    while (have_posts()) {
	        the_post();
	        //Hightlight Search Terms in Results
	        $title = get_the_title();
	        //$title = preg_replace($keys_to_replace, '<span class="search-highlight">\0</span>', $title);
	        $excerpt = get_the_excerpt();
	        //$excerpt = preg_replace($keys_to_replace, '<span class="search-highlight">\0</span>', $excerpt);
	        $post_id = get_the_ID();
	        $article_type = get_field('acf_article_type', $post_id);
	        $acf_article_sponsor = get_field('acf_article_sponsor', $post_id);
	        ?>
										<div class="js-regular-listing <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
										    echo 'sponsor-bg';
										} ?>">
											<div class="text-content text-content--border-top">
												<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
													<figure class="text-content__figure-right text-content__figure-right--search-results list-img">
														<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'img-responsive']); ?></a>
													</figure>
												<?php } ?>
												<h2 class="text-content__title text-content__title--big icons title-article-author <?php echo avatar_article_get_icon($post_id); ?>">
													<a class="text-content__link" href="<?php the_permalink(); ?>">
														<?php echo $title; // Data is escaped
	        ?>
													</a>
												</h2>
												<p class="text-content__excerpt">
													<?php echo $excerpt; // Data is escaped
	        ?>
												</p>
												<ul class="pub-details pub-details--search-results">
													<?php
	        avatar_display_post_author($post_id, $single = false);
	        avatar_display_post_source($post_id, $single = false);
	        avatar_display_post_date($post_id, $single = false);
	        ?>
												</ul>
												<?php
	                                            if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
	                                                avatar_display_post_sponsor($post_id, false);
	                                            }
	        ?>
											</div>
										</div>
									<?php } ?>
									<?php //the_posts_navigation();
	                                ?>
								</div>
							</div>
							<div class="pagination">
								<?php next_posts_link(); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } else { ?>
			<header>
				<div class="entity-header entity-header--gray entity-row row">
					<div>
						<div>
							<div class="entity-header__landing-box entity-header__landing-box--search col-md-7 col-md-offset-1">
								<h1 class="entity-header__name entity-header__name--block entity-header__name--small entity-header__name--no-capitalize entity-header__name--no-border-bottom">
									<div class="search-box-result">
										<span class="search-page-title"><?php echo esc_html(_e('Search Results for:', 'avatar-tcm')); ?></span>
										<form class="search-box-result__form">
											<input type="search" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php the_search_query(); ?>" class="search-box-result__input form-control form-control--small-width form-control--sticky no-border-radius" />
											<button type="submit" class="search-box-result__button btn btn-lg user-form__btn-submit no-border-radius component-quick-subscribe-newsletters__button" title="<?php esc_attr_e('Search', 'avatar-tcm'); ?>"><?php esc_attr_e('New search', 'avatar-tcm'); ?></button>
										</form>
									</div>
								</h1>
								<div class="text-content text-content__excerpt text-content__excerpt--text-lightest no-padding-top-xs">
									<span>
										<?php printf(_n('%s result found', '%s results found', $wp_query->found_posts, 'avatar-tcm'), $wp_query->found_posts); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

			</header>
			<div class="entity-content row equal-col-md">
				<section class="col-lg-8 col-md-7"></section>
			<?php } ?>
			<aside class="col-lg-4 col-md-5 primary">
				<?php //include Quick subscribe newsletters component
	            avatar_include_subscription_module();
?>
				<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
					<?php
    at_get_the_m32banner(
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
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center',
        ]
    );
?>
				</div>
				<?php //include Cxense most popular/shared component
                include locate_template('templates/general/component-cxense-most.php'); ?>

				<?php //include tools and resources component
                include locate_template('templates/tools/component-tools-and-ressources.php');
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
			</div>
		</div>
</section>
<?php get_footer(); ?>