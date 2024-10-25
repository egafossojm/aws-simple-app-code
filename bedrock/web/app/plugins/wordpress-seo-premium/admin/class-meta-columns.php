<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_Meta_Columns.
 */
class WPSEO_Meta_Columns
{
    /**
     * @var WPSEO_Metabox_Analysis_SEO
     */
    private $analysis_seo;

    /**
     * @var WPSEO_Metabox_Analysis_Readability
     */
    private $analysis_readability;

    /**
     * When page analysis is enabled, just initialize the hooks.
     */
    public function __construct()
    {
        if (apply_filters('wpseo_use_page_analysis', true) === true) {
            add_action('admin_init', [$this, 'setup_hooks']);
        }

        $this->analysis_seo = new WPSEO_Metabox_Analysis_SEO;
        $this->analysis_readability = new WPSEO_Metabox_Analysis_Readability;
    }

    /**
     * Sets up up the hooks.
     */
    public function setup_hooks()
    {
        $this->set_post_type_hooks();

        if ($this->analysis_seo->is_enabled()) {
            add_action('restrict_manage_posts', [$this, 'posts_filter_dropdown']);
        }

        if ($this->analysis_readability->is_enabled()) {
            add_action('restrict_manage_posts', [$this, 'posts_filter_dropdown_readability']);
        }

        add_filter('request', [$this, 'column_sort_orderby']);
    }

    /**
     * Adds the column headings for the SEO plugin for edit posts / pages overview.
     *
     * @param  array  $columns  Already existing columns.
     * @return array Array containing the column headings.
     */
    public function column_heading($columns)
    {
        if ($this->display_metabox() === false) {
            return $columns;
        }

        $added_columns = [];

        if ($this->analysis_seo->is_enabled()) {
            $added_columns['wpseo-score'] = '<span class="yoast-tooltip yoast-tooltip-n yoast-tooltip-alt" data-label="'.esc_attr__('SEO score', 'wordpress-seo').'"><span class="yoast-column-seo-score yoast-column-header-has-tooltip"><span class="screen-reader-text">'.__('SEO score', 'wordpress-seo').'</span></span></span>';
        }

        if ($this->analysis_readability->is_enabled()) {
            $added_columns['wpseo-score-readability'] = '<span class="yoast-tooltip yoast-tooltip-n yoast-tooltip-alt" data-label="'.esc_attr__('Readability score', 'wordpress-seo').'"><span class="yoast-column-readability yoast-column-header-has-tooltip"><span class="screen-reader-text">'.__('Readability score', 'wordpress-seo').'</span></span></span>';
        }

        $added_columns['wpseo-title'] = __('SEO Title', 'wordpress-seo');
        $added_columns['wpseo-metadesc'] = __('Meta Desc.', 'wordpress-seo');

        if ($this->analysis_seo->is_enabled()) {
            $added_columns['wpseo-focuskw'] = __('Keyphrase', 'wordpress-seo');
        }

        return array_merge($columns, $added_columns);
    }

    /**
     * Displays the column content for the given column.
     *
     * @param  string  $column_name  Column to display the content for.
     * @param  int  $post_id  Post to display the column content for.
     */
    public function column_content($column_name, $post_id)
    {
        if ($this->display_metabox() === false) {
            return;
        }

        switch ($column_name) {
            case 'wpseo-score':
                echo $this->parse_column_score($post_id);

                return;

            case 'wpseo-score-readability':
                echo $this->parse_column_score_readability($post_id);

                return;

            case 'wpseo-title':
                $post = get_post($post_id, ARRAY_A);
                $title = wpseo_replace_vars($this->page_title($post_id), $post);
                $title = apply_filters('wpseo_title', $title);

                echo esc_html($title);

                return;

            case 'wpseo-metadesc':
                $post = get_post($post_id, ARRAY_A);
                $metadesc_val = wpseo_replace_vars(WPSEO_Meta::get_value('metadesc', $post_id), $post);
                $metadesc_val = apply_filters('wpseo_metadesc', $metadesc_val);

                if ($metadesc_val === '') {
                    echo '<span aria-hidden="true">&#8212;</span><span class="screen-reader-text">',
                    esc_html__('Meta description not set.', 'wordpress-seo'),
                    '</span>';

                    return;
                }

                echo esc_html($metadesc_val);

                return;

            case 'wpseo-focuskw':
                $focuskw_val = WPSEO_Meta::get_value('focuskw', $post_id);

                if ($focuskw_val === '') {
                    echo '<span aria-hidden="true">&#8212;</span><span class="screen-reader-text">',
                    esc_html__('Focus keyphrase not set.', 'wordpress-seo'),
                    '</span>';

                    return;
                }

                echo esc_html($focuskw_val);

                return;
        }
    }

