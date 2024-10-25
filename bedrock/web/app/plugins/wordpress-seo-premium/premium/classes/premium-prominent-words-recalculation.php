<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Handles adding site wide analysis UI to the WordPress admin.
 */
class WPSEO_Premium_Prominent_Words_Recalculation implements WPSEO_WordPress_Integration
{
    /**
     * Base height of the recalculation modal in pixels.
     *
     * @var int
     */
    const MODAL_DIALOG_HEIGHT_BASE = 150;

    /**
     * Height of the recalculation progressbar in pixels.
     *
     * @var int
     */
    const PROGRESS_BAR_HEIGHT = 32;

    /**
     * Instance of the WPSEO_Premium_Prominent_Words_Unindexed_Post_Query class.
     *
     * @var WPSEO_Premium_Prominent_Words_Unindexed_Post_Query
     */
    protected $post_query;

    /**
     * Instance of the WPSEO_Premium_Prominent_Words_Support class.
     *
     * @var WPSEO_Premium_Prominent_Words_Support
     */
    private $prominent_words_support;

    /**
     * WPSEO_Premium_Prominent_Words_Recalculation constructor.
     *
     * @param  WPSEO_Premium_Prominent_Words_Unindexed_Post_Query  $post_query  The post query class to retrieve the unindexed posts with.
     * @param  WPSEO_Premium_Prominent_Words_Support  $prominent_words_support  The prominent words support class to determine supported posts types to index.
     */
    public function __construct(WPSEO_Premium_Prominent_Words_Unindexed_Post_Query $post_query, WPSEO_Premium_Prominent_Words_Support $prominent_words_support)
    {
        $this->post_query = $post_query;
        $this->prominent_words_support = $prominent_words_support;
    }

    /**
     * Registers all hooks to WordPress.
     *
     * @return void
     */
    public function register_hooks()
    {
        // When the language isn't supported, stop adding hooks.
        $language_support = new WPSEO_Premium_Prominent_Words_Language_Support;

        if (! $language_support->is_language_supported(WPSEO_Language_Utils::get_language(get_locale()))) {
            return;
        }

        add_action('wpseo_tools_overview_list_items', [$this, 'show_tools_overview_item'], 11);

        add_action('admin_enqueue_scripts', [$this, 'enqueue']);

        if ($this->is_modal_page()) {
            add_action('admin_footer', [$this, 'modal_box'], 20);
        }
    }

    /**
     * Adds an item on the tools page list.
     *
     * @return void
     */
    public function show_tools_overview_item()
    {
        $total_items = $this->post_query->get_totals($this->get_post_types());

        echo '<li>';
        echo '<strong>'.esc_html__('Internal linking', 'wordpress-seo-premium').'</strong><br/>';

        if (count($total_items) === 0) {
            // phpcs:ignore WordPress.Security.EscapeOutput -- Correctly escaped in message_already_indexed() method.
            echo $this->message_already_indexed();
        }

        if (count($total_items) > 0) {
            // phpcs:ignore WordPress.Security.EscapeOutput -- Correctly escaped in generate_internal_link_calculation_interface() method.
            echo $this->generate_internal_link_calculation_interface();
        }

        echo '</li>';
    }

    /**
     * Renders the HTML for the internal linking interface.
     *
     * @return void
     */
    public function add_internal_linking_interface()
    {
        $total_items = $this->post_query->get_totals($this->get_post_types());

        echo '<h2>'.esc_html__('Internal linking', 'wordpress-seo-premium').'</h2>';
        echo '<p>'.esc_html__('Want to use our internal linking tool? Analyze all the published posts, pages and custom post types to generate internal linking suggestions.', 'wordpress-seo-premium').'</p>';

        if (count($total_items) === 0) {
            // phpcs:ignore WordPress.Security.EscapeOutput -- Correctly escaped in message_already_indexed() method.
            printf('<p>%s</p><br>', $this->message_already_indexed());

            return;
        }

        // phpcs:ignore WordPress.Security.EscapeOutput -- Correctly escaped in generate_internal_link_calculation_interface() method.
        echo $this->generate_internal_link_calculation_interface();
    }

    /**
     * Takes an array of post types and converts it to a textual list of post types.
     *
     * @param  array  $post_types  The post types to retrieve the labels for.
     * @return array A list of post type labels for the supplied post types.
     */
    protected function get_indexable_post_type_labels($post_types)
    {
        if (! is_array($post_types)) {
            return [];
        }

        return array_map([$this, 'retrieve_post_type_label'], $post_types);
    }

    /**
     * Retrieves the label for the passed post type.
     *
     * @param  string  $post_type  The post type to retrieve the label for.
     * @return string The post type's label. Defaults to the post type itself if no label could be retrieved.
     */
    protected function retrieve_post_type_label($post_type)
    {
        $post_type_object = get_post_type_object($post_type);

        if (is_null($post_type_object)) {
            return $post_type;
        }

        return $post_type_object->labels->name;
    }

    /**
     * Generates the HTML interface for the recalculation.
     *
     * @return string The HTML representation of the interface.
     */
    protected function generate_internal_link_calculation_interface()
    {
        return sprintf(
            '<span id="internalLinksCalculation"><a id="openInternalLinksCalculation" href="%s" title="%s" class="%s">%s</a></span>',
            esc_url('#TB_inline?width=600&height='.(self::MODAL_DIALOG_HEIGHT_BASE + self::PROGRESS_BAR_HEIGHT).'&inlineId=wpseo_recalculate_internal_links_wrapper'),
            esc_attr__('Generate internal linking suggestions', 'wordpress-seo-premium'),
            esc_attr('btn button yoast-js-calculate-prominent-words yoast-js-calculate-prominent-words--all thickbox'),
            esc_html__('Analyze your content', 'wordpress-seo-premium')
        );
    }

