<?php

defined('ABSPATH') || exit('Cheatin&#8217; uh?');

/**
 * Generate the content of advanced-cache.php file
 *
 * @since 2.1   Add filter rocket_advanced_cache_file
 * @since 2.0.3
 *
 * @return string $buffer The content of avanced-cache.php file
 */
function get_rocket_advanced_cache_file()
{
    $buffer = '<?php'."\n";
    $buffer .= 'defined( \'ABSPATH\' ) or die( \'Cheatin\\\' uh?\' );'."\n\n";

    // Add a constant to be sure this is our file.
    $buffer .= 'define( \'WP_ROCKET_ADVANCED_CACHE\', true );'."\n";

    // Get cache path.
    $buffer .= '$rocket_cache_path = \''.WP_ROCKET_CACHE_PATH.'\';'."\n";

    // Get config path.
    $buffer .= '$rocket_config_path = \''.WP_ROCKET_CONFIG_PATH.'\';'."\n\n";

    // Include the Mobile Detect class if we have to create a different caching file for mobile.
    if (is_rocket_generate_caching_mobile_files()) {
        $buffer .= 'if ( file_exists( \''.WP_ROCKET_VENDORS_PATH.'classes/class-rocket-mobile-detect.php'.'\' ) && ! class_exists( \'Rocket_Mobile_Detect\' ) ) {'."\n";
        $buffer .= "\t".'include_once \''.WP_ROCKET_VENDORS_PATH.'classes/class-rocket-mobile-detect.php'.'\';'."\n";
        $buffer .= '}'."\n";
    }

    // Include the process file in buffer.
    $buffer .= 'if ( file_exists( \''.WP_ROCKET_FRONT_PATH.'process.php'.'\' ) ) {'."\n";
    $buffer .= "\t".'include \''.WP_ROCKET_FRONT_PATH.'process.php'.'\';'."\n";
    $buffer .= '} else {'."\n";
    // Add a constant to provent include issue.
    $buffer .= "\t".'define( \'WP_ROCKET_ADVANCED_CACHE_PROBLEM\', true );'."\n";
    $buffer .= '}';

    /**
     * Filter the content of advanced-cache.php file
     *
     * @since 2.1
     *
     * @param  string  $buffer  The content that will be printed in advanced-cache.php.
     */
    $buffer = apply_filters('rocket_advanced_cache_file', $buffer);

    return $buffer;
}

/**
 * Create advanced-cache.php file
 *
 * @since 2.0
 *
 * @return void
 */
function rocket_generate_advanced_cache_file()
{
    rocket_put_content(WP_CONTENT_DIR.'/advanced-cache.php', get_rocket_advanced_cache_file());
}

/**
 * Generates the configuration file for the current domain based on the values ​​of options
 *
 * @since 2.0
 *
 * @return array Names of all config files & The content that will be printed
 */
