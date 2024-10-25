<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_How_To_Block.
 */
class WPSEO_How_To_Block implements WPSEO_WordPress_Integration
{
    /**
     * Registers the how-to block as a server-side rendered block.
     *
     * @return void
     */
    public function register_hooks()
    {
        if (! function_exists('register_block_type')) {
            return;
        }

        register_block_type(
            'yoast/how-to-block',
            ['render_callback' => [$this, 'render']]
        );
    }

    /**
     * Renders the block.
     *
     * Because we can't save script tags in Gutenberg without sufficient user permissions,
     * we render these server-side.
     *
     * @param  array  $attributes  The attributes of the block.
     * @param  string  $content  The HTML content of the block.
     * @return string The block preceded by its JSON-LD script.
     */
    public function render($attributes, $content)
    {
        if (! is_array($attributes) || ! is_singular()) {
            return $content;
        }

        $json_ld = $this->get_json_ld($attributes);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [$json_ld],
        ];

        return WPSEO_Utils::schema_tag($schema).$content;
    }

    /**
     * Returns the JSON-LD for a how-to block.
     *
     * @param  array  $attributes  The attributes of the how-to block.
     * @return array The JSON-LD representation of the how-to block.
     */
    protected function get_json_ld(array $attributes)
    {
        $hash = WPSEO_Schema_IDs::WEBPAGE_HASH;
        if (WPSEO_Schema_Article::is_article_post_type()) {
            $hash = WPSEO_Schema_IDs::ARTICLE_HASH;
        }

        $json_ld = [
            '@type' => 'HowTo',
            'mainEntityOfPage' => ['@id' => WPSEO_Frontend::get_instance()->canonical(false).$hash],
        ];

        $post_title = get_the_title();
        if (! empty($post_title)) {
            $json_ld['name'] = $post_title;
        }

        if (! empty($attributes['hasDuration']) && $attributes['hasDuration'] === true) {
            $days = empty($attributes['days']) ? 0 : $attributes['days'];
            $hours = empty($attributes['hours']) ? 0 : $attributes['hours'];
            $minutes = empty($attributes['minutes']) ? 0 : $attributes['minutes'];

            if (($days + $hours + $minutes) > 0) {
                $json_ld['totalTime'] = 'P'.$days.'DT'.$hours.'H'.$minutes.'M';
            }
        }

        if (! empty($attributes['jsonDescription'])) {
            $json_ld['description'] = $attributes['jsonDescription'];
        }

        if (! empty($attributes['steps']) && is_array($attributes['steps'])) {
            $json_ld['step'] = [];
            $steps = array_filter($attributes['steps'], 'is_array');
            foreach ($steps as $step) {
                $json_ld['step'][] = $this->get_section_json_ld($step);
            }
        }

        return $json_ld;
    }

    /**
     * Returns the JSON-LD for a step-section in a how-to block.
     *
     * @param  array  $step  The attributes of a step-section in the how-to block.
     * @return array The JSON-LD representation of the step-section in a how-to block.
     */
    protected function get_section_json_ld(array $step)
    {
        $section_json_ld = [
            '@type' => 'HowToSection',
            'itemListElement' => $this->get_step_json_ld($step),
        ];

        if (! empty($step['jsonName'])) {
            $section_json_ld['name'] = $step['jsonName'];
        }

        if (! empty($step['jsonImageSrc'])) {
            $section_json_ld['image'] = [
                '@type' => 'ImageObject',
                'contentUrl' => $step['jsonImageSrc'],
            ];
        }

        return $section_json_ld;
    }

    /**
     * Returns the JSON-LD for a step's description in a how-to block.
     *
     * @param  array  $step  The attributes of a step(-section) in the how-to block.
     * @return array The JSON-LD representation of the step's description in a how-to block.
     */
    protected function get_step_json_ld(array $step)
    {
        $step_json_ld = [
            '@type' => 'HowToStep',
        ];

        if (! empty($step['jsonText'])) {
            $step_json_ld['text'] = $step['jsonText'];
        }

        return $step_json_ld;
    }
}
