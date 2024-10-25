<?php

/**
 * Presenter for the quick edit
 */
class WPSEO_Redirect_Quick_Edit_Presenter
{
    /**
     * Displays the table
     *
     * @param  array  $display  Data to display on the table.
     */
    public function display(array $display = [])
    {

        // @codingStandardsIgnoreStart
        extract($display);
        // @codingStandardsIgnoreEnd

        require WPSEO_PREMIUM_PATH.'classes/redirect/views/redirects-quick-edit.php';
    }
}
