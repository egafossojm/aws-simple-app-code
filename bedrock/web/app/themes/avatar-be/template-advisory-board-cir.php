<?php

/**
 * Template Name: Advisory Board CIR
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
$advisory_board_args = [
    'post_type' => 'cir-board-members',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'tax_query' => [
        [
            'taxonomy' => 'category',
            'terms' => 'advisory-board-members',
            'field' => 'slug',
        ],
        'relation' => 'AND',
        [
            'taxonomy' => 'category',
            'terms' => 'advisory-board-cir-member',
            'field' => 'slug',
        ],
    ],
];

$advisory_board = new WP_Query($advisory_board_args);
$advisory_board_count = 0 ?>

<div class="advisory-board" style="padding-top:42.5px;">
    <!-- <h2>CIR Board</h2> -->
    <!-- Pension/Investments Board -->
    <div class="container-advisory-board">
        <div class="advisory-board-row">

            <?php if ($advisory_board->have_posts() && $advisory_board->post_count > 0) {
                while ($advisory_board->have_posts()) {
                    $advisory_board->the_post();
                    $title = get_the_title();
                    $title_position = get_field('title');
                    $the_content = get_the_content();
                    $portrait = get_field('portrait');
                    $portrait_url = $portrait['url'];
                    $portrait_url_alt = $portrait['title'];

                    ?>

                    <div class="advisory-member">
                        <img class="advisory-boards-thumb" src="<?php echo $portrait_url; ?>" alt="<?php echo $portrait_url_alt; ?>" />
                        <?php if ($the_content) { ?>
                            <a href="<?php echo get_permalink(); ?>">
                            <?php } ?>
                            <strong><?php echo $title; ?></strong>
                            <br />
                            <?php echo $title_position; ?>
                            <?php if ($the_content) { ?>
                                [...]
                            </a>
                        <?php } ?>
                    </div>

            <?php
                } // endwhile;
            }
wp_reset_postdata(); ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>