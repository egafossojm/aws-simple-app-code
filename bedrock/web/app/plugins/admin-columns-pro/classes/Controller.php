<?php

namespace ACP;

use AC\Request;

abstract class Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function dispatch($action)
    {
        $method = $action.'_action';

        if (! is_callable([$this, $method])) {
            throw Exception\Controller::from_invalid_action($action);
        }

        $this->$method();
    }
}