function get_rocket_config_file()
{
    $options = get_option(WP_ROCKET_SLUG);

    if (! $options) {
        return;
    }

    $buffer = '<?php'."\n";
    $buffer .= 'defined( \'ABSPATH\' ) or die( \'Cheatin\\\' uh?\' );'."\n\n";

    if (apply_filters('rocket_override_min_documentRoot', false)) {
        /**
         * Filter the Document Root path to use during the minification
         *
         * @since 2.7
         *
         * @param string The Document Root path.
         */
        $min_documentroot = apply_filters('rocket_min_documentRoot', ABSPATH);

        $buffer .= '$min_documentRoot = \''.$min_documentroot.'\';'."\n";
    }

    if (apply_filters('rocket_override_min_cachepath', false)) {
        /**
         * Filter the temp directory path to use during the minification
         *
         * @since 2.8.3
         *
         * @param string The temp path, empty to leave Minify guessing it automatically.
         */
        $min_cachepath = apply_filters('rocket_min_cachePath', '');

        $buffer .= '$min_cachePath = \''.$min_cachepath.'\';'."\n";
    }

    /**
     * Filters the preservation of the CSS comments during minification
     *
     * @author Remy Perona
     *
     * @since 2.9
     *
     * @param bool False to not preserve the comments, true to preserve.
     */
    if (apply_filters('rocket_minification_preserve_css_comments', false)) {
        $buffer .= '$min_preserve_css_comments = true;'."\n";
    }

    $buffer .= '$rocket_cookie_hash = \''.COOKIEHASH.'\''.";\n";

    /**
     * Filters the activation of the common cache for logged-in users.
     *
     * @since 2.10
     *
     * @author Remy Perona
     *
     * @param bool True to activate the common cache, false to ignore.
     */
    if (apply_filters('rocket_common_cache_logged_users', false)) {
        $buffer .= '$rocket_common_cache_logged_users = 1;'."\n";
    }

    foreach ($options as $option => $value) {
        if ($option === 'cache_ssl' || $option === 'cache_mobile' || $option === 'do_caching_mobile_files' || $option === 'secret_cache_key') {
            $buffer .= '$rocket_'.$option.' = \''.$value.'\';'."\n";
        }

        if ($option === 'cache_reject_uri') {
            $buffer .= '$rocket_'.$option.' = \''.get_rocket_cache_reject_uri().'\';'."\n";
        }

        if ($option === 'cache_query_strings') {
            $buffer .= '$rocket_'.$option.' = '.var_export(get_rocket_cache_query_string(), true).';'."\n";
        }

        if ($option === 'cache_reject_cookies') {
            $cookies = get_rocket_cache_reject_cookies();

            if (get_rocket_option('cache_logged_user')) {
                $logged_in_cookie = str_replace(COOKIEHASH, '', LOGGED_IN_COOKIE);
                $cookies = str_replace($logged_in_cookie.'|', '', $cookies);
                $cookies = trim($cookies, '|');
            }

            $buffer .= '$rocket_'.$option.' = \''.$cookies.'\';'."\n";
        }

        if ($option === 'cache_reject_ua') {
            $buffer .= '$rocket_'.$option.' = \''.get_rocket_cache_reject_ua().'\';'."\n";
        }
    }

    $buffer .= '$rocket_cache_mandatory_cookies = '.var_export(get_rocket_cache_mandatory_cookies(), true).';'."\n";

    $buffer .= '$rocket_cache_dynamic_cookies = '.var_export(get_rocket_cache_dynamic_cookies(), true).';'."\n";

    /** This filter is documented in inc/front/htaccess.php */
    if (apply_filters('rocket_url_no_dots', false)) {
        $buffer .= '$rocket_url_no_dots = \'1\';';
    }

    $config_files_path = [];
    $urls = [home_url()];

    // Check if a translation plugin is activated and this configuration is in subdomain.
    $subdomains = get_rocket_i18n_subdomains();
    if ($subdomains) {
        $urls = $subdomains;
    }

    foreach ($urls as $url) {
        $file = get_rocket_parse_url(untrailingslashit($url));
        $file['path'] = (! empty($file['path'])) ? str_replace('/', '.', untrailingslashit($file['path'])) : '';
        $config_files_path[] = WP_ROCKET_CONFIG_PATH.strtolower($file['host']).$file['path'].'.php';
    }

    /**
     * Filter all config files path
     *
     * @since 2.6.5
     *
     * @param  array  $config_files_path  Path of all config files.
     */
    $config_files_path = apply_filters('rocket_config_files_path', $config_files_path);

    /**
     * Filter the content of all config files
     *
     * @since 2.1
     *
     * @param  string  $buffer  The content that will be printed.
     * @param  array  $config_files_path  Names of all config files.
     */
    $buffer = apply_filters('rocket_config_file', $buffer, $config_files_path);

    return [$config_files_path, $buffer];
}

/**
 * Create the current config domain file
 * For example, if home_url() return example.com, the config domain file will be in /config/example.com
 *
 * @since 2.0
 *
 * @return void
 */
function rocket_generate_config_file()
{
    [$config_files_path, $buffer] = get_rocket_config_file();

    if (count($config_files_path)) {
        foreach ($config_files_path as $file) {
            rocket_put_content($file, $buffer);
        }
    }
}

/**
 * Remove the current config domain file
 *
 * @since 2.6
 *
 * @return void
 */
function rocket_delete_config_file()
{
    [$config_files_path] = get_rocket_config_file();
    foreach ($config_files_path as $config_file) {
        rocket_direct_filesystem()->delete($config_file);
    }
}

/**
 * Create all cache folders (wp-rocket & min)
 *
 * @since 2.6
 *
 * @return void
 */
