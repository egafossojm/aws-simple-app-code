</div>
<!--footer-->
<?php
/* -------------------------------------------------------------
     * Get Info from theme Option (Footer tab)
     * ============================================================*/
$avatar_f_sn = get_field('acf_footer_sn', 'option');
$avatar_f_parner_site = get_field('acf_footer_parner_site', 'option');
$avatar_f_page_newsletter = is_user_logged_in() ? get_field('acf_footer_page_newsletter', 'option') : get_field('acf_footer_page_newsletter_login', 'option');
$avatar_f_page_newsletter_external_link = get_field('acf_footer_page_newsletter_external_link', 'option');
$avatar_f_page_account = is_user_logged_in() ? get_field('acf_footer_page_account', 'option') : get_field('acf_footer_page_account_login', 'option');
?>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12 leaderboard-fullwrap top-border">
				<?php
                if (! is_microsite($wp_query->post)) {

                    $arr_m32_vars = [
                        'kv' => [
                            'pos' => [
                                'btf',
                                'but1',
                                'bottom_leaderboard',
                            ],
                        ],
                        'sizes' => '[ [728,90], [970,250], [980,200] ]',
                        'sizeMapping' => '[ [[0,0], [[0,0]]], [[768,0], [[728,90]]], [[1024, 0], [[728,90],[970,250],[980,200]]] ]',

                    ];
                    $arr_avt_vars = [
                        'class' => 'leaderboard',
                    ];

                    if (empty($wp_query->post)) {
                        return;
                    }
                    get_correct_banner_ads(wp_get_post_categories($wp_query->post->ID), $site_id ??= get_current_blog_id(), $id, $wp_query, $arr_m32_vars, $arr_avt_vars);
                }
