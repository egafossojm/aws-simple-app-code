<?php
$avatar_tools_cp_id = get_field('acf_tools_ce_place_link', 'option');
$avatar_tools_ceplace_login = get_field('acf_tools_ce_place_login_link', 'options');
if (! $avatar_tools_cp_id && ! $avatar_tools_ceplace_login) {
    return;
}

?>
<div class="row bloc ce">
	<div class="col-md-12">
		<h2 class="ce">
			<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>">
				<?php _e('CE Corner', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if (has_post_thumbnail($avatar_tools_cp_id)) { ?>
					<figure class="col-md-5 thumb">
						<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>">
							<?php echo get_the_post_thumbnail($avatar_tools_cp_id, 'medium', ['class' => 'img-responsive']); ?>
						</a>
					</figure>
				<?php } ?>
				<div class="col-md-7 text">
					<h3 class="top">
						<a target="_blank" class="text-content__link" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>">
							<?php echo get_the_title($avatar_tools_cp_id); ?>
						</a>
					</h3>
					<p><?php echo get_the_excerpt($avatar_tools_cp_id); ?></p>
					<a target="_blank" href="<?php echo get_page_link($avatar_tools_ceplace_login); ?>" class="btn user-form__btn-submit">
						<?php _e('Go to CE Corner', 'avatar-tcm'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>