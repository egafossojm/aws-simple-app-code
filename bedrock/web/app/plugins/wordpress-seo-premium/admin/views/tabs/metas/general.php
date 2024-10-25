<?php
/**
 * WPSEO plugin file.
 */
if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$wpseo_general_presenter = new WPSEO_Paper_Presenter(
    '',
    dirname(__FILE__).'/paper-content/general-content.php',
    [
        'paper_id' => 'settings-general',
    ]
);

echo $wpseo_general_presenter->get_output();
