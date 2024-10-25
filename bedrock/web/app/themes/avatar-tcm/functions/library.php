<?php
/**
 * Custom Functions, general
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
/* -------------------------------------------------------------
 * Remove WordPress Core Update notification
 * ============================================================*/
if (! function_exists('avatar_remove_core_updates')) {

    function avatar_remove_core_updates()
    {
        if (! current_user_can('update_core')) {
            return;
        }
        add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
        add_filter('pre_option_update_core', '__return_null');
        add_filter('pre_site_transient_update_core', '__return_null');
        add_filter('xmlrpc_enabled', '__return_false');
    }
    add_action('after_setup_theme', 'avatar_remove_core_updates');
}

/* -------------------------------------------------------------
 * Enable svg support
 * ============================================================*/

if (! function_exists('avatar_add_svg_mime_types')) {
    /**
     * @param  $mimes  - MIME file type
     * @return mixed
     */
    function avatar_add_svg_mime_types($mimes)
    {

        if (is_super_admin()) {
            $mimes['svg'] = 'image/svg+xml';
        }

        return $mimes;
    }
    add_filter('upload_mimes', 'avatar_add_svg_mime_types');
}

/* -------------------------------------------------------------
 * Test if the post ID is Feature
 * ============================================================*/

if (! function_exists('avatar_is_feature')) {
    /**
     * @param  $post_id  - Post ID
     * @return bool|mixed|null|void
     */
    function avatar_is_feature($post_id)
    {

        $is_ = false;
        if (get_field('acf_article_type', $post_id) == 'feature') {
            $is_ = get_field('acf_article_feature', $post_id);
        }

        return $is_;
    }
}

/* -------------------------------------------------------------
 * Test if the feature ID is Partner
 * ============================================================*/
if (! function_exists('avatar_is_partner')) {
    /**
     * @param  $post_id  Post ID
     * @return bool|mixed|null|void
     */
    function avatar_is_partner($post_id)
    {

        $is_ = false;
        $feature = avatar_is_feature($post_id);
        if ($feature and get_field('acf_feature_ispartner', $feature->ID)) {
            $is_ = get_field('acf_feature_partner', $feature->ID);
        }

        return $is_;
    }
}

/* -------------------------------------------------------------
 * Test if the post ID is Brand (brandknowledge)
 * ============================================================*/

if (! function_exists('avatar_is_brand')) {
    /**
     * @param  $post_id  - Post ID
     * @return bool|mixed|null|void
     */
    function avatar_is_brand($post_id)
    {

        $is_ = false;

        if (get_field('acf_article_type', $post_id) == 'brand') {
            $is_ = get_field('acf_article_brand', $post_id);
        }

        return $is_;
    }
}

/* -------------------------------------------------------------
 * Test if is Columnist
 * ============================================================*/

if (! function_exists('avatar_is_columnist')) {
    /**
     * @param  $post_id  - Post ID
     * @return bool|mixed|null|void
     */
    function avatar_is_columnist($post_id)
    {

        $is_ = false;

        $is_id = get_field('acf_article_author', $post_id);
        if (is_array($is_id) && ! empty($is_id)) {
            $is_id = $is_id[0];
        }
        if (get_field('acf_author_is_columnist', $is_id)) {
            $is_ = $is_id;
        }

        return $is_;
    }
}

/* -------------------------------------------------------------
 * Test if the post ID is Microsite (microsite)
 * ============================================================*/

if (! function_exists('avatar_is_microsite')) {
    /**
     * @param  $post_id  - Post ID
     * @return bool|mixed|null|void
     */
    function avatar_is_microsite($post_id)
    {

        $is_ = false;

        if (get_field('acf_article_type', $post_id) == 'microsite') {
            $is_ = get_field('acf_article_microsite', $post_id);
        }

        return $is_;
    }
}

/* -------------------------------------------------------------
 * Send Emails
 * ============================================================*/

if (! function_exists('avatar_send_email')) {
    /**
     * @param  $to  - email address
     * @param  $subject  - email subject
     * @param  $body  - email body content
     */
    function avatar_send_email($to, $subject, $body, $headers = '')
    {

        add_filter('wp_mail_content_type', 'avatar_set_email_content_type');

        $send_now = wp_mail($to, $subject, $body, $headers);

        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter('wp_mail_content_type', 'avatar_set_email_content_type');

    }
}

