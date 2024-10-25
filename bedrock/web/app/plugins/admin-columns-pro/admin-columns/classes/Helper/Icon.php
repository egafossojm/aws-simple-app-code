<?php

namespace AC\Helper;

class Icon
{
    public function dashicon($args = [])
    {
        $defaults = [
            'icon' => '',
            'title' => '',
            'class' => '',
            'tooltip' => '',
        ];

        $data = (object) wp_parse_args($args, $defaults);

        $class = 'dashicons dashicons-'.$data->icon;

        if ($data->class) {
            $class .= ' '.trim($data->class);
        }

        $attributes = [];

        if ($data->title) {
            $attributes[] = 'title="'.esc_attr($data->title).'"';
        }

        if ($data->tooltip) {
            $attributes[] = ac_helper()->html->get_tooltip_attr($data->tooltip);
        }

        return '<span class="'.esc_attr($class).'" '.implode(' ', $attributes).'></span>';
    }

    /**
     * @since 3.0
     *
     * @param  bool  $tooltip
     * @param  bool  $title
     * @param  string  $class
     * @return string
     */
    public function yes($tooltip = false, $title = true, $class = 'green')
    {
        if ($title === true) {
            $title = __('Yes');
        }

        return $this->dashicon(['icon' => 'yes', 'class' => $class, 'title' => $title, 'tooltip' => $tooltip]);
    }

    /**
     * @since 3.0
     *
     * @param  bool  $tooltip
     * @param  bool  $title
     * @param  string  $class
     * @return string
     */
    public function no($tooltip = false, $title = true, $class = 'red')
    {
        if ($title === true) {
            $title = __('No');
        }

        return $this->dashicon(['icon' => 'no-alt', 'class' => $class, 'title' => $title, 'tooltip' => $tooltip]);
    }

    /**
     * @since 3.0
     *
     * @param  string  $tooltip
     * @return string HTML Dashicon
     */
    public function yes_or_no($is_true, $tooltip = '')
    {
        return $is_true ? $this->yes($tooltip) : $this->no($tooltip);
    }
}
