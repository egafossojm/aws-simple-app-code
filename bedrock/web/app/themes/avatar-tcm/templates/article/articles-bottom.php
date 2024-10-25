<?php
$fields = get_field('homepage_articles', 'option');
$avatar_fields = avatar_get_news_homepage($fields);

$avatar_post_id = get_the_ID();
$avatar_article_main_cat = get_field('article_side_main_subcategory', $avatar_post_id) ? get_field('article_side_main_subcategory', $avatar_post_id) : '';
// Get post ID array from homepage
$article_ids = [];

if (! empty($avatar_fields)) {
    foreach ($avatar_fields as $key => $arr_articles) {
        if (array_key_exists('article', $arr_articles)) {
            $article_ids[] = $arr_articles['article']['id'];
        }
    }
} else {
    error_log('$avatar_fields is empty');

    return;
}

$article_cat_ids = $article_ids;
// add current post ID
$article_cat_ids[] = $avatar_post_id;
//Remove dublicate ID
$article_cat_ids = array_unique($article_cat_ids);

$article_ids_top = $article_ids;
// Remove current post ID
if (($k = array_search($avatar_post_id, $article_ids)) !== false) {
    unset($article_ids[$k]);
    $article_ids_top = $article_ids;
}

// Query arguments for article from same category
$cat_stories_arg = [
    'cat' => $avatar_article_main_cat,
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__not_in' => $article_cat_ids,
    'orderby' => 'date',
];
// Query arguments for top stories (from homepage)
$top_stories_arg = [
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__in' => $article_ids_top,
    'orderby' => 'post__in',
];
?>
<section>
	<div class="row row--articles-bottom">
		<div class="col-sm-6">
			<h2 class="bloc-title bloc-title--border-color bloc-title__text--color bloc-title--big">
				<?php
                    _e('Latest news', 'avatar-tcm');

if ($avatar_article_main_cat != '') {
    printf(__(' In %s', 'avatar-tcm'), get_cat_name($avatar_article_main_cat));
}
?>
			</h2>

				<?php
// the query
$cat_stories_query = new WP_Query($cat_stories_arg); ?>

				<?php if ($cat_stories_query->have_posts()) { ?>
					<!-- start of the top story -->
					<?php while ($cat_stories_query->have_posts()) {
					    $cat_stories_query->the_post(); ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class('text-content text-content--border-bottom'); ?>>
							<h3 class="text-content__title text-content__title--big <?php echo avatar_article_get_icon(get_the_ID()); ?> icons">
								<a class="text-content__link   " href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="text-content__excerpt">
								<?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
							</p>
							<ul class="pub-details">
								<?php avatar_display_post_author(get_the_ID(), $single = false); ?>
								<?php avatar_display_post_source(get_the_ID(), $single = false); ?>
								<?php avatar_display_post_date(get_the_ID(), $single = false); ?>
							</ul>
						</div>

					<?php } ?>
					<!-- end of the top story -->
					<?php wp_reset_postdata(); ?>

				<?php } else { ?>
					<p><?php _e('Sorry, no posts matched your criteria.', 'avatar-tcm'); ?></p>
				<?php } ?>

		</div>
		<div class="col-sm-6">
			<h2 class="bloc-title bloc-title--border-color bloc-title__text--color bloc-title--big"><?php _e('Today\'s top stories', 'avatar-tcm'); ?></h2>

				<?php
                // the query
                $top_stories_query = new WP_Query($top_stories_arg); ?>

				<?php if ($top_stories_query->have_posts()) { ?>
					<!-- start of the top story -->
					<?php while ($top_stories_query->have_posts()) {
					    $top_stories_query->the_post(); ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class('text-content text-content--border-bottom'); ?>>
							 <h3 class="text-content__title text-content__title--dinlB text-content__title--big <?php echo avatar_article_get_icon(get_the_ID()); ?> icons">
							 	<a class="text-content__link  "  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							 </h3>
							<p class="text-content__excerpt">
								<?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
							</p>
							<ul class="pub-details">
								<?php avatar_display_post_author(get_the_ID(), $single = false); ?>
								<?php avatar_display_post_source(get_the_ID(), $single = false); ?>
								<?php avatar_display_post_date(get_the_ID(), $single = false); ?>
							</ul>
						</div>

					<?php } ?>
					<!-- end of the top story -->
					<?php wp_reset_postdata(); ?>

				<?php } else { ?>
					<p><?php _e('Sorry, no posts matched your criteria.', 'avatar-tcm'); ?></p>
				<?php } ?>
		</div>
	</div>
</section>