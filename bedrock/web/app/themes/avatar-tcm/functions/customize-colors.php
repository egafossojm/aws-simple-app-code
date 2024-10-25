<?php
/* -------------------------------------------------------------
 *  Customizer functionality for Main Color
 * ============================================================*/

// #e22028 is default primary color

if (! function_exists('avatar_customize_register')) {

    function avatar_customize_register($wp_customize)
    {

        // Remove the core header textcolor control, as it shares the main text color.
        $wp_customize->remove_control('header_textcolor');

        // Add Primary color setting and control.
        $wp_customize->add_setting('primary_color', [
            'default' => '#e22028',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'refresh',
            // 'transport'         => 'postMessage',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', [
            'label' => __('Primary Color', 'avatar-tcm'),
            'section' => 'colors',
        ]));

    }
    add_action('customize_register', 'avatar_customize_register', 11);
}

/* -------------------------------------------------------------
 * Enqueues front-end CSS for the Primary color.
 * ============================================================*/

function avatar_primary_color_css()
{

    $primary_color = get_theme_mod('primary_color', '#e22028');

    // Don't do anything if the current color is the default.
    if ($primary_color == '#e22028') {
        return;
    }

    $css = '
			.icons:after,
			.icons:before,
			.menu-user__link.active,
			.most-top5__rank,
			.related-news-module__link:hover,
			.text-content__link:hover,
			.text-content__category-label,
			.text-content__category-label a,
			.article-body a:hover,
			.text-content__item a:hover,
			.text-content__excerpt a:hover,
			.taxonomies-link__description a:hover,
			.site-header__center-button:hover,
			.user-header__link,
			.user-form__legend-title,
			.user-why-content__title,
			.user-side-box__title,
			.user-form__panel-title,
			.user-form__btn-submit:focus,
			.user-form__btn-submit:hover,
			.validation-box,
			.user-form-confirmation__icon,
			.user-form-confirmation__title,
			.user-form-confirmation__link,
			.user-profile-header__title,
			.user-profile-menu__item.active .user-profile-menu__icon,
			.user-profile-menu__item.active .user-profile-menu__link,
			.user-profile-menu__item:hover,
			.user-profile-menu__icon:hover,
			.user-profile-menu__item.active,
			.user-profile-menu__link:hover,
			.user-profile-menu__link:focus,
			.user-profile-menu__link:hover .user-profile-menu__icon,
			.user-profile-menu__link:focus .user-profile-menu__icon,
			.user-profile-menu__text:hover,
			.user-profile-menu__text:focus,
			.most-top-list__rank,
			.bold-text--color,
			.search-highlight,
			.component-newspaper a.bloc-title__link,
			.component-newspaper .bloc-title__caret,
			.component-newspaper__btn_required,
			.backissue--list-title .bloc-title__text--color,
			.backissue--list-title .bloc-title__caret,
			.tools-section .btn:hover,
			.slideshow_trigger:hover span,
			.slideshow_trigger:hover figure i,
			.tools-module--tools-resources .bg .text .pub-details,
			.tools-module--tools-resources .bg .text .pub-details span,
			.tools-module--tools-resources .bg .text .pub-details span:first-child,
			.dropdown-menu>li>a:hover,
			.entity-box-listing--podcast h2:after,
			.micro-module .social ul li a,
			.keyword-pop .header a,
			.keyword-pop .closepop,
			.keypop-trigger {
			    color:  %1$s;
			}

			.ias-trigger-prev a,
			.ias-trigger a,
			.footer-top,
			.avatar-topic-select,
			.btn-footer,
			.site-header__center-button:hover .site-header__hamburger-icon,
			.featured-video:hover .videos-caret--featured,
			.user-form__btn-submit,
			.validation-box__item,
			.user-form__btn-submit--negative,
			.backissues-title,
			.micro-module .btn,
			.video-brightcove-iframe .vjs-big-play-button,
			.video-brightcove-iframe .vjs-big-play-button:hover,
			.video-brightcove-iframe .vjs-big-play-button:focus,
			.micro-module .subscriptions .btn{
			    background:  %1$s;
			}

			.user-form__btn-submit:focus, .user-form__btn-submit:hover,
			.validation-box,
			.user-form-confirmation__title,
			.tools-section .btn:hover {
				    border-color:%1$s;
			}

			.ias-spinner svg circle {
				stroke: %1$s;
			}
			.std-btn {
				background-color:  %1$s;
			}

		';
    wp_add_inline_style('avatar-tcm', sprintf($css, $primary_color));
}
add_action('wp_enqueue_scripts', 'avatar_primary_color_css', 11);
