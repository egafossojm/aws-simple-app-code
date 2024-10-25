<?php

namespace AC\Column\Post;

use AC\Column;

/**
 * @since 2.0
 */
class Sticky extends Column
{
    private $stickies = null;

    public function __construct()
    {
        $this->set_type('column-sticky');
        $this->set_label(__('Sticky', 'codepress-admin-columns'));
    }

    public function is_valid()
    {
        return $this->get_post_type() == 'post';
    }

    public function get_value($post_id)
    {
        return ac_helper()->icon->yes_or_no($this->is_sticky($post_id));
    }

    public function get_raw_value($post_id)
    {
        return $this->is_sticky($post_id);
    }

    // Helpers
    private function is_sticky($post_id)
    {
        if ($this->stickies === null) {
            $this->stickies = get_option('sticky_posts');
        }

        return in_array($post_id, (array) $this->stickies);
    }
}
