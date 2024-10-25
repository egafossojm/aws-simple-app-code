<?php

namespace ACP\Column\Media;

use AC;
use ACP\Export;
use ACP\Sorting;

class ExifData extends AC\Column\Media\ExifData implements Export\Exportable, Sorting\Sortable
{
    public function sorting()
    {
        return new Sorting\Model\Value($this);
    }

    public function export()
    {
        return new Export\Model\Value($this);
    }
}
