<?php

namespace AC;

use LogicException;

abstract class TypedArrayIterator extends ArrayIterator
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @param  string  $type  Type to validate the collection against
     */
    public function __construct(array $array, $type)
    {
        parent::__construct($array);

        $this->type = $type;
    }

    /**
     * Optional validation when a type was set
     *
     * @throws LogicException
     */
    protected function validate()
    {
        foreach ($this as $value) {
            $this->validate_type($value);
        }
    }

    protected function validate_type($value)
    {
        if (! $value instanceof $this->type) {
            throw new LogicException(sprintf('Found object that is not a %s.', $this->type));
        }
    }
}
