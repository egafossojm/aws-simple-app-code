<?php get_header(); ?>
<section class="single-cpt">
	<header>
		<?php
        $sponsor_website = $partner_linkedin = $partner_twitter = $partner_facebook = '';

// Custom fields for CPT feature
$post_id = get_the_ID();
$acf_feature_date = get_field('acf_feature_published_date');
$sponsor_name = get_field('acf_feature_image_alt');
$sponsor_image = get_field('acf_feature_image1');
$sponsor_website = get_field('acf_feature_website');

$is_partner = get_field('acf_feature_ispartner');

$partner_report_id = get_field('acf_in_depth_partner_report', 'option');
$page_feature = get_post($partner_report_id);
$page_partner_report_title = $page_feature->post_title;
$page_partner_report_link = get_page_link($partner_report_id);

if ($is_partner) {
    $partner_object = get_field('acf_feature_partner');
    $partner_id = $partner_object->ID;
    $sponsor_name = $partner_object->post_title;
    $sponsor_image = get_the_post_thumbnail_url($partner_id);
    $sponsor_website = strtolower(get_field('acf_partner_website', $partner_id));
    $partner_linkedin = strtolower(get_field('acf_partner_linkedin', $partner_id));
    $partner_twitter = strtolower(get_field('acf_partner_twitter', $partner_id));
    $partner_facebook = strtolower(get_field('acf_partner_facebook', $partner_id));
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$articles_args = [
    'post_type' => 'post',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'meta_query' => [
        'relation' => 'AND',
        [
            'key' => 'acf_article_type',
            'value' => 'feature',
            'compare' => '=',
        ],
        [
            'key' => 'acf_article_feature',
            'value' => $post_id,
            'compare' => '=',
        ],
    ],
    'order' => 'DESC',
    'orderby' => 'date',
    'paged' => $paged,
];
$wp_query = null;
$wp_query = new WP_Query($articles_args);
$conditional_margin_css = '';
if ($wp_query->post_count == 0) {
    $conditional_margin_css = 'entity-content--no-margin-top';
}
?>

		<div class="entity-header entity-row row entity-header--gray">
			<div>
					<div class="col-md-2 col-sm-3 col-xs-5 text-center">
						<?php if ($is_partner) { ?>
							<span class="entity-header__sponsor-cat-name"><?php echo esc_html($page_partner_report_title); ?></span>
						<?php }?>
						<?php if ($sponsor_image) { ?>

						<figure class="entity-header__figure entity-header__figure--noRadius">
							<?php if ($is_partner) { ?>
								<img class="entity-header__image" src="<?php echo esc_url($sponsor_image); ?>" alt="<?php echo wp_kses_post($sponsor_name); ?>">
						<?php } else { ?>
							<img class="entity-header__image" src="<?php echo esc_url($sponsor_image['url']); ?>" alt="<?php echo wp_kses_post($sponsor_name); ?>">
					<?php }?>
						</figure>
						<div class="entity-header__presentedBy">
							<?php if ($is_partner) { ?>
								<span class="entity-header__presentedBy-text">
									<?php printf(_x('By %s', 'By name of partner (single feature)', 'avatar-tcm'), $sponsor_name); ?>
								</span>
							<?php } else { ?>
								<span class="entity-header__presentedBy-text">
									<?php printf(_x('Presented by %s', 'By name of sponsor (single feature)', 'avatar-tcm'), $sponsor_name); ?>
								</span>
							<?php }?>
						</div>
						<?php } ?>
						<div class="entity-header__infos">
							<?php if ($sponsor_website || $partner_twitter || $partner_facebook) { ?>
							<dl class="social-icons">

								<?php if ($partner_linkedin) { ?>
									<dd>
										<a class="lkin" target="_blank" href="<?php echo esc_url($partner_linkedin); ?>">
											<span><?php _e('LinkedIn', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
								<?php if ($partner_twitter) { ?>
									<dd>
										<a class="twt" target="_blank" href="<?php echo esc_url($partner_twitter); ?>">
											<span><?php _e('Twitter', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
								<?php if ($partner_facebook) { ?>
									<dd>
										<a class="fb" target="_blank" href="<?php echo esc_url($partner_facebook); ?>">
											<span><?php _e('Facebook', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
							</dl>
							<?php }?>
							<?php if ($sponsor_website) { ?>
								<a target="_blank" href="<?php echo esc_url($sponsor_website); ?>">
									<?php _e('Visit website', 'avatar-tcm'); ?>
								</a>
							<?php }?>
						</div>
					</div>
					<div class="entity-header__landing-box entity-header__landing-box--negative-margin col-md-6 col-sm-9 col-xs-7">
						<h1 class="entity-header__name <?php echo get_locale(); ?>"><?php the_title(); ?></h1>
						<div class="text-content text-content__excerpt text-content__excerpt--text-lightest">
							<?php the_content(); ?>
							<?php if ($acf_feature_date) { ?>
								<span class="entity-header__date">
									<?php echo date_i18n(get_option('date_format'), strtotime(get_date_from_gmt(date('Y-m-d H:i:s', $acf_feature_date), 'Y-m-d H:i:s'))); ?>
								</span>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<?php get_template_part('templates/article/article-entity-share', 'top'); ?>
					</div>
			</div>
		</div>
	</header>
	<div class="entity-content <?php echo esc_attr($conditional_margin_css); ?> row equal-col-md">
		<section class="col-md-8">
			<div class="row row--no-margin">
				<div class="col-md-9 col-md-offset-3 col-sm-12 ?>">
					<div class="row">
						<div class="entity-box-listing col-xs-12 <?php if ($is_partner) { ?> sponsor-bg <?php }?>" >
							<div id="js-regular-listing-container">
								<?php if ($wp_query->have_posts()) { ?>
									<?php while ($wp_query->have_posts()) {
									    $wp_query->the_post(); ?>
										<div class="js-regular-listing">
											<div class="text-content text-content--border-top">
												<h2 class="text-content__title text-content__title--big icons  <?php echo avatar_article_get_icon(get_the_ID()); ?>" ><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
												<p class="text-content__excerpt"><?php echo get_the_excerpt(); ?></p>
												<ul class="pub-details">
													<?php
									                    avatar_display_post_source(get_the_ID(), $single = false);
									    avatar_display_post_date(get_the_ID(), $single = false);
									    ?>
												</ul>
											</div>
										</div>
									<?php }  ?>
								<div class="pagination">
									<?php next_posts_link('Older Entries', $wp_query->max_num_pages); ?>
								</div>
								<?php } else { ?>
									<?php
                                    _e('There is currently no post for this feature', 'avatar-tcm'); ?>
								<?php } ?>

							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
		<aside class="col-md-4 primary">
			<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
				<?php
                    at_get_the_m32banner(
                        $arr_m32_vars = [
                            'kv' => [
                                'pos' => [
                                    'atf',
                                    'but1',
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
			<?php if ($is_partner) { ?>
				<div class="sponsor-black-box col-sm-6 col-md-12">
					<p class="sponsor-black-box__title partner-title">
						<?php echo esc_html(get_field('acf_in_depth_partner_report_info_title', 'option')); ?>
					</p>
					<p class="sponsor-black-box__description">
						<?php echo esc_html(get_field('acf_in_depth_partner_report_info_desc', 'option')); ?>
					</p>
				</div>
			<?php } else { ?>
				<?php include locate_template('templates/category/component-partner-report.php'); ?>
			<?php } ?>
		</aside>
	</div>

	<div class="row">
		<section id="entity-footer" class="col-md-8">
			<?php include locate_template('templates/category/latest-in-depth.php'); ?>
		</section>
		<aside class="col-md-4 text-center">
			<?php //echo at_get_m32_bigbox(); // @see AVAIE-1557?>
		</aside>
	</div>
</section>
<?php get_footer(); ?>