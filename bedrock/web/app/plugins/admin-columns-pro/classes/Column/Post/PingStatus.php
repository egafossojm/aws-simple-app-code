<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 2.0
 */
class PingStatus extends AC\Column\Post\PingStatus implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model\Post\Field($this);
        $model->set_field('ping_status');

        return $model;
    }

    public function editing()
    {
        return new Editing\Model\Post\PingStatus($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Post\PingStatus($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\PingStatus;
    }
}