    /**
     * Indicates which of the SEO columns are sortable.
     *
     * @param  array  $columns  Appended with their orderby variable.
     * @return array Array containing the sortable columns.
     */
    public function column_sort($columns)
    {
        if ($this->display_metabox() === false) {
            return $columns;
        }

        $columns['wpseo-metadesc'] = 'wpseo-metadesc';

        if ($this->analysis_seo->is_enabled()) {
            $columns['wpseo-focuskw'] = 'wpseo-focuskw';
        }

        return $columns;
    }

    /**
     * Hides the SEO title, meta description and focus keyword columns if the user hasn't chosen which columns to hide.
     *
     * @param  array|false  $result  The hidden columns.
     * @param  string  $option  The option name used to set which columns should be hidden.
     * @param  WP_User  $user  The User.
     * @return array $result Array containing the columns to hide.
     */
    public function column_hidden($result, $option, $user)
    {
        global $wpdb;

        if ($user->has_prop($wpdb->get_blog_prefix().$option) || $user->has_prop($option)) {
            return $result;
        }

        if (! is_array($result)) {
            $result = [];
        }

        array_push($result, 'wpseo-title', 'wpseo-metadesc');

        if ($this->analysis_seo->is_enabled()) {
            array_push($result, 'wpseo-focuskw');
        }

        return $result;
    }

    /**
     * Adds a dropdown that allows filtering on the posts SEO Quality.
     */
    public function posts_filter_dropdown()
    {
        if (! $this->can_display_filter()) {
            return;
        }

        $ranks = WPSEO_Rank::get_all_ranks();

        echo '<label class="screen-reader-text" for="wpseo-filter">'.esc_html__('Filter by SEO Score', 'wordpress-seo').'</label>';
        echo '<select name="seo_filter" id="wpseo-filter">';

        echo $this->generate_option('', __('All SEO Scores', 'wordpress-seo'));

        foreach ($ranks as $rank) {
            $selected = selected($this->get_current_seo_filter(), $rank->get_rank(), false);

            echo $this->generate_option($rank->get_rank(), $rank->get_drop_down_label(), $selected);
        }

        echo '</select>';
    }

    /**
     * Adds a dropdown that allows filtering on the posts Readability Quality.
     *
     * @return void
     */
    public function posts_filter_dropdown_readability()
    {
        if (! $this->can_display_filter()) {
            return;
        }

        $ranks = WPSEO_Rank::get_all_readability_ranks();

        echo '<label class="screen-reader-text" for="wpseo-readability-filter">'.esc_html__('Filter by Readability Score', 'wordpress-seo').'</label>';
        echo '<select name="readability_filter" id="wpseo-readability-filter">';

        echo $this->generate_option('', __('All Readability Scores', 'wordpress-seo'));

        foreach ($ranks as $rank) {
            $selected = selected($this->get_current_readability_filter(), $rank->get_rank(), false);

            echo $this->generate_option($rank->get_rank(), $rank->get_drop_down_readability_labels(), $selected);
        }

        echo '</select>';
    }

    /**
     * Generates an <option> element.
     *
     * @param  string  $value  The option's value.
     * @param  string  $label  The option's label.
     * @param  string  $selected  HTML selected attribute for an option.
     * @return string The generated <option> element.
     */
    protected function generate_option($value, $label, $selected = '')
    {
        return '<option '.$selected.' value="'.esc_attr($value).'">'.esc_html($label).'</option>';
    }

    /**
     * Determines the SEO score filter to be later used in the meta query, based on the passed SEO filter.
     *
     * @param  string  $seo_filter  The SEO filter to use to determine what further filter to apply.
     * @return array The SEO score filter.
     */
    protected function determine_seo_filters($seo_filter)
    {
        if ($seo_filter === WPSEO_Rank::NO_FOCUS) {
            return $this->create_no_focus_keyword_filter();
        }

        if ($seo_filter === WPSEO_Rank::NO_INDEX) {
            return $this->create_no_index_filter();
        }

        $rank = new WPSEO_Rank($seo_filter);

        return $this->create_seo_score_filter($rank->get_starting_score(), $rank->get_end_score());
    }

    /**
     * Determines the Readability score filter to the meta query, based on the passed Readability filter.
     *
     * @param  string  $readability_filter  The Readability filter to use to determine what further filter to apply.
     * @return array The Readability score filter.
     */
    protected function determine_readability_filters($readability_filter)
    {
        $rank = new WPSEO_Rank($readability_filter);

        return $this->create_readability_score_filter($rank->get_starting_score(), $rank->get_end_score());
    }

