<?php /* To be displayed in Single.php | Variables are from post-subheader-variables.php */ ?>
<div class="entity-header entity-header--article-padTB entity-row">
	<div>
		<div class="col-md-12 ">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<?php if (has_post_thumbnail($author_id)) { ?>
						<figure class="entity-figure">
							<a href="<?php echo esc_url($author_link); ?>">
								<img class="entity-header__image" src="<?php echo esc_url(get_the_post_thumbnail_url($author_id)); ?>">
							</a>
						</figure>
					<?php } ?>
					<div class="entity-title">
						<span class="entity-title__columnist-tag"><?php echo esc_html($columns->name); ?></span>
						<p class="entity-title__name">
							<a class="entity-title__link" href="<?php echo esc_url($author_link); ?>">
								<?php echo esc_html($author_name); ?>
							</a>
						</p>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12 text-center-xs text-right-md">
					<div class="sponsor-title">
						<a class="sponsor-title__link" href="<?php echo esc_url($author_link); ?>">
							<?php _e('More from this author', 'avatar-tcm'); ?>
							<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>