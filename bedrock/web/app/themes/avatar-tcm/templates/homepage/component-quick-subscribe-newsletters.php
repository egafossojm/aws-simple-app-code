<?php
/*
* Location : HomePage
* Quick subscribe newsletters Component
* Quick conditional form for newsletters subscription redirection
*/
?>
<div class="component component-quick-subscribe-newsletters sponsor-bg col-sm-6 col-md-12">
	<div class="row">
		<div class=" col-md-12">
			<p class="text-center">
				<span class="bold-text">
					<?php printf(_x('Every day, get the financial news that matters in your inbox.', 'Use variables for highlight the keywords', 'avatar-tcm'), '<span class="bold-text--color">', '</span>'); ?>
				</span>
			</p>
		</div>
		<?php if (is_user_logged_in()) { //logged in
		    $newsletters_page = get_field('acf_profile_newsletters', 'option'); ?>
			<div class="col-md-12" action="<?php echo avatar_get_current_url(); ?>" method="POST">
				<div class="text-center">
					<a href="<?php echo get_permalink($newsletters_page); ?>" class="btn btn-lg user-form__btn-submit no-border-radius component-quick-subscribe-newsletters__button">
						<?= get_locale() == 'fr_CA' ? 'Abonnez-vous' : 'Subscribe'; ?>
					</a>
				</div>
			</div>
		<?php } else { //not logged in
		    $signin_page = get_field('acf_page_signin_newsletters', 'option'); ?>
			<form class="col-md-12 text-center" action="<?php echo get_permalink($signin_page); ?>" method="POST">
				<div class="form-inline">
					<input value="" placeholder="<?php _e('Your email address', 'avatar-tcm'); ?>" type="email" id="email_input" name="email_input" class="form-control form-control--small-width form-control--sticky no-border-radius" aria-required="true" required>
					<input name="send_user_message" type="submit" class="btn btn-lg form-control user-form__btn-submit no-border-radius component-quick-subscribe-newsletters__button" value="<?= get_locale() == 'fr_CA' ? 'Abonnez-vous' : 'Subscribe'; ?>">
				</div>
			</form>
		<?php } ?>
	</div>
</div>