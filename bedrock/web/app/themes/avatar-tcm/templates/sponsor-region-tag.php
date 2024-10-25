<?php
/**
 * This is the template that displays tags or custom tag taxonomy
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
global $wp_query;
get_header();

$idGestionnaireEnDirect = get_cat_ID('Gestionnaires en direct');
$idAdvisorToGo = get_cat_ID('Advisor To Go');

$site_id = get_current_blog_id();
switch ($site_id) {
    case 5:
        $curr_sponsor_cat_id = $idAdvisorToGo;
        $site_url = get_blog_details($site_id)->siteurl;
        $disclaimerlink = $site_url.'/full-disclaimer/';
        $cat_name = 'Advisor <i>ToGo</i> Podcasts';
        break;
    case 4:case 6:
        $curr_sponsor_cat_id = $idGestionnaireEnDirect;
        $site_url = get_blog_details($site_id)->siteurl;
        $disclaimerlink = $site_url.'/avis-de-non-responsabilite/';
        $cat_name = 'Balados Gestionnaires <i>en direct</i>';
        break;
    default:
        $curr_sponsor_cat_id = 0;
        $cat_name = get_cat_name($curr_sponsor_cat_id);
        break;
}

if ($curr_sponsor_cat_id != 0) {
    $sponsorthiscat = get_category($curr_sponsor_cat_id);
    $sponsor_info = avatar_get_sponsor_info_categ($sponsorthiscat);
}

// Manage exception depending of the type of taxonomy term searched
switch (get_taxonomy(get_queried_object()->taxonomy)->name) {

    // Exceptions for custom taxonomy 'post_company' -> 'Company'
    case 'post_sponsor':
        $avatar_tag_name = __('Company: %s', 'avatar-tcm');
        $object = get_term_by('name', single_tag_title('', false), 'post_sponsor');
        $object_logo = get_field('acf_sponsor_logo', $object);
        $object_url = get_field('acf_sponsor_external_link', $object);
        $display_class = 'entity-header__landing-box--company';
        $sponsor = get_term_by('id', get_queried_object()->term_id, 'post_sponsor');
        $acf_sponsor_type = get_field('acf_sponsor_type', $sponsor);
        $IsPostRegion = false;
        break;

    case 'post_region':
        $avatar_tag_name = __('Region: %s', 'avatar-tcm');
        $object = get_term_by('name', single_tag_title('', false), 'post_region');
        $object_logo = get_field('acf_region_image', $object);
        $display_class = 'entity-header__landing-box--region';
        //$object_url = get_field( 'acf_sponsor_external_link', $object );
        $acf_sponsor_type = '';
        $IsPostRegion = true;
        break;
        // Default case: any tag
    default:
        $avatar_tag_name = __('Tag: %s', 'avatar-tcm');
        $IsPostRegion = false;
        break;
}
?>
<section class="single-cpt">
	<!--podcast general sponsorship top bar-->
		<?php if (($acf_sponsor_type == 'podcast') || ($IsPostRegion)) {?>
			<section class="row row--no-margin color_bg_dark_navy podtopbar">
				<div class="col-sm-6  text-content">
					<h1><?php if ($curr_sponsor_cat_id == 0) {
					    echo single_cat_title();
					} else {
					    echo $cat_name;
					}?></h1>
					<i class="featured-videos-title__icon featured-videos-title--thin fa fa fa-headphones"></i>
					<div class="excerpt"><?php if ($curr_sponsor_cat_id == 0) {
					    echo category_description();
					} else {
					    echo category_description($curr_sponsor_cat_id);
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
					<a href="<?php echo $disclaimerlink; ?>" class="disclaimer-link"><?php _e('See full disclaimer', 'avatar-tcm'); ?></a>
				</div>
			</section>
		<?php } ?>
		<!--end top bar-->

	
	  <header>
		<div class="entity-header entity-header--gray entity-row row">
			<div>
				<div>
					<div class="entity-header__landing-box <?php echo $display_class; ?> col-sm-7 col-sm-offset-1">
						<h1 class="entity-header__name entity-header__name--block entity-header__name--small entity-header__name--no-capitalize entity-header__name--no-border-bottom">
							<div class="search-box-result">
								<span class="search-box-result__title">
									<?php $avatar_tag = single_tag_title('', false); ?>
									<?php printf($avatar_tag_name, $avatar_tag); ?>
								</span>
							</div>
						</h1>
						<!--put php condition if template for region-->
						<?php if (get_taxonomy(get_queried_object()->taxonomy)->name == 'post_region') { ?>
							<figure class="sponsor-bloc">
									<img src="<?php echo $object_logo['sizes']['thumbnail']; ?>">
								</figure>
						<?php } ?>
						<!--end if here-->

						<div class="text-content text-content__excerpt text-content__excerpt--text-lightest no-padding-top-xs">
							<span>
								<?php printf(_n('%s result found', '%s results found', $wp_query->found_posts, 'avatar-tcm'), $wp_query->found_posts); ?>
						</div>
					</div>
					<div class="col-sm-4">
						<!--put php condition if template for company-->

						<?php if (get_taxonomy(get_queried_object()->taxonomy)->name == 'post_sponsor' && isset($object_logo['sizes']['thumbnail'])) { ?>
						<figure class="sponsor-bloc">
								<?php if ($acf_sponsor_type != 'podcast') {?>
								<figcaption><?php _e('Powered by', 'avatar-tcm'); ?></figcaption>
							<?php } ?>
								<!--sponsor link and logo-->
								<a href="<?php echo $object_url; ?>"><img src="<?php echo $object_logo['sizes']['thumbnail']; ?>" alt="<?php echo $object->name; ?>"></a>  
								                                </figure>
							<?php } ?>
						<!--end if here-->
				</div>
			</div>
		</div>
	</header>
	<div class="entity-content row equal-col-md">
	<?php if (have_posts()) { ?>
		<section class="col-lg-8 col-md-7 col-no-padding-left-xs">
			<div class="row row--no-margin">
				<div class=" col-md-10 col-md-offset-2-calc-15">
					<div class="row">
						<div class="entity-box-listing entity-box-listing--headphones col-xs-12" >
							<div id="js-regular-listing-container" >

								<?php while (have_posts()) {
								    the_post();
								    //Hightlight Search Terms in Results
								    $title = get_the_title();
								    $avatar_tag = preg_replace('/[.,]/', '', $avatar_tag);
								    $keys = explode(' ', $avatar_tag);
								    $title = preg_replace('/('.implode('|', $keys).' )/iu', '\0', $title);
								    $excerpt = get_the_excerpt();
								    $keys = explode(' ', $avatar_tag);
								    $excerpt = preg_replace('/('.implode('|', $keys).')/iu', '\0', $excerpt);
								    $post_id = get_the_ID();
								    $acf_podcast_related_article = get_field('acf_podcast_related_article', $post_id);
								    $acf_podcast_related_video = get_field('acf_podcast_related_video', $post_id);
								    $category = wp_get_post_categories($post_id);
								    $aside_sponsor_and_region = ($idAdvisorToGo == $category[0]) || ($idGestionnaireEnDirect == $category[0]) || (isset($category[1]) && ($idGestionnaireEnDirect == $category[1]));
								    ?>
								<div class="js-regular-listing">
									<div class="text-content text-content--border-top">
										<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
											<figure class="text-content__figure-right text-content__figure-right--search-results list-img">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail($size = 'full', $attr = ['class' => 'img-responsive']); ?>
												</a>
											</figure>
										<?php } ?>
										<h2 class="text-content__title text-content__title--big icons title-article-author <?php echo avatar_article_get_icon($post_id); ?>" >
											<a class="text-content__link"  href="<?php the_permalink(); ?>">
												<?php echo wp_kses_post($title); ?>
											</a>
										</h2>
										<p class="text-content__excerpt">
											<?php echo wp_kses_post($excerpt); ?>
										</p>
										<ul class="pub-details pub-details--search-results">
											<?php
								               avatar_display_post_author($post_id, $single = false, $aside_sponsor_and_region ? 'Featuring: ' : 'By: ');
								    avatar_display_post_source($post_id, $single = false);
								    avatar_display_post_date($post_id, $single = false);
								    ?>
										</ul>
										<ul class="pub-details pub-details--search-results">
											<li class="pub-details__item"><?php	avatar_display_speaker_campanie_name($post_id); ?></li>
										</ul>
										<?php
								        avatar_display_fund_by_article($post_id);
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
								<?php //the_posts_navigation();?>
							</div>
						</div>
						<div class="pagination">
							<?php next_posts_link(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
		<aside class="col-lg-4 col-md-5 primary">
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
					<?php if (($acf_sponsor_type == 'podcast') || $IsPostRegion) {?>
						<div class="col-sm-12 col-md-12 micro-module togo-filter">
						<?php // Include Advisor Sponsor
include locate_template('templates/podcast/component-advisor-sponsor.php');
					    ?>
						</div>             
						<div class="col-sm-12 col-md-12 micro-module togo-filter">
						<?php // Include Advisor Region
					    include locate_template('templates/podcast/component-advisor-region.php');
					    ?>
						</div>
					<?php } else { ?>
						<?php
					    // Include Microsite Block
					    avatar_include_template_conditionally('templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
					    ?>
						<?php //include tools and resources component
					        include locate_template('templates/tools/component-tools-and-ressources.php');
					    ?>
						<?php //include Cxense most popular/shared component
					        include locate_template('templates/general/component-cxense-most.php');
					    ?>
						<?php
					    if ($is_brand or $is_partner) { ?>
							<?php include locate_template('templates/article/article-aside-sponsor.php'); ?>
						<?php } ?>
					<?php } ?>
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
			<?php //include Cxense most popular/shared component
include locate_template('templates/general/component-cxense-most.php');
?>
		</aside>
	</div>
</section>
<?php get_footer(); ?>