function rocket_init_cache_dir()
{
    global $is_apache;
    // Create cache folder if not exist.
    if (! rocket_direct_filesystem()->is_dir(WP_ROCKET_CACHE_PATH)) {
        rocket_mkdir_p(WP_ROCKET_CACHE_PATH);
    }

    if (! rocket_direct_filesystem()->is_file(WP_ROCKET_CACHE_PATH.'index.html')) {
        rocket_direct_filesystem()->touch(WP_ROCKET_CACHE_PATH.'index.html');
    }

    if ($is_apache) {
        $htaccess_path = WP_ROCKET_CACHE_PATH.'.htaccess';

        if (! rocket_direct_filesystem()->is_file($htaccess_path)) {
            rocket_direct_filesystem()->touch($htaccess_path);
            rocket_put_content($htaccess_path, "<IfModule mod_autoindex.c>\nOptions -Indexes\n</IfModule>");
        }
    }

    // Create minify cache folder if not exist.
    if (! rocket_direct_filesystem()->is_dir(WP_ROCKET_MINIFY_CACHE_PATH)) {
        rocket_mkdir_p(WP_ROCKET_MINIFY_CACHE_PATH);
    }

    // Create busting cache folder if not exist.
    if (! rocket_direct_filesystem()->is_dir(WP_ROCKET_CACHE_BUSTING_PATH)) {
        rocket_mkdir_p(WP_ROCKET_CACHE_BUSTING_PATH);
    }

    // Create critical CSS folder if not exist.
    if (! rocket_direct_filesystem()->is_dir(WP_ROCKET_CRITICAL_CSS_PATH)) {
        rocket_mkdir_p(WP_ROCKET_CRITICAL_CSS_PATH);
    }
}

/**
 * Create the config folder (wp-rocket-config)
 *
 * @since 2.6
 *
 * @return void
 */
function rocket_init_config_dir()
{
    // Create config domain folder if not exist.
    if (! rocket_direct_filesystem()->is_dir(WP_ROCKET_CONFIG_PATH)) {
        rocket_mkdir_p(WP_ROCKET_CONFIG_PATH);
    }
}

/**
 * Added or set the value of the WP_CACHE constant
 *
 * @since 2.0
 *
 * @param  bool  $turn_it_on  The value of WP_CACHE constant.
 * @return void
 */
function set_rocket_wp_cache_define($turn_it_on)
{
    // If WP_CACHE is already define, return to get a coffee.
    if (! rocket_valid_key() || ($turn_it_on && defined('WP_CACHE') && WP_CACHE)) {
        return;
    }

    // Get path of the config file.
    $config_file_path = rocket_find_wpconfig_path();
    if (! $config_file_path) {
        return;
    }

    // Get content of the config file.
    $config_file = file($config_file_path);

    // Get the value of WP_CACHE constant.
    $turn_it_on = $turn_it_on ? 'true' : 'false';

    /**
     * Filter allow to change the value of WP_CACHE constant
     *
     * @since 2.1
     *
     * @param  string  $turn_it_on  The value of WP_CACHE constant.
     */
    apply_filters('set_rocket_wp_cache_define', $turn_it_on);

    // Lets find out if the constant WP_CACHE is defined or not.
    $is_wp_cache_exist = false;

    // Get WP_CACHE constant define.
    $constant = "define('WP_CACHE', $turn_it_on); // Added by WP Rocket"."\r\n";

    foreach ($config_file as &$line) {
        if (! preg_match('/^define\(\s*\'([A-Z_]+)\',(.*)\)/', $line, $match)) {
            continue;
        }

        if ($match[1] === 'WP_CACHE') {
            $is_wp_cache_exist = true;
            $line = $constant;
        }
    }
    unset($line);

    // If the constant does not exist, create it.
    if (! $is_wp_cache_exist) {
        array_shift($config_file);
        array_unshift($config_file, "<?php\r\n", $constant);
    }

    // Insert the constant in wp-config.php file.
    $handle = @fopen($config_file_path, 'w');
    foreach ($config_file as $line) {
        @fwrite($handle, $line);
    }

    @fclose($handle);

    // Update the writing permissions of wp-config.php file.
    $chmod = defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : 0644;
    rocket_direct_filesystem()->chmod($config_file_path, $chmod);
}

/**
 * Delete all minify cache files
 *
 * @since 2.1
 *
 * @param  string|array  $extensions  (default: array('js','css') File extensions to minify.
 * @return void
 */
