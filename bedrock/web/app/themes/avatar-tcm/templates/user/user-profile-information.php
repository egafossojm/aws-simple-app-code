<?php // see page-user-profile.php?>
<!-- User profile tab -->
<span class="user-profile-content__title text-center"><?php echo esc_html($profile_information->post_title); ?></span>
<p class="user-profile-content__intro-text"><?php the_content(); ?></p>
<!--form-->
<?php if ($was_profile_updated) { ?>
	<div class="alert alert-success">
		<?php _e('Profile was updated successfully. Thank you!', 'avatar-tcm'); ?>
	</div>
<?php } ?>
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
            echo wp_kses($html_errors, [
                'div' => ['class' => []], 'span' => ['class' => []], 'ul' => ['class' => []], 'li' => ['class' => []]]);
        }
?>
	<fieldset name="log-in-information" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('Login information', 'avatar-tcm'); ?></span>
			<span class="user-form__legend-text">
				<?php _e('All fields are required', 'avatar-tcm'); ?>
				<br><br>
				<?php _e('Passwords must have at least 8 characters and contain at least one of the following: uppercase letters, lowercase letters and numbers.', 'avatar-tcm'); ?>
			</span>
		</legend>
		<div class="user-form__inputs col-md-9 col-sm-8">
			<label for="f_EMail" class="user-form__label"><?php _e('Your email', 'avatar-tcm'); ?></label>
			<input value="<?php echo isset($avatar_get_user_data_di['f_EMail']) ? $avatar_get_user_data_di['f_EMail'] : $avatar_get_user_data_di['work_email']; ?>" type="email" id="f_EMail" name="f_EMail" class="form-control" aria-required="true" required>
			<label class="user-form__label">
				<a data-toggle="collapse" data-target="#newPassword"><?php _e('Change Your Password', 'avatar-tcm'); ?></a>
			</label>
			<div id="newPassword" class="collapse <?php echo isset($errors->errors['user_passs']) ? 'in' : ''; ?>">
				<label for="user_pass" class="user-form__label"><?php _e('New password', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($avatar_get_user_data_di['user_pass']) ? $avatar_get_user_data_di['user_pass'] : ''; ?>" type="password" id="user_pass" name="user_pass" class="form-control" autocomplete="new-password">

				<label for="user_pass2" class="user-form__label"><?php _e('Repeat new password', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($avatar_get_user_data_di['user_pass2']) ? $avatar_get_user_data_di['user_pass2'] : ''; ?>" type="password" id="user_pass2" name="user_pass2" class="form-control" autocomplete="new-password">
			</div>
		</div>
	</fieldset>

	<!-- About you -->
	<fieldset name="sign-up-informations" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('About you', 'avatar-tcm'); ?></span>
			<span class="user-form__legend-text">
				<?php _e('All fields are required', 'avatar-tcm'); ?>
			</span>
		</legend>
		<div class="user-form__inputs col-md-9 col-sm-8">
			<div class="col-md-6 col-sm-6 col-no-padding-xs-left">
				<label for="f_FirstName" class="user-form__label"><?php _e('First name', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($avatar_get_user_data_di['f_FirstName']) ? $avatar_get_user_data_di['f_FirstName'] : $avatar_get_user_data_di['f_FirstName']; ?>" type="text" id="<?php echo 'f_FirstName'; ?>" name="f_FirstName" class="form-control " aria-required="true" required>
			</div>
			<div class="col-md-6 col-sm-6 col-no-padding-xs">
				<label for="f_LastName" class="user-form__label"><?php _e('Last name', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($avatar_get_user_data_di['f_LastName']) ? $avatar_get_user_data_di['f_LastName'] : $avatar_get_user_data_di['last_name']; ?>" type="text" id="f_LastName" name="f_LastName" class="form-control " aria-required="true" required>
			</div>
			<div class="col-md-6 col-sm-6 col-no-padding-xs">
				<label for="last-name" class="user-form__label user-form__label-radio-boolean">
					<?php _e('Gender', 'avatar-tcm'); ?>
				</label>
				<div class="radio user-form__radio user-form__radio-boolean">
					<label class="user-form__label-radio">
						<input <?php checked($avatar_get_user_data_di['f_Gender'], 'M'); ?> name="f_Gender" type="radio"  value="M"/><?php _e('Male', 'avatar-tcm'); ?>
					</label>
					<label class="user-form__label-radio">
						<input <?php checked($avatar_get_user_data_di['f_Gender'], 'F'); ?> name="f_Gender" type="radio"  value="F" /><?php _e('Female', 'avatar-tcm'); ?>
					</label>
				</div>
				<br>
			</div>
			<div class="col-md-6 col-sm-6 col-no-padding-xs">
				<label for="f_Birthdate_Year" class="user-form__label"><?php _e('Year of birth', 'avatar-tcm'); ?></label>
				<select id="f_Birthdate_Year" name="f_Birthdate_Year" class="form-control">
					<option value="0"></option>
					<?php
                   $star_year = 1913;
$end_year = date('Y', strtotime('-10 year'));

for ($i = $end_year; $i > $star_year; $i--) { ?>
					<option <?php selected($avatar_get_user_data_di['f_Birthdate_Year'], $i); ?> value="<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</fieldset>


	<!-- Professional Information -->
	<fieldset name="sign-up-informations" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('Professional Information', 'avatar-tcm'); ?></span>
			<span class="user-form__legend-text">
				<?php _e('Answer required', 'avatar-tcm'); ?>
			</span>
		</legend>
		<div class="user-form__inputs col-md-9 col-sm-8 user-form__inputs--radio">
			<label for="last-name" class="user-form__label user-form__label-radio-boolean">
				<?php _e('Are you licensed to sell financial products?', 'avatar-tcm'); ?>
			</label>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php checked(empty($product_sell_arr[0]), false); ?>  name="licensed_to_sell" type="radio" data-toggle="collapse" data-target="#licensed-yes" value="yes" aria-required="true" required="required" /><?php _e('Yes', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php checked(empty($role_in_firm_arr[0]), false); ?>  name="licensed_to_sell" type="radio" data-toggle="collapse" data-target="#licensed-no" value="no"><?php _e('No', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="accordion-group">
				<!--panel licensed yes-->

				<div id="licensed-yes" class="panel-collapse collapse collapse-radio  <?php echo empty($product_sell_arr[0]) ? '' : 'in'; ?>">
					<div class="panel user-form__panel">
						<div class="panel-heading">
							<span class="user-form__panel-title"><?php _e('Which products?', 'avatar-tcm'); ?></span>
							<?php //change for DI and POST?>
							<?php foreach (avatar_get_product_sell_arr() as $product_sell) { ?>

							<div class="checkbox user-form__checkbox">
								<label class="user-form__label-checkbox">
								<input type="checkbox" name="f_product_sell[]" value="<?php echo esc_attr($product_sell['value']); ?>" <?php (isset($product_sell['name'])) ? checked(in_array($product_sell['value'], $product_sell_arr), true) : 'checked'; ?>><?php echo esc_attr(_e($product_sell['name'], 'avatar-tcm')); ?>
								</label>
							</div>
							<?php } ?>

						</div>
					</div>
				</div>
				<!--panel licensed no-->
				<div id="licensed-no" class="panel-collapse collapse collapse-radio  <?php echo empty($role_in_firm_arr[0]) ? '' : 'in'; ?>">
					<div class="panel user-form__panel">
						<div class="panel-heading">
							<span class="user-form__panel-title"><?php _e('What is your main responsibility/role within your firm? (check every role that fits with your responsibilities)', 'avatar-tcm'); ?></span>
							<?php //change for DI and POST?>
							<?php foreach (avatar_get_role_in_firm_arr() as $role_in_firm) { ?>

								<div class="checkbox user-form__checkbox">
									<label class="user-form__label-checkbox">
										<input type="checkbox" name="f_role_in_firm[]" value="<?php echo esc_attr($role_in_firm['value']); ?>" <?php (isset($role_in_firm['name'])) ? checked(in_array($role_in_firm['value'], $role_in_firm_arr)) : ''; ?>><?php echo esc_attr(_e($role_in_firm['name'], 'avatar-tcm')); ?>
									</label>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div><!--end accordion group-->

			<label for="f_Title" class="user-form__label"><?php _e('Job title', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Title']); ?>" type="text" id="f_Title" name="f_Title" class="form-control " aria-required="true" required>

			<label for="f_Company" class="user-form__label"><?php _e('Company name', 'avatar-tcm'); ?></label>
			<input value="<?php echo isset($avatar_get_user_data_di['f_Company']) ? $avatar_get_user_data_di['f_Company'] : $avatar_get_user_data_di['f_Company']; ?>" type="text" id="f_Company" name="f_Company" class="form-control " aria-required="true" required>




			<label for="f_Years_Experience" class="user-form__label"><?php _e('Years of experience', 'avatar-tcm'); ?></label>
			<select id="f_Years_Experience" name="f_Years_Experience" class="form-control">
			<?php foreach (avatar_get_years_experience_arr() as $years_experience) { ?>
				<option <?php selected($avatar_get_user_data_di['f_Years_Experience'], $years_experience['value']); ?> value="<?php echo esc_attr($years_experience['value']); ?>"><?php echo esc_attr(_x($years_experience['name'], 'Feminin', 'avatar-tcm')); ?></option>
			<?php } ?>
			</select>


			<!-- Asset Under Management -->
			<label for="f_AssetUnderManagement" class="user-form__label">
				<?php _e('Assets under management', 'avatar-tcm'); ?>
			</label>
			<select id="f_AssetUnderManagement" name="f_AssetUnderManagement" class="form-control">
			<?php foreach (avatar_get_asset_under_management_arr() as $asset_under_management) { ?>
				<option <?php selected($avatar_get_user_data_di['f_AssetUnderManagement'], $asset_under_management['value']); ?> value="<?php echo esc_attr($asset_under_management['value']); ?>"><?php echo esc_attr(_x($asset_under_management['name'], 'Masculin', 'avatar-tcm')); ?></option>
			<?php } ?>
			</select>

			<label for="f_NumberOfFamiliesServed" class="user-form__label"><?php _e('Number of client households served', 'avatar-tcm'); ?></label>

			<select id="f_NumberOfFamiliesServed" name="f_NumberOfFamiliesServed" class="form-control">
			<?php foreach (avatar_get_number_families_served_arr() as $number_families_served) { ?>
				<option <?php selected($avatar_get_user_data_di['f_NumberOfFamiliesServed'], $number_families_served['value']); ?> value="<?php echo esc_attr($number_families_served['value']); ?>"><?php echo esc_attr(_x($number_families_served['name'], 'Masculin', 'avatar-tcm')); ?></option>
			<?php } ?>
			</select>

			<label for="f_BusinessAddress" class="user-form__label"><?php _e('Business address', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_BusinessAddress']); ?>" type="text" id="f_BusinessAddress" name="f_BusinessAddress" class="form-control " aria-required="false" >

			<label for="f_UnitNumber" class="user-form__label"><?php _e('Unit number', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_UnitNumber']); ?>" type="text" id="f_UnitNumber" name="f_UnitNumber" class="form-control " aria-required="false" >

			<label for="f_City" class="user-form__label"><?php _e('City', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_City']); ?>" type="text" id="f_City" name="f_City" class="form-control" aria-required="false" >


			<!-- Country -->
			<label for="f_Country" class="user-form__label"><?php _e('Country', 'avatar-tcm'); ?></label>
			<select id="f_Country" name="f_Country" class="form-control">
			<?php foreach (avatar_get_country_list_arr(get_bloginfo('language')) as $code => $name) { ?>
				<option <?php selected($avatar_get_user_data_di['f_Country'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
			<?php } ?>
			</select>

			<!-- State -->
			<div id="container_f_ProvinceState" class="collapse <?php echo ($avatar_get_user_data_di['f_Country'] == 'Canada' || $avatar_get_user_data_di['f_Country'] == 'United States') ? 'in' : '' ?> ">
				<label for="f_ProvinceState" class="user-form__label"><?php _e('Province', 'avatar-tcm'); ?></label>

				<select class="js_ProvinceState <?php echo ($avatar_get_user_data_di['f_Country'] == 'Canada') ? 'in' : '' ?> collapse  form-control f_ProvinceState_CA">
				<?php foreach (avatar_get_country_states('CA') as $code => $name) { ?>
					<option <?php selected($avatar_get_user_data_di['f_ProvinceState'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
				<?php } ?>
				</select>

				<select class="js_ProvinceState <?php echo ($avatar_get_user_data_di['f_Country'] == 'United States') ? 'in' : '' ?> collapse form-control f_ProvinceState_US">
				<?php foreach (avatar_get_country_states('US') as $code => $name) { ?>
					<option <?php selected($avatar_get_user_data_di['f_ProvinceState'], $name); ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
				<?php } ?>
				</select>
				 <input type="hidden" id="f_ProvinceState" name="f_ProvinceState" value="<?php echo esc_attr($avatar_get_user_data_di['f_ProvinceState']); ?>">
			</div>

			<label for="f_PostalCode" class="user-form__label"><?php _e('Postal code', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_PostalCode']); ?>" type="text" id="f_PostalCode" name="f_PostalCode" class="form-control" aria-required="false" >


			<label for="f_Telephone" class="user-form__label"><?php _e('Telephone with area code', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Telephone']); ?>" type="text" id="f_Telephone" name="f_Telephone" class="form-control " aria-required="false" >


		</div>
	</fieldset>
	<!-- More Information -->
	<fieldset name="sign-up-informations" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('More information', 'avatar-tcm'); ?></span>
		</legend>
		<div class="user-form__inputs col-md-9 col-sm-8">

            <?php $site_id = get_current_blog_id();
if ($site_id != 2) { ?>
			        <label for="f_CompletedCourses" class="user-form__label"><?php _e('Your designations / Completed courses', 'avatar-tcm'); ?></label>



			<?php foreach (avatar_get_prof_designations_arr() as $prof_designations) { ?>

				<div class="checkbox user-form__checkbox">
					<label class="user-form__label-checkbox">
						<input type="checkbox" name="f_CompletedCourses[]" value="<?php echo esc_attr($prof_designations['value']); ?>" <?php (isset($prof_designations['name'])) ? checked(in_array($prof_designations['value'], $prof_designations_arr)) : ''; ?>><?php echo esc_attr(_e($prof_designations['name'], 'avatar-tcm')); ?>
					</label>
				</div>
			<?php } ?>

            <?php } ?>



			<label for="f_ProfOrganizations" class="user-form__label"><?php _e('Professional organizations', 'avatar-tcm'); ?></label>

			<?php foreach (avatar_get_prof_organizations_arr() as $prof_organizations) { ?>

				<div class="checkbox user-form__checkbox">
					<label class="user-form__label-checkbox">
						<input type="checkbox" name="f_ProfOrganizations[]" value="<?php echo esc_attr($prof_organizations['value']); ?>" <?php (isset($prof_organizations['name'])) ? checked(in_array($prof_organizations['value'], $prof_organizations_arr)) : ''; ?>><?php echo esc_attr(_e($prof_organizations['name'], 'avatar-tcm')); ?>

					</label>
				</div>
			<?php } ?>

		</div>
	</fieldset>

	<br>
	<div name="sign-up-informations">
		<div class="row equal-col">
			<legend class="user-form__legend col-md-3 col-sm-4"></legend>
			<div class="col-md-9 col-sm-8 user-form__inputs--checkboxes">
				<input name="update_user_profile" type="submit" class="btn user-form__btn-submit" value="<?php esc_attr_e('Update my profile', 'avatar-tcm'); ?>">
			</div>
		</div>
	</div>
</form>