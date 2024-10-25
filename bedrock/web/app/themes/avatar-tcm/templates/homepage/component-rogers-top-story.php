<div class="bloc-title bloc-title--margin-top-negative">
    <span class="bloc-title__text">
        <?php _e('Top stories', 'avatar-tcm'); ?>
    </span>
</div>
<?php
function spit_first($homepage_article)
{
    global $site_id;
    $article_type = get_field('acf_article_type', $homepage_article['article']['id']);
    $acf_article_sponsor = get_field('acf_article_sponsor', $homepage_article['article']['id']);
    ?><div class="col-sm-12 first-featured">
        <div class="row <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
            echo 'sponsor-bg';
        } ?>">
            <figure class="col-sm-8 col-sm-push-4">
                <a href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
                    <?php
                    if (isset($homepage_article['article']['featured_image'])) { ?>
                        <div class="top-image">
                            <?php echo get_the_post_thumbnail($homepage_article['article']['id'], 'large', ['class' => 'img-responsive']); ?>
                        </div>
                    <?php }
                    ?>
                </a>
            </figure>
            <div class="text-content top-featured col-sm-4 col-sm-pull-8">
                <?php avatar_display_post_category($homepage_article['article']['id'], $single = false); ?>
                <h2 class="text-content__title text-content__title--xxbig">
                    <a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
                        <?php echo get_the_title($homepage_article['article']['id']); ?>
                    </a>
                </h2>
                <p class="text-content__excerpt">
                    <?php echo get_the_excerpt($homepage_article['article']['id']); ?>
                </p>
                <ul class="pub-details">
                    <?php if ($site_id == 7) {
                        avatar_display_post_date_only($homepage_article['article']['id'], $single = false);
                    } else {
                        avatar_display_post_date($homepage_article['article']['id'], $single = false);
                    } ?>
                </ul>
                <?php
                if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                    avatar_display_post_sponsor($homepage_article['article']['id'], false);
                }
    ?>
            </div>

        </div>
    </div>
