<?php

namespace ACP\Search;

abstract class Filter
{
    /**
     * @var string
     */
    protected $name;

    /** @var Comparison */
    protected $comparison;

    /** @var string */
    protected $label;

    /**
     * @param  string  $name
     * @param  string  $label
     */
    public function __construct($name, Comparison $comparison, $label)
    {
        $this->name = $name;
        $this->comparison = $comparison;
        $this->label = $label;
    }

    abstract public function __invoke();
}
