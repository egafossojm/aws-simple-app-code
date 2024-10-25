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
            case 'template_av_vosnouvellesdumardi':

                $code_728_90_h = '173792';
                $code_728_1_a_h = '173793';
                $code_728_1_b_h = '173794';
                $code_728_116_h = '431161';
                $code_728_19_h = '562231';

                $code_728_90_b = '676855';
                $code_728_116_b = '676856';
                $code_728_19_b = '676858';

                $code_300_250 = '173795';
                $code_300_1_a = '173796';
                $code_300_1_b = '173797';
                $code_300_116 = '431160';
                $code_300_19 = '562230';

                $code_RTB_1 = '124236000';
                $code_RTB_2 = '124236019';

                break;
            case 'template_av_vosnouvellesdujeudi':
                $code_728_90_h = '174593';
                $code_728_1_a_h = '174594';
                $code_728_1_b_h = '174595';
                $code_728_116_h = '430964';
                $code_728_19_h = '562034';

                $code_728_90_b = '676859';
                $code_728_116_b = '676860';
                $code_728_19_b = '676862';

                $code_300_250 = '174596';
                $code_300_1_a = '174597';
                $code_300_1_b = '174598';
                $code_300_116 = '430965';
                $code_300_19 = '562035';

                $code_RTB_1 = '124244500';
                $code_RTB_2 = '124244519';

                break;
            case 'template_av_vosnouvellesprefereesdumois':

                $code_728_90_h = '173798';
                $code_728_1_a_h = '173799';
                $code_728_1_b_h = '173800';
                $code_728_116_h = '431159';
                $code_728_19_h = '562229';

                $code_728_90_b = '676863';
                $code_728_116_b = '676864';
                $code_728_19_b = '676866';

                $code_300_250 = '173801';
                $code_300_1_a = '173802';
                $code_300_1_b = '173803';
                $code_300_116 = '431158';
                $code_300_19 = '562228';

                $code_RTB_1 = '124236100';
                $code_RTB_2 = '124236119';

                break;
            case 'template_av_editionspeciale':

                $code_728_90_h = '676867';
                $code_728_1_a_h = '';
                $code_728_1_b_h = '';
                $code_728_116_h = '676868';
                $code_728_19_h = '676870';

                $code_728_90_b = '676871';
                $code_728_116_b = '676872';
                $code_728_19_b = '676874';

                $code_300_250 = '676875';
                $code_300_1_a = '';
                $code_300_1_b = '';
                $code_300_116 = '676876';
                $code_300_19 = '676878';

                $code_RTB_1 = '125514700';
                $code_RTB_2 = '125514719';
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