<?php } // end spit_first()

        function spit_second_or_third($homepage_article)
        {
            global $site_id;
            $article_type = get_field('acf_article_type', $homepage_article['article']['id']);
            $acf_article_sponsor = get_field('acf_article_sponsor', $homepage_article['article']['id']);
            ?><div class="col-sm-6">
        <div class="text-content text-content--border-bottom  <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
            echo 'sponsor-bg';
        } ?>">
            <figure class="">
                <a href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
                    <?php
                    if (isset($homepage_article['article']['featured_image'])) { ?>
                        <div class="top-image">
                            <?php echo get_the_post_thumbnail($homepage_article['article']['id'], 'large', ['class' => 'img-responsive']); ?>
                        </div>
                    <?php }
                    ?>
                </a>
            </figure>
            <?php avatar_display_post_category($homepage_article['article']['id'], $single = false); ?>
            <h2 class="text-content__title text-content__title--xbig icons <?php echo avatar_article_get_icon($homepage_article['article']['id']); ?>">
                <a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
                    <?php echo get_the_title($homepage_article['article']['id']); ?>
                </a>
            </h2>
            <p class="text-content__excerpt"> <?php echo get_the_excerpt($homepage_article['article']['id']); ?></p>
            <ul class="pub-details">
                <?php if ($site_id == 7) {
                    avatar_display_post_date_only($homepage_article['article']['id'], $single = false);
                } else {
                    avatar_display_post_date($homepage_article['article']['id'], $single = false);
                } ?>
            </ul>
            <?php
            if (array_key_exists('homepage_r_linked_article', $homepage_article)) { ?>
                <ul class="related">
                    <?php
                    foreach ($homepage_article['homepage_r_linked_article'] as $key_r_linked_article => $homepage_r_linked_article) { ?>
                        <li>
                            <a href="<?php echo get_permalink($homepage_r_linked_article['id']); ?>">
                                <?php echo get_the_title($homepage_r_linked_article['id']); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php
            if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                avatar_display_post_sponsor($homepage_article['article']['id'], false);
            }
            ?>
        </div>
    </div>
<?php } // end spit_second_or_third()

        function spit_other($homepage_article)
        {
            global $site_id;
            $article_type = get_field('acf_article_type', $homepage_article['article']['id']);
            $acf_article_sponsor = get_field('acf_article_sponsor', $homepage_article['article']['id']);
            ?><div class="col-sm-6 split">
        <div class="text-content text-content--border-top <?php if (($article_type == 'brand') || (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
            echo 'sponsor-bg';
        } ?>">
            <?php $image_col = isset($homepage_article['article']['featured_image']) ? true : false; ?>
            <div class="after-clear">
                <?php if ($image_col) { ?>
                    <figure class="text-content__figure-right">
                        <a href="<?php echo get_permalink($homepage_article['article']['id']); ?>">
                            <?php echo get_the_post_thumbnail($homepage_article['article']['id'], 'thumbnail', ['class' => 'img-responsive']); ?>
                        </a>
                    </figure>
                <?php } ?>
                <?php avatar_display_post_category($homepage_article['article']['id'], $single = false); ?>
                <h2 class="text-content__title  icons <?php echo avatar_article_get_icon($homepage_article['article']['id']); ?>">
                    <a class="text-content__link" href="<?php echo get_permalink($homepage_article['article']['id']); ?>"><?php echo get_the_title($homepage_article['article']['id']); ?></a>
                </h2>
                <p class="text-content__excerpt"><?php echo get_the_excerpt($homepage_article['article']['id']); ?></p>
                <ul class="pub-details">
                    <?php avatar_display_post_author($homepage_article['article']['id'], $single = false); ?>
                    <?php avatar_display_post_source($homepage_article['article']['id'], $single = false); ?>
                    <?php if ($site_id == 7) {
                        avatar_display_post_date_only($homepage_article['article']['id'], $single = false);
                    } else {
                        avatar_display_post_date($homepage_article['article']['id'], $single = false);
                    } ?>
                </ul>
                <?php
                if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                    avatar_display_post_sponsor($homepage_article['article']['id'], false);
                }
            ?>
            </div>
        </div>
        <?php
        if (array_key_exists('homepage_r_linked_article', $homepage_article)) { ?>
            <ul class="related">
                <?php
            foreach ($homepage_article['homepage_r_linked_article'] as $key_r_linked_article => $homepage_r_linked_article) { ?>
                    <li><a href="<?php echo get_permalink($homepage_r_linked_article['id']); ?>"><?php echo get_the_title($homepage_r_linked_article['id']); ?></a></li>
                <?php } ?>
            </ul>
        <?php }
        ?>
    </div>
