<?php

namespace ACP\Column\Post;

use AC;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

class ID extends AC\Column\Post\ID implements Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('ID');

        return $model;
    }

    public function filtering()
    {
        return new Filtering\Model\Post\ID($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\ID;
    }
}
