<?php
/**
 *  Email template system
 *
 *	For email such as reset password, forgot password, register confirmation, etc
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php

function avatar_template_email_system($array = [])
{
    //array validations
    //email_content_title : title
    //email_content : content

    if (empty($array)) {
        $array = '';
    }
    if (array_key_exists('title', $array)) {
        $email_content_title = $array['title'];
    }
    if (array_key_exists('content', $array)) {
        $email_content = $array['content'];
    }
    if (array_key_exists('emailto', $array)) {
        $emailto = $array['emailto'];
    }

    $tc_logo = get_template_directory_uri().'/assets/images/tc-media-logo.png';
    $contex_logo = get_template_directory_uri().'/assets/images/logo-contex-nbg.png';
    $site_logo = get_stylesheet_directory_uri().'/assets/images/site-logo.png';
    $site_main_color = get_theme_mod('primary_color');
    $site_url = get_site_url();
    $site_id = get_current_blog_id();
    switch ($site_id) {
        case 2:
            $customer_email = 'abonnement@finance-investissement.com';

            break;

        case 3:
            $customer_email = 'subs@investmentexecutive.com';

            break;
    }

    return $body = '<html> 
	<body style="background:#f6f6f6;">
<table bgcolor="#fff" style="background:#fff; border-collapse:collapse;border-spacing:0;font-family:\'Helvetica\',\'Arial\',sans-serif; font-size:14px; line-height:19px; margin:0 auto; margin-top: 15px; padding:20px;width:80%;">
  <tbody>
    <tr>
      <td align="center" style="margin:0; padding:15px 0px; text-align:center; vertical-align:top;
											"><a href="'.$site_url.'" target="_blank" rel="noopener noreferrer" style="text-decoration:none"> <img width="350" src="'.$site_logo.'" alt="site-logo" style="border:medium none; display:block; clear:both; margin:0 auto; outline:medium none; text-decoration:none;
												"> </a></td>
    </tr>
    <tr>
      <td bgcolor="'.$site_main_color.'" style="border-spacing:0;border-collapse:collapse; vertical-align:top; text-align:inherit; width:100%; background:'.$site_main_color.'; padding:0;"><table style="border-spacing:0; border-collapse:collapse; vertical-align:top; text-align:center; width:100%;
												padding:0px; background:url(\''.get_stylesheet_directory_uri().'/assets/images/banner-email.jpg'.'\'); background-position:center center; background-size:cover;"
												>
          
        </table></td>
    </tr>
    
    <!--CONTENT -->
    <tr>
      <td bgcolor="#fff" style="background:#fff; border-collapse:collapse;border-spacing:0;font-family:\'Helvetica\',\'Arial\',sans-serif; font-size:14px; line-height:19px; padding:20px;width:100%;"><table style="">
          <tr>
            <td valign="top" style="line-height:19px; padding:30px; border-collapse:collapse!important; color:#222; font-family:Arial; font-size:14px; font-weight:normal; vertical-align:top;  word-break:break-word; text-align:left;
														">'.$email_content.' </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td bgcolor="#f6f6f6"><!--COPYRIGHT-->
        
        <table style="border-collapse:collapse!important; vertical-align:top; width: 100%;
												">
          <tbody>
                <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
              <td align="center" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#8c8c8c;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 20px;" valign="top"><center style="text-align:center;width:100%;min-width:580px;">
                  <p style="text-align:center;font-size:11px;line-height:17px;font-family:Arial;font-weight:normal;margin:0 0 10px;padding:0 35px;" align="center"><span>'.__('TContex Group Inc. | 55, Sainte-Catherine West, suite 501 | Montréal, QC H3B 1A5', 'avatar-tcm').'</span><br>
                  '.__('To contact customer care, please email', 'avatar-tcm').' <a href="mailto:'.$customer_email.'">'.$customer_email.'</a> '.__('or call 866-453-5833.', 'avatar-tcm').'
                  </p>
                <img src="'.esc_url($contex_logo).'" alt="Context" style="float:none;display:inline;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;" align="none">
                </center></td>
              </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>';
}?>