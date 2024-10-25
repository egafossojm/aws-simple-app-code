<?php

namespace ACP\Helper\Select\Group;

use AC;

class Alphabetically extends AC\Helper\Select\Group
{
    /**
     * @return string
     */
    public function get_label($entity, AC\Helper\Select\Option $option)
    {
        return strtoupper(substr($option->get_label(), 0, 1));
    }
}
