<?php
/**
 * Template Name: Audio-podcast SubPage
 *
 * This is the template that displays podcast audio subpages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php

$thiscat = get_category(get_query_var('cat'));
$catid = $thiscat->cat_ID; //Current category ID
$current_cat_name = $thiscat->name; //Current category name
$avatar_podcast_cat_id = $catid;
$idAdvisorToGo = get_cat_ID('Advisor To Go');
$aside_sponsor_and_region = ($idAdvisorToGo == $thiscat->category_parent);

if ($aside_sponsor_and_region) {
    $sponsorthiscat = get_category($idAdvisorToGo);
    $sponsor_info = avatar_get_sponsor_info_categ($sponsorthiscat);
} else {
    $sponsor_info = avatar_get_sponsor_info_categ($thiscat);
}

$curr_page_id = $catid;
$avatar_exclude_podcast_ids = avatar_get_featured_video_articles_id();
//$avatar_video_cat_id = avatar_get_cat_by_page( $curr_page_id );

// Arguments
$avatar_first_podcast_subcat_arrg = [
    'post_type' => 'post',
    'cat' => $avatar_podcast_cat_id,
    'post__not_in' => $avatar_exclude_podcast_ids,
    'order' => 'DESC',
    'order_by' => 'post_date',
    'posts_per_page' => 1,
];

$avatar_first_podcast_subcat_query = new WP_Query($avatar_first_podcast_subcat_arrg);

?>
<?php get_header(); ?>


<div class="wrap">
	<div id="primary" class="content-area no-sponsor-bg">
		<main id="main">
			<!--podcast general sponsorship top bar-->
			<section class="row row--no-margin color_bg_dark_navy podtopbar">
					<div class="col-sm-6  text-content">
						<h1><?php if ($aside_sponsor_and_region) {
						    echo 'Advisor <i>ToGo</i> Podcasts';
						} else {
						    echo single_cat_title();
						}?></h1>
						<i class="featured-videos-title__icon featured-videos-title--thin fa fa fa-headphones"></i>
						<div class="excerpt"><?php if ($aside_sponsor_and_region) {
						    echo category_description($idAdvisorToGo);
						} else {
						    echo category_description();
						}?></div>
					</div>
					<div class="col-sm-3  text-content">
						<figure class="sponsor-bloc">
							<!--sponsor link and logo-->
	                        <?php

						        $logo_array = $sponsor_info->logo;
$logo = $logo_array['url'];
$sponsor_name = $sponsor_info->name;
$external_link = $sponsor_info->external_link;

if (! empty($logo)) { ?>
	                            	<figcaption><?php _e('Powered by', 'avatar-tcm'); ?></figcaption>
	                            	<?php if ($external_link) { ?>
	                                <a href="<?php echo $external_link; ?>" target="_blank"><img src="<?php echo $logo; ?>" alt=""></a>
	                                <?php } else { ?>
	                                	<img src="<?php echo $logo; ?>" alt="">
	                                <?php } ?>
	                                
	                               <?php } else { ?>
	                                     <div><?php echo $sponsor_name; ?></div>
	                               <?php }
	                               ?>
						</figure>
					</div>
					<div class="col-sm-3  text-content">
						<p class="reserved"><?php _e('For Advisor Use Only', 'avatar-tcm'); ?></p>
						<a href="<?php echo get_blog_details(5)->siteurl; ?>/full-disclaimer/" class="disclaimer-link"><?php _e('See full disclaimer', 'avatar-tcm'); ?></a>
					</div>
			</section>
			<!--end top bar-->





		<?php // featured video section?>
		<?php if ($avatar_first_podcast_subcat_query->have_posts()) { ?>
		<section class="row equal-col-md row--no-margin">
			<div class="col-md-8 left-content">
			<?php while ($avatar_first_podcast_subcat_query->have_posts()) {
			    $avatar_first_podcast_subcat_query->the_post(); ?>
				<?php
			        $curr_post_id = get_the_id();
			    $acf_podcast_related_article = get_field('acf_podcast_related_article', $curr_post_id);
			    $acf_podcast_related_video = get_field('acf_podcast_related_video', $curr_post_id);
			    $category = wp_get_post_categories($curr_post_id);
			    ?>
				<?php $avatar_exclude_podcast_ids[] = $curr_post_id; ?>
				<?php
			        $sponsor_info = avatar_get_sponsor_info($curr_post_id);
			    $logo_array = $sponsor_info->logo;
			    $logo = $logo_array['url'];
			    $sponsor_name = $sponsor_info->name;
			    $external_link = $sponsor_info->external_link;
			    ?>
				<div class="row">
					<div class="col-sm-12">
						<h2 class="bloc-title bloc-title"><?php echo get_cat_name(end($category)); ?></h2>
					</div>
				</div>
				<div class="row">
					<?php if (has_post_thumbnail()) { ?>
							<figure class="col-sm-6 col-sm-push-6 figure-relative text-content">
								<a class="featured-video" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail($size = 'medium_large', ['class' => 'img-responsive text-content__image-full']); ?>
									<div class="kxo"><i class="videos-caret videos-caret--featured fa fa-caret-right" aria-hidden="true"></i></div>
								</a>
							</figure>
						<?php } ?>
 							
						<div class="<?php if (has_post_thumbnail()) { ?>col-sm-6 col-sm-pull-6<?php } else { ?>col-sm-12<?php } ?> text-content">
							<h2 class="text-content__title text-content__title--xxbig">
								<a class="text-content__link" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<p class="text-content__excerpt text-content__excerpt">
								<?php echo wp_trim_words(get_the_excerpt(), 35); ?>
							</p>
							<ul class="pub-details pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false, $aside_sponsor_and_region ? 'Featuring: ' : 'By: '); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
							<ul class="pub-details pub-details--search-results">
								<li class="pub-details__item"><?php	avatar_display_speaker_campanie_name($curr_post_id); ?></li>
							</ul>							
							<ul class="pub-details">
								<li class="pub-details__item">
									<figure class="featured-sponsor">
										<?php if ($external_link !== '') {?><a href="<?php echo $external_link; ?>" target="_blank"><?php } ?>
											<img alt="<?php echo $sponsor_name; ?>" src="<?php echo $logo; ?>">
										<?php if ($external_link !== '') {?></a><?php } ?>
									</figure>
								</li>
							</ul>
							<?php
			                avatar_display_fund_by_article($curr_post_id);
			    ?>
							<?php if (($acf_podcast_related_article !== null) && ($acf_podcast_related_article !== 0) && ($acf_podcast_related_article !== false)) {
							    $acf_podcast_related_article_obj = get_post($acf_podcast_related_article);
							    ?>
								<div class="fund-related article">
									<a href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>">
										<i class="fa fa-newspaper-o" aria-hidden="true"></i>
									</a>
									<a class="link" href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>"><?php _e('Related Article', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>		
							<?php if (($acf_podcast_related_video !== null) && ($acf_podcast_related_video !== 0) && ($acf_podcast_related_video !== false)) {
							    $acf_podcast_related_video_id = is_array($acf_podcast_related_video) ? $acf_podcast_related_video[0]->ID : $acf_podcast_related_video;
							    $acf_podcast_related_video_obj = get_post($acf_podcast_related_video_id);
							    ?>							
								<div class="fund-related video" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>">
									<a href="<?php echo get_permalink($acf_podcast_related_video_id); ?>"  title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" target="_blank" class="popup-video cboxElement">
										<i class="fa fa-video-camera" aria-hidden="true"></i>
									</a>
									<a class="link popup-video cboxElement" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" href="<?php echo get_permalink($acf_podcast_related_video_id); ?>"><?php _e('Related Video', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>
						</div>
				</div>

			<?php } ?>
		<?php } wp_reset_postdata(); // end have_posts?>
		<?php //end 1 podcast?>


		<?php
            // podcast 2-9
            $page_id = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 8;
$avatar_podcast_subcat_arrg = [
    'post_type' => 'post',
    'cat' => $avatar_podcast_cat_id,
    'post__not_in' => $avatar_exclude_podcast_ids,
    'order' => 'DESC',
    'order_by' => 'post_date',
    'paged' => $page_id,
    'posts_per_page' => $posts_per_page,
];

$avatar_podcast_subcat_query = new WP_Query($avatar_podcast_subcat_arrg);
?>


		<?php if ($avatar_podcast_subcat_query->have_posts()) { ?>
					<div class="row category-regular-listing" id="js-regular-listing-container" >
			<?php while ($avatar_podcast_subcat_query->have_posts()) {
			    $avatar_podcast_subcat_query->the_post(); ?>
				<?php
			    $curr_post_id = get_the_id();
			    $acf_podcast_related_article = get_field('acf_podcast_related_article', $curr_post_id);
			    $acf_podcast_related_video = get_field('acf_podcast_related_video', $curr_post_id);
			    ?>
				<div class="col-md-6 col-sm-6 js-regular-listing"><!-- LOOP  -->
					<div id="post-<?php the_ID(); ?>" class="row" >
						<?php if (has_post_thumbnail()) { ?>
						<figure class="figure-relative text-content no-padding-bottom col-md-5 col-sm-5 col-xs-12 col-no-padding-xs-right togo-list">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail($size = 'thumbnail', ['class' => 'img-responsive text-content__image-full']); ?>
							<i class="videos-caret videos-caret--listing fa fa-caret-right" aria-hidden="true"></i>
							</a>
						</figure>
						<?php }?>
						<?php $css_content_video = has_post_thumbnail() ? 'col-md-7 col-sm-7 col-xs-12' : 'col-md-12'; ?>
						<div class="text-content <?php echo esc_attr($css_content_video); ?> ">
							<h2 class="text-content__title">
								<a class="text-content__link text-content__link--text-hover-base" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<ul class="pub-details">
								<?php avatar_display_post_author($curr_post_id, $single = false); ?>
								<?php avatar_display_post_date($curr_post_id, $single = false); ?>
							</ul>
							<ul class="pub-details">
								<li class="pub-details__item"><?php	avatar_display_speaker_campanie_name($curr_post_id); ?></li>
							</ul>
							<?php
			                avatar_display_fund_by_article($curr_post_id);
			    ?>
							<?php if (($acf_podcast_related_article !== null) && ($acf_podcast_related_article !== 0) && ($acf_podcast_related_article !== false)) {
							    $acf_podcast_related_article_obj = get_post($acf_podcast_related_article);
							    ?>
								<div class="fund-related article">
									<a href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>">
										<i class="fa fa-newspaper-o" aria-hidden="true"></i>
									</a>
									<a class="link" href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>"><?php _e('Related Article', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>		
							<?php if (($acf_podcast_related_video !== null) && ($acf_podcast_related_video !== 0) && ($acf_podcast_related_video !== false)) {
							    $acf_podcast_related_video_id = is_array($acf_podcast_related_video) ? $acf_podcast_related_video[0]->ID : $acf_podcast_related_video;
							    $acf_podcast_related_video_obj = get_post($acf_podcast_related_video_id);
							    ?>							
								<div class="fund-related video" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>">
									<a href="<?php echo get_permalink($acf_podcast_related_video_id); ?>"  title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" target="_blank" class="popup-video cboxElement">
										<i class="fa fa-video-camera" aria-hidden="true"></i>
									</a>
									<a class="link popup-video cboxElement" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" href="<?php echo get_permalink($acf_podcast_related_video_id); ?>"><?php _e('Related Video', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>		
							
						</div>
						
					</div>
				</div>
			<?php } ?>
				</div>
					<div class="pagination pagination--video">
						<?php next_posts_link('Older Entries', $avatar_podcast_subcat_query->max_num_pages); ?>
					</div>
				</div>
		<?php } else { ?>
			<div class="col-md-8"></div>
		</div>
		<?php } wp_reset_postdata(); // end have_posts?>


			<aside class="col-md-4">
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
                                    'sizes' => '[ [300,250] ]',
                                    'sizeMapping' => '[ [[0,0], [[320,50]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
                                ],
                                $arr_avt_vars = [
                                    'class' => 'bigbox text-center',
                                ]
                            );
?>
					</div>
						<div class="col-sm-12 col-md-12 micro-module togo-filter">
					            <?php // Include Advisor Sponsor
                    include locate_template('templates/podcast/component-advisor-sponsor.php');

?>
					</div>
						<div class="col-sm-12 col-md-12 micro-module togo-filter">
					            <?php // Include Advisor Sponsor
include locate_template('templates/podcast/component-advisor-region.php');

?>
						</div>
						<?php
at_get_the_m32banner(
    $arr_m32_vars = [
        'sticky' => true,
        'staySticky' => true,
        'kv' => [
            'pos' => [
                'btf',
                'but1',
                'right_bigbox',
                'bottom_right_bigbox',
            ],
        ],
        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
    ],
    $arr_avt_vars = [
        'class' => 'bigbox text-center bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
    ]
);
?>
					</aside>
				</section>
		<?php // endn subcategory podcast sections?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>
