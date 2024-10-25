<?php
/**
 * File with the class to handle data from Ultimate SEO.
 */

/**
 * Class with functionality to import & clean Ultimate SEO post metadata.
 */
class WPSEO_Import_Greg_SEO extends WPSEO_Plugin_Importer
{
    /**
     * The plugin name.
     *
     * @var string
     */
    protected $plugin_name = "Greg's High Performance SEO";

    /**
     * Meta key, used in SQL LIKE clause for delete query.
     *
     * @var string
     */
    protected $meta_key = '_ghpseo_%';

    /**
     * Array of meta keys to detect and import.
     *
     * @var array
     */
    protected $clone_keys = [
        [
            'old_key' => '_ghpseo_alternative_description',
            'new_key' => 'metadesc',
        ],
        [
            'old_key' => '_ghpseo_secondary_title',
            'new_key' => 'title',
        ],
    ];
}
