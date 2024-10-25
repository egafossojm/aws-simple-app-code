<?php
$all_fields = get_fields(get_the_ID());
$campaign = $all_fields['acf_newsletter_template']['value'];
$send_date = $all_fields['acf_newsletter_send_date'];
$tc_logo = get_template_directory_uri().'/assets/images/Logo-Contex-RGB-fr.png';
$site_logo = get_stylesheet_directory_uri().'/assets/images/site-logo.png';
$background = '#fff';
$bgcolor = '#fff';
$category_color = '#1e73be';
$title_color = '#222';
$excerpt_color = '#222';
$date_color = '#9f9fa0';
$site_color = get_theme_mod('primary_color');
$category_color = $site_color;
/* -------------------------------------------------------------
 * Permalink URL for newsletter
 * ============================================================*/

function avatar_add_utm_to_url($url, $campaign)
{

    switch ($campaign) {
        case 'template_av_vosnouvellesdumardi':
            $campaign_name = 'Daily_Bulletin';
            break;
        case 'template_av_vosnouvellesdujeudi':
            $campaign_name = 'Daily_Bulletin';
            break;
        case 'template_av_vosnouvellesprefereesdumois':
            $campaign_name = 'Palmares_Mois';
            break;
        case 'template_av_editionspeciale':
            $campaign_name = 'Breaking_News';
            break;
        default:
            $campaign_name = 'INT-EN';
            break;
    }

    return add_query_arg(
        [
            'utm_source' => 'EmailMarketing',
            'utm_medium' => 'email',
            'utm_content' => str_replace(' ', '', strtolower(get_bloginfo('name'))),
            'utm_campaign' => str_replace(' ', '-', $campaign_name),
        ], $url
    );
}

function avatar_get_the_permalink_url($url, $campaign)
{

    return esc_url(avatar_add_utm_to_url($url, $campaign));

}

$newsletter_template = $campaign;
//Get liveintent codes
$li_codes = avatar_newsletter_li_code($newsletter_template);

switch ($newsletter_template) {
    case 'template_av_vosnouvellesdumardi':
        $newsletter_template_wording = __('Vos nouvelles du mardi', 'avatar-tcm');
        $prepend_date = date_i18n('l', strtotime($send_date));
        $showDayOfMonth = true;
        break;
    case 'template_av_vosnouvellesdujeudi':
        $newsletter_template_wording = __('Vos nouvelles du jeudi', 'avatar-tcm');
        $prepend_date = date_i18n('l', strtotime($send_date));
        $showDayOfMonth = true;
        break;
    case 'template_av_vosnouvellesprefereesdumois':
        $newsletter_template_wording = __('Vos nouvelles préférées du mois', 'avatar-tcm');
        $prepend_date = '';
        $showDayOfMonth = false;
        break;
    case 'template_av_editionspeciale':
        $newsletter_template_wording = __('Édition spéciale', 'avatar-tcm');
        $showDayOfMonth = true;
        break;
    default:
        $newsletter_template_wording = __('Your e-newsletter and alerts', 'avatar-tcm');
        $showDayOfMonth = true;
        break;
}
if ($newsletter_template == 'template_av_vosnouvellesdumardi') {

}
$newsletter_block_array = $all_fields['acf_newsletter_block'];

$user_profile_page = get_field('acf_profile_newsletters', 'option');
$user_profile_page_url = 'https://tc.avantages.ca/T/WF/4601/qR4iev/Subscription/CL[[=Contact.idContact;]]/[[=Contact.clKey;]]/Form.ofsys';

?>

 <?php
     include locate_template('templates/newsletter/liveintent/ad_slot_init.php');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>AV Responsive Newsletter</title>
  <meta name="viewport" content="width=device-width">
  <!-- For testing only -->
</head>
<body style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">

  <!-- For testing only -->

  <style type="text/css">
