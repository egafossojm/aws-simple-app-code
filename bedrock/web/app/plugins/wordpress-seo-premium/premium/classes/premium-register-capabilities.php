<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Capabilities registration class.
 */
class WPSEO_Premium_Register_Capabilities implements WPSEO_WordPress_Integration
{
    /**
     * Registers the hooks.
     *
     * @return void
     */
    public function register_hooks()
    {
        add_action('wpseo_register_capabilities', [$this, 'register']);
    }

    /**
     * Registers the capabilities.
     *
     * @return void
     */
    public function register()
    {
        $manager = WPSEO_Capability_Manager_Factory::get();

        $manager->register('wpseo_manage_redirects', ['editor', 'wpseo_editor', 'wpseo_manager']);
    }
}
