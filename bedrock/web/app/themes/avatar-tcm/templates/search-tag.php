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

// Manage exception depending of the type of taxonomy term searched
switch (get_taxonomy(get_queried_object()->taxonomy)->name) {
    // Exceptions for default WordPress 'tag' -> 'Keywords'
    case 'post_tag':
        $avatar_tag_name = __('Keyword: %s', 'avatar-tcm');

        $object = get_term_by('name', single_tag_title('', false), 'post_tag');
        $sponsor_id = get_field('acf_keyword_sponsor', $object);

        $sponsor = get_term($sponsor_id, 'post_sponsor');
        // Add 'External link' to object
        $sponsor->{'external_link'} = get_field('acf_sponsor_external_link', $sponsor->taxonomy.'_'.$sponsor->term_id);
        // Add 'Logo' to object
        $sponsor->{'logo'} = get_field('acf_sponsor_logo', $sponsor->taxonomy.'_'.$sponsor->term_id);

        break;

        // Exceptions for custom taxonomy 'post_company' -> 'Company'
    case 'post_company':
        $avatar_tag_name = __('Company: %s', 'avatar-tcm');
        break;

        // Default case: any tag
    default:
        $avatar_tag_name = __('Tag: %s', 'avatar-tcm');
        break;
}
?>
<section class="single-cpt">
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
						<div class="text-content text-content__excerpt text-content__excerpt--text-lightest no-padding-top-xs">
							<span>
								<?php printf(_n('%s result found', '%s results found', $wp_query->found_posts, 'avatar-tcm'), $wp_query->found_posts); ?>
							</span>
						</div>
					</div>
						<div class="col-sm-4">
							<?php if ($sponsor->{'logo'} != '') { ?>
							<figure class="sponsor-bloc">
								<figcaption><?php _e('This topic is brought to you by', 'avatar-tcm'); ?></figcaption>
								<!--sponsor link and logo-->
								<a href="<?php echo $sponsor->{'external_link'}; ?>"><img src="<?php echo $sponsor->{'logo'}['sizes']['thumbnail']; ?>" alt="<?php echo $sponsor->name; ?>"></a>  
                            </figure>
                        <?php } ?>
								
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
						<div class="entity-box-listing col-xs-12" >
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
								    ?>
								<div class="js-regular-listing">
									<div class="text-content text-content--border-top">
										<?php if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
											<figure class="text-content__figure-right text-content__figure-right--search-results list-img">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail($size = 'thumbnail', $attr = ['class' => 'img-responsive']); ?>
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
								               avatar_display_post_author($post_id, $single = false);
								    avatar_display_post_source($post_id, $single = false);
								    avatar_display_post_date($post_id, $single = false);
								    ?>
										</ul>
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
include locate_template('templates/general/component-cxense-most.php'); ?>

     	    		<?php //include tools and resources component
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
            'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
        ]
    );
?>
     			</aside>
	</div>
</section>
<?php get_footer(); ?>