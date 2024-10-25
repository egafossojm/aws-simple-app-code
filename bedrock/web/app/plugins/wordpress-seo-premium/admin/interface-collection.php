<?php
/**
 * WPSEO plugin file.
 */

/**
 * Interface that represents a collection.
 */
interface WPSEO_Collection
{
    /**
     * Returns the collection data.
     *
     * @return array The collection data.
     */
    public function get();
}
