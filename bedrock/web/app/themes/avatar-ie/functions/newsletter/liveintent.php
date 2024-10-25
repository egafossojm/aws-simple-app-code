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
            case 'template_ie_am':

                $code_728_90_h = '228294';
                $code_728_1_a_h = '228295';
                $code_728_1_b_h = '228296';
                $code_728_116_h = '420573';
                $code_728_19_h = '551643';

                $code_728_90_b = '706356';
                $code_728_116_b = '706357';
                $code_728_19_b = '706359';

                $code_300_250 = '228291';
                $code_300_1_a = '228292';
                $code_300_1_b = '228293';
                $code_300_116 = '420574';
                $code_300_19 = '551644';

                $code_RTB_1 = '124771000';
                $code_RTB_2 = '124771019';

                break;
            case 'template_ie_pm':
                $code_728_90_h = '228300';
                $code_728_1_a_h = '228301';
                $code_728_1_b_h = '228302';
                $code_728_116_h = '420571';
                $code_728_19_h = '551641';

                $code_728_90_b = '706364';
                $code_728_116_b = '706365';
                $code_728_19_b = '706367';

                $code_300_250 = '228297';
                $code_300_1_a = '228298';
                $code_300_1_b = '228299';
                $code_300_116 = '420572';
                $code_300_19 = '551642';

                $code_RTB_1 = '124771100';
                $code_RTB_2 = '124771119';

                break;
            case 'template_ie_weekly':

                $code_728_90_h = '228306';
                $code_728_1_a_h = '228307';
                $code_728_1_b_h = '228308';
                $code_728_116_h = '420569';
                $code_728_19_h = '551639';

                $code_728_90_b = '706376';
                $code_728_116_b = '706377';
                $code_728_19_b = '706379';

                $code_300_250 = '228303';
                $code_300_1_a = '228304';
                $code_300_1_b = '228305';
                $code_300_116 = '420570';
                $code_300_19 = '551640';

                $code_RTB_1 = '124771200';
                $code_RTB_2 = '124771219';

                break;

            case 'template_ie_monthly':

                $code_728_90_h = '706576';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '706577';
                $code_728_19_h = '706579';

                $code_728_90_b = '706580';
                $code_728_116_b = '706581';
                $code_728_19_b = '706583';

                $code_300_250 = '706672';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '706673';
                $code_300_19 = '706675';

                $code_RTB_1 = '125742000';
                $code_RTB_2 = '125742019';

                break;

            case 'template_ie_etf':

                $code_728_90_h = '706568';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '706569';
                $code_728_19_h = '706571';

                $code_728_90_b = '706572';
                $code_728_116_b = '706573';
                $code_728_19_b = '706575';

                $code_300_250 = '706668';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '706669';
                $code_300_19 = '706671';

                $code_RTB_1 = '125741900';
                $code_RTB_2 = '125741919';

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
