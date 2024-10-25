<?php
$all_fields = get_fields(get_the_ID());
$campaign = $all_fields['acf_newsletter_template']['value'];
$send_date = $all_fields['acf_newsletter_send_date'];
$tc_logo = get_template_directory_uri().'/assets/images/Logo-Contex-RGB-en.png';
$site_logo = get_stylesheet_directory_uri().'/assets/images/site-logo.png';
$social_networks = 'acf_footer_sn_bencan';
$background = '#fff';
$bgcolor = '#fff';
$category_color = '#1e73be';
$title_color = '#222';
$excerpt_color = '#222';
$date_color = '#9f9fa0';
$site_color = get_theme_mod('primary_color');
$category_color = $site_color;
$site_name = 'Benefits Canada';
/* -------------------------------------------------------------
 * Permalink URL for newsletter
 * ============================================================*/

function avatar_add_utm_to_url($url, $campaign)
{

    switch ($campaign) {
        case 'template_beca_beca-newsletter':
            $campaign_name = 'Benefits Canada Daily Newsletters';
            break;
        case 'template_beca_beca-3rd-party-sponsored':
            $campaign_name = 'Benefits Canada Partners';
            break;
        case 'template_beca_beca-events':
            $campaign_name = 'Benefits Canada Conference Alerts';
            break;
        case 'template_beca_beca-special-offers':
            $campaign_name = 'Benefits Canada Offers';
            break;
        case 'template_cir_cir-newsletter':
            $campaign_name = 'Canadian Investment Review News Update';
            break;
        case 'template_cir_cir-3rd-party-sponsored':
            $campaign_name = 'Canadian Investment Review Partners';
            break;
        case 'template_cir_cir-events':
            $campaign_name = 'Canadian Investment Review Conference Alerts';
            break;
        case 'template_cir_cir-special-offers':
            $campaign_name = 'Canadian Investment Review Offers';
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
        ],
        $url
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
    case 'template_beca_beca-newsletter':
        $newsletter_template_wording = __('Benefits Canada Daily Newsletters', 'avatar-tcm');
        $prepend_date = date_i18n('l', strtotime($send_date));
        $showDayOfMonth = true;
        break;
    case 'template_beca_beca-3rd-party-sponsored':
        $newsletter_template_wording = __('Benefits Canada Partners', 'avatar-tcm');
        $prepend_date = date_i18n('l', strtotime($send_date));
        $showDayOfMonth = true;
        break;
    case 'template_beca_beca-events':
        $newsletter_template_wording = __('Benefits Canada Conference Alerts', 'avatar-tcm');
        $prepend_date = '';
        $showDayOfMonth = false;
        break;
    case 'template_beca_beca-special-offers':
        $newsletter_template_wording = __('Benefits Canada Offers', 'avatar-tcm');
        $showDayOfMonth = true;
        break;
    case 'template_cir_cir-newsletter':
        $newsletter_template_wording = __('Canadian Investment Review Newsletter', 'avatar-tcm');
        $showDayOfMonth = true;
        $site_name = 'Canadian Investment Review';
        $site_color = '#420d42';
        $category_color = $site_color;
        $site_logo = get_stylesheet_directory_uri().'/assets/images/CIR_logo_RGB.png';
        $social_networks = 'acf_footer_sn_cir';

        break;
    case 'template_cir_cir-3rd-party-sponsored':
        $newsletter_template_wording = __('Canadian Investment Review Partners', 'avatar-tcm');
        $site_logo = get_stylesheet_directory_uri().'/assets/images/CIR_logo_RGB.png';
        $social_networks = 'acf_footer_sn_cir';
        $site_name = 'Canadian Investment Review';
        $site_color = '#420d42';
        $category_color = $site_color;
        $showDayOfMonth = true;
        break;
    case 'template_cir_cir-events':
        $newsletter_template_wording = __('Canadian Investment Review  Conference Alerts', 'avatar-tcm');
        $site_logo = get_stylesheet_directory_uri().'/assets/images/CIR_logo_RGB.png';
        $social_networks = 'acf_footer_sn_cir';
        $site_name = 'Canadian Investment Review';
        $site_color = '#420d42';
        $category_color = $site_color;
        $showDayOfMonth = true;
        break;
    case 'template_cir_cir-special-offers':
        $newsletter_template_wording = __('Canadian Investment Review Offers', 'avatar-tcm');
        $site_logo = get_stylesheet_directory_uri().'/assets/images/CIR_logo_RGB.png';
        $social_networks = 'acf_footer_sn_cir';
        $site_name = 'Canadian Investment Review';
        $site_color = '#420d42';
        $category_color = $site_color;
        $showDayOfMonth = true;
        break;

    default:
        $newsletter_template_wording = __('Your e-newsletter and alerts', 'avatar-tcm');
        $showDayOfMonth = true;
        break;
}

$newsletter_block_array = $all_fields['acf_newsletter_block'];

$user_profile_page = get_field('acf_profile_newsletters', 'option');
$user_profile_page_url = get_permalink($user_profile_page->ID);

?>

