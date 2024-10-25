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
$avatar_f_page_newsletter_external_link = get_field('acf_footer_page_newsletter_external_link', 'option');
$acf_newspaper_subscription_url = get_field('acf_newspaper_subscription_url', 'option');
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
			<?php if ($avatar_f_page_newsletter_external_link) { ?>
				<a class="btn btn-newsletter <?= is_cir_section() ? 'cir-bg' : ''; ?>" target="_blank" href="<?php echo esc_url($avatar_f_page_newsletter_external_link); ?>"><?php echo _e($site_id == 5 ? 'Newsletters' : 'Bulletins', 'avatar-tcm'); ?></a>
			<?php } ?>
			<?php if ($acf_newspaper_subscription_url) { ?>
				<a class="btn btn-magazine <?= is_cir_section() ? 'cir-bg' : ''; ?>" target="_blank" href="<?php echo $acf_newspaper_subscription_url; ?>"><?php echo _e('Magazine', 'avatar-tcm'); ?></a>
			<?php } ?>
		</div>
		<div class="social">
			<h2><?= get_locale() == 'fr_CA' ? 'Connectez-vous' : 'Connect'; ?></h2>
			<ul>
				<?php while (has_sub_field('acf_footer_sn', 'option')) { ?>
          <?php if (the_sub_field('title') && the_sub_field('url')) { ?>
            <li>
              <a title="<?php esc_attr(the_sub_field('title')); ?>" class="footer-top-socials__link rightwidget-socials_link <?= is_cir_section() ? 'cir-color' : ''; ?>" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>"></a>
            </li>
          <?php } ?>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>