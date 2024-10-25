<?php
/* -------------------------------------------------------------
 * VARIABLES
 * ============================================================*/
$email = $_email;

$has_errors = false;

// Page
//@todo delete this variable
//$page = isset( $_GET['q'] ) ? htmlspecialchars( $_GET['q'] ) : '';

// Email
$user_login_email_forgot = isset($_POST['user_login_email_forgot']) ? $_POST['user_login_email_forgot'] : false;
$g_recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

$was_submited = isset($_POST['form_forgot_password']) ? true : false;

/* -------------------------------------------------------------
 * VERIFICATIONS - Create an object "$errors"
 * ============================================================*/
if ($was_submited) {
    // Make sure there is a proper wp error obj. If not, make one
    if (! is_wp_error($errors)) {
        $errors = new WP_Error;
    }

    // Validate email
    if (isset($user_login_email_forgot) && (! is_email($user_login_email_forgot) || ! email_exists($user_login_email_forgot))) {
        $errors->add('email_invalid', __('Email is invalid', 'avatar-tcm'));
    }

    // Validate captcha
    if (empty($g_recaptcha_response)) {
        $errors->add('recaptcha_error', __('Please check the the captcha form.', 'avatar-tcm'));
    } else {
        $secretKey = get_field('acf_recaptcha_secret_key', 'options');
        $ip = avatar_get_ip_address();
        $response = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$g_recaptcha_response.'&remoteip='.$ip);
        $response = wp_remote_retrieve_body($response);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys['success']) !== 1) {
            $errors->add('recaptcha_spam', __('The captcha must be validated', 'avatar-tcm'));
        }
    }

    // Variable
    if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
        $has_errors = true;
    }
}

/* -------------------------------------------------------------
 * EMAIL - PREPARE AND SEND
 * ============================================================*/

if ($was_submited && ! $has_errors) {
    // Get user info
    $user_object = get_user_by('email', $user_login_email_forgot);
    $user_id = $user_object->ID;
    $user_first_name = $user_object->first_name;

    // Getnerate 'activation' code and 'link'
    $code = sha1($user_id.current_time('timestamp'));
    $activation_link = add_query_arg(['resetkey' => $code, 'u' => $user_id], get_permalink(get_field('acf_page_password_reset', 'option')));

    // Save user activation code
    update_user_meta($user_id, 'avatar_resetkey', $code);

    // Construct email to reset password
    $email_subject = '['.get_bloginfo().'] '.__('Reset Password', 'avatar-tcm');
    $email_title = __('Password change request', 'avatar-tcm');
    $email_content = '<p style="font-size:17px; color:#222; "> '.__('Dear', 'avatar-tcm').' '.$user_first_name.',</p>

						<p style="font-size:17px; color:#222; ">'.__('You can reset your password for', 'avatar-tcm').' '.get_bloginfo().'. <br />
						<a href="'.esc_url($activation_link).'" style="text-decoration:none; display:inline-block; color:#fff; background:'.get_theme_mod('primary_color').'; border-radius:5px; margin:10px auto; padding:8px 15px; font-size:17px; font-weight:normal;">'.__('Click here', 'avatar-tcm').'</a><br />
						'.__('If the above link doesn\'t work, copy and paste the text below in your browser', 'avatar-tcm').' :<br />
						'.$activation_link.'</p>

						<p style="font-size:17px; color:#222; ">'.__('Sincerely', 'avatar-tcm').',</p>

						<p style="font-size:17px; color:#222; ">'.__('IE team', 'avatar-tcm').'</p>';
    $body_message = avatar_template_email_system(['title' => $email_title, 'content' => $email_content]);

    // Send email to reset password
    avatar_send_email($user_login_email_forgot, $email_subject, $body_message);
}  ?>

<h3 class="sign-in-box__title"><?php _e('Forgot password', 'avatar-tcm'); ?></h3>
<?php
/**
  * Forgot password page 2 (after validation of first form AND if no errors)
  **/
if ($was_submited && ! $has_errors) { ?>
	<p class="tab-pane-sign-in__text">
		<?php printf(__('An email was sent to %s', 'avatar-tcm'), $user_login_email_forgot); ?><br><br>
		<?php _e('Follow the link in the email to reset your password.', 'avatar-tcm'); ?>
	</p>
	<p class="tab-pane-sign-in__text"><?php _e('Kind regards', 'avatar-tcm'); ?>,</p>
	<p class="tab-pane-sign-in__text"><?php _e('IE team', 'avatar-tcm'); ?></p>
	<a id="trigger-form-login" href="#" class="tab-pane-sign-in__link text-right">
		<?php _e('Back to sign in', 'avatar-tcm'); ?>
		<i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
	</a>
<?php
/**
  * Forgot password page 1 (first form and display errors)
  **/
} else { ?>
	<p class="tab-pane-sign-in__text">
		<?php _e('Follow the link in the email to reset your password.', 'avatar-tcm'); ?>
	</p>
	<?php
    if ($has_errors) {
        // Display errors
        $html_errors =
            '<div class="panel validation-box row">
				<div class="panel-heading">
					<span class="validation-box__message validation-box__message--small">'.__('Please verify these fields', 'avatar-tcm').'</span>
						<ul class="validation-box__list">';
        foreach ($errors->get_error_messages() as $key => $val) {
            $html_errors .= '<li class="validation-box__item">'.$val.'</li>';
        }
        $html_errors .= '	</ul>
				</div>
			</div>';
        echo wp_kses($html_errors, ['div' => ['class' => []], 'span' => ['class' => []], 'ul' => ['class' => []], 'li' => ['class' => []]]);
    } ?>

	<form name="loginform_forgot" id="loginform_forgot" class="sign-in-form" action="<?php echo avatar_get_current_url(['q' => 'f2']); ?>#f2" method="post">
		<p class="login-username">
			<label for="user_login_email_forgot"><?php _e('Your email', 'avatar-tcm'); ?></label>
			<input type="email" name="user_login_email_forgot" id="user_login_email_forgot" class="input" value="<?php echo esc_attr($email); ?>" required="required"  />
		</p>
		<div class="g-recaptcha forgot-recaptcha" data-sitekey="<?php echo esc_attr(get_field('acf_recaptcha_site_key', 'options')); ?>"></div>
		<p class="login-submit">
			<input type="submit" name="wp-submit" id="wp-submit" class="btn button user-form__btn-submit--negative" value="<?php esc_attr_e('Submit', 'avatar-tcm'); ?>" />
			<input type="hidden" name="redirect_to" value="<?php echo esc_url($ref_url); ?>" />
			<input type="hidden" name="form_forgot_password" value="1" />
		</p>
	</form>
	<a id="trigger-form-login" href="#" class="tab-pane-sign-in__link text-right">
		<?php _e('Back to sign in', 'avatar-tcm'); ?>
		<i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
	</a>
<?php } ?>