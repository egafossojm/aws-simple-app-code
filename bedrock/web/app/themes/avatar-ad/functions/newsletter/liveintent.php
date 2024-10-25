<?php
/**
 * Functions, mapping for LiveIntent (newsletter)
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */

/* -------------------------------------------------------------
 * OpenX ID for Big Box
 * ============================================================*/

if (! function_exists('avatar_ad_newsletter_li_code')) {

    /**
     * @return string
     */
    function avatar_newsletter_li_code($newsletter_type)
    {

        $j = 1;
        $codes_RTB = [];

        switch ($newsletter_type) {
            case 'template_ad_ambulletin':

                $code_728_90_h = '173211';
                $code_728_1_a_h = '173212';
                $code_728_1_b_h = '173213';
                $code_728_116_h = '431316';
                $code_728_19_h = '562386';

                $code_728_90_b = '676707';
                $code_728_116_b = '676708';
                $code_728_19_b = '676710';

                $code_300_250 = '173181';
                $code_300_1_a = '173182';
                $code_300_1_b = '173183';
                $code_300_116 = '431326';
                $code_300_19 = '562396';

                $code_RTB_1 = '124227900';
                $code_RTB_2 = '124227919';

                break;
            case 'template_ad_midday':
                $code_728_90_h = '173217';
                $code_728_1_a_h = '173218';
                $code_728_1_b_h = '173219';
                $code_728_116_h = '431314';
                $code_728_19_h = '562384';

                $code_728_90_b = '676735';
                $code_728_116_b = '676736';
                $code_728_19_b = '676738';

                $code_300_250 = '173187';
                $code_300_1_a = '173188';
                $code_300_1_b = '173189';
                $code_300_116 = '431324';
                $code_300_19 = '562394';

                $code_RTB_1 = '124228000';
                $code_RTB_2 = '124228019';

                break;
            case 'template_ad_pmbulletin':

                $code_728_90_h = '173220';
                $code_728_1_a_h = '173221';
                $code_728_1_b_h = '173222';
                $code_728_116_h = '431313';
                $code_728_19_h = '562383';

                $code_728_90_b = '676739';
                $code_728_116_b = '676740';
                $code_728_19_b = '676742';

                $code_300_250 = '173193';
                $code_300_1_a = '173194';
                $code_300_1_b = '173195';
                $code_300_116 = '431322';
                $code_300_19 = '562392';

                $code_RTB_1 = '124228100';
                $code_RTB_2 = '124228119';

                break;
            case 'template_ad_breakingnews':

                $code_728_90_h = '173226';
                $code_728_1_a_h = '173227';
                $code_728_1_b_h = '173228';
                $code_728_116_h = '431311';
                $code_728_19_h = '562381';

                $code_728_90_b = '676743';
                $code_728_116_b = '676744';
                $code_728_19_b = '676746';

                $code_300_250 = '676747';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '676748';
                $code_300_19 = '676750';

                $code_RTB_1 = '124228400';
                $code_RTB_2 = '124228419';

                break;
            case 'template_ad_weekinreview':

                $code_728_90_h = '173223';
                $code_728_1_a_h = '173224';
                $code_728_1_b_h = '173225';
                $code_728_116_h = '431312';
                $code_728_19_h = '562382';

                $code_728_90_b = '676751';
                $code_728_116_b = '676752';
                $code_728_19_b = '676754';

                $code_300_250 = '173199';
                $code_300_1_a = '173200';
                $code_300_1_b = '173201';
                $code_300_116 = '431320';
                $code_300_19 = '562390';

                $code_RTB_1 = '124228200';
                $code_RTB_2 = '124228219';

                break;
            case 'template_ad_bestofthemonth':

                $code_728_90_h = '173214';
                $code_728_1_a_h = '173215';
                $code_728_1_b_h = '173216';
                $code_728_116_h = '431315';
                $code_728_19_h = '562385';

                $code_728_90_b = '676755';
                $code_728_116_b = '676756';
                $code_728_19_b = '676758';

                $code_300_250 = '173205';
                $code_300_1_a = '173206';
                $code_300_1_b = '173207';
                $code_300_116 = '431318';
                $code_300_19 = '562388';

                $code_RTB_1 = '124228300';
                $code_RTB_2 = '124228319';

                break;

            case 'template_ad_togo':
                $code_728_90_h = '676767';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '676768';
                $code_728_19_h = '676770';

                $code_728_90_b = '676771';
                $code_728_116_b = '676772';
                $code_728_19_b = '676774';

                $code_300_250 = '676763';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '676764';
                $code_300_19 = '676766';

                $code_RTB_1 = '125514200';
                $code_RTB_2 = '125514219';

                break;
        }

        for ($i = $code_RTB_1; $i <= $code_RTB_2; $i++) {
            $codes_RTB['code_RTB_'.$j] = $i;
            $j++;
        }

        return

                array_merge(
                    $codes_RTB,
                    ['code_728_90_h' => $code_728_90_h,
                        'code_728_1_a_h' => $code_728_1_a_h,
                        'code_728_1_b_h' => $code_728_1_b_h,
                        'code_728_116_h' => $code_728_116_h,
                        'code_728_19_h' => $code_728_19_h,
                        'code_728_90_b' => $code_728_90_b,
                        'code_728_116_b' => $code_728_116_b,
                        'code_728_19_b' => $code_728_19_b,
                        'code_300_250' => $code_300_250,
                        'code_300_1_a' => $code_300_1_a,
                        'code_300_1_b' => $code_300_1_b,
                        'code_300_116' => $code_300_116,
                        'code_300_19' => $code_300_19,
                    ]
                );
    }
}
