<?php
$avatar_tools_ac_id = get_field('acf_advisor_retirement_resource_center_link', 'option');
if (! $avatar_tools_ac_id) {
    return;
}
?>
<div class="row bloc">
	<div class="col-md-12">
		<h2 class="retirement">
			<a href="<?php echo esc_url(get_permalink($avatar_tools_ac_id)); ?>">
				<?php _e('Retirement resource centre', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if (has_post_thumbnail($avatar_tools_ac_id)) { ?>
					<figure class="col-sm-6 thumb">
						<a href="<?php echo esc_url(get_permalink($avatar_tools_ac_id)); ?>">
							<?php echo get_the_post_thumbnail($avatar_tools_ac_id, 'medium', ['class' => 'img-responsive']); ?>
						</a>
					</figure>
				<?php } ?>
				<div class="col-sm-6 text">
					<h3>
						<a class="text-content__link" href="<?php echo esc_url(get_permalink($avatar_tools_ac_id)); ?>">
							<?php echo get_the_title($avatar_tools_ac_id); ?>
						</a>
					</h3>
					<p><?php echo get_the_excerpt($avatar_tools_ac_id); ?></p>
					<a href="<?php echo esc_url(get_permalink($avatar_tools_ac_id)); ?>" class="btn user-form__btn-submit">
						<?php _e('Learn more', 'avatar-tcm'); ?>
					</a>
					<figure class="sponsored-by">
						<figcaption><?php _e('Brought to you by', 'avatar-tcm'); ?></figcaption>
						<a href="https://www.sunlife.ca/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sunlife-mini.png" alt=""></a>
					</figure>
				</div>
			</div>
		</div>
	</div>
</div>