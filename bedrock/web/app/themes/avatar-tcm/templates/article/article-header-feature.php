<?php /* To be displayed in Single.php | Variables are from article-gather-conditional-variables.php */ ?>
<div class="entity-header entity-header--article-padB entity-row row">
	<div>
		<div class="col-sm-2 col-xs-5 text-center">
			<?php if ($sponsor_image) { ?>
				<?php if ($sponsor_website) { ?>
					<a target="_blank" href="<?php echo esc_url($sponsor_website); ?>">
						<figure class="entity-header__figure entity-header__figure--article entity-header__figure--noRadius">
							<img class="entity-header__image" src="<?php echo esc_url($sponsor_image['url']); ?>" alt="<?php echo esc_url($sponsor_title); ?>">
						</figure>
					</a>
				<?php } else { ?>
					<figure class="entity-header__figure entity-header__figure--noRadius">
						<img class="entity-header__image" src="<?php echo esc_url($sponsor_image['url']); ?>" alt="<?php echo esc_url($sponsor_title); ?>">
					</figure>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="entity-header__landing-box entity-header__landing-box--negative-margin entity-header__landing-box--article col-sm-6 col-xs-7">
			<h2 class="entity-header__name <?php echo get_locale(); ?>">
				<a class="entity-header__link" href="<?php echo esc_url($sponsor_link); ?>">
					<?php echo esc_html($feature_title); ?>
				</a>
			</h2>
			<div class="entity-header__infos">
				<?php if ($sponsor_title) { ?>
					<div class="entity-header__presentedBy">
						<span class="entity-header__presentedBy-text">
							<?php _e('Presented by', 'avatar-tcm'); ?>
						<?php if ($sponsor_website) { ?>
							<a class="entity-title__link" target="_blank" href="<?php echo esc_url($sponsor_website); ?>">
								<?php echo esc_html($sponsor_title); ?>
							</a>
						<?php } else { ?>
							<?php echo esc_html($sponsor_title); ?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12 text-center-xs text-right-md">
			<div class="sponsor-title sponsor-title--article-feature">
				<a class="sponsor-title__link entity-header__link-article-more " href="<?php echo esc_url($sponsor_link); ?> " >
					<?php _e('More from this feature', 'avatar-tcm'); ?>
					<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</div> 