function rocket_clean_minify($extensions = ['js', 'css'])
{
    if (version_compare(PHP_VERSION, '5.3') < 0) {
        return;
    }

    $extensions = is_string($extensions) ? (array) $extensions : $extensions;
    try {
        $dir = new RecursiveDirectoryIterator(WP_ROCKET_MINIFY_CACHE_PATH.get_current_blog_id(), FilesystemIterator::SKIP_DOTS);
    } catch (Exception $e) {
        // No logging yet.
        return;
    }

    try {
        $iterator = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
    } catch (Exception $e) {
        // No logging yet.
        return;
    }

    foreach ($extensions as $ext) {
        /**
         * Fires before the minify cache files are deleted
         *
         * @since 2.1
         *
         * @param  string  $ext  File extensions to minify.
         */
        do_action('before_rocket_clean_minify', $ext);

        try {
            $files = new RegexIterator($iterator, '#.*\.'.$ext.'#', RegexIterator::GET_MATCH);
            foreach ($files as $file) {
                rocket_direct_filesystem()->delete($file[0]);
            }
        } catch (Exception $e) {
            // No logging yet.
            return;
        }

        /**
         * Fires after the minify cache files was deleted
         *
         * @since 2.1
         *
         * @param  string  $ext  File extensions to minify.
         */
        do_action('after_rocket_clean_minify', $ext);
    }

    foreach ($iterator as $item) {
        if (rocket_direct_filesystem()->is_dir($item)) {
            rocket_direct_filesystem()->delete($item);
        }
    }
}

/**
 * Delete all cache busting files
 *
 * @since 2.9
 *
 * @author Remy Perona
 *
 * @param  string|array  $extensions  (default: array('js','css') File extensions to clean.
 * @return void
 */
function rocket_clean_cache_busting($extensions = ['js', 'css'])
{
    if (version_compare(PHP_VERSION, '5.3') < 0) {
        return;
    }

    $extensions = is_string($extensions) ? (array) $extensions : $extensions;

    try {
        $dir = new RecursiveDirectoryIterator(WP_ROCKET_CACHE_BUSTING_PATH.get_current_blog_id(), FilesystemIterator::SKIP_DOTS);
    } catch (Exception $e) {
        // No logging yet.
        return;
    }

    try {
        $iterator = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
    } catch (Exception $e) {
        // No logging yet.
        return;
    }

    foreach ($extensions as $ext) {
        /**
         * Fires before the minify cache files are deleted
         *
         * @since 2.1
         *
         * @param  string  $ext  File extensions to minify.
         */
        do_action('before_rocket_clean_minify', $ext);

        try {
            $files = new RegexIterator($iterator, '#.*\.'.$ext.'#', RegexIterator::GET_MATCH);
            foreach ($files as $file) {
                rocket_direct_filesystem()->delete($file[0]);
            }
        } catch (Exception $e) {
            // No logging yet.
            return;
        }

        /**
         * Fires after the cache busting files was deleted
         *
         * @since 2.9
         *
         * @param  string  $ext  File extensions to clean.
         */
        do_action('after_rocket_clean_cache_busting', $ext);
    }

    foreach ($iterator as $item) {
        if (rocket_direct_filesystem()->is_dir($item)) {
            rocket_direct_filesystem()->delete($item);
        }
    }
}

/**
 * Delete one or several cache files
 *
 * @since 2.0   Delete cache files for all users
 * @since 1.1.0 Add filter rocket_clean_files
 * @since 1.0
 *
 * @param  string|array  $urls  URLs of cache files to be deleted.
 * @return void
 */
function rocket_clean_files($urls)
{
    if (is_string($urls)) {
        $urls = (array) $urls;
    }

    /**
     * Filter URLs that the cache file to be deleted
     *
     * @since 1.1.0
     *
     * @param array URLs that will be returned.
     */
    $urls = apply_filters('rocket_clean_files', $urls);
    $urls = array_filter($urls);

    foreach ($urls as $url) {
        /**
         * Fires before the cache file is deleted
         *
         * @since 1.0
         *
         * @param  string  $url  The URL that the cache file to be deleted.
         */
        do_action('before_rocket_clean_file', $url);

        /** This filter is documented in inc/front/htaccess.php */
        if (apply_filters('rocket_url_no_dots', false)) {
            $url = str_replace('.', '_', $url);
        }

        $dirs = glob(WP_ROCKET_CACHE_PATH.rocket_remove_url_protocol($url), GLOB_NOSORT);
        if ($dirs) {
            foreach ($dirs as $dir) {
                rocket_rrmdir($dir);
            }
        }

        /**
         * Fires after the cache file is deleted
         *
         * @since 1.0
         *
         * @param  string  $url  The URL that the cache file was deleted.
         */
        do_action('after_rocket_clean_file', $url);
    }
}

/**
 * Remove the home cache file and pagination
 *
 * $since 2.2 Add $lang argument
 *
 * @since 2.0 Delete cache files for all users
 * @since 1.0
 *
 * @param  string  $lang  (default: '') The language code.
 * @return void
 */
