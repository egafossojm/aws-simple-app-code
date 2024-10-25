<!--brand knowledge section-->
<!-- get info from scheduler -->
<?php
$args = [
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 20,
    'post__in' => $avatar_sh_campaigns_articles,
    'orderby' => 'post__in',
];
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
    ?>
<table class="container building-your-business" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0; background:#ebebeb;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
          <tbody>
            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:580px;margin:0 auto;padding:0;">
                  <tbody>
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                      <td class="full-section" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 0;" align="left" valign="top"><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <!--brand knowledge section title-->
                              <td class="section-title" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:middle;text-align:left;color:#fff;font-family:Georgia;font-weight:normal;line-height:19px;font-size:18px;font-style:italic;height:20px;background:<?php echo esc_attr($partner_color); ?>;margin:0;padding:10px 20px 10px 10px;" align="left" bgcolor="<?php echo esc_attr($partner_color); ?>" valign="middle"><a href="<?php echo avatar_get_the_permalink_url($category_permalink, $campaign); ?>" style="color:#ffffff;text-decoration:none;"><strong style="font-weight:normal !important;"><?php _e('Brand Knowledge', 'avatar-tcm'); ?></strong></a></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:580px;margin:10px auto 0;padding:0;">
                          <tbody>
                            <!--brand knowledge list item-->
                            <?php
                                while ($the_query->have_posts()) {
                                    $the_query->the_post();
                                    $main_sub_category_id = get_field('article_side_main_subcategory');
                                    $main_sub_category_object = get_category($main_sub_category_id); //3 get current main sub category object
                                    $sponsor_name = $main_sub_category_object->name; //4 get current main sub category name
                                    $obj_brand = get_page_by_title($sponsor_name, 'OBJECT', 'brand');
                                    ?>
                                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                  <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 20px 5px 10px;" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                                      <tbody>
                                        <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                          <td class="first" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:5px 0 0;" align="left" valign="top"><span class="title" style="font-size:16px;"><a href="<?php echo avatar_get_the_permalink_url(get_the_permalink(), $campaign); ?>" style="text-decoration:none;color:#222;font-weight:700;"><strong><?php the_title(); ?></strong></a></span><br>
                                            <span class="date" style="color:#9f9fa0;font-size:11px;line-height:25px;"><?php echo _x('By: ', 'Used before brand name', 'avatar-tcm'); ?> <a style="color:#9f9fa0; text-decoration:none;" href="<?php echo avatar_get_the_permalink_url(the_permalink($obj_brand->ID), $campaign); ?>"><?php echo wp_kses_post($sponsor_name); ?></a></span></td>
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
<!--end brand knowledge section-->