@media only screen and (max-width: 728px) {
  .row.header.advert {
    display: none !important;
  }
}
@media (max-width: 600px) {
  table[class="body"] {
    overflow: hidden!important;
  }
  table[class="body"] img {
    width: auto !important; height: auto !important;
  }
  table[class="body"] center {
    min-width: 0 !important;
  }
  table[class="body"] .container {
    width: 95% !important;
  }
  table[class="body"] .row {
    width: 100% !important; display: block !important;
  }
  table[class="body"] .wrapper {
    display: block !important; padding-right: 0 !important;
  }
  table[class="body"] .columns {
    table-layout: fixed !important; float: none !important; width: 100% !important; padding-right: 0px !important; padding-left: 0px !important; display: block !important;
  }
  table[class="body"] .column {
    table-layout: fixed !important; float: none !important; width: 100% !important; padding-right: 0px !important; padding-left: 0px !important; display: block !important;
  }
  table[class="body"] .wrapper.first .columns {
    display: table !important;
  }
  table[class="body"] .wrapper.first .column {
    display: table !important;
  }
  table[class="body"] table.columns td {
    width: 100% !important;
  }
  table[class="body"] table.column td {
    width: 100% !important;
  }
  table[class="body"] .columns td.one {
    width: 8.333333% !important;
  }
  table[class="body"] .column td.one {
    width: 8.333333% !important;
  }
  table[class="body"] .columns td.two {
    width: 16.666666% !important;
  }
  table[class="body"] .column td.two {
    width: 16.666666% !important;
  }
  table[class="body"] .columns td.three {
    width: 25% !important;
  }
  table[class="body"] .column td.three {
    width: 25% !important;
  }
  table[class="body"] .columns td.four {
    width: 33.333333% !important;
  }
  table[class="body"] .column td.four {
    width: 33.333333% !important;
  }
  table[class="body"] .columns td.five {
    width: 41.666666% !important;
  }
  table[class="body"] .column td.five {
    width: 41.666666% !important;
  }
  table[class="body"] .columns td.six {
    width: 50% !important;
  }
  table[class="body"] .column td.six {
    width: 50% !important;
  }
  table[class="body"] .columns td.seven {
    width: 58.333333% !important;
  }
  table[class="body"] .column td.seven {
    width: 58.333333% !important;
  }
  table[class="body"] .columns td.eight {
    width: 66.666666% !important;
  }
  table[class="body"] .column td.eight {
    width: 66.666666% !important;
  }
  table[class="body"] .columns td.nine {
    width: 75% !important;
  }
  table[class="body"] .column td.nine {
    width: 75% !important;
  }
  table[class="body"] .columns td.ten {
    width: 83.333333% !important;
  }
  table[class="body"] .column td.ten {
    width: 83.333333% !important;
  }
  table[class="body"] .columns td.eleven {
    width: 91.666666% !important;
  }
  table[class="body"] .column td.eleven {
    width: 91.666666% !important;
  }
  table[class="body"] .columns td.twelve {
    width: 100% !important;
  }
  table[class="body"] .column td.twelve {
    width: 100% !important;
  }
  table[class="body"] td.offset-by-one {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-two {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-three {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-four {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-five {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-six {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-seven {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-eight {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-nine {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-ten {
    padding-left: 0 !important;
  }
  table[class="body"] td.offset-by-eleven {
    padding-left: 0 !important;
  }
  table[class="body"] table.columns td.expander {
    width: 1px !important;
  }
  table[class="body"] .right-text-pad {
    padding-left: 10px !important;
  }
  table[class="body"] .text-pad-right {
    padding-left: 10px !important;
  }
  table[class="body"] .left-text-pad {
    padding-right: 10px !important; padding-left: 10px !important;
  }
  table[class="body"] .text-pad-left {
    padding-right: 10px !important; padding-left: 10px !important;
  }
  table[class="body"] .hide-for-small {
    display: none !important;
  }
  table[class="body"] .show-for-desktop {
    display: none !important;
  }
  table[class="body"] .show-for-small {
    display: inherit !important;
  }
  table[class="body"] .hide-for-desktop {
    display: inherit !important;
  }
  table.facebook td {
    background: #3b5998; border-color: #2d4473;
  }
  table.facebook:hover td {
    background: #2d4473 !important;
  }
  table.twitter td {
    background: #00acee; border-color: #0087bb;
  }
  table.twitter:hover td {
    background: #0087bb !important;
  }
  table.google-plus td {
    background-color: #DB4A39; border-color: #CC0000;
  }
  table.google-plus:hover td {
    background: #CC0000 !important;
  }
  .template-label {
    color: #ffffff; font-weight: bold; font-size: 11px;
  }
  .callout .panel {
    background: #ECF8FF; border-color: #b9e5ff;
  }
  .advert {
    background: #999999;
  }
  .header .columns {
    background: #fff;
  }
  .footer h5 {
    padding-bottom: 10px;
  }
  table.columns .text-pad {
    padding-left: 10px; padding-right: 10px;
  }
  table.columns .left-text-pad {
    padding-left: 10px;
  }
  table.columns .right-text-pad {
    padding-right: 10px;
  }
  #newsletterAV .bigbox-cell {
    text-align: center;
  }
  #newsletterAV .bigbox-cell img {
    display: inline;
  }
  #newsletterAV .date-info {
    text-align: left !important;
  }
  .header .wrapper.last .date-info {
    padding-bottom: 10px !important;
  }
  .welcome-msg .wrapper .sub-columns {
    padding-bottom: 10px !important;
  }
  .welcome-msg .wrapper .sub-columns p {
    line-height: 15px; margin-bottom: 3px !important;
  }
  .alert-bloc .wrapper.last .sub-columns {
    padding: 13px 10px !important;
  }
  .news-list .wrapper.ad {
    background: #d9d9d9; padding-top: 20px !important;
  }
  .wrapper.ad .bigbox-cell {
    padding-bottom: 0 !important;
  }
  .multimedia-centre .multimedia-news .wrapper {
    padding-bottom: 0 !important; margin-top: 0;
  }
  .multimedia-centre .multimedia-news .wrapper .thumb-text-float {
    padding-top: 0;
  }
  .multimedia-centre .multimedia-news .wrapper td {
    padding-right: 20px;
  }
  .special-features .wrapper td {
    padding-right: 20px;
  }
  .special-features .wrapper.last td {
    padding-right: 10px;
  }
  .special-features .thumb-listing .thumb-text-float {
    padding-top: 10px !important; padding-bottom: 0 !important;
  }
  .partners-place .wrapper .section-listing tr td {
    border: none !important;
  }
  .partners-place .wrapper .section-listing tr tr td {
    padding-right: 15px !important; padding-left: 15px !important;
  }
  .partners-place .wrapper .section-listing tr td img {
    margin-bottom: 10px !important;
  }
  .partners-place .wrapper .section-listing tr+tr td {
    padding-bottom: 15px !important;
  }
  .partners-place .wrapper .section-listing tr+tr td+td {
    padding-bottom: 0px !important;
  }
  .partners-place .wrapper .section-listing .five {
    width: 85% !important;
  }
  .partners-place .wrapper .section-listing .seven {
    width: 85% !important;
  }
  .ce-place .full-section {
    padding: 0 !important;
  }
  .ce-place .section-listing .wrapper {
    padding: 0 0 10px !important;
  }
  .ce-place .section-listing .ad {
    padding: 20px 0 !important; background-color: #D9D9D9;
  }
  .partners-place .wrapper .section-listing tr tr td.six {
    padding: 0 !important; width: 50% !important; float: left !important; clear: none !important; border: none !important;
  }
}

@media only screen and (max-width: 600px) {
  table[class="body"] .right-text-pad {
    padding-left: 10px !important;
  }
  table[class="body"] .left-text-pad {
    padding-right: 10px !important;
  }
  table[class="body"] td.text-pad-right.content-ads {
    text-align: center!important;
    padding: 0!important;
  }
}

@media only screen and (max-width:340px){
  .wrapper,
    table[class="body"] .container {
    max-width:310px!important;
  }
  .ce-place .wrapper.last {
    max-width:310px!important;
    overflow: hidden;
  }
}
.custom-html-bloc a:link,
  .custom-html-bloc a:visited,
  .custom-html-bloc a:hover,
  .custom-html-bloc a:active {
    color: #e22028 !important;
  }
</style>

  <table id="newsletterAV" class="body" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
    <tbody>
    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">

    <td class="center" align="center" valign="top" bgcolor="#d9d9d9" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
  <!--begin main center content section-->
  <center class="main-center" style="width: 100%; min-width: 580px; background: #D9D9D9;">
    <!--begin top advertisement banner 728 x 90 -->
	<?php if ($all_fields['acf_newsletter_show_top_leaderboard_ad']) {
	    include locate_template('templates/newsletter/liveintent/ad_slot_728_h.php');
	} ?>
    <!--end top advertisement banner-->
     &nbsp;
    <!--top of header links-->
    <table class="container header" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;margin:0 auto;padding:0;">
    <tbody>
      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
        <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top"><center style="width:100%;min-width:580px;">
          <p style="text-align:center;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0 0 10px;padding:0;" align="center"><?php _ex('If you cannot view this e-mail correctly, please', 'second part is: "click here"', 'avatar-tcm'); ?> [[IF(Config.isShowMessage == 0){]]<a href="[[=Message.WebVersion(false);]]" style="color:<?php echo esc_attr($site_color); ?>"><?php _ex('click here', 'first part is: "If you cannot view this e-mail correctly, please"', 'avatar-tcm'); ?></a>[[}]]</p>
          </center></td>
        <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
        </tr>
    </tbody>
    </table>
    &nbsp;
    <!--begin main header-->
    <table class="container header" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
    <tbody>
      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
        <tbody>
          <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
          <td class="wrapper" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 20px 0px 0px;" align="left" valign="top"><table class="six columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:280px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
            <tbody>
              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <!--main logo--><td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 10px;" align="left" valign="top"><a target="_blank" href="<?php echo avatar_get_the_permalink_url(get_bloginfo('url'), $campaign); ?>" style="text-decoration:none;"><img src="<?php echo esc_url($site_logo); ?>" alt="" width="260" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:260px;max-width:260px;clear:both;display:block;border:none;"></a></td><!--end main logo-->
              </tr>
            </tbody>
            </table></td>
          <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top"><table class="six columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:280px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
            <tbody>
              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td class="date-info text-pad" style="vertical-align:middle;font-size:12px;word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;text-align:right;color:#222;font-family:Arial;font-weight:normal;line-height:19px;margin:0;padding:0px 20px 10px 10px;" align="right" valign="middle">
                <!--date label-->
                <span class="date-label"><?php echo wp_kses_post(ucfirst($prepend_date)).' '.($showDayOfMonth ? date_i18n('d F Y', strtotime($send_date)) : date_i18n('F Y', strtotime($send_date))); ?></span><!--end date label--><br>
                <!--newsletter type label-->
                <span class="blurb-label"><strong><?php echo wp_kses_post($newsletter_template_wording); ?></strong></span><!--end newsletter type label--><br>
                <!--go to web version link-->
                <a class="blurb-label" style="font-size:12px;color:<?php echo esc_attr($site_color); ?>;text-decoration:none;" href="<?php echo esc_url(avatar_get_the_permalink_url(get_bloginfo('url'), $campaign)); ?>"><?php _e('Go to website', 'avatar-tcm'); ?></a><!--end go to web version link--><br>
				<!-- manage subscription -->
                <a href="https://tc.avantages.ca/T/WF/4601/qR4iev/Update/CL[[=Contact.idContact;]]/[[=Contact.clKey;]]/Form.ofsys" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Manage subscription', 'avatar-tcm'); ?></a>
				<!-- end manage subscription -->
				</td>
              </tr>
            </tbody>
            </table></td>
          <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
          </tr>
        </tbody>
        </table></td>
      </tr>
    </tbody>
    </table>
      <!--end main header-->
      <?php

	  $add_br = false;
foreach ($newsletter_block_array as $newsletter_block) {
    //var_dump($newsletter_block);
    $block_type = $newsletter_block['acf_fc_layout'];

    $newsletter_category = $newsletter_block['acf_newsletter_category'];
    $category_name = $newsletter_category->name;
    $category_permalink = get_term_link($newsletter_category);
    $category_articles = $newsletter_block['acf_newsletter_articles'];
    $has_category_label = true;
    $has_ad = false;

    $newsletter_category = $newsletter_block['acf_newsletter_category'];
    // Get Custom 'section title' if exists
    ($newsletter_block['acf_newsletter_bypass_category_name']) ? $category_name = $newsletter_block['acf_newsletter_new_category_name'] : $category_name = $newsletter_category->name;

    $category_permalink = get_term_link($newsletter_category);
    $category_articles = $newsletter_block['acf_newsletter_articles'];
    $has_category_label = true;
    $has_ad = false;

    $background = '#fff';
    $bgcolor = '#fff';
    $category_color = $site_color;
    $title_color = '#222';
    $excerpt_color = '#222';
    $date_color = '#9f9fa0';

    if (isset($previous_type) && ! ($previous_type == 'acf_newsletter_dailynews' && $block_type == 'acf_newsletter_dailynews')) {
        echo ' &nbsp;';
    }
    //echo '|' . $previous_type . '|' . $block_type . '|';
    switch ($block_type) {
        case 'acf_newsletter_dailynews':
            $add_br = false;
            $has_category_label = false;
            ($all_fields['acf_newsletter_show_standard_news_ad']) ? $has_ad = true : $has_ad = false;
            include locate_template('templates/newsletter/newsletter_dailynews.php');
            $was_daily = true;
            break;
        case 'acf_newsletter_headlines':
            $add_br = false;
            $has_category_label = false;
            ($all_fields['acf_newsletter_show_standard_news_ad']) ? $has_ad = true : $has_ad = false;
            include locate_template('templates/newsletter/newsletter_headlines.php');
            $was_daily = true;
            break;
        case 'acf_newsletter_categories':
            include locate_template('templates/newsletter/newsletter_base_template.php');
            break;
        case 'acf_newsletter_indepth':
            $field = get_field('acf_in_depth_category', 'option');
            // Get Custom 'section title' if exists
            ($newsletter_block['acf_newsletter_section_title']) ? $category_name = $newsletter_block['acf_newsletter_section_title'] : $category_name = get_term($field)->name;
            $category_permalink = get_term_link($field);
            include locate_template('templates/newsletter/newsletter_indepth.php');
            break;
        case 'acf_newsletter_customblock':

            include locate_template('templates/newsletter/newsletter_customblock.php');
            break;
        case 'acf_newsletter_brandknowledge':
            if (have_rows('acf_newsletter_scheduler_campaigns', 'options')) {
                $category_permalink = get_permalink(get_field('acf_brand_knowledge_page', 'option'));
                while (have_rows('acf_newsletter_scheduler_campaigns', 'options')) {
                    the_row();
                    $newsletter_type = get_sub_field('acf_newsletter_template')['value'];
                    if ($newsletter_type == $campaign) {
                        $articles = get_sub_field('articles');
                        $avatar_sh_campaigns_articles = avatar_get_scheduler_campaigns_articles_id($articles);
                        if (! empty($avatar_sh_campaigns_articles)) {
                            $sponsor_url = get_sub_field('url');
                            include locate_template('templates/newsletter/newsletter_brandknowledge.php');
                        }
                    }
                }
            }
            break;
        case 'acf_newsletter_partners_place':
            $category_permalink = get_term_link(get_field('acf_tools_partnersplace_link', 'option'));
            include locate_template('templates/newsletter/newsletter_partner.php');
            break;
        default:
            break;
    }
    $previous_type = $block_type;
    $add_br = true;
}

?>
  &nbsp;
    <!--newsletter footer-->
    <table class="container footer" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;border-top-style:solid;border-top-color:#bfbfbf;border-top-width:1px;background:#D9D9D9;margin:0 auto;padding:0;" bgcolor="#D9D9D9">
    <tbody>
      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
        <tbody>
          <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
          <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:18px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:580px;margin:0 auto;padding:0;">
            <tbody>
              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top"><center style="width:100%;min-width:580px;">
                <p style="text-align:center;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0 0 10px;padding:0;" align="center">
				<!--unsubscribe link-->
                <a href="https://tc.avantages.ca/T/WF/4601/qR4iev/Subscription/CL[[=Contact.idContact;]]/[[=Contact.clKey;]]/Form.ofsys" class="blurb-label" style="font-size:12px;color:<?php echo esc_attr($site_color); ?>;text-decoration:none;"><?php _e('Unsubscribe', 'avatar-tcm'); ?></a>
				<!--end unsubscribe link-->
				</p>
                </center></td>
              <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
              </tr>
              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#424242;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top"><center style="text-align:center;width:100%;min-width:580px;">
                <p style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center"><?php _e('Envoyée par Groupe Contex Inc. et ses marques affiliées.', 'avatar-tcm'); ?><br>
                  <a href="<?php echo esc_url('http://ladingpage.tcmlesaffaires.pages.dialoginsight.com/politique-confidentialite'); ?>" style="color:#424242;text-decoration:underline;"><?php _e('Privacy Policy', 'avatar-tcm'); ?></a> | &copy; Groupe Context <?php echo date('Y').' '; ?>. <?php _e('All Rights Reserved.', 'avatar-tcm'); ?><br>
                  <?php _e('355, Sainte-Catherine Ouest, suite 501, Montréal, QC H3B 1A5 (514) 392-2009', 'avatar-tcm'); ?><br />
				  <?php _e('Service à la clientèle: 1 800 361-7215', 'avatar-tcm'); ?>
				  </p>
                <img width="100" src="<?php echo esc_url($tc_logo); ?>" alt="Groupe Context" style="float:none;display:inline;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;width:100px;" align="none">
                </center></td>
              </tr>
            </tbody>
            </table></td>
          </tr>
        </tbody>
        </table></td>
      </tr>
    </tbody>
    </table>
    <!--end newsletter footer-->
    &nbsp;
    <!--bottom advertisement-->
	<?php if ($all_fields['acf_newsletter_show_bottom_banner_ad']) {
	    include locate_template('templates/newsletter/liveintent/ad_slot_728_b.php');
	} ?>
    <!--end bottom advertisement-->
  </center>
  <!--end main center content section-->
    <?php
	  include locate_template('templates/newsletter/liveintent/ad_slot_rtb.php');
?>
    </td>
    </tr>
    </tbody>
  </table>
</body>
</html>
