<?php
/**
 * WPSEO plugin file.
 */

/**
 * Represents the interface for an installable object.
 */
interface WPSEO_Installable
{
    /**
     * Runs the installation routine.
     *
     * @return void
     */
    public function install();
}