<?php } // end spit_other()

        function spit_ad($homepage_acf_ad_scheduling)
        {
            $ad_surtitle = $homepage_acf_ad_scheduling['ad_surtitle'];
            $ad_title = $homepage_acf_ad_scheduling['ad_title'];
            $ad_image = $homepage_acf_ad_scheduling['ad_image']['url'];
            $ad_url = $homepage_acf_ad_scheduling['ad_url'];
            ?>
    <div class="col-sm-6 split">
        <hr style="
    margin: 0;
    border-color: #ccc;
">
        <style>
            .native-box {
                background-color: #eee;
                padding: 12px 0 12px 8px;
                width: 100%;
                display: flex;
                justify-content: space-between;
                font-family: "Roboto", sans-serif, Helvetica, Arial, sans-serif;
                margin: 12px 0;
                flex-wrap: wrap;
                min-height: 120px;
                align-items: start;
            }

            .native-box a:hover {
                cursor: pointer;
            }

            .native-box .sponsored-label {
                color: #333;
                display: block;
                text-decoration: none;
                font-size: 11px;
            }

            .native-box .sponsored-label:hover {
                text-decoration: underline;
            }

            .native-box .article-title {
                display: block;
                margin: 8px 0;
                font-family: "Roboto", sans-serif, Helvetica, Arial, sans-serif;
                font-weight: 700;
                line-height: 20px;
                font-size: 16px;
            }

            .native-box .article-title {
                color: #000;
                text-decoration: none;
            }

            .native-box .article-title:hover {
                color: #ed1c24;
            }

            .native-box .native-img-container {
                margin-left: 8px;
                display: flex;
                align-items: center;
                width: 36%;
                justify-content: end;
            }
        </style>
        <div class="native-box">
            <div style="width:60%;">
                <a class="sponsored-label" href="<?php echo $ad_url; ?>"><?php echo $ad_surtitle; ?></a>
                <a class="article-title" href="<?php echo $ad_url; ?>"><?php echo $ad_title; ?></a>
            </div>

            <div class="native-img-container">
                <a href="<?php echo $ad_url; ?>" style="width: 112px;height: 94px;" class="text-right">
                    <img style="height: 100%;  width: 100%;  object-fit: cover;" src="<?php echo $ad_image; ?>" />
                </a>
            </div>
        </div>
    </div>
<?php } // end spit_ad()

        $fields = get_field('homepage_articles', 'option');
        $avatar_homepage_articles = avatar_get_news_homepage($fields);
        global $post;
        $current_page_id = $post->ID;
        $ad_is_active = false;
        $ad_is_active_second = false;
        $ad_position = 4;
        $ad_position_second = 6;
        if (is_front_page()) {
            $homepage_acf_ad_scheduling = get_field('home_ad_scheduling', $current_page_id);
            $homepage_acf_ad_scheduling_second = get_field('home_ad_scheduling_2', $current_page_id);
            if ($homepage_acf_ad_scheduling || $homepage_acf_ad_scheduling_second) {
                $home_date_compare_format = 'Y-m-d H:i:s';
                $now = date($home_date_compare_format);
                $ad_is_active = $homepage_acf_ad_scheduling['ad_start_date'] <= $now && $homepage_acf_ad_scheduling['ad_end_date'] >= $now;
                $ad_is_active_second = $homepage_acf_ad_scheduling_second['ad_start_date'] <= $now && $homepage_acf_ad_scheduling_second['ad_end_date'] >= $now;
                $ad_position = $homepage_acf_ad_scheduling['ad_position'];
                $ad_position_second = $homepage_acf_ad_scheduling_second['ad_position'];
            }
        }

        if (empty($avatar_homepage_articles) && is_super_admin()) {
            _e('No articles selected for home page or the articles was deleted.', 'avatar-tcm');
        } else {
            ?><div class="row top-alternate"><?php
                                                spit_first($avatar_homepage_articles[0]);
            ?><div class="col-sm-12 secondary-featured">
            <div class="row equal-col"><?php
                spit_second_or_third($avatar_homepage_articles[1]);
            spit_second_or_third($avatar_homepage_articles[2]);
            ?></div>
        </div>
    </div><?php
            $therest = array_slice($avatar_homepage_articles, 3);
            global $site_id;
            if ($site_id == 7) {
                $therest = array_merge(
                    array_slice($therest, 0, 6),
                    //["AD_SLOT"],
                    array_slice($therest, 6, 4),
                    // ["AD_SLOT"],
                    array_slice($therest, 10)
                );
            } else {
                $therest = array_merge(
                    array_slice($therest, 0, 6),
                    // ["AD_SLOT"],
                    array_slice($therest, 6, 4),
                    // ["AD_SLOT"],
                    array_slice($therest, 10)
                );
            }
            foreach ($therest as $key => $homepage_article) {
                if ($key % 2 == 0) { ?><div class="row"><?php }
                if ($ad_position == ($key + 4) && $ad_position_second != ($key + 4)) {
                    if ($ad_is_active && $homepage_acf_ad_scheduling) {
                        spit_ad($homepage_acf_ad_scheduling);
                    } else {
                        spit_other($homepage_article);
                    }
                } else {
                    if ($ad_position_second == ($key + 4) && $ad_position != ($key + 4)) {
                        if ($ad_is_active_second && $homepage_acf_ad_scheduling_second) {
                            spit_ad($homepage_acf_ad_scheduling_second);
                        } else {
                            spit_other($homepage_article);
                        }
                    } else {
                        spit_other($homepage_article);
                    }
                }

                if ($key % 2 == 1) { ?></div><?php }
                }
            // When $therest is uneven, it means we're missing a closing div.
            if (count($therest) % 2 == 1) { ?></div><?php }
            } ?>
<!-- end 2 column listing -->