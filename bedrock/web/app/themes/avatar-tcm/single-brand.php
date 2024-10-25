<?php get_header(); ?>

<section class="single-cpt">
	<header>
		<?php
        $post_id = get_the_ID();
$avatar_topics = avatar_get_all_topics_brand_cpt($post_id);
$sponsor_image = get_the_post_thumbnail_url($post_id);
$sponsor_name = get_the_title();
$sponsor_website = strtolower(get_field('acf_brand_website', $post_id));
$sponsor_linkedin = strtolower(get_field('acf_brand_linkedin', $post_id));
$sponsor_twitter = strtolower(get_field('acf_brand_twitter', $post_id));
$sponsor_facebook = strtolower(get_field('acf_brand_facebook', $post_id));
$avatar_brand_id = (isset($_REQUEST['avatar_topic_id']) && ! empty($_REQUEST['avatar_topic_id'])) ? $_REQUEST['avatar_topic_id'] : false;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if ($avatar_brand_id) {

    $avatar_brand_args = [
        'post_type' => 'post',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'acf_article_type',
                'value' => 'brand',
                'compare' => '=',
            ],
            [
                'key' => 'acf_article_brand',
                'value' => $post_id,
                'compare' => '=',
            ],
            [
                'key' => 'acf_article_brand_topic',
                'value' => $avatar_brand_id,
                'compare' => '=',
            ],
        ],
        'order' => 'DESC',
        'orderby' => 'date',
        'paged' => $paged,
    ];
} else {

    $avatar_brand_args = [
        'post_type' => 'post',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'acf_article_type',
                'value' => 'brand',
                'compare' => '=',
            ],
            [
                'key' => 'acf_article_brand',
                'value' => $post_id,
                'compare' => '=',
            ],
        ],
        'order' => 'DESC',
        'orderby' => 'date',
        'paged' => $paged,
    ];
}

$wp_query = null;
$wp_query = new WP_Query($avatar_brand_args);
$conditional_margin_css = $wp_query->post_count == 0 ? 'entity-content--no-margin-top' : '';
?>
		<div class="entity-header entity-row row reg-author">
			<div>
					<div class="col-md-2 col-sm-3 col-xs-5 text-center">
						<span class="entity-header__sponsor-cat-name">
							<?php echo esc_html(get_field('acf_brand_knowledge_info_title', 'option')); ?>
						</span>
						<?php if ($sponsor_image) { ?>
						<figure class="entity-header__figure entity-header__figure--noRadius entity-header__figure--wide">
							<?php if ($sponsor_website) { ?>
								<a target="_blank" href="<?php echo esc_url($sponsor_website); ?>">
									<img class="entity-header__image" src="<?php echo esc_url($sponsor_image); ?>" alt="<?php echo wp_kses_post($sponsor_name); ?>">
								</a>
							<?php } else { ?>
								<img class="entity-header__image" src="<?php echo esc_url($sponsor_image); ?>" alt="<?php echo wp_kses_post($sponsor_name); ?>">
							<?php }?>
						</figure>
						<?php } ?>
						<div class="entity-header__infos">
							<dl class="social-icons">
								<dt class="social-icons__empty"></dt>
								<?php if ($sponsor_linkedin) { ?>
									<dd>
										<a class="lkin" target="_blank" href="<?php echo esc_url($sponsor_linkedin); ?>">
											<span><?php _e('LinkedIn', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
								<?php if ($sponsor_twitter) { ?>
									<dd>
										<a class="twt" target="_blank" href="<?php echo esc_url($sponsor_twitter); ?>">
											<span><?php _e('Twitter', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
								<?php if ($sponsor_facebook) { ?>
									<dd>
										<a class="fb" target="_blank" href="<?php echo esc_url($sponsor_facebook); ?>">
											<span><?php _e('Facebook', 'avatar-tcm') ?></span>
										</a>
									</dd>
								<?php }?>
							</dl>
							<?php if ($sponsor_website) { ?>
								<a target="_blank" href="<?php echo esc_url($sponsor_website); ?>">
									<?php _e('Visit website', 'avatar-tcm'); ?>
								</a>
							<?php }?>
						</div>
					</div>
					<div class="entity-header__landing-box entity-header__landing-box--negative-margin col-md-6 col-sm-9 col-xs-7">
						<h1 class="entity-header__name"><?php the_title(); ?></h1>
						<div class="text-content text-content__excerpt text-content__excerpt--text-lightest">
							<?php the_content(); ?>
						</div>
						<?php
                if (! empty($avatar_topics)) { ?>
							<form action="<?php echo get_permalink(); ?>" method="post" class="form-horizontal" >
								<select id="avatar_topic_id" class="form-control avatar-topic-select" name="avatar_topic_id" onchange="this.form.submit()">
									<option value="" ><?php _e('All Topics', 'avatar-tcm'); ?></option>
									<?php foreach ($avatar_topics as $key => $value) { ?>
										<option <?php if ($avatar_brand_id == $key) {
										    echo 'selected';
										} ?> value="<?php echo esc_attr($key); ?>" ><?php echo wp_kses_post($value); ?></option>
									<?php } ?>
								</select>
							</form>
						<?php } ?>
					</div>
					<div class="col-md-4 col-xs-12">
						<?php get_template_part('templates/article/article-entity-share', 'top'); ?>
					</div>
			</div>
		</div>
	</header>

	<div class="entity-content entity-content--brand <?php echo $conditional_margin_css; ?> row equal-col-md">
		<section class="col-md-8">
			<div class="row">
				<div class="col-md-9 col-md-offset-3 col-sm-12 ?>">
					<div class="row row--no-margin">
						<div class="entity-box-listing col-xs-12 sponsor-bg" >
							<div id="js-regular-listing-container">
								<?php if ($wp_query->have_posts()) { ?>
									<?php while ($wp_query->have_posts()) {
									    $wp_query->the_post(); ?>
										<div class="js-regular-listing">
											<div class="text-content text-content--border-bottom text-content--border-bottom-dark">
												<h2 class="text-content__title text-content__title--big icons  <?php echo avatar_article_get_icon(get_the_ID()); ?>" ><a class="text-content__link"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
								<?php wp_reset_postdata(); ?>
								<?php } else { ?>
									<?php _e('There is currently no post for this feature', 'avatar-tcm'); ?>
								<?php } ?>
								<div class="pagination">
									<?php next_posts_link(); ?>
								</div>
							</div>
						</div>
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
			<?php include locate_template('templates/general/component-cxense-most.php'); ?>
			<div class="sponsor-black-box col-sm-6 col-md-12">
				<p class="sponsor-black-box__title"><?php echo get_field('acf_brand_knowledge_info_title', 'option'); ?></p>
				<p class="sponsor-black-box__description"><?php echo get_field('acf_brand_knowledge_info_desc', 'option'); ?></p>
			</div>
		</aside>
	</div>
</section>
<?php get_footer(); ?>