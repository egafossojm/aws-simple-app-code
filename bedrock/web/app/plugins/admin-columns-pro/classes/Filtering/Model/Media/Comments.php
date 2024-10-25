<?php

namespace ACP\Filtering\Model\Media;

use ACP\Filtering\Model;

class Comments extends Model
{
    public function filter_by_comments($where)
    {
        global $wpdb;

        if ($this->get_filter_value() == 'no_comments') {
            $where .= "AND {$wpdb->posts}.comment_count = '0'";
        } elseif ($this->get_filter_value() == 'has_comments') {
            $where .= "AND {$wpdb->posts}.comment_count <> '0'";
        }

        return $where;
    }

    public function get_filtering_vars($vars)
    {
        add_filter('posts_where', [$this, 'filter_by_comments']);

        return $vars;
    }

    public function get_filtering_data()
    {
        return [
            'options' => [
                'no_comments' => __('No comments', 'codepress-admin-columns'),
                'has_comments' => __('Has comments', 'codepress-admin-columns'),
            ],
        ];
    }
}
