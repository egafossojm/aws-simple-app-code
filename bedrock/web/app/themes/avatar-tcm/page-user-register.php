<?php
/**
*Template Name: User : Register
**/
?>
<?php
if (is_user_logged_in()) {
    $user_redirect_to = get_field('acf_profile_information', 'options') ? get_page_link(get_field('acf_profile_information', 'options')) : home_url();
    wp_redirect($user_redirect_to);
    exit;
}

$registrer_result = avatar_try_user_register($fields, $errors);
?>
<?php get_header(); ?>
<div class="wrap">
<div id="primary" class="content-area">
	<main class="user-page">
		<section class="col-no-padding-xs col-md-12">
			<!--user header -->
			<div class="user-header">
				<div class="user-header__page-title" style="background: url(<?php the_post_thumbnail_url(); ?> );">
					<h1 class="user-header__page-title-text"><?php _e('Subscription Details', 'avatar-tcm'); ?></h1>
				</div>
			</div>
		</section>

		<?php if (! isset($_POST['new_user'])) { ?>
			<!--Why become a member?-->
			<aside class="col-md-3 col-md-push-9 user-side-box">
				<span class="user-side-box__title"><?php _e('Why subscribe?', 'avatar-tcm'); ?></span>
				<ul class="user-side-box__list"><!-- loop -->
					<li class="user-side-box__item"><?php _e('Access the most original and influential benefits, pension and investment news source for key decision-makers in Canadian workplaces.', 'avatar-tcm'); ?></li>
					<li class="user-side-box__item"><?php _e('Receive exclusive content through our newsletters.', 'avatar-tcm'); ?></li>
					<li class="user-side-box__item"><?php _e('Special offers, webinars, surveys, research and so much more!', 'avatar-tcm'); ?></li>
				</ul>
			</aside>
		<?php } ?>

		<section class="<?php echo $css_class = isset($_POST['new_user']) ? 'col-md-12' : 'col-md-9 col-md-pull-3'; ?> user-form">
			<?php
            switch ($registrer_result) {
                case 'BADFIELD':case 'user_register_failed':
                    // Generate form
                    avatar_user_register_display_form($fields, $errors);
                    break;
                default:
                    echo $registrer_result;
                    break;
            }
//avatar_user_register( $fields, $errors );
?>
		</section>

	</main>
	</div>
</div>
<?php get_footer(); ?>