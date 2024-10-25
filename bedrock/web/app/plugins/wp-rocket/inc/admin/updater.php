<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

/**
 * Excludes WP Rocket from WP updates
 *
 * @since 1.0
 *
 * @param  array  $r  An array of HTTP request arguments.
 * @param  string  $url  The request URL.
 * @return array Updated array of HTTP request arguments.
 */
function rocket_updates_exclude($r, $url)
{
    if (strpos($url, 'http://api.wordpress.org/plugins/update-check') !== 0 || ! isset($r['body']['plugins'])) {
        return $r; // Not a plugin update request. Stop immediately.
    }

    $plugins = maybe_unserialize($r['body']['plugins']);

    if (isset($plugins->plugins[plugin_basename(WP_ROCKET_FILE)], $plugins->active[array_search(plugin_basename(WP_ROCKET_FILE), $plugins->active, true)])) {
        unset($plugins->plugins[plugin_basename(WP_ROCKET_FILE)]);
        unset($plugins->active[array_search(plugin_basename(WP_ROCKET_FILE), $plugins->active, true)]);
    }

    $r['body']['plugins'] = maybe_serialize($plugins);

    return $r;
}
add_filter('http_request_args', 'rocket_updates_exclude', 5, 2);

/**
 * Hack the returned object
 *
 * @since 1.0
 *
 * @param  false|object|array  $bool  The result object or array. Default false.
 * @param  string  $action  The type of information being requested from the Plugin Install API.
 * @param  object  $args  Plugin API arguments.
 * @return false|object|array Empty object if slug is WP Rocket, default value otherwise
 */
function rocket_force_info($bool, $action, $args)
{
    if ($action === 'plugin_information' && $args->slug === 'wp-rocket') {
        return new stdClass;
    }

    return $bool;
}
add_filter('plugins_api', 'rocket_force_info', 10, 3);

/**
 * Hack the returned result with our content
 *
 * @since 1.0
 *
 * @param  object|WP_Error  $res  Response object or WP_Error.
 * @param  string  $action  The type of information being requested from the Plugin Install API.
 * @param  object  $args  Plugin API arguments.
 * @return object|WP_Error Updated response object or WP_Error
 */
function rocket_force_info_result($res, $action, $args)
{
    if ($action === 'plugin_information' && isset($args->slug) && $args->slug === 'wp-rocket' && isset($res->external) && $res->external) {

        $request = wp_remote_post(
            WP_ROCKET_WEB_INFO, [
                'timeout' => 30,
                'action' => 'plugin_information',
                'request' => serialize($args),
            ]
        );

        if (is_wp_error($request)) {
            // translators: %s is an URL.
            $res = new WP_Error('plugins_api_failed', sprintf(__('An unexpected error occurred. Something may be wrong with WP-Rocket.me or this server&#8217;s configuration. If you continue to have problems, <a href="%s">contact support</a>.', 'rocket'), rocket_get_external_url('support')), $request->get_error_message());
        } else {
            $res = maybe_unserialize(wp_remote_retrieve_body($request));

            if (! is_object($res) && ! is_array($res)) {
                // translators: %s is an URL.
                $res = new WP_Error('plugins_api_failed', sprintf(__('An unexpected error occurred. Something may be wrong with WP-Rocket.me or this server&#8217;s configuration. If you continue to have problems, <a href="%s">contact support</a>.', 'rocket'), rocket_get_external_url('support')), wp_remote_retrieve_body($request));
            }
        }

        if (! is_wp_error($res) && rocket_is_white_label()) {

            $res = (array) $res;

            $res['name'] = get_rocket_option('wl_plugin_name');
            $res['slug'] = sanitize_key($res['name']);
            $res['author'] = get_rocket_option('wl_author');
            $res['homepage'] = get_rocket_option('wl_author_URI');
            $res['wl_plugin_URI'] = get_rocket_option('wl_plugin_URI');
            $res['author_profile'] = get_rocket_option('wl_author_URI');
            $res['sections']['changelog'] = str_replace(['wp-rocket', 'rocket_'], [$res['slug'], $res['slug'].'_'], $res['sections']['changelog']);
            $res['sections']['changelog'] = str_replace(['WP Rocket', 'WP&nbsp;Rocket', 'WP-Rocket'], $res['name'], $res['sections']['changelog']);
            $res['sections']['description'] = implode("\n", get_rocket_option('wl_description'));

            unset($res['sections']['installation'], $res['sections']['faq'], $res['contributors'], $res['banners']);

            $res = (object) $res;

        }
    }

    return $res;
}
add_filter('plugins_api_result', 'rocket_force_info_result', 10, 3);
