<?php

namespace ACP\Editing\Model\User;

use ACP\Editing\Model;

class ShowToolbar extends Model
{
    public function get_view_settings()
    {
        return [
            'type' => 'togglable',
            'options' => [
                'true' => __('True', 'codepress-admin-columns'),
                'false' => __('False', 'codepress-admin-columns'),
            ],
        ];
    }

    public function save($id, $value)
    {
        return update_user_meta($id, 'show_admin_bar_front', $value) !== false;
    }
}
