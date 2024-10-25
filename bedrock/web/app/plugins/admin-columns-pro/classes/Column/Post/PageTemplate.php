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
class PageTemplate extends AC\Column\Post\PageTemplate implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function editing()
    {
        return new Editing\Model\Post\PageTemplate($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Post\PageTemplate($this);
    }

    public function search()
    {
        return new Search\Comparison\Post\PageTemplate($this->get_page_templates());
    }
}
