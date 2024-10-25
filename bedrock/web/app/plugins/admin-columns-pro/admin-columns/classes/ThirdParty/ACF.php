<?php

namespace AC\ThirdParty;

use AC\Registrable;

class ACF implements Registrable
{
    public function register()
    {
        add_filter('ac/post_types', [$this, 'remove_acf_field_group']);
    }

    /**
     * Fix which remove the Advanced Custom Fields Type (acf) from the admin columns settings page
     *
     * @since 2.0
     *
     * @return array Post Types
     */
    public function remove_acf_field_group($post_types)
    {
        if (class_exists('Acf', false)) {
            if (isset($post_types['acf'])) {
                unset($post_types['acf']);
            }
            if (isset($post_types['acf-field-group'])) {
                unset($post_types['acf-field-group']);
            }
        }

        return $post_types;
    }
}
