<?php
/**
 * WPSEO plugin file.
 */

/**
 * Generates the HTML for a metabox tab.
 */
class WPSEO_Metabox_Null_Tab implements WPSEO_Metabox_Tab
{
    /**
     * Returns the html for the tab link.
     *
     * @return string
     */
    public function link()
    {
        return null;
    }

    /**
     * Returns the html for the tab content.
     *
     * @return string
     */
    public function content()
    {
        return null;
    }
}
