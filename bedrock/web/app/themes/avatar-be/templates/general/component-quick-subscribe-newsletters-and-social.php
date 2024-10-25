<?php
/*
 * Location : Sitewide on  AD, AV, CO
 * Ebulletin-magazine and social links Component
 * Quick bulletin and magazine subscription links with social links.
 */
/* -------------------------------------------------------------
 * Get certain Info from theme Option (Footer tab)
 * ============================================================*/
$avatar_f_sn = get_field('acf_footer_sn', 'option');
$site_id = get_current_blog_id();
?>
<div class="col-sm-6 col-md-12 micro-module micro-module--left-alignment news-subscribe sponsor-bg">
	<div class="bloc">
		<div class="row head">
			<div class="col-md-12">
				<h2><?= get_locale() == 'fr_CA' ? 'Abonnez-vous' : 'Subscribe'; ?></h2>
			</div>
		</div>
		<div class="row subscriptions">

			<?php if (is_user_logged_in()) { //logged in
			    $newsletters_page = get_field('acf_profile_newsletters', 'option'); ?>
				<a class="btn btn-newsletter <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newsletters_page); ?>">
					<?php echo _e(($site_id == 5) || ($site_id == 7) ? 'Newsletters' : 'Bulletins', 'avatar-tcm'); ?>
				</a>
			<?php } else { //not logged in
			    $signin_page = get_field('acf_page_signin_newsletters', 'option'); ?>
				<a class="btn btn-newsletter <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($signin_page); ?>"><?php echo _e(($site_id == 5) || ($site_id == 7) ? 'Newsletters' : 'Bulletins', 'avatar-tcm'); ?></a>
			<?php } ?>
			<?php if (is_user_logged_in()) { //logged in
			    $newspaper_page = get_field('acf_profile_newspaper', 'option'); ?>
				<a class="btn btn-magazine <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newspaper_page); ?>"><?php echo _e('Magazine', 'avatar-tcm'); ?></a>
			<?php } else { //not logged in
			    $newpaper_signin_page = get_field('acf_footer_page_newspaper_login', 'option'); ?>
				<a class="btn btn-magazine <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($newpaper_signin_page); ?>"><?php echo _e('Magazine', 'avatar-tcm'); ?></a>
			<?php } ?>
			<?php if ($site_id == 7) {
			    $register_page = get_field('acf_page_signup', 'option'); ?>
				<a class="btn btn-flipbook <?= is_cir_section() ? 'cir-bg' : ''; ?>" href="<?php echo get_permalink($register_page); ?>"><?php echo _e('Flipbook', 'avatar-tcm'); ?></a>
			<?php } ?>
		</div>
		<div class="social">
			<h2><?= get_locale() == 'fr_CA' ? 'Connectez-vous' : 'Connect'; ?></h2>
			<?php
            if (is_cir_section()) {
                ?>
				<!-- <span class="component-quick-subscribe-newsletters__social-network-title"><?php //_e('Canadian Investment Review', 'avatar-tcm')
                                                                                                    ?></span> -->
				<ul>
					<?php while (has_sub_field('acf_footer_sn_cir', 'option')) { ?>
						<li>
							<a title="<?php esc_attr(the_sub_field('title')); ?>" class="footer-top-socials__link rightwidget-socials_link cir-color" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>"></a>
						</li>
					<?php } ?>
				</ul>
			<?php
            } else {
                ?>
				<!-- <span class="component-quick-subscribe-newsletters__social-network-title"><?php //_e('Benefits Canada', 'avatar-tcm')
                                                                                                    ?></span> -->
				<ul>
					<?php while (has_sub_field('acf_footer_sn_bencan', 'option')) { ?>
            <?php if (the_sub_field('title') && the_sub_field('url')) { ?>
              <li>
                <a title="<?php esc_attr(the_sub_field('title')); ?>" class="footer-top-socials__link rightwidget-socials_link" target="_blank" href="<?php esc_url(the_sub_field('url')); ?>"></a>
              </li>
            <?php } ?>
					<?php } ?>
				</ul>
			<?php
            }
?>
		</div>
	</div>
</div>

<?php
// Loading the Microsite Widget
// if(!is_single()) {
//todo mschmit - find way post_parent dont work and use it instead
global $post;
$parent_title = ! empty($post) ? get_the_title($post->post_parent) : null;
$arr_m32_vars = [
    'kv' => [
        'pos' => [
            'atf',
            'but1',
            'right_bigbox',
            'top_right_bigbox',
        ],
    ],
    'sizes' => '[ [300,250] ]',
    'sizeMapping' => '[ [[0,0], [[320,50]]], [[768,0], [[300,250]]], [[1024, 0], [[300,250]]] ]',
];

$arr_avt_vars = [
    'class' => 'bigbox text-center',
];
if (
    get_current_view_context() === 'bencan'
) {
    echo '<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">';
    at_get_the_m32banner(
        $arr_m32_vars,
        $arr_avt_vars
    );
    echo '</div>';
    avatar_include_template_conditionally('templates/microsite/component-microsite-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
    // The job posting block replaced the events block on bencan
    // include( locate_template( 'templates/events/component-events-block_bencan.php' ) );
    include locate_template('templates/job/component-job-block.php');
} elseif (get_current_view_context() === 'cir') {
    echo '<div class="bbox-wrap col-xs-12 col-sm-6 col-md-12 col-lg-12">';
    at_get_the_cir_m32banner(
        $arr_m32_vars,
        $arr_avt_vars
    );
    echo '</div>';
    avatar_include_template_conditionally('templates/cir/microsite/component-microsite-cir-block.php', 'SHOW_HOMEPAGE_MICROSITE_WIDGET');
    include locate_template('templates/events/component-events-block_cir.php');
}

// }
