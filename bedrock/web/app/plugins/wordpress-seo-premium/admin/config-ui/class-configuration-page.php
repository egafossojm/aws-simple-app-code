<?php
/**
 * WPSEO plugin file.
 */

/**
 * @class WPSEO_Configuration_Wizard Loads the Yoast configuration wizard.
 */
class WPSEO_Configuration_Page
{
    /**
     * @var string
     */
    const PAGE_IDENTIFIER = 'wpseo_configurator';

    /**
     * Sets the hooks when the user has enough rights and is on the right page.
     */
    public function set_hooks()
    {
        if (! ($this->is_config_page() && current_user_can(WPSEO_Configuration_Endpoint::CAPABILITY_RETRIEVE))) {
            return;
        }

        if ($this->should_add_notification()) {
            $this->add_notification();
        }

        // Register the page for the wizard.
        add_action('admin_menu', [$this, 'add_wizard_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_init', [$this, 'render_wizard_page']);
    }

    /**
     * Check if the configuration is finished. If so, just remove the notification.
     */
    public function catch_configuration_request()
    {
        $configuration_page = filter_input(INPUT_GET, 'configuration');
        $page = filter_input(INPUT_GET, 'page');

        if (! ($configuration_page === 'finished' && ($page === WPSEO_Admin::PAGE_IDENTIFIER))) {
            return;
        }

        $this->remove_notification();
        $this->remove_notification_option();

        wp_redirect(admin_url('admin.php?page='.WPSEO_Admin::PAGE_IDENTIFIER));
        exit;
    }

    /**
     *  Registers the page for the wizard.
     */
    public function add_wizard_page()
    {
        add_dashboard_page('', '', 'wpseo_manage_options', self::PAGE_IDENTIFIER, '');
    }

    /**
     * Renders the wizard page and exits to prevent the WordPress UI from loading.
     */
    public function render_wizard_page()
    {
        $this->show_wizard();
        exit;
    }

    /**
     * Enqueues the assets needed for the wizard.
     */
    public function enqueue_assets()
    {
        wp_enqueue_media();

        if (! wp_script_is('wp-element', 'registered') && function_exists('gutenberg_register_scripts_and_styles')) {
            gutenberg_register_scripts_and_styles();
        }

        /*
         * Print the `forms.css` WP stylesheet before any Yoast style, this way
         * it's easier to override selectors with the same specificity later.
         */
        wp_enqueue_style('forms');
        $asset_manager = new WPSEO_Admin_Asset_Manager;
        $asset_manager->register_wp_assets();
        $asset_manager->register_assets();
        $asset_manager->enqueue_script('configuration-wizard');
        $asset_manager->enqueue_style('yoast-components');

        $config = $this->get_config();

        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'configuration-wizard', 'yoastWizardConfig', $config);

        $yoast_components_l10n = new WPSEO_Admin_Asset_Yoast_Components_L10n;
        $yoast_components_l10n->localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'configuration-wizard');
    }

    /**
     * Setup Wizard Header.
     */
    public function show_wizard()
    {
        $this->enqueue_assets();
        $dashboard_url = admin_url('/admin.php?page=wpseo_dashboard');
        $wizard_title = sprintf(
            /* translators: %s expands to Yoast SEO. */
            __('%s &rsaquo; Configuration Wizard', 'wordpress-seo'),
            'Yoast SEO'
        );
        ?>
		<!DOCTYPE html>
		<!--[if IE 9]>
		<html class="ie9" <?php language_attributes(); ?> >
		<![endif]-->
		<!--[if !(IE 9) ]><!-->
		<html <?php language_attributes(); ?>>
		<!--<![endif]-->
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<title><?php echo esc_html($wizard_title); ?></title>
			<?php
            wp_print_head_scripts();
        wp_print_styles('yoast-seo-yoast-components');

        /**
         * Is called before the closing </head> tag in the Yoast Configuration wizard.
         *
         * Allows users to add their own scripts or styles.
         *
         * @since 4.0
         */
        do_action('wpseo_configuration_wizard_head');
        ?>
		</head>
		<body class="wp-admin wp-core-ui">
		<div id="wizard"></div>
		<div role="contentinfo" class="yoast-wizard-return-link-container">
			<a class="button yoast-wizard-return-link" href="<?php echo esc_url($dashboard_url); ?>">
				<span aria-hidden="true" class="dashicons dashicons-no"></span>
				<?php
            esc_html_e('Close the Wizard', 'wordpress-seo');
        ?>
			</a>
		</div>
		<?php
            wp_print_media_templates();
        wp_print_footer_scripts();

        /**
         * Is called before the closing </body> tag in the Yoast Configuration wizard.
         *
         * Allows users to add their own scripts.
         *
         * @since 4.0
         */
        do_action('wpseo_configuration_wizard_footer');

        wp_print_scripts('yoast-seo-configuration-wizard');
        ?>
		</body>
		</html>
		<?php
    }

    /**
     * Get the API config for the wizard.
     *
     * @return array The API endpoint config.
     */
    public function get_config()
    {
        $service = new WPSEO_GSC_Service;
        $config = [
            'namespace' => WPSEO_Configuration_Endpoint::REST_NAMESPACE,
            'endpoint_retrieve' => WPSEO_Configuration_Endpoint::ENDPOINT_RETRIEVE,
            'endpoint_store' => WPSEO_Configuration_Endpoint::ENDPOINT_STORE,
            'nonce' => wp_create_nonce('wp_rest'),
            'root' => esc_url_raw(rest_url()),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'finishUrl' => admin_url('admin.php?page=wpseo_dashboard&configuration=finished'),
            'gscAuthURL' => $service->get_client()->createAuthUrl(),
            'gscProfiles' => $service->get_sites(),
            'gscNonce' => wp_create_nonce('wpseo-gsc-ajax-security'),
        ];

        return $config;
    }

    /**
     * Checks if the current page is the configuration page.
     *
     * @return bool
     */
    protected function is_config_page()
    {
        return  filter_input(INPUT_GET, 'page') === self::PAGE_IDENTIFIER;
    }

    /**
     * Adds a notification to the notification center.
     */
    private function add_notification()
    {
        $notification_center = Yoast_Notification_Center::get();
        $notification_center->add_notification(self::get_notification());
    }

    /**
     * Removes the notification from the notification center.
     */
    private function remove_notification()
    {
        $notification_center = Yoast_Notification_Center::get();
        $notification_center->remove_notification(self::get_notification());
    }

    /**
     * Gets the notification.
     *
     * @return Yoast_Notification
     */
    private static function get_notification()
    {
        $message = __('The configuration wizard helps you to easily configure your site to have the optimal SEO settings.', 'wordpress-seo');
        $message .= '<br/>';
        $message .= sprintf(
            /* translators: %1$s resolves to Yoast SEO, %2$s resolves to the starting tag of the link to the wizard, %3$s resolves to the closing link tag */
            __('We have detected that you have not finished this wizard yet, so we recommend you to %2$sstart the configuration wizard to configure %1$s%3$s.', 'wordpress-seo'),
            'Yoast SEO',
            '<a href="'.admin_url('?page='.self::PAGE_IDENTIFIER).'">',
            '</a>'
        );

        $notification = new Yoast_Notification(
            $message,
            [
                'type' => Yoast_Notification::WARNING,
                'id' => 'wpseo-dismiss-onboarding-notice',
                'capabilities' => 'wpseo_manage_options',
                'priority' => 0.8,
            ]
        );

        return $notification;
    }

    /**
     * When the notice should be shown.
     *
     * @return bool
     */
    private function should_add_notification()
    {
        return  WPSEO_Options::get('show_onboarding_notice') === true;
    }

    /**
     * Remove the options that triggers the notice for the configuration wizard.
     */
    private function remove_notification_option()
    {
        WPSEO_Options::set('show_onboarding_notice', false);
    }
}
