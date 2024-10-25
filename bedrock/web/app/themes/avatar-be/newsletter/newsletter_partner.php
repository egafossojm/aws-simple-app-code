
<!--partners place section-->
<?php

$avatar_partnersplace_category = get_field('acf_tools_partnersplace_link', 'option');
if ($avatar_partnersplace_category == null) {
    return false;
}

$avatar_category_posts_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'cat' => $avatar_partnersplace_category->term_id,
    'order' => 'DESC',
    'order_by' => 'post_date',
    'posts_per_page' => 4,
];

$the_query = new WP_Query($avatar_category_posts_args);
if ($the_query->have_posts()) {
    ?>
&nbsp;
<table class="container building-your-business" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0; background:#ebebeb;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
          <tbody>
            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                  <tbody>
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                      <td class="full-section" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 0;" align="left" valign="top"><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <!--brand knowledge section title-->
                              <td class="section-title" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:middle;text-align:left;color:#fff;font-family:Georgia;font-weight:normal;line-height:19px;font-size:18px;font-style:italic;height:20px;background:<?php echo esc_attr($site_color); ?>;margin:0;padding:10px 20px 10px 10px;" align="left" bgcolor="<?php echo esc_attr($site_color); ?>" valign="middle"><a href="<?php echo avatar_get_the_permalink_url($category_permalink, $campaign); ?>" style="color:#ffffff;text-decoration:none;"><strong style="font-weight:normal !important;"><?php _e('Partners&rsquo; Place', 'avatar-tcm'); ?></strong></a></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:10px auto 0;padding:0;">
                          <tbody>
                            <!--brand knowledge list item-->
                            <?php
                                while ($the_query->have_posts()) {
                                    $the_query->the_post();

                                    $sponsor_obj = avatar_get_sponsor_info($the_query->ID());

                                    ?>
                                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 20px 5px 10px;" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                                      <tbody>
                                        <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                          <td class="first" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:5px 0 0;" align="left" valign="top"><span class="title" style="font-size:18px;"><a href="<?php echo avatar_get_the_permalink_url(get_the_permalink(), $campaign); ?>" style="text-decoration:none;color:#222;font-weight:700;"><strong><?php the_title(); ?></strong></a></span><br>
                                          <?php if (is_object($sponsor_obj)) { ?>
                                            <span class="date" style="color:#9f9fa0;font-size:11px;line-height:25px;"><?php _e('Brought to you by:', 'avatar-tcm'); ?> <?php echo wp_kses_post($sponsor_obj->name); ?></span>
                                          <?php } ?>  
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                  <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                                </tr>
                            <?php } ?>
                            <!--end brand knowledge list item-->
                          </tbody>
                        </table></td>
                      <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
<?php } wp_reset_postdata(); ?>
<!--end partners place section-->