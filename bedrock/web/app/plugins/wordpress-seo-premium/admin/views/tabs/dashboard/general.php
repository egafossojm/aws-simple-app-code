<?php

if (! defined('WPSEO_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (WPSEO_Utils::is_api_available() && current_user_can(WPSEO_Configuration_Endpoint::CAPABILITY_RETRIEVE)) {
    echo '<h2>'.esc_html__('Configuration wizard', 'wordpress-seo').'</h2>';
    ?>
	<p>
		<?php
            /* translators: %1$s expands to Yoast SEO */
            printf(__('Need help determining your settings? Configure %1$s step-by-step.', 'wordpress-seo'), 'Yoast SEO');
    ?>
	</p>
<p>
	<a class="button"
		href="<?php echo esc_url(admin_url('admin.php?page='.WPSEO_Configuration_Page::PAGE_IDENTIFIER)); ?>"><?php esc_html_e('Open the configuration wizard', 'wordpress-seo'); ?></a>
</p>

	<br/>
<?php
}

/**
 * Action: 'wpseo_internal_linking' - Hook to add the internal linking analyze interface to the interface.
 */
do_action('wpseo_internal_linking');

echo '<h2>'.esc_html__('Credits', 'wordpress-seo').'</h2>';
?>
<p>
	<?php
        /* translators: %1$s expands to Yoast SEO */
        printf(__('Take a look at the people that create %1$s.', 'wordpress-seo'), 'Yoast SEO');
?>
</p>

<p>
	<a class="button"
		href="<?php echo esc_url(admin_url('admin.php?page='.WPSEO_Admin::PAGE_IDENTIFIER.'&intro=1')); ?>"><?php esc_html_e('View credits', 'wordpress-seo'); ?></a>
</p>
<br/>
<?php
echo '<h2>'.esc_html__('Restore default settings', 'wordpress-seo').'</h2>';
?>
<p>
	<?php
    /* translators: %s expands to Yoast SEO. */
    printf(__('If you want to restore a site to the default %s settings, press this button.', 'wordpress-seo'), 'Yoast SEO');
?>
</p>

<p>
	<a onclick="if ( !confirm( '<?php esc_html_e('Are you sure you want to reset your SEO settings?', 'wordpress-seo'); ?>' ) ) return false;"
		class="button"
		href="<?php echo esc_url(add_query_arg(['nonce' => wp_create_nonce('wpseo_reset_defaults')], admin_url('admin.php?page='.WPSEO_Admin::PAGE_IDENTIFIER.'&wpseo_reset_defaults=1'))); ?>"><?php esc_html_e('Restore default settings', 'wordpress-seo'); ?></a>
</p>
