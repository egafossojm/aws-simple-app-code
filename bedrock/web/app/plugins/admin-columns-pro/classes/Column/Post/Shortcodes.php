<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Sorting;

class Shortcodes extends AC\Column\Post\Shortcodes implements Export\Exportable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function export()
    {
        return new Export\Model\Post\Shortcodes($this);
    }
}
