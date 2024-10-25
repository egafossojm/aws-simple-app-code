<?php

if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$version = '3.4';

/**
 * Display a list of contributors
 *
 * @param  array  $contributors  Contributors' data, associative by GitHub username.
 */
function wpseo_display_contributors($contributors)
{
    foreach ($contributors as $username => $dev) {
        echo '<li class="wp-person">';
        echo '<a href="', esc_url('https://github.com/'.$username), '" class="web"><img src="//gravatar.com/avatar/', $dev->gravatar, '?s=120" class="gravatar" alt="">', $dev->name, '</a>';
        echo '<span class="title">', $dev->role, "</span></li>\n";
    }
}

?>

<div class="wrap about-wrap">

	<h1><?php
        /* translators: %1$s expands to Yoast SEO */
        printf(__('Thank you for updating %1$s!', 'wordpress-seo'), 'Yoast SEO');
?></h1>

	<p class="about-text">
		<?php
/* translators: %1$s and %2$s expands to anchor tags, %3$s expands to Yoast SEO */
printf(__('While most of the development team is at %1$sYoast%2$s in the Netherlands, %3$s is created by a worldwide team.', 'wordpress-seo'), '<a target="_blank" href="https://yoast.com/">', '</a>', 'Yoast SEO');
echo ' ';
/* translators: 1: link open tag; 2: link close tag. */
printf(__('Want to help us develop? Read our %1$scontribution guidelines%2$s!', 'wordpress-seo'), '<a target="_blank" href="'.WPSEO_Shortlinker::get('https://yoa.st/wpseocontributionguidelines').'">', '</a>');
?>
	</p>

	<div class="wp-badge"></div>

	<h2 class="nav-tab-wrapper" id="wpseo-tabs">
		<a class="nav-tab" href="#top#credits" id="credits-tab"><?php esc_html_e('Credits', 'wordpress-seo'); ?></a>
		<a class="nav-tab" href="#top#integrations" id="integrations-tab"><?php esc_html_e('Integrations', 'wordpress-seo'); ?></a>
	</h2>

	<div id="credits" class="wpseotab">
		<h2 class="screen-reader-text"><?php esc_html_e('Team and contributors', 'wordpress-seo'); ?></h2>

		<h3 class="wp-people-group"><?php esc_html_e('Product Management', 'wordpress-seo'); ?></h3>
		<ul class="wp-people-group " id="wp-people-group-project-leaders">
			<?php
    $people = [
        'jdevalk' => (object) [
            'name' => 'Joost de Valk',
            'role' => __('Project Lead', 'wordpress-seo'),
            'gravatar' => 'f08c3c3253bf14b5616b4db53cea6b78',
        ],
        'mariekerakt' => (object) [
            'name' => 'Marieke van de Rakt',
            'role' => __('Head R&D', 'wordpress-seo'),
            'gravatar' => '1d83533e299c379140f9fcc2cb0015cb',
        ],
        'irenestr' => (object) [
            'name' => 'Irene Strikkers',
            'role' => __('Linguist', 'wordpress-seo'),
            'gravatar' => '074d67179d52561e36e57e8e9ea8f8cf',
        ],
    ];

wpseo_display_contributors($people);
?>
		</ul>
		<h3 class="wp-people-group"><?php esc_html_e('Development Leaders', 'wordpress-seo'); ?></h3>
		<ul class="wp-people-group " id="wp-people-group-development-leaders">
			<?php
$people = [
    'omarreiss' => (object) [
        'name' => 'Omar Reiss',
        'role' => __('CTO', 'wordpress-seo'),
        'gravatar' => '86aaa606a1904e7e0cf9857a663c376e',
    ],
    'atimmer' => (object) [
        'name' => 'Anton Timmermans',
        'role' => __('Architect', 'wordpress-seo'),
        'gravatar' => 'b3acbabfdd208ecbf950d864b86fe968',
    ],
    'moorscode' => (object) [
        'name' => 'Jip Moors',
        'role' => __('Architect', 'wordpress-seo'),
        'gravatar' => '1751c5afc377ef4ec07a50791db1bc52',
    ],
];

wpseo_display_contributors($people);
?>
		</ul>
		<h3 class="wp-people-group"><?php esc_html_e('Yoast Developers', 'wordpress-seo'); ?></h3>
		<ul class="wp-people-group " id="wp-people-group-core-developers">
			<?php
$people = [
    'afercia' => (object) [
        'name' => 'Andrea Fercia',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '074af62ea5ff218b6a6eeab89104f616',
    ],
    'rarst' => (object) [
        'name' => 'Andrey Savchenko',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => 'c445c2491f9f55409b2e4dccee357961',
    ],
    'andizer' => (object) [
        'name' => 'Andy Meerwaldt',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => 'a9b43e766915b48031eab78f9916ca8e',
    ],
    'boblinthorst' => (object) [
        'name' => 'Bob Linthorst',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '8063b1955f54681ef3a2deb21972faa1',
    ],
    'CarolineGeven' => (object) [
        'name' => 'Caroline Geven',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => 'f2596a568c3974e35f051266a63d791f',
    ],
    'terw-dan' => (object) [
        'name' => 'Danny Terwindt',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '20a04b0736e630e80ce2dbefe3f1d62f',
    ],
    'diedexx' => (object) [
        'name' => 'Diede Exterkate',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '59908788f406037240ee011388db29f8',
    ],
    'irenestr' => (object) [
        'name' => 'Irene Strikkers',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '074d67179d52561e36e57e8e9ea8f8cf',
    ],
    'jcomack' => (object) [
        'name' => 'Jimmy Comack',
        'role' => __('Developer', 'wordpress-seo'),
        'gravatar' => '41073ef9e1f3e01b03cbee75cee33bd4',
    ],
];

