<div class="row">
<?php if ($was_newspaper_updated) { ?>
	<div class="alert alert-success">
		<?php _e('Profile was updated successfully. Thank you!', 'avatar-tcm'); ?>
	</div>
<?php } ?>
	<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
		<span class="user-profile-content__title"><?php the_title(); ?></span>
		<p class="user-profile-content__intro-text"><?php the_content(); ?></p>

		<?php if ($current_user->roles[0] == 'newspaper') { ?>
			<hr><p class="user-profile-content__title">
				<?php _e('You are subscribed to the newspaper. ', 'avatar-tcm'); ?>
			</p>
		<?php } ?>

	</div>
	<div class="col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
	<?php
        // Get the last Newspaper Date
        $newspaper_args = [
            'post_type' => 'newspaper',
            'post_status' => 'publish',
            'posts_per_page' => 1,
        ];
$newspaper_obj = new WP_Query($newspaper_args);
?>
	<?php if ($newspaper_obj->post_count) {
	    echo get_the_post_thumbnail($newspaper_obj->posts[0]->ID, 'thumbnail', ['class' => 'pull-right img-responsive cover']);
	} ?>
	</div>
</div>
<!--form-->
<form action="<?php echo esc_url(avatar_get_current_url()); ?>" method="POST" class="user-form">
	<!-- User Information -->
	<?php
	    // Check for wp error obj and see if it has any errors
	    if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
	        // Display errors
	        $html_errors =
	            '<div class="panel validation-box row">
					<div class="panel-heading">
						<div class="col-sm-4 col-md-3">
							<span class="validation-box__message">'.__('Form submission failed!', 'avatar-tcm').'</span>
						</div>
						<div class="col-sm-8 col-md-9">
							<span class="validation-box__message validation-box__message--small">'.__('Please verify these fields', 'avatar-tcm').'</span>
								<ul class="validation-box__list">';
	        foreach ($errors->get_error_messages() as $key => $val) {
	            $html_errors .= '<li class="validation-box__item">'.$val.'</li>';
	        }
	        $html_errors .= '</ul></div></div></div>';
	        echo wp_kses($html_errors, ['div' => ['class' => []], 'span' => ['class' => []], 'ul' => ['class' => []], 'li' => ['class' => []]]);
	    }
?>


	<!-- Professional Information -->
	<fieldset name="sign-up-informations" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('Delivery Information', 'avatar-tcm'); ?></span>
			<span class="user-form__legend-text">
				<?php _e('All fields are required', 'avatar-tcm'); ?>
			</span>
		</legend>
		<input type="hidden" id="f_EMail" name="f_EMail" value="<?php echo esc_attr($current_user->user_email); ?>">
		<div class="user-form__inputs col-md-9 col-sm-8 user-form__inputs--radio">
			<label for="f_Address1" class="user-form__label"><?php _e('Address', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Address1']); ?>" type="text" id="f_Address1" name="f_Address1" class="form-control" aria-required="true" required="required" >

			<label for="f_Address2" class="user-form__label"><?php _e('Unit number', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Address2']); ?>" type="text" id="f_Address2" name="f_Address2" class="form-control " aria-required="false" >

			<label for="f_City" class="user-form__label"><?php _e('City', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_City']); ?>" type="text" id="f_City" name="f_City" class="form-control" aria-required="true" required="required" >


			<!-- Country -->
			<label for="f_Country" class="user-form__label"><?php _e('Country', 'avatar-tcm'); ?></label>
			<select id="f_Country" name="f_Country" class="form-control" aria-required="true" required="required">
			<?php foreach (avatar_get_country_list_arr(get_bloginfo('language')) as $code => $name) { ?>
				<option <?php selected($avatar_get_user_data_di['f_Country'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
			<?php } ?>
			</select>

			<!-- State -->
			<div id="container_f_ProvinceState" class="collapse <?php echo ($avatar_get_user_data_di['f_Country'] == 'Canada' || $avatar_get_user_data_di['f_Country'] == 'United States') ? 'in' : '' ?> ">
				<label for="f_ProvinceState" class="user-form__label"><?php _e('Province', 'avatar-tcm'); ?></label>

				<select class="js_ProvinceState <?php echo ($avatar_get_user_data_di['f_Country'] == 'Canada') ? 'in' : '' ?> collapse  form-control f_ProvinceState_CA">
				<?php foreach (avatar_get_country_states('CA') as $code => $name) { ?>
					<option <?php selected($avatar_get_user_data_di['f_Province'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
				<?php } ?>
				</select>

				<select class="js_ProvinceState <?php echo ($avatar_get_user_data_di['f_Country'] == 'United States') ? 'in' : '' ?> collapse form-control f_ProvinceState_US">
				<?php foreach (avatar_get_country_states('US') as $code => $name) { ?>
					<option <?php selected($avatar_get_user_data_di['f_Province'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
				<?php } ?>
				</select>
				 <input type="hidden" id="f_ProvinceState" name="f_Province" value="<?php echo esc_attr($avatar_get_user_data_di['f_Province']); ?>">
			</div>

			<label for="f_PostalCode" class="user-form__label"><?php _e('Postal code', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_PostalCode']); ?>" type="text" id="f_PostalCode" name="f_PostalCode" class="form-control" aria-required="true" required="required" maxlength="12">


			<label for="f_TelephoneNumber" class="user-form__label"><?php _e('Telephone with area code', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_TelephoneNumber']); ?>" type="text" id="f_TelephoneNumber" name="f_TelephoneNumber" class="form-control" aria-required="true" required="required" >
		</div>
	</fieldset>
	<br>
	<div name="sign-up-informations">
		<div class="row equal-col">
			<legend class="user-form__legend col-md-3 col-sm-4"></legend>
			<div class="col-md-9 col-sm-8 user-form__inputs--checkboxes">
				<?php $btn_message = ($current_user->roles[0] == 'newspaper') ? __('Update delivery address', 'avatar-tcm') : __('Subscribe to Magazine', 'avatar-tcm'); ?>
				<input name="update_user_newspaper" type="submit" class="btn user-form__btn-submit" value="<?php echo esc_attr($btn_message); ?>">
			</div>
		</div>
	</div>
</form>