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
            case 'template_fi_quotidien':

                $code_728_90_h = '228288';
                $code_728_1_a_h = '228289';
                $code_728_1_b_h = '228290';
                $code_728_116_h = '420575';
                $code_728_19_h = '551645';

                $code_728_90_b = '706344';
                $code_728_116_b = '706345';
                $code_728_19_b = '706347';

                $code_300_250 = '228285';
                $code_300_1_a = '228286';
                $code_300_1_b = '228287';
                $code_300_116 = '420576';
                $code_300_19 = '551646';

                $code_RTB_1 = '124771300';
                $code_RTB_2 = '124771319';

                break;
            case 'template_fi_hebdo':
                $code_728_90_h = '228282';
                $code_728_1_a_h = '228283';
                $code_728_1_b_h = '228284';
                $code_728_116_h = '420577';
                $code_728_19_h = '551647';

                $code_728_90_b = '706328';
                $code_728_116_b = '706329';
                $code_728_19_b = '706331';

                $code_300_250 = '228279';
                $code_300_1_a = '228280';
                $code_300_1_b = '228281';
                $code_300_116 = '420578';
                $code_300_19 = '551648';

                $code_RTB_1 = '124771400';
                $code_RTB_2 = '124771419';

                break;
            case 'template_fi_fireleve':

                $code_728_90_h = '228276';
                $code_728_1_a_h = '228277';
                $code_728_1_b_h = '228278';
                $code_728_116_h = '420579';
                $code_728_19_h = '551649';

                $code_728_90_b = '706336';
                $code_728_116_b = '706337';
                $code_728_19_b = '706339';

                $code_300_250 = '228270';
                $code_300_1_a = '228271';
                $code_300_1_b = '228272';
                $code_300_116 = '420581';
                $code_300_19 = '551651';

                $code_RTB_1 = '124771500';
                $code_RTB_2 = '124771519';

                break;

            case 'template_fi_specialefnb':

                $code_728_90_h = '706584';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '706585';
                $code_728_19_h = '706587';

                $code_728_90_b = '706588';
                $code_728_116_b = '706589';
                $code_728_19_b = '706591';

                $code_300_250 = '706676';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '706677';
                $code_300_19 = '706679';

                $code_RTB_1 = '125742100';
                $code_RTB_2 = '125742119';

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
