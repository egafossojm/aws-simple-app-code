<?php

/**
 * Template Name: Newspaper: IndexPage
 *
 * This is the template that displays Newspaper(backissues) section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
global $current_user;

$site_id = get_current_blog_id();

error_log('SITEID: '.$site_id);
if ($site_id != 4 && $site_id != 5 && $site_id != 6 && $site_id != 7) {
    if (! is_user_logged_in()) {
        $user_redirect_to = get_field('acf_footer_page_newspaper_login', 'options') ? get_page_link(get_field('acf_footer_page_newspaper_login', 'options')) : home_url();
        error_log('Redirect to 1: '.$user_redirect_to);
        wp_redirect($user_redirect_to);
        exit;
    } elseif (! avatar_user_have_access()) {
        $user_redirect_to = get_field('acf_profile_newspaper', 'options') ? get_page_link(get_field('acf_profile_newspaper', 'options')) : home_url();
        error_log('Redirect to 2: '.$user_redirect_to);
        wp_redirect($user_redirect_to);
        exit;
    }
}
$post_id = get_the_ID();
get_header();

// Get the last Newspaper Date
$newspaper_args = [
    'post_type' => 'newspaper',
    'post_status' => 'publish',
    'posts_per_page' => 1,
];

$newspaper_obj = new WP_Query($newspaper_args);
$newspaper_id = $newspaper_obj->posts[0]->ID;

$newspaper_cat_ids = avatar_get_all_category_newspaper_cpt($newspaper_id);

$parent_post_id = wp_get_post_parent_id($post_id);
$useType = false;
if ($parent_post_id !== false) {
    $parent_post = get_post($parent_post_id);
    if ($parent_post->post_name === 'magazine-archives') {
        $useType = true;
        $newspaper_id = $post_id;

        $main_cat_id = get_field('acf_newspaper_main_cat', 'option');
        $list_category = get_categories(['parent' => $main_cat_id]);

        $post = get_post($post_id);
        if (! empty($post)) {
            $slug = $post->post_name;
            $newspaper_name = $post->post_title;
        }
        foreach ($list_category as $category) {
            if (str_replace('_', '', $category->slug) === $slug) {
                $cat_id = $category->cat_ID;
            }
        }

        $newspaper_cat_ids = ($cat_id === '') || ($cat_id === null) ? [] : [$cat_id => 99];
        $newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'post_date',
            'order' => 'DESC',

            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'acf_newspaper_type',
                    'value' => $newspaper_name,
                    'compare' => '=',
                ],
            ],
        ];

        $newspaper_obj = new WP_Query($newspaper_args);
        $newspaper_id = $newspaper_obj->posts[0]->ID;
    }
}
?>
<section class="single-cpt">
	<header>
		<div class="entity-header entity-header--citybg entity-row row" style="background: url(<?php the_post_thumbnail_url(); ?> );">
			<div class="col-md-2 col-sm-4 col-xs-4 text-center">

				<div class="entity-header__backissues">
					<?php if ($newspaper_obj->have_posts()) {  ?>
						<?php while ($newspaper_obj->have_posts()) {
						    $newspaper_obj->the_post(); ?>
							<?php if (has_post_thumbnail()) { ?>
								<figure>
									<?php
						            $newspaper_url = trim(get_field('acf_newspaper_thumbnail_url', $newspaper_id));
							    if ($newspaper_url != '') {
							        echo '<a target="_blank" href="'.$newspaper_url.'">';
							    }
							    the_post_thumbnail('thumbnail', ['class' => 'img-responsive']);
							    if ($newspaper_url != '') {
							        echo '</a>';
							    }
							    ?>
								</figure>
							<?php } ?>
						<?php } ?>
					<?php }
					wp_reset_postdata(); ?>
				</div>
			</div>
			<div class="entity-header__landing-box entity-header__landing-box--backissue col-md-10 col-sm-8 col-xs-8">
				<span class="entity-title__tag entity-title__tag--big">
					<?php switch ($site_id) {
					    case 6:
					        echo 'Dernier magazine paru';
					        break;
					    case 5:
					        echo 'Latest issue';
					        break;
					    case 4:
					        echo 'Dernière édition';
					        break;
					    case 7:
					        echo 'Latest issue of the magazine';
					        break;
					    default:
					        _e('Latest issue of the newspaper', 'avatar-tcm');
					        break;
					}
?>
				</span>
				<h1 class="entity-header__name entity-header__name--no-border-bottom entity-header__name--backissue">
					<?php echo get_the_title($newspaper_id); ?>
				</h1>

				<div class="list-filter__newspaper">
					<?php if (isset($slug) && $slug !== '') { ?>
						<input type="hidden" name="newspaper_type" id="newspaper_type" value="<?php echo $slug; ?>" />
						<input type="hidden" name="newspaper_name" id="newspaper_name" value="<?php echo $newspaper_name; ?>" />
						<input type="hidden" name="newspaper_cat_id" id="newspaper_cat_id" value="<?php echo $cat_id; ?>" />
					<?php } ?>
					<form id="js_newspaper_date_form" class="form-inline" action="">
						<div class="form-group">
							<div class="super-select">
								<span class="styler"></span>
								<select id="js_newspaper_years" class="avatar-topic-select avatar-topic-select--black-on-white" name="">
									<option disable value=""><?php esc_attr(_e('Year', 'avatar-tcm')); ?></option>
									<?php
                $high_year = isset($slug) && $slug !== '' && ($slug !== null) ? avatar_get_first_year_by_type_high($newspaper_name) : date('Y');
$low_year = isset($slug) && ($slug !== '') && ($slug !== null) ? avatar_get_first_year_by_type($newspaper_name) : avatar_get_first_year();
if ($high_year >= $low_year) {
    for ($k = $high_year, $i = $low_year; $i <= $k; $k--) {
        if (isset($slug) && ($slug !== '') && ($slug !== null)) {
            if (avatar_is_year_by_type_exist($k, $newspaper_name) != $k) {
                continue;
            }
        }
        echo '<option data-newspaper="'.$k.'"  value="'.$k.'">'.$k.'</option>';
    }
} ?>

								</select>
							</div>
						</div>

						<div class="form-group month">
							<div class="super-select">
								<span class="styler"></span>
								<select disabled="disabled" id="js_newspaper_month" class="avatar-topic-select avatar-topic-select--black-on-white" name="">
									<option value=""><?php esc_attr(_e('Month', 'avatar-tcm')); ?></option>;
								</select>
							</div>
						</div>
						<button disabled="disabled" type="submit" class="js_newspaper_btn std-btn"><?php esc_attr(_e('Find Issue', 'avatar-tcm')); ?></button>
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

						<?php
                        if (count($newspaper_cat_ids) > 0) {
                            foreach ($newspaper_cat_ids as $cat_id => $cat_pos) { ?>
							<?php
                                /*if($useType) {
                                    $wp_query_newspaper_arg = array(
                                        'post_type' => 'post',
                                        'post_status' => 'publish',
                                        'posts_per_page'=> 20,
                                        'cat' 		=> $cat_id,
                                    );
                                } else {*/
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
                                //}
                                $wp_query_newspaper = new WP_Query($wp_query_newspaper_arg);
                                ?>
							<!-- start <?php echo esc_attr($cat_id).'_'.esc_attr($cat_pos); ?> category -->
							<?php if ($wp_query_newspaper->have_posts() && $wp_query_newspaper->post_count !== 0) { ?>
								<div class="entity-box-listing entity-box-listing--multi-category col-xs-12">
									<div id="js-regular-listing-container">
										<h2 class="backissues-title"><span><?php echo get_cat_name($cat_id); ?></span></h2>
										<?php while ($wp_query_newspaper->have_posts()) {
										    $wp_query_newspaper->the_post(); ?>
											<div class="text-content text-content--border-top">
												<h2 class="text-content__title text-content__title--big icons title-article-author <?php echo avatar_article_get_icon(get_the_ID()); ?>">
													<a class="text-content__link" href="<?php the_permalink(); ?>">
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
								<div class="magazine-unsubscribe-text col-xl-12">
									<?php

                                    switch (get_locale()) {
                                        case 'fr_CA':
                                            ?>
											<p>
												Pour vous désabonner du magazine imprimé :<br>
												Courriel : <a href="mailto:benefitscanada@kckglobal.com">benefitscanada@kckglobal.com</a><br>
												Téléphone : <a href="tel:1-800-361-7215">1-800-361-7215</a>
											</p>
										<?php
                                                    break;
                                        case 'en_US':
                                            ?>
											<p>
												To unsubscribe from the print magazine:<br>
												Email <a href="mailto:benefitscanada@kckglobal.com">benefitscanada@kckglobal.com</a><br>
												Call <a href="tel:1-800-361-7215">1-800-361-7215</a>
											</p>
										<?php
                                                break;
                                        default:
                                            ?>
											<p>
												To unsubscribe from the print magazine:<br>
												Email <a href="mailto:benefitscanada@kckglobal.com">benefitscanada@kckglobal.com</a><br>
												Call <a href="tel:1-800-361-7215">1-800-361-7215</a>
											</p>
									<?php
                                                break;
                                    }
							    ?>
								</div>
							<?php } ?>
						<?php }
                            } ?>
						<!-- end <?php echo esc_attr($cat_id).'_'.esc_attr($cat_pos); ?> category -->
					</div>
				</div>
			</div>
		</section>
		<aside class="col-md-4 primary">
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
                    'top_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [320,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center',
        ]
    );
?>
			</div>

			<?php //include Cxense most popular/shared component
            include locate_template('templates/general/component-cxense-most.php');
?>

			<?php include locate_template('templates/tools/component-tools-and-ressources.php'); ?>
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
        'sizeMapping' => '[ [[0,0], [[320,50], [320,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
    ],
    $arr_avt_vars = [
        'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
    ]
);
?>
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
