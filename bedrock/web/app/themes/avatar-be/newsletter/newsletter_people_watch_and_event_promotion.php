<!-- <pre><?php // print_r($all_fields);
            ?></pre> -->
<table class="twelve columns" style="background-color: white;border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:728px;margin:0 auto 15px;padding:0;">
    <!-- <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
        <th style="text-align: center;">People Watch</th>
        <th style="text-align: center;">Conferences</th>
    </tr> -->
    <tbody>
    <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
        <td class="wrapper" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 25px;" valign="top">
            <?php if (strpos($campaign, 'beca') !== false) { ?>
                <center style="padding: 10px 0 0 0;">
                    <strong style="font-size: 18px;color:<?php echo esc_attr($site_color); ?>;">People Watch</strong>
                </center>
                <ul style="width: 240px; text-decoration: none; list-style-type: none; padding: 0;">
                    <?php foreach ((array) $all_fields['acf_newsletter_footer_people_watch_list'] as $appointment_block) { ?>
                        <li style="padding: 0 0 10px 0;">
                            <a class="blurb-label" style="font-weight: bold;font-size:12px;color:black;text-decoration:none;" href="<?php echo avatar_get_the_permalink_url(get_permalink($appointment_block['acf_newsletter_footer_appointment_notice']), $campaign) ?>">
                                <?php
                                    $appointment_title = ! empty($appointment_block['acf_newsletter_footer_custom_title'])
                                        ? $appointment_block['acf_newsletter_footer_custom_title']
                                        : $appointment_block['acf_newsletter_footer_appointment_notice']->post_title;
                        echo $appointment_title;
                        ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <center>
                    <a target="_blank" style="font-size:12px;color:<?php echo esc_attr($site_color); ?>;text-decoration:none;" href="<?php echo avatar_get_the_permalink_url($all_fields['acf_newsletter_footer_link_to_people_watch_page'], $campaign) ?>">Visit People Watch Page for more.</a>
                </center> 
            <?php } else { ?>
                <center style="padding: 10px 0 0 0;">
                    <strong style="font-size: 18px;color:<?php echo esc_attr($site_color); ?>;">Contact Us</strong>
                </center>
                <ul style="width: 240px; text-decoration: none; list-style-type: none; padding: 0;">
                    <?php foreach ((array) $all_fields['acf_newsletter_footer_contact_page'] as $appointment_block) { ?>
                        <li style="padding: 0 0 10px 0;">
                            <a class="blurb-label" style="font-weight: bold;font-size:12px;color:black;text-decoration:none;" href="mailto:<?php echo $appointment_block['acf_newsletter_footer_contact_page_email'] ?>">
                                <?php
                            $appointment_title = ! empty($appointment_block['acf_newsletter_footer_contact_page_label'])
                                ? $appointment_block['acf_newsletter_footer_contact_page_label']
                                : $appointment_block['acf_newsletter_footer_contact_page_email'];
                        echo $appointment_title;
                        ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </td>
        <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;vertical-align:top;text-align:left;position:relative;color:#222;font-family:Arial;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px 25px;" valign="top">
            <center style="padding: 10px 0 0 0;">
                <strong style="font-size: 18px;color:<?php echo esc_attr($site_color); ?>;">Conferences</strong>
            </center>
            <ul style="width: 240px; text-decoration: none; list-style-type: none; padding: 0;">
                <?php foreach ((array) $all_fields['acf_newsletter_footer_events_list'] as $event_block) { ?>
                    <li style="padding: 0 0 10px 0;">
                        <a class="blurb-label" style="font-weight: bold;font-size:12px;color:black;text-decoration:none;" href="<?php echo avatar_get_the_permalink_url($event_block['acf_newsletter_footer_event_link'], $campaign) ?>">
                            <?php echo $event_block['acf_newsletter_footer_event_title'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <center>
                <a target="_blank" style="font-size:12px;color:<?php echo esc_attr($site_color); ?>;text-decoration:none;" href="<?php echo avatar_get_the_permalink_url($all_fields['acf_newsletter_footer_events_link_to_event_page'], $campaign) ?>">Visit Conferences for more.</a>
            </center>
        </td>
    </tr>
    </tbody>
    <!-- <tr style="vertical-align:top;text-align:left;padding:0;" align="left">
        <td style="text-align: center;">
            <a target="_blank" href="<?php // $all_fields['acf_newsletter_footer_link_to_people_watch_page']
                                ?>">Go to People Watch Page</a>
        </td>
        <td style="text-align: center;">
            <a target="_blank" href="<?php // $all_fields['acf_newsletter_footer_events_link_to_event_page']
                                ?>">Go to event Page</a>
        </td>
    </tr> -->
</table>



<!-- acf_newsletter_footer_people_watch_list -->
<!-- acf_newsletter_footer_appointment_notice -->
<!-- acf_newsletter_footer_link_to_people_watch_page -->
<!-- acf_newsletter_footer_events_list -->
<!-- acf_newsletter_footer_event_title -->
<!-- acf_newsletter_footer_event_link -->
<!-- acf_newsletter_footer_events_link_to_event_page -->