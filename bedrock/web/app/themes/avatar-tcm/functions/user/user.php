<?php
/* -------------------------------------------------------------
 * Create Array for add new user in WordPress
 * ============================================================*/

if (! function_exists('avatar_user_arr_for_wp')) {

    function avatar_user_arr_for_wp($arr)
    {
        if (empty($arr)) {
            return false;
        }
        avatar_rename_arr_key('f_EMail', 'user_email', $arr);
        avatar_rename_arr_key('f_FirstName', 'first_name', $arr);
        avatar_rename_arr_key('f_LastName', 'last_name', $arr);
        unset($arr['user_pass2']);
        unset($arr['f_Company']);
        unset($arr['licensed_to_sell']);
        unset($arr['role_in_firm']);
        unset($arr['product_sell']);
        unset($arr['optin_OptInPartnerIE']);
        unset($arr['optin_IE_Offers']);
        unset($arr['optin_Optin_Transcontinental']);
        unset($arr['optin_special']);
        unset($arr['recaptcha']);
        $arr['role'] = 'subscriber';

        return $arr;
    }
}

/* -------------------------------------------------------------
 * Dont send email on 'email_change' and 'password_change'
 * ============================================================*/
add_filter('send_email_change_email', '__return_false');
add_filter('send_password_change_email', '__return_false');
