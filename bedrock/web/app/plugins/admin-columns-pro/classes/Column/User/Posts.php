<?php

namespace ACP\Column\User;

use AC;
use ACP\Export;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Posts extends AC\Column\User\Posts implements Export\Exportable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\User\PostCount($this);
    }

    public function export()
    {
        return new Export\Model\User\Posts($this);
    }
}