    /**
     * Initialize the modal box to be displayed when needed.
     *
     * @return void
     */
    public function modal_box()
    {
        // Adding the thickbox.
        add_thickbox();

        $supported_post_types = $this->get_post_types();
        $total_items = $this->post_query->get_totals($supported_post_types);
        $supported_post_type_labels = $this->get_indexable_post_type_labels($supported_post_types);

        $progress = sprintf(
            /* translators: 1: expands to a <span> containing the number of items recalculated. 2: expands to a <strong> containing the total number of items. */
            esc_html__('Item %1$s of %2$s analyzed.', 'wordpress-seo-premium'),
            '<span id="wpseo_count_items" class="wpseo-prominent-words-progress-current">0</span>',
            '<strong id="wpseo_count_items_total" class="wpseo-prominent-words-progress-total">'.array_sum($total_items).'</strong>'
        );

        ?>
		<div id="wpseo_recalculate_internal_links_wrapper" class="hidden">
			<div id="wpseo_recalculate_internal_links">
				<p>
					<?php

                    printf(
                        /* translators: 1: expands to a list of supported post type labels that are being recalculated. */
                        esc_html__('Generating suggestions for %1$s...', 'wordpress-seo-premium'),
                        esc_html(implode(', ', $supported_post_type_labels))
                    );

        ?>
				</p>
				<?php if ($total_items > 0) { ?>
					<div id="wpseo_internal_links_unindexed_progressbar" class="wpseo-progressbar"></div>
					<p><?php echo $progress; // phpcs:ignore WordPress.Security.EscapeOutput -- See above.?></p>
				<?php } else { ?>
					<p><?php esc_html_e('Everything is already indexed. There is no need to recalculate anything.', 'wordpress-seo-premium'); ?></p>
				<?php } ?>
			</div>

			<button onclick="tb_remove();" type="button" class="button"><?php esc_html_e('Stop analyzing', 'wordpress-seo-premium'); ?></button>
		</div>

		<?php
    }

    /**
     * Enqueues site wide analysis script.
     *
     * @return void
     */
    public function enqueue()
    {
        $asset_manager = new WPSEO_Admin_Asset_Manager;
        $version = $asset_manager->flatten_version(WPSEO_VERSION);

        wp_register_script(
            WPSEO_Admin_Asset_Manager::PREFIX.'premium-site-wide-analysis',
            plugin_dir_url(WPSEO_PREMIUM_FILE).'assets/js/dist/yoast-premium-site-wide-analysis-'.$version.WPSEO_CSSJS_SUFFIX.'.js',
            [
                WPSEO_Admin_Asset_Manager::PREFIX.'analysis',
                'yoast-seo-premium-commons',
            ],
            WPSEO_VERSION,
            true
        );

        if ($this->is_modal_page()) {
            $this->enqueue_dashboard_assets();
        }
    }

    /**
     * Enqueues the dashboard assets.
     *
     * @return void
     */
    protected function enqueue_dashboard_assets()
    {
        $all_items = $this->post_query->get_totals($this->get_post_types());

        $data = [
            'allWords' => get_terms(WPSEO_Premium_Prominent_Words_Registration::TERM_NAME, ['fields' => 'ids']),
            'nrOfItemsPerPostType' => $all_items,
            'totalItems' => array_sum($all_items),
            'message' => ['analysisCompleted' => $this->message_already_indexed()],
            'restApi' => [
                'root' => esc_url_raw(rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
            ],
            'l10n' => [
                'calculationInProgress' => __('Calculation in progress...', 'wordpress-seo-premium'),
                'calculationCompleted' => __('Calculation completed.', 'wordpress-seo-premium'),
                'contentLocale' => get_locale(),
            ],
        ];

        // Add feature flags to localization data.
        $localization_data = [
            'data' => $data,
            'enabledFeatures' => WPSEO_Utils::retrieve_enabled_features(),
        ];

        wp_enqueue_script(WPSEO_Admin_Asset_Manager::PREFIX.'premium-site-wide-analysis');
        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'premium-site-wide-analysis', 'yoastSiteWideAnalysisData', $localization_data);
    }

    /**
     * Returns the rest enabled post types.
     *
     * @return array Array with rest enabled post types.
     */
    protected function get_post_types()
    {
        return array_filter($this->prominent_words_support->get_supported_post_types(), ['WPSEO_Post_Type', 'is_rest_enabled']);
    }

    /**
     * Returns the already indexed message.
     *
     * @return string The message to return when it is already indexed.
     */
    private function message_already_indexed()
    {
        return '<span class="wpseo-checkmark-ok-icon"></span>'.esc_html__('Good job! You\'ve optimized your internal linking suggestions. These suggestions will now appear alongside your content when you are writing or editing a post.', 'wordpress-seo-premium');
    }

    /**
     * Determines if we are on a page that can show the modal.
     *
     * @return bool True if we are on the page that should contain the modal.
     */
    protected function is_modal_page()
    {
        return filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) === 'wpseo_tools';
    }
}
