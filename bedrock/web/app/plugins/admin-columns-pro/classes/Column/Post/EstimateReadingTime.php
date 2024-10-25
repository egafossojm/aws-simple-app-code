<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Sorting;

class EstimateReadingTime extends AC\Column\Post\EstimatedReadingTime implements Export\Exportable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\Post\EstimateReadingTime($this);
    }

    public function export()
    {
        return new Export\Model\StrippedValue($this);
    }
}
