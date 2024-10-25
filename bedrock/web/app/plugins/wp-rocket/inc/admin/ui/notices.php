<?php
defined('ABSPATH') || exit('Cheatin&#8217; uh?');

/**
 * This warnings are displayed when the plugin can not be deactivated correctly
 *
 * @since 2.0.0
 */
function rocket_bad_deactivations()
{
    global $current_user;

    $msgs = get_transient($current_user->ID.'_donotdeactivaterocket');
    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options')) && $msgs) {

        delete_transient($current_user->ID.'_donotdeactivaterocket');
        $errors = [];

        foreach ($msgs as $msg) {
            switch ($msg) {
                case 'wpconfig':
                    $errors['wpconfig'] = '<p>'.sprintf(
                        // translators: %1$s WP Rocket plugin name; %2$s = file name.
                        __('<strong>%1$s</strong> has not been deactivated due to missing writing permissions.<br>
Make <strong>%2$s</strong> writeable and retry deactivation, or force deactivation now:', 'rocket'),
                        WP_ROCKET_PLUGIN_NAME,
                        'wp-config.php'
                    ).'</p>';
                    break;

                case 'htaccess':
                    $errors['htaccess'] = '<p>'.sprintf(
                        // translators: %1$s WP Rocket plugin name; %2$s = file name.
                        __('<strong>%1$s</strong> has not been deactivated due to missing writing permissions.<br>
Make <strong>%2$s</strong> writeable and retry deactivation, or force deactivation now:', 'rocket'),
                        WP_ROCKET_PLUGIN_NAME,
                        '.htaccess'
                    ).'</p>';
                    break;
            }

            /**
             * Filter the output messages for each bad deactivation attempt.
             *
             * @since 2.0.0
             *
             * @param  array  $errors  Contains the error messages to be filtered
             * @param  string  $msg  Contains the error type (wpconfig or htaccess)
             */
            $errors = apply_filters('rocket_bad_deactivations', $errors, $msg);

        }

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => implode('', $errors),
            'action' => 'force_deactivation',
        ]);
    }
}
add_action('admin_notices', 'rocket_bad_deactivations');

/**
 * This warning is displayed to inform the user that a plugin de/activation can be followed by a cache clear
 *
 * @since 1.3.0
 */