?>
			</div>
		</div>
	</div>
	<div class="footer-top">
		<div class="doct"></div>
		<div class="container full-sm">
			<div>
				<div class="row text-center">
					<div class="col-md-4 col-sm-12">
						<?php if ($avatar_f_page_newsletter_external_link) { ?>
							<a class="footer-top__link" href="<?php echo esc_url($avatar_f_page_newsletter_external_link); ?>" target="_blank">
								<?php _e('Newsletters', 'avatar-tcm'); ?>
							</a>

						<?php } elseif (is_int($avatar_f_page_newsletter)) { ?>
							<a class="footer-top__link" href="<?php echo esc_url(get_page_link($avatar_f_page_newsletter)); ?>">
								<?php echo get_the_title($avatar_f_page_newsletter); ?>
							</a>
						<?php } ?>
					</div>
					<div class="col-md-4 col-sm-12">

						<?php if (get_field('acf_footer_sn', 'option')) { ?>

							<dl class="social-icons footer-top-socials">
								<?php while (has_sub_field('acf_footer_sn', 'option')) { ?>
                  <?php if (the_sub_field('title') && the_sub_field('url')) { ?>
                    <dd class="footer-top-socials__description">
                      <a title="<?php esc_attr(the_sub_field('title')); ?>" class="footer-top-socials__link" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>"></a>
                    </dd>
                  <?php } ?>
								<?php } ?>
							</dl>

						<?php } ?>

					</div>
					<div class="col-md-4 col-sm-12">
						<?php if (is_int($avatar_f_page_account)) { ?>
							<a class="footer-top__link" href="<?php echo esc_url(get_page_link($avatar_f_page_account)); ?>">
								<?php echo get_the_title($avatar_f_page_account); ?>
							</a>
						<?php } ?>
					</div>
					<?php if (isset($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER']) && $_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] == 'true') { ?>
						<div class="col-md-4 col-sm-12" style="border-top: 2px solid #ccc;">
							<?php $events = get_permalink(93752);
					    $events_title = get_the_title(93752);
					    ?>
							<a class="footer-top__link" href="<?php echo esc_url($events); ?>">
								<?php if ($events_title) {
								    echo 'EVENTS';
								} ?>
							</a>
						</div>
						<div class="col-md-4 col-sm-12 " style="border-top: 2px solid #ccc;">
							<?php
                            $webinars = get_permalink(93777);
					    $webinars_title = get_the_title(93777);
					    ?>
							<a class="footer-top__link" href="<?php echo esc_url($webinars); ?>">
								<?php if ($webinars_title) {
								    echo strtoupper($webinars_title);
								} ?>
							</a>
						</div>
						<div class="col-md-4 col-sm-12 " style="border-top: 2px solid #ccc;">
							<?php
                            $awards = get_permalink(93221);
					    $awards_title = get_the_title(93221);
					    ?>
							<a class="footer-top__link" href="<?php echo esc_url($awards); ?>">
								<?php if ($awards_title) {
								    echo strtoupper($awards_title);
								} ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<!-- row parent-->
				<!--col 1-->
				<div class="col-md-8">
					<div class="row">
						<?php for ($i = 1; $i < 5; $i++) {
						    $col_class = 'col-md-3 col-xs-6'; ?>
							<div class="<?php echo esc_attr($col_class); ?>">
								<?php if (is_active_sidebar('footer_col_'.$i.'_row_1')) { ?>
									<?php dynamic_sidebar('footer_col_'.$i.'_row_1'); ?>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="row">
						<?php for ($i = 1; $i < 5; $i++) {
						    $col_class = 'col-md-3 col-xs-6'; ?>
							<div class="<?php echo esc_attr($col_class); ?>">
								<?php if (is_active_sidebar('footer_col_'.$i.'_row_2')) { ?>
									<?php dynamic_sidebar('footer_col_'.$i.'_row_2'); ?>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<!--col 2-->
				<div class="col-md-4">
					<div class="row row-newspaper">
						<?php
                        // Get acf_newspaper_page ID
                        $newspaper_page_id = get_field('acf_newspaper_page', 'options');
$acf_newspaper_subscription_url = get_field('acf_newspaper_subscription_url', 'option');

// Get the last Newspaper Date
$newspaper_args = [
    'post_type' => 'newspaper',
    'post_status' => 'publish',
    'posts_per_page' => 1,
];
$newspaper_obj = new WP_Query($newspaper_args);
$title = avatar_user_have_access() ? __('Current Issue', 'avatar-tcm') : __('Free Subscription', 'avatar-tcm');
// var_dump($newspaper_obj);
?>
						<?php if ($newspaper_page_id && ! empty($newspaper_obj->posts[0])) { ?>
							<ul id="menu-footer-newspaper">
								<li class="footer-newspaper-first-link">
									<a class="bloc-title__link" href="<?php the_permalink($newspaper_page_id); ?>"><?php echo get_the_title($newspaper_page_id); ?>
									</a>
								</li>
								<li class="footer-newspaper-image">
									<a href="<?php the_permalink($newspaper_page_id); ?>">
										<?php if ($newspaper_obj->posts[0]->ID) {
										    echo get_the_post_thumbnail($newspaper_obj->posts[0]->ID, 'thumbnail', ['class' => 'img-responsive']);
										} ?>
									</a>
								</li>
								<?php $site_id = get_current_blog_id();
						    if ($site_id == 5) { // Advisor ?
						        ?>
									<li class="btn btn-footer">
										<a href="<?php the_permalink($newspaper_page_id); ?>"><?php echo wp_kses_post(_e($title, 'avatar-tcm')); ?></a>
									</li>
								<?php } elseif ($site_id == 7 && ! empty($newspaper_page_id)) { // Benefits ?
								    ?>
									<li class="btn btn-footer">
										<a href="<?php the_permalink($newspaper_page_id); ?>"><?php echo wp_kses_post(__('Current Issue', 'avatar-tcm')); ?></a>
									</li>
								<?php } else { ?>
									<?php if ($acf_newspaper_subscription_url && ! empty($acf_newspaper_subscription_url && ! empty($title))) { ?>
										<li class="btn btn-footer">
											<a href="<?php echo $acf_newspaper_subscription_url; ?>" target="_blank"><?php echo wp_kses_post(__($title, 'avatar-tcm')); ?>
											</a>
										</li>
									<?php } else { ?>
										<li class="btn btn-footer">
											<a href="<?php the_permalink($newspaper_page_id); ?>"><?php echo wp_kses_post(_e($title, 'avatar-tcm')); ?>
											</a>
										</li>
									<?php } ?>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="row row-footer-more">
				<!--row2-->
				<div class="col-md-12">
					<div class="row">
						<?php if (get_field('acf_footer_parner_site', 'option')) { ?>

							<div class="menu-footer-more-container">
								<ul id="menu-footer-more" class="menu">
									<?php while (has_sub_field('acf_footer_parner_site', 'option')) { ?>
                    <?php if (the_sub_field('url')) { ?>
                      <li>
                        <a target="_blank" href="<?php esc_url(the_sub_field('url')); ?>">
                          <img alt="<?php esc_html(the_sub_field('title')); ?>" src="<?php esc_url(the_sub_field('logo')); ?>">
                        </a>
                      </li>
                    <?php } ?>
									<?php } ?>
								</ul>
							</div>

						<?php } ?>

						<?php if (is_active_sidebar('footer_more')) { ?>
							<?php //dynamic_sidebar( 'footer_more' );
                            ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="copyright__container container">
			<div class="rows">
				<div class="text-left col-md-8">
					<?php wp_nav_menu(['theme_location' => 'copyright']); ?>
					<?php if (is_active_sidebar('copyright_col_2')) { ?>
						<span class="copyright__text"><?php dynamic_sidebar('copyright_col_2'); ?></span>
						</p>

					<?php } ?>
				</div>
				<div class="copyright__infos-supp text-center col-md-4">
					<?php if (is_active_sidebar('copyright_col_1')) { ?>
						<?php dynamic_sidebar('copyright_col_1'); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</footer>
<?= get_linkedin_tags_url(); ?>
<?php if (get_current_view_context() == 'bencan') {
    ?>
	<?= get_twitter_pixel_code(); ?>
<?php
} ?>

<?= get_ofsys_bookmark_interceptor(); ?>
<?php wp_footer(); ?>

<script>
	const didomi_consent_choices_btn = document.querySelector(".didomi-consent-choices");
	if (didomi_consent_choices_btn) {
		didomi_consent_choices_btn.addEventListener("click", function(e) {
			e.preventDefault();
			if (Didomi) {
				Didomi.preferences.show();
			}
		});
	}
</script>
</body>

</html>