function rocket_clean_home($lang = '')
{
    $parse_url = get_rocket_parse_url(get_rocket_i18n_home_url($lang));

    /** This filter is documented in inc/front/htaccess.php */
    if (apply_filters('rocket_url_no_dots', false)) {
        $parse_url['host'] = str_replace('.', '_', $parse_url['host']);
    }

    $root = WP_ROCKET_CACHE_PATH.$parse_url['host'].'*'.untrailingslashit($parse_url['path']);

    /**
     * Filter the homepage caching folder root
     *
     * @since 2.6.5
     *
     * @param  array  $root  The root that will be returned.
     * @param  string  $host  The website host.
     * @param  string  $path  The website path.
     */
    $root = apply_filters('rocket_clean_home_root', $root, $parse_url['host'], $parse_url['path']);

    /**
     * Fires before the home cache file is deleted
     *
     * @since 1.0
     *
     * @param  string  $root  The path of home cache file.
     * @param  string  $lang  The current lang to purge.
     */
    do_action('before_rocket_clean_home', $root, $lang);

    // Delete homepage.
    $files = glob($root.'/{index,index-*}.{html,html_gzip}', GLOB_BRACE | GLOB_NOSORT);
    if ($files) {
        foreach ($files as $file) { // no array map to use @.
            rocket_direct_filesystem()->delete($file);
        }
    }

    // Delete homepage pagination.
    $dirs = glob($root.'*/'.$GLOBALS['wp_rewrite']->pagination_base, GLOB_NOSORT);
    if ($dirs) {
        foreach ($dirs as $dir) {
            rocket_rrmdir($dir);
        }
    }

    // Remove the hidden empty file for mobile detection on NGINX with the Rocket NGINX configuration.
    $nginx_mobile_detect_files = glob($root.'/.mobile-active', GLOB_BRACE | GLOB_NOSORT);
    if ($nginx_mobile_detect_files) {
        foreach ($nginx_mobile_detect_files as $nginx_mobile_detect_file) { // no array map to use @.
            rocket_direct_filesystem()->delete($nginx_mobile_detect_file);
        }
    }

    /**
     * Fires after the home cache file was deleted
     *
     * @since 1.0
     *
     * @param  string  $root  The path of home cache file.
     * @param  string  $lang  The current lang to purge.
     */
    do_action('after_rocket_clean_home', $root, $lang);
}

/**
 * Remove the home cache feed
 *
 * @since 2.7
 *
 * @return void
 */
function rocket_clean_home_feeds()
{

    $urls = [];
    $urls[] = get_feed_link();
    $urls[] = get_feed_link('comments_');

    /**
     * Filter the home feeds urls
     *
     * @since 2.7
     *
     * @param  array  $urls  The urls of the home feeds.
     */
    $urls = apply_filters('rocket_clean_home_feeds', $urls);

    /**
     * Fires before the home feeds cache is deleted
     *
     * @since 2.7
     *
     * @param  array  $urls  The urls of the home feeds.
     */
    do_action('before_rocket_clean_home_feeds', $urls);

    rocket_clean_files($urls);

    /**
     * Fires after the home feeds cache was deleted
     *
     * @since 2.7
     *
     * @param  array  $urls  The urls of the home feeds.
     */
    do_action('after_rocket_clean_home_feeds', $urls);
}

/**
 * Remove all cache files of the domain
 *
 * @since 2.0 Delete domain cache files for all users
 * @since 1.0
 *
 * @param  string  $lang  (default: '') The language code.
 * @return void
 */
function rocket_clean_domain($lang = '')
{
    $urls = (! $lang || is_object($lang) || is_array($lang)) ? get_rocket_i18n_uri() : get_rocket_i18n_home_url($lang);
    $urls = (array) $urls;

    /**
     * Filter URLs to delete all caching files from a domain
     *
     * @since 2.6.4
     *
     * @param array     URLs that will be returned.
     * @param string    The language code.
     */
    $urls = apply_filters('rocket_clean_domain_urls', $urls, $lang);
    $urls = array_filter($urls);

    foreach ($urls as $url) {
        $file = get_rocket_parse_url($url);

        /** This filter is documented in inc/front/htaccess.php */
        if (apply_filters('rocket_url_no_dots', false)) {
            $file['host'] = str_replace('.', '_', $file['host']);
        }

        $root = WP_ROCKET_CACHE_PATH.$file['host'].'*'.$file['path'];

        /**
         * Fires before all cache files are deleted
         *
         * @since 1.0
         *
         * @param  string  $root  The path of home cache file.
         * @param  string  $lang  The current lang to purge.
         * @param  string  $url  The home url.
         */
        do_action('before_rocket_clean_domain', $root, $lang, $url);

        // Delete cache domain files.
        $dirs = glob($root.'*', GLOB_NOSORT);
        if ($dirs) {
            foreach ($dirs as $dir) {
                rocket_rrmdir($dir, get_rocket_i18n_to_preserve($lang));
            }
        }

        /**
         * Fires after all cache files was deleted
         *
         * @since 1.0
         *
         * @param  string  $root  The path of home cache file.
         * @param  string  $lang  The current lang to purge.
         * @param  string  $url  The home url.
         */
        do_action('after_rocket_clean_domain', $root, $lang, $url);
    }
}

