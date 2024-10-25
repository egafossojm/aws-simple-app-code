<?php

namespace ACP\Export;

use AC;
use AC\Registrable;
use ACP\Asset\Enqueueable;

class Settings implements Registrable
{
    /**
     * @var Enqueueable
     */
    protected $assets;

    public function __construct(array $assets)
    {
        $this->assets = $assets;
    }

    public function register()
    {
        add_action('ac/column/settings', [$this, 'column_settings']);
        add_action('ac/settings/scripts', [$this, 'admin_scripts']);
    }

    public function column_settings(AC\Column $column)
    {
        $setting = new Settings\Column($column);
        $setting->set_default('on');

        $column->add_setting($setting);
    }

    public function admin_scripts()
    {
        foreach ($this->assets as $asset) {
            $asset->enqueue();
        }
    }
}
