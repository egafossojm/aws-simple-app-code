<?php

namespace ACP\Search;

use AC;
use ACP;
use ACP\Asset\Location;
use ACP\Search\Controller\Comparison;
use ACP\Search\Controller\Segment;

final class Addon implements AC\Registrable
{
    /**
     * @var AC\Request
     */
    private $request;

    /**
     * @var string
     */
    private $plugin_file;

    public function __construct()
    {
        $this->request = new AC\Request;
        $this->request->add_middleware(new Middleware\Request);
        $this->plugin_file = ACP_FILE;
    }

    public function register()
    {
        $settings = new Settings([
            new ACP\Asset\Style('acp-search-admin', $this->get_location()->with_suffix('assets/search/css/admin.css')),
        ]);
        $settings->register();

        $table_screen_options = new TableScreenOptions([
            new ACP\Asset\Script('acp-search-table-screen-options', $this->get_location()->with_suffix('assets/search/js/screen-options.bundle.js')),
        ]);
        $table_screen_options->register();

        add_action('ac/table/list_screen', [$this, 'table_screen_request']);
        add_action('wp_ajax_acp_search_segment_request', [$this, 'segment_request']);
        add_action('wp_ajax_acp_search_comparison_request', [$this, 'comparison_request']);
    }

    private function get_location()
    {
        return new Location\Absolute(
            plugin_dir_url($this->plugin_file),
            plugin_dir_path($this->plugin_file)
        );
    }

    public function segment_request()
    {
        $segment = new Segment(
            $this->request,
            new Middleware\Rules
        );

        $segment->dispatch($this->request->get('method'));
    }

    public function comparison_request()
    {
        $comparison = new Comparison(
            $this->request
        );

        $comparison->dispatch($this->request->get('method'));
    }

    private function get_table_screen_options()
    {
        $location = $this->get_location();

        return new TableScreenOptions([
            new ACP\Asset\Script('acp-search-table-screen-options', $location->with_suffix('assets/search/js/screen-options.bundle.js')),
        ]);
    }

    public function table_screen_request(AC\ListScreen $list_screen)
    {
        if (! $this->get_table_screen_options()->is_active($list_screen)) {
            return;
        }

        $filters = $this->get_filters($list_screen);

        $assets = [
            new ACP\Asset\Style('aca-search-table', $this->get_location()->with_suffix('assets/search/css/table.css')),
            new ACP\Asset\Script('aca-search-moment', $this->get_location()->with_suffix('assets/search/js/moment.min.js')),
            new ACP\Asset\Script('aca-search-querybuilder', $this->get_location()->with_suffix('assets/search/js/query-builder.standalone.min.js'), ['jquery', 'jquery-ui-datepicker']),
            new Asset\Script\Table(
                'aca-search-table',
                $this->get_location()->with_suffix('assets/search/js/table.bundle.js'),
                $filters,
                $this->request
            ),
        ];

        $table_screen = TableScreenFactory::create($this, $list_screen, $this->request, $assets);

        if (! $table_screen) {
            return;
        }

        $table_screen->register();
    }

    /**
     * @return array
     */
    private function get_filters(AC\ListScreen $list_screen)
    {
        $filters = [];

        foreach ($list_screen->get_columns() as $column) {
            $setting = $column->get_setting('search');

            if (! $setting instanceof Settings\Column || ! $setting->is_active()) {
                continue;
            }

            if (! $column instanceof Searchable || ! $column->search()) {
                continue;
            }

            $filter = new Middleware\Filter(
                $column->get_name(),
                $column->search(),
                $this->get_filter_label($column)
            );

            $filters[] = $filter();
        }

        return $filters;
    }

    /**
     * @return string
     */
    private function get_filter_label(AC\Column $column)
    {
        $label = $this->sanitize_label($column->get_custom_label());

        if (! $label) {
            $label = $this->sanitize_label($column->get_label());
        }

        if (! $label) {
            $label = $column->get_type();
        }

        return $label;
    }

    /**
     * Allow dashicons as label, all the rest is parsed by 'strip_tags'
     *
     * @param  string  $label
     * @return string
     */
    private function sanitize_label($label)
    {
        if (strpos($label, 'dashicons') === false) {
            $label = strip_tags($label);
        }

        return trim($label);
    }
}
