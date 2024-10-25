<?php
/**
 * WPSEO plugin file.
 */
if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$wpseo_breadcrumbs_presenter = new WPSEO_Paper_Presenter(
    esc_html__('Breadcrumbs settings', 'wordpress-seo'),
    dirname(__FILE__).'/paper-content/breadcrumbs-content.php',
    [
        'paper_id' => 'settings-breadcrumbs',
    ]
);
echo $wpseo_breadcrumbs_presenter->get_output();