/**
 * Delete the caching files of a specific term
 *
 * $since 2.6.8
 *
 * @param  int  $term_id  The term ID.
 * @param  string  $taxonomy_slug  The taxonomy slug.
 * @return void
 */
function rocket_clean_term($term_id, $taxonomy_slug)
{
    $purge_urls = [];

    // Get all term infos.
    $term = get_term_by('id', $term_id, $taxonomy_slug);

    // Get the term language.
    $lang = false;

    // WPML.
    if (rocket_is_plugin_active('sitepress-multilingual-cms/sitepress.php') && ! rocket_is_plugin_active('woocommerce-multilingual/wpml-woocommerce.php')) {
        $lang = $GLOBALS['sitepress']->get_language_for_element($term_id, 'tax_'.$taxonomy_slug);

        // Polylang.
    } elseif (rocket_is_plugin_active('polylang/polylang.php') || rocket_is_plugin_active('polylang-pro/polylang.php')) {
        $lang = pll_get_term_language($term_id);
    }

    // Get permalink.
    $permalink = get_term_link($term, $taxonomy_slug);

    // Add permalink.
    if (rocket_extract_url_component($permalink, PHP_URL_PATH) !== '/') {
        array_push($purge_urls, $permalink);
    }

    /**
     * Fires before deleted caching files related with the term
     *
     * @since 2.6.8
     *
     * @param  obj  $term  The term object.
     * @param  array  $purge_urls  URLs cache files to remove.
     * @param  string  $lang  The term language.
     */
    do_action('before_rocket_clean_term', $term, $purge_urls, $lang);

    /**
     * Filter URLs cache files to remove
     *
     * @since 2.6.8
     *
     * @param  array  $purge_urls  List of URLs cache files to remove.
     * @param  obj  $term  The term object.
     */
    $purge_urls = apply_filters('rocket_term_purge_urls', $purge_urls, $term);

    // Purge all files.
    rocket_clean_files($purge_urls);

    // Never forget to purge homepage and their pagination.
    rocket_clean_home($lang);

    /**
     * Fires before deleted caching files related with the term
     *
     * @since 2.6.8
     *
     * @param  obj  $term  The term object.
     * @param  array  $purge_urls  URLs cache files to remove.
     * @param  string  $lang  The term language.
     */
    do_action('after_rocket_clean_term', $term, $purge_urls, $lang);
}

/**
 * Delete the caching files of a specific user
 *
 * $since 2.6.12
 *
 * @param  int  $user_id  The user ID.
 * @param  string  $lang  The language code.
 * @return void
 */
function rocket_clean_user($user_id, $lang = '')
{
    $urls = (! $lang || is_object($lang)) ? get_rocket_i18n_uri() : get_rocket_i18n_home_url($lang);
    $urls = (array) $urls;

    /** This filter is documented in inc/functions/files.php */
    $urls = apply_filters('rocket_clean_domain_urls', $urls, $lang);
    $urls = array_filter($urls);
    $user = get_user_by('id', $user_id);

    if (! $user) {
        return;
    }

    $user_key = $user->user_login.'-'.get_rocket_option('secret_cache_key');

    foreach ($urls as $url) {
        $parse_url = get_rocket_parse_url($url);

        /** This filter is documented in inc/front/htaccess.php */
        if (apply_filters('rocket_url_no_dots', false)) {
            $parse_url['host'] = str_replace('.', '_', $parse_url['host']);
        }

        $root = WP_ROCKET_CACHE_PATH.$parse_url['host'].'-'.$user_key.'*'.$parse_url['path'];

        /**
         * Fires before all caching files are deleted for a specific user
         *
         * @since 2.6.12
         *
         * @param  int  $user_id  The path of home cache file.
         * @param  string  $lang  The language code.
         */
        do_action('before_rocket_clean_user', $user_id, $lang);

        // Delete cache domain files.
        $dirs = glob($root.'*', GLOB_NOSORT);
        if ($dirs) {
            foreach ($dirs as $dir) {
                rocket_rrmdir($dir, get_rocket_i18n_to_preserve($lang));
            }
        }

        /**
         * Fires after all caching files are deleted for a specific user
         *
         * @since 2.6.12
         *
         * @param  int  $user_id  The path of home cache file.
         * @param  string  $lang  The language code.
         */
        do_action('after_rocket_clean_user', $user_id, $lang);
    }
}

