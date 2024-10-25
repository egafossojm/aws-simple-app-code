<?php get_header(); ?>
<?php while (have_posts()) {
    the_post(); ?>
	<?php
    $filtered_content = apply_filters('the_content', get_the_content());
    $singleMainCategoryField = get_field('article_side_main_subcategory', get_the_ID());
    $singleMainCategoryFieldCat = get_category($singleMainCategoryField);
    $singleMainCategoryFieldCat = is_array($singleMainCategoryFieldCat) ? $singleMainCategoryFieldCat[0] : $singleMainCategoryFieldCat;
    $singleMainCategoryFieldCatSlug = $singleMainCategoryFieldCat->slug;

    //$keyword_popup_info[] { 0 = has keyword; 1 = content; 2 = tag; 3 = custom html }
    $keyword_popup_info = avatar_add_sponsored_keyword(get_the_ID(), $filtered_content);
    $content = avatar_split_post($keyword_popup_info[1]);
    $avatar_video_checked = get_field('acf_article_media');
    $avatar_video_id = get_field('acf_article_video');
    $avatar_article_type = get_field('acf_article_type');
    $avatar_media_checked = get_field('acf_article_media');
    $avatar_podcast_url = get_field('acf_article_audio_url');
    $avatar_article_site_origin = get_field('imported_site_origin');

    $avatar_microsite_object = get_field('acf_article_microsite');

    $newpaper = get_field('acf_article_newspaper');
    if ($newpaper) {
        $newspaper_name = get_field('acf_newspaper_type', $newpaper->ID);
        $newspaper_id = $newpaper->ID;
    }

    $category = wp_get_post_categories(get_the_ID());
    $article_origin = get_primary_category_origin($category);
    $url_category = get_category_link($category[0]);

    $site_id = get_current_blog_id();
    switch ($site_id) {
        case 5:
            $idAdvisorToGo = get_cat_ID('Advisor To Go');
            $curr_sponsor_cat_id = $idAdvisorToGo;
            $aside_sponsor_and_region = ($idAdvisorToGo == $category[0]);
            $site_url = get_blog_details($site_id)->siteurl;
            $disclaimerlink = $site_url.'/full-disclaimer/';
            $cat_name = 'Advisor <i>ToGo</i> Podcasts';
            break;
        case 4:
        case 6:
            $idGestionnaireEnDirect = get_cat_ID('Gestionnaires en direct');
            $curr_sponsor_cat_id = $idGestionnaireEnDirect;
            $aside_sponsor_and_region = ($idGestionnaireEnDirect == $category[0]) || (isset($category[1]) && ($idGestionnaireEnDirect == $category[1]));
            $site_url = get_blog_details($site_id)->siteurl;
            $disclaimerlink = $site_url.'/avis-de-non-responsabilite/';
            $cat_name = 'Balados Gestionnaires <i>en direct</i>';
            break;
        default:
            $curr_sponsor_cat_id = 0;
            $aside_sponsor_and_region = false;
            $cat_name = get_cat_name($curr_sponsor_cat_id);
            break;
    }

    if ($curr_sponsor_cat_id != 0) {
        $sponsorthiscat = get_category($curr_sponsor_cat_id);
        $sponsor_info = avatar_get_sponsor_info_categ($sponsorthiscat);
    }

    if (is_singular()) {
        include locate_template('functions/post/post-subheader-variables.php');
    }
    // For colors
    $avatar_columnist_page_obj = get_field('acf_inside_track_breadcrumb', 'option');
    $avatar_columnist_page_color_class = $is_columnist ? avatar_get_cat_page_color($avatar_columnist_page_obj->ID) : '';

    $author_id = get_field('acf_article_author');
    $author_origin = get_field('acf_columnist_site_source', $author_id[0]->ID);
    $cir_author = ! empty($author_origin) ? strcmp('CIR blog', $author_origin) === 0 : null;

    ?>
	<div class="wrap">

		<!--podcast general sponsorship top bar-->
		<?php if ($aside_sponsor_and_region) { ?>
			<section class="row row--no-margin color_bg_dark_navy podtopbar">
				<div class="col-sm-6  text-content">
					<h1><?php if ($curr_sponsor_cat_id == 0) {
					    echo single_cat_title();
					} else {
					    echo $cat_name;
					} ?></h1>
					<i class="featured-videos-title__icon featured-videos-title--thin fa fa fa-headphones"></i>
					<div class="excerpt"><?php if ($curr_sponsor_cat_id == 0) {
					    echo category_description();
					} else {
					    echo category_description($curr_sponsor_cat_id);
					} ?></div>
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

		<article id="post-<?php the_ID(); ?>" <?php post_class('base-article '.$avatar_columnist_page_color_class); ?> itemscope itemtype="http://schema.org/NewsArticle">
			<meta itemscope itemprop="mainEntityOfPage" content="" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" />
			<!--if advisor to client article, insert little head image-->
			<?php if ($avatar_article_type === 'advisortoclient') { ?>
				<div class="adv-head row">
					<a href="<?php echo $url_category; ?>">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-atc-main.png" class="img-responsive" alt="Advisor to client">
				</div>
				</a>
			<?php } elseif (get_current_view_context() == 'cir') { ?>

				<div id="js-sticky-banner-single" class="adv-head-cir row">
					<a href="<?php echo $url_category; ?>">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR">
				</div>
				</a>

			<?php } ?>
			<!---->
			<?php avatar_display_post_sponsor($post_id, true, $aside_sponsor_and_region ? '' : 'Presented by:'); ?>
			<header class="base-article__header">
				<?php
                if ($is_brand) { ?>
					<p class="sponsor-title sponsor-title--article">
						<?php echo esc_html($brand_page_title); ?>
					</p>
				<?php } elseif ($is_partner) { ?>
					<p class="sponsor-title sponsor-title--article">
						<?php echo esc_html($partner_page_title); ?>
					</p>
				<?php } elseif ($is_columnist) {
				    include locate_template('templates/article/article-header-writer.php');
				} elseif ($is_regular_feature) {
				    include locate_template('templates/article/article-header-feature.php');
				} elseif (is_object($avatar_microsite_object)) {
				    $microsite_id = $avatar_microsite_object->ID;
				    $microsite_title = $avatar_microsite_object->post_title;
				    $microsite_excerpt = $avatar_microsite_object->post_excerpt;
				    $microsite_link = get_permalink($microsite_id);
				    $partner_banner = get_field('acf_microsite_partner_banner', $microsite_id);

				    $partner_logo = get_field('acf_microsite_partner_logo', $microsite_id);
				    $partner_link = get_field('acf_microsite_partner_url', $microsite_id);
				    $partner_name = get_field('acf_microsite_partner_name', $microsite_id);
				    $partner_background = get_field('acf_microsite_banner_color_picker', $microsite_id);
				    include locate_template('templates/article/article-header-microsite.php');
				}

    ?>
				<?php if (! is_singular('microsite')) { ?>
					<h1 class="base-article__title" itemprop="headline"><?php the_title(); ?></h1>
					<div class="row">
						<div class="col-md-8">
							<?php if (has_excerpt()) {  ?>
								<div itemprop="description" class="base-article__deck">
									<?php the_excerpt() ?>
								</div>
							<?php } ?>
							<ul class="pub-details">
								<?php avatar_display_post_author($post_id, $single = true, $aside_sponsor_and_region ? 'Featuring: ' : 'By: '); ?>
								<?php avatar_display_post_source($post_id, $single = true); ?>
								<?php avatar_display_post_date($post_id, $single = true); ?>
							</ul>
							<ul class="pub-details">
								<li class="pub-details__item"><?php avatar_display_speaker_campanie_name($post_id); ?></li>
							</ul>
						</div>
						<div class="col-md-4 single-share-socials">
							<?php get_template_part('templates/article/article-share', 'top'); ?>
						</div>
					</div>
				<?php } ?>
			</header>
			<?php if (is_singular('microsite') || (($singleMainCategoryField && ($singleMainCategoryFieldCatSlug == 'post-event-coverage') || $singleMainCategoryFieldCatSlug == 'conference-coverage'))) { ?>
				<div>
					<section class="col-12 article-body">
					<?php } else { ?>
						<div class="row equal-col-md">
							<section class="col-md-8 article-body">
							<?php } ?>
							<?php if ($avatar_video_id && $avatar_video_checked && in_array('video', $avatar_video_checked)) {
							    //display the video player
							    avater_the_video_player($avatar_video_id);
							    ?>
							<?php } else { ?>
								<?php if (has_post_thumbnail()) { ?>
									<?php $avatar_thumbnail_caption = get_the_post_thumbnail_caption($post_id); ?>
									<figure class="main post-thumbnail">
										<?php the_post_thumbnail('post-featured-image', ['class' => 'img-responsive btn-block']); ?>
									</figure><!-- .post-thumbnail -->
									<?php if ($avatar_thumbnail_caption != '') { ?>
										<div class="wp-caption-text"><?php echo esc_html($avatar_thumbnail_caption); ?></div>
									<?php } ?>
								<?php } ?>
							<?php } ?>
							<?php if (has_post_thumbnail()) { ?>
								<?php $imag_arr = wp_get_attachment_metadata(get_post_thumbnail_id(), false); ?>
								<div class="hidden" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
									<meta itemprop="url" content="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>">
									<meta itemprop="width" content="<?php echo esc_attr($imag_arr['width']); ?>">
									<meta itemprop="height" content="<?php echo esc_attr($imag_arr['height']); ?>">
								</div>
							<?php } else { ?>
								<?php $avatar_wpseo = get_option('wpseo'); ?>
								<div class="hidden" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
									<meta itemprop="url" content="<?php echo esc_url($avatar_wpseo['company_logo']); ?>">
									<meta itemprop="width" content="646">
									<meta itemprop="height" content="216">
								</div>
							<?php } ?>
							<?php if ($avatar_wpseo = get_option('wpseo')) { ?>
								<div class="hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
									<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
										<?php $avatar_wpseo = get_option('wpseo'); ?>
										<meta itemprop="url" content="<?php echo esc_url($avatar_wpseo['company_logo']); ?>">
									</div>
									<meta itemprop="name" content="<?php echo wp_kses_post($avatar_wpseo['company_name']); ?>">
								</div>
							<?php } ?>
							<div class="hidden">
								<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>" />
								<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>" />
							</div>
							<?php
							    $authors_list = get_field('acf_article_author', $post_id);
    if ($authors_list) {
        $author_list = '<div class="hidden" itemprop="author" itemscope itemtype="http://schema.org/Person">';
        foreach ($authors_list as $author) {
            $author_list .= '<span itemprop="name">'.get_the_title($author->ID).'</span>';
        }
        $author_list .= '</div>';
        // Data is escaped
        echo $author_list;
    }
    ?>
							<?php if ($avatar_podcast_url && $avatar_media_checked && in_array('podcast', $avatar_media_checked)) {
							    //display the podcast player
							    avater_the_podcast_player($avatar_podcast_url);
							    ?>
							<?php } ?>

							<div class="row">
								<!--first and second paragraphs of content-->
								<div class="col-md-12">
									<?php echo $content[0]; // Data is escaped
    ?>
								</div>
							</div>

							<!--popover template-->
							<?php if ($keyword_popup_info[0]) {
							    $tag = $keyword_popup_info[2];
							    $tag_html = '<a href="'.esc_url(get_tag_link($tag->term_id)).'" rel="tag">'.ucfirst($tag->name).'</a>';
							    ?>
								<div id="myPopover" class="keyword-pop hide">
									<div class="header">
										<?php echo $tag_html; ?>
									</div>
									<div class="pop-content">
										<?php echo $keyword_popup_info[3]; ?>
									</div>

									<span class="closepop"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
								</div>
							<?php } ?>
							<!--end popover template-->
							<!--remove row element below if no more text is present in article-->
							<?php if (strlen($content[1]) > 20) { ?>
								<div class="row equal-col-md">
									<div class="col-lg-7 col-md-12">
										<!--3rd paragraph and more-->
										<?php
							                $paragraphs = preg_split('/<\/p>/', $content[1], -1, PREG_SPLIT_DELIM_CAPTURE);
							    $index = 0;
							    $paragraphsLength = count($paragraphs);
							    while ($index <= ($paragraphsLength / 2)) {
							        echo $paragraphs[$index];
							        $index++;
							    }
							    echo '<div id="ad-outstream-video" data-ad-network="slimcut" class="ad ad-outstream-video">
													
												  </div>';

							    while ($index <= $paragraphsLength) {
							        if (empty($paragraphs[$index])) {
							            break;
							        }

							        echo $paragraphs[$index];
							        $index++;
							    }

							    $index = 0;
							    ?>
									</div>

									<aside class="col-lg-5 col-md-12 article-related">
										<div class="row row--no-margin">
											<?php include locate_template('templates/article/article-aside.php'); ?>
										</div>
										<?php
							    // Display BigBox banner
							    if (! avatar_acf_value(get_the_id(), 'acf_microsite_no_publicity', false)) {
							        $arr_m32_vars = [
							            'sticky' => true,
							            'staySticky' => true,
							            'isCompanion' => true,
							            'kv' => [
							                'pos' => [
							                    'btf',
							                    'but2',
							                    'right_bigbox_last',
							                    'inarticle_bigbox',
							                ],
							            ],
							            'sizes' => '[ "fluid",[300,1050], [300,600], [300,250] ]',
							            'sizeMapping' => '[ [[0,0], ["fluid",[320,50], [300,250]]], [[768,0], ["fluid",[300,250]]], [[1024, 0], ["fluid",[300,1050], [300,600], [300,250]]] ]',
							        ];
							        $arr_avt_vars = [
							            'class' => 'js_bigbox_aside bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
							        ];

							        get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);
							    }
							    ?>
									</aside>
								</div>
							<?php } else { ?>
								<div class="row">
									<div class="col-md-12" itemprop="description">
										<!--3rd paragraph and more-->
										<?php
							    $paragraphs = preg_split('/<\/p>/', $content[1], -1, PREG_SPLIT_DELIM_CAPTURE);
							    $index = 0;
							    $paragraphsLength = count($paragraphs);
							    while ($index <= ($paragraphsLength / 2)) {
							        echo $paragraphs[$index];
							        $index++;
							    }
							    echo '<div id="ad-outstream-video" data-ad-network="slimcut" class="ad ad-outstream-video">
													
												  </div>';

							    while ($index <= $paragraphsLength) {
							        echo $paragraphs[$index];
							        $index++;
							    }

							    $index = 0;
							    ?>
									</div>
								</div>
							<?php } ?>
							<?php
                            avatar_display_fund_by_article($post_id);

    $acf_podcast_related_article = get_field('acf_podcast_related_article', $post_id);
    $acf_podcast_related_video = get_field('acf_podcast_related_video', $post_id);
    if (($acf_podcast_related_article !== null) && ($acf_podcast_related_article !== 0) && ($acf_podcast_related_article !== false)) {
        $acf_podcast_related_article_obj = get_post($acf_podcast_related_article);
        ?>
								<div class="fund-related article">
									<a href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>">
										<i class="fa fa-newspaper-o" aria-hidden="true"></i>
									</a>
									<a class="link" href="<?php echo get_permalink($acf_podcast_related_article); ?>" title="<?php echo $acf_podcast_related_article_obj->post_title; ?>"><?php echo _e('Related Article', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>
							<?php if (($acf_podcast_related_video !== null) && ($acf_podcast_related_video !== 0) && ($acf_podcast_related_video !== false)) {
							    $acf_podcast_related_video_id = is_array($acf_podcast_related_video) ? $acf_podcast_related_video[0]->ID : $acf_podcast_related_video;
							    $acf_podcast_related_video_obj = get_post($acf_podcast_related_video_id);
							    ?>
								<div class="fund-related video" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>">
									<a href="<?php echo get_permalink($acf_podcast_related_video_id); ?>" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" target="_blank" class="popup-video cboxElement">
										<i class="fa fa-video-camera" aria-hidden="true"></i>
									</a>
									<a class="link popup-video cboxElement" title="<?php echo $acf_podcast_related_video_obj->post_title; ?>" href="<?php echo get_permalink($acf_podcast_related_video_id); ?>" target="_blank"><?php echo _e('Related Video', 'avatar-tcm'); ?></a>
								</div>
							<?php } ?>


							<?php get_template_part('templates/article/article-share', 'bottom'); ?>
							</section>

							<?php if (is_singular('microsite') || (($singleMainCategoryField && ($singleMainCategoryFieldCatSlug == 'post-event-coverage') || $singleMainCategoryFieldCatSlug == 'conference-coverage'))) { ?>

							<?php } else { ?>
								<aside class="col-md-4 primary">
									<?php
							            if (! $aside_sponsor_and_region) {
							                //include Quick subscribe newsletters component
							                avatar_include_subscription_module();
							            }
							    ?>
									<?php if ($aside_sponsor_and_region) { ?>
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
										<?php // Include Microsite Block & Events block
									    // $avatart_microsite_template = 'templates/microsite/component-microsite-block.php';
									    // Include Microsite Block
									    // avatar_include_template_conditionally( $avatart_microsite_template, 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
									    //
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
									<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
										<?php
									    //  if( ! avatar_acf_value(get_the_id(), 'acf_microsite_no_publicity', false)) {
									    $arr_m32_vars = [
									        'isCompanion' => true,
									        'kv' => [
									            'pos' => [
									                'btf',
									                'but1',
									                'right_bigbox',
									                'top_right_bigbox',
									            ],
									        ],
									        'sizes' => '[ "fluid",[300,1050], [300,600], [300,250] ]',
									        'sizeMapping' => '[ [[0,0], ["fluid",[320,50], [300,250]]], [[768,0], ["fluid",[300,250]]], [[1024, 0], ["fluid",[300,1050], [300,600], [300,250]]] ]',
									    ];
							    $arr_avt_vars = [
							        'class' => 'js_bigbox_primary bigbox text-center',
							    ];

							    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

							    //  }
							    ?>
									</div>
									<?php
							        if (! avatar_acf_value(get_the_id(), 'acf_microsite_no_publicity', false)) {
							            $arr_m32_vars = [
							                'isCompanion' => true,
							                'kv' => [
							                    'pos' => [
							                        'btf',
							                        'but2',
							                        'right_bigbox_last',
							                        'bottom_right_bigbox',
							                    ],
							                ],
							                'sizes' => '[ "fluid",[300,1050], [300,600], [300,250] ]',
							                'sizeMapping' => '[ [[0,0], ["fluid",[320,50], [300,250]]], [[768,0], ["fluid",[300,250]]], [[1024, 0], ["fluid",[300,1050], [300,600], [300,250]]] ]',
							            ];
							            $arr_avt_vars = [
							                'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
							            ];
							            get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);
							        }
							    ?>
								</aside>
							<?php } ?>
						</div>

		</article>
	<?php }  ?>
	</div>
	<?php
    if (! ($is_brand or $is_partner or $aside_sponsor_and_region)) {
        include locate_template('templates/article/articles-bottom.php');
    }
?>
	<?php get_footer(); ?>
