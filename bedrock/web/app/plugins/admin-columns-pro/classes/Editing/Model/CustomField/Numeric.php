<?php

namespace ACP\Editing\Model\CustomField;

use ACP\Editing\Model;

class Numeric extends Model\CustomField
{
    /**
     * @return array
     */
    public function get_view_settings()
    {
        return [
            'type' => 'number',
        ];
    }
}
