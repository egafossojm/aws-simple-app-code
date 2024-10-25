<?php
$post_id = get_the_ID();

//Gather values for Profile information
$profile_information = get_field('acf_profile_information', 'option');
$profile_information_active_state = ($post_id == $profile_information->ID) ? 'active' : '';

//Gather values for Profile Newspaper
$profile_newspaper = get_field('acf_profile_newspaper', 'option');
$profile_newspaper_active_state = ($post_id == $profile_newspaper->ID) ? 'active' : '';

//Gather values for Profile Newsletters
//TODO : RENAME WITH A S -ACF
$profile_newsletters = get_field('acf_profile_newsletters', 'option');
$profile_newsletters_active_state = ($post_id == $profile_newsletters->ID) ? 'active' : '';

//Gather values for Profile Contact us
$profile_contact_us = get_field('acf_profile_contact_us', 'option');
$profile_contact_us_active_state = ($post_id == $profile_contact_us->ID) ? 'active' : '';
?>
<ul class="user-profile-menu nav">
	<?php if ($profile_information) { ?>
	<!--profile information-->
	<li class="user-profile-menu__item <?php echo esc_attr($profile_information_active_state); ?>">
		<a class="user-profile-menu__link" href="<?php the_permalink($profile_information->ID); ?>">
			<div class="user-profile-menu__title-left">
				<i class="user-profile-menu__icon fa fa-user" aria-hidden="true"></i>
			</div>
			<div class="user-profile-menu__title-right">
				<span class="user-profile-menu__text hidden-sm hidden-xs <?php echo get_locale(); ?>"><?php echo esc_html($profile_information->post_title); ?></span>
			</div>
		</a>
	</li>
	<?php } ?>

	<?php if ($profile_newsletters) { ?>
	<!-- profile newsletters-->
	<li class="user-profile-menu__item <?php echo esc_attr($profile_newsletters_active_state); ?>">
		<a class="user-profile-menu__link" href="<?php the_permalink($profile_newsletters->ID); ?>">
			<div class="user-profile-menu__title-left">
				<i class="user-profile-menu__icon fa fa-envelope" aria-hidden="true"></i>
			</div>
			<div class="user-profile-menu__title-right">
				<span class="user-profile-menu__text hidden-sm hidden-xs <?php echo get_locale(); ?>"><?php echo esc_html($profile_newsletters->post_title); ?></span>
			</div>
		</a>
	</li>
	<?php } ?>

	<?php if ($profile_newspaper) { ?>
	<!--profile newspaper-->
	<li class="user-profile-menu__item <?php echo esc_attr($profile_newspaper_active_state); ?>">
		<a class="user-profile-menu__link" href="<?php the_permalink($profile_newspaper->ID); ?>">
			<div class="user-profile-menu__title-left">
				<i class="user-profile-menu__icon fa fa-newspaper-o" aria-hidden="true"></i>
			</div>
			<div class="user-profile-menu__title-right">
				<span class="user-profile-menu__text hidden-sm hidden-xs <?php echo get_locale(); ?>"><?php echo esc_html($profile_newspaper->post_title); ?></span>
			</div>
		</a>
	</li>
	<?php } ?>



	<?php if ($profile_contact_us) { ?>
	<!-- profile contact us-->
	<li class="user-profile-menu__item <?php echo esc_attr($profile_contact_us_active_state); ?>">
		<a class="user-profile-menu__link" href="<?php the_permalink($profile_contact_us->ID); ?>" >
			<div class="user-profile-menu__title-left">
				<i class="user-profile-menu__icon fa fa-commenting-o" aria-hidden="true"></i>
			</div>
			<div class="user-profile-menu__title-right">
				<span class="user-profile-menu__text hidden-sm hidden-xs <?php echo get_locale(); ?>"><?php echo esc_html($profile_contact_us->post_title); ?></span>
			</div>
		</a>
	</li>
	<?php } ?>
	<!-- log out-->
	<li class="user-profile-menu__item">
		<a class="user-profile-menu__link" href="<?php echo wp_logout_url(home_url()); ?>" >
			<div class="user-profile-menu__title-left">
				<i class="user-profile-menu__icon fa fa-sign-out" aria-hidden="true"></i>
			</div>
			<div class="user-profile-menu__title-right">
				<span class="user-profile-menu__text hidden-sm hidden-xs <?php echo get_locale(); ?>"><?php _e('Logout', 'avatar-tcm'); ?></span>
			</div>
		</a>
	</li>

</ul>