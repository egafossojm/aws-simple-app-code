<?php
/* -------------------------------------------------------------
 * Related Articles by category and tags
 * ============================================================*/
if (! function_exists('avatar_the_related_articles')) {

    function avatar_the_related_articles($post_id, $main_sub_category_id, $posttags)
    {

        $exclude_id = [$post_id];

        if (! empty($posttags)) {

            foreach ($posttags as $tag) {
                $tags_id[] = $tag->term_id;
            }

            $avatar_related_articles_arg = [
                'post_type' => ['post'],
                'post_status' => ['publish'],
                'post__not_in' => $exclude_id,
                'cat' => $main_sub_category_id,
                'tag__in' => $tags_id,
                'posts_per_page' => 3,

            ];

            $avatar_related_articles = new WP_Query($avatar_related_articles_arg);
            if ($avatar_related_articles->have_posts()) { ?>
				<dl class="related-news-module col-sm-6 col-md-12">
					<dt><h2 class="related-news-module__title related-news-module__title--color"><?php _e('Related news', 'avatar-tcm'); ?></h2></dt>
					<?php while ($avatar_related_articles->have_posts()) {
					    $avatar_related_articles->the_post(); ?>
						<dd class="related-news-module__description" id="post-<?php the_ID(); ?>">
							<h3 class="related-news-module__description-title"><a class="related-news-module__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</dd>
					<?php } ?>
				</dl>
				<?php wp_reset_postdata();
            }
        }
    }
}

/* -------------------------------------------------------------
 * Related Featured Articles
 * ============================================================*/
if (! function_exists('avatar_the_related_featured_articles')) {

    function avatar_the_related_featured_articles($feature_id, $post_id)
    {

        $exclude_id = [$post_id];

        if (! empty($feature_id)) {

            $avatar_related_articles_arg = [
                'post_type' => ['post'],
                'post_status' => ['publish'],
                'post__not_in' => $exclude_id,
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'acf_article_type',
                        'value' => 'feature',
                        'compare' => '=',
                    ],
                    [
                        'key' => 'acf_article_feature',
                        'value' => $feature_id,
                        'compare' => '=',
                    ],
                ],
                'order' => 'DESC',
                'orderby' => 'date',
                'posts_per_page' => 5,

            ];

            $avatar_related_articles = new WP_Query($avatar_related_articles_arg);
            if ($avatar_related_articles->have_posts()) { ?>
				<dl class="related-news-module col-sm-6 col-md-12">
					<dt><h2 class="related-news-module__title related-news-module__title--color"><?php _e('Related news', 'avatar-tcm'); ?></h2></dt>
					<?php while ($avatar_related_articles->have_posts()) {
					    $avatar_related_articles->the_post(); ?>
						<dd id="post-<?php the_ID(); ?>" class="related-news-module__description">
							<h3 class="related-news-module__description-title">
							<a class="related-news-module__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</dd>
					<?php } ?>
				</dl>
				<?php wp_reset_postdata();
            }
        }
    }
}
/* -------------------------------------------------------------
 * Related Brand Articles
 * ============================================================*/
if (! function_exists('avatar_the_related_brand_articles')) {

    function avatar_the_related_brand_articles($brand_id, $post_id)
    {

        $exclude_id = [$post_id];

        if (! empty($brand_id)) {

            $avatar_related_articles_arg = [
                'post_type' => ['post'],
                'post_status' => ['publish'],
                'post__not_in' => $exclude_id,
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'acf_article_type',
                        'value' => 'brand',
                        'compare' => '=',
                    ],
                    [
                        'key' => 'acf_article_brand',
                        'value' => $brand_id,
                        'compare' => '=',
                    ],
                ],
                'order' => 'DESC',
                'orderby' => 'date',
                'posts_per_page' => 5,

            ];
            $avatar_related_articles = new WP_Query($avatar_related_articles_arg);
            if ($avatar_related_articles->have_posts()) { ?>
				<dl class="related-news-module col-sm-6 col-md-12">
					<dt><h2 class="related-news-module__title related-news-module__title--color"><?php _e('Related news', 'avatar-tcm'); ?></h2></dt>
					<?php while ($avatar_related_articles->have_posts()) {
					    $avatar_related_articles->the_post(); ?>
						<dd class="related-news-module__description" id="post-<?php the_ID(); ?>">
							<h3 class="related-news-module__description-title"><a class="related-news-module__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</dd>
					<?php } ?>
				</dl>
				<?php wp_reset_postdata();
            }
        }
    }
}
?>