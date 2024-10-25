<?php

namespace ACP\Column\User;

use AC;
use ACP\Export;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 4.0.7
 */
class Name extends AC\Column\User\Name implements Export\Exportable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\User\Name($this);
    }

    public function export()
    {
        return new Export\Model\User\Name($this);
    }

    public function search()
    {
        return new Search\Comparison\User\Name(['first_name', 'last_name']);
    }
}
