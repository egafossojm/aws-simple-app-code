<?php
/**
 * WPSEO plugin file.
 */

/**
 * Generate the HTML for a form element.
 */
interface Yoast_Form_Element
{
    /**
     * Return the HTML for the form element.
     *
     * @return string
     */
    public function get_html();
}
