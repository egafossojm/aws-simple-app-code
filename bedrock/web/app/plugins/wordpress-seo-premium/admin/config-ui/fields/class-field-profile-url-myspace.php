<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_Config_Field_Profile_URL_MySpace.
 */
class WPSEO_Config_Field_Profile_URL_MySpace extends WPSEO_Config_Field
{
    /**
     * WPSEO_Config_Field_Profile_URL_MySpace constructor.
     */
    public function __construct()
    {
        parent::__construct('profileUrlMySpace', 'Input');

        $this->set_property('label', __('MySpace URL', 'wordpress-seo'));
        $this->set_property('pattern', '^https:\/\/myspace\.com\/([^/]+)\/$');

        $this->set_requires('publishingEntityType', 'company');
    }

    /**
     * Set adapter.
     *
     * @param  WPSEO_Configuration_Options_Adapter  $adapter  Adapter to register lookup on.
     */
    public function set_adapter(WPSEO_Configuration_Options_Adapter $adapter)
    {
        $adapter->add_option_lookup($this->get_identifier(), 'myspace_url');
    }
}
