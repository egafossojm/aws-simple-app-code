<div id="sites" style="padding-top: 20px;"></div>
<div class="col-sm-12">
    <div class="bloc-title">
        <span class="bloc-title__text">
            <?php _e('Sites', 'avatar-tcm'); ?>
        </span>
    </div>
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            // Args fot the microsites
            $microsite_id = 50050;
            if (get_locale() == 'fr_CA') {
                $microsite_id = 52035;
            }
            $microsites_args = [
                'post_type' => 'microsite',
                // Display only the children posts
                // 'post_parent__not_in' => array(0),
                // Get post with parent of Microsite Benefits canada id->50050
                // OR
                // Get post with parent of Microsite Avantages id->52035
                'post_parent' => $microsite_id,
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'date',
                'paged' => $paged,
                'posts_per_page' => 10,
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'is_partner',
                        'value' => '1',
                        'compare' => '=',
                    ],
                ],
            ];
            $avatar_indepth_partner_report_id = get_field('acf_partners_place_repeater', 'option');

            $wp_query = new WP_Query($microsites_args);
            ?>
    <div class="col-sm-12">
        <div class="wrap">
            <div class="content-area">
                <main class="content-wrapper">
                    <?php
                            if ($wp_query->have_posts()) {
                                while ($wp_query->have_posts()) {
                                    $wp_query->the_post();
                                    ?>
                            <div class="col-sm-12 col-md-6">
                                <div class="main-container">

                                    <div class="col-sm-12 text-content">
                                        <?php if (get_field('acf_microsite_partner_logo')) {
                                            $partner_logo = get_field('acf_microsite_partner_logo') ?>
                                            <div class="top-image">
                                                <a class="text-content__link" href="<?php the_permalink(); ?>">
                                                    <figure class="image-container">
                                                        <img class="display-partner-logo" src="<?php echo $partner_logo['url']; ?>">
                                                    </figure>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <figure class="image-container">
                                                <img class="display-partner-logo">
                                            </figure>
                                        <?php } ?>
                                        <h2 class="text-content__title text-content__title--big text-content__title--big--sponsored-content">
                                            <a class="text-content__link" href="<?php the_permalink(); ?>">
                                                <?php echo get_the_title(); ?>
                                            </a>
                                        </h2>
                                        <div class="partner-content-excerpt"><?php the_excerpt(); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                                }
                                wp_reset_query(); // end while
                            } else { ?>
                        <p>No Series content found.</p>
                    <?php } ?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
// include( locate_template( 'templates/general/component-partners-place.php' ) );
include locate_template('templates/general/component-partners-series.php');
            include locate_template('templates/general/component-partners-education.php');
            //include(locate_template('templates/general/component-plansponsorguidebooks.php'));
            include locate_template('templates/general/component-partners-roundtables.php');
            include locate_template('templates/general/component-partners-directory.php');

            ?>