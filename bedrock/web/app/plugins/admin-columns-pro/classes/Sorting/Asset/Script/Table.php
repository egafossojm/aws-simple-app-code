<?php

namespace ACP\Sorting\Asset\Script;

use ACP\Asset\Location;
use ACP\Asset\Script;
use ACP\Sorting\Table\Preference;

final class Table extends Script
{
    /** @var Preference */
    private $preference;

    /**
     * @param  string  $handle
     */
    public function __construct($handle, Location $location, Preference $preference)
    {
        parent::__construct($handle, $location, ['jquery']);

        $this->preference = $preference;
    }

    public function register()
    {
        parent::register();

        wp_localize_script($this->get_handle(), 'ACP_Sorting', [
            'order' => $this->preference->get_order(),
            'orderby' => $this->preference->get_order_by(),
        ]);
    }
}