    /**
     * Creates a keyword filter for the meta query, based on the passed Keyword filter.
     *
     * @param  string  $keyword_filter  The keyword filter to use.
     * @return array The keyword filter.
     */
    protected function get_keyword_filter($keyword_filter)
    {
        return [
            'post_type' => get_query_var('post_type', 'post'),
            'key' => WPSEO_Meta::$meta_prefix.'focuskw',
            'value' => sanitize_text_field($keyword_filter),
        ];
    }

    /**
     * Determines whether the passed filter is considered to be valid.
     *
     * @param  mixed  $filter  The filter to check against.
     * @return bool Whether or not the filter is considered valid.
     */
    protected function is_valid_filter($filter)
    {
        return ! empty($filter) && is_string($filter);
    }

    /**
     * Collects the filters and merges them into a single array.
     *
     * @return array Array containing all the applicable filters.
     */
    protected function collect_filters()
    {
        $active_filters = [];

        $seo_filter = $this->get_current_seo_filter();
        $readability_filter = $this->get_current_readability_filter();
        $current_keyword_filter = $this->get_current_keyword_filter();

        if ($this->is_valid_filter($seo_filter)) {
            $active_filters = array_merge(
                $active_filters,
                $this->determine_seo_filters($seo_filter)
            );
        }

        if ($this->is_valid_filter($readability_filter)) {
            $active_filters = array_merge(
                $active_filters,
                $this->determine_readability_filters($readability_filter)
            );
        }

        if ($this->is_valid_filter($current_keyword_filter)) {
            $active_filters = array_merge(
                $active_filters,
                $this->get_keyword_filter($current_keyword_filter)
            );
        }

        return $active_filters;
    }

    /**
     * Modify the query based on the filters that are being passed.
     *
     * @param  array  $vars  Query variables that need to be modified based on the filters.
     * @return array Array containing the meta query to use for filtering the posts overview.
     */
    public function column_sort_orderby($vars)
    {
        $collected_filters = $this->collect_filters();

        if (isset($vars['orderby'])) {
            $vars = array_merge($vars, $this->filter_order_by($vars['orderby']));
        }

        return $this->build_filter_query($vars, $collected_filters);
    }

    /**
     * Retrieves the meta robots query values to be used within the meta query.
     *
     * @return array Array containing the query parameters regarding meta robots.
     */
    protected function get_meta_robots_query_values()
    {
        return [
            'relation' => 'OR',
            [
                'key' => WPSEO_Meta::$meta_prefix.'meta-robots-noindex',
                'compare' => 'NOT EXISTS',
            ],
            [
                'key' => WPSEO_Meta::$meta_prefix.'meta-robots-noindex',
                'value' => '1',
                'compare' => '!=',
            ],
        ];
    }

    /**
     * Determines the score filters to be used. If more than one is passed, it created an AND statement for the query.
     *
     * @param  array  $score_filters  Array containing the score filters.
     * @return array Array containing the score filters that need to be applied to the meta query.
     */
    protected function determine_score_filters($score_filters)
    {
        if (count($score_filters) > 1) {
            return array_merge(['relation' => 'AND'], $score_filters);
        }

        return $score_filters;
    }

    /**
     * Retrieves the post type from the $_GET variable.
     *
     * @return string The current post type.
     */
    public function get_current_post_type()
    {
        return filter_input(INPUT_GET, 'post_type');
    }

    /**
     * Retrieves the SEO filter from the $_GET variable.
     *
     * @return string The current post type.
     */
    public function get_current_seo_filter()
    {
        return filter_input(INPUT_GET, 'seo_filter');
    }

    /**
     * Retrieves the Readability filter from the $_GET variable.
     *
     * @return string The current post type.
     */
    public function get_current_readability_filter()
    {
        return filter_input(INPUT_GET, 'readability_filter');
    }

    /**
     * Retrieves the keyword filter from the $_GET variable.
     *
     * @return string The current post type.
     */
    public function get_current_keyword_filter()
    {
        return filter_input(INPUT_GET, 'seo_kw_filter');
    }

