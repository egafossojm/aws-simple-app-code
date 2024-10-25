<?php $post_id = get_the_ID(); ?>
<?php get_header();

// For colors
$avatar_columnist_page_obj = get_field('acf_inside_track_breadcrumb', 'option');
$avatar_columnist_page_color_class = avatar_get_cat_page_color($avatar_columnist_page_obj->ID);

$isSpeaker = get_field('acf_author_is_speaker', $post_id);

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
?>

<!--podcast general sponsorship top bar-->
<?php if ($isSpeaker) { ?>
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

<section class="single-cpt <?php echo esc_attr($avatar_columnist_page_color_class); ?>">
	<header>
		<?php
        $author_email = get_field('acf_author_email', $post_id);
$author_tel = get_field('acf_author_tel', $post_id);
$author_tel_url = get_field('acf_author_tel_url', $post_id);
$author_website = strtolower(get_field('acf_author_website', $post_id));
$author_linkedin = strtolower(get_field('acf_author_linkedin', $post_id));
$author_twitter = strtolower(get_field('acf_author_twitter', $post_id));
$columns = get_term(get_field('acf_author_column'), 'post_column');
$is_columnist = get_field('acf_author_is_columnist', $post_id);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 10;
$articles_args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'meta_query' => [
        [
            'key' => 'acf_article_author',
            'value' => '"'.$post_id.'"',
            'compare' => 'LIKE',
        ],
    ],
    'order' => 'DESC',
    'orderby' => 'date',
    'paged' => $paged,
];
$wp_query = null;
$wp_query = new WP_Query($articles_args);
$reg_author = $is_columnist ? '' : 'entity-header--gray';
$conditional_margin_css = '';
if ($wp_query->post_count == 0) {
    $conditional_margin_css = 'entity-content--no-margin-top';
}

$author_id = get_field('acf_article_author');
$author_origin = get_field('acf_columnist_site_source', $author_id[0]->ID);
$cir_author = strcmp('CIR blog', $author_origin) === 0;

?>

		<?php if (get_current_view_context() == 'cir') { ?>

			<div id="js-sticky-banner-single" class="adv-head-cir row">
				<a href="<?php echo $url_category; ?>">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR_Logo_Horizontal.png" class="img-responsive" alt="CIR">
				</a>
			</div>

		<?php } ?>
		<div class="entity-header entity-row expert-panel row <?php echo esc_attr($reg_author); ?>">
			<div>
				<div>
					<div class="col-md-2 col-sm-3 col-xs-5 text-center">
						<?php if (has_post_thumbnail($post_id)) { ?>
							<figure class="entity-header__figure entity-header__figure--noFloat">
								<img class="entity-header__image" src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail'); ?>" alt="<?php avatar_the_post_thumbnail_alt($post_id); ?>">
							</figure>
						<?php } ?>
						<div class="entity-header__infos">
							<?php
                    $enterprise_url = get_field('acf_enterprise_url', $post_id);
