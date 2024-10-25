<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Attachment extends AC\Column\Post\Attachment implements Editing\Editable, Export\Exportable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model($this);
    }

    public function editing()
    {
        return new Editing\Model\Post\Attachment($this);
    }

    public function export()
    {
        return new Export\Model\Post\Attachment($this);
    }
}
