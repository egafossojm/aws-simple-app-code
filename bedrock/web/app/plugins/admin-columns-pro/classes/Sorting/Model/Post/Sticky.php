<?php

namespace ACP\Sorting\Model\Post;

use AC;
use ACP\Sorting\Model;

class Sticky extends Model
{
    public function __construct(AC\Column $column)
    {
        parent::__construct($column);

        $this->set_data_type('numeric');
    }

    public function get_sorting_vars()
    {
        $sticky_ids = (array) get_option('sticky_posts');
        $ids = $this->strategy->get_results();
        $matched = [];

        foreach ($sticky_ids as $k => $sticky_id) {
            $index = array_search($sticky_id, $ids);

            if ($index !== false) {
                unset($ids[$index]);
                $ids[] = $matched[] = $sticky_id;
            }
        }

        if (! acp_sorting()->show_all_results()) {
            $ids = $matched;
        }

        if ($this->get_order() === 'ASC') {
            $ids = array_reverse($ids);
        }

        return [
            'ids' => $ids,
        ];
    }
}
