<table class="container news-list" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 728px; background: #fff; margin: 0 auto; padding: 0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
      <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">
        <table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
          <tbody>
            <!--split advertisement-->
            <td class="wrapper last ad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; position: relative; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0 0px 0px; width: 100%;" align="left" valign="top">
              <?php
              if (NEWSLETTER_TYPE_ADS && NEWSLETTER_TYPE_ADS == 'liveintent') {

                  include 'liveintent/ad_slot_300.php';

              } elseif ($all_fields['acf_newsletter_show_bottom_banner_ad']) { ?>
                <table class="seven columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 485px; margin: 0 auto; padding: 0;">
                  <tbody>
                    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                      <td class="text-pad-right bigbox-cell content-ads" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 5px 20px 20px 0px;" align="left" valign="top">
                        <!--advertisement link and img--><a href="http://redux-d.openx.net/e/1.0/rc?cs=[[=CodeUnique;]]1"><img src="http://redux-d.openx.net/e/1.0/ai?auid=<?php echo avatar_newsletter_big_box_code($campaign, $send_date); ?>&amp;cs=[[=CodeUnique;]]1" border="0" alt="<?php echo $post_title; ?>"></a>
                      </td>
                      <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                    </tr>
                  </tbody>
                </table>

              <?php } ?>
            </td>
            <!--end split advertisement-->
            <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
              <td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">
                <table class="five columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; margin: 0 auto; padding: 0;">
                  <tbody>
                    <!--indivitual news item listing-->
                    <?php foreach ($second_article_block as $article) {
                        $show_thumbnail = $article['acf_newsletter_article_display_thumbnail'];
                        $show_excerpt = $article['acf_newsletter_article_display_excerpt'];
                        $bypass_title = $article['acf_newsletter_article_bypass_title'];
                        $new_title = $article['acf_newsletter_article_new_title'];
                        $display_date = $article['acf_newsletter_display_date'];

                        $new_excerpt = $article['acf_newsletter_article_excerpt'];

                        $article_id = $article['acf_newsletter_article'];
                        $post = get_post($article_id);

                        if ($show_thumbnail) {
                            $the_article_thumbnail_url = get_the_post_thumbnail_url($article_id, 'thumbnail');
                        }

                        $excerpt = $post->post_excerpt;
                        if ($bypass_title) {
                            $post_title = $new_title;
                        } else {
                            $post_title = $post->post_title;
                        }

                        if ($show_excerpt) {
                            $excerpt = $new_excerpt;
                        }

                        if ($bypass_title) {
                            $post_title = $new_title;
                        } else {
                            $post_title = $post->post_title;
                        }

                        $main_sub_category_id = get_field('article_side_main_subcategory', $article_id); //2 get current main sub category

                        $main_sub_category_object = get_category($main_sub_category_id); //3 get current main sub category object

                        $sub_category_name = $main_sub_category_object->name; //4 get current main sub category name

                        $article_permalink = get_the_permalink($article_id);

                        $acf_article_sponsor = get_field('acf_article_sponsor', $article_id);
                        ?>
                      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                        <td class="first" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:0 0 15px;" align="left" valign="top">
                          <table class="row thumb-listing" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                            <tbody>
                              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                <?php if ($show_thumbnail && isset($the_article_thumbnail_url)) { ?>

                                  <td class="wrapper" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0px 20px 0px 0px;" align="left" valign="top">
                                    <table class="five columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:220px;margin:0 auto;padding:0;">
                                      <tbody>
                                        <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                          <td class="left-text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0px 0px 0px 10px;" align="left" valign="top">
                                            <a href="<?php echo avatar_get_the_permalink_url($article_permalink, $campaign); ?>" style="color:#222;text-decoration:none;">
                                              <img width="220" style="width:220px;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;max-width:100%;clear:both;display:block;float:none;margin:0;border:none; padding-bottom: 5px;" class="center" alt="<?php echo $post_title; ?>" src="<?php echo esc_url($the_article_thumbnail_url); ?>" align="none">                                            </a>
                                          </td>
                                          <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0;" align="left" valign="top"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>

                                <?php } ?>
                                <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:0px 0 0;padding:0px 0px 0px;" align="left" valign="top">
                                  <table class="seven columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width: 468px;margin:0 auto;padding:0;">
                                    <tbody>
                                      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                        <td class="right-text-pad thumb-text-float" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0px 0px 0px 0px; <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                            echo 'background: #eeeeee;padding: 10px;';
                                        } ?> " <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                            echo ' class="sponsor-bg"';
                                        } ?> align="left" valign="top">
                                          <!-- <span class="category" style="color:<?php //echo esc_attr($site_color);?>;font-size:12px;font-style:italic;line-height:25px;"><a href="<?php // echo avatar_get_the_permalink_url(get_category_link($main_sub_category_object->term_id), $campaign);?>" style="text-decoration:none;color:<?php // echo esc_attr($category_color);?>;font-family:Georgia;font-size:12px;font-style:italic;line-height:25px;"><?php // echo wp_kses_post($sub_category_name);?></a></span><br> -->
                                          <span class="title" style="font-size:16px;font-weight:700;"><a href="<?php echo avatar_get_the_permalink_url($article_permalink, $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($title_color); ?>;font-weight:700;"><strong><?php echo wp_kses_post($post_title); ?></strong></a></span><br>
                                          <?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                            <span class="excerpt" style="font-size:13px;color:<?php echo esc_attr($excerpt_color); ?>;"><a href="<?php echo avatar_get_the_permalink_url($article_permalink, $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($title_color); ?>;font-weight:300;"><?php echo wp_kses_post($excerpt); ?></a></span><br>
                                          <?php } ?>
                                          <?php if ($display_date) { ?>
                                            <span class="date" style="line-height:25px;color:<?php echo esc_attr($date_color); ?>;font-size:11px;"><?php echo esc_attr($formated_date); ?></span>
                                          <?php } ?>
                                          <?php
                                          if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                                              avatar_display_post_sponsor($article_id, false);
                                          }
                        ?>
                                        </td>
                                        <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0;" align="left" valign="top"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    <?php } ?>
                    <!--end indivitual news item listing-->

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