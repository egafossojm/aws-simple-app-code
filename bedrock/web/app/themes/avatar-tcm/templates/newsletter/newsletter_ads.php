<table class="container news-list" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; background: #fff; margin: 0 auto; padding: 0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
      <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"><table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;">
          <tbody>
            <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
              <td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0 20px 0px 0px;" align="left" valign="top"><table class="five columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 230px; margin: 0 auto; padding: 0;">
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

                      $acf_article_sponsor = get_field('acf_article_sponsor', $article_id);
                      ?>
                    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                      <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 0;" align="left" valign="top"><table class="text-pad-left" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; padding: 0 0 0 20px;">
                          <tbody>
                            <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                              <td class="text-pad-left" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 5px 10px;" align="left" valign="top"><table style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; padding: 0;">
                                  <tbody>
                                    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                      <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 10px 0 0; padding: 5px 0 0; <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                          echo 'background: #eeeeee;padding: 10px;';
                                      } ?> " <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                          echo ' class="sponsor-bg"';
                                      } ?>  align="left" valign="top">
                                        <!--category-->
                                        <span class="category">
                                            <a href="<?php echo avatar_get_the_permalink_url(get_category_link($main_sub_category_object->term_id), $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($category_color); ?>;font-family:Georgia;font-size:12px;font-style:italic;line-height:25px;">
                                                <?php echo wp_kses_post($sub_category_name); ?>
                                            </a>
                                        </span>
                                          <br>
                                        <!--title-->
                                        <span class="title" style="font-size: 16px;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink($article_id), $campaign); ?>" style="text-decoration: none; color: #222222; font-weight: bold;"><strong><?php echo wp_kses_post($post_title); ?></strong></a></span><br>
                                        <?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                        <span class="excerpt" style="font-size:13px;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink($article_id), $campaign); ?>" style="text-decoration: none; color: #222222; font-weight: 300;"><?php echo wp_kses_post($excerpt); ?></a></span><br>
                                        <?php } ?>
                                        <!--date-->
                                          <?php if ($display_date) { ?>
                                            <span class="date" style="color: #9f9fa0; font-size: 11px; line-height: 25px;"><?php echo get_the_date(get_option('date_format'), $post->ID); ?></span>
                                          <?php } ?>
										  <?php
                    if ((($acf_article_sponsor !== null) && ($acf_article_sponsor > 0))) {
                        echo '<span style="font-size: 12px;">';
                        avatar_display_post_sponsor($article_id, false);
                        echo '</span>';
                    }
                      ?>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                    </tr>
                  <?php } ?>
                    <!--end indivitual news item listing-->

                  </tbody>
                </table></td>
              <!--split advertisement-->
              <td class="wrapper last ad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; position: relative; color: #222222; font-family: 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0 0px 0px; width: 100%;" align="left" valign="top">
                <?php
                      if (NEWSLETTER_TYPE_ADS && NEWSLETTER_TYPE_ADS == 'liveintent') {

                          include locate_template('templates/newsletter/liveintent/ad_slot_300.php');

                      } elseif ($all_fields['acf_newsletter_show_bottom_banner_ad']) { ?>
                  <table class="seven columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 330px; margin: 0 auto; padding: 0;">
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
                <!--end split advertisement-->
                </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>