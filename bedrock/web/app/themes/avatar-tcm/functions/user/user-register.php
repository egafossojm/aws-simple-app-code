<?php
/**
 *  User Register functions
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
?>
<?php
function avatar_try_user_register(&$fields, &$errors)
{
    // Check args and replace if necessary
    if (! is_array($fields)) {
        $fields = [];
    }

    if (! is_wp_error($errors)) {
        $errors = new WP_Error;
    }

    // Check for form submit
    if (isset($_POST['new_user'])) {
        // Get fields from submitted form
        $fields = avatar_user_register_get_fields();

        avatar_user_register_sanitize($fields);

        // Validate fields and produce errors
        if (avatar_user_register_validate($fields, $errors)) {

            //Send to DI
            $send_to_di = avatar_create_user_di($fields, 'Insert');

            if ($send_to_di) {

                $wp_arr = avatar_user_arr_for_wp($fields);

                $user_id = wp_insert_user($wp_arr);

                // The meta.
                $blog_id = get_current_blog_id();
                if ($fields['is_newspaper'] || $fields['is_display_newspaper']) {
                    $meta = ['add_to_blog' => $blog_id, 'new_role' => 'newspaper'];
                    // AVAIE-1400
                    if ($user_id) {
                        $user_obj = get_user_by('id', $user_id);
                        $avatar_get_user_data_di = avatar_get_user_info_di($user_obj->user_email);
                        $avatar_get_user_data_di = (array) $avatar_get_user_data_di;
                        $send_to = get_field('acf_profile_update_email', 'option');
                        if ($send_to) {
                            avatar_send_email($send_to, sprintf(__('%s new subscription', 'avatar-tcm'), get_bloginfo('name')), avatarie_update_profile_ie_email_body($avatar_get_user_data_di));
                        }
                    }
                } else {
                    $meta = ['add_to_blog' => $blog_id, 'new_role' => 'subscriber'];
                }

                // Add user to all blogs
                $blog_list = get_sites();
                foreach ($blog_list as $key => $blog) {
                    if ($blog->blog_id == $blog_id) {
                        // Add new user to site (blog)
                        $result = add_new_user_to_blog($user_id, null, $meta);
                    } else {
                        $result = add_user_to_blog($blog->blog_id, $user_id, 'subscriber');
                    }
                }

                if ($user_id && ! is_wp_error($user_id)) {
                    wp_set_current_user($user_id, $wp_arr['user_email']);
                    wp_set_auth_cookie($user_id);
                    do_action('wp_login', $wp_arr['user_email']);

                    $email_subject = __('Newsletter subscription confirmed', 'avatar-tcm');
                    $code = sha1($user_id.current_time('timestamp'));
                    $activation_link = add_query_arg(['key' => $code, 'u' => $user_id], get_permalink(get_field('acf_page_signin', 'option')));
                    //add_user_meta( $user_id, 'avatar_activate_code', $code, true );
                    add_user_meta($user_id, AVATAR_DIALOG_INSIGHT_BD_ID, $send_to_di, true);
                    add_user_meta($user_id, 'acf_user_uid_advisor_central', avatar_uuid_v4(), true);
                    $site_main_color = get_theme_mod('primary_color');

                    $site_email = get_field('acf_profile_register_email', 'options');
                    $title_content = __('Create your account', 'avatar-tcm'); // [1] title
                    $site_url = get_site_url();
                    $site_id = get_current_blog_id();
                    switch ($site_id) {
                        case 2:
                            $newsletter_email = 'newsletter@tc.financeetinvestissement.com';
                            $team_name = "L'équipe <i>Finance et Investissement</i>";
                            $privaty_policy_link = 'https://tctranscontinental.com/fr/politique-sur-la-vie-privee';
                            break;
                        case 3:
                            $newsletter_email = 'newsletter@tc.investmentexecutive.com';
                            $team_name = '<i>The Investment Executive</i> Team';
                            $privaty_policy_link = 'https://tctranscontinental.com/privacy-policy';
                            break;
                    }

                    $text_content = '
						<style>.preheader{display: none !important;mso-hide:all;visibility:hidden;mso-hide:all;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;}</style>
						<span class="preheader" style="display: none !important; mso-hide:all; visibility:hidden;">'.__('You are being sent this e-mail as a valued subscriber of', 'avatar-tcm').get_bloginfo().'.</span>
						<span class="x_title" style="font-size:17px; color:#222; font-weight:700"><strong>'.$wp_arr['first_name'].',</strong></span><br><br>
                        <span>'.__('Welcome and thank you for joining the', 'avatar-tcm').' <i>'.get_bloginfo().'.</i> '.__('community. You are now subscribed to the country’s foremost news source for financial industry professionals.', 'avatar-tcm').'</span><br><br>
                        <span>'.__('You’ll receive news and analysis concerning industry updates, investments, estate planning, compliance and everything in between. To ensure our newsletters are delivered directly to your inbox, add', 'avatar-tcm').' <strong><a>'.$newsletter_email.'</a></strong> '.__('to your Address Book, Safe Sender or White List.', 'avatar-tcm').'</span><br><br>
                        <span>'.__('Your subscription will activate within 24 hours. In the meantime, visit', 'avatar-tcm').' <a href="'.$site_url.'" target="_blank"><i>'.get_bloginfo().'</i></a> '.__('for the latest stories.', 'avatar-tcm').'</span><br><br>
                        <span>'.__('Sincerely,', 'avatar-tcm').'</span><br>
                        <span>'.$team_name.'</span><br><br>'.
                        '<span style="font-size:11px; "><span>'.__('This is a one-time administration email confirmation sent to', 'avatar-tcm').' <a href="mailto:'.$wp_arr['user_email'].'">'.$wp_arr['user_email'].'</a>. '.__('Your name and address information including email address will be used to correspond with you regarding your newsletter subscription and to send you other relevant information. You may withdraw your consent at any time by managing your preferences', 'avatar-tcm').' <a href="'.esc_url(get_permalink(get_field('acf_page_signin', 'option'))).'" target="_blank" rel="noopener noreferrer">'.__('here', 'avatar-tcm').'</a>. '.__('Please view our full', 'avatar-tcm').' <a href="'.esc_url($privaty_policy_link).'">'.__('Privacy Policy', 'avatar-tcm').'</a> '.__('for more details.', 'avatar-tcm').'</a><br>';
                    $text_content .= '</span>';
                    // Send Email to user
                    $body_message = avatar_template_email_system(['title' => $title_content, 'content' => $text_content, 'emailto' => $wp_arr['user_email']]);
                    //avatar_new_user_email_html ( $wp_arr['first_name'], $activation_link );

                    avatar_send_email($wp_arr['user_email'], $email_subject, $body_message);

                    $fields = [];

                    // And display a message
                    return avatar_get_user_register_display_thanks_message($wp_arr['first_name'], $wp_arr['user_email'], $code);
                } else {
                    $errors->add('user_register_failed', __('Exception error register general user failed. Please contact your administrator', 'avatar-tcm'));
                }
            } else {
                $errors->add('user_register_failed', __('Exception error register general user failed. Please contact your DI administrator', 'avatar-tcm'));
            }

            // Clear field data
            $fields = [];

            return 'user_register_failed';
        }
    }

    return 'BADFIELD';
}

function avatar_user_register(&$fields, &$errors)
{
    $result = avatar_try_user_register($fields, $errors);
    switch ($result) {
        case 'BADFIELD':
            // Generate form
            avatar_user_register_display_form($fields, $errors);
            break;
        default:
            echo $result;
            break;
    }
}

function avatar_user_register_sanitize(&$fields)
{
    $fields['f_lastQualificationdate'] = date('Y-m-d H:i:s +0000');
    $fields['user_login'] = sanitize_user(strtotime('now').'avt'.wp_rand(1, 99999));
    $fields['user_pass'] = isset($fields['user_pass']) ? sanitize_text_field(trim($fields['user_pass'])) : '';
    $fields['user_pass2'] = isset($fields['user_pass2']) ? sanitize_text_field(trim($fields['user_pass2'])) : '';
    $fields['f_EMail'] = isset($fields['f_EMail']) ? sanitize_email($fields['f_EMail']) : '';
    $fields['f_Gender'] = isset($fields['f_Gender']) ? sanitize_text_field($fields['f_Gender']) : '';
    $fields['f_FirstName'] = isset($fields['f_FirstName']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_FirstName'], [])))) : '';
    $fields['f_LastName'] = isset($fields['f_LastName']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_LastName'], [])))) : '';
    $fields['f_Company'] = isset($fields['f_Company']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_Company'], [])))) : '';
    //newspaper
    $fields['is_newspaper'] = isset($fields['is_newspaper']) ? (bool) $fields['is_newspaper'] : false;
    $fields['f_BusinessAddress'] = isset($fields['f_BusinessAddress']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_BusinessAddress'], [])))) : '';
    $fields['f_UnitNumber'] = isset($fields['f_UnitNumber']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_UnitNumber'], [])))) : '';
    $fields['f_City'] = isset($fields['f_City']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_City'], [])))) : '';
    $fields['f_Country'] = isset($fields['f_Country']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_Country'], [])))) : '';
    $fields['f_ProvinceState'] = isset($fields['f_ProvinceState']) ? sanitize_text_field(trim(wp_kses($fields['f_ProvinceState'], []))) : '';
    $fields['f_PostalCode'] = isset($fields['f_PostalCode']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_PostalCode'], [])))) : '';
    $fields['f_Telephone'] = isset($fields['f_Telephone']) ? sanitize_text_field(trim(stripslashes_deep(wp_kses($fields['f_Telephone'], [])))) : '';
    $fields['f_Source'] = 'Avatar';
    $fields['licensed_to_sell'] = isset($fields['licensed_to_sell']) ? sanitize_text_field($fields['licensed_to_sell']) : '';
    $fields['f_product_sell'] = isset($fields['product_sell']) ? $fields['product_sell'] : [];
    $fields['f_role_in_firm'] = isset($fields['role_in_firm']) ? $fields['role_in_firm'] : [];
    $fields['optin_OptInPartnerIE'] = (isset($fields['optin_OptInPartnerIE']) && ($fields['optin_OptInPartnerIE'] == true)) ? true : false;
    $fields['optin_IE_Offers'] = (isset($fields['optin_IE_Offers']) && ($fields['optin_IE_Offers'] == true)) ? true : false;
    $fields['optin_Optin_Transcontinental'] = (isset($fields['optin_Optin_Transcontinental']) && ($fields['optin_Optin_Transcontinental'] == true)) ? true : false;
    $fields['optin_special'] = (isset($fields['optin_special']) && ($fields['optin_special'] == true)) ? true : false;
}

function avatar_user_register_display_form($fields = [], $errors = null)
{

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

    // Disaply form
    ?>
<!-- form start  -->
	<form action="<?php echo avatar_get_current_url(); ?>" method="POST">
		<!-- User Information -->
		<fieldset name="sign-up-informations" class="row">
			<legend class="user-form__legend col-md-3 col-sm-4">
				<span class="user-form__legend-title"><?php _e('Sign-up information', 'avatar-tcm'); ?></span>
				<span class="user-form__legend-text">
					<?php _e('All fields are required', 'avatar-tcm'); ?>
					<br><br>
					<?php _e('Passwords must have at least 8 characters and contain at least one of the following: uppercase letters, lowercase letters and numbers.', 'avatar-tcm'); ?>
				</span>
			</legend>
			<div class="user-form__inputs col-md-7 col-sm-6">
				<?php //set email
                      $email_input_get = isset($_GET['email']) ? $_GET['email'] : '';
    $email_input_post = isset($fields['f_EMail']) ? $fields['f_EMail'] : '';
    $email_input = $email_input_post ? $email_input_post : $email_input_get
    ?>
				<label for="f_EMail" class="user-form__label"><?php _e('Your email', 'avatar-tcm'); ?></label>
				<input value="<?php echo esc_attr($email_input); ?>" type="email" id="f_EMail" name="f_EMail" class="form-control" aria-required="true" required>

				<label for="user_pass" class="user-form__label"><?php _e('Create your password', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($fields['user_pass']) ? $fields['user_pass'] : ''; ?>" type="password" id="user_pass" name="user_pass" class="form-control " aria-required="true" required>

				<label for="user_pass2" class="user-form__label"><?php _e('Repeat your password', 'avatar-tcm'); ?></label>
				<input value="<?php echo isset($fields['user_pass2']) ? $fields['user_pass2'] : ''; ?>" type="password" id="user_pass2" name="user_pass2" class="form-control " aria-required="true" required>
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
			<div class="user-form__inputs col-md-7 col-sm-6">
				<div class="col-md-6 col-sm-6 col-no-padding-xs-left">
					<label for="f_FirstName" class="user-form__label"><?php _e('First name', 'avatar-tcm'); ?></label>
					<input value="<?php echo isset($fields['f_FirstName']) ? $fields['f_FirstName'] : ''; ?>" type="text" id="f_FirstName" name="f_FirstName" class="form-control " aria-required="true" required>
				</div>

				<div class="col-md-6 col-sm-6 col-no-padding-xs">
					<label for="f_LastName" class="user-form__label"><?php _e('Last name', 'avatar-tcm'); ?></label>
					<input value="<?php echo isset($fields['f_LastName']) ? $fields['f_LastName'] : ''; ?>" type="text" id="f_LastName" name="f_LastName" class="form-control " aria-required="true" required>
				</div>
				<div class="col-md-6 col-sm-6 col-no-padding-xs">
					<label for="last-name" class="user-form__label user-form__label-radio-boolean">
						<?php _e('Gender', 'avatar-tcm'); ?>
					</label>
					<div class="radio user-form__radio user-form__radio-boolean">
						<label class="user-form__label-radio">
							<input <?php if (isset($avatar_get_user_data_di['f_Gender'])) {
							    checked($avatar_get_user_data_di['f_Gender'], 'M');
							} ?> name="f_Gender" type="radio"  value="M"/><?php _e('Male', 'avatar-tcm'); ?>
						</label>
						<label class="user-form__label-radio">
							<input <?php if (isset($avatar_get_user_data_di['f_Gender'])) {
							    checked($avatar_get_user_data_di['f_Gender'], 'F');
							} ?> name="f_Gender" type="radio"  value="F" /><?php _e('Female', 'avatar-tcm'); ?>
						</label>
					</div>
					<br>
				</div>
				<div class="col-md-6 col-sm-6 col-no-padding-xs">
					<label for="f_Company" class="user-form__label"><?php _e('Company name', 'avatar-tcm'); ?></label>
					<input value="<?php echo isset($fields['f_Company']) ? $fields['f_Company'] : ''; ?>" type="text" id="f_Company" name="f_Company" class="form-control " aria-required="true" required>
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
						<input  <?php echo isset($fields['licensed_to_sell']) ? checked('yes', $fields['licensed_to_sell'], false) : 'checked'; ?>  name="licensed_to_sell" type="radio" data-toggle="collapse" data-target="#licensed-yes" value="yes" aria-required="true" required /><?php _e('Yes', 'avatar-tcm'); ?>
					</label>
				</div>
				<div class="radio user-form__radio user-form__radio-boolean user-form__radio-boolean-js">
					<label class="user-form__label-radio">
						<input  <?php isset($fields['licensed_to_sell']) ? checked('no', $fields['licensed_to_sell']) : ''; ?>  name="licensed_to_sell" type="radio" data-toggle="collapse" data-target="#licensed-no" value="no"><?php _e('No', 'avatar-tcm'); ?>
					</label>
				</div>
				<div class="accordion-group">
					<!--panel licensed yes-->
					<div id="licensed-yes" class="panel-collapse collapse collapse-radio <?php echo isset($fields['licensed_to_sell']) ? ($fields['licensed_to_sell'] == 'yes') ? 'in' : '' : 'in'; ?>">
						<div class="panel user-form__panel">
							<div class="panel-heading">
								<span class="user-form__panel-title"><?php _e('Which products?', 'avatar-tcm'); ?></span>

								<?php foreach (avatar_get_product_sell_arr() as $product_sell) { ?>

								<div class="checkbox user-form__checkbox">
									<label class="user-form__label-checkbox">
										<input type="checkbox" name="product_sell[]" value="<?php echo esc_attr($product_sell['value']); ?>" <?php (isset($fields['product_sell'])) ? checked(in_array($product_sell['value'], $fields['product_sell'])) : ''; ?>><?php echo esc_attr(_e($product_sell['name'], 'avatar-tcm')); ?>
									</label>
								</div>
								<?php } ?>

							</div>
						</div>
					</div>
					<!--panel licensed no-->
					<div id="licensed-no" class="panel-collapse collapse collapse-radio  <?php echo isset($fields['licensed_to_sell']) ? ($fields['licensed_to_sell'] == 'no') ? 'in' : '' : ''; ?>">
						<div class="panel user-form__panel">
							<div class="panel-heading">
								<span class="user-form__panel-title"><?php _e('What is your main responsibility/role within your firm? (check every role that fits with your responsibilities)', 'avatar-tcm'); ?></span>

								<?php foreach (avatar_get_role_in_firm_arr() as $role_in_firm) { ?>

								<div class="checkbox user-form__checkbox">
									<label class="user-form__label-checkbox">
										<input type="checkbox" name="role_in_firm[]" value="<?php echo esc_attr($role_in_firm['value']); ?>" <?php (isset($fields['role_in_firm'])) ? checked(in_array($role_in_firm['value'], $fields['role_in_firm'])) : ''; ?>><?php echo esc_attr(_e($role_in_firm['name'], 'avatar-tcm')); ?>
									</label>
								</div>
								<?php } ?>

							</div>
						</div>
					</div>
				</div><!-- end accordion group -->
			</div>
		</fieldset>

		<?php
            /* -------------------------------------------------------------
             * Display Newspaper fieldset
             * ============================================================*/
            $display_newspaper = false;
    $is_display_newspaper = false;

    if (avatar_is_refer_newspaper() || (isset($fields['is_newspaper']) && $fields['is_newspaper'] == true)) {
        $display_newspaper = true;
    }
    ?>

		<?php if (avatar_is_refer_newspaper() || (isset($fields['is_display_newspaper']) && $fields['is_display_newspaper'] == true)) { ?>
			<?php $is_display_newspaper = true; ?>
			<input type="hidden" name="is_display_newspaper" id="js_is_display_newspaper" value="true">
		<?php } ?>

	<?php if (! $is_display_newspaper) { // hide on newspaper?>
		<!-- More Options -->
		<fieldset name="sign-up-informations" class="row">
			<legend class="user-form__legend col-md-3 col-sm-4">
				<span class="user-form__legend-title"><?php _e('More options', 'avatar-tcm'); ?></span>
				<span class="user-form__legend-text">
				<?php _e('Optional', 'avatar-tcm'); ?>
				</span>
			</legend>
			<div class="user-form__inputs col-md-9 col-sm-8 user-form__inputs--checkboxes">
			<?php if (have_rows('acf_opt_in', 'option')) { ?>
				<?php
                // loop through the rows of data
                while (have_rows('acf_opt_in', 'option')) {
                    the_row();
                    // get sub field values
                    $opt_in_id = esc_attr(get_sub_field('acf_opt_in_id'));
                    $opt_in_description = esc_html(get_sub_field('acf_opt_in_description'));
                    ?>
				<div class="switch-box">
					<input <?php isset($fields[$opt_in_id]) ? checked($fields[$opt_in_id], true) : ''; ?> type="checkbox" id="<?php echo esc_attr($opt_in_id); ?>" name="<?php echo esc_attr($opt_in_id); ?>" value="true">
					<label for="<?php echo esc_attr($opt_in_id); ?>">
						<div class="switch-box__button"></div>
						<span class="switch-box__text"><?php echo wp_kses_post($opt_in_description); ?></span>
					</label>
				</div>
				<?php } ?>
			<?php } ?>
			</div>
		</fieldset>
	<?php } ?>


		<fieldset name="sign-up-informations" class="row">
			<legend class="user-form__legend col-md-3 col-sm-4">
				<span class="user-form__legend-title"><?php _e('Newspaper subscription', 'avatar-tcm'); ?></span>
				<?php if ($is_display_newspaper) { ?>
					<span class="user-form__legend-text"><?php _e('All fields are required', 'avatar-tcm'); ?></span>
				<?php } else { ?>
					<span class="user-form__legend-text"><?php _e('Optional', 'avatar-tcm'); ?></span>
				<?php } ?>
			</legend>
			<div class="user-form__inputs col-md-7 col-sm-6">
			<?php if (! $is_display_newspaper) { // hide on newspaper?>
				<div class="switch-box">
					<input type="checkbox" id="newspaper-yes-input" name="is_newspaper" <?php checked($display_newspaper, true); ?>>
					<label for="newspaper-yes-input" data-toggle="collapse" data-target="#newspaper-yes" >
						<div class="switch-box__button" value="yes" aria-required="true"  /></div>
						<span class="switch-box__text"><?php _e('Yes I would like to subscribe to the newspaper', 'avatar-tcm'); ?></span>
					</label>
				</div>
			<?php } ?>
				<div id="newspaper-yes" class="panel-collapse collapse <?php echo esc_attr(($display_newspaper || $is_display_newspaper) ? 'in' : ''); ?>">
					<div class="accordion-group">
						<label for="f_BusinessAddress" class="user-form__label"><?php _e('Business address', 'avatar-tcm'); ?></label>
						<input value="<?php echo isset($fields['f_BusinessAddress']) ? $fields['f_BusinessAddress'] : ''; ?>" type="text" id="f_BusinessAddress" name="f_BusinessAddress" class="form-control" aria-required="true" >

						<label for="f_UnitNumber" class="user-form__label"><?php _e('Unit number', 'avatar-tcm'); ?></label>
						<input value="<?php echo isset($fields['f_UnitNumber']); ?>" type="text" id="f_UnitNumber" name="f_UnitNumber" class="form-control " aria-required="false" >

						<label for="f_City" class="user-form__label"><?php _e('City', 'avatar-tcm'); ?></label>
						<input value="<?php echo isset($fields['f_City']) ? $fields['f_City'] : ''; ?>" type="text" id="f_City" name="f_City" class="form-control" aria-required="true">
						<!-- Country -->
						<label for="f_Country" class="user-form__label"><?php _e('Country', 'avatar-tcm'); ?></label>
						<select id="f_Country" name="f_Country" class="form-control" aria-required="true">
							<?php foreach (avatar_get_country_list_arr(get_bloginfo('language')) as $code => $name) { ?>
								<option <?php isset($fields['f_Country']) ? (selected($fields['f_Country'], $name)) : ''; ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
							<?php } ?>
						</select>
						<!-- State -->
						<div id="container_f_ProvinceState" class="collapse <?php echo isset($fields['f_Country']) ? (($fields['f_Country'] == 'Canada' || $fields['f_Country'] == 'United States') ? 'in' : '') : '' ?> ">
							<label for="f_ProvinceState" class="user-form__label"><?php _e('Province', 'avatar-tcm'); ?></label>
							<select class="js_ProvinceState <?php echo isset($fields['f_Country']) ? ($fields['f_Country'] == 'Canada') ? 'in' : '' : ''; ?> collapse  form-control f_ProvinceState_CA" aria-required="true" >
								<?php foreach (avatar_get_country_states('CA') as $code => $name) { ?>
									<option <?php isset($fields['f_ProvinceState']) ? (selected($fields['f_ProvinceState'], $name)) : ''; ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
								<?php } ?>
							</select>
							<select class="js_ProvinceState <?php echo isset($fields['f_Country']) ? ($fields['f_Country'] == 'United States') ? 'in' : '' : ''; ?> collapse form-control f_ProvinceState_US" aria-required="true" >
								<?php foreach (avatar_get_country_states('US') as $code => $name) { ?>
									<option <?php isset($fields['f_ProvinceState']) ? (selected($fields['f_ProvinceState'], $name)) : ''; ?>  value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
								<?php } ?>
							</select>
							<input type="hidden" id="f_ProvinceState" name="f_ProvinceState" value="<?php echo isset($fields['f_ProvinceState']) ? esc_attr($fields['f_ProvinceState']) : ''; ?>">
						</div>
						<label for="f_PostalCode" class="user-form__label"><?php _e('Postal code', 'avatar-tcm'); ?></label>
						<input value="<?php echo isset($fields['f_PostalCode']) ? $fields['f_PostalCode'] : ''; ?>" type="text" id="f_PostalCode" name="f_PostalCode" class="form-control" aria-required="true">
						<label for="f_Telephone" class="user-form__label"><?php _e('Telephone with area code', 'avatar-tcm'); ?></label>
						<input value="<?php echo isset($fields['f_Telephone']) ? $fields['f_Telephone'] : ''; ?>" type="text" id="f_Telephone" name="f_Telephone" class="form-control " aria-required="true">
					</div>
				</div>
			</div>
		</fieldset>
		<!-- Submit -->
		<div name="sign-up-informations">
			<div class="row equal-col">
				<legend class="user-form__legend col-md-3 col-sm-4"></legend>
				<div class="col-md-9 col-sm-8 user-form__inputs--checkboxes">
					<div class="g-recaptcha register-recaptcha" data-sitekey="<?php echo esc_attr(get_field('acf_recaptcha_site_key', 'options')); ?>" required></div><br>
					<input name="new_user" type="submit" class="btn user-form__btn-submit" value="<?php esc_attr_e('Create my account', 'avatar-tcm'); ?>">
				</div>
			</div>
		</div>
	</form>
