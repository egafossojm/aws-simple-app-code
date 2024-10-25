<?php
/**
 * Template Name: Inside Track: IndexPage
 *
 * This is the template that displays Inside Track section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php get_header(); ?>
<?php
$page_id = (get_query_var('paged')) ? get_query_var('paged') : 1;
//order inside track
$avatar_columnist_args = [
    'post_type' => 'writer',
    'post_status' => 'publish',
    'paged' => $page_id,
    'posts_per_page' => 5,
    'orderby' => 'ID',
    'meta_query' => [
        'relation' => 'AND',
        'is_columnist' => [
            'key' => 'acf_author_is_columnist',
            'value' => 1,
        ],
        'author_published_date' => [
            'key' => 'acf_author_published_date',
        ],
    ],
    'orderby' => [
        'author_published_date' => 'DESC',
    ],
];

$avatar_columnists = new WP_Query($avatar_columnist_args);
?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="homepage" >
			<section class="row equal-col-md">
				<div class="col-md-8 left-content">
					<h1 class="bloc-title bloc-title--no-margin-bottom">
						<?php printf('<span class="bloc-title__text--color">'.__('Latest columns in', 'avatar-tcm').'</span> %s', get_the_title()); ?>
					</h1>
                    <div id="js-regular-listing-container" class="columnist-listing">
					<?php
                    if ($avatar_columnists->have_posts() && $avatar_columnists->post_count !== 0) {
                        while ($avatar_columnists->have_posts()) {
                            $avatar_columnists->the_post();
                            $columnist_id = $avatar_columnists->ID;
                            $columns = get_term(get_field('acf_author_column'), 'post_column');
                            ?>
                         <?php
                                 $IsCIRExperts = strtoupper($columns->name) == 'CANADIAN INVESTMENT REVIEW EXPERTS';
                            ?>
						 <div class="js-regular-listing">
							<div class="col-md-12">
								<div class="row columnist-listing__head columnist-listing__head--small">
									<div class="col-sm-8 col-xs-12">
										<figure class="entity-figure ">
											<a href="<?php the_permalink(); ?>"><img class="entity-header__image" src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail'); ?>" alt="<?php avatar_the_post_thumbnail_alt($post_id); ?>" >></a>
										</figure>
										<div class="entity-title wide show" >
												<?php if (! is_wp_error($columns)) { ?>
												<span class="entity-title__tag entity-title__tag--color"><?php echo wp_kses_post($columns->name); ?></span>
											<?php } ?>

											<h2 class="entity-title__name"><a class="entity-title__link entity-title__link--black" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										</div>
									</div>
									<div class="col-sm-4 hidden-xs">
										<?php if ($IsCIRExperts) {?>
											<figure class="entity-figure ">
												<a href="/investments/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CIR.png" class="img-responsive" title="CIR" alt="CIR"></a>
											</figure>										
										<?php } ?>									
										<span class="entity-row__link-top"><a class="entity-row__link-top-text entity-row__link-top-text--color" href="<?php the_permalink(); ?>"><?php _e('All columns', 'avatar-tcm'); ?></a><i class="bloc-title__caret bloc-title__caret--small fa fa-caret-right" aria-hidden="true"></i></span>
									</div>
								</div>
							</div>

						<div  class="row">
							<?php
                                   $curr_author_id = get_the_ID();
                            $articles_args = [
                                'post_type' => 'post',
                                'posts_per_page' => 4,
                                'meta_query' => [
                                    [
                                        'key' => 'acf_article_author',
                                        'value' => '"'.$curr_author_id.'"',
                                        'compare' => 'LIKE',
                                    ],
                                ],
                                'orderby' => 'date',
                            ];
                            $i = 0;
                            $articles = new WP_Query($articles_args);
                            if ($articles->have_posts()) {
                                while ($articles->have_posts()) {
                                    $articles->the_post();
                                    $curr_post_id = get_the_ID();
                                    ?>
							<?php $i++; ?>
							<?php if ($i == 1) { ?>
								<div class="col-sm-6 col-no-padding-right">
								<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
									<figure>
										<a href="<?php the_permalink(); ?>">
											<div class="top-image text-content no-padding-bottom">
												<?php the_post_thumbnail($size = 'large', $attr = ['class' => 'img-responsive']); ?>
											</div>
										</a>
									</figure>
								<?php }?>
									<div class="text-content no-padding-bottom">
										<h3 class="text-content__title text-content__title--big"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="text-content__excerpt">
											<?php
                                                        if (has_excerpt()) {
                                                            echo wp_trim_words(get_the_excerpt(), 25);
                                                        } else {
                                                            echo strip_shortcodes(wp_trim_words(get_the_content(), 25));
                                                        }
							    ?>
										</p>
										<ul class="pub-details">
											<?php avatar_display_post_source($curr_post_id, $single = false); ?>
											<?php avatar_display_post_date($curr_post_id, $single = false); ?>
										</ul>
									</div>
								</div>
								<div class="col-sm-6">
									<?php }  ?>
									<?php if ($i > 1) { ?>
										<div>
											<div class="text-content no-padding-bottom">
												<h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
												<p class="text-content__excerpt">
													<?php
							                if (has_excerpt()) {
							                    echo wp_trim_words(get_the_excerpt(), 25);
							                } else {
							                    echo strip_shortcodes(wp_trim_words(get_the_content(), 25));
							                }
									    ?>
												</p>
												<ul class="pub-details">
													<?php avatar_display_post_source($curr_post_id, $single = false); ?>
													<?php avatar_display_post_date($curr_post_id, $single = false); ?>
												</ul>
											</div>

										</div>
									<?php } ?>
								<?php }   wp_reset_postdata(); ?>
								</div>
					<?php }?>
					</div>
                    </div>


					<?php }  wp_reset_postdata(); ?>
					<?php } else { ?>
						<p><?php _e('There is currently no post', 'avatar-tcm'); ?></p>
					<?php } ?>
                    </div><!-- .entity-content -->
                    <div class="pagination">
                        <?php next_posts_link(_e('Next Page', 'avatar-tcm'), $avatar_columnists->max_num_pages); ?>
                   </div>

				</div><!-- .entity-listing"-->

				<aside class="primary col-md-4">
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
                'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
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
					<?php
    // Include Microsite Block
    avatar_include_template_conditionally('templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
//include tools and resources component
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
                'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12 stick',
            ]
        );
?>

				</aside>

			</section>

		</main><!-- #main -->

	</div><!-- #primary -->

</div><!-- .wrap -->
<?php get_footer(); ?>