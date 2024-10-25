<?php
/**
 * WPSEO plugin file.
 *
 *
 * @uses array $alerts_data
 */
$type = 'alerts';
$dashicon = 'warning';

$i18n_title = __('Problems', 'wordpress-seo');
$i18n_issues = __('We have detected the following issues that affect the SEO of your site.', 'wordpress-seo');
$i18n_no_issues = __('Good job! We could detect no serious SEO problems.', 'wordpress-seo');
$i18n_muted_issues_title = __('Muted problems:', 'wordpress-seo');

$active_total = count($alerts_data['errors']['active']);
$total = $alerts_data['metrics']['errors'];

$active = $alerts_data['errors']['active'];
$dismissed = $alerts_data['errors']['dismissed'];

require WPSEO_PATH.'admin/views/partial-alerts-template.php';