    /**
     * Uses the vars to create a complete filter query that can later be executed to filter out posts.
     *
     * @param  array  $vars  Array containing the variables that will be used in the meta query.
     * @param  array  $filters  Array containing the filters that we need to apply in the meta query.
     * @return array Array containing the complete filter query.
     */
    protected function build_filter_query($vars, $filters)
    {
        // If no filters were applied, just return everything.
        if (count($filters) === 0) {
            return $vars;
        }

        $result = ['meta_query' => []];
        $result['meta_query'] = array_merge($result['meta_query'], [$this->determine_score_filters($filters)]);

        $current_seo_filter = $this->get_current_seo_filter();

        // This only applies for the SEO score filter because it can because the SEO score can be altered by the no-index option.
        if ($this->is_valid_filter($current_seo_filter) && ! in_array($current_seo_filter, [WPSEO_Rank::NO_INDEX, WPSEO_Rank::NO_FOCUS], true)) {
            $result['meta_query'] = array_merge($result['meta_query'], [$this->get_meta_robots_query_values()]);
        }

        return array_merge($vars, $result);
    }

    /**
     * Creates a Readability score filter.
     *
     * @param  number  $low  The lower boundary of the score.
     * @param  number  $high  The higher boundary of the score.
     * @return array The Readability Score filter.
     */
    protected function create_readability_score_filter($low, $high)
    {
        return [
            [
                'key' => WPSEO_Meta::$meta_prefix.'content_score',
                'value' => [$low, $high],
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            ],
        ];
    }

    /**
     * Creates an SEO score filter.
     *
     * @param  number  $low  The lower boundary of the score.
     * @param  number  $high  The higher boundary of the score.
     * @return array The SEO score filter.
     */
    protected function create_seo_score_filter($low, $high)
    {
        return [
            [
                'key' => WPSEO_Meta::$meta_prefix.'linkdex',
                'value' => [$low, $high],
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            ],
        ];
    }

    /**
     * Creates a filter to retrieve posts that were set to no-index.
     *
     * @return array Array containin the no-index filter.
     */
    protected function create_no_index_filter()
    {
        return [
            [
                'key' => WPSEO_Meta::$meta_prefix.'meta-robots-noindex',
                'value' => '1',
                'compare' => '=',
            ],
        ];
    }

