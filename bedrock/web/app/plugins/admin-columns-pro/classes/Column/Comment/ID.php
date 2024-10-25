<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 2.0
 */
class ID extends AC\Column\Comment\ID implements Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('comment_ID');

        return $model;
    }

    public function search()
    {
        return new Search\Comparison\Comment\ID;
    }
}
