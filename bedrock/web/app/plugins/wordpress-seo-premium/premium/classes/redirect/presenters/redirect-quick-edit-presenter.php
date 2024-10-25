<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Presenter for the quick edit
 */
class WPSEO_Redirect_Quick_Edit_Presenter implements WPSEO_Redirect_Presenter
{
    /**
     * Displays the table
     *
     * @param  array  $display  Data to display on the table.
     * @return void
     */
    public function display(array $display = [])
    {

        extract($display);

        require WPSEO_PREMIUM_PATH.'classes/redirect/views/redirects-quick-edit.php';
    }
}
