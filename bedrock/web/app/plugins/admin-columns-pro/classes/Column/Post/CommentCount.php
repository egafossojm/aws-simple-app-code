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
class CommentCount extends AC\Column\Post\CommentCount implements Export\Exportable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\Post\CommentCount($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Post\CommentCount($this);
    }

    public function export()
    {
        return new Export\Model\Post\CommentCount($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\CommentCount;
    }
}