$enterprise_image = get_field('acf_enterprise_logo', $post_id);
if ($enterprise_image) {
    ?>
								<ul class="pub-details">
									<li class="pub-details__item">
										<figure class="featured-sponsor">
											<?php if ($enterprise_url !== '') { ?><a href="<?php echo $enterprise_url; ?>" target="_blank"><?php } ?>
												<img alt="<?php echo $enterprise_image['alt']; ?>" src="<?php echo $enterprise_image['url']; ?>">
												<?php if ($enterprise_url !== '') { ?></a><?php } ?>
										</figure>
									</li>
								</ul>
							<?php
}
?>
						</div>
						<div class="entity-header__infos">
							<?php if ($author_email || $author_linkedin || $author_twitter) { ?>
								<dl class="social-icons">
									<dt class="social-icons-empty"></dt>
									<?php if ($author_email) { ?>
										<dd>
											<a class="mailto" href="mailto:<?php echo sanitize_email($author_email); ?>">
												<span><?php _e('Mail', 'avatar-tcm'); ?></span>
											</a>
										</dd>
									<?php } ?>
									<?php if ($author_linkedin) { ?>
										<dd>
											<a class="lkin" target="_blank" href="<?php echo esc_url($author_linkedin); ?>">
												<span><?php _e('LinkedIn', 'avatar-tcm'); ?></span>
											</a>
										</dd>
									<?php } ?>
									<?php if ($author_twitter) { ?>
										<dd>
											<a class="twt" target="_blank" href="<?php echo esc_url($author_twitter); ?>">
												<span><?php _e('Twitter', 'avatar-tcm'); ?></span>
											</a>
										</dd>
									<?php } ?>
								</dl>
							<?php } ?>
							<?php if ($author_website) { ?>
								<a target="_blank" href="<?php echo esc_url($author_website); ?>">
									<?php _e('Visit website', 'avatar-tcm'); ?>
								</a>
							<?php } ?>
							<?php if ($author_tel) { ?>
								<?php $author_tel_url = preg_replace('/[^0-9]/', '', $author_tel); ?>
								<span class="entity-header__tel">
									<a href="tel:<?php echo esc_attr($author_tel_url); ?>"><?php echo esc_html($author_tel); ?></a>
								</span>
							<?php } ?>
						</div>
					</div>
					<div class="entity-header__landing-box entity-header__landing-box--negative-margin col-md-6 col-sm-9 col-xs-7">
						<?php if ($is_columnist) { ?>
							<span class="entity-title__tag">
								<?php
    if (is_wp_error($columns)) {
        echo wp_kses_post($columns->get_error_message());
    } else {
        echo esc_html($columns->name);
    }
						    ?>
							</span>
						<?php } ?>
						<h1 class="entity-header__name">
							<?php the_title(); ?>
						</h1>
						<div class="text-content text-content__excerpt text-content__excerpt--text-lightest">
							<?php the_content(); ?>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<?php get_template_part('templates/article/article-entity-share', 'top'); ?>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="entity-content <?php echo esc_attr($conditional_margin_css); ?>row equal-col-md">
		<section class="col-md-8">
			<div class="row row--no-margin">
				<div class=" col-md-9 col-md-offset-3">
					<div class="row">
						<div class="entity-box-listing col-xs-12">
							<div id="js-regular-listing-container">
								<?php if ($wp_query->have_posts() && $wp_query->post_count !== 0) {
								    while ($wp_query->have_posts()) {
								        $wp_query->the_post();
								        $post_id = get_the_ID();
								        ?>
										<div class="js-regular-listing">
											<div class="text-content text-content--border-top">
												<h2 class="text-content__title text-content__title--big icons title-article-author <?php echo avatar_article_get_icon($post_id); ?>">
													<a class="text-content__link" href="<?php the_permalink(); ?>">
														<?php the_title(); ?>
													</a>
												</h2>
												<p class="text-content__excerpt">
													<?php echo get_the_excerpt(); ?>
												</p>
												<ul class="pub-details">
													<?php
								                            avatar_display_post_source($post_id, $single = false);
								        avatar_display_post_date($post_id, $single = false);
								        ?>
												</ul>
											</div>
										</div>
									<?php } ?>

									<?php wp_reset_postdata(); ?>

								<?php } else {
								    _e('There is currently no post for this author', 'avatar-tcm'); ?>

								<?php } ?>

							</div>

							<div class="pagination">
								<?php next_posts_link(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<aside class="col-md-4 primary text-center">
			<?php //include Quick subscribe newsletters component
            avatar_include_subscription_module();
?>
			<?php
$arr_m32_vars = [
    'sticky' => true,
    'staySticky' => true,
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
    'class' => 'bigbox text-center bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
];

$is_cir_author = $cir_author;
get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars, $is_cir_author);
?>
			<?php //include Cxense most popular/shared component
include locate_template('templates/general/component-cxense-most.php'); ?>
		</aside>
	</div>
	<?php if ($is_columnist) { ?>
		<div class="row equal-col-md">
			<?php //load if is columnist
include locate_template('templates/category/more-columnists.php');
	    ?>
			<aside class="col-md-4 primary text-center">
				<?php

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
	        ];
	    $arr_avt_vars = [
	        'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
	    ];

	    $is_cir_author = $cir_author;
	    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars, $is_cir_author);

	    ?>
			</aside>
		</div>
	<?php } ?>
</section>
<?php get_footer(); ?>