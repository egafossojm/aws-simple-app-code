<?php

namespace AC\Column\Post;

use AC\Column;

/**
 * @since 3.0
 */
class Shortlink extends Column
{
    public function __construct()
    {
        $this->set_type('column-shortlink');
        $this->set_label(__('Shortlink', 'codepress-admin-columns'));
    }

    public function get_value($post_id)
    {
        $link = $this->get_raw_value($post_id);

        return ac_helper()->html->link($link, $link);
    }

    public function get_raw_value($post_id)
    {
        return wp_get_shortlink($post_id);
    }
}
