<?php
/**
*Template Name: User : Sign in
**/
?>
<?php
if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_field('acf_profile_newsletters', 'option')));
    //return;
}
if (! isset($errors)) {
    $errors = new WP_Error;
}
// If User subscribed and has click on the link from the confirmation email, User will be redirected on login page
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
            $errors->add('user_not_exist', __('User ID do not exist', 'avatar-tcm'));
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
} else {
    $errors->add('user_id_key_not_exist', __('User ID or Key do not exist', 'avatar-tcm'));
}
?>
<?php get_header(); ?>
<?php if (have_posts()) {
    while (have_posts()) {
        the_post(); ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main class="user-page">
			<section class="sign-in-header row row--no-margin" style="background: url(<?php the_post_thumbnail_url(); ?> ); background-size: cover; background-repeat:no-repeat; ">
				<div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8  sign-in-box">
					<h1 class="sign-in-box__title"><?php the_title(); ?></h1>
					<?php
                              $args = [
                                  'redirect' => '/profil',
                                  'form_id' => 'loginform',
                                  'label_username' => __('Your email', 'avatar-tcm'),
                                  'label_password' => __('Your password', 'avatar-tcm'),
                                  'label_remember' => __('Remember me', 'avatar-tcm'),
                                  'label_log_in' => __('Log In', 'avatar-tcm'),
                                  'remember' => true,
                              ];
        wp_login_form($args);
        ?>
				</div>
			</section>
			<section class="row row--no-margin">
				<aside class="col-md-4 col-md-push-8">
					<div class="user-side-box user-side-box--sign-in">
						<p class="user-side-box__title user-side-box__title--small"><?php _e('No account yet?', 'avatar-tcm'); ?></p>
						<a href="/register" class="btn user-form__btn-submit"><?php _e('Create my account', 'avatar-tcm'); ?></a>
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
<?php wp_reset_postdata(); ?>
<?php } else { ?>
<p><?php _e('Sorry, no posts matched your criteria.', 'avatar-tcm'); ?></p>
<?php } ?>
<?php get_footer(); ?>