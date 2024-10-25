<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Approved extends AC\Column\Comment\Approved implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('comment_approved');

        return $model;
    }

    public function editing()
    {
        return new Editing\Model\Comment\Approved($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Comment\Approved($this);
    }

    public function search()
    {
        return new Search\Comparison\Comment\Approved;
    }
}
