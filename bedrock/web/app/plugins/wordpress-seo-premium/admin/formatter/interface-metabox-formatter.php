<?php
/**
 * WPSEO plugin file.
 */

/**
 * Interface to force get_values.
 */
interface WPSEO_Metabox_Formatter_Interface
{
    /**
     * Returns formatter values.
     *
     * @return array
     */
    public function get_values();
}
