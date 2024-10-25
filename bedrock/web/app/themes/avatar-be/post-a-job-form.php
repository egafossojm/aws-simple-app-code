<?php

/**
 * Template Name: Post a Job
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 *
 * @version 1.0.0
 */
get_header(); ?>
<?php while (have_posts()) {
    the_post(); ?>

	<article class="base-article">
		<header>
			<h1><?php the_title(); ?> </h1>
		</header>
		<div class="row equal-col-md">
			<section class="col-md-8 article-body">
				<?php
                    // User Contact
                    $was_sent = false;

    if (isset($_REQUEST['send_post_a_job_form'])) {

        if (empty($_POST['g-recaptcha-response'])) {
            $errors = new WP_Error;
            $errors->add('recaptcha_error', __('The captcha must be validated.', 'avatar-tcm'));
        } else {
            $secretKey = get_field('acf_recaptcha_secret_key', 'options');
            $ip = avatar_get_ip_address();
            $response = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$ip);
            $response = wp_remote_retrieve_body($response);
            $responseKeys = json_decode($response, true);

            if (intval($responseKeys['success']) !== 1) {
                $errors = new WP_Error;
                $errors->add('recaptcha_spam', "You're a robot, aren't you?");
            }
        }

        // it's ok send email
        if (! (is_wp_error($errors) && count($errors->get_error_messages()) > 0)) {
            $time = date_i18n(get_option('date_format'), current_time('timestamp'));

            $job_Title = $_POST['job-title'];
            $salary_Range = $_POST['salary-range'];
            $location = $_POST['location'];
            $short_Description = $_POST['short-description'];
            $long_Description = $_POST['long-description'];
            $employment_Status = $_POST['employment-status'];
            $how_to_apply = $_POST['how-to-apply'];
            $website = $_POST['website'];
            $posting_date = $_POST['posting-date'];
            $closing_date = $_POST['closing-date'];
            $first_name = $_POST['first-name'];
            $last_name = $_POST['last-name'];
            $submitter_company_name = $_POST['submitter-company-name'];
            $submitter_email = $_POST['submitter-email'];
            $street = $_POST['street'];
            $city = $_POST['city'];
            $country = $_POST['f_Country'];
            $province = $_POST['f_Province'];
            $submitter_phone_number = $_POST['submitter-phone-number'];
            $postalCode = $_POST['PostalCode'];
            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

            // $send_email_to = 'michel.schmit@toumoro.com';
            $send_email_to = get_field('acf_post__job_form_email', 'option');

            //$headers = 'Cc: '.$current_user->display_name.' <'.$current_user->user_email.'>;' . "\r\n";
            $user_msg .= '<hr><br /><br /><code>';
            $user_msg .= '<strong>'.__('Job Title : ', 'avatar-tcm').'</strong>'.$job_Title.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Salary Range : ', 'avatar-tcm').'</strong>'.$salary_Range.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Location : ', 'avatar-tcm').'</strong>'.$location.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Short Description : ', 'avatar-tcm').'</strong>'.$short_Description.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Long Description : ', 'avatar-tcm').'</strong>'.$long_Description.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Emloyment Status : ', 'avatar-tcm').'</strong>'.$employment_Status.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('How to apply : ', 'avatar-tcm').'</strong>'.$how_to_apply.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Website : ', 'avatar-tcm').'</strong>'.$website.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Posting Date : ', 'avatar-tcm').'</strong>'.$posting_date.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Closing Date : ', 'avatar-tcm').'</strong>'.$closing_date.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('First Name : ', 'avatar-tcm').'</strong>'.$first_name.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Last Name : ', 'avatar-tcm').'</strong>'.$last_name.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Submitter Company Name : ', 'avatar-tcm').'</strong>'.$submitter_company_name.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Submitter Phone Number : ', 'avatar-tcm').'</strong>'.$submitter_phone_number.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Submitter Email : ', 'avatar-tcm').'</strong>'.$submitter_email.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Submiter Address ', 'avatar-tcm').'</strong>'.''.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Street : ', 'avatar-tcm').'</strong>'.$street.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('City : ', 'avatar-tcm').'</strong>'.$city.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Country : ', 'avatar-tcm').'</strong>'.$country.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Province : ', 'avatar-tcm').'</strong>'.$province.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            $user_msg .= '<strong>'.__('Postal Code : ', 'avatar-tcm').'</strong>'.$postalCode.'<br />';
            $user_msg .= __('------------------------------------------------------', 'avatar-tcm').''.'<br />';
            //$user_msg .= '<strong>' . __('logo : ', 'avatar-tcm') . '</strong>' . '<img alt="" src="cid:logo_photo">' . '<br /></code>';

            $body_message = avatar_template_email_system(['title' => stripslashes_deep($user_sbj), 'content' => stripslashes_deep(nl2br($user_msg))]);

            function attachInlineImage()
            {
                global $phpmailer, $_FILES;
                $file = $_FILES['logo']['tmp_name'];
                $uid = 'logo_photo';
                $name = $_FILES['logo']['name'];
                if (is_file($file)) {
                    $phpmailer->AddEmbeddedImage($file, $uid, $name);
                }
            }

            add_action('phpmailer_init', 'attachInlineImage');
            avatar_send_email($send_email_to, get_bloginfo('name').' - '.__('Post a Job', 'avatar-tcm'), $body_message);
            $was_sent = true;
            // clean contact form
            $user_sbj = $user_msg = '';
        } else {
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
    }
    ?>
				<div class="row">
					<div class="text-center">
						<span class="user-profile-content__title"><?php echo esc_html($profile_contact_us->post_title); ?></span>
						<p class="user-profile-content__intro-text"><?php the_content(); ?></p>
					</div>

					<form class="user-form col-md-offset-3 post-a-job-form" action="<?php echo avatar_get_current_url(); ?>" method="POST" enctype="multipart/form-data">
						<?php if ($was_sent) { ?>
							<div class="alert alert-success">
								<?php _e('Job Posting was sent. Thank you!', 'avatar-tcm'); ?>
							</div>
						<?php } ?>
						<!-- job title -->
						<div>
							<label for="job-title" class="user-form__label"><?php _e('Job Title*', 'avatar-tcm'); ?></label>
							<input value="<?php echo isset($user_sbj) ? $user_sbj : ''; ?>" type="text" id="job-title" name="job-title" class="form-control" aria-required="true" required>
						</div>
						<!-- salary range -->
						<div>
							<label for="salary-range" class="user-form__label"><?php _e('Salary Range', 'avatar-tcm'); ?></label>
							<input value="" type="text" id="salary-range" name="salary-range" class="form-control" aria-required="false">
						</div>
						<!-- location -->
						<div>
							<label for="location" class="user-form__label"><?php _e('Location*', 'avatar-tcm'); ?></label>
							<input value="" type="text" id="location" name="location" class="form-control" aria-required="true" required>
						</div>
						<!-- Short description -->
						<label for="short-description" class="user-form__label"><?php echo _e('Short Description*', 'avatar-tcm'); ?></label>
						<label for="short-description" class="user-form__label" style="font-size: smaller;"><?php echo _e('This text will appear on the Careers homepage (Approximately 60 words)', 'avatar-tcm'); ?></label>
						<textarea name="short-description" class="form-control" id="short-description" rows="2" aria-required="true" required maxlength="800"></textarea>

						<!-- long description -->
						<label for="long-description" class="user-form__label"><?php echo _e('Long Description*', 'avatar-tcm'); ?></label>
						<textarea name="long-description" class="form-control" id="long-description" rows="6" aria-required="true" required></textarea>
						<!-- employment status -->
						<label for="employment-status" class="user-form__label"><?php _e('Employment Status*', 'avatar-tcm'); ?></label>
						<select id="employment-status" name="employment-status" class="form-control">
							<option value="Full-Time" aria-required="true" required><?php _e('Full-time', 'avatar-tcm'); ?></option>
							<option value="Half-Time" aria-required="true" required><?php _e('Half-time', 'avatar-tcm'); ?></option>

						</select>
						<!-- how to apply -->
						<label for="how-to-apply" class="user-form__label"><?php echo _e('How to apply and contact information*', 'avatar-tcm'); ?></label>
						<textarea name="how-to-apply" class="form-control" id="how-to-apply" rows="3" aria-required="true" required></textarea>
						<!-- website -->
						<label for="website" class="user-form__label"><?php _e('Website', 'avatar-tcm'); ?></label>
						<input value="" type="text" id="website" name="website" class="form-control" aria-required="false">

						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<!-- posting date -->
									<label for="posting-date" class="user-form__label"><?php _e('Posting Date', 'avatar-tcm'); ?></label>
									<input value="" type="date" id="posting-date" name="posting-date" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<!-- posting date -->
									<label for="posting-date" class="user-form__label"><?php _e('Closing Date', 'avatar-tcm'); ?></label>
									<input value="" type="date" id="closing-date" name="closing-date" class="form-control">
								</div>
							</div>
						</div>

						<!-- submitter's name -->
						<label for="submitter_name" class="user-form__label"><?php _e("Submitter's Name*", 'avatar-tcm'); ?></label>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<input value="" type="text" placeholder="first name" id="first-name" name="first-name" class="form-control " aria-required="true" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input value="" type="text" placeholder="last name" id="last-name" name="last-name" class="form-control " aria-required="true" required>
								</div>
							</div>
						</div>
						<!-- submitter's company name -->
						<label for="submitter-company-name" class="user-form__label"><?php _e("Submitter's Company Name*", 'avatar-tcm'); ?></label>
						<input value="" type="text" id="submitter-company-name" name="submitter-company-name" class="form-control" aria-required="true" required>
						<!-- subsmitterr's phone number -->
						<label for="submitter-phone-number" class="user-form__label"><?php _e("Submitter's Phone Number*", 'avatar-tcm'); ?></label>
						<input value="" type="tel" id="submitter-phone-number" placeholder="(555) 555-5555" name="submitter-phone-number" class="form-control" aria-required="true" required>
						<!-- subsmitter's email -->
						<label for="submitter-email" class="user-form__label"><?php _e("Submitter's Email Address*", 'avatar-tcm'); ?></label>
						<input value="" type="email" id="submitter-email" name="submitter-email" class="form-control" aria-required="true" required>
						<!-- subsmitter's address -->
						<label for="subsmitter-address" class="user-form__label"><?php _e("Submitter's Address*", 'avatar-tcm'); ?></label>
						<input value="" placeholder="street" type="text" id="street" name="street" class="form-control" aria-required="true" required>
						<input value="" placeholder="city" type="text" id="city" name="city" class="form-control" aria-required="true" required>
						<!-- Country -->
						<select id="f_Country" name="f_Country" class="form-control" aria-required="true" required>
							<?php foreach (avatar_get_country_list_arr(get_bloginfo('language')) as $code => $name) { ?>
								<option hidden disabled selected value> -- select a country -- </option>
								<option <?php isset($fields['f_Country']) ? (selected($fields['f_Country'], $name)) : ''; ?> value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
							<?php } ?>
						</select>
						<!-- State -->
						<div id="container_f_ProvinceState" class="collapse <?php echo isset($fields['f_Country']) ? (($fields['f_Country'] == 'Canada' || $fields['f_Country'] == 'United States') ? 'in' : '') : '' ?> ">

							<select class="js_ProvinceState <?php echo isset($fields['f_Country']) ? ($fields['f_Country'] == 'Canada') ? 'in' : '' : ''; ?> collapse  form-control f_ProvinceState_CA" aria-required="true" required>
								<?php foreach (avatar_get_country_states('CA') as $code => $name) { ?>
									<option hidden disabled selected value> -- select a province -- </option>
									<option <?php isset($fields['f_Province']) ? (selected($fields['f_Province'], $name)) : ''; ?> value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
								<?php } ?>
							</select>
							<select class="js_ProvinceState <?php echo isset($fields['f_Country']) ? ($fields['f_Country'] == 'United States') ? 'in' : '' : ''; ?> collapse form-control f_ProvinceState_US">
								<?php foreach (avatar_get_country_states('US') as $code => $name) { ?>
									<option <?php isset($fields['f_Province']) ? (selected($fields['f_Province'], $name)) : ''; ?> value="<?php echo esc_attr($name); ?>" data-countrycode="<?php echo esc_attr($code); ?>"><?php echo esc_attr($name); ?></option>
								<?php } ?>
							</select>
							<input type="hidden" id="f_ProvinceState" name="f_Province" value="<?php echo isset($fields['f_ProvinceS']) ? esc_attr($fields['f_Province']) : ''; ?>">
						</div>

						<input value="" type="text" placeholder="postal code" id="PostalCode" name="PostalCode" class="form-control" aria-required="true" required>

						<!-- logo -->
						<!--
						<div>
							<label for="logo" class="user-form__label"><?php // _e('Logo', 'avatar-tcm');?></label>
							<input id="logo" name="logo" type="file">
						</div>
						-->
						<br>
                        <p><b>Pricing Information:</b> $800 for a one month listing with coloured logo and the promotion of the job listing in the Benefits Canada daily e-newsletter for 1x per week.</p>
						<br>
						<div class="g-recaptcha register-recaptcha" data-sitekey="<?php echo esc_attr(get_field('acf_recaptcha_site_key', 'options')); ?>" required></div><br>
						<input name="send_post_a_job_form" type="submit" class="btn user-form__btn-submit" value="<?php esc_attr_e('Submit', 'avatar-tcm'); ?>">
					</form>
				</div>
			</section>
			<aside class="primary col-md-4">

				<div class="col-sm-6 col-md-12 post-a-job-pricing">
					<div class="bloc">
						<div class="row" style="padding-right: 20px;padding-left: 20px;">
							<h3 style="font-size: larger; color: #ed1c23; font-weight: 600;">Pricing Information:</h3>
							<p style="font-size: medium;">$800 for a one month listing with coloured logo and the promotion of the job listing in the Benefits Canada daily e-newsletter for 1x per week.</p>
							<p style="font-size: medium;"><strong>If you have any questions please <a href="mailto:cassie.pastorfide@contexgroup.ca?Subject=Benefits%20Canada%20Careers">contact us</a>.</strong></p>
						</div>
					</div>
				</div>

				<?php
    //include Quick subscribe newsletters component

    avatar_include_subscription_module();

    //include( locate_template( 'templates/homepage/component-quick-subscribe-newsletters.php' ) );
    ?>


				<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">
					<?php
        $arr_m32_vars = [
            'sticky' => false,
            'staySticky' => false,
            'kv' => [
                'pos' => [
                    'btf',
                    'but1',
                    'right_bigbox_last',
                    'bottom_right_bigbox',
                ],
            ],
            'sizes' => '[ [300,1050], [300,600], [300,250] ]',
            'sizeMapping' => '[ [[0,0], [[320,50], [300,250]]], [[768,0], [[300,250]]], [[1024, 0], [[300,1050], [300,600], [300,250]]] ]',
        ];
    $arr_avt_vars = [
        'class' => 'bigbox text-center col-xs-12 col-sm-6 col-md-12 col-lg-12',
    ];

    get_correct_banner_ads(get_the_category(), $site_id, $id, $wp_query, $arr_m32_vars, $arr_avt_vars);

    ?>

					<?php
    // Include Microsite Block
    // $avatar_microsite_template = $avatar_article_site_origin === 'CIR' ? 'templates/cir/microsite/component-microsite-cir-block.php' : 'templates/microsite/component-microsite-block.php';
    // avatar_include_template_conditionally( $avatar_microsite_template, 'SHOW_HOMEPAGE_MICROSITE_WIDGET' );
    ?>
				</div>
			</aside>
		</div>
	</article>

<?php } ?>
<?php get_footer(); ?>
