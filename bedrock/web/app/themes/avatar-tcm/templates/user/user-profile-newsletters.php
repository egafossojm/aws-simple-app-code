<?php
//User Newsletter
if (isset($_REQUEST['update_user_newsletter'])) {
    $avatar_get_user_data_di = $_REQUEST;

    $avatar_get_user_data_di['f_EMail'] = $current_user->user_email;
    unset($avatar_get_user_data_di['update_user_newsletter']);

    while (have_rows('acf_newsletter', 'option')) {
        the_row();
        $id = get_sub_field('acf_newsletter_id');
        $avatar_get_user_data_di[$id] = (isset($_REQUEST[$id])) ? true : false;
    }
    while (have_rows('acf_opt_in', 'option')) {
        the_row();
        $id = get_sub_field('acf_opt_in_id');
        $avatar_get_user_data_di[$id] = (isset($_REQUEST[$id])) ? true : false;
    }

    $send_to_di = avatar_update_user_di($avatar_get_user_data_di, $current_user->user_email);

} else {
    $avatar_get_user_data_di = avatar_get_user_info_di($current_user->user_email);
    $avatar_get_user_data_di = (array) $avatar_get_user_data_di;
}
?>

<!-- User profile tab : Newsletter Subscription -->
<span class="user-profile-content__title"><?php echo esc_html($profile_newsletters->post_title); ?></span>
<p class="user-profile-content__intro-text"><?php the_content(); ?></p>
<div class="user-profile-newsletters">
	<?php
   if ($avatar_newsletter_title_section = get_field('acf_newsletter_title_section', 'option')) {
       echo '<h3>'.$avatar_newsletter_title_section.'</h3>';
   }?>
	<form action="<?php echo avatar_get_current_url(); ?>" method="POST">
	<!-- newsletters list-->
	<?php // check if the repeater field has rows of data
       if (have_rows('acf_newsletter', 'option')) {
           $i = 0;
           $length = count(get_field('acf_newsletter', 'option')); //to get last of array
           // loop through the rows of data
           while (have_rows('acf_newsletter', 'option')) {
               the_row();
               // get sub field values
               $newsletter_id = get_sub_field('acf_newsletter_id');
               $newsletter_name = esc_html(get_sub_field('acf_newsletter_name'));
               $newsletter_description = esc_html(get_sub_field('acf_newsletter_description'));
               $newsletter_date_info = esc_html(get_sub_field('acf_newsletter_date'));
               $newsletter_image = esc_url(get_sub_field('acf_newsletter_image'));
               $newsletter_di_data = $avatar_get_user_data_di[$newsletter_id];
               $newsletter_style_image = $newsletter_image ? "background:linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)), url('".$newsletter_image."');" : '';
               ?>
			<?php if ($i % 2 == 0) { ?>
				<div class="user-profile-newsletters__row row equal-col-md">
			<?php } ?>
			<div class="col-md-6 col-sm-6">
				<div class="newsletters-box switch-box">
					<input <?php checked($newsletter_di_data, true); ?> type="checkbox" name="<?php echo esc_attr($newsletter_id); ?>" id="<?php echo esc_attr($newsletter_id); ?>">
					<label for="<?php echo esc_attr($newsletter_id); ?>" class="newsletters-box__label">
						<div class="newsletters-box__label-box" style="<?php echo esc_attr($newsletter_style_image); ?>">
							<span class="newsletters-box__label-text"><?php echo wp_kses_post($newsletter_name); ?></span>
							<div class="switch-box__button switch-box__button--light switch-box__button--newsletters"></div>
						</div>
					</label>
					<span class="newsletters-box__infos-text"><?php echo wp_kses_post($newsletter_description); ?></span>
					<span class="newsletters-box__infos-text--date"><?php echo wp_kses_post($newsletter_date_info); ?></span>
				</div>
			</div>
			<?php if ($i % 2 == 1 || $i == $length - 1) {  ?>
				</div>
			<?php } $i++; ?>

		<?php } ?>
	<?php } ?>

	<hr class="thin-line">
	<?php
    if ($avatar_newsletter_title_section_optin = get_field('acf_newsletter_title_section_optin', 'option')) {
        echo '<h3>'.$avatar_newsletter_title_section_optin.'</h3>';
    }?>
	<!-- opt in list -->
		<?php // check if the repeater field has rows of data
            if (have_rows('acf_opt_in', 'option')) {
                $length = count(get_field('acf_opt_in', 'option')); // to get last of array
                $i = 0;
                // loop through the rows of data
                while (have_rows('acf_opt_in', 'option')) {
                    the_row();
                    // get sub field values
                    $opt_in_id = get_sub_field('acf_opt_in_id');
                    $opt_in_name = esc_html(get_sub_field('acf_opt_in_name'));
                    $opt_in_description = esc_html(get_sub_field('acf_opt_in_description'));
                    $opt_in_image = esc_url(get_sub_field('acf_opt_in_image'));
                    $newsletter_di_data = $avatar_get_user_data_di[$opt_in_id];
                    $opt_in_style_image = $opt_in_image ? "background:linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)), url('".$opt_in_image."');" : '';

                    ?>
		<?php if ($i % 2 == 0) { ?>
			<div class="user-profile-newsletters__row row equal-col-md">
		<?php }?>
			<div class="col-md-6 col-sm-6">
				<!--newsletter box 1 -->
				<div class="newsletters-box switch-box">
					<input <?php checked($newsletter_di_data, true); ?> type="checkbox" name="<?php echo esc_attr($opt_in_id); ?>" id="<?php echo esc_attr($opt_in_id); ?>" >
					<label for="<?php echo esc_attr($opt_in_id); ?>" class="newsletters-box__label">
						<div class="newsletters-box__label-box" style="<?php echo esc_attr($opt_in_style_image); ?>">
							<span class="newsletters-box__label-text"><?php echo wp_kses_post($opt_in_name); ?></span>
							<div class="switch-box__button switch-box__button--newsletters"></div>
						</div>
					</label>
					<span class="newsletters-box__infos-text"><?php echo wp_kses_post($opt_in_description); ?></span>
				</div>
			</div>
		<?php if ($i % 2 == 1 || $i == $length - 1) {  ?>
		</div>
		<?php } $i++; ?>

		<?php } ?>
	<?php } ?>
		<input name="update_user_newsletter" type="submit" class="btn user-form__btn-submit" value="<?php esc_attr_e('Save', 'avatar-tcm'); ?>">

	</form>
</div>