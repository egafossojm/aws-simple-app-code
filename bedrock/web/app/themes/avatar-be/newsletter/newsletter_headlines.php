<!--article listing section-->
<?php
$article_repeater = $newsletter_block['acf_newsletter_articles'];

$first_article_block = array_shift($article_repeater);
$second_article_block = $article_repeater;

?>

      <table class="container  headline-first-block" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;background:<?php echo esc_attr($background); ?>;margin:0 auto;padding:0;" bgcolor="<?php echo esc_attr($bgcolor); ?>">
        <tbody>
          <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
            <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                <tbody>

                <tr><td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                        <tbody>
                          <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                            <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" align="left" valign="top"><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0; width: 100%;">
                                <tbody>
                                  <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                    <!--multimedia centre section title-->
                                    <td class="section-title" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:middle;text-align:left;color:#fff;font-family:Georgia;font-weight:normal;line-height:19px;font-size:18px;font-style:normal; text-transform:uppercase;height:20px;background:<?php echo esc_attr($site_color); ?>;margin:0;padding:10px 20px 10px 10px;" align="left" bgcolor="<?php echo esc_attr($site_color); ?>" valign="middle"><strong style="font-weight:normal !important; color: #ffffff;"><?php echo wp_kses_post($newsletter_template_wording); ?></strong></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                        </tbody>
                      </table></td></tr>
                  <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                    <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row text-pad multimedia-news" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;padding:0px;">
                        <tbody>
                            <?php
                            $show_thumbnail = false;
$show_excerpt = $first_article_block['acf_newsletter_article_display_excerpt'];
$bypass_title = $first_article_block['acf_newsletter_article_bypass_title'];
$new_title = $first_article_block['acf_newsletter_article_new_title'];

$new_excerpt = $first_article_block['acf_newsletter_article_excerpt'];

if ($show_excerpt) {
    $excerpt = $new_excerpt;
}

$article_id = $first_article_block['acf_newsletter_article'];

$post = get_post($article_id);

if ($bypass_title) {
    $post_title = $new_title;
} else {
    $post_title = $post->post_title;
}

$article_permalink = get_the_permalink($article_id);

?>
                        <!--article listing item no image-->

                                  <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                    <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 10px 5px;" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                                        <tbody>
                                          <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                            <td class="first" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:0px 0 5px; border-bottom: 1px solid <?php echo esc_attr($site_color); ?>;" align="left" valign="top">
                                              <span class="title" style="font-size:20px;"><a href="<?php echo avatar_get_the_permalink_url($article_permalink, $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($site_color); ?>;font-weight:700;"><strong><?php echo wp_kses_post($post_title); ?></strong></a></span><br>
                                                <?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                                <span class="excerpt" style="padding: 5px 0;font-size:13px;color:<?php echo esc_attr($excerpt_color); ?>;"><?php echo wp_kses_post($excerpt); ?></span><br>
                                                <?php } ?>
                                                </td>
                                          </tr>
                                        </tbody>
                                      </table></td>
                                    <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                                  </tr>
                          <!--end article listing item no image-->

                          <!--end article listing item with image-->

                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table>

      <!--end article listing section-->
      <!--begin article listing with big box-->
<?php
if ($has_ad) {
    include 'newsletter_headline_ads.php';
} else {
    include 'newsletter_headline_noads.php';
}?>
      <!--end article listing with bigbox-->