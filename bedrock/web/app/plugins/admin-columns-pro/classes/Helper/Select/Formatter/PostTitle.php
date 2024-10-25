<?php

namespace ACP\Helper\Select\Formatter;

use AC;
use ACP\Helper\Select\Value;
use WP_Post;

class PostTitle extends AC\Helper\Select\Formatter
{
    public function __construct(AC\Helper\Select\Entities $entities, ?AC\Helper\Select\Value $value = null)
    {
        if ($value === null) {
            $value = new Value\Post;
        }

        parent::__construct($entities, $value);
    }

    /**
     * @param  WP_Post  $post
     * @return string
     */
    public function get_label($post)
    {
        $label = $post->post_title;

        if ($post->post_type === 'attachment') {
            $label = ac_helper()->image->get_file_name($post->ID);
        }

        if (! $label) {
            $label = sprintf(__('#%d (no title)'), $post->ID);
        }

        return $label;
    }
}