/**
 * Remove all caching files in the cache folder
 *
 * @since 2.6.8
 *
 * @return void
 */
function rocket_clean_cache_dir()
{
    /**
     * Fires before deleting all caching files in the cache folder
     *
     * @since 2.6.8
     */
    do_action('before_rocket_clean_cache_dir');

    // Delete all caching files.
    $dirs = glob(WP_ROCKET_CACHE_PATH.'*', GLOB_NOSORT);
    if ($dirs) {
        foreach ($dirs as $dir) {
            rocket_rrmdir($dir);
        }
    }

    /**
     * Fires after deleting all caching files in the cache folder
     *
     * @since 2.6.8
     */
    do_action('after_rocket_clean_cache_dir');
}

/**
 * Remove a single file or a folder recursively
 *
 * @since 1.0
 *
 * @param  string  $dir  File/Directory to delete.
 * @param  array  $dirs_to_preserve  (default: array()) Dirs that should not be deleted.
 * @return void
 */
function rocket_rrmdir($dir, $dirs_to_preserve = [])
{
    $dir = untrailingslashit($dir);

    /**
     * Fires before a file/directory cache is deleted
     *
     * @since 1.1.0
     *
     * @param  string  $dir  File/Directory to delete.
     * @param  array  $dirs_to_preserve  Directories that should not be deleted.
     */
    do_action('before_rocket_rrmdir', $dir, $dirs_to_preserve);

    // Remove the hidden empty file for mobile detection on NGINX with the Rocket NGINX configuration.
    $nginx_mobile_detect_file = $dir.'/.mobile-active';

    if (rocket_direct_filesystem()->is_dir($dir) && rocket_direct_filesystem()->exists($nginx_mobile_detect_file)) {
        rocket_direct_filesystem()->delete($nginx_mobile_detect_file);
    }

    if (! rocket_direct_filesystem()->is_dir($dir)) {
        rocket_direct_filesystem()->delete($dir);

        return;
    }

    $dirs = glob($dir.'/*', GLOB_NOSORT);
    if ($dirs) {

        $keys = [];
        foreach ($dirs_to_preserve as $dir_to_preserve) {
            $matches = preg_grep("#^$dir_to_preserve$#", $dirs);
            $keys[] = reset($matches);
        }

        $dirs = array_diff($dirs, array_filter($keys));
        foreach ($dirs as $dir) {
            if (rocket_direct_filesystem()->is_dir($dir)) {
                rocket_rrmdir($dir, $dirs_to_preserve);
            } else {
                rocket_direct_filesystem()->delete($dir);
            }
        }
    }

    rocket_direct_filesystem()->delete($dir);

    /**
     * Fires after a file/directory cache was deleted
     *
     * @since 1.1.0
     *
     * @param  string  $dir  File/Directory to delete.
     * @param  array  $dirs_to_preserve  Dirs that should not be deleted.
     */
    do_action('after_rocket_rrmdir', $dir, $dirs_to_preserve);
}

/**
 * Instanciate the filesystem class
 *
 * @since 2.10
 *
 * @return object WP_Filesystem_Direct instance
 */
function rocket_direct_filesystem()
{
    require_once ABSPATH.'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH.'wp-admin/includes/class-wp-filesystem-direct.php';

    return new WP_Filesystem_Direct(new StdClass);
}

/**
 * Directory creation based on WordPress Filesystem
 *
 * @since 1.3.4
 *
 * @param  string  $dir  The path of directory will be created.
 * @return bool
 */
function rocket_mkdir($dir)
{
    $chmod = defined('FS_CHMOD_DIR') ? FS_CHMOD_DIR : (fileperms(WP_CONTENT_DIR) & 0777 | 0755);

    return rocket_direct_filesystem()->mkdir($dir, $chmod);
}

