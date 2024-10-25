<?php
$site_id = get_current_blog_id();
$avatar_tools_ac_id = get_field('acf_imagez_vos_explications_link', 'option');
if (! $avatar_tools_ac_id) {
    return;
}
if ($site_id == 4) {
    $explication_url = '../microsite/imagez-vos-explications';
} else {
    $explication_url = esc_url(get_page_link($avatar_tools_ac_id));
}
?>
<div class="row bloc">
	<div class="col-md-12">
		<h2 class="expectations">
			<a href="<?php echo $explication_url; ?>">
				<?php _e('Imagez vos explications', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if (has_post_thumbnail($avatar_tools_ac_id)) { ?>
					<figure class="col-sm-6 thumb">
						<a href="<?php echo $explication_url; ?>">
							<?php echo get_the_post_thumbnail($avatar_tools_ac_id, 'medium', ['class' => 'img-responsive']); ?>
						</a>
					</figure>
				<?php } ?>
				<div class="col-sm-6 text">
					<h3>
						<a class="text-content__link" href="<?php echo $explication_url; ?>">
							<?php echo get_the_title($avatar_tools_ac_id); ?>
						</a>
					</h3>
					<p><?php echo get_the_excerpt($avatar_tools_ac_id); ?></p>
					<a href="<?php echo $explication_url; ?>" class="btn user-form__btn-submit">
						<?php _e('Cliquez ici', 'avatar-tcm'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>