<?php
// Get the ID of a given category
$category_id = get_cat_ID('Advisor To Go');

// Get the URL of this category
$category_link = get_category_link($category_id);
$category_image = get_field('acf_category_image', get_category($category_id));

?>
<div class="row bloc">
	<div class="col-md-12">
		<h2 class="headphones">
			<a href="<?php echo esc_url($category_link); ?>">
				<?php _e('Advisor <i>ToGo</i> Podcasts', 'avatar-tcm'); ?>
				<i class="fa fa-caret-right bloc-title__caret" aria-hidden="true"></i>
			</a>
		</h2>
	</div>
	<div class="col-md-12">
		<div class="bg">
			<div class="row">
				<?php if ($category_image) { ?>
					<figure class="col-sm-6 thumb">
						<a href="<?php echo esc_url($category_link); ?>">
							<img src="<?php echo wp_get_attachment_image_url($category_image, $size = 'medium_large'); ?>" class="img-responsive" alt="">
						</a>
					</figure>
				<?php } ?>
				<div class="col-sm-6 text">
					<h3>
						<a class="text-content__link" href="<?php echo esc_url($category_link); ?>">
							<?php _e('Advisor <i>ToGo</i> Podcasts', 'avatar-tcm'); ?>
						</a>
					</h3>
					<p><?php echo category_description($category_id); ?></p>
					<a href="<?php echo esc_url($category_link); ?>" class="btn user-form__btn-submit">
						<?php _e('Click here', 'avatar-tcm'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>