<?php

namespace AC\Column\Post;

use AC\Column;

/**
 * Column displaying full item permalink (including URL).
 *
 * @since 2.0
 */
class Permalink extends Column
{
    public function __construct()
    {
        $this->set_type('column-permalink');
        $this->set_label(__('Permalink', 'codepress-admin-columns'));
    }

    public function get_value($id)
    {
        $link = $this->get_raw_value($id);

        return ac_helper()->html->link($link, $link, ['target' => '_blank']);
    }

    public function get_raw_value($id)
    {
        return get_permalink($id);
    }
}
