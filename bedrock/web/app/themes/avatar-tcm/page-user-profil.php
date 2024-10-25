<?php
/**
*Template Name: User : Profil
**/
?>
<?php
if (! is_user_logged_in()) {
    $user_redirect_to = get_field('acf_page_signin', 'options') ? get_page_link(get_field('acf_page_signin', 'options')) : home_url();
    wp_redirect($user_redirect_to);
    exit;
}
global $current_user;
$alreadySend = false;

if (! isset($errors)) {
    $errors = new WP_Error;
}

/* -------------------------------------------------------------
 * Update Profile
 * ============================================================*/
$was_profile_updated = false;
avatar_add_diid(wp_get_current_user());
if (isset($_REQUEST['update_user_profile'])) {
    $avatar_get_user_data_di = $_REQUEST;
    $avatar_get_user_data_di['f_lastQualificationdate'] = date('Y-m-d H:i:s +0000');

    $product_sell_arr = isset($avatar_get_user_data_di['f_product_sell']) ? $avatar_get_user_data_di['f_product_sell'] : [];
    $role_in_firm_arr = isset($avatar_get_user_data_di['f_role_in_firm']) ? $avatar_get_user_data_di['f_role_in_firm'] : [];

    $prof_organizations_arr = isset($avatar_get_user_data_di['f_ProfOrganizations']) ? $avatar_get_user_data_di['f_ProfOrganizations'] : [];
    $prof_designations_arr = isset($avatar_get_user_data_di['f_CompletedCourses']) ? $avatar_get_user_data_di['f_CompletedCourses'] : [];

    if ($avatar_get_user_data_di['user_pass'] != '') {
        if (! ($avatar_get_user_data_di['user_pass'] === $avatar_get_user_data_di['user_pass2'])) {
            $errors->add('user_passs', __('Passwords do not match', 'avatar-tcm'));
        }
        if (strlen($avatar_get_user_data_di['user_pass']) < 8) {
            $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
        }
        if (! preg_match('@[A-Z]@', $avatar_get_user_data_di['user_pass'])) {
            $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
        }
        if (! preg_match('@[a-z]@', $avatar_get_user_data_di['user_pass'])) {
            $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
        }
        if (! preg_match('@[0-9]@', $avatar_get_user_data_di['user_pass'])) {
            $errors->add('user_pass', __('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'));
        }
    }

    if (empty($avatar_get_user_data_di['f_FirstName'])) {
        $errors->add('f_FirstName', __('Required field "First Name" is empty', 'avatar-tcm'));
    }
    if (empty($avatar_get_user_data_di['f_LastName'])) {
        $errors->add('f_LastName', __('Required field "Last Name" is empty', 'avatar-tcm'));
    }
    if (empty($avatar_get_user_data_di['f_Company'])) {
        $errors->add('f_Company', __('Required field "Company Name" is empty', 'avatar-tcm'));
    }

    if ($avatar_get_user_data_di['f_EMail'] != $current_user->user_email) {

        if (! is_email($avatar_get_user_data_di['f_EMail'])) {
            $errors->add('email_invalid', __('Email is invalid', 'avatar-tcm'));
        }
        if (email_exists($avatar_get_user_data_di['f_EMail'])) {
            $errors->add('email', __('Email already in use', 'avatar-tcm'));
        }
    }

    if ($avatar_get_user_data_di['licensed_to_sell'] == 'yes') {
        if (empty($avatar_get_user_data_di['f_product_sell'])) {
            $errors->add('f_product_sell', __('Select which product you sell', 'avatar-tcm'));
        }
    }
    if ($avatar_get_user_data_di['licensed_to_sell'] == 'no') {
        if (empty($avatar_get_user_data_di['f_role_in_firm'])) {
            $errors->add('f_role_in_firm', __('Select what is your main responsibility/role within your firm', 'avatar-tcm'));
        }
    }

    // All it's OK, send data to DI && Update user meta
    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {
        $send_to_di = avatar_update_user_profile($avatar_get_user_data_di, $current_user->user_email);
        $user_arg = ['ID' => $current_user->ID];
        if ($send_to_di) {
            $send_to = get_field('acf_profile_update_email', 'option');
            avatar_send_email($send_to, sprintf(__('%s account update', 'avatar-tcm'), get_bloginfo('name')), avatarie_update_profile_ie_email_body(avatar_user_profil_sanitize($avatar_get_user_data_di)));
            $alreadySend = true;
        }
        if ($avatar_get_user_data_di['f_EMail'] != $current_user->user_email && $avatar_get_user_data_di['f_EMail'] != '') {
            $user_arg['user_email'] = $avatar_get_user_data_di['f_EMail'];
        }

        if ($avatar_get_user_data_di['f_FirstName'] != $current_user->first_name && $avatar_get_user_data_di['f_FirstName'] != '') {
            $user_arg['first_name'] = $avatar_get_user_data_di['f_FirstName'];
        }
        if ($avatar_get_user_data_di['f_LastName'] != $current_user->last_name && $avatar_get_user_data_di['f_LastName'] != '') {
            $user_arg['last_name'] = $avatar_get_user_data_di['f_LastName'];
        }

        if ($avatar_get_user_data_di['user_pass'] != $current_user->user_pass && $avatar_get_user_data_di['user_pass'] != '') {
            $user_arg['user_pass'] = $avatar_get_user_data_di['user_pass'];
        }

        if (count($user_arg) > 1) {

            if (array_key_exists('user_pass', $user_arg)) {
                delete_user_meta($current_user->ID, 'avatar_change_pass');
            }
            $user_update = wp_update_user($user_arg);
        }

        $was_profile_updated = true;
    }

} else {
    $avatar_get_user_data_di = avatar_get_user_info_di($current_user->user_email);
    $avatar_get_user_data_di = (array) $avatar_get_user_data_di;
    $product_sell_arr = explode('|', $avatar_get_user_data_di['f_product_sell']);
    $role_in_firm_arr = explode('|', $avatar_get_user_data_di['f_role_in_firm']);
    $prof_organizations_arr = explode('|', $avatar_get_user_data_di['f_ProfOrganizations']);
    $prof_designations_arr = explode('|', $avatar_get_user_data_di['f_CompletedCourses']);
}