<?php
}

function avatar_user_register_get_fields()
{
    return [
        'user_pass' => isset($_POST['user_pass']) ? $_POST['user_pass'] : '',
        'user_pass2' => isset($_POST['user_pass2']) ? $_POST['user_pass2'] : '',
        'user_login' => current_time('timestamp').'avt'.wp_rand(1, 99999),
        'f_EMail' => isset($_POST['f_EMail']) ? $_POST['f_EMail'] : '',
        'f_Gender' => isset($_POST['f_Gender']) ? $_POST['f_Gender'] : '',
        'f_FirstName' => isset($_POST['f_FirstName']) ? $_POST['f_FirstName'] : '',
        'f_LastName' => isset($_POST['f_LastName']) ? $_POST['f_LastName'] : '',
        'f_Company' => isset($_POST['f_Company']) ? $_POST['f_Company'] : '',
        'is_newspaper' => isset($_POST['is_newspaper']) ? $_POST['is_newspaper'] : false,
        'is_display_newspaper' => isset($_POST['is_display_newspaper']) ? $_POST['is_display_newspaper'] : false,
        'f_BusinessAddress' => isset($_POST['f_BusinessAddress']) ? $_POST['f_BusinessAddress'] : '',
        'f_UnitNumber' => isset($_POST['f_UnitNumber']) ? $_POST['f_UnitNumber'] : '',
        'f_City' => isset($_POST['f_City']) ? $_POST['f_City'] : '',
        'f_Country' => isset($_POST['f_Country']) ? $_POST['f_Country'] : '',
        'f_ProvinceState' => isset($_POST['f_ProvinceState']) ? $_POST['f_ProvinceState'] : '',
        'f_PostalCode' => isset($_POST['f_PostalCode']) ? $_POST['f_PostalCode'] : '',
        'f_Telephone' => isset($_POST['f_Telephone']) ? $_POST['f_Telephone'] : '',
        'f_Source' => 'Avatar',
        'licensed_to_sell' => isset($_POST['licensed_to_sell']) ? $_POST['licensed_to_sell'] : 'yes',
        'role_in_firm' => isset($_POST['role_in_firm']) ? $_POST['role_in_firm'] : [],
        'product_sell' => isset($_POST['product_sell']) ? $_POST['product_sell'] : [],
        'optin_OptInPartnerIE' => isset($_POST['optin_OptInPartnerIE']) ? $_POST['optin_OptInPartnerIE'] : '',
        'optin_IE_Offers' => isset($_POST['optin_IE_Offers']) ? $_POST['optin_IE_Offers'] : '',
        'optin_Optin_Transcontinental' => isset($_POST['optin_Optin_Transcontinental']) ? $_POST['optin_Optin_Transcontinental'] : '',
        'optin_special' => isset($_POST['optin_special']) ? $_POST['optin_special'] : '',
        'recaptcha' => isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '',
    ];
}

