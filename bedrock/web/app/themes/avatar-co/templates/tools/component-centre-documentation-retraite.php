<?php
$site_id = get_current_blog_id();
$avatar_tools_ac_id = get_field('acf_tools_centre_documentation_retraite_link', 'option');
if (! $avatar_tools_ac_id) {
    return;
}
if ($site_id == 4) {
    $retraite_url = '../microsite/centre-de-documentation-sur-la-retraite';
} else {
    $retraite_url = esc_url(get_page_link($avatar_tools_ac_id));
}
?>
<div class="row bloc">
	<div class="col-md-12">
		<h2 class="retirement">
			<a href="<?php echo $retraite_url; ?>">
				<?php _e('Centre de documentation sur la retraite', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if (has_post_thumbnail($avatar_tools_ac_id)) { ?>
					<figure class="col-sm-6 thumb">
						<a href="<?php echo $retraite_url; ?>">
							<?php echo get_the_post_thumbnail($avatar_tools_ac_id, 'medium', ['class' => 'img-responsive']); ?>
						</a>
					</figure>
				<?php } ?>
				<div class="col-sm-6 text">
					<h3>
						<a class="text-content__link" href="<?php echo $retraite_url; ?>">
							<?php echo get_the_title($avatar_tools_ac_id); ?>
						</a>
					</h3>
					<p><?php echo get_the_excerpt($avatar_tools_ac_id); ?></p>
					<a href="<?php echo $retraite_url; ?>" class="btn user-form__btn-submit">
						<?php _e('Cliquez ici', 'avatar-tcm'); ?>
					</a>
					<figure class="sponsored-by">
						<figcaption><?php _e('Brought to you by :', 'avatar-tcm'); ?></figcaption>
						<a href="https://www.sunlife.ca/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-footer-sun-life-fr.png" alt=""></a>
					</figure>
				</div>
			</div>
		</div>
	</div>
</div>