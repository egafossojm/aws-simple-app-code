<?php
/**
*Template Name: User : Login
**/
/* -------------------------------------------------------------
 * CHECK IF USER IS LOGGED IN
 * ============================================================*/

if (is_user_logged_in()) {
    $user_redirect_to = get_field('acf_page_after_login') ? get_page_link(get_field('acf_page_after_login')) : home_url();
    wp_redirect($user_redirect_to);
    exit;
}

/* -------------------------------------------------------------
 * Variables (forgot password)
 * ============================================================*/
// URL reset key
$resetkey = isset($_GET['resetkey']) ? esc_html($_GET['resetkey']) : '';

// URL user id
$user_id = isset($_GET['u']) ? esc_html($_GET['u']) : false;

// User
if ($user_id) {
    $user_object = get_user_by('id', $user_id);
    $user_email = $user_object->data->user_email;
}

// Form submited
$was_submited = isset($_POST['form_reset_password']) ? true : false;

settype($has_errors, 'bool');
$accepted_resetkey = false;

/* -------------------------------------------------------------
 * VERIFICATIONS - Create an object "$errors"  (forgot password)
 * ============================================================*/
if ($was_submited) {
    // Make sure there is a proper wp error obj. If not, make one
    if (! is_wp_error($errors)) {
        $errors = new WP_Error;
    }
    if (empty($_POST['user_pass']) || empty($_POST['user_pass2'])) {
        $errors->add('user_pass_field', __('Required fields are missing', 'avatar-tcm'));
    }
    if (! ($_POST['user_pass'] === $_POST['user_pass2'])) {
        $errors->add('user_passs', __('Passwords do not match', 'avatar-tcm'));
    }
    if (strlen($_POST['user_pass']) < 8) {
        $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
    }
    if (! preg_match('@[A-Z]@', $_POST['user_pass'])) {
        $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
    }
    if (! preg_match('@[a-z]@', $_POST['user_pass'])) {
        $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
    }
    if (! preg_match('@[0-9]@', $_POST['user_pass'])) {
        $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
    }

    // Validate email
    if (isset($user_login_email_forgot) && (! is_email($user_login_email_forgot) || email_exists($user_login_email_forgot || $user_login_email_forgot != ''))) {
        $errors->add('email_invalid', __('Email is invalid', 'avatar-tcm'));
    }

    // Validate the key
    if (get_user_meta($user_id, 'avatar_resetkey', true)) {
        $accepted_resetkey = $resetkey == get_user_meta($user_id, 'avatar_resetkey', true);
    } else {
        $errors->add('key_invalid', __('The key is not valid. Please try to log-in again.', 'avatar-tcm'));
    }

    // Variable
    if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
        $has_errors = true;
    }
}

/* -------------------------------------------------------------
 * UPDATE PASSWORD (forgot password)
 * ============================================================*/
// Apply modification
if ($accepted_resetkey && $was_submited && ! $has_errors) {
    // Delete user activation code
    delete_user_meta($user_id, 'avatar_resetkey');

    // Change Password
    wp_set_password($_POST['user_pass'], $user_id);

    // Redirect
    $redirect_link = add_query_arg(['pwdr' => 'ok'], get_permalink(get_field('acf_page_signin', 'option')));
    wp_redirect($redirect_link);
}

?>
<?php
if (! isset($errors)) {
    $errors = new WP_Error;
}
// If User subscribed and has click on the link from the confirmation email, User will be redirected on login page.
if (isset($_GET['u']) && isset($_GET['key'])) {

    // Test GET variables
    if (! is_int((int) $_GET['u'])) {
        $errors->add('user_id', __('Bad user ID', 'avatar-tcm'));

    } else {
        $avatar_user = get_user_by('ID', $_GET['u']);

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
            $errors->add('user_not_exist', __('User ID does not exist', 'avatar-tcm'));
        }
    }

    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {
        // Delete user activation code
        delete_user_meta($avatar_user->ID, 'avatar_activate_code');

        // Automatically log the user in and redirect User in his profile
        wp_set_current_user($avatar_user->ID, $avatar_user->user_email);
        wp_set_auth_cookie($avatar_user->ID);
        do_action('wp_login', $avatar_user->user_email);
        wp_redirect(get_permalink(get_field('acf_profile_newsletters', 'option')));
    }
}

