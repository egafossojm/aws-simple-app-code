<?php
/**
 * Template Name: Magazine archive Landing
 *-magazine archives landing page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
$site_id = get_current_blog_id();
get_header(); ?>
	<div class="wrap">
	<div id="primary" class="content-area tools-section">
		<main id="main">
			<div class="row">
                <div class="col-sm-12">
                    <h1 class="bloc-title bloc-title--no-margin-bottom">
                        <span><?php the_title(); ?></span>
                    </h1>
                </div>
			</div>
			<section class="row equal-col-md dual-col">
				<div class="col-md-8 left-content">
					<?php
                    $main_cat_id = get_field('acf_newspaper_main_cat', 'option');
$list_category = get_categories(['parent' => $main_cat_id]);

for ($i = 0; $i <= 1; $i++) {
    $newspaper_args = [
        'post_type' => 'newspaper',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'order' => 'DESC',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'acf_newspaper_type',
                'value' => $list_category[$i]->name,
                'compare' => '=',
            ],

        ],
    ];

    $newspaper_obj = new WP_Query($newspaper_args);
    ?>
						
							<div class="row bloc">
								<div class="col-md-12">
									<h2><?php echo $list_category[$i]->cat_name; ?></h2>
								</div>
								<div class="col-md-12">
									<div class="bg">
										<div class="row">
												<figure class="col-sm-3 thumb">
													<a href="<?php echo str_replace('_', '/', $list_category[$i]->slug); ?>">
														<?php echo get_the_post_thumbnail($newspaper_obj->posts[0]->ID, 'full', ['class' => 'img-responsive']); ?>
													</a>
												</figure>
											<div class="col-sm-9 text">
												<p><?php
                            switch ($i) {
                                case 0:echo 'Focuses on trends and strategies for successful advisors.';
                                    break;
                                case 1:echo 'Provides perspective on industry news and analysis of wealth management products.';
                                    break;
                            }
    ?></p>
												<a href="<?php echo str_replace('_', '/', $list_category[$i]->slug); ?>" class="btn user-form__btn-submit">
													<?php
        switch ($site_id) {
            case 5:echo 'view articles';
                break;
            default:echo 'click here';
                break;
        } ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						
					<?php } ?>
					<?php
                    $newspaper_page_id = $newspaper_page_id_list[1];
$newspaper_args = [
    'post_id' => $newspaper_page_id_list[1],
    'post_type' => 'newspaper',
    'post_status' => 'publish',
    'posts_per_page' => 1,
];
$newspaper_obj = new WP_Query($newspaper_args);
//var_dump($newspaper_obj);
?>
				</div>
				<aside class="primary col-md-4">
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
            'sizeMapping' => '[ [[0,0], [[320,50], [320,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
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