/* -------------------------------------------------------------
 * Set Email Content Type to text/html
 * ============================================================*/

if (! function_exists('avatar_set_email_content_type')) {
    /**
     * @return string
     */
    function avatar_set_email_content_type($content_type)
    {
        return 'text/html';
    }
}

/* -------------------------------------------------------------
 * Rename Array key
 * ============================================================*/

if (! function_exists('avatar_rename_arr_key')) {
    /**
     * @return bool
     */
    function avatar_rename_arr_key($oldkey, $newkey, array &$arr)
    {

        if (array_key_exists($oldkey, $arr)) {

            $arr[$newkey] = $arr[$oldkey];
            unset($arr[$oldkey]);

            return true;
        } else {
            return false;
        }
    }
}

/* -------------------------------------------------------------
 * Test if the string is sha1
 * ============================================================*/

if (! function_exists('avatar_is_sha1')) {
    /**
     * @param  $str  string to verify
     * @return bool
     */
    function avatar_is_sha1($str)
    {

        return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    }
}

/* -------------------------------------------------------------
 * Get current URL
 * ============================================================*/

if (! function_exists('avatar_get_current_url')) {
    /**
     * @param  $arg  ex: array( "p=koinkoin" )
     * @return string|void
     */
    function avatar_get_current_url($arg = [])
    {
        global $wp;

        return esc_url(home_url(add_query_arg([$arg], $wp->request)));
    }
}

/* -------------------------------------------------------------
 * Stay logged in for longer periods
 * ============================================================*/
if (! function_exists('avatar_keep_me_logged_in')) {
    /**
     * @return int
     */
    function avatar_keep_me_logged_in($expirein)
    {
        return 31556926; // 1 year in seconds
    }

    add_filter('auth_cookie_expiration', 'avatar_keep_me_logged_in');
}

/* -------------------------------------------------------------
 * Hide Toolbar when viewing site for all users (except for admins)
 * ============================================================*/
if (! function_exists('avatar_hide_admin_bar')) {
    /**
     * @return bool
     */
    function avatar_hide_admin_bar()
    {

        return $bar = (! (current_user_can('webeditor') || current_user_can('supereditor') || current_user_can('salescoordinator') || current_user_can('administrator'))) ? false : true;

    }
    add_filter('show_admin_bar', 'avatar_hide_admin_bar');
}

/* -------------------------------------------------------------
 * Get IP Address
 * ============================================================*/

if (! function_exists('avatar_get_ip_address')) {
    /**
     * @return IP Address or null
     */
    function avatar_get_ip_address()
    {

        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }
}

/* -------------------------------------------------------------
 *  Validates a phone number using a regular expression.
 * ============================================================*/

if (! function_exists('avatar_is_phone')) {
    /**
     * @param  string  $phone  Phone number to validate.
     * @return bool
     */
    function avatar_is_phone($phone)
    {

        if (strlen(trim(preg_replace('/[\s\#0-9_\-\+\/\(\)]/', '', $phone))) > 0) {
            return false;
        }

        return true;
    }
}

/* -------------------------------------------------------------
 * Have user access?
 * ============================================================*/

if (! function_exists('avatar_user_have_access')) {
    /**
     * @return bool
     */
    function avatar_user_have_access()
    {

        $current_user = wp_get_current_user();

        if (is_array($current_user->roles)) {

            return in_array('newspaper', $current_user->roles)
                    || in_array('administrator', $current_user->roles)
                    || in_array('author', $current_user->roles)
                    || in_array('webeditor', $current_user->roles)
                    || in_array('supereditor', $current_user->roles);
        } else {
            return false;
        }
    }
}

/* -------------------------------------------------------------
 * Give user access to newspaper
 * ============================================================*/

if (! function_exists('avatar_user_give_access_to_newspaper')) {
    /**
     * @return bool
     */
    function avatar_user_give_access_to_newspaper()
    {
        $current_user = wp_get_current_user();

        if ($current_user->roles[0] == 'subscriber') {
            $current_user->remove_role('subscriber');
            $current_user->add_role('newspaper');
        }
    }
}

/* -------------------------------------------------------------
 * Test if refer is newspaper
 * ============================================================*/

