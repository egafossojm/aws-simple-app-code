<?php

if (! defined('ABSPATH')) {
    exit;
}

$classes = [
    'ac-column-heading-setting',
    'ac-column-indicator--'.$this->setting,
    'ac-column-indicator',
];

if ($this->dashicon) {
    $classes[] = 'dashicons';
    $classes[] = $this->dashicon;
}

if ($this->state == 'on') {
    $classes[] = 'on';
}

?>
<span class="<?php echo esc_attr(implode(' ', $classes)); ?>"
		title="<?php echo esc_attr($this->title); ?>"
		data-setting="<?php echo esc_attr($this->setting); ?>"
		data-indicator-toggle=""
>
</span>