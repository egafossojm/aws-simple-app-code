<?php
$avatar_brand_id = get_post_meta($post_id, 'acf_article_brand', true);
$avatar_brand_topic_id = get_post_meta($post_id, 'acf_article_brand_topic', true);

$avatar_brand_args = [
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'post__not_in' => [$post_id],
    'meta_query' => [
        'relation' => 'AND',
        [
            'key' => 'acf_article_type',
            'value' => 'brand',
            'compare' => '=',
        ],
        [
            'key' => 'acf_article_brand',
            'value' => $avatar_brand_id,
            'compare' => '=',
        ],
        [
            'key' => 'acf_article_brand_topic',
            'value' => $avatar_brand_topic_id,
            'compare' => '=',
        ],
    ],
    'order' => 'DESC',
    'orderby' => 'date',
];

$avatar_brand_args_count = [
    'fields' => 'ids',
    'post_type' => 'post',
    'posts_per_page' => -1,
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
            'value' => $avatar_brand_id,
            'compare' => '=',
        ],
    ],
];

$wp_query_brand_articles = new WP_Query($avatar_brand_args);
$avatar_brand_id = get_post_meta($post_id, 'acf_article_brand', true);

$wp_query_brand_articles_count = new WP_Query($avatar_brand_args_count);
$avatar_count_brand_posts = $wp_query_brand_articles_count->found_posts; //add exluded post
$avatar_brand_found_posts = sprintf(_n('%s Article', '%s Articles', $avatar_count_brand_posts, 'avatar-tcm'), $avatar_count_brand_posts);
?>
 <?php if ($avatar_brand_id and $wp_query_brand_articles->post_count != 0) { ?>
<div id="brand-listing-container">
	<div>
		<div class="row brand-listing-header equal-col-xs sponsor-bg">
			<div class="col-md-6 col-xs-12">
				<?php if ($sponsor_image) { ?>
					<figure class="entity-figure">
						<a href="<?php echo esc_url($sponsor_link); ?>"><img class="entity-figure__img" src="<?php echo esc_url($sponsor_image); ?>">
						</a>
					</figure>
				<?php } else { ?>
					<a href="<?php the_permalink(); ?>">
						<h2><?php echo wp_kses_post($sponsor_title); ?></h2>
					</a>
				<?php } ?>
			</div>
			<div class="col-md-6 col-xs-12 text-right brand-listing-count"><!--NB ARTICLES COUNT BRAND-->
				<div>
					<a href="<?php echo esc_url($sponsor_link); ?>">
						<span><?php echo wp_kses_post($avatar_brand_found_posts); ?></span>
					</a>
					<i class="fa fa-caret-right" aria-hidden="true"></i>
				</div>
			</div>
		</div>
		<div class="row brand-listing-content sponsor-bg">
			<div class="col-md-4">
				<p class="brand-listing-desc"><?php echo apply_filters('get_the_content', get_post_field('post_content', $avatar_brand_id)); ?></p>
			</div>
	<?php if ($wp_query_brand_articles->have_posts()) {
	    $i = 0;
	    $total_posts = $wp_query_brand_articles->post_count; ?>
		<?php while ($wp_query_brand_articles->have_posts()) {
		    $wp_query_brand_articles->the_post(); ?>
			<?php $curr_post_id = get_the_ID(); ?>
			<?php $i++; ?>
			<?php if ($i == 1) { ?>
				<div class="col-md-4">
					<div class="text-content">
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if (has_post_thumbnail()) { ?>
								<figure>
									<a href="<?php the_permalink(); ?>">
										<div class="article-thumbnail">
											<?php the_post_thumbnail('thumbnail', ['class' => 'img-responsive']); ?>
										</div>
									</a>
								</figure>
							<?php } ?>
							<div>
								<h2 class="text-content__title text-content_title--big icons <?php echo avatar_article_get_icon($curr_post_id); ?>" ><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="text-content__excerpt">
									<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if ($i >= 2) { ?>
				<?php if ($i == 2) { ?>
					<div class="col-md-4">
				<?php } ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="text-content">
						<h2 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>"><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
						<ul class="pub-details">
							<?php
		                        avatar_display_post_author($curr_post_id, $single = false);
			    avatar_display_post_source($curr_post_id, $single = false);
			    avatar_display_post_date($curr_post_id, $single = false);
			    ?>
						</ul>
					</div>
				</div>

				<?php if ($i == 4 or $i == $total_posts) { ?>
					</div>
				<?php } ?>

			<?php } ?>

		<?php } wp_reset_postdata(); ?>
	<?php } ?>

		</div>
	</div>
</div>
<?php } ?>