<?php

/**
 * Template Name: Media Kit
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>

<!-- Get ACF Fields -->
<?php
// ACF Topbar fields
$topbar = get_field('topbar');
if ($topbar) {
    $topbar_bg = $topbar['background_color'];
    $topbar_title = $topbar['title'];
    $topbar_subtitle = $topbar['subtitle'];
    $topbar_description = $topbar['description'];

}

// ACF Main content fields
$main_content = get_field('content');
if ($main_content) {
    $main_content_title = $main_content['title'];
    $main_content_subtitle = $main_content['subtitle'];
    $main_content_left_column = $main_content['left_column'];
    $main_content_right_column = $main_content['right_column'];
}

// ACF Button links fields
$button_link = get_field('link');
if ($button_link) {
    $button_link_name = $button_link['link_name'];
    $button_link_url = $button_link['url'];
}
?>
<?php get_header(); ?>
    <div class="container container-content container-w">
        <div class="wrap">
            <div class="content-area">
                    <section id="mediakit-topbar" class="row equal-col-md">
                        <div class="mediakit-topbar" style="background-color: <?php echo $topbar_bg; ?>">
                            <div class="mediakit-container">
                                <div class="topbar-bloc-container">
                                    <span class="mediakit-topbar-content-title"><?php echo $topbar_title; ?></span>
                                    <span class="mediakit-topbar-content-subtitle"><?php echo $topbar_subtitle; ?></span>
                                </div>
                                <div class="topbar-bloc-container">
                                    <span class="mediakit-topbar-content-description"><?php echo $topbar_description; ?></span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <main>
                        <section id="mediakit-content">
                            <div class="main-content-header">
                                <h1 class="main-content-title"><?php echo $main_content_title; ?></h1>
                                <div class="main-content-title-seperator"><hr></div>
                                <h2 class="main-content-subtitle"><?php echo $main_content_subtitle; ?></h2>
                            </div>
                            <div class="main-content-container">
                                <!-- Left column -->
                                <div>
                                    <span><?php echo $main_content_left_column; ?></span>
                                </div>

                                <!-- Right column -->
                                <div>
                                    <span><?php echo $main_content_right_column; ?></span>
                                </div>
                            </div>

                            <div class="download-mediakit-btn"><a class="btn btn-footer" href="<?php echo $button_link_url; ?>"><?php echo $button_link_name; ?></a></div>
                        </section>
                    </main>
            </div>
        </div>
    </div>
<?php get_footer(); ?>