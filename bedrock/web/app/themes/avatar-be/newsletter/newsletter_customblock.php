<!--wysiwyg bloc-->
<?php
    $custom_title = $newsletter_block['acf_newsletter_section_title'];
$custom_url = $newsletter_block['acf_newsletter_section_url'];
$custom_html = $newsletter_block['acf_newsletter_customhtml'];
?>
<table class="container building-your-business" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:728px;background:#fff;margin:0 auto;padding:0;" bgcolor="#fff">
  <tbody>
    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
      <td style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"><table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;display:block;padding:0px;">
          <tbody>
            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:20px 0px 0px;" align="left" valign="top"><table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                  <tbody>
                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                      <td class="full-section" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 0;" align="left" valign="top">
                       <!--title area-->
                       <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                          <tbody>
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <td class="section-title" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:middle;text-align:left;color:#fff;font-family:Georgia;font-weight:normal;line-height:19px;font-size:18px;font-style:italic;height:20px;background:<?php echo esc_attr($site_color); ?>;margin:0;padding:10px 20px 10px 10px;" align="left" bgcolor="<?php echo esc_attr($site_color); ?>" valign="middle">
                              <!--section title-->
                              <span style="color:#ffffff;text-decoration:none; font-weight:normal"><strong style="font-weight:normal !important;"><?php echo wp_kses_post($custom_title); ?></strong></span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--end title area-->
                        <!--begin article listing-->
                        <table class="twelve columns" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto;padding:0;">
                          <tbody>
                            <!--begin article list item-->
                            <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                              <td class="text-pad" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0" align="left" valign="top"><table style="width:100%;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;">
                                  <tbody>
                                    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
                                      <td class="first custom-html-bloc" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:13px;border-top-style:none;border-top-width:1px;border-top-color:#D9D9D9;margin:10px 0 0;padding:5px 0 0;" align="left" valign="top">
                                        <?php echo wp_kses_post($custom_html); ?>
                                    </tr>
                                  </tbody>
                                </table></td>
                              <td class="expander" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;visibility:hidden;width:0px;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" align="left" valign="top"></td>
                            </tr>
                            <!--end article list item-->
                          </tbody>
                        </table>
                        <!--end article listing-->
                        </td>
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
<!--end wysiwyg bloc-->
