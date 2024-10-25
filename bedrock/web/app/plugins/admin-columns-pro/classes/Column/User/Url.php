<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Url extends AC\Column\User\Url implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function editing()
    {
        return new Editing\Model\User\Url($this);
    }

    public function filtering()
    {
        return new Filtering\Model\User\Url($this);
    }

    public function search()
    {
        return new Search\Comparison\User\Url;
    }
}