function avatar_user_register_validate(&$fields, &$errors)
{

    // Make sure there is a proper wp error obj
    // If not, make one
    if (! is_wp_error($errors)) {
        $errors = new WP_Error;
    }

    // Validate form data

    if (empty($fields['user_pass'])) {
        $errors->add('user_pass_field', __('Required form field "Password" is missing', 'avatar-tcm'));
    }
    if (empty($fields['user_pass2'])) {
        $errors->add('user_pass2_field', __('Required form field "Repeat Password" is missing', 'avatar-tcm'));
    }
    if (! ($fields['user_pass'] === $fields['user_pass2'])) {
        $errors->add('user_passs', __('Passwords do not match', 'avatar-tcm'));
    }
    if (strlen($fields['user_pass']) < 8) {
        $errors->add('user_pass', __('Password length must be greater than 8', 'avatar-tcm'));
    }
    if (! preg_match('@[A-Z]@', $fields['user_pass'])) {
        $errors->add('user_pass', __('Password must have uppercase letter', 'avatar-tcm'));
    }
    if (! preg_match('@[a-z]@', $fields['user_pass'])) {
        $errors->add('user_pass', __('Password must have lowercase letter', 'avatar-tcm'));
    }
    if (! preg_match('@[0-9]@', $fields['user_pass'])) {
        $errors->add('user_pass', __('Password must contain a number', 'avatar-tcm'));
    }
    if (empty($fields['f_FirstName'])) {
        $errors->add('f_FirstName', __('Required field "First Name" is empty', 'avatar-tcm'));
    }
    if (empty($fields['f_LastName'])) {
        $errors->add('f_LastName', __('Required field "Last Name" is empty', 'avatar-tcm'));
    }
    if (empty($fields['f_Company'])) {
        $errors->add('f_Company', __('Required field "Company Name" is missing', 'avatar-tcm'));
    }
    if (! is_email($fields['f_EMail'])) {
        $errors->add('email_invalid', __('Email is invalid', 'avatar-tcm'));
    }
    if (email_exists($fields['f_EMail'])) {
        $errors->add('email', __('Email is already in use', 'avatar-tcm'));
    }
    if ($fields['licensed_to_sell'] == 'yes') {
        if (empty($fields['product_sell'])) {
            $errors->add('product_sell', __('Select which product you sell', 'avatar-tcm'));
        }
    }
    if ($fields['licensed_to_sell'] == 'no') {
        if (empty($fields['role_in_firm'])) {
            $errors->add('role_in_firm', __('Select what is your main responsibility/role within your firm', 'avatar-tcm'));
        }
    }

    // NewsPaper

    if ($fields['is_newspaper'] || $fields['is_display_newspaper']) {

        // make user newspaper to DI
        if ($avatar_optin_newspaper = get_field('acf_newspaper', 'option')) {
            $fields[$avatar_optin_newspaper] = true;
        }

        // Newsletter
        if (have_rows('acf_newsletter', 'option')) {
            while (have_rows('acf_newsletter', 'option')) {
                the_row();
                $id = get_sub_field('acf_newsletter_id');
                $fields[$id] = true;
            }
        }
        // Opt-in
        if (have_rows('acf_opt_in', 'option')) {
            while (have_rows('acf_opt_in', 'option')) {
                the_row();
                $id = get_sub_field('acf_opt_in_id');
                $fields[$id] = true;
            }
        }

        if (empty($fields['f_BusinessAddress'])) {
            $errors->add('f_BusinessAddress', __('Field "Business address" is mandatory', 'avatar-tcm'));
        }

        if (empty($fields['f_City'])) {
            $errors->add('f_City', __('Field "City" is mandatory', 'avatar-tcm'));
        }

        if (empty($fields['f_Country'])) {
            $errors->add('f_Country', __('Field "Country" is mandatory', 'avatar-tcm'));
        }

        if (empty($fields['f_PostalCode'])) {
            $errors->add('f_PostalCode', __('Field "Postal Code" is mandatory', 'avatar-tcm'));
        }

        if (empty($fields['f_Telephone'])) {
            $errors->add('f_Telephone', __('Field "Telephone" is mandatory', 'avatar-tcm'));
        }

        if (strlen($fields['f_PostalCode']) > 12) {
            $errors->add('f_PostalCode', __('Invalid postal code length', 'avatar-tcm'));
        }

        if (($fields['f_Country'] == 'Canada' || $fields['f_Country'] == 'United States') && ($fields['f_ProvinceState'] == '')) {
            $errors->add('f_ProvinceState', __('Field "Province" is mandatory', 'avatar-tcm'));
        }

        if ($fields['f_Country'] == 'Canada') {

            $expression = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
            $is_valid = (bool) preg_match($expression, $fields['f_PostalCode']);

            if (! $is_valid) {
                $errors->add('f_ProvinceState', __('Invalid Canadian Postal Code', 'avatar-tcm'));
            }

        }

        if ($fields['f_Country'] == 'United States') {

            $expression = '/^\d{5}([\-]?\d{4})?$/';
            $is_valid = (bool) preg_match($expression, $fields['f_PostalCode']);

            if (! $is_valid) {
                $errors->add('f_ProvinceState', __('Invalid United States Zip Code', 'avatar-tcm'));
            }

        }
    }

    if (empty($fields['recaptcha'])) {
        $errors->add('recaptcha_error', __('The captcha must be validated.', 'avatar-tcm'));
    } else {

        $secretKey = get_field('acf_recaptcha_secret_key', 'options');
        $ip = avatar_get_ip_address();
        $response = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$fields['recaptcha'].'&remoteip='.$ip);
        $response = wp_remote_retrieve_body($response);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys['success']) !== 1) {
            $errors->add('recaptcha_spam', __('The captcha must be validated', 'avatar-tcm'));
        }
    }
    // If errors were produced, fail
    if (count($errors->get_error_messages()) > 0) {
        return false;
    }

    // Else, success!
    return true;
}

function avatar_get_user_register_display_thanks_message($user_firstname, $user_email, $code)
{
    $activation_link = add_query_arg(['key' => $code, 'email' => $user_email], get_permalink(get_field('acf_page_resend', 'option')));

    return '<div class="user-form-confirmation text-center">
		<i class="fa fa-envelope user-form-confirmation__icon" aria-hidden="true"></i>
		<span class="user-form-confirmation__title">
			'.__('Thank you', 'avatar-tcm').' '.$user_firstname.'
		</span>
		<span class="user-form-confirmation__text user-form-confirmation__text--thick">
			'.__('A confirmation email has been sent to your email address : ', 'avatar-tcm').' '.$user_email.'
		</span>
		<span class="user-form-confirmation__text user-form-confirmation__text--italic">
			'.__('The Investment Executive Team', 'avatar-tcm').'
		</span>
	</div>';
}

function avatar_user_register_display_thanks_message($user_firstname, $user_email, $code)
{
    echo avatar_get_user_register_display_thanks_message($user_firstname, $user_email, $code);
}
