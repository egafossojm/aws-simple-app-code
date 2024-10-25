<?php
/**
 * Template Name: Tools : Tools and Ressources
 *
 * This is the template that displays the page 'Tools & Ressources'
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header(); ?>
<div class="wrap">
	<div id="primary" class="content-area tools-section">
		<main id="main">
			<div class="row">
                <div class="col-sm-12">
                    <h1 class="bloc-title bloc-title--no-margin-bottom">
                        <span><?php the_title(); ?></span>
                    </h1>
                </div>
			</div>
            <?php
            $site_id = get_current_blog_id();

if ($site_id != 2) {
    // Include CE Place
    include locate_template('templates/tools/component-ceplace.php');
}  ?>
			<section class="row equal-col-md dual-col">
				<div class="col-md-8 left-content">
					<?php

        // Include Modèle lettre et courriels
        $slug_name = 'modeles-de-lettres';
include locate_template('templates/tools/component-modeles-lettres.php');

// Include Imagez vos explications
$slug_name = 'imagez-vos-explications';
include locate_template('templates/tools/component-imagez-vos-explications.php');

// Include Centre documentation sur la retraite
include locate_template('templates/tools/component-centre-documentation-retraite.php');

?>
				</div>

				<aside class="primary col-md-4">
					<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'sticky' => true,
            'staySticky' => true,
            'kv' => [
                'pos' => [
                    'btf',
                    'but1',
                    'right_bigbox_last',
                    'bottom_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [320,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
        ]
    );
?>
				</aside>
			</section>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer(); ?>