if (isset($_POST['log']) && isset($_POST['pwd'])) {
    $avatar_user = false;
    $avatar_change_pass = false;
    $login_log = isset($_POST['log']) ? trim($_POST['log']) : '';
    $login_pass = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    $login_remember = isset($_POST['rememberme']) ? $_POST['rememberme'] : '';
    $login_redirect = isset($_POST['redirect_to']) ? esc_url($_POST['redirect_to']) : '';

    // Test if user and pass is not empty
    if (empty($login_log) || empty($login_pass)) {
        if (empty($login_log)) {
            $errors->add('user_log', __('The username email field is empty.', 'avatar-tcm'));
        }
        if (empty($login_pass)) {
            $errors->add('user_pass', __('The password field is empty.', 'avatar-tcm'));
        }
    } else {
        // We have the data, start step II
        // Test if username or email are OK and if they exist
        if (is_email($login_log)) {
            if (email_exists($login_log)) {
                $avatar_user = get_user_by('email', $login_log);
            } else {
                $errors->add('user_log', __('This email does not exist', 'avatar-tcm'));
            }
        } else {
            if (username_exists($login_log)) {
                $avatar_user = get_user_by('login', $login_log);
            } else {
                $errors->add('user_log', __('This username does not exist', 'avatar-tcm'));
            }
        }

        // Test if password is OK for current user
        if ($avatar_user) {

            $avatar_user_activation_key = get_user_meta($avatar_user->ID, 'avatar_activate_code', true);
            if ($avatar_user_activation_key) {
                $activation_link = add_query_arg(['key' => $avatar_user_activation_key, 'email' => $avatar_user->user_email], get_permalink(get_field('acf_page_resend', 'option')));
                wp_redirect($activation_link, 301);
                exit;
            }

            if (! wp_check_password($login_pass, $avatar_user->data->user_pass, $avatar_user->ID)) {
                $errors->add('user_pass', __('Wrong password', 'avatar-tcm'));
            }
        }
    }
    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {

        wp_set_current_user($avatar_user->ID);

        $user = wp_signon();

        if (! is_wp_error($user)) {

            // Test if current password respect new regles
            if (strlen($login_pass) < 8) {
                $avatar_change_pass = true;
            }
            if (! preg_match('@[A-Z]@', $login_pass)) {
                $avatar_change_pass = true;
            }
            if (! preg_match('@[a-z]@', $login_pass)) {
                $avatar_change_pass = true;
            }
            if (! preg_match('@[0-9]@', $login_pass)) {
                $avatar_change_pass = true;
            }
            if ($avatar_change_pass) {
                add_user_meta($avatar_user->ID, 'avatar_change_pass', '1', true);
            }
        }

        wp_redirect($login_redirect);

    } else {
        error_log('Validation Error for Log In');
    }
}
$_email = isset($_POST['email_input']) ? $_POST['email_input'] : (isset($_POST['log']) ? $_POST['log'] : '');
?>
<?php get_header(); ?>
	<?php if (have_posts()) {
	    while (have_posts()) {
	        the_post();
	        $register_page = get_field('acf_page_signup', 'option'); ?>
	<div class="wrap">
		<div id="primary" class="content-area">
			<main class="user-page">
				<?php
	                    // Display error mesages for activation account.
	                    if (isset($_GET['u']) && isset($_GET['key'])) {
	                        if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
	                            // Display errors
	                            $html_errors =
	                                    '<div class="panel error-box row"> <div class="panel-heading"> <div class="col-md-3">
										<span class="error-box__message">'.__('Activation failed!', 'avatar-tcm').'</span>
										 <div class="col-md-9">
										<span class="error-box__message error-box__message--small">'.__('Wrong URL', 'avatar-tcm').'</span>
												<ul class="error-box__list">';
	                            foreach ($errors->get_error_messages() as $key => $val) {
	                                $html_errors .= '<li class="error-box__item">'.$val.'</li>';
	                            }
	                            $html_errors .= '</ul></div></div></div></div>';
	                            echo wp_kses($html_errors, ['div' => ['class' => []], 'span' => ['class' => []], 'ul' => ['class' => []], 'li' => ['class' => []]]);
	                        }
	                    }
	        ?>

				<section class="sign-in-header row row--no-margin" style="background: url(<?php the_post_thumbnail_url(); ?> ); background-size: cover; background-repeat:no-repeat; background-position: center; ">
					<div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8  sign-in-box">
						<div class="tab-content ">
							<?php
	                    // Page Reset Password
	                    if (get_the_id() == get_field('acf_page_password_reset', 'option')->ID) {
	                        include locate_template('templates/user/form-reset-password.php');

	                        // Regular Login Page
	                    } else {
	                        include locate_template('templates/user/form-sign-in.php');
	                    }
	        ?>
						</div>
					</div>
				</section>
				<section class="row row--no-margin">
					<aside class="col-md-4 col-md-push-8">
						<div class="user-side-box user-side-box--sign-in">
							<p class="user-side-box__title user-side-box__title--small"><?php _e('No account yet?', 'avatar-tcm'); ?></p>
							<a href="<?php echo add_query_arg('email', $_email, get_permalink($register_page)); ?>" class="btn user-form__btn-submit"><?php _e('Create my account', 'avatar-tcm'); ?></a>
						</div>
						</aside>
					<div class="col-md-8 col-md-pull-4 col-no-padding-left">
						<?php the_content(); ?>
					</div>
				</section>
			</main>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
<?php get_footer(); ?>