    /**
     * Creates a filter to retrieve posts that have no keyword set.
     *
     * @return array Array containing the no focus keyword filter.
     */
    protected function create_no_focus_keyword_filter()
    {
        return [
            [
                'key' => WPSEO_Meta::$meta_prefix.'meta-robots-noindex',
                'value' => 'needs-a-value-anyway',
                'compare' => 'NOT EXISTS',
            ],
            [
                'key' => WPSEO_Meta::$meta_prefix.'linkdex',
                'value' => 'needs-a-value-anyway',
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    /**
     * Determines whether a particular post_id is of an indexable post type.
     *
     * @param  string  $post_id  The post ID to check.
     * @return bool Whether or not it is indexable.
     */
    protected function is_indexable($post_id)
    {
        if (! empty($post_id) && ! $this->uses_default_indexing($post_id)) {
            return WPSEO_Meta::get_value('meta-robots-noindex', $post_id) === '2';
        }

        $post = get_post($post_id);

        if (is_object($post)) {
            // If the option is false, this means we want to index it.
            return WPSEO_Options::get('noindex-'.$post->post_type, false) === false;
        }

        return true;
    }

    /**
     * Determines whether the given post ID uses the default indexing settings.
     *
     * @param  int  $post_id  The post ID to check.
     * @return bool Whether or not the default indexing is being used for the post.
     */
    protected function uses_default_indexing($post_id)
    {
        return WPSEO_Meta::get_value('meta-robots-noindex', $post_id) === '0';
    }

    /**
     * Returns filters when $order_by is matched in the if-statement.
     *
     * @param  string  $order_by  The ID of the column by which to order the posts.
     * @return array Array containing the order filters.
     */
    private function filter_order_by($order_by)
    {
        switch ($order_by) {
            case 'wpseo-metadesc':
                return [
                    'meta_key' => WPSEO_Meta::$meta_prefix.'metadesc',
                    'orderby' => 'meta_value',
                ];

            case 'wpseo-focuskw':
                return [
                    'meta_key' => WPSEO_Meta::$meta_prefix.'focuskw',
                    'orderby' => 'meta_value',
                ];
        }

        return [];
    }

    /**
     * Parses the score column.
     *
     * @param  int  $post_id  The ID of the post for which to show the score.
     * @return string The HTML for the SEO score indicator.
     */
    private function parse_column_score($post_id)
    {
        if (! $this->is_indexable($post_id)) {
            $rank = new WPSEO_Rank(WPSEO_Rank::NO_INDEX);
            $title = __('Post is set to noindex.', 'wordpress-seo');

            WPSEO_Meta::set_value('linkdex', 0, $post_id);

            return $this->render_score_indicator($rank, $title);
        }

        if (WPSEO_Meta::get_value('focuskw', $post_id) === '') {
            $rank = new WPSEO_Rank(WPSEO_Rank::NO_FOCUS);
            $title = __('Focus keyphrase not set.', 'wordpress-seo');

            return $this->render_score_indicator($rank, $title);
        }

        $score = (int) WPSEO_Meta::get_value('linkdex', $post_id);
        $rank = WPSEO_Rank::from_numeric_score($score);
        $title = $rank->get_label();

        return $this->render_score_indicator($rank, $title);
    }

    /**
     * Parsing the readability score column.
     *
     * @param  int  $post_id  The ID of the post for which to show the readability score.
     * @return string The HTML for the readability score indicator.
     */
    private function parse_column_score_readability($post_id)
    {
        $score = (int) WPSEO_Meta::get_value('content_score', $post_id);
        $rank = WPSEO_Rank::from_numeric_score($score);

        return $this->render_score_indicator($rank);
    }

    /**
     * Sets up the hooks for the post_types.
     */
    private function set_post_type_hooks()
    {
        $post_types = WPSEO_Post_Type::get_accessible_post_types();

        if (! is_array($post_types) || $post_types === []) {
            return;
        }

        foreach ($post_types as $post_type) {
            if ($this->display_metabox($post_type) === false) {
                continue;
            }

            add_filter('manage_'.$post_type.'_posts_columns', [$this, 'column_heading'], 10, 1);
            add_action('manage_'.$post_type.'_posts_custom_column', [$this, 'column_content'], 10, 2);
            add_action('manage_edit-'.$post_type.'_sortable_columns', [$this, 'column_sort'], 10, 2);

            /*
             * Use the `get_user_option_{$option}` filter to change the output of the get_user_option
             * function for the `manage{$screen}columnshidden` option, which is based on the current
             * admin screen. The admin screen we want to target is the `edit-{$post_type}` screen.
             */
            $filter = sprintf('get_user_option_%s', sprintf('manage%scolumnshidden', 'edit-'.$post_type));

            add_filter($filter, [$this, 'column_hidden'], 10, 3);
        }

        unset($post_type);
    }

    /**
     * Wraps the WPSEO_Metabox check to determine whether the metabox should be displayed either by
     * choice of the admin or because the post type is not a public post type.
     *
     * @since 7.0
     *
     * @param  string  $post_type  Optional. The post type to test, defaults to the current post post_type.
     * @return bool Whether or not the meta box (and associated columns etc) should be hidden.
     */
    private function display_metabox($post_type = null)
    {
        $current_post_type = sanitize_text_field($this->get_current_post_type());

        if (! isset($post_type) && ! empty($current_post_type)) {
            $post_type = $current_post_type;
        }

        return WPSEO_Utils::is_metabox_active($post_type, 'post_type');
    }

    /**
     * Retrieve the page title.
     *
     * @param  int  $post_id  Post to retrieve the title for.
     * @return string
     */
    private function page_title($post_id)
    {
        $fixed_title = WPSEO_Meta::get_value('title', $post_id);
        if ($fixed_title !== '') {
            return $fixed_title;
        }

        $post = get_post($post_id);

        if (is_object($post) && WPSEO_Options::get('title-'.$post->post_type, '') !== '') {
            $title_template = WPSEO_Options::get('title-'.$post->post_type);
            $title_template = str_replace(' %%page%% ', ' ', $title_template);

            return wpseo_replace_vars($title_template, $post);
        }

        return wpseo_replace_vars('%%title%%', $post);
    }

    /**
     * @param  WPSEO_Rank  $rank  The rank this indicator should have.
     * @param  string  $title  Optional. The title for this rank, defaults to the title of the rank.
     * @return string The HTML for a score indicator.
     */
    private function render_score_indicator($rank, $title = '')
    {
        if (empty($title)) {
            $title = $rank->get_label();
        }

        return '<div aria-hidden="true" title="'.esc_attr($title).'" class="wpseo-score-icon '.esc_attr($rank->get_css_class()).'"></div><span class="screen-reader-text wpseo-score-text">'.$title.'</span>';
    }

    /**
     * Determines whether or not filter dropdowns should be displayed.
     *
     * @return bool Whether or the current page can display the filter drop downs.
     */
    public function can_display_filter()
    {
        if ($GLOBALS['pagenow'] === 'upload.php') {
            return false;
        }

        if ($this->display_metabox() === false) {
            return false;
        }

        $screen = get_current_screen();
        if ($screen === null) {
            return false;
        }

        return WPSEO_Post_Type::is_post_type_accessible($screen->post_type);
    }
}
