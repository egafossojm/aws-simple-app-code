<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 4.0
 */
class User extends AC\Column\Comment\User implements Editing\Editable, Export\Exportable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('user_id');

        return $model;
    }

    public function editing()
    {
        return new Editing\Model\Comment\User($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Comment\User($this);
    }

    public function export()
    {
        return new Export\Model\StrippedValue($this);
    }

    public function search()
    {
        return new Search\Comparison\Comment\User;
    }
}
