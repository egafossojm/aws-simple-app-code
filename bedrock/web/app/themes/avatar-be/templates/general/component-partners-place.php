<?php
/*
* Location : Sponsored Content page
* Partner's place Component
* A maximum 4 article listing of Partners Place content.
*/
?>
<?php
$avatar_cat_partnersplace = get_field('acf_tools_partnersplace_link', 'option');
$acf_partners_place_repeater = get_field('acf_partners_place_repeater', 'option');

// Test if array exist and create new array with ID only
if (is_array($acf_partners_place_repeater)) {
    $acf_partners_place_repeater_array = [];
    foreach ($acf_partners_place_repeater as $key => $value) {
        $acf_partners_place_repeater_array[] = $value['acf_partners_place_article'];
    }
} else {
    new WP_Error('empty', __('Partners Place Options are empty', 'avatar-tcm'));

    return;
}

$wp_query_articles_arg = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'post__in' => $acf_partners_place_repeater_array,
    'orderby' => 'post__in',
];
$wp_query_articles = new WP_Query($wp_query_articles_arg);
$post_count = 0;
?>
<div class="col-sm-12">
    <div class="bloc-title">
        <span class="bloc-title__text">
            <?php _e('Education', 'avatar-tcm'); ?>
        </span>
    </div>
<?php
    if ($wp_query_articles) { ?>
    <div class="component tools-module col-sm-6 col-md-12">

        <div class="bloc">
            <div class="row home-partner-list">
                <?php
                // List of articles
                while ($wp_query_articles->have_posts()) {
                    $wp_query_articles->the_post();
                    // get sponsor if exists
                    $sponsor = avatar_get_sponsor_info(get_the_ID()); ?>

                    <?php if ($post_count == 0) { ?>
                    <div class="col-sm-12 col-md-6 home-module">
                        <div class="<?php if ($sponsor) {
                            echo 'sponsor-bg text-content';
                        } ?>">
                            <div class="row">
                            <?php // Thumbnail
                            // if( has_post_thumbnail() ):?>
                                 <!-- <figure class="col-md-12 thumb"> -->
                                 <!-- <?php the_post_thumbnail($size = 'large', $attr = ['class' => 'img-responsive']); ?> -->
                                 <!-- <img src="https://via.placeholder.com/250" alt=""> -->
                                 <!-- </figure> -->
                             <?php
                            // endif;?>
                            <?php if (has_post_thumbnail()) { ?>
                                    <div class="col-md-12 thumb">
                                        <figure>
                                        <?php the_post_thumbnail($size = 'large', $attr = ['class' => 'img-responsive']); ?>
                                        </figure>
                                    </div>
                                    <?php } else { ?>
                                        <figure class="image-container">
                                            <img class="display-partner-logo">
                                        </figure>
                                    <?php } ?>
                                <div class="col-md-12 text text--half-bloc">
                                    <?php // Title?>
                                    <h3><a class="text-content__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    <?php // Excerpt?>
                                    <p class="text-content__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>

                                    <?php // Sponsor
                                    avatar_display_post_sponsor(get_the_ID(), $single = false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $post_count++;
                    } else { ?>
                        <div class="col-sm-12 col-md-6">
                            <div class="partners-place-container">
                                <div class="text-content no-padding-bottom">
                                    <h3 class="text-content__title icons <?php echo avatar_article_get_icon($curr_post_id); ?>">
                                        <a class="text-content__link"  href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
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
                                <div>
                                    <!-- <figure>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="top-image">
                                                <img src="https://via.placeholder.com/100" alt="">
                                            </div>
                                        </a>
                                    </figure> -->
                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="top-image">
                                            <figure class="image-container-small">
                                                <?php the_post_thumbnail($size = 'large', $attr = ['class' => 'img-responsive']); ?>
                                            </figure>
                                        </div>
                                    <?php } else { ?>
                                        <figure class="image-container-small">
                                            <img class="display-partner-logo">
                                        </figure>
                                    <?php } ?>
                                </div>
                            
                            </div>
                        </div>
                        <?php $post_count++;
                    } ?>
                <?php } wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <p>No education found.</p>
    <?php } ?>
</div>