<?php

namespace ACP\Search;

use ACP\Search\Query\Bindings;
use LogicException;

abstract class Comparison
{
    /**
     * @var Labels
     */
    protected $labels;

    /**
     * @var Operators
     */
    protected $operators;

    /**
     * @var string
     */
    protected $value_type;

    /**
     * @param  string  $value_type
     */
    public function __construct(Operators $operators, $value_type = null, ?Labels $labels = null)
    {
        if ($labels === null) {
            $labels = new Labels;
        }

        if ($value_type === null) {
            $value_type = Value::STRING;
        }

        $this->labels = $labels;
        $this->value_type = $value_type;
        $this->operators = $operators;

        $this->validate_value_type();
    }

    private function validate_value_type()
    {
        $value_types = [
            Value::DATE,
            Value::INT,
            Value::DECIMAL,
            Value::STRING,
        ];

        if (! in_array($this->value_type, $value_types)) {
            throw new LogicException('Unsupported value type found.');
        }
    }

    /**
     * @return Operators
     */
    public function get_operators()
    {
        return $this->operators;
    }

    /**
     * @return string
     */
    public function get_value_type()
    {
        return $this->value_type;
    }

    /**
     * @return array
     */
    public function get_labels()
    {
        $labels = [];

        foreach ($this->get_operators() as $operator) {
            $labels[$operator] = $this->labels->get_offset($operator);
        }

        return $labels;
    }

    /**
     * @param  string  $operator
     * @return Bindings
     */
    final public function get_query_bindings($operator, Value $value)
    {
        if ($this->operators->search($operator) === false) {
            throw new LogicException('Unsupported operator found.');
        }

        if ($this->value_type !== $value->get_type()) {
            throw new LogicException('Value types are not identical.');
        }

        return $this->create_query_bindings($operator, $value);
    }

    /**
     * @param  string  $operator
     * @return Bindings
     */
    abstract protected function create_query_bindings($operator, Value $value);
}
