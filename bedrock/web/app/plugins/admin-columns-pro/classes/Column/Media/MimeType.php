<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

class MimeType extends AC\Column\Media\MimeType implements Editing\Editable, Filtering\Filterable, Search\Searchable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\Media\MimeType($this);
    }

    public function editing()
    {
        return new Editing\Model\Media\MimeType($this);
    }

    public function filtering()
    {
        return new Filtering\Model\Media\MimeType($this);
    }

    public function search()
    {
        return new Search\Comparison\Media\MimeType;
    }
}
