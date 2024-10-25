<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 4.0
 */
class BeforeMoreTag extends AC\Column\Post\BeforeMoreTag implements Export\Exportable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Post\BeforeMoreTag($this);
    }

    public function export()
    {
        return new Export\Model\StrippedValue($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\BeforeMoreTag;
    }
}