/**
 * Recursive directory creation based on full path.
 *
 * @since 1.3.4
 *
 * @source wp_mkdir_p() in /wp-includes/functions.php
 *
 * @param  string  $target  path to the directory we want to create.
 * @return bool True if directory is created/exists, false otherwise
 */
function rocket_mkdir_p($target)
{
    // from php.net/mkdir user contributed notes.
    $target = str_replace('//', '/', $target);

    // safe mode fails with a trailing slash under certain PHP versions.
    $target = untrailingslashit($target);
    if (empty($target)) {
        $target = '/';
    }

    if (rocket_direct_filesystem()->exists($target)) {
        return rocket_direct_filesystem()->is_dir($target);
    }

    // Attempting to create the directory may clutter up our display.
    if (rocket_mkdir($target)) {
        return true;
    } elseif (rocket_direct_filesystem()->is_dir(dirname($target))) {
        return false;
    }

    // If the above failed, attempt to create the parent node, then try again.
    if (($target !== '/') && (rocket_mkdir_p(dirname($target)))) {
        return rocket_mkdir_p($target);
    }

    return false;
}

/**
 * File creation based on WordPress Filesystem
 *
 * @since 1.3.5
 *
 * @param  string  $file  The path of file will be created.
 * @param  string  $content  The content that will be printed in advanced-cache.php.
 * @return bool
 */
function rocket_put_content($file, $content)
{
    $chmod = defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : 0644;

    return rocket_direct_filesystem()->put_contents($file, $content, $chmod);
}

/**
 * Try to find the correct wp-config.php file, support one level up in filetree
 *
 * @since 2.1
 *
 * @return string|bool The path of wp-config.php file or false if not found
 */
function rocket_find_wpconfig_path()
{
    /**
     * Filter the wp-config's filename
     *
     * @since 2.11
     *
     * @author Maxime Culea
     *
     * @param  string  $filename  The WP Config filename, without the extension.
     */
    $config_file_name = apply_filters('rocket_wp_config_name', 'wp-config');
    $config_file = ABSPATH.$config_file_name.'.php';
    $config_file_alt = dirname(ABSPATH).'/'.$config_file_name.'.php';

    if (rocket_direct_filesystem()->exists($config_file) && rocket_direct_filesystem()->is_writable($config_file)) {
        return $config_file;
    } elseif (rocket_direct_filesystem()->exists($config_file_alt) && rocket_direct_filesystem()->is_writable($config_file_alt) && ! rocket_direct_filesystem()->exists(dirname(ABSPATH).'/wp-settings.php')) {
        return $config_file_alt;
    }

    // No writable file found.
    return false;
}

/**
 * Get WP Rocket footprint
 *
 * @since 2.0
 *
 * @param  bool  $debug  (default: true) If true, adds the date of generation cache file.
 * @return string The footprint that will be printed
 */
function get_rocket_footprint($debug = true)
{
    $footprint = ! rocket_is_white_label() ?
                    "\n".'<!-- This website is like a Rocket, isn\'t it? Performance optimized by WP Rocket. Learn more: https://wp-rocket.me' :
                    "\n".'<!-- Cached page for great performance';
    if ($debug) {
        $footprint .= ' - Debug: cached@'.time();
    }
    $footprint .= ' -->';

    return $footprint;
}

/**
 * Fetch and save the cache busting file content
 *
 * @since 2.10
 *
 * @author Remy Perona
 *
 * @param  string  $src  Original URL of the asset.
 * @param  array  $cache_busting_paths  Paths used to generated the cache busting file.
 * @param  string  $abspath_src  Absolute path to the asset.
 * @param  string  $current_filter  Current filter value.
 * @return bool true if successful, false otherwise
 */
function rocket_fetch_and_cache_busting($src, $cache_busting_paths, $abspath_src, $current_filter)
{
    if (wp_is_stream($src)) {
        $response = wp_remote_get($src);
        $content = wp_remote_retrieve_body($response);
    } else {
        $content = rocket_direct_filesystem()->get_contents($src);
    }

    if (! $content) {
        return false;
    }

    if ($current_filter === 'style_loader_src') {
        // Rewrite import/url in CSS content to add the absolute path to the file.
        $content = Minify_CSS_UriRewriter::rewrite($content, dirname($abspath_src));
    }

    if (! rocket_direct_filesystem()->is_dir($cache_busting_paths['bustingpath'])) {
        rocket_mkdir_p($cache_busting_paths['bustingpath']);
    }

    rocket_mkdir_p(dirname($cache_busting_paths['filepath']));

    return rocket_put_content($cache_busting_paths['filepath'], $content);
}
