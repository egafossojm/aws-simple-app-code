<?php
/**
 * Template Name: In Depth : SubPage
 *
 * The template for displaying feature CPT in 'In Depth'
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php get_header();
$avatar_indepth_page_id = get_the_ID();
$avatar_indepth_partner_report_id = get_field('acf_in_depth_partner_report', 'option');
$avatar_is_partner_report = ($avatar_indepth_partner_report_id == $avatar_indepth_page_id) ? true : false;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$articles_args = [
    'post_type' => 'feature',
    'post_status' => 'publish',
    'meta_query' => [

        'subcat' => [
            'key' => 'acf_feature_parent_sub_category',
            'value' => $avatar_indepth_page_id,
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
    'paged' => $paged,
    'posts_per_page' => 12,
];

$wp_query = new WP_Query($articles_args);

$row_extra_class = $avatar_is_partner_report ? esc_attr('row--sponsorPad') : '';
$bg_extra_class = $avatar_is_partner_report ? esc_attr('sponsor-bg') : '';

?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main">
			<section class"row">
				<?php if ($avatar_is_partner_report) { ?>
					<div class="landing-sponsor <?php echo esc_attr($bg_extra_class); ?>">
						<div class="row <?php echo esc_attr($row_extra_class); ?>">
							<div class="col-sm-3">
								<p class="sponsor-title sponsor-title--landing">
									<?php echo esc_html(get_field('acf_in_depth_partner_report_info_title', 'option')); ?>
									<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
								</p>
							</div>
							<div class="col-sm-9">
								<p class="landing-sponsor__description">
									<?php echo esc_html(get_field('acf_in_depth_partner_report_info_desc', 'option')); ?>
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
			</section>
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
				<?php
                    if ($avatar_is_partner_report) {
                        include locate_template('templates/category/component-partner-report-recommended.php');
                    }
?>


					<h1 class="bloc-title <?php if ($avatar_is_partner_report == false) {
					    echo 'bloc-title--no-margin-bottom';
					} ?>">
						<span class="bloc-title__text--color"><?php _e('Latest', 'avatar-tcm'); ?> </span>
						<span><?php echo get_the_title($avatar_indepth_page_id); ?></span>
					</h1>
					<div id="js-regular-listing-container" class="<?php echo esc_attr($row_extra_class).' '.esc_attr($bg_extra_class); ?>">
					<?php
					    if ($wp_query->have_posts()) {
					        $i = 0;
					        $total_posts = count($wp_query->posts); ?>
							<div class="row js-regular-listing category-regular-listing">

							<?php while ($wp_query->have_posts()) {
							    $wp_query->the_post();
							    if ($i > 1) {
							        $text_content_extra_class = 'text-content--border-top';
							    } else {
							        $text_content_extra_class = '';
							    }
							    if ($i % 2 == 0) {
							        $conditional_col = 'col-md-6 col-sm-6';
							    } else {
							        $conditional_col = 'col-md-6 col-sm-6';
							    }
							    ?>
								<div id="post-<?php the_ID(); ?>" <?php post_class($conditional_col); ?>>
									<div>
										<div class="text-content <?php echo esc_attr($text_content_extra_class); ?>">
											<?php if (has_post_thumbnail()) { ?>
												<figure>
													<a class="text-content__link" href="<?php the_permalink(); ?>">
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
							<?php $i++;
							} ?>
								</div>
								<div class="pagination">
									<?php next_posts_link('Older Entries', $wp_query->max_num_pages); ?>
								</div>
						<?php } else { ?>
							<?php _e('No Feature Posts found.', 'avatar-tcm'); ?>
						<?php } ?>

					</div>
				</div>
				<aside class="col-md-4 primary">
                	<?php //include Quick subscribe newsletters component
							 avatar_include_subscription_module();
?>
					<?php if ($avatar_is_partner_report == false) { ?>
						<?php include locate_template('templates/category/component-partner-report.php'); ?>
					<?php }?>

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