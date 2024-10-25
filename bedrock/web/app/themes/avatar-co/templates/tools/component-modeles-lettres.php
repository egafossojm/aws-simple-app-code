<?php
$avatar_cat_modeleslettres = get_field('acf_modeles_lettres_link', 'option');

if ($avatar_cat_modeleslettres == null) {
    return;
}

$wp_query_articles_arg = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 2,
    'cat' => $avatar_cat_modeleslettres->term_id,
];
$wp_query_articles = new WP_Query($wp_query_articles_arg);

if ($wp_query_articles) { ?>
<div class="bloc">
	<div class="row">
		<div class="col-md-12">
			<h2 class="letters">
				<a class="text-content__link" href="<?php echo get_category_link($avatar_cat_modeleslettres->term_id); ?>"><?php echo wp_kses_post($avatar_cat_modeleslettres->name); ?></a>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</h2>
		</div>
	</div>
	<div class="row equal-col">
		<?php
        // List of articles
        while ($wp_query_articles->have_posts()) {
            $wp_query_articles->the_post();
            ?>
			<div class="col-sm-6">
				<div <?php post_class('bg text-content'); ?>>
					<div class="row">
						<?php // Thumbnail
                       if (has_post_thumbnail() && get_field('acf_article_thumbnail_show')) { ?>
							<figure class="col-md-12 thumb">
								<a class="text-content__link" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), $size = 'medium', ['class' => 'img-responsive wp-post-image']); ?></a>
							</figure>
						<?php
                       }

            // Date?>
						<div class="col-md-12 text text--half-bloc">
							<ul class="pub-details">
								<?php avatar_display_post_date(get_the_ID(), $single = false); ?>
							</ul>

							<h3><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<?php // Excerpt?>
							<p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>

							<?php avatar_display_post_sponsor(get_the_ID(), $single = false); ?>
						</div>
					 </div>
				</div>
			</div>
		<?php
        }
    wp_reset_postdata(); ?>
	</div>
  </div>
<?php
}
?>