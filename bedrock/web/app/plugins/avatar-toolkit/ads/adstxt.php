<?php
/* -------------------------------------------------------------
 * Forked from "Metro ads.txt" originally created by Sylvain Maltais
 * ============================================================*/

/* -------------------------------------------------------------
 * Register the rewrite rule for /ads.txt request.
 * ============================================================*/
if (! function_exists('at_ads_txt_init')) {
    function at_ads_txt_init()
    {
        add_rewrite_rule('^ads\.txt$', 'index.php?avatar_adstxt=true', 'top');
    }
    add_action('init', 'at_ads_txt_init');
}

/* -------------------------------------------------------------
 * Merge query variables
 * ============================================================*/

if (! function_exists('at_ads_txt_query_vars')) {

    function at_ads_txt_query_vars($query_vars)
    {
        $new_vars = ['avatar_adstxt'];

        return array_merge($query_vars, $new_vars);
    }
    add_filter('query_vars', 'at_ads_txt_query_vars', 10, 1);
}

/* -------------------------------------------------------------
 * Display the content of ads.txt
 * ============================================================*/

if (! function_exists('at_ads_txt')) {

    function at_ads_txt(&$wp)
    {
        if ((isset($wp->query_vars['avatar_adstxt']) && $wp->query_vars['avatar_adstxt'] === 'true') || (isset($wp->query_vars['pagename']) && ($wp->query_vars['pagename'] === 'ads.txt'))) {
            $at_getadstxt_content = get_field('acf_adstxt', 'options');
            if ($at_getadstxt_content) {
                header('Content-Type: text/plain');
                echo $at_getadstxt_content;
                exit;
            }
        }

    }
    add_action('parse_request', 'at_ads_txt', 10, 1);
}
