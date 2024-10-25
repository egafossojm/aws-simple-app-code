<?php

namespace DeliciousBrains\WP_Offload_Media\Pro\Tools;

use DeliciousBrains\WP_Offload_Media\Pro\Background_Processes\Background_Tool_Process;
use DeliciousBrains\WP_Offload_Media\Pro\Background_Processes\Copy_Buckets_Process;
use DeliciousBrains\WP_Offload_Media\Pro\Background_Tool;

class Copy_Buckets extends Background_Tool
{
    /**
     * @var string
     */
    protected $tool_key = 'copy_buckets';

    /**
     * @var string
     */
    protected $tab = 'media';

    /**
     * @var array
     */
    protected static $show_tool_constants = [
        'AS3CF_SHOW_COPY_BUCKETS_TOOL',
        'WPOS3_SHOW_COPY_BUCKETS_TOOL',
    ];

    /**
     * Initialize the tool.
     */
    public function init()
    {
        parent::init();

        if (! $this->as3cf->is_pro_plugin_setup(true)) {
            return;
        }

        // Prompt
        add_action('as3cfpro_load_assets', [$this, 'load_assets']);
        add_action('as3cf_after_settings', [$this, 'render_modal']);
        add_filter('as3cfpro_js_strings', [$this, 'add_js_strings']);
    }

    /**
     * Get the details for the sidebar block
     *
     * @return array|bool
     */
    protected function get_sidebar_block_args()
    {
        if (! $this->as3cf->is_pro_plugin_setup(true)) {
            return false;
        }

        return parent::get_sidebar_block_args();
    }

    /**
     * AJAX handle start.
     */
    public function ajax_handle_start()
    {
        parent::ajax_handle_start();

        $this->as3cf->end_ajax(['success' => true]);
    }

    /**
     * Load assets.
     */
    public function load_assets()
    {
        $this->as3cf->enqueue_script('as3cf-pro-copy-buckets', 'assets/js/pro/tools/copy-buckets', [
            'jquery',
            'wp-util',
        ]);
    }

    /**
     * Render modal in footer.
     */
    public function render_modal()
    {
        $this->as3cf->render_view('modals/copy-buckets');
    }

    /**
     * Add localized strings to Javascript.
     *
     *
     * @return array
     */
    public function add_js_strings($strings)
    {
        $strings['tools'][$this->tool_key] = [
            'error' => __('There was an error attempting to start the copy tool. Please try again.', 'amazon-s3-and-cloudfront'),
        ];

        return $strings;
    }

    /**
     * Should render.
     *
     * @return bool
     */
    public function should_render()
    {
        if (static::show_tool_constant() !== false && constant(static::show_tool_constant())) {
            return true;
        }

        return $this->is_queued() || $this->is_processing() || $this->is_paused() || $this->is_cancelled();
    }

    /**
     * Get title text.
     *
     * @return string
     */
    public function get_title_text()
    {
        return __('Copy files to new bucket', 'amazon-s3-and-cloudfront');
    }

    /**
     * Get button text.
     *
     * @return string
     */
    public function get_button_text()
    {
        return __('Begin Copy', 'amazon-s3-and-cloudfront');
    }

    /**
     * Get queued status text.
     *
     * @return string
     */
    public function get_queued_status()
    {
        return __('Copying Media Library items between buckets.', 'amazon-s3-and-cloudfront');
    }

    /**
     * Get more info text.
     *
     * @return string
     */
    public function get_more_info_text()
    {
        return __('Would you like to consolidate your offloaded media files by copying them into the currently selected bucket? All existing offloaded media URLs will be updated to reference the new bucket.', 'amazon-s3-and-cloudfront');
    }

    /**
     * Message for error notice.
     *
     * @return string
     */
    protected function get_error_notice_message()
    {
        $title = __('Copy Bucket Errors', 'amazon-s3-and-cloudfront');
        $message = __('Previous attempts at copying your media library between buckets have resulted in errors.', 'amazon-s3-and-cloudfront');

        return sprintf('<strong>%s</strong> &mdash; %s', $title, $message);
    }

    /**
     * Get background process class.
     *
     * @return Background_Tool_Process|null
     */
    protected function get_background_process_class()
    {
        return new Copy_Buckets_Process($this->as3cf, $this);
    }
}
