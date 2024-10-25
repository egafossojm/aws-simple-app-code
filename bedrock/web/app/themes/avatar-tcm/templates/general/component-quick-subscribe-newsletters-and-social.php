<?php
/*
 * Location : Sitewide on  AD, AV, CO
 * Ebulletin-magazine and social links Component
 * Quick bulletin and magazine subscription links with social links.
 */
/* -------------------------------------------------------------
 * Get certain Info from theme Option (Footer tab)
 * ============================================================*/
$avatar_f_sn = get_field('acf_footer_sn', 'option');
$site_id = get_current_blog_id();
?>
<div class="col-sm-6 col-md-12 micro-module news-subscribe sponsor-bg">
	<div class="bloc">
		<div class="row head">
			<div class="col-md-12">
				<h2><?= get_locale() == 'fr_CA' ? 'Abonnez-vous' : 'Subscribe'; ?></h2>
			</div>
		</div>
		<div class="row subscriptions">

			<?php if (is_user_logged_in()) { //logged in
			    $newsletters_page = get_field('acf_profile_newsletters', 'option'); ?>
				<a class="btn btn-newsletter <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newsletters_page); ?>">
					<?php echo _e(($site_id == 5) || ($site_id == 7) ? 'Newsletters' : 'Bulletins', 'avatar-tcm'); ?>
				</a>
			<?php } else { //not logged in
			    $signin_page = get_field('acf_page_signin_newsletters', 'option'); ?>
				<a class="btn btn-newsletter <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($signin_page); ?>"><?php echo _e(($site_id == 5) || ($site_id == 7) ? 'Newsletters' : 'Bulletins', 'avatar-tcm'); ?></a>
			<?php } ?>
			<?php if (is_user_logged_in()) { //logged in
			    $newspaper_page = get_field('acf_profile_newspaper', 'option'); ?>
				<a class="btn btn-magazine <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newspaper_page); ?>"><?php echo _e('Magazine', 'avatar-tcm'); ?></a>
			<?php } else { //not logged in
			    $newpaper_signin_page = get_field('acf_footer_page_newspaper_login', 'option'); ?>
				<a class="btn btn-magazine <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newpaper_signin_page); ?>"><?php echo _e('Magazine', 'avatar-tcm'); ?></a>
			<?php } ?>
		</div>
		<div class="social">
			<h2><?= get_locale() == 'fr_CA' ? 'Connectez-vous' : 'Connect'; ?></h2>
			<ul>
				<?php while (has_sub_field('acf_footer_sn', 'option')) { ?>
					<li>
						<a title="<?php esc_attr(the_sub_field('title')); ?>" class="footer-top-socials__link rightwidget-socials_link <?= is_cir_section() ? 'cir-color' : ''; ?>" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>"></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>