<!--begin alert bloc-->
<?php
$is_alert = $newsletter_block['acf_newsletter_section_alert'];
if ($is_alert) {

    $background = $site_color;
    $bgcolor = $site_color;
    $title_color = '#fff';
    $excerpt_color = '#fff';
    $date_color = '#fff';
    $category_color = '#fff';

}
include locate_template('templates/newsletter/newsletter_base_template.php');
?>
