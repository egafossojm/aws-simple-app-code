<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_GSC_Category_Filters.
 *
 * This class will get all category counts from the options and will parse the filter links that are displayed above
 * the crawl issue tables.
 */
class WPSEO_GSC_Category_Filters
{
    /**
     * The counts per category.
     *
     * @var array
     */
    private $category_counts = [];

    /**
     * All the possible filters.
     *
     * @var array
     */
    private $filter_values = [];

    /**
     * The current category.
     *
     * @var string
     */
    private $category;

    /**
     * Constructing this object.
     *
     * Setting the hook to create the issues categories as the links.
     *
     * @param  array  $platform_counts  Set of issue counts by platform.
     */
    public function __construct(array $platform_counts)
    {
        if (! empty($platform_counts)) {
            $this->set_counts($platform_counts);
        }

        // Setting the filter values.
        $this->set_filter_values();

        $this->category = $this->get_current_category();
    }

    /**
     * Returns the value of the current category.
     *
     * @return mixed|string
     */
    public function get_category()
    {
        return $this->category;
    }

    /**
     * Returns the current filters as an array.
     *
     * Only return categories with more than 0 issues.
     *
     * @return array
     */
    public function as_array()
    {
        $new_views = [];

        foreach ($this->category_counts as $category_name => $category) {
            $new_views[] = $this->create_view_link($category_name, $category['count']);
        }

        return $new_views;
    }

    /**
     * Getting the current view.
     */
    private function get_current_category()
    {
        $current_category = filter_input(INPUT_GET, 'category');
        if (! empty($current_category)) {
            return $current_category;
        }

        // Just prevent redirect loops.
        if (! empty($this->category_counts)) {
            $current_category = 'not_found';
            if (empty($this->category_counts[$current_category])) {
                $current_category = key($this->category_counts);
            }

            // Just redirect to set the category.
            wp_redirect(add_query_arg('category', $current_category));
            exit;
        }
    }

    /**
     * Setting the view counts based on the saved data. The info will be used to display the category filters.
     *
     * @param  array  $platform_counts  Set of counts by platform.
     */
    private function set_counts(array $platform_counts)
    {
        $this->category_counts = $this->parse_counts($platform_counts);
    }

    /**
     * Setting the values for the filter.
     */
    private function set_filter_values()
    {
        $this->set_filter_value(
            'access_denied',
            __('Access denied', 'wordpress-seo'),
            __('Server requires authentication or is blocking Googlebot from accessing the site.', 'wordpress-seo'),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Access denied', 'wordpress-seo')
            )
        );
        $this->set_filter_value('faulty_redirects', __('Faulty redirects', 'wordpress-seo'));
        $this->set_filter_value('not_followed', __('Not followed', 'wordpress-seo'));
        $this->set_filter_value(
            'not_found',
            __('Not found', 'wordpress-seo'),
            __('URL points to a non-existent page.', 'wordpress-seo'),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Not found', 'wordpress-seo')
            )
        );
        $this->set_filter_value(
            'other',
            __('Other', 'wordpress-seo'),
            __('Google was unable to crawl this URL due to an undetermined issue.', 'wordpress-seo'),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Other', 'wordpress-seo')
            )
        );
        $this->set_filter_value(
            'roboted',
            __('Blocked', 'wordpress-seo'),
            sprintf(
                /* translators: %1$s: expands to '<code>robots.txt</code>'. */
                __('Googlebot could access your site, but certain URLs are blocked for Googlebot in your %1$s file. This block could either be for all Googlebots or even specifically for Googlebot-mobile.', 'wordpress-seo'),
                '<code>robots.txt</code>'
            ),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Blocked', 'wordpress-seo')
            )
        );
        $this->set_filter_value(
            'server_error',
            __('Server Error', 'wordpress-seo'),
            __('Request timed out or site is blocking Google.', 'wordpress-seo'),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Server Error', 'wordpress-seo')
            )
        );
        $this->set_filter_value(
            'soft_404',
            __('Soft 404', 'wordpress-seo'),
            __("The target URL doesn't exist, but your server is not returning a 404 (file not found) error.", 'wordpress-seo'),
            sprintf(
                /* translators: %s: category name. N.B.: The category name is translated separately. */
                __('Show information about errors in category %s', 'wordpress-seo'),
                __('Soft 404', 'wordpress-seo')
            )
        );
    }

    /**
     * Add new filter value to the filter_values.
     *
     * @param  string  $key  Filter key.
     * @param  string  $value  Filter value.
     * @param  string  $description  Optional description string.
     * @param  string  $help_button_text  Optional help button text.
     */
    private function set_filter_value($key, $value, $description = '', $help_button_text = '')
    {
        $this->filter_values[$key] = [
            'value' => $value,
            'description' => $description,
            'help-button' => $help_button_text,
        ];
    }

    /**
     * Creates a filter link.
     *
     * @param  string  $category  Issue type.
     * @param  int  $count  Count for the type.
     * @return string
     */
    private function create_view_link($category, $count)
    {
        $href = add_query_arg(
            [
                'category' => $category,
                'paged' => 1,
            ]
        );

        $class = 'gsc_category';
        $aria_current = '';

        if ($this->category === $category) {
            $class .= ' current';
            $aria_current = ' aria-current="page"';
        }

        $help_button = '';
        $help_panel = '';
        if ($this->filter_values[$category]['description'] !== '') {
            $help = new WPSEO_Admin_Help_Panel($category, $this->filter_values[$category]['help-button'], $this->filter_values[$category]['description'], 'has-wrapper');
            $help_button = $help->get_button_html();
            $help_panel = $help->get_panel_html();
        }

        return sprintf(
            '<a href="%1$s" class="%2$s"%8$s>%3$s</a> (<span id="gsc_count_%4$s">%5$s</span>) %6$s %7$s',
            esc_attr($href),
            $class,
            $this->filter_values[$category]['value'],
            $category,
            $count,
            $help_button,
            $help_panel,
            $aria_current
        );
    }

    /**
     * Parsing the category counts.
     *
     * When there are 0 issues for a specific category, just remove that one from the array.
     *
     * @param  array  $category_counts  Set of counts for categories.
     * @return mixed
     */
    private function parse_counts($category_counts)
    {
        foreach ($category_counts as $category_name => $category) {
            if ($category['count'] === '0') {
                unset($category_counts[$category_name]);
            }
        }

        return $category_counts;
    }
}
