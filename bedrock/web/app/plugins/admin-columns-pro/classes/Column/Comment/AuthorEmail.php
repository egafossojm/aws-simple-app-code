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
class AuthorEmail extends AC\Column\Comment\AuthorEmail implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        $model = new Sorting\Model($this);
        $model->set_orderby('comment_author_email');

        return $model;
    }

    public function editing()
    {
        return new Editing\Model\Comment\AuthorEmail($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Comment\AuthorEmail($this);
    }

    public function search()
    {
        return new Search\Comparison\Comment\Email;
    }
}
