<?php
$avatar_tools_ac_id = get_field('acf_tools_advisorcentral_link', 'option');
if (! $avatar_tools_ac_id) {
    return;
}
?>
<div class="row bloc">
	<div class="col-md-12">
		<h2 class="advisor">
			<a target="_blank" href="<?php echo esc_url(get_page_link($avatar_tools_ac_id)); ?>">
				<?php _e('Advisor Central', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
			<span><?php _e('login required', 'avatar-tcm'); ?></span>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if (has_post_thumbnail($avatar_tools_ac_id)) { ?>
					<figure class="col-sm-6 thumb">
						<a target="_blank" href="<?php echo esc_url(get_page_link($avatar_tools_ac_id)); ?>">
							<?php echo get_the_post_thumbnail($avatar_tools_ac_id, 'medium', ['class' => 'img-responsive']); ?>
						</a>
					</figure>
				<?php } ?>
				<div class="col-sm-6 text">
					<h3>
						<a target="_blank" class="text-content__link" href="<?php echo esc_url(get_page_link($avatar_tools_ac_id)); ?>">
							<?php echo get_the_title($avatar_tools_ac_id); ?>
						</a>
					</h3>
					<p><?php echo get_the_excerpt($avatar_tools_ac_id); ?></p>
					<a target="_blank" href="<?php echo esc_url(get_page_link($avatar_tools_ac_id)); ?>" class="btn user-form__btn-submit">
						<?php _e('Go to Advisor Central', 'avatar-tcm'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>