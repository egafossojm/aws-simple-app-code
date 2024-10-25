<?php

namespace ACP\Search\Helper\Sql\Comparison;

use ACP\Search\Helper\DateValueFactory;
use ACP\Search\Value;

class Today extends Between
{
    /**
     * @return Between
     *
     * @throws \Exception
     */
    public function bind_value(Value $value)
    {
        $value_factory = new DateValueFactory($value->get_type());

        return parent::bind_value($value_factory->create_range_today());
    }
}
