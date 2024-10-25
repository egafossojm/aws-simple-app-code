<?php
global $current_user;
$site_id = get_current_blog_id();
if ($site_id != 4 && $site_id != 5 && $site_id != 6 && $site_id != 7) {
    if (! is_user_logged_in()) {
        $user_redirect_to = get_field('acf_footer_page_newspaper_login', 'options') ? get_page_link(get_field('acf_footer_page_newspaper_login', 'options')) : home_url();
        wp_redirect($user_redirect_to);
        exit;
    } elseif (! avatar_user_have_access()) {

        $user_redirect_to = get_field('acf_profile_newspaper', 'options') ? get_page_link(get_field('acf_profile_newspaper', 'options')) : home_url();
        wp_redirect($user_redirect_to);
        exit;
    }
}
?>
<?php get_header();

// Get the last Newspaper Date
$newspaper_id = get_the_id();

$newspaper_cat_ids = avatar_get_all_category_newspaper_cpt($newspaper_id);
?>
<section class="single-cpt">
	<header>
		<div class="entity-header entity-header--citybg entity-row row">
			<div class="col-md-2 col-sm-4 col-xs-4 text-center">

				<div class="entity-header__backissues">
					<?php if (has_post_thumbnail($newspaper_id)) { ?>
						<figure>
							<?php
                            $newspaper_url = trim(get_field('acf_newspaper_thumbnail_url', $newspaper_id));
					    if ($newspaper_url != '') {
					        echo '<a target="_blank" href="'.$newspaper_url.'">';
					    }
					    echo get_the_post_thumbnail($newspaper_id, 'thumbnail', ['class' => 'img-responsive']);
					    if ($newspaper_url != '') {
					        echo '</a>';
					    }
					    ?>
						</figure>
					<?php } ?>
				</div>
			</div>
			<div class="entity-header__landing-box entity-header__landing-box--backissue col-md-10 col-sm-8 col-xs-8">
				<h1 class="entity-header__name entity-header__name--no-border-bottom entity-header__name--backissue">
					<?php echo get_the_title($newspaper_id); ?>
				</h1>

				<div class="list-filter__newspaper">
					<form id="js_newspaper_date_form" class="form-inline" action="">
						<div class="form-group">
							<div class="super-select">
								<span class="styler"></span>
								<select id="js_newspaper_years" class="avatar-topic-select avatar-topic-select--black-on-white" name="">
								<option disable value=""><?php _e('Year', 'avatar-tcm'); ?></option>
								<?php
					        $newspaper_name = get_field('acf_newspaper_type', $newspaper_id);
$high_year = ($newspaper_name !== '') && ($newspaper_name !== null) ? avatar_get_first_year_by_type_high($newspaper_name) : date('Y');
$low_year = ($newspaper_name !== '') && ($newspaper_name !== null) ? avatar_get_first_year_by_type($newspaper_name) : avatar_get_first_year();
if ($high_year >= $low_year) {
    for ($k = $high_year, $i = $low_year; $i <= $k; $k--) {
        if (($newspaper_name !== '') && ($newspaper_name !== null)) {
            if (avatar_is_year_by_type_exist($k, $newspaper_name) != $k) {
                continue;
            }
        }
        echo '<option data-newspaper="'.esc_attr($k).'"  value="'.esc_attr($k).'">'.esc_attr($k).'</option>';
    }
} ?>

							</select>
							</div>
						</div>

						<div class="form-group">
							<div class="super-select">
								<span class="styler"></span>
								<select disabled="disabled" id="js_newspaper_month" class="avatar-topic-select avatar-topic-select--black-on-white" name="">
									<option value=""><?php _e('Month', 'avatar-tcm'); ?></option>;
								</select>
							</div>
						</div>
						<button disabled="disabled" type="submit" class="js_newspaper_btn std-btn"><?php esc_attr_e('Find Issue', 'avatar-tcm'); ?></button>
					</form>
				</div>
			</div>
		</div>
	</header>
	<div class="entity-content row equal-col-md">
		<section class="col-md-8">
			<div class="row row--no-margin">
				<div class=" col-md-9 col-md-offset-3">
					<div class="row">

					<?php foreach ($newspaper_cat_ids as $cat_id => $cat_pos) { ?>
						<?php
                            $wp_query_newspaper_arg = [
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 20,
                                'cat' => $cat_id,
                                'meta_query' => [
                                    [
                                        'key' => 'acf_article_newspaper',
                                        'value' => $newspaper_id,
                                        'compare' => '=',
                                    ],
                                ],
                            ];
					    $wp_query_newspaper = new WP_Query($wp_query_newspaper_arg);
					    $newspaper_name = get_field('acf_newspaper_type', $newspaper_id);
					    ?><!-- start <?php echo esc_attr($cat_id).'_'.esc_attr($cat_pos); ?> category -->
						<?php if ($wp_query_newspaper->have_posts() && $wp_query_newspaper->post_count !== 0) { ?>
							<div class="entity-box-listing entity-box-listing--multi-category col-xs-12" >
								<div id="js-regular-listing-container" >
									<h2 class="backissues-title"><span><?php echo get_cat_name($cat_id); ?></span></h2>
										<?php while ($wp_query_newspaper->have_posts()) {
										    $wp_query_newspaper->the_post(); ?>
											<div class="text-content text-content--border-top">
												<h2 class="text-content__title text-content__title--big icons title-article-author <?php echo avatar_article_get_icon(get_the_ID()); ?>" >
													<a class="text-content__link"  href="<?php the_permalink(); ?>">
														<?php the_title(); ?>
													</a>
												</h2>
												<p class="text-content__excerpt">
													<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
												</p>
											</div>
											<!-- end post <?php echo get_the_ID(); ?>-->
									<?php } ?>
									<?php wp_reset_postdata(); ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<!-- end <?php echo esc_attr($cat_id).'_'.esc_attr($cat_pos); ?> category -->
					</div>
				</div>
			</div>
		</section>
		<aside class="col-md-4 primary text-center">
        	<?php //include Quick subscribe newsletters component
                avatar_include_subscription_module();
?>
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
			<?php //include Cxense most popular/shared component
            include locate_template('templates/general/component-cxense-most.php'); ?>
		</aside>
	</div>
	<div class="row">
		<?php include locate_template('templates/general/component-latest-newspaper-issues.php'); ?>
		<div class="pagination">
			<?php next_posts_link(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>