<?php
/* -------------------------------------------------------------
 * Hooks for Newsletter admin page
 * ============================================================*/

/* -------------------------------------------------------------
 *  Add a button in order to send Newsletter as a test
 * ============================================================*/

if (! function_exists('avatar_newsletter_button')) {

    function avatar_newsletter_button()
    {
        // Variables
        global $post_type;
        // If in Newsletter
        if ($post_type == 'newsletter') { ?>
			<div id="major-publishing-actions" style="overflow:hidden">
				<div id="publishing-action">
					<?php if (get_post_status(get_the_ID()) == 'publish') { ?>
					<input type="submit" accesskey="p" tabindex="5" value="<?php _e('Send a test to DI', 'avatar-tcm'); ?>" class="button-secondary" id="send-test" name="send-test">
					<input type="submit" accesskey="p" tabindex="6" value="<?php _e('Send to DI', 'avatar-tcm'); ?>" class="button-secondary" id="send-to-di" name="send-to-di">
					<?php } ?>
				</div>
			</div>
		<?php

        }
    }
    add_action('post_submitbox_misc_actions', 'avatar_newsletter_button');
}

// Save and send the newsletter

if (! function_exists('avatar_send_newsletter_callback')) {
    function avatar_send_newsletter_callback($post_id)
    {

        global $post;

        if ($post->post_type == 'newsletter') {
            $submit_button_test_di = $_POST['send-test'];
            $submit_button_send_to_di = $_POST['send-to-di'];

            if (isset($submit_button_send_to_di) || isset($submit_button_test_di)) {
                $subject = get_field('acf_newsletter_subject');

                $communication_type = explode('_', get_field('acf_newsletter_template')['value']);

                if (isset($communication_type[2])) {

                    $communication_type = constant('AVATAR_DIALOG_INSIGHT_COMMUNICATION_TYPE_'.strtoupper($communication_type[2]));

                    $params = [
                        'communication_type' => $communication_type,
                        'sending_date' => get_field('acf_newsletter_send_date'),
                        'sender_name' => AVATAR_DIALOG_INSIGHT_SENDER_NAME[get_field('acf_newsletter_template')['value']],
                    ];

                    if (isset($submit_button_test_di)) {
                        $params['id_filter'] = AVATAR_DIALOG_INSIGHT_TEST_FILTER;
                    }

                    $newsletter_url = get_permalink(get_the_ID());

                    avatar_send_message_di($subject, $newsletter_url, $params);

                }
            }

        }
    }
    add_action('save_post', 'avatar_send_newsletter_callback');
}

?>