function rocket_warning_plugin_modification()
{
    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options')) && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        rocket_notice_html([
            'status' => 'warning',
            'dismissible' => '',
            // translators: %s is WP Rocket plugin name (maybe white label).
            'message' => sprintf(__('<strong>%s</strong>: One or more plugins have been enabled or disabled, clear the cache if they affect the front end of your site.', 'rocket'), WP_ROCKET_PLUGIN_NAME),
            'action' => 'clear_cache',
            'dismiss_button' => __FUNCTION__,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_plugin_modification');

/**
 * This warning is displayed when some plugins may conflict with WP Rocket
 *
 * @since 1.3.0
 */
function rocket_plugins_to_deactivate()
{
    $plugins_to_deactivate = [];

    // Deactivate all plugins who can cause conflicts with WP Rocket.
    $plugins = [
        'w3-total-cache' => 'w3-total-cache/w3-total-cache.php',
        'wp-super-cache' => 'wp-super-cache/wp-cache.php',
        'quick-cache' => 'quick-cache/quick-cache.php',
        'hyper-cache' => 'hyper-cache/plugin.php',
        'hyper-cache-extended' => 'hyper-cache-extended/plugin.php',
        'wp-fast-cache' => 'wp-fast-cache/wp-fast-cache.php',
        'flexicache' => 'flexicache/wp-plugin.php',
        'wp-fastest-cache' => 'wp-fastest-cache/wpFastestCache.php',
        'lite-cache' => 'lite-cache/plugin.php',
        'gator-cache' => 'gator-cache/gator-cache.php',
        'wp-http-compression' => 'wp-http-compression/wp-http-compression.php',
        'wordpress-gzip-compression' => 'wordpress-gzip-compression/ezgz.php',
        'gzip-ninja-speed-compression' => 'gzip-ninja-speed-compression/gzip-ninja-speed.php',
        'speed-booster-pack' => 'speed-booster-pack/speed-booster-pack.php',
        'wp-performance-score-booster' => 'wp-performance-score-booster/wp-performance-score-booster.php',
        'remove-query-strings-from-static-resources' => 'remove-query-strings-from-static-resources/remove-query-strings.php',
        'query-strings-remover' => 'query-strings-remover/query-strings-remover.php',
        'wp-ffpc' => 'wp-ffpc/wp-ffpc.php',
        'far-future-expiry-header' => 'far-future-expiry-header/far-future-expiration.php',
        'combine-css' => 'combine-css/combine-css.php',
        'super-static-cache' => 'super-static-cache/super-static-cache.php',
        'wpcompressor' => 'wpcompressor/wpcompressor.php',
        'check-and-enable-gzip-compression' => 'check-and-enable-gzip-compression/richards-toolbox.php',
        'leverage-browser-caching-ninjas' => 'leverage-browser-caching-ninjas/leverage-browser-caching-ninja.php',
        'force-gzip' => 'force-gzip/force-gzip.php',
    ];

    if (get_rocket_option('lazyload')) {
        $plugins['bj-lazy-load'] = 'bj-lazy-load/bj-lazy-load.php';
        $plugins['lazy-load'] = 'lazy-load/lazy-load.php';
        $plugins['jquery-image-lazy-loading'] = 'jquery-image-lazy-loading/jq_img_lazy_load.php';
        $plugins['advanced-lazy-load'] = 'advanced-lazy-load/advanced_lazyload.php';
        $plugins['crazy-lazy'] = 'crazy-lazy/crazy-lazy.php';
    }

    if (get_rocket_option('lazyload_iframes')) {
        $plugins['lazy-load-for-videos'] = 'lazy-load-for-videos/codeispoetry.php';
    }

    if (get_rocket_option('minify_css') || get_rocket_option('minify_js') || get_rocket_option('minify_html')) {
        $plugins['wp-super-minify'] = 'wp-super-minify/wp-super-minify.php';
        $plugins['bwp-minify'] = 'bwp-minify/bwp-minify.php';
        $plugins['wp-minify'] = 'wp-minify/wp-minify.php';
        $plugins['scripts-gzip'] = 'scripts-gzip/scripts_gzip.php';
        $plugins['minqueue'] = 'minqueue/plugin.php';
        $plugins['dependency-minification'] = 'dependency-minification/dependency-minification.php';
    }

    if (get_rocket_option('minify_css') || get_rocket_option('minify_js')) {
        $plugins['async-js-and-css'] = 'async-js-and-css/asyncJSandCSS.php';
    }

    if (get_rocket_option('minify_html')) {
        $plugins['wp-html-compression'] = 'wp-html-compression/wp-html-compression.php';
        $plugins['wp-compress-html'] = 'wp-compress-html/wp_compress_html.php';
    }

    if (get_rocket_option('minify_js')) {
        $plugins['wp-js'] = 'wp-js/wp-js.php';
        $plugins['combine-js'] = 'combine-js/combine-js.php';
        $plugins['footer-javascript'] = 'footer-javascript/footer-javascript.php';
        $plugins['scripts-to-footerphp'] = 'scripts-to-footerphp/scripts-to-footer.php';
    }

    if (get_rocket_option('do_cloudflare')) {
        $plugins['cloudflare'] = 'cloudflare/cloudflare.php';
    }

    /**
     * Filter the recommended plugins to deactivate to prevent conflicts
     *
     * @since 2.6.4
     *
     * @param  string  $plugins  List of recommended plugins to deactivate
     */
    $plugins = apply_filters('rocket_plugins_to_deactivate', $plugins);

    $plugins = array_filter($plugins, 'is_plugin_active');

    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && count($plugins)
        && rocket_valid_key()
    ) {

        // translators: %s is WP Rocket plugin name (maybe white label).
        $warning = '<p>'.sprintf(__('<strong>%s</strong>: The following plugins are not compatible with this plugin and may cause unexpected results:', 'rocket'), WP_ROCKET_PLUGIN_NAME).'</p>';

        $warning .= '<ul class="rocket-plugins-error">';

        foreach ($plugins as $plugin) {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.$plugin);
            $warning .= '<li>'.$plugin_data['Name'].'</span> <a href="'.wp_nonce_url(admin_url('admin-post.php?action=deactivate_plugin&plugin='.rawurlencode($plugin)), 'deactivate_plugin').'" class="button-secondary alignright">'.__('Deactivate', 'rocket').'</a></li>';
        }

        $warning .= '</ul>';

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $warning,
        ]);
    }
}
add_action('admin_notices', 'rocket_plugins_to_deactivate');

