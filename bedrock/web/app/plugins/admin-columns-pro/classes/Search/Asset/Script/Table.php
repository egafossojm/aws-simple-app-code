<?php

namespace ACP\Search\Asset\Script;

use AC\Request;
use ACP\Asset\Location;
use ACP\Asset\Script;

final class Table extends Script
{
    /**
     * @var array
     */
    protected $filters;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param  string  $handle
     */
    public function __construct($handle, Location $location, array $filters, Request $request)
    {
        parent::__construct($handle, $location, ['aca-search-querybuilder', 'wp-pointer']);

        $this->filters = $filters;
        $this->request = $request;
    }

    public function register()
    {
        parent::register();

        wp_localize_script('aca-search-table', 'ac_search', [
            'rules' => json_decode($this->request->get('ac-rules-raw')),
            'filters' => $this->filters,
            'i18n' => [
                'select' => _x('Select', 'select placeholder', 'codepress-admin-columns'),
                'add_filter' => __('Add Filter', 'codepress-admin-columns'),
            ],
        ]);
    }
}
