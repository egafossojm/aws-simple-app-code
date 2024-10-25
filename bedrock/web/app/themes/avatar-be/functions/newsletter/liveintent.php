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
            case 'template_beca_beca-newsletter':

                $code_728_90_h = '173241';
                $code_728_1_a_h = '173242';
                $code_728_1_b_h = '173243';
                $code_728_116_h = '431307';
                $code_728_19_h = '562377';

                $code_728_90_b = '721585';
                $code_728_116_b = '721586';
                $code_728_19_b = '721588';

                $code_300_250 = '173238';
                $code_300_1_a = '173239';
                $code_300_1_b = '173240';
                $code_300_116 = '431308';
                $code_300_19 = '562378';

                $code_RTB_1 = '124228600';
                $code_RTB_2 = '124228619';

                break;
            case 'template_cir_cir-newsletter':
                $code_728_90_h = '173581';
                $code_728_1_a_h = '173582';
                $code_728_1_b_h = '173583';
                $code_728_116_h = '431227';
                $code_728_19_h = '562297';

                $code_728_90_b = '721589';
                $code_728_116_b = '721590';
                $code_728_19_b = '721592';

                $code_300_250 = '721565';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '721566';
                $code_300_19 = '721568';

                $code_RTB_1 = '124233600';
                $code_RTB_2 = '124233619';

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