/**
 * This warning is displayed when there is no permalink structure in the configuration.
 *
 * @since 1.0
 */
function rocket_warning_using_permalinks()
{
    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && ! $GLOBALS['wp_rewrite']->using_permalinks()
        && rocket_valid_key()
    ) {
        $message = sprintf(
            /* translators: %1$s WP Rocket plugin name; %2$s = opening link; %3$s = closing link */
            __('%1$s: A custom permalink structure is required for the plugin to work properly. %2$sGo to permalinks settings%3$s', 'rocket'),
            '<strong>'.WP_ROCKET_PLUGIN_NAME.'</strong>',
            '<a href="'.admin_url('options-permalink.php').'">',
            '</a>'
        );

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_using_permalinks');

/**
 * This warning is displayed when the wp-config.php file isn't writable
 *
 * @since 2.0
 */
function rocket_warning_wp_config_permissions()
{
    $config_file = rocket_find_wpconfig_path();

    if (! ($GLOBALS['pagenow'] === 'plugins.php' && isset($_GET['activate']))
        // This filter is documented in inc/admin-bar.php.
        && current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable($config_file) && (! defined('WP_CACHE') || ! WP_CACHE))
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions('wp-config.php');

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
            'dismiss_button' => __FUNCTION__,
            'readonly_content' => '/** Enable Cache by '.WP_ROCKET_PLUGIN_NAME." */\r\ndefine( 'WP_CACHE', true );\r\n",
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_wp_config_permissions');

/**
 * This warning is displayed when the advanced-cache.php file isn't writeable
 *
 * @since 2.0
 */
function rocket_warning_advanced_cache_permissions()
{
    $advanced_cache_file = WP_CONTENT_DIR.'/advanced-cache.php';

    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && ! rocket_direct_filesystem()->is_writable($advanced_cache_file)
        && (! defined('WP_ROCKET_ADVANCED_CACHE') || ! WP_ROCKET_ADVANCED_CACHE)
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions(basename(WP_CONTENT_DIR).'/advanced-cache.php');

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
            'dismiss_button' => __FUNCTION__,
            'readonly_content' => get_rocket_advanced_cache_file(),
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_advanced_cache_permissions');

/**
 * This warning is displayed when the advanced-cache.php file isn't ours
 *
 * @since 2.2
 */
function rocket_warning_advanced_cache_not_ours()
{
    // This filter is documented in inc/admin-bar.php.
    if (! ($GLOBALS['pagenow'] === 'plugins.php' && isset($_GET['activate']))
        && current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && ! defined('WP_ROCKET_ADVANCED_CACHE')
        && (defined('WP_CACHE') && WP_CACHE)
        && get_rocket_option('version') === WP_ROCKET_VERSION
        && rocket_valid_key()) {

        $message = rocket_notice_writing_permissions(basename(WP_CONTENT_DIR).'/advanced-cache.php');

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_advanced_cache_not_ours');

/**
 * This warning is displayed when the .htaccess file doesn't exist or isn't writeable
 *
 * @since 1.0
 */
function rocket_warning_htaccess_permissions()
{
    global $is_apache;
    $htaccess_file = get_home_path().'.htaccess';

    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable($htaccess_file))
        && $is_apache
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions('.htaccess');

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
            'dismiss_button' => __FUNCTION__,
            'readonly_content' => get_rocket_htaccess_marker(),
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_htaccess_permissions');

/**
 * This warning is displayed when the config dir isn't writeable
 *
 * @since 2.0.2
 */
function rocket_warning_config_dir_permissions()
{
    /** This filter is documented in inc/admin-bar.php */
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable(WP_ROCKET_CONFIG_PATH))
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions(trim(str_replace(ABSPATH, '', WP_ROCKET_CONFIG_PATH), '/'));

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_config_dir_permissions');

/**
 * This warning is displayed when the cache dir isn't writeable
 *
 * @since 1.0
 */
function rocket_warning_cache_dir_permissions()
{
    /** This filter is documented in inc/admin-bar.php */
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable(WP_ROCKET_CACHE_PATH))
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions(trim(str_replace(ABSPATH, '', WP_ROCKET_CACHE_PATH), '/'));

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_cache_dir_permissions');

/**
 * This warning is displayed when the minify cache dir isn't writeable
 *
 * @since 2.1
 */
function rocket_warning_minify_cache_dir_permissions()
{
    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable(WP_ROCKET_MINIFY_CACHE_PATH))
        && (get_rocket_option('minify_css', false) || get_rocket_option('minify_js', false))
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions(trim(str_replace(ABSPATH, '', WP_ROCKET_MINIFY_CACHE_PATH), '/'));

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_minify_cache_dir_permissions');

/**
 * This warning is displayed when the busting cache dir isn't writeable
 *
 * @since 2.9
 *
 * @author Remy Perona
 */
function rocket_warning_busting_cache_dir_permissions()
{
    // This filter is documented in inc/admin-bar.php.
    if (current_user_can(apply_filters('rocket_capacity', 'manage_options'))
        && (! rocket_direct_filesystem()->is_writable(WP_ROCKET_CACHE_BUSTING_PATH))
        && (get_rocket_option('remove_query_strings', false))
        && rocket_valid_key()) {

        $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

        if (in_array(__FUNCTION__, (array) $boxes, true)) {
            return;
        }

        $message = rocket_notice_writing_permissions(trim(str_replace(ABSPATH, '', WP_ROCKET_CACHE_BUSTING_PATH), '/'));

        rocket_notice_html([
            'status' => 'error',
            'dismissible' => '',
            'message' => $message,
        ]);
    }
}
add_action('admin_notices', 'rocket_warning_busting_cache_dir_permissions');

/**
 * Confirming notice when the site has been added
 *
 * @since 2.2
 */
function rocket_thank_you_license()
{
    if (get_rocket_option('license') === '1') {
        $options = get_option(WP_ROCKET_SLUG);
        $options['license'] = time();
        $options['ignore'] = true;
        update_option(WP_ROCKET_SLUG, $options);

        $message = sprintf(
            /* translators: %1$s = plugin name, %2$s + %3$s = opening links, %4$s = closing link */
            __('%1$s is good to go! %2$sTest your load time%4$s, or visit your %3$ssettings%4$s.', 'rocket'),
            '<strong>'.WP_ROCKET_PLUGIN_NAME.'</strong>',
            '<a href="https://wp-rocket.me/blog/correctly-measure-websites-page-load-time/" target="_blank">',
            '<a href="'.admin_url('options-general.php?page='.WP_ROCKET_PLUGIN_SLUG).'">',
            '</a>'
        );

        rocket_notice_html(['message' => $message]);
    }
}
add_action('admin_notices', 'rocket_thank_you_license');

/**
 * Add a message about Imagify on the "Upload New Media" screen and WP Rocket options page.
 *
 * @since 2.7
 */
function rocket_imagify_notice()
{
    $current_screen = get_current_screen();

    // Add the notice only on the "WP Rocket" settings, "Media Library" & "Upload New Media" screens.
    if (current_filter() === 'admin_notices' && (isset($current_screen) && $current_screen->base !== 'settings_page_wprocket')) {
        return;
    }

    $boxes = get_user_meta($GLOBALS['current_user']->ID, 'rocket_boxes', true);

    if (defined('IMAGIFY_VERSION') || in_array(__FUNCTION__, (array) $boxes, true) || get_option('wp_rocket_dismiss_imagify_notice') === 1 || rocket_is_white_label() || ! current_user_can('manage_options')) {
        return;
    }

    $imagify_plugin = 'imagify/imagify.php';
    $is_imagify_installed = rocket_is_plugin_installed($imagify_plugin);

    $action_url = $is_imagify_installed ?
    rocket_get_plugin_activation_link($imagify_plugin)
        :
    wp_nonce_url(add_query_arg(
        [
            'action' => 'install-plugin',
            'plugin' => 'imagify',
        ],
        admin_url('update.php')
    ), 'install-plugin_imagify');

    $details_url = add_query_arg(
        [
            'tab' => 'plugin-information',
            'plugin' => 'imagify',
            'TB_iframe' => true,
            'width' => 722,
            'height' => 949,
        ],
        admin_url('plugin-install.php')
    );

    $classes = $is_imagify_installed ? '' : ' install-now';
    $cta_txt = $is_imagify_installed ? esc_html__('Activate Imagify', 'rocket') : esc_html__('Install Imagify for Free', 'rocket');

    $dismiss_url = wp_nonce_url(
        admin_url('admin-post.php?action=rocket_ignore&box='.__FUNCTION__),
        'rocket_ignore_'.__FUNCTION__
    );
    ?>

	<div id="plugin-filter" class="updated plugin-card plugin-card-imagify rkt-imagify-notice">
		<a href="<?php echo $dismiss_url; ?>" class="rkt-cross"><span class="dashicons dashicons-no"></span></a>

		<p class="rkt-imagify-logo">
			<img src="<?php echo WP_ROCKET_ADMIN_UI_IMG_URL; ?>logo-imagify.png" srcset="<?php echo WP_ROCKET_ADMIN_UI_IMG_URL; ?>logo-imagify.svg 2x" alt="Imagify" width="150" height="18">
		</p>
		<p class="rkt-imagify-msg">
			<?php _e('Speed up your website and boost your SEO by reducing image file sizes without losing quality with Imagify.', 'rocket'); ?>
		</p>
		<p class="rkt-imagify-cta">
			<a data-slug="imagify" href="<?php echo $action_url; ?>" class="button button-primary<?php echo $classes; ?>"><?php echo $cta_txt; ?></a>
			<?php if (! $is_imagify_installed) { ?>
			<br><a data-slug="imagify" data-name="Imagify Image Optimizer" class="thickbox open-plugin-details-modal" href="<?php echo $details_url; ?>"><?php _e('More details', 'rocket'); ?></a>
			<?php } ?>
		</p>
	</div>

	<?php
}
add_action('admin_notices', 'rocket_imagify_notice');

/**
 * This notice is displayed after purging the CloudFlare cache
 *
 * @since 2.9
 *
 * @author Remy Perona
 */
function rocket_cloudflare_purge_result()
{
    global $current_user;
    // This filter is documented in inc/admin-bar.php.
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if (! is_admin()) {
        return;
    }

    $notice = get_transient($current_user->ID.'_cloudflare_purge_result');
    if (! $notice) {
        return;
    }

    delete_transient($current_user->ID.'_cloudflare_purge_result');

    rocket_notice_html([
        'status' => $notice['result'],
        'message' => $notice['message'],
    ]);
}
add_action('admin_notices', 'rocket_cloudflare_purge_result');

/**
 * This notice is displayed after modifying the CloudFlare settings
 *
 * @since 2.9
 *
 * @author Remy Perona
 */
function rocket_cloudflare_update_settings()
{
    global $current_user;
    $screen = get_current_screen();
    $rocket_wl_name = get_rocket_option('wl_plugin_name', null);
    $wp_rocket_screen_id = isset($rocket_wl_name) ? 'settings_page_'.sanitize_key($rocket_wl_name) : 'settings_page_wprocket';
    // This filter is documented in inc/admin-bar.php.
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if ($screen->id !== $wp_rocket_screen_id) {
        return;
    }

    $notices = get_transient($current_user->ID.'_cloudflare_update_settings');
    if ($notices) {
        $errors = '';
        $success = '';
        delete_transient($current_user->ID.'_cloudflare_update_settings');
        foreach ($notices as $notice) {
            if ($notice['result'] === 'error') {
                $errors .= $notice['message'].'<br>';
            } elseif ($notice['result'] === 'success') {
                $success .= $notice['message'].'<br>';
            }
        }

        if (! empty($success)) {
            rocket_notice_html([
                'message' => $success,
            ]);
        }

        if (! empty($errors)) {
            rocket_notice_html([
                'status' => 'error',
                'message' => $success,
            ]);
        }
    }
}
add_action('admin_notices', 'rocket_cloudflare_update_settings');

/**
 * Displays a notice for analytics opt-in
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_analytics_optin_notice()
{
    if (rocket_is_white_label()) {
        return;
    }

    $screen = get_current_screen();
    $rocket_wl_name = get_rocket_option('wl_plugin_name', null);
    $wp_rocket_screen_id = isset($rocket_wl_name) ? 'settings_page_'.sanitize_key($rocket_wl_name) : 'settings_page_wprocket';
    // This filter is documented in inc/admin-bar.php.
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if ($screen->id !== $wp_rocket_screen_id) {
        return;
    }

    if ((int) get_option('rocket_analytics_notice_displayed') === 1) {
        return;
    }

    if (get_rocket_option('analytics_enabled')) {
        return;
    }

    $analytics_notice = sprintf(
        // Opening <p> provided by rocket_notice_html().
        '<strong>%1$s</strong><br>%2$s</p>',
        __('Would you allow WP Rocket to collect non-sensitive diagnostic data from this website?', 'rocket'),
        __('This would help us to improve WP Rocket for you in the future.', 'rocket')
    );

    $analytics_notice .= sprintf(
        '<p><button class="hide-if-no-js button-rocket-reveal rocket-preview-analytics-data">%s</button></p>',
        /* translators: button text, click will expand data collection preview */
        __('What info will we collect?', 'rocket')
    );

    $analytics_notice .= sprintf(
        '<div class="rocket-analytics-data-container"><p class="description">%1$s</p>%2$s</div>',
        __('Below is a detailed view of all data WP Rocket will collect if granted permission. WP Rocket will never transmit any domain names or email addresses (except for license validation), IP addresses, or third-party API keys.', 'rocket'),
        rocket_data_collection_preview_table()
    );

    $analytics_notice .= sprintf(
        '<p><a href="%1$s" class="button button-primary">%2$s</a> <a href="%3$s" class="button button-secondary">%4$s</a>',
        // Closing </p> provided by rocket_notice_html().
        wp_nonce_url(admin_url('admin-post.php?action=rocket_analytics_optin&value=yes'), 'analytics_optin'),
        /* translators: button text for data collection opt-in */
        __('Yes, allow', 'rocket'),
        wp_nonce_url(admin_url('admin-post.php?action=rocket_analytics_optin&value=no'), 'analytics_optin'),
        /* translators: button text for data collection opt-in */
        __('No, thanks', 'rocket')
    );

    // Status should be as neutral as possible; nothing has happened yet.
    rocket_notice_html([
        'status' => 'info',
        'message' => $analytics_notice,
    ]);
}
add_action('admin_notices', 'rocket_analytics_optin_notice');

/**
 * Displays a notice after analytics opt-in
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_analytics_optin_thankyou_notice()
{
    if (rocket_is_white_label()) {
        return;
    }

    $screen = get_current_screen();
    $rocket_wl_name = get_rocket_option('wl_plugin_name', null);
    $wp_rocket_screen_id = isset($rocket_wl_name) ? 'settings_page_'.sanitize_key($rocket_wl_name) : 'settings_page_wprocket';
    // This filter is documented in inc/admin-bar.php.
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if ($screen->id !== $wp_rocket_screen_id) {
        return;
    }

    $analytics_optin = get_transient('rocket_analytics_optin');

    if (! $analytics_optin) {
        return;
    }

    $thankyou_message = sprintf(
        // Opening <p> provided by rocket_notice_html().
        '<strong>%s</strong></p>',
        __('Thank you!', 'rocket')
    );

    $thankyou_message .= sprintf(
        '<p>%1$s</p><div>%2$s</div>',
        __('WP Rocket now collects these metrics from your website:', 'rocket'),
        rocket_data_collection_preview_table()
    );

    // Closing </p> provided by rocket_notice_html().
    $thankyou_message .= '<p>';

    rocket_notice_html([
        'message' => $thankyou_message,
    ]);

    delete_transient('rocket_analytics_optin');
}
add_action('admin_notices', 'rocket_analytics_optin_thankyou_notice');

/**
 * Displays a notice after clearing the cache
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_clear_cache_notice()
{
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    $cleared_cache = get_transient('rocket_clear_cache');

    if (! $cleared_cache) {
        return;
    }

    delete_transient('rocket_clear_cache');

    $formatted_plugin_name = '<strong>'.WP_ROCKET_PLUGIN_NAME.'</strong>';

    switch ($cleared_cache) {
        case 'all':
            /* translators: %s = plugin name (maybe white-labelled) */
            $notice = sprintf(__('%s: Cache cleared.', 'rocket'), $formatted_plugin_name);
            break;
        case 'post':
            $notice = sprintf(__('%s: Post cache cleared.', 'rocket'), $formatted_plugin_name);
            break;
        case 'term':
            $notice = sprintf(__('%s: Term cache cleared.', 'rocket'), $formatted_plugin_name);
            break;
        case 'user':
            $notice = sprintf(__('%s: User cache cleared.', 'rocket'), $formatted_plugin_name);
            break;
        default:
            $notice = '';
            break;
    }

    if (empty($notice)) {
        return;
    }

    rocket_notice_html([
        'message' => $notice,
    ]);
}
add_action('admin_notices', 'rocket_clear_cache_notice');

/**
 * This notice is displayed when the sitemap preload is running
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_sitemap_preload_running()
{
    $screen = get_current_screen();
    $rocket_wl_name = get_rocket_option('wl_plugin_name', null);
    $wp_rocket_screen_id = isset($rocket_wl_name) ? 'settings_page_'.sanitize_key($rocket_wl_name) : 'settings_page_wprocket';
    // This filter is documented in inc/admin-bar.php.
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if ($screen->id !== $wp_rocket_screen_id) {
        return;
    }

    $running = get_transient('rocket_sitemap_preload_running');
    if ($running === false) {
        return;
    }

    rocket_notice_html([
        'message' => sprintf(__('Sitemap preload: %d uncached pages have now been preloaded. (refresh to see progress)', 'rocket'), $running),
    ]);
}
add_action('admin_notices', 'rocket_sitemap_preload_running');

/**
 * This notice is displayed after the sitemap preload is complete
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_sitemap_preload_complete()
{
    global $current_user;
    $screen = get_current_screen();
    $rocket_wl_name = get_rocket_option('wl_plugin_name', null);
    $wp_rocket_screen_id = isset($rocket_wl_name) ? 'settings_page_'.sanitize_key($rocket_wl_name) : 'settings_page_wprocket';
    /** This filter is documented in inc/admin-bar.php */
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }

    if ($screen->id !== $wp_rocket_screen_id) {
        return;
    }

    $result = get_transient('rocket_sitemap_preload_complete');
    if ($result === false) {
        return;
    }

    delete_transient('rocket_sitemap_preload_complete');

    rocket_notice_html([
        // translators: %d is the number of pages preloaded.
        'message' => sprintf(__('Sitemap preload: %d pages have been cached.', 'rocket'), $result),
    ]);
}
add_action('admin_notices', 'rocket_sitemap_preload_complete');

