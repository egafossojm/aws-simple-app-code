<?php
/**
 * WPSEO Premium plugin file.
 */
if (! empty($redirect_file)) {
    switch ($redirect_file) {
        case 'apache_include_file':
            ?>
			<div class="notice notice-warning inline">
				<p>
					<?php esc_html_e("As you're on Apache, you should add the following include to the website httpd config file:", 'wordpress-seo-premium'); ?>
					<br><code>Include <?php echo esc_html($file_path); ?></code>
				</p>
			</div>
			<?php
            break;
        case 'cannot_write_htaccess':
            ?>
			<div class='notice notice-error inline'>
				<p>
					<?php
                    printf(
                        /* translators: %s: '.htaccess' file name. */
                        esc_html__("We're unable to save the redirects to your %s file. Please make the file writable.", 'wordpress-seo-premium'),
                        '<code>.htaccess</code>'
                    );
            ?>
				</p>
			</div>

			<?php
            break;
        case 'nginx_include_file':
            ?>
			<div class="notice notice-warning inline">
				<p>
					<?php esc_html_e("As you're on Nginx, you should add the following include to the Nginx config file:", 'wordpress-seo-premium'); ?>
					<br><code>include <?php echo esc_html($file_path); ?></code>
				</p>
			</div>
			<?php
            break;
        case 'cannot_write_file':
            ?>
			<div class='notice notice-error inline'>
				<p>
					<?php
                    printf(
                        /* translators: %s expands to the folder location where the redirects fill will be saved. */
                        esc_html__("We're unable to save the redirect file to %s", 'wordpress-seo-premium'),
                        esc_html($file_path)
                    );
            ?>
				</p>
			</div>
			<?php
            break;
    }
}
?>

<div id="table-settings" class="tab-url redirect-table-tab">
<?php echo '<h2>'.esc_html__('Redirects settings', 'wordpress-seo-premium').'</h2>'; ?>
	<form action="<?php echo esc_url(admin_url('options.php')); ?>" method="post">
		<?php
        settings_fields('yoast_wpseo_redirect_options');

$yform = Yoast_Form::get_instance();

$yform->set_option('wpseo_redirect');

$yoast_premium_toggle_values = [
    'off' => 'PHP',
    'on' => (WPSEO_Utils::is_apache()) ? '.htaccess' : __('Web server', 'wordpress-seo-premium'),
];
$yform->toggle_switch('disable_php_redirect', $yoast_premium_toggle_values, __('Redirect method', 'wordpress-seo-premium'));

if (WPSEO_Utils::is_apache()) {
    /* translators: 1: '.htaccess' file name */
    echo '<p>'.sprintf(esc_html__('Write redirects to the %1$s file. Make sure the %1$s file is writable.', 'wordpress-seo-premium'), '<code>.htaccess</code>').'</p>';

    $yform->light_switch('separate_file', __('Generate a separate redirect file', 'wordpress-seo-premium'));

    /* translators: %s: '.htaccess' file name */
    echo '<p>'.sprintf(esc_html__('By default we write the redirects to your %s file, check this if you want the redirects written to a separate file. Only check this option if you know what you are doing!', 'wordpress-seo-premium'), '<code>.htaccess</code>').'</p>';
} else {
    /* translators: %s: 'Yoast SEO Premium' */
    echo '<p>'.sprintf(esc_html__('%s can generate redirect files that can be included in your website web server configuration. If you choose this option the PHP redirects will be disabled. Only check this option if you know what you are doing!', 'wordpress-seo-premium'), 'Yoast SEO Premium').'</p>';
}
?>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes', 'wordpress-seo-premium'); ?>" />
		</p>
	</form>
</div>
