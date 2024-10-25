<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 4.0
 */
class ShowToolbar extends AC\Column\User\ShowToolbar implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function editing()
    {
        return new Editing\Model\User\ShowToolbar($this);
    }

    public function filtering()
    {
        return new Filtering\Model\User\ShowToolbar($this);
    }

    public function search()
    {
        return new Search\Comparison\User\TrueFalse('show_admin_bar_front');
    }
}