/**
 * Warns if PHP version is less than 5.3 and offers to rollback.
 *
 * @since 2.11
 *
 * @author Remy Perona
 */
function rocket_php_warning()
{
    if (version_compare(PHP_VERSION, '5.3') >= 0) {
        return;
    }
    /** This filter is documented in inc/admin-bar.php */
    if (! current_user_can(apply_filters('rocket_capacity', 'manage_options'))) {
        return;
    }
    // Translators: %1$s = Plugin name, %2$s = Plugin version, %3$s = PHP version required.
    echo '<div class="notice notice-error"><p>'.sprintf(__('%1$s %2$s requires at least PHP %3$s to function properly. To use this version, please ask your web host how to upgrade your server to PHP %3$s or higher. If you are not able to upgrade, you can rollback to the previous version by using the button below.', 'rocket'), WP_ROCKET_PLUGIN_NAME, WP_ROCKET_VERSION, '5.3').'</p>
	<p><a href="'.wp_nonce_url(admin_url('admin-post.php?action=rocket_rollback'), 'rocket_rollback').'" class="button">'.
    // Translators: %s = Previous plugin version.
    sprintf(__('Re-install version %s', 'rocket'), WP_ROCKET_LASTVERSION)
    .'</a></p></div>';
}
add_action('admin_notices', 'rocket_php_warning');

