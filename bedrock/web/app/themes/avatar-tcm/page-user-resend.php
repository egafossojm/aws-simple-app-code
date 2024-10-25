<?php
/**
*Template Name: User : Resend Activation Email
**/
?>
<?php
if (is_user_logged_in()) {
    //return;
}
if (! isset($errors)) {
    $errors = new WP_Error;
}
// If User subscribed and has click on the link from the confirmation email, User will be redirected on login page
if (isset($_GET['email']) && isset($_GET['key'])) {

    // Test GET variables
    if (! email_exists($_GET['email'])) {

        $errors->add('user_id', __('This Email do not exist', 'avatar-tcm'));

    } else {
        $avatar_user = get_user_by('email', $_GET['email']);

        if ($avatar_user) {

            // ok, we have the good user ID, it is time to test the key
            if (! avatar_is_sha1($_GET['key'])) {

                $errors->add('user_activation_key', __('Activation code is not valid', 'avatar-tcm'));
            } else {
                // Get user activation key
                $avatar_user_activation_key = get_user_meta($avatar_user->ID, 'avatar_activate_code', true);
                if ($avatar_user_activation_key != $_GET['key']) {

                    $errors->add('user_no_activation_key', __('Activation code does not exist', 'avatar-tcm'));

                }
            }

        } else {
            $errors->add('user_not_exist', __('User email do not exist', 'avatar-tcm'));
        }
    }

    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {
        $email_subject = '['.get_bloginfo('name').'] '.__('Confirm your account', 'avatar-tcm');
        // Send user activation code
        $activation_link = add_query_arg(['key' => $avatar_user_activation_key, 'u' => $avatar_user->ID], get_permalink(get_field('acf_page_signin', 'option')));
        $site_main_color = get_theme_mod('primary_color');
        $site_email = get_field('acf_profile_register_email', 'options');
        $title_content = __('Create your account', 'avatar-tcm'); // [1] title
        $text_content = '
						<span class="x_title" style="font-size:17px; color:#222; font-weight:700"><strong>'.sprintf(__('Hi %s', 'avatar-tcm'), $avatar_user->first_name).',</strong></span><br>
						<span class="x_title" style="font-size:17px; color:#222; font-weight:600"><strong>'.__('Please confirm your account : ', 'avatar-tcm').'</strong></span><br><br>
						<a href="'.esc_url($activation_link).'" target="_blank" rel="noopener noreferrer" style="text-decoration:none; display:inline-block; color:#fff; font-weight:700; background:'.$site_main_color.';   border-radius:5px;  margin:10px auto; padding:8px 15px;  font-size:12px;  font-weight:normal; ">'.__('Confirm my account', 'avatar-tcm').'</a><br><br>
						'.__('Thank you for being part of the greatest financial community in Canada. If you have any problems, please write to :', 'avatar-tcm');
        $text_content .= '<a href="mailto:'.$site_email.'">'.$site_email.'</a>';
        // Send Email to user
        $body_message = avatar_template_email_system(['title' => $title_content, 'content' => $text_content]);
        //avatar_new_user_email_html ( $wp_arr['first_name'], $activation_link );

        avatar_send_email($_GET['email'], $email_subject, $body_message);

    }
} else {
    $errors->add('user_id_key_not_exist', __('User Email and the Activation Key do not exist', 'avatar-tcm'));
}
?>
<?php get_header(); ?>
<div class="wrap">
<div id="primary" class="content-area">
	<main class="user-page">
		<section class="col-no-padding-xs col-md-12">
			<!--user header -->
				<div class="user-header__page-title"
					style="background:
					linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),
					url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), $size = 'large')) ?>') center center;
					background-size:cover;"><!--background image -->
					<h1 class="user-header__page-title-text"><?php the_title(); ?></h1>
				</div>
			</div>
		</section>
		<section class="col-md-12 user-form">
			<?php

                if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
                    // Display errors
                    $html_errors =
                        '<div class="panel validation-box row">
							<div class="panel-heading">
								<div class="col-md-3">
									<span class="validation-box__message">'.__('Activation failed!', 'avatar-tcm').'</span>
								</div>
								<div class="col-md-9">
									<span class="validation-box__message validation-box__message--small">'.__('Wrong URL', 'avatar-tcm').'</span>
										<ul class="validation-box__list">';
                    foreach ($errors->get_error_messages() as $key => $val) {
                        $html_errors .= '<li class="validation-box__item">'.$val.'</li>';
                    }
                    $html_errors .= '</ul></div></div></div>';
                    echo wp_kses($html_errors, ['div' => ['class' => []], 'span' => ['class' => []], 'ul' => ['class' => []], 'li' => ['class' => []]]);
                } else {
                    avatar_user_register_display_thanks_message($avatar_user->first_name, $_GET['email'], $_GET['key']);
                }

?>
		</section>
	</main>
	</div>
</div>
<?php get_footer(); ?>