<?php
/**
 * WPSEO plugin file.
 */

/**
 * This class generates the metabox on the edit post / page as well as contains all page analysis functionality.
 */
class WPSEO_Metabox extends WPSEO_Meta
{
    /**
     * @var WPSEO_Social_Admin
     */
    protected $social_admin;

    /**
     * @var WPSEO_Metabox_Analysis_SEO
     */
    protected $analysis_seo;

    /**
     * @var WPSEO_Metabox_Analysis_Readability
     */
    protected $analysis_readability;

    /**
     * The metabox editor object.
     *
     * @var WPSEO_Metabox_Editor
     */
    protected $editor;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_insert_post', [$this, 'save_postdata']);
        add_action('edit_attachment', [$this, 'save_postdata']);
        add_action('add_attachment', [$this, 'save_postdata']);
        add_action('admin_init', [$this, 'translate_meta_boxes']);

        // Check if one of the social settings is checked in the options, if so, initialize the social_admin object.
        if (WPSEO_Options::get('opengraph', false) || WPSEO_Options::get('twitter', false)) {
            $this->social_admin = new WPSEO_Social_Admin;
        }

        $this->editor = new WPSEO_Metabox_Editor;
        $this->editor->register_hooks();

        $this->analysis_seo = new WPSEO_Metabox_Analysis_SEO;
        $this->analysis_readability = new WPSEO_Metabox_Analysis_Readability;
    }

    /**
     * Translate text strings for use in the meta box.
     *
     * IMPORTANT: if you want to add a new string (option) somewhere, make sure you add that array key to
     * the main meta box definition array in the class WPSEO_Meta() as well!!!!
     */
    public static function translate_meta_boxes()
    {
        WPSEO_Meta::$meta_fields['general']['title']['title'] = __('SEO title', 'wordpress-seo');

        WPSEO_Meta::$meta_fields['general']['metadesc']['title'] = __('Meta description', 'wordpress-seo');

        /* translators: %s expands to the post type name. */
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-noindex']['title'] = __('Allow search engines to show this %s in search results?', 'wordpress-seo');
        if ((string) get_option('blog_public') === '0') {
            WPSEO_Meta::$meta_fields['advanced']['meta-robots-noindex']['description'] = '<p class="error-message">'.__('Warning: even though you can set the meta robots setting here, the entire site is set to noindex in the sitewide privacy settings, so these settings won\'t have an effect.', 'wordpress-seo').'</p>';
        }
        /* translators: %1$s expands to Yes or No,  %2$s expands to the post type name.*/
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-noindex']['options']['0'] = __('Default for %2$s, currently: %1$s', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-noindex']['options']['2'] = __('Yes', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-noindex']['options']['1'] = __('No', 'wordpress-seo');

        /* translators: %1$s expands to the post type name.*/
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-nofollow']['title'] = __('Should search engines follow links on this %1$s?', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-nofollow']['options']['0'] = __('Yes', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-nofollow']['options']['1'] = __('No', 'wordpress-seo');

        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['title'] = __('Meta robots advanced', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['description'] = __('Advanced <code>meta</code> robots settings for this page.', 'wordpress-seo');
        /* translators: %s expands to the advanced robots settings default as set in the site-wide settings.*/
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['options']['-'] = __('Site-wide default: %s', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['options']['none'] = __('None', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['options']['noimageindex'] = __('No Image Index', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['options']['noarchive'] = __('No Archive', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['meta-robots-adv']['options']['nosnippet'] = __('No Snippet', 'wordpress-seo');

        WPSEO_Meta::$meta_fields['advanced']['bctitle']['title'] = __('Breadcrumbs Title', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['bctitle']['description'] = __('Title to use for this page in breadcrumb paths', 'wordpress-seo');

        WPSEO_Meta::$meta_fields['advanced']['canonical']['title'] = __('Canonical URL', 'wordpress-seo');

        WPSEO_Meta::$meta_fields['advanced']['canonical']['description'] = sprintf(
            /* translators: 1: link open tag; 2: link close tag. */
            __('The canonical URL that this page should point to. Leave empty to default to permalink. %1$sCross domain canonical%2$s supported too.', 'wordpress-seo'),
            '<a href="https://googlewebmastercentral.blogspot.com/2009/12/handling-legitimate-cross-domain.html" target="_blank" rel="noopener">',
            WPSEO_Admin_Utils::get_new_tab_message().'</a>'
        );

        WPSEO_Meta::$meta_fields['advanced']['redirect']['title'] = __('301 Redirect', 'wordpress-seo');
        WPSEO_Meta::$meta_fields['advanced']['redirect']['description'] = __('The URL that this page should redirect to.', 'wordpress-seo');

        do_action('wpseo_tab_translate');
    }

    /**
     * Determines whether the metabox should be shown for the passed identifier.
     *
     * By default the check is done for post types, but can also be used for taxonomies.
     *
     * @param  string|null  $identifier  The identifier to check.
     * @param  string  $type  The type of object to check. Defaults to post_type.
     * @return bool Whether or not the metabox should be displayed.
     */
    public function display_metabox($identifier = null, $type = 'post_type')
    {
        return WPSEO_Utils::is_metabox_active($identifier, $type);
    }

    /**
     * Adds the Yoast SEO meta box to the edit boxes in the edit post, page,
     * attachment, and custom post types pages.
     *
     * @return void
     */
    public function add_meta_box()
    {
        $post_types = WPSEO_Post_Type::get_accessible_post_types();
        $post_types = array_filter($post_types, [$this, 'display_metabox']);

        if (! is_array($post_types) || $post_types === []) {
            return;
        }

        $product_title = $this->get_product_title();

        $this->register_helpcenter_tab();

        foreach ($post_types as $post_type) {
            add_filter("postbox_classes_{$post_type}_wpseo_meta", [$this, 'wpseo_metabox_class']);

            add_meta_box(
                'wpseo_meta',
                $product_title,
                [$this, 'meta_box'],
                $post_type,
                'normal',
                apply_filters('wpseo_metabox_prio', 'high'),
                ['__block_editor_compatible_meta_box' => true]
            );
        }
    }

    /**
     * Adds CSS classes to the meta box.
     *
     * @param  array  $classes  An array of postbox CSS classes.
     * @return array List of classes that will be applied to the editbox container.
     */
    public function wpseo_metabox_class($classes)
    {
        $classes[] = 'yoast wpseo-metabox';

        return $classes;
    }

    /**
     * Pass variables to js for use with the post-scraper.
     *
     * @return array
     */
    public function localize_post_scraper_script()
    {
        $post = $this->get_metabox_post();
        $permalink = '';

        if (is_object($post)) {
            $permalink = get_sample_permalink($post->ID);
            $permalink = $permalink[0];
        }

        $post_formatter = new WPSEO_Metabox_Formatter(
            new WPSEO_Post_Metabox_Formatter($post, [], $permalink)
        );

        $values = $post_formatter->get_values();

        /** This filter is documented in admin/filters/class-cornerstone-filter.php. */
        $post_types = apply_filters('wpseo_cornerstone_post_types', WPSEO_Post_Type::get_accessible_post_types());
        if ($values['cornerstoneActive'] && ! in_array($post->post_type, $post_types, true)) {
            $values['cornerstoneActive'] = false;
        }

        return $values;
    }

    /**
     * Pass some variables to js for replacing variables.
     */
    public function localize_replace_vars_script()
    {
        return [
            'no_parent_text' => __('(no parent)', 'wordpress-seo'),
            'replace_vars' => $this->get_replace_vars(),
            'recommended_replace_vars' => $this->get_recommended_replace_vars(),
            'scope' => $this->determine_scope(),
            'has_taxonomies' => $this->current_post_type_has_taxonomies(),
        ];
    }

    /**
     * Determines whether or not the current post type has registered taxonomies.
     *
     * @return bool Whether the current post type has taxonomies.
     */
    private function current_post_type_has_taxonomies()
    {
        $post_taxonomies = get_object_taxonomies(get_post_type());

        return ! empty($post_taxonomies);
    }

    /**
     * Determines the scope based on the post type.
     * This can be used by the replacevar plugin to determine if a replacement needs to be executed.
     *
     * @return string String describing the current scope.
     */
    private function determine_scope()
    {
        $post_type = get_post_type($this->get_metabox_post());

        if ($post_type === 'page') {
            return 'page';
        }

        return 'post';
    }

    /**
     * Pass some variables to js for the edit / post page overview, etc.
     *
     * @return array
     */
    public function localize_shortcode_plugin_script()
    {
        return [
            'wpseo_filter_shortcodes_nonce' => wp_create_nonce('wpseo-filter-shortcodes'),
            'wpseo_shortcode_tags' => $this->get_valid_shortcode_tags(),
        ];
    }

    /**
     * Output a tab in the Yoast SEO Metabox.
     *
     * @param  string  $id  CSS ID of the tab.
     * @param  string  $heading  Heading for the tab.
     * @param  string  $content  Content of the tab. This content should be escaped.
     */
    public function do_tab($id, $heading, $content)
    {
        ?>
		<div id="<?php echo esc_attr('wpseo_'.$id); ?>" class="wpseotab <?php echo esc_attr($id); ?>">
			<?php echo $content; ?>
		</div>
		<?php
    }

    /**
     * Output the meta box.
     */
    public function meta_box()
    {
        $content_sections = $this->get_content_sections();

        echo '<div class="wpseo-metabox-content">';
        echo '<div class="wpseo-metabox-sidebar"><ul>';

        foreach ($content_sections as $content_section) {
            if ($content_section->name === 'premium') {
                continue;
            }

            $content_section->display_link();
        }

        echo '</ul></div>';

        foreach ($content_sections as $content_section) {
            $content_section->display_content();
        }

        echo '</div>';
    }

    /**
     * Returns the relevant metabox sections for the current view.
     *
     * @return WPSEO_Metabox_Section[]
     */
    private function get_content_sections()
    {
        $content_sections = [];

        $content_sections[] = $this->get_content_meta_section();

        // Check if social_admin is an instance of WPSEO_Social_Admin.
        if ($this->social_admin instanceof WPSEO_Social_Admin) {
            $content_sections[] = $this->social_admin->get_meta_section();
        }

        if (WPSEO_Capability_Utils::current_user_can('wpseo_edit_advanced_metadata') || WPSEO_Options::get('disableadvanced_meta') === false) {
            $content_sections[] = $this->get_advanced_meta_section();
        }

        if (has_action('wpseo_tab_header') || has_action('wpseo_tab_content')) {
            $content_sections[] = $this->get_addons_meta_section();
        }

        return $content_sections;
    }

    /**
     * Returns the metabox section for the content analysis.
     *
     * @return WPSEO_Metabox_Section
     */
    private function get_content_meta_section()
    {
        wp_nonce_field('yoast_free_metabox', 'yoast_free_metabox_nonce');

        $content = $this->get_tab_content('general');

        /**
         * Filter: 'wpseo_content_meta_section_content' - Allow filtering the metabox content before outputting.
         *
         * @api string $post_content The metabox content string.
         */
        $content = apply_filters('wpseo_content_meta_section_content', $content);

        return new WPSEO_Metabox_Section_React(
            'content',
            '<span class="screen-reader-text">'.__('Content optimization', 'wordpress-seo').'</span><span class="yst-traffic-light-container">'.WPSEO_Utils::traffic_light_svg().'</span>',
            $content,
            [
                'link_aria_label' => __('Content optimization', 'wordpress-seo'),
                'link_class' => 'yoast-tooltip yoast-tooltip-e',
            ]
        );
    }

    /**
     * Returns the metabox section for the advanced settings.
     *
     * @return WPSEO_Metabox_Section
     */
    private function get_advanced_meta_section()
    {
        $content = $this->get_tab_content('advanced');

        $tab = new WPSEO_Metabox_Form_Tab(
            'advanced',
            $content,
            __('Advanced', 'wordpress-seo'),
            ['single' => true]
        );

        return new WPSEO_Metabox_Tab_Section(
            'advanced',
            '<span class="screen-reader-text">'.__('Advanced', 'wordpress-seo').'</span><span class="dashicons dashicons-admin-generic"></span>',
            [$tab],
            [
                'link_aria_label' => __('Advanced', 'wordpress-seo'),
                'link_class' => 'yoast-tooltip yoast-tooltip-e',
            ]
        );
    }

    /**
     * Returns a metabox section dedicated to hosting metabox tabs that have been added by other plugins through the
     * `wpseo_tab_header` and `wpseo_tab_content` actions.
     *
     * @return WPSEO_Metabox_Section
     */
    private function get_addons_meta_section()
    {
        return new WPSEO_Metabox_Addon_Tab_Section(
            'addons',
            '<span class="screen-reader-text">'.__('Add-ons', 'wordpress-seo').'</span><span class="dashicons dashicons-admin-plugins"></span>',
            [],
            [
                'link_aria_label' => __('Add-ons', 'wordpress-seo'),
                'link_class' => 'yoast-tooltip yoast-tooltip-e',
            ]
        );
    }

    /**
     * Retrieves the contents for the metabox tab.
     *
     * @param  string  $tab_name  Tab for which to retrieve the field definitions.
     * @return string
     */
    private function get_tab_content($tab_name)
    {
        $content = '';
        foreach (WPSEO_Meta::get_meta_field_defs($tab_name) as $key => $meta_field) {
            $content .= $this->do_meta_box($meta_field, $key);
        }

        return $content;
    }

    /**
     * Adds a line in the meta box.
     *
     * @todo [JRF] Check if $class is added appropriately everywhere.
     *
     * @param  array  $meta_field_def  Contains the vars based on which output is generated.
     * @param  string  $key  Internal key (without prefix).
     * @return string
     */
    public function do_meta_box($meta_field_def, $key = '')
    {
        $content = '';
        $esc_form_key = esc_attr(WPSEO_Meta::$form_prefix.$key);
        $meta_value = WPSEO_Meta::get_value($key, $this->get_metabox_post()->ID);

        $class = '';
        if (isset($meta_field_def['class']) && $meta_field_def['class'] !== '') {
            $class = ' '.$meta_field_def['class'];
        }

        $placeholder = '';
        if (isset($meta_field_def['placeholder']) && $meta_field_def['placeholder'] !== '') {
            $placeholder = $meta_field_def['placeholder'];
        }

        $aria_describedby = '';
        $description = '';
        if (isset($meta_field_def['description'])) {
            $aria_describedby = ' aria-describedby="'.$esc_form_key.'-desc"';
            $description = '<p id="'.$esc_form_key.'-desc" class="yoast-metabox__description">'.$meta_field_def['description'].'</p>';
        }

        switch ($meta_field_def['type']) {
            case 'text':
                $ac = '';
                if (isset($meta_field_def['autocomplete']) && $meta_field_def['autocomplete'] === false) {
                    $ac = 'autocomplete="off" ';
                }
                if ($placeholder !== '') {
                    $placeholder = ' placeholder="'.esc_attr($placeholder).'"';
                }
                $content .= '<input type="text"'.$placeholder.' id="'.$esc_form_key.'" '.$ac.'name="'.$esc_form_key.'" value="'.esc_attr($meta_value).'" class="large-text'.$class.'"'.$aria_describedby.'/>';
                break;

            case 'textarea':
                $rows = 3;
                if (isset($meta_field_def['rows']) && $meta_field_def['rows'] > 0) {
                    $rows = $meta_field_def['rows'];
                }
                $content .= '<textarea class="large-text'.$class.'" rows="'.esc_attr($rows).'" id="'.$esc_form_key.'" name="'.$esc_form_key.'"'.$aria_describedby.'>'.esc_textarea($meta_value).'</textarea>';
                break;

            case 'hidden':
                $content .= '<input type="hidden" id="'.$esc_form_key.'" name="'.$esc_form_key.'" value="'.esc_attr($meta_value).'"/>'."\n";
                break;
            case 'select':
                if (isset($meta_field_def['options']) && is_array($meta_field_def['options']) && $meta_field_def['options'] !== []) {
                    $content .= '<select name="'.$esc_form_key.'" id="'.$esc_form_key.'" class="yoast'.$class.'">';
                    foreach ($meta_field_def['options'] as $val => $option) {
                        $selected = selected($meta_value, $val, false);
                        $content .= '<option '.$selected.' value="'.esc_attr($val).'">'.esc_html($option).'</option>';
                    }
                    unset($val, $option, $selected);
                    $content .= '</select>';
                }
                break;

            case 'multiselect':
                if (isset($meta_field_def['options']) && is_array($meta_field_def['options']) && $meta_field_def['options'] !== []) {

                    // Set $meta_value as $selected_arr.
                    $selected_arr = $meta_value;

                    // If the multiselect field is 'meta-robots-adv' we should explode on ,.
                    if ($key === 'meta-robots-adv') {
                        $selected_arr = explode(',', $meta_value);
                    }

                    if (! is_array($selected_arr)) {
                        $selected_arr = (array) $selected_arr;
                    }

                    $options_count = count($meta_field_def['options']);

                    // This select now uses Select2.
                    $content .= '<select multiple="multiple" size="'.esc_attr($options_count).'" name="'.$esc_form_key.'[]" id="'.$esc_form_key.'" class="yoast'.$class.'"'.$aria_describedby.'>';
                    foreach ($meta_field_def['options'] as $val => $option) {
                        $selected = '';
                        if (in_array($val, $selected_arr, true)) {
                            $selected = ' selected="selected"';
                        }
                        $content .= '<option '.$selected.' value="'.esc_attr($val).'">'.esc_html($option).'</option>';
                    }
                    $content .= '</select>';
                    unset($val, $option, $selected, $selected_arr, $options_count);
                }
                break;

            case 'checkbox':
                $checked = checked($meta_value, 'on', false);
                $expl = (isset($meta_field_def['expl'])) ? esc_html($meta_field_def['expl']) : '';
                $content .= '<input type="checkbox" id="'.$esc_form_key.'" name="'.$esc_form_key.'" '.$checked.' value="on" class="yoast'.$class.'"'.$aria_describedby.'/> <label for="'.$esc_form_key.'">'.$expl.'</label>';
                unset($checked, $expl);
                break;

            case 'radio':
                if (isset($meta_field_def['options']) && is_array($meta_field_def['options']) && $meta_field_def['options'] !== []) {
                    foreach ($meta_field_def['options'] as $val => $option) {
                        $checked = checked($meta_value, $val, false);
                        $content .= '<input type="radio" '.$checked.' id="'.$esc_form_key.'_'.esc_attr($val).'" name="'.$esc_form_key.'" value="'.esc_attr($val).'"/> <label for="'.$esc_form_key.'_'.esc_attr($val).'">'.esc_html($option).'</label> ';
                    }
                    unset($val, $option, $checked);
                }
                break;

            case 'upload':
                $content .= '<input'.
                    ' id="'.$esc_form_key.'"'.
                    ' type="text"'.
                    ' size="36"'.
                    ' class="'.$class.'"'.
                    ' name="'.$esc_form_key.'"'.
                    ' value="'.esc_attr($meta_value).'"'.$aria_describedby.
                    ' readonly="readonly"'.
                    ' />';
                $content .= '<input'.
                    ' id="'.esc_attr($esc_form_key).'_button"'.
                    ' class="wpseo_image_upload_button button"'.
                    ' data-target="'.esc_attr($esc_form_key).'"'.
                    ' data-target-id="'.esc_attr($esc_form_key).'-id"'.
                    ' type="button"'.
                    ' value="'.esc_attr__('Upload Image', 'wordpress-seo').'"'.
                    ' /> ';
                $content .= '<input'.
                    ' class="wpseo_image_remove_button button"'.
                    ' type="button"'.
                    ' value="'.esc_attr__('Clear Image', 'wordpress-seo').'"'.
                    ' />';
                break;
        }

        $html = '';
        if ($content === '') {
            $content = apply_filters('wpseo_do_meta_box_field_'.$key, $content, $meta_value, $esc_form_key, $meta_field_def, $key);
        }

        if ($content !== '') {

            $title = esc_html($meta_field_def['title']);

            // By default, use the field title as a label element.
            $label = '<label for="'.$esc_form_key.'">'.$title.'</label>';

            // Set the inline help and help panel, if any.
            $help_button = '';
            $help_panel = '';
            if (isset($meta_field_def['help']) && $meta_field_def['help'] !== '') {
                $help = new WPSEO_Admin_Help_Panel($key, $meta_field_def['help-button'], $meta_field_def['help']);
                $help_button = $help->get_button_html();
                $help_panel = $help->get_panel_html();
            }

            // If it's a set of radio buttons, output proper fieldset and legend.
            if ($meta_field_def['type'] === 'radio') {
                return '<fieldset><legend>'.$title.'</legend>'.$help_button.$help_panel.$content.$description.'</fieldset>';
            }

            // If it's a single checkbox, ignore the title.
            if ($meta_field_def['type'] === 'checkbox') {
                $label = '';
            }

            // Other meta box content or form fields.
            if ($meta_field_def['type'] === 'hidden') {
                $html = $content;
            } else {
                $html = $label.$help_button.$help_panel.$content.$description;
            }
        }

        return $html;
    }

    /**
     * Save the WP SEO metadata for posts.
     *
     * {@internal $_POST parameters are validated via sanitize_post_meta().}
     *
     * @param  int  $post_id  Post ID.
     * @return bool|void Boolean false if invalid save post request.
     */
    public function save_postdata($post_id)
    {
        // Bail if this is a multisite installation and the site has been switched.
        if (is_multisite() && ms_is_switched()) {
            return false;
        }

        if ($post_id === null) {
            return false;
        }

        if (! isset($_POST['yoast_free_metabox_nonce']) || ! wp_verify_nonce($_POST['yoast_free_metabox_nonce'], 'yoast_free_metabox')) {
            return false;
        }

        if (wp_is_post_revision($post_id)) {
            $post_id = wp_is_post_revision($post_id);
        }

        /**
         * Determine we're not accidentally updating a different post.
         * We can't use filter_input here as the ID isn't available at this point, other than in the $_POST data.
         */
        if (! isset($_POST['ID']) || $post_id !== (int) $_POST['ID']) {
            return false;
        }

        clean_post_cache($post_id);
        $post = get_post($post_id);

        if (! is_object($post)) {
            // Non-existent post.
            return false;
        }

        do_action('wpseo_save_compare_data', $post);

        $meta_boxes = apply_filters('wpseo_save_metaboxes', []);
        $meta_boxes = array_merge($meta_boxes, WPSEO_Meta::get_meta_field_defs('general', $post->post_type), WPSEO_Meta::get_meta_field_defs('advanced'));

        foreach ($meta_boxes as $key => $meta_box) {

            // If analysis is disabled remove that analysis score value from the DB.
            if ($this->is_meta_value_disabled($key)) {
                WPSEO_Meta::delete($key, $post_id);

                continue;
            }

            $data = null;
            $field_name = WPSEO_Meta::$form_prefix.$key;

            if ($meta_box['type'] === 'checkbox') {
                $data = isset($_POST[$field_name]) ? 'on' : 'off';
            } else {
                if (isset($_POST[$field_name])) {
                    $data = wp_unslash($_POST[$field_name]);

                    // For multi-select.
                    if (is_array($data)) {
                        $data = array_map(['WPSEO_Utils', 'sanitize_text_field'], $data);
                    }

                    if (is_string($data)) {
                        $data = WPSEO_Utils::sanitize_text_field($data);
                    }
                }

                // Reset options when no entry is present with multiselect - only applies to `meta-robots-adv` currently.
                if (! isset($_POST[$field_name]) && ($meta_box['type'] === 'multiselect')) {
                    $data = [];
                }
            }

            if ($data !== null) {
                WPSEO_Meta::set_value($key, $data, $post_id);
            }
        }

        do_action('wpseo_saved_postdata');
    }

    /**
     * Determines if the given meta value key is disabled.
     *
     * @param  string  $key  The key of the meta value.
     * @return bool Whether the given meta value key is disabled.
     */
    public function is_meta_value_disabled($key)
    {
        if ($key === 'linkdex' && ! $this->analysis_seo->is_enabled()) {
            return true;
        }

        if ($key === 'content_score' && ! $this->analysis_readability->is_enabled()) {
            return true;
        }

        return false;
    }

    /**
     * Enqueues all the needed JS and CSS.
     *
     * @todo [JRF => whomever] Create css/metabox-mp6.css file and add it to the below allowed colors array when done.
     */
    public function enqueue()
    {
        global $pagenow;

        $asset_manager = new WPSEO_Admin_Asset_Manager;

        $is_editor = self::is_post_overview($pagenow) || self::is_post_edit($pagenow);

        if (self::is_post_overview($pagenow)) {
            $asset_manager->enqueue_style('edit-page');
            $asset_manager->enqueue_script('edit-page-script');

            return;
        }

        /* Filter 'wpseo_always_register_metaboxes_on_admin' documented in wpseo-main.php */
        if (($is_editor === false && apply_filters('wpseo_always_register_metaboxes_on_admin', false) === false) || $this->display_metabox() === false) {
            return;
        }

        if (get_queried_object_id() !== 0) {
            // Enqueue files needed for upload functionality.
            wp_enqueue_media(['post' => get_queried_object_id()]);
        }

        $asset_manager->enqueue_style('metabox-css');
        $asset_manager->enqueue_style('scoring');
        $asset_manager->enqueue_style('select2');

        $asset_manager->enqueue_script('metabox');
        $asset_manager->enqueue_script('admin-media');

        $asset_manager->enqueue_script('post-scraper');
        $asset_manager->enqueue_script('replacevar-plugin');
        $asset_manager->enqueue_script('shortcode-plugin');

        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'admin-media', 'wpseoMediaL10n', $this->localize_media_script());
        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'post-scraper', 'wpseoPostScraperL10n', $this->localize_post_scraper_script());
        $yoast_components_l10n = new WPSEO_Admin_Asset_Yoast_Components_L10n;
        $yoast_components_l10n->localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'post-scraper');

        $analysis_worker_location = new WPSEO_Admin_Asset_Analysis_Worker_Location($asset_manager->flatten_version(WPSEO_VERSION));
        $used_keywords_assessment_location = new WPSEO_Admin_Asset_Analysis_Worker_Location($asset_manager->flatten_version(WPSEO_VERSION), 'used-keywords-assessment');

        $localization_data = [
            'url' => $analysis_worker_location->get_url($analysis_worker_location->get_asset(), WPSEO_Admin_Asset::TYPE_JS),
            'keywords_assessment_url' => $used_keywords_assessment_location->get_url($used_keywords_assessment_location->get_asset(), WPSEO_Admin_Asset::TYPE_JS),
            'log_level' => WPSEO_Utils::get_analysis_worker_log_level(),
            // We need to make the feature flags separately available inside of the analysis web worker.
            'enabled_features' => WPSEO_Utils::retrieve_enabled_features(),
        ];
        wp_localize_script(
            WPSEO_Admin_Asset_Manager::PREFIX.'post-scraper',
            'wpseoAnalysisWorkerL10n',
            $localization_data
        );

        /**
         * Remove the emoji script as it is incompatible with both React and any
         * contenteditable fields.
         */
        remove_action('admin_print_scripts', 'print_emoji_detection_script');

        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'replacevar-plugin', 'wpseoReplaceVarsL10n', $this->localize_replace_vars_script());
        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'shortcode-plugin', 'wpseoShortcodePluginL10n', $this->localize_shortcode_plugin_script());

        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'metabox', 'wpseoAdminL10n', WPSEO_Utils::get_admin_l10n());
        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'metabox', 'wpseoSelect2Locale', WPSEO_Language_Utils::get_language(WPSEO_Language_Utils::get_user_locale()));

        wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'metabox', 'wpseoFeaturesL10n', WPSEO_Utils::retrieve_enabled_features());

        if (post_type_supports(get_post_type(), 'thumbnail')) {
            $asset_manager->enqueue_style('featured-image');

            $asset_manager->enqueue_script('featured-image');

            $featured_image_l10 = ['featured_image_notice' => __('SEO issue: The featured image should be at least 200 by 200 pixels to be picked up by Facebook and other social media sites.', 'wordpress-seo')];
            wp_localize_script(WPSEO_Admin_Asset_Manager::PREFIX.'metabox', 'wpseoFeaturedImageL10n', $featured_image_l10);
        }
    }

    /**
     * Pass some variables to js for upload module.
     *
     * @return array
     */
    public function localize_media_script()
    {
        return [
            'choose_image' => __('Use Image', 'wordpress-seo'),
        ];
    }

    /**
     * Returns post in metabox context.
     *
     * @returns WP_Post|array
     */
    protected function get_metabox_post()
    {
        $post = filter_input(INPUT_GET, 'post');
        if (! empty($post)) {
            $post_id = (int) WPSEO_Utils::validate_int($post);

            return get_post($post_id);
        }

        if (isset($GLOBALS['post'])) {
            return $GLOBALS['post'];
        }

        return [];
    }

    /**
     * Returns an array with shortcode tags for all registered shortcodes.
     *
     * @return array
     */
    private function get_valid_shortcode_tags()
    {
        $shortcode_tags = [];

        foreach ($GLOBALS['shortcode_tags'] as $tag => $description) {
            $shortcode_tags[] = $tag;
        }

        return $shortcode_tags;
    }

    /**
     * Prepares the replace vars for localization.
     *
     * @return array Replace vars.
     */
    private function get_replace_vars()
    {
        $post = $this->get_metabox_post();

        $cached_replacement_vars = [];

        $vars_to_cache = [
            'date',
            'id',
            'sitename',
            'sitedesc',
            'sep',
            'page',
            'currentyear',
        ];

        foreach ($vars_to_cache as $var) {
            $cached_replacement_vars[$var] = wpseo_replace_vars('%%'.$var.'%%', $post);
        }

        // Merge custom replace variables with the WordPress ones.
        return array_merge($cached_replacement_vars, $this->get_custom_replace_vars($post));
    }

    /**
     * Prepares the recommended replace vars for localization.
     *
     * @return array Recommended replacement variables.
     */
    private function get_recommended_replace_vars()
    {
        $recommended_replace_vars = new WPSEO_Admin_Recommended_Replace_Vars;
        $post = $this->get_metabox_post();

        // What is recommended depends on the current context.
        $post_type = $recommended_replace_vars->determine_for_post($post);

        return $recommended_replace_vars->get_recommended_replacevars_for($post_type);
    }

    /**
     * Gets the custom replace variables for custom taxonomies and fields.
     *
     * @param  WP_Post  $post  The post to check for custom taxonomies and fields.
     * @return array Array containing all the replacement variables.
     */
    private function get_custom_replace_vars($post)
    {
        return [
            'custom_fields' => $this->get_custom_fields_replace_vars($post),
            'custom_taxonomies' => $this->get_custom_taxonomies_replace_vars($post),
        ];
    }

    /**
     * Gets the custom replace variables for custom taxonomies.
     *
     * @param  WP_Post  $post  The post to check for custom taxonomies.
     * @return array Array containing all the replacement variables.
     */
    private function get_custom_taxonomies_replace_vars($post)
    {
        $taxonomies = get_object_taxonomies($post, 'objects');
        $custom_replace_vars = [];

        foreach ($taxonomies as $taxonomy_name => $taxonomy) {

            if (is_string($taxonomy)) { // If attachment, see https://core.trac.wordpress.org/ticket/37368 .
                $taxonomy_name = $taxonomy;
                $taxonomy = get_taxonomy($taxonomy_name);
            }

            if ($taxonomy->_builtin && $taxonomy->public) {
                continue;
            }

            $custom_replace_vars[$taxonomy_name] = [
                'name' => $taxonomy->name,
                'description' => $taxonomy->description,
            ];
        }

        return $custom_replace_vars;
    }

    /**
     * Gets the custom replace variables for custom fields.
     *
     * @param  WP_Post  $post  The post to check for custom fields.
     * @return array Array containing all the replacement variables.
     */
    private function get_custom_fields_replace_vars($post)
    {
        $custom_replace_vars = [];

        // If no post object is passed, return the empty custom_replace_vars array.
        if (! is_object($post)) {
            return $custom_replace_vars;
        }

        $custom_fields = get_post_custom($post->ID);

        foreach ($custom_fields as $custom_field_name => $custom_field) {
            if (substr($custom_field_name, 0, 1) === '_') {
                continue;
            }

            $custom_replace_vars[$custom_field_name] = $custom_field[0];
        }

        return $custom_replace_vars;
    }

    /**
     * @param  string  $page  The page to check for the post overview page.
     * @return bool Whether or not the given page is the post overview page.
     */
    public static function is_post_overview($page)
    {
        return $page === 'edit.php';
    }

    /**
     * @param  string  $page  The page to check for the post edit page.
     * @return bool Whether or not the given page is the post edit page.
     */
    public static function is_post_edit($page)
    {
        return $page === 'post.php'
            || $page === 'post-new.php';
    }

    /**
     * Retrieves the product title.
     *
     * @return string The product title.
     */
    protected function get_product_title()
    {
        $product_title = 'Yoast SEO';

        if (WPSEO_Utils::is_yoast_seo_premium()) {
            $product_title .= ' Premium';
        }

        return $product_title;
    }

    /**
     * Adds the template variables tab to the helpcenter.
     *
     * @return void
     */
    protected function register_helpcenter_tab()
    {
        static $tab_registered;

        if ($tab_registered) {
            return;
        }

        // Add template variables tab to the Help Center.
        $tab = new WPSEO_Help_Center_Template_Variables_Tab;
        $tab->register_hooks();

        $tab_registered = true;
    }

    /* ********************* DEPRECATED METHODS ********************* */

    /**
     * Outputs the page analysis score in the Publish Box.
     *
     * @deprecated 9.6
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    public function publish_box()
    {
        _deprecated_function(__METHOD__, 'WPSEO 9.6');
    }

    /**
     * Sets up all the functionality related to the prominence of the page analysis functionality.
     *
     * @deprecated 9.6
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    public function setup_page_analysis()
    {
        _deprecated_function(__METHOD__, 'WPSEO 9.6');
    }
}
