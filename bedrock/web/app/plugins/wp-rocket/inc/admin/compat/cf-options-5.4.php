<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

$cf_instance = get_rocket_cloudflare_api_instance();
if (! is_wp_error($cf_instance)) {
    try {
        $zone_instance = new Cloudflare\Zone($cf_instance);
        $zone = $zone_instance->zones($newvalue['cloudflare_domain']);

        if (isset($zone->result[0]->id)) {
            $newvalue['cloudflare_zone_id'] = $zone->result[0]->id;
        }
    } catch (Exception $e) {
        return false;
    }
}
