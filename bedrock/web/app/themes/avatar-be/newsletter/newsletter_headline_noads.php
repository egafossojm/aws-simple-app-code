<table class="container headline-news-list news-list" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 728px; background: #fff; margin: 0 auto; padding: 0;" bgcolor="#fff">
	<tbody>
         <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
            <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                <tbody>

                <tr><td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                  <tbody>
                  <!--indivitual news item listing-->
                  <?php foreach ($second_article_block as $article) {
                      $show_excerpt = $article['acf_newsletter_article_display_excerpt'];
                      $new_excerpt = $article['acf_newsletter_article_excerpt'];
                      $article_id = $article['acf_newsletter_article'];
                      $bypass_title = $article['acf_newsletter_article_bypass_title'];
                      $new_title = $article['acf_newsletter_article_new_title'];
                      $post = get_post($article_id);
                      $post_title = $post->post_title;

                      $excerpt = $post->post_excerpt;
                      if ($bypass_title) {
                          $post_title = $new_title;
                      } else {
                          $post_title = $post->post_title;
                      }

                      if ($show_excerpt) {
                          $excerpt = $new_excerpt;
                      }
                      ?>
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
						<td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row text-pad multimedia-news" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;padding:0px;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 10px 5px;" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                                  <tbody>
                                    <tr style="vertical-align: top; text-align: left; padding: 0;" align="left">
                                      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:0px 0 5px; border-bottom: 1px solid <?php echo esc_attr($site_color); ?>; <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                          echo 'background: #eeeeee;padding: 10px;';
                                      } ?> "  <?php if (($acf_article_sponsor !== null) && ($acf_article_sponsor > 0)) {
                                          echo ' class="sponsor-bg"';
                                      } ?> align="left" valign="top">
                                        <!--title-->
                                        <span class="title" style="font-size: 18px;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink($article_id), $campaign); ?>" style="text-decoration: none; color: <?php echo esc_attr($site_color); ?>; font-weight: bold;"><strong><?php echo wp_kses_post($post_title); ?></strong></a></span><br>
										<?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                        <span class="excerpt" style="padding: 5px 0;font-size:13px;"><?php echo wp_kses_post($excerpt); ?></span><br>
                                        <?php } ?>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                    </tr>
                  <?php } ?>
                    <!--end indivitual news item listing-->

                  </tbody>
                </table></td>
                </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>