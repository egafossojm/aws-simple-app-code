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
class Type extends AC\Column\Comment\Type implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('comment_type');

        return $model;
    }

    public function editing()
    {
        return new Editing\Model\Comment\Type($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Comment\Type($this);
    }

    public function search()
    {
        return new Search\Comparison\Comment\Type;
    }
}
