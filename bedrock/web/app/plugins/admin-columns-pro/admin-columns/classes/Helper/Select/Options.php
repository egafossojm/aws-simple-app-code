<?php

namespace AC\Helper\Select;

use AC\ArrayIterator;
use LogicException;

class Options extends ArrayIterator
{
    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->validate();
    }

    private function validate()
    {
        foreach ($this as $option) {
            if (! $option instanceof Option && ! $option instanceof OptionGroup) {
                throw new LogicException('Only Option and OptionGroup objects allowed.');
            }
        }
    }

    /**
     * @return Options
     */
    public static function create_from_array(array $array)
    {
        $options = [];

        foreach ($array as $key => $value) {
            $options[] = new Option($key, $value);
        }

        return new self($options);
    }
}
