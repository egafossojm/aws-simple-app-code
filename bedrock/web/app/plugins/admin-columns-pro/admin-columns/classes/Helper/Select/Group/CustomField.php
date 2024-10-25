<?php

namespace AC\Helper\Select\Group;

use AC\Helper\Select\Group;
use AC\Helper\Select\Option;

class CustomField extends Group
{
    /**
     * @return string
     */
    public function get_label($entity, Option $option)
    {
        return strpos($entity, '_') === 0 ? 'Hidden' : 'Default';
    }
}
