<?php

namespace DeliciousBrains\WP_Offload_Media\Providers;

use AS3CF_Error;

class Null_Provider
{
    /**
     * Log and fail calls to instance methods.
     *
     *
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        AS3CF_Error::log($arguments, __CLASS__."->$name()");
        throw new \Exception('Failed to instantiate the provider client. Check your error log.');
    }

    /**
     * Log and fail calls to static methods.
     *
     *
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        AS3CF_Error::log($arguments, __CLASS__."::$name()");
        throw new \Exception('Failed to instantiate the provider client. Check your error log.');
    }
}
