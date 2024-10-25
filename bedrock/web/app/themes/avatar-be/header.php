<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="<?php echo esc_attr(substr(get_bloginfo('language'), 0, 2)); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!-- LiveConnectTag for advertisers -->
	<script type="text/javascript" src="//b-code.liadm.com/b-00t6.min.js" async="true" charset="utf-8"></script>
	<!-- LiveConnectTag for advertisers -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action('avatar_body'); ?>
	<div id="tc-site-context"></div>


	<?php
    // Only one of the two following template will exist in any given theme. avatar-tcm most not contain any of these two templates.
    //get_template_part( 'templates/market','watch' );
    get_template_part('templates/promotion-bar');
// end of Only one
?>

	<header class="site-main current-context-view-<?= get_current_view_context() ? get_current_view_context() : ''; ?>">
		<!-- Navigation -->
		<div class="site-header navbar navbar-toggleable-md" data-spy="affix" data-offset-top="110">
			<div class="site-header__container container">
				<div class="site-header__center">
					<div class="row row--no-margin">
						<div class="col-xs-2 col-md-4 col-left col-no-padding-xs-left">
							<button id="button-menu-main-js" class="site-header__center-button site-header__hamburger navbar-toggle" type="button" data-toggle="collapse" data-target="#menu-main">
								<span class="sr-only"><?php _e('Toggle navigation', 'avatar-tcm'); ?></span>
								<span class="site-header__hamburger-icon icon-bar"></span>
								<span class="site-header__hamburger-icon icon-bar"></span>
								<span class="site-header__hamburger-icon icon-bar"></span>
							</button>
						</div>
						<div class="col-xs-7 col-md-4 text-center c-logo">
							<?php if (function_exists('the_custom_logo')) { ?>
								<?php the_custom_logo(); ?>
							<?php } ?>
						</div>
						<div class="col-xs-3 col-md-4 text-right col-no-padding-xs-left">
							<button class="search-trigger hidden-lg" data-target="#search-box" data-toggle="collapse">
								<i class="fa fa-search" aria-hidden="true"></i>
								<span class="sr-only"><?php _e('Search', 'avatar-tcm'); ?></span>
							</button>
							<button type="button" class="site-header__center-button navbar-toggle" data-toggle="collapse" data-target="#menu-user">
								<i class="site-header__user-icon fa fa-user" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</div>
				<nav class="site-header__navigation-desktop">
					<!-- Brand and toggle get grouped for better mobile display -->
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="row">
						<div class="col-xs-12 user-m-contain">
							<?php
                        $theme_menu_location = avatar_user_have_access() ? 'header_user_in_newspaper' : (is_user_logged_in() ? 'header_user_in' : 'header_user');
$menu_user_arg = [
    'theme_location' => $theme_menu_location,
    'depth' => 2,
    'container' => 'div',
    'container_class' => 'menu-user collapse navbar-collapse',
    'container_id' => 'menu-user',
    'menu_class' => 'menu-user__list nav navbar-nav',
    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
    'walker' => new WP_Bootstrap_Navwalker,
];
wp_nav_menu($menu_user_arg);
?>
							<!-- /.navbar-collapse -->
						</div>
					</div>
					<?php if (is_single()) { ?>
						<p class='site-header__title-single' aria-label='article title'><?php the_title(); ?></p>
						<div class="site-header__socials-share">
							<?php get_template_part('templates/article/article-share', 'top'); ?>
						</div>
					<?php } ?>
					<div class="hidden-lg">
						<?php
                        //Mobile menu
                        $menu_main_arg_mobile = [
                            'menu' => 'mobile',
                            'theme_location' => 'header_main',
                            'depth' => 2,
                            'container' => 'div',
                            'container_class' => 'collapse navbar-collapse',
                            'container_id' => 'menu-main',
                            'menu_class' => 'site-header__menu-main menu-main nav navbar-nav color-mobile',
                            'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                            'walker' => new WP_Bootstrap_Navwalker,
                        ];
wp_nav_menu($menu_main_arg_mobile);
?>
					</div>
					<div class="hidden visible-lg">
						<?php
//Desktop menu
$menu_main_arg = [
    'theme_location' => 'header_main',
    'depth' => 2,
    'container' => 'div',
    'container_class' => 'collapse navbar-collapse',
    'container_id' => 'menu-main',
    'menu_class' => 'site-header__menu-main menu-main nav navbar-nav',
    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
    'walker' => new WP_Bootstrap_Navwalker,
];
wp_nav_menu($menu_main_arg); ?>
					</div>
					<div id="search-box" class="collapse search-box">
						<form class="text-center search-box__form form-inline" action="<?php echo home_url(); ?>">
							<input type="search" name="s" id="search" value="" placeholder="<?php esc_attr_e('Search', 'avatar-tcm'); ?>" class="search-box__input form-control form-control--small-width form-control--sticky no-border-radius" />
							<input type="hidden" name="post_type" value="post">
							<button type="submit" class="search-box__button btn btn-lg user-form__btn-submit user-form__btn-submit--search no-border-radius component-quick-subscribe-newsletters__button" title="<?php esc_attr_e('Search', 'avatar-tcm'); ?>"><?php esc_attr_e('Search', 'avatar-tcm'); ?></button>
						</form>
					</div>
				</nav>
			</div>
		</div>
		<div class="row"></div>
		<?php // publicity
        $page_obj = get_field('acf_brand_knowledge_page', 'option');
//Hide ads on Brand Knowledge homepage
if (! empty($page_obj) && get_the_ID() !== $page_obj->ID) { ?>
			<?php if (! avatar_acf_value(get_the_id(), 'acf_microsite_no_publicity', false)) {  ?>
				<div style="height: 65px" class="hidden visible-lg"></div>
				<div class="container container-ads m32-stick">

					<div class="row">
						<div class="col-md-12 container-ads__ad text-center">
							<?php
                    $arr_m32_vars = [
                        'isCompanion' => true,
                        'kv' => [
                            'pos' => [
                                'atf',
                                'but1',
                                'top_leaderboard',
                            ],
                        ],
                        'sizes' => '[ [320,50], [300,50], [728,90], [970,250], [980,200], [970,60], [980,60] ]',
                        'sizeMapping' => '[ [[0,0], [[320,50], [300,50]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90], [970,250], [980,200], [970,60], [980,60]]] ]',
                    ];
			    $arr_avt_vars = [
			        'class' => 'leaderboard',
			    ];
			    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

			    ?>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } // end publicity
?>
	</header>
	<!-- Page Content -->


	<?php
    if (! avatar_acf_field_exists(get_the_id(), 'acf_microsite_no_publicity') && ! is_front_page()) {
        get_template_part('templates/breadcrumb', 'menu');
    }
?>


	<div class="container container-content container-w">
