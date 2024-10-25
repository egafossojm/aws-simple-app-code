<?php

namespace ACP\Search\Comparison;

use ACP\Helper\Select\Options;

interface SearchableValues
{
    /**
     * @return Options\Paginated
     */
    public function get_values($search, $page);
}
