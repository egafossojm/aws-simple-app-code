<?php

namespace ACP\Helper\Select\Options;

use AC;
use AC\ArrayIterator;

/**
 * @deprecated use AC\Helper\Select\Options\Paginated instead
 */
class Paginated extends AC\Helper\Select\Options\Paginated
{
    public function __construct(AC\Helper\Select\Paginated $paginated, ArrayIterator $options)
    {
        parent::__construct($paginated, $options);
    }
}
