<?php

namespace ACP\Filtering\Model\User;

use ACP\Filtering\Model;

class RichEditing extends Model
{
    public function get_filtering_vars($vars)
    {
        $vars['meta_query'][] = [
            [
                'key' => 'rich_editing',
                'value' => $this->get_filter_value() === '1' ? 'true' : 'false',
            ],
        ];

        return $vars;
    }

    public function get_filtering_data()
    {
        $data = [
            'options' => [
                0 => __('No'),
                1 => __('Yes'),
            ],
        ];

        return $data;
    }
}
