<?php
/**
 * Functions, mapping for OpenX (newsletter)
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */

/* -------------------------------------------------------------
 * OpenX ID for Big Box
 * ============================================================*/

if (! function_exists('avatar_newsletter_big_box_code')) {

    /**
     * @return string
     */
    function avatar_newsletter_big_box_code($newsletter_type, $newsletter_date)
    {

        switch ($newsletter_type) {
            case 'template_ad_ambulletin':
                $code = avatar_big_box_am_day_code($newsletter_date);
                break;
            case 'template_ad_pmbulletin':
                $code = avatar_big_box_pm_day_code($newsletter_date);
                break;
            case 'template_ad_weekinreview':
                $code = '537983241';
                break;
            case 'template_ad_bestofthemonth':
                $code = '539639053';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for Header banner
 * ============================================================*/

if (! function_exists('avatar_newsletter_header_code')) {

    /**
     * @return string
     */
    function avatar_newsletter_header_code($newsletter_type, $newsletter_date)
    {
        switch ($newsletter_type) {
            case 'template_ad_ambulletin':
                $code = avatar_header_am_day_code($newsletter_date);
                break;
            case 'template_ad_pmbulletin':
                $code = avatar_header_pm_day_code($newsletter_date);
                break;
            case 'template_ad_weekinreview':
                $code = '537983242';
                break;
            case 'template_ad_bestofthemonth':
                $code = '539639054';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for Footer Banner
 * ============================================================*/

if (! function_exists('avatar_newsletter_footer_code')) {

    /**
     * @return string
     */
    function avatar_newsletter_footer_code($newsletter_type, $newsletter_date)
    {
        switch ($newsletter_type) {
            case 'template_ad_ambulletin':
                $code = avatar_footer_am_day_code($newsletter_date);
                break;
            case 'template_ad_pmbulletin':
                $code = avatar_footer_pm_day_code($newsletter_date);
                break;
            case 'template_ad_weekinreview':
                $code = '537983242';
                break;
            case 'template_ad_bestofthemonth':
                $code = '539639054';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for Big Box AM
 * ============================================================*/

if (! function_exists('avatar_big_box_am_day_code')) {

    /**
     * @return string
     */
    function avatar_big_box_am_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537981578';
                break;
            case 2: //TUESDAY
                $code = '537981581';
                break;
            case 3: //WEDNESDAY
                $code = '537981586';
                break;
            case 4: //THURSDAY
                $code = '537981592';
                break;
            case 5: //FRIDAY
                $code = '537981598';
                break;
            case 6: //SATURDAY
                $code = '537981609';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;

        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for Big Box PM
 * ============================================================*/

if (! function_exists('avatar_big_box_pm_day_code')) {

    /**
     * @return string
     */
    function avatar_big_box_pm_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537983247';
                break;
            case 2: //TUESDAY
                $code = '537983250';
                break;
            case 3: //WEDNESDAY
                $code = '537983253';
                break;
            case 4: //THURSDAY
                $code = '537983257';
                break;
            case 5: //FRIDAY
                $code = '537983260';
                break;
            case 6: //SATURDAY
                $code = '537983263';
                break;
            case 0: //SUNDAY
            default:
                $code = ''; //??
                break;

        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for header AM
 * ============================================================*/

if (! function_exists('avatar_header_am_day_code')) {

    /**
     * @return string
     */
    function avatar_header_am_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537981579';
                break;
            case 2: //TUESDAY
                $code = '537981582';
                break;
            case 3: //WEDNESDAY
                $code = '537981587';
                break;
            case 4: //THURSDAY
                $code = '537981596';
                break;
            case 5: //FRIDAY
                $code = '537981603';
                break;
            case 6: //SATURDAY
                $code = '537981610';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for header PM
 * ============================================================*/

if (! function_exists('avatar_header_pm_day_code')) {

    /**
     * @return string
     */
    function avatar_header_pm_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537983248';
                break;
            case 2: //TUESDAY
                $code = '537983251';
                break;
            case 3: //WEDNESDAY
                $code = '537983254';
                break;
            case 4: //THURSDAY
                $code = '537983258';
                break;
            case 5: //FRIDAY
                $code = '537983261';
                break;
            case 6: //SATURDAY
                $code = '537983265';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for footer PM
 * ============================================================*/

if (! function_exists('avatar_footer_pm_day_code')) {

    /**
     * @return string
     */
    function avatar_footer_pm_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537983249';
                break;
            case 2: //TUESDAY
                $code = '537983252';
                break;
            case 3: //WEDNESDAY
                $code = '537983256';
                break;
            case 4: //THURSDAY
                $code = '537983259';
                break;
            case 5: //FRIDAY
                $code = '537983262';
                break;
            case 6: //SATURDAY
                $code = '537983266';
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code.'1';
    }
}

/* -------------------------------------------------------------
 * OpenX ID for footer AM
 * ============================================================*/

if (! function_exists('avatar_footer_am_day_code')) {

    /**
     * @return string
     */
    function avatar_footer_am_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537981580';
                break;
            case 2: //TUESDAY
                $code = '537981583';
                break;
            case 3: //WEDNESDAY
                $code = '537981588';
                break;
            case 4: //THURSDAY
                $code = '537981597';
                break;
            case 5: //FRIDAY
                $code = '537981608';
                break;
            case 6: //SATURDAY
                $code = '537981611';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code.'1';
    }
}
