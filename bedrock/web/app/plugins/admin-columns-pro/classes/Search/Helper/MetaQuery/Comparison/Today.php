<?php

namespace ACP\Search\Helper\MetaQuery\Comparison;

use ACP\Search\Helper\DateValueFactory;
use ACP\Search\Helper\MetaQuery;
use ACP\Search\Operators;
use ACP\Search\Value;

class Today extends MetaQuery\Date
{
    /**
     * @param  string  $key
     *
     * @throws \Exception
     */
    public function __construct($key, Value $value)
    {
        $factory = new DateValueFactory($value->get_type());
        $value = $factory->create_range_today();

        parent::__construct($key, Operators::BETWEEN, $value);
    }
}
