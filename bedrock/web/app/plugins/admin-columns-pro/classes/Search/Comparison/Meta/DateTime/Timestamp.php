<?php

namespace ACP\Search\Comparison\Meta\DateTime;

use ACP\Search\Comparison\Meta;
use ACP\Search\Labels;
use ACP\Search\Operators;
use ACP\Search\Value;

class Timestamp extends Meta
{
    public function __construct($meta_key, $type)
    {
        $operators = new Operators([
            Operators::EQ,
            Operators::GT,
            Operators::LT,
            Operators::BETWEEN,
            Operators::TODAY,
            Operators::PAST,
            Operators::FUTURE,
            Operators::IS_EMPTY,
            Operators::NOT_IS_EMPTY,
        ], false);

        parent::__construct($operators, $meta_key, $type, Value::DATE, new Labels\Date);
    }

    protected function get_meta_query($operator, Value $value)
    {
        $time = is_array($value->get_value())
            ? array_map([$this, 'to_time'], $value->get_value())
            : $this->to_time($value->get_value());

        switch ($operator) {
            case Operators::EQ:
                $operator = Operators::BETWEEN;
                $value = new Value(
                    [
                        $time,
                        $time + DAY_IN_SECONDS - 1,
                    ],
                    Value::INT
                );

                break;
            default:
                $value = new Value($time, Value::INT);
        }

        return parent::get_meta_query(
            $operator,
            $value
        );
    }

    /**
     * @param  string  $value
     * @return int
     */
    private function to_time($value)
    {
        return (int) strtotime($value);
    }
}
