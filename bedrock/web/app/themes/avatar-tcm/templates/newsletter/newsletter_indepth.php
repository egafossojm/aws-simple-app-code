<!--begin special feature section-->
<?php
$feature_repeater = $newsletter_block['acf_newsletter_features_repeater'];

?>
<table class="container special-features" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0 0 10px 0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
          <tbody>
            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:580px;margin:0 auto;padding:0;">
                  <tbody>
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" align="left" valign="top"><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <!--section title-->
                                <td class="section-title" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:middle;text-align:left;color:#fff;font-family:Georgia;font-weight:normal;line-height:19px;font-size:18px;font-style:italic;height:20px;background:<?php echo esc_attr($site_color); ?>;margin:0;padding:10px 20px 10px 10px;" align="left" bgcolor="<?php echo esc_attr($site_color); ?>" valign="middle"><a href="<?php echo avatar_get_the_permalink_url($category_permalink, $campaign); ?>" style="color:#ffffff;text-decoration:none;"><strong style="font-weight:normal !important;"><?php echo wp_kses_post($category_name); ?></strong></a></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>

            <?php foreach ($feature_repeater as $feature) {

                $post_id = $feature['acf_newsletter_feature'];

                global $post;
                $post = get_post($post_id);
                setup_postdata($post);

                $parent_sub_category_id = get_field('acf_feature_parent_sub_category');
                $category_name = get_term_by('ID', $parent_sub_category_id);
                $sponsor_object = get_fields($post_id);
                $parent_sub_category_id = get_field('acf_feature_parent_sub_category');

                $child_category_name = get_the_title($parent_sub_category_id);
                $child_category_permalink = get_the_permalink($parent_sub_category_id);
                $post_date = new DateTime($post->post_date);
                $formated_date = date_i18n('d F Y', strtotime($post->post_date)); //date_format($post_date, get_option( 'date_format' ) );

                $bypass_feature_name = $feature['acf_newsletter_bypass_feature_name'];
                if ($bypass_feature_name) {
                    $feature_name = $feature['acf_newsletter_new_feature_name'];
                } else {
                    $feature_name = get_the_title();
                }

                $display_date = $feature['acf_newsletter_display_date'];
                $show_excerpt = $feature['acf_newsletter_feature_display_excerpt'];
                $excerpt = $feature['acf_newsletter_feature_excerpt'];

                $display_thumbnail = $feature['acf_newsletter_feature_display_thumbnail'];

                if ($bypass_title) {
                    $post_title = $new_title;
                } else {
                    $post_title = $post->post_title;
                }

                ?>
            <!--article listing item no image-->
                <?php if (! $display_thumbnail || ! has_post_thumbnail()) { ?>
                      <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                        <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 10px 5px;" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                            <tbody>
                              <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                <td class="first" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:0px 0 5px;" align="left" valign="top">
                                    <span class="category">
                                        <a href="<?php echo avatar_get_the_permalink_url($child_category_permalink, $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($category_color); ?>;font-family:Georgia;font-size:12px;font-style:italic;line-height:25px;">
                                            <?php echo wp_kses_post($child_category_name); ?>
                                        </a>
                                    </span>
                                    <br>
                                  <span class="title" style="font-size:16px;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink(), $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($title_color); ?>;font-weight:700;"><strong><?php echo wp_kses_post($feature_name); ?></strong></a></span><br>
                                    <?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                    <span class="excerpt" style="font-size:13px;color:<?php echo esc_attr($excerpt_color); ?>;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink(), $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($title_color); ?>;font-weight:300;"><?php echo wp_kses_post($excerpt); ?></a></span><br>
                                    <?php } ?>
                                    <?php if ($display_date) { ?>
                                        <span class="date" style="color:<?php echo esc_attr($date_color); ?>;font-size:11px;line-height:25px;"><?php echo wp_kses_post($formated_date); ?></span>
                                    <?php } ?>
                                </td>
                              </tr>
                            </tbody>
                          </table></td>
                        <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                      </tr>
              <!--end article listing item no image-->
                  <?php } else { ?>
              <!--article listing item with image-->
            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row thumb-listing" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
                  <tbody>
                  <!--special feature list item-->
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                      <!--special feature image cell-->
                      <td class="wrapper" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 20px 0px 0px;" align="left" valign="top"><table class="five columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:230px;margin:0 auto;padding:0;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <td class="left-text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px 10px;" align="left" valign="top">
                                  <?php if ($display_thumbnail && has_post_thumbnail()) { ?>
                                    <a href="<?php echo avatar_get_the_permalink_url(the_permalink(), $campaign); ?>" style="color:#222;text-decoration:none;">
                                        <img width="220" style="width:220px;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;max-width:100%;clear:both;display:block;float:none;margin:0 auto;border:none;" class="center" alt="<?php echo $post_title; ?>" src="<?php echo esc_url(the_post_thumbnail_url($post_id, 'thumbnail')); ?>" align="none">
                                    </a>
                                <?php } ?>

                              </td>
                              <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                            </tr>
                          </tbody>
                        </table></td>

                        <!--special feature text-->
                      <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top"><table class="seven columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:330px;margin:0 auto;padding:0;">

                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <td class="right-text-pad thumb-text-float" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0px 20px 0px 0px;" align="left" valign="top"><span class="category" style="text-decoration:none;color:<?php echo esc_attr($category_color); ?>;font-family:Georgia;font-size:12px;font-style:italic;line-height:25px;"><a href="<?php echo avatar_get_the_permalink_url($child_category_permalink, $campaign); ?>" style="text-decoration:none;color:<?php echo esc_attr($category_color); ?>;"><?php echo wp_kses_post($child_category_name); ?></a></span><br>
                                <span class="title" style="font-size:16px;font-weight:700;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink(), $campaign); ?>" style="text-decoration:none;color:#222;font-weight:700;"><strong><?php echo wp_kses_post($feature_name); ?></strong><br></a></span>
                                  <?php if ($show_excerpt && ! empty($excerpt)) { ?>
                                  <span class="excerpt" style="font-size:13px;color:<?php echo esc_attr($excerpt_color); ?>;"><a href="<?php echo avatar_get_the_permalink_url(the_permalink(), $campaign); ?>" style="text-decoration:none;color:#222;font-weight:300;"><?php echo wp_kses_post($excerpt); ?></a></span><br>
                                  <?php } ?>
                                      <?php if ($display_date) { ?>
                                        <span class="date" style="line-height:25px;color:<?php echo esc_attr($date_color); ?>;font-size:11px;"><?php echo wp_kses_post($formated_date); ?></span>
                                      <?php } ?>
                                  </td>
                                  <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-width:1px;border-top-color:#D9D9D9;border-top-style:none;margin:10px 0 0;padding:0;" align="left" valign="top"></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                    <!--end special feature list item-->
                  </tbody>
                </table></td>
            </tr>
            <?php } ?>
                <?php wp_reset_postdata(); ?>
          <?php } ?>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>

<!--end special feature section-->