/* -------------------------------------------------------------
 * Subscribe to NewsPaper
 * ============================================================*/
$was_newspaper_updated = false;
if (isset($_REQUEST['update_user_newspaper'])) {
    $avatar_get_user_data_di = $_REQUEST;

    $avatar_get_user_data_di['f_BusinessAddress'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_BusinessAddress'])));
    $avatar_get_user_data_di['f_UnitNumber'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_UnitNumber'])));
    $avatar_get_user_data_di['f_City'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_City'])));
    $avatar_get_user_data_di['f_Country'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_Country'])));
    $avatar_get_user_data_di['f_ProvinceState'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_ProvinceState'])));
    $avatar_get_user_data_di['f_PostalCode'] = sanitize_text_field(trim(strtoupper($avatar_get_user_data_di['f_PostalCode'])));
    $avatar_get_user_data_di['f_Telephone'] = sanitize_text_field(trim(stripslashes_deep($avatar_get_user_data_di['f_Telephone'])));
    if ($avatar_optin_newspaper = get_field('acf_newspaper', 'option')) {
        $avatar_get_user_data_di[$avatar_optin_newspaper] = true;
    }

    if (empty($avatar_get_user_data_di['f_BusinessAddress'])) {
        $errors->add('f_BusinessAddress', __('Field "Business address" is mandatory', 'avatar-tcm'));
    }

    if (empty($avatar_get_user_data_di['f_City'])) {
        $errors->add('f_City', __('Field "City" is mandatory', 'avatar-tcm'));
    }

    if (empty($avatar_get_user_data_di['f_Country'])) {
        $errors->add('f_Country', __('Field "Country" is mandatory', 'avatar-tcm'));
    }

    if (empty($avatar_get_user_data_di['f_PostalCode'])) {
        $errors->add('f_PostalCode', __('Field "Postal Code" is mandatory', 'avatar-tcm'));
    }

    if (empty($avatar_get_user_data_di['f_Telephone'])) {
        $errors->add('f_Telephone', __('Field "Telephone" is mandatory', 'avatar-tcm'));
    }

    if (strlen($avatar_get_user_data_di['f_PostalCode']) > 12) {
        $errors->add('f_PostalCode', __('Invalid postal code', 'avatar-tcm'));
    }

    if (($avatar_get_user_data_di['f_Country'] == 'Canada' || $avatar_get_user_data_di['f_Country'] == 'United States') && ($avatar_get_user_data_di['f_ProvinceState'] == '')) {
        $errors->add('f_ProvinceState', __('Field "Province" is mandatory', 'avatar-tcm'));
    }

    if ($avatar_get_user_data_di['f_Country'] == 'Canada') {

        $expression = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
        $is_valid = (bool) preg_match($expression, $avatar_get_user_data_di['f_PostalCode']);

        if (! $is_valid) {
            $errors->add('f_ProvinceState', __('Invalid Postal Code', 'avatar-tcm'));
        }

    }

    if ($avatar_get_user_data_di['f_Country'] == 'United States') {

        $expression = '/^\d{5}([\-]?\d{4})?$/';
        $is_valid = (bool) preg_match($expression, $avatar_get_user_data_di['f_PostalCode']);

        if (! $is_valid) {
            $errors->add('f_ProvinceState', __('Invalid United States Zip Code', 'avatar-tcm'));
        }

    }

    // All it's OK, send data to DI && Update user meta
    if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {

        $send_to_di = avatar_update_user_profile($avatar_get_user_data_di, $current_user->user_email);

        if ($send_to_di) {
            //Test user Role
            if ($current_user->roles[0] == 'subscriber') {
                $current_user->remove_role('subscriber');
                $current_user->add_role('newspaper');
            }
            $was_newspaper_updated = true;

            // AVAIE-1400

            $avatar_get_user_data_di_ = avatar_get_user_info_di($current_user->user_email);
            $avatar_get_user_data_di_ = (array) $avatar_get_user_data_di_;

            $send_to = get_field('acf_profile_update_email', 'option');
            if ($send_to) {
                if (! $alreadySend) {
                    avatar_send_email($send_to, sprintf(__('%s account update', 'avatar-tcm'), get_bloginfo('name')), avatarie_update_profile_ie_email_body(avatar_user_profil_sanitize($avatar_get_user_data_di_)));
                }
            }
        }
    }

} else {
    $avatar_get_user_data_di = avatar_get_user_info_di($current_user->user_email);
    $avatar_get_user_data_di = (array) $avatar_get_user_data_di;
}
?>
<?php get_header(); ?>
<div class="wrap">
<div id="primary" class="content-area">
	<main class="user-page">
		<section>
			<div class="row">
				<div class="col-md-10 col-md-offset-2">
					<?php $change_pass = get_user_meta($current_user->ID, 'avatar_change_pass', true); ?>
					<?php // AVAIE-2087 - change for  $change_pass if you want to show the message, thanks?>
					<?php if ($change_pass = false) { ?>
						<div class="alert alert-warning">
							<?php _e('Passwords must be at least 8 character long, contain an uppercase letter, a lowercase letter and a number.', 'avatar-tcm'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="row equal-col-md">
				<!--menu-->
				<div class="col-md-2 col-no-padding-right">
					<?php include locate_template('templates/user/user-profile-menu.php'); ?>
				</div>
				<!--content -->
				<div class="col-md-10 col-no-padding user-profile-col">
					<div class="user-profile-content">
						<div class="tab-content">
							<!--Newspaper subscritpion tab-->
							<?php if ($profile_newspaper_active_state == 'active') { ?>
							<div id="newspaper-subscription">
								<?php include locate_template('templates/user/user-profile-newspaper.php'); ?>
							</div>
							<?php } ?>
							<!--  Newsletters Subscription -->
							<?php if ($profile_newsletters_active_state == 'active') { ?>
							<div class="text-center" id="newsletters-subscription">
								<?php include locate_template('templates/user/user-profile-newsletters.php'); ?>
							</div>
							<?php } ?>
							<!--  Profile information -->
							<?php if ($profile_information_active_state == 'active') { ?>
							<div id="information">
								<?php include locate_template('templates/user/user-profile-information.php'); ?>
							</div>
							<?php } ?>
							<!--  Contact us -->
							<?php if ($profile_contact_us_active_state == 'active') { ?>
							<div id="contact-us">
								<?php include locate_template('templates/user/user-profile-contact-us.php'); ?>
							</div>
							<?php } ?>
						</div>
						<!-- tab content -->
					</div>
				</div>
		</section>
	</main>
	</div>
</div>
<?php get_footer();

function avatar_user_profil_sanitize($fields)
{
    if (is_array($fields['f_product_sell'])) {
        $fields['f_product_sell'] = implode('|', $fields['f_product_sell']);
    }
    if (is_array($fields['f_role_in_firm'])) {
        $fields['f_role_in_firm'] = implode('|', $fields['f_role_in_firm']);
    }
    if (is_array($fields['f_ProfOrganizations'])) {
        $fields['f_ProfOrganizations'] = implode('|', $fields['f_ProfOrganizations']);
    }
    if (is_array($fields['f_CompletedCourses'])) {
        $fields['f_CompletedCourses'] = implode('|', $fields['f_CompletedCourses']);
    }
    $id_contact = (array) avatar_get_user_info_di($fields['f_EMail']);
    $fields['id_contact'] = $id_contact['id_contact'];

    return $fields;
}
?>
