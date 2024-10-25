<?php
/**
 * WPSEO plugin file.
 */

/**
 * Sitemap Cache Data object, manages sitemap data stored in cache.
 */
class WPSEO_Sitemap_Cache_Data implements Serializable, WPSEO_Sitemap_Cache_Data_Interface
{
    /**
     * Sitemap XML data.
     *
     * @var string
     */
    private $sitemap = '';

    /**
     * Status of the sitemap, usable or not.
     *
     * @var string
     */
    private $status = self::UNKNOWN;

    /**
     * Set the sitemap XML data
     *
     * @param  string  $sitemap  XML Content of the sitemap.
     */
    public function set_sitemap($sitemap)
    {

        if (! is_string($sitemap)) {
            $sitemap = '';
        }

        $this->sitemap = $sitemap;

        /*
         * Empty sitemap is not usable.
         */
        if (! empty($sitemap)) {
            $this->set_status(self::OK);
        } else {
            $this->set_status(self::ERROR);
        }
    }

    /**
     * Set the status of the sitemap, is it usable.
     *
     * @param  bool|string  $valid  Is the sitemap valid or not.
     * @return void
     */
    public function set_status($valid)
    {

        if ($valid === self::OK) {
            $this->status = self::OK;

            return;
        }

        if ($valid === self::ERROR) {
            $this->status = self::ERROR;
            $this->sitemap = '';

            return;
        }

        $this->status = self::UNKNOWN;
    }

    /**
     * Is the sitemap usable.
     *
     * @return bool True if usable, False if bad or unknown.
     */
    public function is_usable()
    {

        return $this->status === self::OK;
    }

    /**
     * Get the XML content of the sitemap.
     *
     * @return string The content of the sitemap.
     */
    public function get_sitemap()
    {

        return $this->sitemap;
    }

    /**
     * Get the status of the sitemap.
     *
     * @return string Status of the sitemap, 'ok'/'error'/'unknown'.
     */
    public function get_status()
    {

        return $this->status;
    }

    /**
     * String representation of object.
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     * @since 5.1.0
     *
     * @return string The string representation of the object or null.
     */
    public function serialize()
    {

        $data = [
            'status' => $this->status,
            'xml' => $this->sitemap,
        ];

        return serialize($data);
    }

    /**
     * Constructs the object.
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @since 5.1.0
     *
     * @param  string  $serialized  The string representation of the object.
     * @return void
     */
    public function unserialize($serialized)
    {

        $data = unserialize($serialized);
        $this->set_sitemap($data['xml']);
        $this->set_status($data['status']);
    }
}