<?php
include locate_template('templates/newsletter/liveintent/ad_slot_init.php');
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>BE Responsive Newsletter</title>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include 'single-newsletter-style.php'; ?>
  <!-- For testing only -->
</head>

<body style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">

  <!-- For testing only -->

  <table id="newsletterBE" class="body" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
    <tbody>
      <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">

        <td class="center" align="center" valign="top" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
          <!--begin main center content section-->
          <center class="main-center" style="width: 100%; min-width: 728px;">
            <!--begin top advertisement banner 728 x 90 -->
            <?php if ($all_fields['acf_newsletter_show_top_leaderboard_ad']) {
                include locate_template('templates/newsletter/liveintent/ad_slot_728_h.php');
            } ?>
            <!--end top advertisement banner-->
            &nbsp;
            <!--top of header links-->
            <table class="container header" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;margin:0 auto;padding:0;">
              <tbody>
                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                  <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top">
                    <center style="width:100%;min-width:728px;">
                      <p style="text-align:center;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0 0 10px;padding:0;" align="center"><?php _ex('If you cannot view this e-mail correctly, please', 'second part is: "click here"', 'avatar-tcm'); ?> [[IF(Config.isShowMessage == 0){]]<a href="[[=Message.WebVersion(false);]]" style="color:<?php echo esc_attr($site_color); ?>"><?php _ex('click here', 'first part is: "If you cannot view this e-mail correctly, please"', 'avatar-tcm'); ?></a>[[}]]</p>
                    </center>
                  </td>
                  <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                </tr>
              </tbody>
            </table>
            &nbsp;
            <!--begin main header-->
            <table class="container header" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
              <tbody>
                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                  <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top">
                    <table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                      <tbody>
                        <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                          <td class="wrapper" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 20px 0px 0px;" align="left" valign="top">
                            <table class="six columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:334px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
                              <tbody>
                                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <!--main logo-->
                                  <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 10px;" align="left" valign="top"><a target="_blank" href="<?php echo avatar_get_the_permalink_url(get_bloginfo('url'), $campaign); ?>" style="text-decoration:none;"><img src="<?php echo esc_url($site_logo); ?>" alt="" width="260" style="padding-left: 20px;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:260px;max-width:260px;clear:both;display:block;border:none;"></a></td>
                                  <!--end main logo-->
                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top">
                            <table class="six columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:360px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
                              <tbody>
                                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <td class="date-info text-pad" style="vertical-align:middle;font-size:12px;word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;text-align:right;color:#222;font-family:Arial;font-weight:normal;line-height:19px;margin:0;padding:0px 0 10px 10px;" align="right" valign="middle">
                                    <!--date label-->
                                    <span class="date-label"><?php echo wp_kses_post(ucfirst($prepend_date)).' '.($showDayOfMonth ? date_i18n('d F Y', strtotime($send_date)) : date_i18n('F Y', strtotime($send_date))); ?></span>
                                    <!--end date label--><br>
                                    <!--newsletter type label-->
                                    <span class="blurb-label"><strong><?php echo wp_kses_post($newsletter_template_wording); ?></strong></span>
                                    <!--end newsletter type label--><br>
                                    <!--go to web version link-->
                                    <a class="blurb-label" style="font-size:12px;color:<?php echo esc_attr($site_color); ?>;text-decoration:none;" href="<?php echo esc_url(avatar_get_the_permalink_url(get_bloginfo('url'), $campaign)); ?>"><?php _e('Go to website', 'avatar-tcm'); ?></a>
                                    <!--end go to web version link--><br>
                                    <!-- manage subscription -->
                                    <a href="<?php echo esc_url(avatar_get_the_permalink_url($user_profile_page_url, $campaign)); ?>" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Manage subscription', 'avatar-tcm'); ?></a>
                                    <!-- end manage subscription -->
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <!--end main header-->
            <?php

            $add_br = false;
