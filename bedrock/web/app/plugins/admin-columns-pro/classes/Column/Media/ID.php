<?php

namespace ACP\Column\Media;

use AC;
use ACP\Search;
use ACP\Sorting;

class ID extends AC\Column\Media\ID implements Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('ID');

        return $model;
    }

    public function search()
    {
        return new Search\Comparison\Post\ID;
    }
}
