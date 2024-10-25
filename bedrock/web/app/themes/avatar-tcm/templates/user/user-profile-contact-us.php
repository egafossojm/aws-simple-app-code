<!-- User profile tab : contact-us -->
<?php
    // User Contact
    $was_sent = false;
if (isset($_REQUEST['send_user_message'])) {
    $user_sbj = isset($_REQUEST['subject']) ? sanitize_text_field(trim(wp_kses($_REQUEST['subject'], []))) : false;
    $user_msg = isset($_REQUEST['message']) ? str_replace('&amp;', '&', sanitize_textarea_field(wp_kses($_REQUEST['message'], []))) : false;

    if (! $user_sbj) {
        $errors->add('user_sbj', __('Required field "Subject" is missing', 'avatar-tcm'));
    }
    if (strlen($user_sbj) > 121) {
        $errors->add('user_sbj', __('The subject must not exceed 120 characters', 'avatar-tcm'));
    }
    if (! $user_msg) {
        $errors->add('user_msg', __('Required form field "Message" is missing', 'avatar-tcm'));
    }

    // it's ok send email
    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {

        $time = date_i18n(get_option('date_format'), current_time('timestamp'));
        $send_email_to = get_field('acf_profile_contactus_email', 'option');
        $ip = avatar_get_ip_address();
        //$headers = 'Cc: '.$current_user->display_name.' <'.$current_user->user_email.'>;' . "\r\n";

        $user_msg .= '<hr><br /><br /><code>';
        $user_msg .= __('IP address : ', 'avatar-tcm').$ip.'<br />';
        $user_msg .= __('Date : ', 'avatar-tcm').$time.'<br />';
        $user_msg .= __('Name : ', 'avatar-tcm').$current_user->display_name.'<br />';
        $user_msg .= __('Email : ', 'avatar-tcm').$current_user->user_email.'<br />';
        $user_msg .= __('Website : ', 'avatar-tcm').get_bloginfo('url').'<br /></code>';

        $body_message = avatar_template_email_system(['title' => stripslashes_deep($user_sbj), 'content' => stripslashes_deep(nl2br($user_msg))]);

        avatar_send_email($send_email_to, get_bloginfo('name').' - '.__('Contact Us', 'avatar-tcm'), $body_message); //to IE

        $was_sent = true;
        // clean contact form
        $user_sbj = $user_msg = '';
    }

}
?>
<div class="row">
	<div class="text-center">
		<span class="user-profile-content__title"><?php echo esc_html($profile_contact_us->post_title); ?></span>
		<p class="user-profile-content__intro-text"><?php the_content(); ?></p>
	</div>

	<form class="user-form col-md-6 col-md-offset-3" action="<?php echo avatar_get_current_url(); ?>" method="POST">
		<?php if ($was_sent) { ?>
			<div class="alert alert-success">
				<?php _e('Message was sent. Thank you!', 'avatar-tcm'); ?>
			</div>
		<?php } ?>
		<div>
			<label for="subject" class="user-form__label"><?php _e('Subject', 'avatar-tcm'); ?></label>
			<input value="<?php echo isset($user_sbj) ? $user_sbj : ''; ?>" type="text" id="subject" name="subject" class="form-control" aria-required="true" required maxlength="120">
			<?php if (is_wp_error($errors) && array_key_exists('user_sbj', $errors->errors)) { ?>
				<?php foreach ($errors->errors['user_sbj'] as $key => $value) { ?>
					<span class="sign-in-box__validation-message"><?php echo esc_html($value); ?></span>
				<?php } ?>
			<?php } ?>
		</div>
		<label for="user-form-message" class="user-form__label"><?php echo _e('Your message', 'avatar-tcm'); ?></label>
		<textarea name="message" class="form-control" id="user-form-message" rows="3" aria-required="true" required><?php echo isset($user_msg) ? esc_textarea($user_msg) : ''; ?></textarea>
		<?php if (is_wp_error($errors) && array_key_exists('user_msg', $errors->errors)) { ?>
			<?php foreach ($errors->errors['user_msg'] as $key => $value) { ?>
				<span class="sign-in-box__validation-message"><?php echo esc_html($value); ?></span>
			<?php } ?>
		<?php } ?>
		<br>
		<input name="send_user_message" type="submit" class="btn user-form__btn-submit" value="<?php esc_attr_e('Send this message', 'avatar-tcm'); ?>">
	</form>
</div>