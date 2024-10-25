<!--LOG IN -->
<div id="sign-in-container" class="tab-pane tab-pane-sign-in  active row row--no-margin" >
	<h1 class="sign-in-box__title"><?php the_title(); ?></h1>
	<?php $ref_url = get_field('acf_page_after_login') ? get_page_link(get_field('acf_page_after_login')) : get_page_link(get_field('acf_profile_information', 'option')); ?>

	<?php if (isset($_GET['pwdr']) && $_GET['pwdr'] == 'ok') { ?>
		<span class="sign-in-box__validation-message sign-in-box__validation-message--success "><?php _e(' Your password has been updated!', 'avatar-tcm'); ?></span><br /><br />
	<?php } ?>
	<form name="loginform" id="loginform" class="sign-in-form" action="<?php echo avatar_get_current_url(); ?>" method="post">
		<p class="login-username">
			<label for="user_login"><?php _e('Email', 'avatar-tcm'); ?></label>
			<input aria-required="true" required type="email" name="log" id="user_login" class="input" value="<?php echo isset($_POST['log']) ? $_POST['log'] : (isset($_POST['email_input']) ? $_POST['email_input'] : ''); ?>" size="20" autofocus />
			<?php if (is_wp_error($errors) && array_key_exists('user_log', $errors->errors)) { ?>
				<?php foreach ($errors->errors['user_log'] as $key => $value) { ?>
					<span class="sign-in-box__validation-message"><?php echo esc_html($value); ?></span>
				<?php } ?>
			<?php } ?>
		</p>
		<p class="login-password">
			<label for="user_pass"><?php _e('Password', 'avatar-tcm'); ?></label>
			<input aria-required="true" required type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
			<?php if (is_wp_error($errors) && array_key_exists('user_pass', $errors->errors)) { ?>
				<?php foreach ($errors->errors['user_pass'] as $key => $value) { ?>
					<span class="sign-in-box__validation-message"><?php echo esc_html($value); ?></span>
				<?php } ?>
			<?php } ?>
		</p>
		<p class="login-remember">
			<div class="switch-box">
				<input name="rememberme" type="checkbox" id="rememberme" value="forever" />
				<label  for="rememberme">
					<div class="switch-box__button"></div>
					<span class="switch-box__text switch-box__text--lightest">
						<?php _e('Keep me logged in', 'avatar-tcm'); ?>
					</span>
				</label>
			</div>
		</p>
		<p class="login-submit login-submit-benefit">
			<input type="submit" name="wp-submit" id="wp-submit" class="button user-form__btn-submit user-form__btn-submit-benefit user-form__btn-log-in-left-benefit" style="font-size: 14px;" value="<?php esc_attr_e('Log In', 'avatar-tcm'); ?>" />
			<input type="hidden" name="redirect_to" value="<?php echo esc_url($ref_url); ?>" />
		
		
		
		<a href="<?php echo add_query_arg('email', $_email, get_permalink($register_page)); ?>" class="btn user-form__btn-submit user-form__btn-submit-benefit user-form__btn-create-account-benefit"><?php _e('Create a new account', 'avatar-tcm'); ?></a>
		</p>				
		<a id="trigger-form-forgot" href="#" class="tab-pane-sign-in__link text-right" style="padding-top:10px">
			<?php _e('Forgot password?', 'avatar-tcm'); ?>
			<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
		</a>
	</form>
</div>
<!-- Forgot Password -->
<div class="tab-pane tab-pane-sign-in row row--no-margin" id="forgot-password-container">
	<?php include locate_template('templates/user/form-forget-password.php'); ?>
</div>