<?php /* To be displayed in Single.php | Variables are from article-gather-conditional-variables.php */ ?>

<?php
    if (isset($partner_banner['url'])) {
        $background = 'background-image:url('.$partner_banner['url'].')';
    } else {
        $background = "background-color:$partner_background";
    }
?>

<div class="entity-header entity-header--article-padB entity-row row microsite" style="<?php echo esc_html($background); ?>">
	<div>
		<div class="col-sm-2 col-xs-5 text-center">
			<?php if ($partner_logo) { ?>
				<?php if ($partner_link) { ?>
					<a target="_blank" href="<?php echo esc_url($partner_link); ?>">
						<figure class="entity-header__figure entity-header__figure--noRadius">
							<img class="entity-header__image" src="<?php echo esc_url($partner_logo['url']); ?>" alt="<?php echo esc_url($partner_name); ?>">
						</figure>
					</a>
				<?php } else { ?>
					<figure class="entity-header__figure entity-header__figure--noRadius">
						<img class="entity-header__image" src="<?php echo esc_url($partner_logo['url']); ?>" alt="<?php echo esc_url($partner_name); ?>">
					</figure>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="entity-header__landing-box entity-header__landing-box--negative-margin entity-header__landing-box--article col-sm-6 col-xs-7">
			<h2 class="entity-header__name <?php echo get_locale(); ?>">
					<?php echo esc_html($microsite_title); ?>
			</h2>
			<div class="entity-header__infos">
				<div class="entity-header__presentedBy">
					<?php echo esc_html($microsite_excerpt); ?>
				</div>	
				
			</div>
		</div>
		<div class="col-sm-4 col-xs-12 text-center-xs text-right-md">
			<div class="sponsor-title sponsor-title--article-feature">
				<a class="sponsor-title__link entity-header__link-article-more " href="<?php echo esc_url($microsite_link); ?> " >
					<?php _e('Visit website', 'avatar-tcm'); ?>
					<i class="sponsor-title__caret fa fa-caret-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</div> 