$has_ads_already = false;
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

    if (
        isset($previous_type)
        && ! ($previous_type == 'acf_newsletter_dailynews' && $block_type == 'acf_newsletter_dailynews')
        && ! ($previous_type == 'acf_newsletter_main_section_title')
    ) {
        echo ' &nbsp;';
    }
    // echo '|' . $previous_type . '|' . $block_type . '|';
    switch ($block_type) {
        case 'acf_newsletter_main_section_title':
            ($all_fields['acf_newsletter_show_standard_news_ad']) ? $has_ad = true : $has_ad = false;
            $section_title = $newsletter_block['acf_newsletter_title'];
            include 'newsletter/newsletter_main_title.php';
            break;
        case 'acf_newsletter_dailynews':
            $add_br = false;
            $has_category_label = false;
            ($all_fields['acf_newsletter_show_standard_news_ad']) ? $has_ad = true : $has_ad = false;
            include 'newsletter/newsletter_dailynews.php';
            $was_daily = true;
            break;
        case 'acf_newsletter_headlines':
            $add_br = false;
            $has_category_label = false;
            ($all_fields['acf_newsletter_show_standard_news_ad']) ? $has_ad = true : $has_ad = false;
            include 'newsletter/newsletter_headlines.php';
            $was_daily = true;
            break;
        case 'acf_newsletter_categories':
            include 'newsletter/newsletter_base_template.php';
            break;
        case 'acf_newsletter_indepth':
            $field = get_field('acf_in_depth_category', 'option');
            // Get Custom 'section title' if exists
            ($newsletter_block['acf_newsletter_section_title']) ? $category_name = $newsletter_block['acf_newsletter_section_title'] : $category_name = get_term($field)->name;
            $category_permalink = get_term_link($field);
            include 'newsletter/newsletter_indepth.php';
            break;
        case 'acf_newsletter_customblock':

            include 'newsletter/newsletter_customblock.php';
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
                            include 'newsletter/newsletter_brandknowledge.php';
                        }
                    }
                }
            }
            break;
        case 'acf_newsletter_partners_place':
            $category_permalink = get_term_link(get_field('acf_tools_partnersplace_link', 'option'));
            include 'newsletter/newsletter_partner.php';
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
            <table class="container footer" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;border-top-style:solid;border-top-color:#bfbfbf;border-top-width:1px;margin:0 auto;padding:0;">
              <tbody>
                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                  <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top">
                    <table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                      <tbody>
                        <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                          <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:18px 0px 0px;" align="left" valign="top">
                            <table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                              <tbody>
                                <tr>
                                  <?php include 'newsletter/newsletter_people_watch_and_event_promotion.php'; ?>
                                </tr>
                                <tr>
                                  <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#424242;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top">
                                    <center style="text-align:center;width:100%;min-width:728px;">
                                      <p style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:bold;margin:0 0 10px;padding:0 35px;" align="center">Follow us</p>
                                      <?php while (has_sub_field($social_networks, 'option')) {
                                          $social_network_name = strtolower(substr(esc_attr(get_sub_field('title')), (strrpos(esc_attr(get_sub_field('title')), ' ') + 1)));
                                          ?>
                                        <?php if (strcmp($social_network_name, 'feeds') !== 0) { ?>
                                          <a title="<?php esc_attr(the_sub_field('title')); ?>" style="margin-left: 2px; margin-right: 2px;display: inline-block;text-decoration:none;" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>">
                                            <img width="24" style="padding: 0;background: white;" src="<?php echo get_template_directory_uri().'/assets/images/'.$social_network_name.'.png'; ?>" />
                                          </a>
                                        <?php } ?>
                                      <?php } ?>
                                    </center>
                                  </td>
                                </tr>
                                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#424242;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top">
                                    <center style="text-align:center;width:100%;min-width:728px;">
                                      <p style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center">
                                        <span style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center"><?php _e('This message was sent to', 'avatar-tcm'); ?> [[=Contact.f_EMail;]] by <?php _e($site_name, 'avatar-tcm'); ?></span><br>
                                        <!-- manage subscription -->
                                        <a href="https://www.benefitscanada.com/profile/" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Manage subscription', 'avatar-tcm'); ?></a> |
                                        <!-- end manage subscription -->
                                        <!--unsubscribe link-->
                                        <?php if (strpos($campaign, 'beca') !== false) { ?>
                                          <a href="https://tc.benefitscanada.com/T/WF/4426/YZWzJM/Subscription/CL[[=Contact.idContact;]]/[[=Contact.clKey;]]/Form.ofsys" class="blurb-label" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Unsubscribe', 'avatar-tcm'); ?></a><br>
                                        <?php } else { ?>
                                          <a href="https://tc.investmentreview.com/T/WF/4220/HboDa1/Subscription/CL[[=Contact.idContact;]]/[[=Contact.clKey;]]/Form.ofsys" class="blurb-label" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Unsubscribe', 'avatar-tcm'); ?></a><br>
                                        <?php } ?>
                                        <!--end unsubscribe link-->
                                        <span style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center">&copy; <?php echo date('Y'); ?>. <?php _e('Contex Group Inc. All rights reserved.', 'avatar-tcm'); ?></span><br>
                                        <span style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center"><?php _e('355, Sainte-Catherine West, suite 501, Montreal, QC H3B 1A5', 'avatar-tcm'); ?></span><br>

                                        <?php _e('Support: ', 'avatar-tcm'); ?><a href="mailto:etcmcontact.ca@kckglobal.com" class="blurb-label" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;">etcmcontact.ca@kckglobal.com</a> | <span>1-866-453-5833</span><br>
                                        <a href="<?php echo esc_url(avatar_get_the_permalink_url('http://ladingpage.tcmlesaffaires.pages.dialoginsight.com/Privacy_Policy', $campaign)); ?>" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Privacy Policy', 'avatar-tcm'); ?></a> | <a href="<?php echo avatar_get_the_permalink_url('https://www.benefitscanada.com/terms-of-use/', $campaign); ?>" style="color:<?php echo esc_attr($site_color); ?>;text-decoration:underline;"><?php _e('Terms and Conditions', 'avatar-tcm'); ?></a><br>
                                      </p>
                                      <img width="100" src="<?php echo esc_url($tc_logo); ?>" alt="Groupe Context" style="float:none;display:inline;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;width:100px;" align="none">
                                    </center>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
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