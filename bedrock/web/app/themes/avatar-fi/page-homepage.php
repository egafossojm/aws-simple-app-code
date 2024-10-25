<?php
/**
*Template Name: Page : HomePage
**/
?>
<?php get_header(); ?>
<div class="wrap">
<div id="primary" class="content-area">
	<main id="main" class="homepage" >
		<section class="row equal-col-md">
			<div class="col-md-8 left-content">
				<?php
                    // Include Top Story
                    include locate_template('templates/homepage/component-top-story.php');

//include Scheduler Area recommended
include locate_template('templates/homepage/component-scheduler-recommended.php');
?>
				</div>
				<aside class="primary col-md-4">
					<?php
        //include Quick subscribe newsletters component
           avatar_include_subscription_module();
?>
						<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
							<?php
        at_get_the_m32banner(
            $arr_m32_vars = [
                'kv' => [
                    'pos' => [
                        'atf',
                        'but1',
                        'right_bigbox',
                        'home_bigbox',
                        'top_right_bigbox',
                    ],
                ],
                'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
            ],
            $arr_avt_vars = [
                'class' => 'bigbox text-center',
            ]
        );
?>
						</div>
					<?php

                        // Include video widget for FI
                        if (SHOW_HOMEPAGE_VIDEO_WIDGET) {
                            include locate_template('templates/general/component-video-dark.php');
                        }

?>
				</aside>
		</section>
		<div class="row">
			<div class="col-md-12 leaderboard-fullwrap top-border">
				<?php
at_get_the_m32banner(
    $arr_m32_vars = [
        'kv' => [
            'pos' => [
                'btf',
                'but1',
                'middle_leaderboard',
                'home_leaderboard',
                'mid_leaderboard',
            ],
        ],
        'sizes' => '[ [728,90], [970,250], [980,200] ]',
        'sizeMapping' => '[ [[0,0], [[320,50]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90], [970,250], [980,200]]] ]',
    ],
    $arr_avt_vars = [
        'class' => 'leaderboard',
    ]
);
?>
			</div>
		</div>
		<section class="row equal-col-md">
			<div class="col-md-8 left-content">
				<?php
//include In Depth component
include locate_template('templates/homepage/component-in-depth.php');

//include Building Your Business component
include locate_template('templates/homepage/component-building-your-business.php');

//include Inside Track component
include locate_template('templates/homepage/component-inside-track.php');
?>
			</div>
			<aside class="primary col-md-4">
				<?php
    //include Cxense most popular/shared component
    include locate_template('templates/general/component-cxense-most.php');
?>
				<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
					<?php
        at_get_the_m32banner(
            $arr_m32_vars = [
                'kv' => [
                    'pos' => [
                        'btf',
                        'but2',
                        'right_bigbox',
                        'home_bigbox',
                        'bottom_right_bigbox',
                    ],
                ],
                'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
            ],
            $arr_avt_vars = [
                'class' => 'bigbox text-center',
            ]
        );
?>
				</div>
                <?php
                //include tools and resources component
    include locate_template('templates/tools/component-tools-and-ressources.php');
?>
			</aside>
		</section>
		<div class="row">
			<div class="col-md-12 leaderboard-fullwrap top-border">
				<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'kv' => [
                'pos' => [
                    'btf',
                    'but1',
                    'middle_leaderboard',
                    'home_leaderboard',
                    'mid_leaderboard',
                ],
            ],
            'sizes' => '[ [728,90], [970,250], [980,200] ]',
            'sizeMapping' => '[ [[0,0], [[320,50]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90], [970,250], [980,200]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'leaderboard',
        ]
    );
?>
			</div>
		</div>
		<section class="row equal-col-md">
			<div class="col-md-8 left-content">
				<?php
//include Inside Track component
include locate_template('templates/homepage/component-newspaper-date.php');
?>
				<div class="row equal-col">

					<div class="col-md-6 col-sm-6">
						<?php
            //include Scheduler Area 1 component
            include locate_template('templates/homepage/component-scheduler-brand-knowledge.php');

//include Scheduler Area 2 component
include locate_template('templates/homepage/component-scheduler-partners-reports.php');
?>
					</div>
					<div class="col-md-6 col-sm-6">
					<?php include locate_template('templates/homepage/component-insight.php'); ?>
						<?php
    at_get_the_m32banner(
        $arr_m32_vars = [
            'kv' => [
                'pos' => [
                    'btf',
                    'but2',
                    'center_bigbox',
                    'bottom_bigbox',
                    'home_bigbox',
                    'mid_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
        ],
        $arr_avt_vars = [
            'class' => 'bigbox text-center',
        ]
    );
?>
					</div>
				</div>
			</div>
			<aside class="primary col-md-4">
				<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
					<?php
at_get_the_m32banner(
    $arr_m32_vars = [
        'kv' => [
            'pos' => [
                'btf',
                'but2',
                'right_bigbox',
                'bottom_bigbox',
                'home_bigbox',
                'bottom_right_bigbox',
            ],
        ],
        'sizes' => '[ [300,250] ]',
        'sizeMapping' => '[ [[0,0], [[320,50], [300,250], [300,600]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
    ],
    $arr_avt_vars = [
        'class' => 'bigbox text-center',
    ]
);
?>
				</div>
				<?php
//include Tools Parter's place component
include locate_template('templates/homepage/component-partners-place.php');
?>
			</aside>
		</section>
	</main>
	<!-- #main -->
	</div><!-- #primary -->
</div>
<!-- .wrap -->
<?php get_footer();
