<?php
/**
 * Created by IntelliJ IDEA.
 * User: jutrasj
 * Date: 17-11-16
 * Time: 9:50 AM
 */
if (! function_exists('avatar_newsletter_big_box_code')) {
    function avatar_newsletter_big_box_code($newsletter_type, $newsletter_date)
    {

        switch ($newsletter_type) {
            case 'template_fi_quotidien':
                $code = avatar_big_box_daily_day_code($newsletter_date);
                break;
            case 'template_fi_specialefnb':
                $code = '539892460';
                break;
            case 'template_fi_hebdo':
                $code = '537981560';
                break;
            case 'template_fi_mensuel':
                $code = '537983709';
                break;
            case 'template_fi_fireleve':
                $code = '537983189';
                break;

        }

        return $code;
    }
}
if (! function_exists('avatar_newsletter_header_code')) {
    function avatar_newsletter_header_code($newsletter_type, $newsletter_date)
    {
        switch ($newsletter_type) {
            case 'template_fi_quotidien':
                $code = avatar_header_daily_day_code($newsletter_date);
                break;
            case 'template_fi_specialefnb':
                $code = '539892461';
                break;
            case 'template_fi_hebdo':
                $code = '537981561';
                break;
            case 'template_fi_mensuel':
                $code = '537983710';
                break;
            case 'template_fi_fireleve':
                $code = '537983190';
                break;

        }

        return $code;
    }
}
if (! function_exists('avatar_newsletter_footer_code')) {
    function avatar_newsletter_footer_code($newsletter_type, $newsletter_date)
    {
        switch ($newsletter_type) {
            case 'template_fi_quotidien':
                $code = avatar_footer_daily_day_code($newsletter_date);
                break;
            case 'template_fi_specialefnb':
                $code = '539892462';
                break;
            case 'template_fi_hebdo':
                $code = '539756784';
                break;
            case 'template_fi_mensuel':
                $code = '539756780';
                break;
            case 'template_fi_fireleve':
                $code = '539756783';
                break;

        }

        return $code;
    }
}

if (! function_exists('avatar_big_box_daily_day_code')) { //OK
    function avatar_big_box_daily_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '539756770';
                break;
            case 2: //TUESDAY
                $code = '539756771';
                break;
            case 3: //WEDNESDAY
                $code = '539756772';
                break;
            case 4: //THURSDAY
                $code = '539756773';
                break;
            case 5: //FRIDAY
                $code = '539756779';
                break;
            case 6: //SATURDAY
                $code = '537981560';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;

        }

        return $code;
    }
}

if (! function_exists('avatar_header_daily_day_code')) {//OK
    function avatar_header_daily_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537981562';
                break;
            case 2: //TUESDAY
                $code = '537981564';
                break;
            case 3: //WEDNESDAY
                $code = '537981566';
                break;
            case 4: //THURSDAY
                $code = '537981568';
                break;
            case 5: //FRIDAY
                $code = '537981570';
                break;
            case 6: //SATURDAY
                $code = '537981561';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code;
    }
}

if (! function_exists('avatar_footer_daily_day_code')) { //ok
    function avatar_footer_daily_day_code($date)
    {

        $day_of_week = date('w', strtotime($date));

        switch ($day_of_week) {
            case 1: //MONDAY
                $code = '537981563';
                break;
            case 2: //TUESDAY
                $code = '537981565';
                break;
            case 3: //WEDNESDAY
                $code = '537981567';
                break;
            case 4: //THURSDAY
                $code = '537981569';
                break;
            case 5: //FRIDAY
                $code = '537981577';
                break;
            case 6: //SATURDAY
                $code = '539756784';
                break;
            case 0: //SUNDAY
            default:
                $code = '';
                break;
        }

        return $code;
    }
}