wpseo_display_contributors($people);
?>
		</ul>
		<h3 class="wp-people-group"><?php esc_html_e('Quality Assurance & Testing', 'wordpress-seo'); ?></h3>
		<ul class="wp-people-group " id="wp-people-group-qa-testing">
			<?php
$people = [
    'tacoverdo' => (object) [
        'name' => 'Taco Verdonschot',
        'role' => __('QA & Translations Manager', 'wordpress-seo'),
        'gravatar' => 'd2d3ecb38cacd521926979b5c678297b',
    ],
    'benvaassen' => (object) [
        'name' => 'Ben Vaassen',
        'role' => __('QA', 'wordpress-seo'),
        'gravatar' => 'e186ff6435b02a7bc1c7185dd66b7e64',
    ],
    'monbauza' => (object) [
        'name' => 'Ramon Bauza',
        'role' => __('Tester', 'wordpress-seo'),
        'gravatar' => 'de09b8491ab1d927e770f7519219cfc9',
    ],
    'boblinthorst' => (object) [
        'name' => 'Bob Linthorst',
        'role' => __('Tester', 'wordpress-seo'),
        'gravatar' => '8063b1955f54681ef3a2deb21972faa1',
    ],
];

wpseo_display_contributors($people);
?>
		</ul>
		<?php
        $patches_from = [];
if (! empty($patches_from)) {
    $call_to_contribute = sprintf(
        /* translators: %1$s expands to Yoast SEO, %2$s to the version number of the plugin. */
        __('We\'re always grateful for patches from non-regular contributors, in %1$s %2$s, patches from the following people made it in:', 'wordpress-seo'),
        'Yoast SEO',
        $version
    );
    ?>
			<h3 class="wp-people-group"><?php esc_html_e('Community contributors', 'wordpress-seo'); ?></h3>
			<p><?php echo $call_to_contribute; ?></p>
			<ul class="ul-square">
				<?php
        foreach ($patches_from as $patcher => $link) {
            echo '<li><a href="', esc_url($link), '">', $patcher, '</a></li>';
        }
    ?>
			</ul>
		<?php } ?>
	</div>

	<div id="integrations" class="wpseotab">
		<h2>
			<?php
            printf(
                /* translators: %1$s expands to Yoast SEO */
                esc_html__('%1$s Integrations', 'wordpress-seo'),
                'Yoast SEO'
            );
?>
		</h2>
		<p class="about-description">
			<?php
printf(
    /* translators: 1: expands to "Yoast SEO"; 2: emphasis open tag; 3: emphasis close tag. */
    esc_html__('%1$s 3.0 brought a way for theme builders and custom field plugins to integrate with %1$s. These integrations make sure that %2$sall%3$s the data on your page is used for the content analysis. On this page, we highlight the frameworks that have nicely working integrations.', 'wordpress-seo'),
    'Yoast SEO',
    '<em>',
    '</em>'
);
?>
		</p>

		<ol>
			<li>
				<?php
    printf(
        /* translators: 1: link open tag; 2: link close tag; 3: Yoast; 4: linked developer name. */
        esc_html__('%1$s%3$s ACF Integration%2$s - an integration built by %4$s and Team %3$s', 'wordpress-seo'),
        '<a target="_blank" href="https://wordpress.org/plugins/yoast-seo-acf-analysis/">',
        '</a>',
        'Yoast',
        '<a href="https://forsberg.ax" target="_blank" rel="noreferrer noopener">Marcus Forsberg</a>, '.
        '<a href="http://kraftner.com/" target="_blank" rel="noreferrer noopener">Thomas Kräftner</a>, '.
        '<a href="https://angrycreative.se/" target="_blank" rel="noreferrer noopener">Angry Creative</a>'
    );
?>
			</li>
			<li><a href="https://www.elegantthemes.com/plugins/divi-builder/" target="_blank" rel="noreferrer noopener">Divi Builder</a></li>
			<li><a href="https://vc.wpbakery.com/" target="_blank" rel="noreferrer noopener">Visual Composer</a></li>
		</ol>

		<h3><?php esc_html_e('Other integrations', 'wordpress-seo'); ?></h3>
		<p class="about-description">
			<?php esc_html_e('We\'ve got other integrations we\'d like to tell you about:', 'wordpress-seo'); ?>
		</p>

		<ol>
			<li>
				<?php
printf(
    /* translators: 1,2: link open tag; 3: link close tag; 4: Yoast SEO. */
    esc_html__('%1$sGlue for %4$s &amp; AMP%3$s - an integration between %2$sthe WordPress AMP plugin%3$s and %4$s.', 'wordpress-seo'),
    '<a target="_blank" rel="noreferrer noopener" href="https://wordpress.org/plugins/glue-for-yoast-seo-amp/">',
    '<a target="_blank" rel="noreferrer noopener" href="https://wordpress.org/plugins/amp/">',
    '</a>',
    'Yoast SEO'
);
?>
			</li>
		</ol>
	</div>
</div>
