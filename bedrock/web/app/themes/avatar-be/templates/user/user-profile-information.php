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
			<span class="user-form__legend-title"><?php _e('Contact details', 'avatar-tcm'); ?></span>
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
			<label for="f_JobTitle" class="user-form__label"><?php _e('Job title', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_JobTitle']); ?>" type="text" id="f_JobTitle" name="f_JobTitle" class="form-control " aria-required="true" required>

			<label for="f_CompanyName" class="user-form__label"><?php _e('Company name', 'avatar-tcm'); ?></label>
			<input value="<?php echo isset($avatar_get_user_data_di['f_CompanyName']) ? $avatar_get_user_data_di['f_CompanyName'] : $avatar_get_user_data_di['f_CompanyName']; ?>" type="text" id="f_CompanyName" name="f_CompanyName" class="form-control " aria-required="true" required>

			<label for="f_Address1" class="user-form__label"><?php _e('Address', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Address1']); ?>" type="text" id="f_Address1" name="f_Address1" class="form-control " aria-required="false" >
			
			<label for="f_Address2" class="user-form__label"><?php _e('Unit Number', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_Address2']); ?>" type="text" id="f_Address2" name="f_Address2" class="form-control " aria-required="false" >

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
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_PostalCode']); ?>" type="text" id="f_PostalCode" name="f_PostalCode" class="form-control" aria-required="false" >


			<label for="f_TelephoneNumber" class="user-form__label"><?php _e('Telephone with area code', 'avatar-tcm'); ?></label>
			<input value="<?php echo esc_attr($avatar_get_user_data_di['f_TelephoneNumber']); ?>" type="text" id="f_TelephoneNumber" name="f_TelephoneNumber" class="form-control " aria-required="false" >


		</div>
	</fieldset>
	<!-- More Information -->
	<fieldset name="sign-up-informations" class="row">
		<legend class="user-form__legend col-md-3 col-sm-4">
			<span class="user-form__legend-title"><?php _e('Professional Information', 'avatar-tcm'); ?></span>
		</legend>
		<div class="user-form__inputs col-md-9 col-sm-8">
			<!-- Fields BECA-CIR: Professional information -->
			<div class="switch-box">
				<label for="last-name" class="user-form__label user-form__label-radio-boolean">
					<?php _e('Does your company offer a benefits plan?', 'avatar-tcm'); ?>
				</label>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Ben']) ? checked('Y', $avatar_get_user_data_di['f_PlanSponsor_Ben']) : ''; ?>  name="f_PlanSponsor_Ben" type="radio" data-toggle="collapse" data-target="#planSponsor-ben-yes:not(.in)" value="Y" aria-required="true" required   /><?php _e('Yes', 'avatar-tcm'); ?>
					</label>
				</div>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Ben']) ? checked('N', $avatar_get_user_data_di['f_PlanSponsor_Ben']) : ''; ?>  name="f_PlanSponsor_Ben" id="f_PlanSponsor_Ben" type="radio" data-toggle="collapse" data-target="#planSponsor-ben-yes.in" value="N"><?php _e('No', 'avatar-tcm'); ?>
					</label>
				</div>
			</div>
			
			<div id="planSponsor-ben-yes" class="panel-collapse collapse <?php echo esc_attr(($avatar_get_user_data_di['f_PlanSponsor_Ben'] === 'Y') ? 'in' : ''); ?>">
				<label for="last-name" class="user-form__label user-form__label-radio-boolean">
					<?php _e('Do you make decisions, manage, influence or design the benefits plan for your company?', 'avatar-tcm'); ?>
				</label>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_BenDecision']) ? checked('Y', $avatar_get_user_data_di['f_PlanSponsor_BenDecision']) : ''; ?>  name="f_PlanSponsor_BenDecision" id="f_PlanSponsor_BenDecision1" type="radio" value="Y" /><?php _e('Yes', 'avatar-tcm'); ?>
					</label>
				</div>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_BenDecision']) ? checked('N', $avatar_get_user_data_di['f_PlanSponsor_BenDecision']) : ''; ?>  name="f_PlanSponsor_BenDecision" id="f_PlanSponsor_BenDecision2" type="radio" value="N"><?php _e('No', 'avatar-tcm'); ?>
					</label>
				</div>
				<script>
				jQuery('#f_PlanSponsor_Ben').change(function () { jQuery("#f_PlanSponsor_BenDecision1").removeAttr("checked");jQuery("#f_PlanSponsor_BenDecision2").removeAttr("checked"); })
				</script>
			</div>
			
			<label for="last-name" class="user-form__label user-form__label-radio-boolean">
				<?php _e('Does your company offer a pension plan?', 'avatar-tcm'); ?>
			</label>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Pen']) ? checked('1', $avatar_get_user_data_di['f_PlanSponsor_Pen']) : ''; ?>  name="f_PlanSponsor_Pen" type="radio" data-toggle="collapse" data-target="#planSponsor-pen-yes:not(.in)" value="1" aria-required="true" required /><?php _e('Yes, a defined benefit plan (DB)', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Pen']) ? checked('2', $avatar_get_user_data_di['f_PlanSponsor_Pen']) : ''; ?>  name="f_PlanSponsor_Pen" type="radio" data-toggle="collapse" data-target="#planSponsor-pen-yes:not(.in)" value="2"><?php _e('Yes, a capital accumulation plan (DC, RRSP, TFSA)', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Pen']) ? checked('3', $avatar_get_user_data_di['f_PlanSponsor_Pen']) : ''; ?>  name="f_PlanSponsor_Pen" type="radio" data-toggle="collapse" data-target="#planSponsor-pen-yes:not(.in)" value="3"><?php _e('Yes, a hybrid or both DB and CAP', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Pen']) ? checked('4', $avatar_get_user_data_di['f_PlanSponsor_Pen']) : ''; ?>  name="f_PlanSponsor_Pen" class="f_PlanSponsor_Pen_off"  type="radio" data-toggle="collapse" data-target="#planSponsor-pen-yes.in" value="4"><?php _e('No', 'avatar-tcm'); ?>
				</label>
			</div>
			<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
				<label class="user-form__label-radio">
					<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_Pen']) ? checked('5', $avatar_get_user_data_di['f_PlanSponsor_Pen']) : ''; ?>  name="f_PlanSponsor_Pen" class="f_PlanSponsor_Pen_off" type="radio" data-toggle="collapse" data-target="#planSponsor-pen-yes.in" value="5"><?php _e('Unknown', 'avatar-tcm'); ?>
				</label>
			</div>
			
			<div id="planSponsor-pen-yes" class="panel-collapse collapse <?php echo esc_attr(($avatar_get_user_data_di['f_PlanSponsor_Pen'] === '1') || ($avatar_get_user_data_di['f_PlanSponsor_Pen'] === '2') || ($avatar_get_user_data_di['f_PlanSponsor_Pen'] === '3') ? 'in' : ''); ?>">
				<label for="last-name" class="user-form__label user-form__label-radio-boolean">
					<?php _e('Do you make decisions, manage, influence or design the pension plan for your company?', 'avatar-tcm'); ?>
				</label>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_PenDecision']) ? checked('Y', $avatar_get_user_data_di['f_PlanSponsor_PenDecision']) : ''; ?>  name="f_PlanSponsor_PenDecision" id="f_PlanSponsor_PenDecision1" type="radio" data-toggle="collapse" data-target="#licensed-yes" value="Y" /><?php _e('Yes', 'avatar-tcm'); ?>
					</label>
				</div>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php echo isset($avatar_get_user_data_di['f_PlanSponsor_PenDecision']) ? checked('N', $avatar_get_user_data_di['f_PlanSponsor_PenDecision']) : ''; ?>  name="f_PlanSponsor_PenDecision" id="f_PlanSponsor_PenDecision2" type="radio" data-toggle="collapse" data-target="#licensed-no" value="N"><?php _e('No', 'avatar-tcm'); ?>
					</label>
				</div>
				<script>
				jQuery('.f_PlanSponsor_Pen_off').change(function () { jQuery("#f_PlanSponsor_PenDecision1").removeAttr("checked");jQuery("#f_PlanSponsor_PenDecision2").removeAttr("checked"); })
				</script>
			</div>

			<label for="f_BEN_JobTitleChoice" class="user-form__label"><?php _e('Which of the following categories best describes your job title?', 'avatar-tcm'); ?></label>
			<select id="f_BEN_JobTitleChoice" name="f_BEN_JobTitleChoice" class="form-control">
				<option value=""></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '1'); ?>  value="1"><?php _e('Executive Management', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '2'); ?>  value="2"><?php _e('Benefits and Pension Management', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '3'); ?>  value="3"><?php _e('Human Resources', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '4'); ?>  value="4"><?php _e('Financial Management', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '10'); ?>  value="10"><?php _e('Benefits and/or Pension Consultant', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '11'); ?>  value="11"><?php _e('Insurance Advisor or Broker', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BEN_JobTitleChoice'], '99'); ?>  value="99"><?php _e('Other', 'avatar-tcm'); ?></option>
			</select>
			
			<label for="f_KR_EmployeesSize" class="user-form__label"><?php _e('Which of the following best represents your company\'s employee size (across all locations)?', 'avatar-tcm'); ?></label>
			<select id="f_KR_EmployeesSize" name="f_KR_EmployeesSize" class="form-control">
				<option value=""></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '1'); ?>  value="1"><?php _e('1 - 19', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '2'); ?>  value="2"><?php _e('20 - 49', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '3'); ?>  value="3"><?php _e('50 - 99', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '11'); ?>  value="11"><?php _e('Under 100 (new)', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '4'); ?>  value="4"><?php _e('100 - 199', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '5'); ?>  value="5"><?php _e('200 - 499', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '6'); ?>  value="6"><?php _e('500 - 999', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '7'); ?>  value="7"><?php _e('1000 - 1499', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '8'); ?>  value="8"><?php _e('1500 - 2499', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '9'); ?>  value="9"><?php _e('2500 +', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_KR_EmployeesSize'], '10'); ?>  value="10"><?php _e('Unknown', 'avatar-tcm'); ?></option>
			</select>
			
			<label for="f_BN_BusinessIndus2019" class="user-form__label"><?php _e('What industry do you work in?', 'avatar-tcm'); ?></label>
			<select id="f_BN_BusinessIndus2019" name="f_BN_BusinessIndus2019" class="form-control">
				<option value=""></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '1'); ?>  value="1"><?php _e('Agriculture/Forestry/Fishing/Hunting', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '2'); ?>  value="2"><?php _e('Architecture', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '3'); ?>  value="3"><?php _e('Arts/Entertainment', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '4'); ?>  value="4"><?php _e('Aviation/Aerospace', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '5'); ?>  value="5"><?php _e('Construction', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '6'); ?>  value="6"><?php _e('Education', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '7'); ?>  value="7"><?php _e('Engineering', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '8'); ?>  value="8"><?php _e('Environmental Services', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '9'); ?>  value="9"><?php _e('Finance', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '10'); ?>  value="10"><?php _e('Government/Public Administration', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '11'); ?>  value="11"><?php _e('Healthcare', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '12'); ?>  value="12"><?php _e('Human Resources', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '13'); ?>  value="13"><?php _e('Insurance', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '14'); ?>  value="14"><?php _e('Legal Services', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '15'); ?>  value="15"><?php _e('Manufacturing', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '16'); ?>  value="16"><?php _e('Marketing', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '17'); ?>  value="17"><?php _e('Media', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '18'); ?>  value="18"><?php _e('Mining/Oil/Gas/Energy', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '19'); ?>  value="19"><?php _e('Pharmaceutical/Medicine Manufacturing', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '20'); ?>  value="20"><?php _e('Professional Association/Organization', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '21'); ?>  value="21"><?php _e('Real Estate', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '22'); ?>  value="22"><?php _e('Recreation/Tourism', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '23'); ?>  value="23"><?php _e('Technology/Telecommunication', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '24'); ?>  value="24"><?php _e('Trade', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '25'); ?>  value="25"><?php _e('Transportation/Logistics', 'avatar-tcm'); ?></option>
				<option <?php selected($avatar_get_user_data_di['f_BN_BusinessIndus2019'], '99'); ?>  value="99"><?php _e('Other', 'avatar-tcm'); ?></option>
			</select>



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