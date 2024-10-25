<?php
function get_new_gtm_id()
{
    $new_gtm_id = 'NDQKHZN';
    if (get_locale() == 'fr_CA') {
        $new_gtm_id = 'NFMQX3J';
    }

    return $new_gtm_id;
}

/**
 * Include Google Tag Manager in hte header of website
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 * Add GTM id to Head
 * ============================================================*/

if (! function_exists('avatar_add_google_tag_manager_id_head')) {

    function avatar_add_google_tag_manager_id_head($avatar_gtm_id)
    {

        // if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
        // 	return;
        // }
        $avatar_gtm_id = get_field('acf_google_tag_manager_id', 'option') ? get_field('acf_google_tag_manager_id', 'option') : false;

        if (! $avatar_gtm_id) {
            return;
        } ?>


		<!-- Keep old GTM only for Bencan !-->
		<?php if (get_current_view_context() !== 'ava') { ?>
			<!-- Google Tag Manager (CURRENT/OLD) -->
			<script>
				(function(w, d, s, l, i) {
					w[l] = w[l] || [];
					w[l].push({
						'gtm.start': new Date().getTime(),
						event: 'gtm.js'
					});
					var f = d.getElementsByTagName(s)[0],
						j = d.createElement(s),
						dl = l != 'dataLayer' ? '&l=' + l : '';
					j.async = true;
					j.src =
						'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
					f.parentNode.insertBefore(j, f);
				})(window, document, 'script', 'dataLayer', '<?php echo esc_js($avatar_gtm_id); ?>');
			</script>
			<!-- End Google Tag Manager -->
		<?php
		} ?>

		<!-- Google Tag Manager (NEW) -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', 'GTM-<?= get_new_gtm_id(); ?>');
		</script>
		<!-- End Google Tag Manager -->

	<?php }
    add_action('wp_head', 'avatar_add_google_tag_manager_id_head');
}

/* -------------------------------------------------------------
 * Add GTM id to Body for nonscript
 * ============================================================*/

if (! function_exists('avatar_add_google_tag_manager_id_body')) {
    /**
     * @return HTML googletagmanager iframe
     */
    function avatar_add_google_tag_manager_id_body($avatar_gtm_id)
    {

        if (defined('WP_DEBUG') && true === WP_DEBUG) {
            return;
        }

        $avatar_gtm_id = get_field('acf_google_tag_manager_id', 'option') ? get_field('acf_google_tag_manager_id', 'option') : false;
        if (! $avatar_gtm_id) {
            return;
        } ?>

		<!-- Keep old GTM only for Bencan !-->
		<?php if (get_current_view_context() !== 'ava') { ?>
			<!-- Google Tag Manager (noscript) (CURRENT/OLD) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($avatar_gtm_id); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		<?php
		} ?>
		<!-- Google Tag Manager (noscript) (NEW) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-<?= get_new_gtm_id(); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
<?php }
    add_action('avatar_body', 'avatar_add_google_tag_manager_id_body');
}