/**
 * Outputs notice HTML
 *
 * @since 2.11
 *
 * @author Remy Perona
 *
 * @param  array  $args  An array of arguments used to determine the notice output.
 * @return void
 */
function rocket_notice_html($args)
{
    $defaults = [
        'status' => 'success',
        'dismissible' => 'is-dismissible',
        'message' => '',
        'action' => '',
        'dismiss_button' => false,
        'readonly_content' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    switch ($args['action']) {
        case 'clear_cache':
            $args['action'] = '<a class="wp-core-ui button" href="'.wp_nonce_url(admin_url('admin-post.php?action=purge_cache&type=all'), 'purge_cache_all').'">'.__('Clear cache', 'rocket').'</a>';
            break;
        case 'force_deactivation':
            /**
             * Allow a "force deactivation" link to be printed, use at your own risks
             *
             * @since 2.0.0
             *
             * @param  bool  $permit_force_deactivation  true will print the link.
             */
            $permit_force_deactivation = apply_filters('rocket_permit_force_deactivation', true);

            // We add a link to permit "force deactivation", use at your own risks.
            if ($permit_force_deactivation) {
                global $status, $page, $s;
                $plugin_file = 'wp-rocket/wp-rocket.php';
                $rocket_nonce = wp_create_nonce('force_deactivation');

                $args['action'] = '<a href="'.wp_nonce_url('plugins.php?action=deactivate&amp;rocket_nonce='.$rocket_nonce.'&amp;plugin='.$plugin_file.'&amp;plugin_status='.$status.'&amp;paged='.$page.'&amp;s='.$s, 'deactivate-plugin_'.$plugin_file).'">'.__('Force deactivation ', 'rocket').'</a>';
            }
            break;
    }

    ?>
	<div class="notice notice-<?php echo $args['status']; ?> <?php echo $args['dismissible']; ?>">
		<?php
            $tag = strpos($args['message'], '<p') !== 0 && strpos($args['message'], '<ul') !== 0;

    echo ($tag ? '<p>' : '').$args['message'].($tag ? '</p>' : '');
    ?>
		<?php if (! empty($args['readonly_content'])) { ?>
		<p><?php _e('The following code should have been written to this file:', 'rocket'); ?>:
			<br><textarea readonly="readonly" id="rules" name="rules" class="large-text readonly" rows="6"><?php echo esc_textarea($args['readonly_content']); ?></textarea>
		</p>
		<?php
		}
    if ($args['action'] || $args['dismiss_button']) {
        ?>
		<p>
			<?php echo $args['action']; ?>
			<?php if ($args['dismiss_button']) { ?>
			<a class="rocket-dismiss" href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=rocket_ignore&box='.$args['dismiss_button']), 'rocket_ignore_'.$args['dismiss_button']); ?>"><?php _e('Dismiss this notice.', 'rocket'); ?></a>
			<?php } ?>
		</p>
		<?php } ?>
	</div>
	<?php
}

/**
 * Outputs formatted notice about issues with writing permissions
 *
 * @since  2.11
 *
 * @author Caspar Hübinger
 *
 * @param  string  $file  File or folder name.
 * @return string Message HTML
 */
function rocket_notice_writing_permissions($file)
{

    $message = sprintf(
        /* translators: %s = plugin name (maybe white labelled) */
        __('%s cannot configure itself due to missing writing permissions.', 'rocket'),
        '<strong>'.WP_ROCKET_PLUGIN_NAME.'</strong>'
    );

    $message .= '<br>'.sprintf(
        /* translators: %s = file/folder name */
        __('Affected file/folder: %s', 'rocket'),
        '<code>'.$file.'</code>'
    );

    if (! rocket_is_white_label()) {
        $message .= '<br>'.sprintf(
            /* translators: This is a doc title! %1$s = opening link; %2$s = closing link */
            __('Troubleshoot: %1$sHow to make system files writeable%2$s', 'rocket'),
            /* translators: Documentation exists in EN, DE, FR, ES, IT; use loaclised URL if applicable */
            '<a href="'.__('http://docs.wp-rocket.me/article/626-how-to-make-system-files-htaccess-wp-config-writeable', 'rocket').'" target="_blank">',
            '</a>'
        );
    }

    return $message;
}
