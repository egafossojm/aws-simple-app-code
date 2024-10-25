<?php
/* -------------------------------------------------------------
 * RESET PASSWORD
 * ============================================================*/
?>
<div id="sign-in-container" class="tab-pane tab-pane-sign-in  active row row--no-margin" >
	<h1 class="sign-in-box__title"><?php the_title(); ?></h1>
	<?php $ref_url = get_field('acf_page_after_login') ? get_page_link(get_field('acf_page_after_login')) : get_page_link(get_field('acf_profile_information', 'option')); ?>

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

	<form name="loginform" id="loginform" class="sign-in-form" action="<?php echo avatar_get_current_url().'?'.$_SERVER['QUERY_STRING'] ?>" method="post">
		<p class="login-password">
			<label for="user_pass"><?php _e('Your new password', 'avatar-tcm'); ?></label>
			<input aria-required="true" required type="password" name="user_pass" id="user_pass" class="input" value="" size="20" />
		</p>
		<p class="login-password">
			<label for="user_pass"><?php _e('Confirm your new password', 'avatar-tcm'); ?></label>
			<input aria-required="true" required type="password" name="user_pass2" id="user_pass2" class="input" value="" size="20" />
		</p>
		<p class="login-submit">
			<input type="submit" name="wp-submit" id="wp-submit" class="button user-form__btn-submit--negative" value="<?php esc_attr_e('Change Password', 'avatar-tcm'); ?>" />
			<input type="hidden" name="redirect_to" value="<?php echo esc_url($ref_url); ?>" />
			<input type="hidden" name="form_reset_password" value="1" />
		</p>
	</form>
</div>