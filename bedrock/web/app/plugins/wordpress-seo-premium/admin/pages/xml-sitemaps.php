<?php

/**
 * @todo - [JRF => whomever] check for other sitemap plugins which may conflict ?
 * @todo - [JRF => whomever] check for existance of .xls rewrite rule in .htaccess from
 * google-sitemaps-plugin/generator and remove as it will cause errors for our sitemaps
 * (or inform the user and disallow enabling of sitemaps )
 * @todo - [JRF => whomever] check if anything along these lines is already being done
 */
if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$yform = Yoast_Form::get_instance();
$yform->admin_header(true, 'wpseo_xml');

$options = get_option('wpseo_xml');

echo '<br/>';
$yform->light_switch('enablexmlsitemap', __('XML sitemap functionality', 'wordpress-seo'));

$tabs = new WPSEO_Option_Tabs('sitemaps');
$tabs->add_tab(new WPSEO_Option_Tab('general', __('General', 'wordpress-seo'), ['video_url' => WPSEO_Shortlinker::get('https://yoa.st/screencast-sitemaps')]));

$title_options = WPSEO_Options::get_option('wpseo_titles');

if (empty($title_options['disable-author'])) {
    $tabs->add_tab(new WPSEO_Option_Tab('user-sitemap', __('User sitemap', 'wordpress-seo'), ['video_url' => WPSEO_Shortlinker::get('https://yoa.st/screencast-sitemaps-user-sitemap')]));
}

$tabs->add_tab(new WPSEO_Option_Tab('post-types', __('Post Types', 'wordpress-seo'), ['video_url' => WPSEO_Shortlinker::get('https://yoa.st/screencast-sitemaps-post-types')]));
$tabs->add_tab(new WPSEO_Option_Tab('exclude-post', __('Excluded Posts', 'wordpress-seo'), ['video_url' => WPSEO_Shortlinker::get('https://yoa.st/screencast-sitemaps-exclude-post')]));
$tabs->add_tab(new WPSEO_Option_Tab('taxonomies', __('Taxonomies', 'wordpress-seo'), ['video_url' => WPSEO_Shortlinker::get('https://yoa.st/screencast-sitemaps-taxonomies')]));

echo '<div id="sitemapinfo">';
$tabs->display($yform, $options);
echo '</div>';

/**
 * Fires at the end of XML Sitemaps configuration form.
 */
do_action('wpseo_xmlsitemaps_config');

$yform->admin_footer();