if (! function_exists('avatar_is_refer_newspaper')) {

    function avatar_is_refer_newspaper()
    {

        $refer_path = parse_url(wp_get_referer())['path'];
        $newspaper_path = parse_url(get_permalink(get_field('acf_footer_page_newspaper_login', 'option')))['path'];

        $is = ($refer_path == $newspaper_path) ? true : false;

        return $is;
    }
}

/* -------------------------------------------------------------
 * Generate Version 4 UUIDs are pseudo-random, is in compliance with RFC 4122.
 * The first function, which was created by Andrew Moore in
 * http://www.php.net/manual/en/function.uniqid.php#94959
 * ============================================================*/

if (! function_exists('avatar_uuid_v4')) {

    function avatar_uuid_v4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
            // 16 bits for "time_mid"
            mt_rand(0, 0xFFFF),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0FFF) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3FFF) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }
}

/* -------------------------------------------------------------
 * Test if UUID is valid
 * ============================================================*/

if (! function_exists('avatar_is_valid_uuid_v4')) {

    function avatar_is_valid_uuid_v4($uuid)
    {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
}

/* -------------------------------------------------------------
 * Block wp-admin access
 * ============================================================*/

if (! function_exists('avatar_blockusers_init')) {
    function avatar_blockusers_init()
    {
        if (is_user_logged_in()
            && is_admin()
            && ! current_user_can('administrator')
            && ! current_user_can('supereditor')
            && ! current_user_can('webeditor')
            && ! current_user_can('salescoordinator')
            && ! (defined('DOING_AJAX')
            && DOING_AJAX)) {
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'avatar_blockusers_init');

/* -------------------------------------------------------------
 * Removes 'white spaces' around searchs
 * ============================================================*/

if (! function_exists('avatar_search_filter')) {
    function avatar_search_filter($query)
    {
        if ($query->query_vars['category_name'] == 'company') {
            $query->query_vars['post_sponsor'] = $query->query_vars['name'];
            $query->query['post_sponsor'] = $query->query_vars['name'];
            $query->query_vars['post_sponsor'] = $query->query_vars['name'];
            unset($query->query['name']);
            unset($query->query['page']);
            unset($query->query['category_name']);
            unset($query->query_vars['category_name']);
            unset($query->query_vars['name']);
            $query->is_tax = true;
            $query->is_archive = true;
            $query->is_single = false;
            $query->is_singular = false;
        } elseif (isset($query->query_vars['post_sponsor'])) {
            $sponsor = get_term_by('slug', $query->query_vars['post_sponsor'], 'post_sponsor');
            $acf_sponsor_type = get_field('acf_sponsor_type', $sponsor);

            if ($acf_sponsor_type != 'podcast') {
                $args_sponsor = [
                    'labels' => $labels_sponsor,
                    'hierarchical' => false,
                    'public' => true,
                    'show_ui' => true,
                    'show_admin_column' => false,
                    'show_in_nav_menus' => false,
                    'show_tagcloud' => false,
                ];
                $site_id = get_current_blog_id();
                $wp_path = get_blog_details($site_id)->path;
                if (trim($wp_path) != '/') {
                    $wp_path = str_replace(get_blog_details($site_id)->path, '', add_query_arg([]));
                } else {
                    $wp_path = add_query_arg([]);
                }
                $new_url = get_blog_details($site_id)->siteurl.'/'.str_replace('togo/', '', $wp_path);
                wp_redirect($new_url);
                exit();
            }
        }
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'redirection.php':
                    if (current_user_can('webeditor') && (! (current_user_can('supereditor') || current_user_can('administrator')))) {
                        echo '<style>.subsubsub {display:none;}</style>';
                    }
                    break;
            }
        }
        // If 's' request variable exists
        if (isset($_GET['s']) && $query->is_main_query()) {
            $query->set('s', trim($_GET['s']));
        }

        return $query;
    }
}
add_filter('pre_get_posts', 'avatar_search_filter');

if (! function_exists(('acf_load_article_type_extra'))) {
    function acf_load_article_type_extra($field)
    {
        if (get_current_blog_id() === 5) {
            $field['choices']['advisortoclient'] = 'Advisor To Client';
        }

        return $field;
    }

    add_filter('acf/load_field/name=acf_article_type', 'acf_load_article_type_extra');
}

if (! function_exists(('acf_load_template'))) {
    function acf_load_template($field)
    {

        $url = parse_url(wp_get_referer());
        parse_str($url['query'], $path);

        //        if(('newsletter' === $_GET["post_type"]) || ('newsletter_scheduler' === $_GET["page"]) ) {
        if ($path['post_type'] !== 'acf-field-group') {

            if (is_array($field['choices'])) {
                $searchContent = [1 => '===============', 2 => 'FI -', 3 => 'IE -', 4 => 'CO -', 5 => 'AD - ', 6 => 'AV - ', 7 => 'BE - '];
                foreach ($field['choices'] as $key => $currChoice) {
                    for ($currSiteId = get_current_blog_id(), $i = 1; $i <= 7; $i++) {
                        if (($i != $currSiteId) && (trim($currChoice) !== '')) {
                            if (strpos($currChoice, $searchContent[$i]) !== false) {
                                unset($field['choices'][$key]);
                            }
                            if ($currSiteId != 7) {
                                if (strpos($currChoice, 'Benefits Canada') !== false) {
                                    unset($field['choices'][$key]);
                                }
                                if (strpos($currChoice, 'Investment Review') !== false) {
                                    unset($field['choices'][$key]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $field;
    }

    add_filter('acf/load_field/name=acf_newsletter_template', 'acf_load_template');
}

function my_post_object_result($title, $post, $field, $post_id)
{
    if ($post->post_type === 'newspaper') {
        $data = get_field('acf_newspaper_type', $post->ID);
        if ($data === null) {
            $data = 'Default';
        }
        if ($data !== '') {
            $title .= ' ('.$data.')';
        }
    }

    return $title;

}

add_filter('acf/fields/post_object/result/name=acf_article_newspaper', 'my_post_object_result', 10, 4);

if (! function_exists('avatar_include_template_conditionally')) {

    function avatar_include_template_conditionally($template_name, $include_condition)
    {
        //error_log('BLOCK: ' . $include_condition);
        if (avatar_defined_value($include_condition)) {
            //error_log('INCLUDE: ' . $template_name);
            include locate_template($template_name);
        }
    }
}

if (! function_exists('avatar_defined_value')) {

    function avatar_defined_value($condition_name)
    {

        $condition_value = defined($condition_name) ? constant($condition_name) : true;

        return $condition_value;
    }
}

if (! function_exists('avatar_include_subscription_module')) {
    function avatar_include_subscription_module()
    {

        if (defined('AVATAR_SUBSCRIPTION_MODULE')) {
            error_log(AVATAR_SUBSCRIPTION_MODULE);
            include locate_template(AVATAR_SUBSCRIPTION_MODULE);
        } else {
            error_log('NOT FOUND');
        }
    }

}

if (! function_exists(('avatar_acf_value'))) {

    function avatar_acf_value($post_id, $acf_boolean_field, $default_value)
    {
        $value = get_field($acf_boolean_field, $post_id);

        if (isset($value)) {
            return $value;
        } else {
            return $default_value;
        }
    }
}

if (! function_exists(('avatar_acf_field_exists'))) {

    function avatar_acf_field_exists($post_id, $acf_field)
    {
        $value = get_field($acf_field, $post_id);

        if ($value === true || $value === false) {
            return true;
        } else {
            return false;
        }
    }
}

function set_the_terms_in_order($terms, $id, $taxonomy)
{
    $terms = wp_cache_get($id, "{$taxonomy}_relationships_sorted");
    if ($terms === false) {
        $terms = wp_get_object_terms($id, $taxonomy, ['orderby' => 'term_order']);
        wp_cache_add($id, $terms, $taxonomy.'_relationships_sorted');
    }

    return $terms;
}
add_filter('get_the_terms', 'set_the_terms_in_order', 10, 4);

function do_the_terms_in_order()
{
    global $wp_taxonomies;  //fixed missing semicolon
    // the following relates to tags, but you can add more lines like this for any taxonomy
    $wp_taxonomies['post_tag']->sort = true;
    $wp_taxonomies['post_tag']->args = ['orderby' => 'term_order'];
}
add_action('init', 'do_the_terms_in_order');
