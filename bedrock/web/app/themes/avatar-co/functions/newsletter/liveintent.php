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
            case 'template_co_ambulletin':

                $code_728_90_h = '173608';
                $code_728_1_a_h = '173609';
                $code_728_1_b_h = '173610';
                $code_728_116_h = '431223';
                $code_728_19_h = '562293';

                $code_728_90_b = '676827';
                $code_728_116_b = '676828';
                $code_728_19_b = '676830';

                $code_300_250 = '173611';
                $code_300_1_a = '173612';
                $code_300_1_b = '173613';
                $code_300_116 = '431222';
                $code_300_19 = '562292';

                $code_RTB_1 = '124233800';
                $code_RTB_2 = '124233819';

                break;
            case 'template_co_pmbulletin':
                $code_728_90_h = '173614';
                $code_728_1_a_h = '173615';
                $code_728_1_b_h = '173616';
                $code_728_116_h = '431221';
                $code_728_19_h = '562291';

                $code_728_90_b = '676831';
                $code_728_116_b = '676832';
                $code_728_19_b = '676834';

                $code_300_250 = '173617';
                $code_300_1_a = '173618';
                $code_300_1_b = '173619';
                $code_300_116 = '431220';
                $code_300_19 = '562290';

                $code_RTB_1 = '124233900';
                $code_RTB_2 = '124233919';

                break;
            case 'template_co_specialoffers':

                $code_728_90_h = '173651';
                $code_728_1_a_h = '173652';
                $code_728_1_b_h = '173653';
                $code_728_116_h = '431208';
                $code_728_19_h = '562278';

                $code_728_90_b = '676835';
                $code_728_116_b = '676836';
                $code_728_19_b = '676838';

                $code_300_250 = '173654';
                $code_300_1_a = '173655';
                $code_300_1_b = '173656';
                $code_300_116 = '431207';
                $code_300_19 = '562277';

                $code_RTB_1 = '124234600';
                $code_RTB_2 = '124234619';

                break;
            case 'template_co_weekinreview':

                $code_728_90_h = '173620';
                $code_728_1_a_h = '173621';
                $code_728_1_b_h = '173622';
                $code_728_116_h = '431219';
                $code_728_19_h = '562289';

                $code_728_90_b = '676839';
                $code_728_116_b = '676840';
                $code_728_19_b = '676842';

                $code_300_250 = '173623';
                $code_300_1_a = '173624';
                $code_300_1_b = '173625';
                $code_300_116 = '431218';
                $code_300_19 = '562288';

                $code_RTB_1 = '124234000';
                $code_RTB_2 = '124234019';
                break;
            case 'template_co_endirect':

                $code_728_90_h = '676843';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '676844';
                $code_728_19_h = '676846';

                $code_728_90_b = '676847';
                $code_728_116_b = '676848';
                $code_728_19_b = '676850';

                $code_300_250 = '676851';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '676852';
                $code_300_19 = '676854';

                $code_RTB_1 = '125514600';
                $code_RTB_2 = '125514619';
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
