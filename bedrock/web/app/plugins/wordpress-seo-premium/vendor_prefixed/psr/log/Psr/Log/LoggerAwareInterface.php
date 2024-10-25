<?php

namespace YoastSEO_Vendor\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     *
     * @return void
     */
    public function setLogger(\YoastSEO_Vendor\Psr\Log\LoggerInterface $logger);
}
