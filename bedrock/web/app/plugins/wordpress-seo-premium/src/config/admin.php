<?php
/**
 * Loads the integrations needed by the WordPress Admin.
 */

namespace Yoast\WP\Free\Config;

use Yoast\WP\Free\Watchers;
use Yoast\WP\Free\WordPress\Integration;
use Yoast\WP\Free\WordPress\Integration_Group;

/**
 * Load Admin integrations.
 */
class Admin implements Integration
{
    /**
     * Initializes the integration.
     *
     * This is the place to register hooks and filters.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    public function register_hooks()
    {
        $integration_group = new Integration_Group(
            [
                new Watchers\Indexable_Post_Watcher,
                new Watchers\Indexable_Term_Watcher,
                new Watchers\Indexable_Author_Watcher,
                new Watchers\Primary_Term_Watcher,
            ]
        );
        $integration_group->register_hooks();
    }
}
