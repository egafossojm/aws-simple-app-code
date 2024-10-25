<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 2.4
 */
class DatePublished extends AC\Column\Post\DatePublished implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('date');

        return $model;
    }

    public function filtering()
    {
        return new Filtering\Model\Post\Date($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\Date\PostDate;
    }

    public function editing()
    {
        return new Editing\Model\Post\Date($this);
    }
}
