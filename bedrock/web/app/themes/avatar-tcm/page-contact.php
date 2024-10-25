<?php
/**
 * Template Name: Contact Us
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header();
while (have_posts()) {
    the_post(); ?>
	<article class="base-article">
		<header>
			<h1><?php the_title(); ?> </h1>
		</header>
		<div class="row equal-col-md">
			<section class="col-md-8 article-body">
				<div class="row equal-col-md">
					<div class="col-md-12">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
			<aside class="col-md-4 primary">
	        	<?php //include Quick subscribe newsletters component
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
                            ],
                        ],
                        'sizes' => '[ [300,1050], [300,600], [300,250] ]',
                        'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
                    ],
                    $arr_avt_vars = [
                        'class' => 'bigbox text-center',
                    ]
                );
    ?>
					</div>
	        </aside>
		</div>
	</article>
<?php
    $avatar_wpseo = get_option('wpseo'); //from Yoast plugin

    function avatar_get_contact_point()
    {
        $avatar_contact_point = get_field('acf_contact_point');
        if ($avatar_contact_point) {
            $content_cp_arr = [];
            foreach ($avatar_contact_point as $contact_point) {
                $content_cp_arr[] = [
                    '@type' => 'ContactPoint',
                    'telephone' => "{$contact_point['acf_contact_point_telephone']}",
                    'contactType' => "{$contact_point['acf_contact_point_contacttype']}",
                    'contactOption' => "{$contact_point['acf_contact_point_contactoption']}",
                ];
            }
        }

        return $content_cp_arr;
    }

    if (get_field('acf_contact_point') and $avatar_wpseo) {

        $contentArr['@context'] = 'http://schema.org';
        $contentArr['@type'] = 'Organization';
        $contentArr['name'] = wp_kses_post($avatar_wpseo['company_name']);
        $contentArr['url'] = esc_url(get_home_url());
        $contentArr['logo'] = esc_url($avatar_wpseo['company_logo']);
        $contentArr['contactPoint'] = avatar_get_contact_point();

        $jsonld = json_encode($contentArr, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        echo '<script type="application/ld+json">';
        // Data is escaped
        echo $jsonld;
        echo '</script>';
    }

    ?>
<?php } get_footer(); ?>
