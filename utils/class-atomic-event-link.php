<?php

defined('WPINC') or die;

class AtomicEvents_Link {
    /**
     * Generates a link with provided attributes.
     *
     * @param string $url The URL of the link (mandatory).
     * @param array $options An array of options for the link (optional).
     * Supported options:
     * - text: The anchor text (default: URL).
     * - class: CSS classes for the link (default: empty).
     * - attributes: Extra attributes for the <a> tag (default: empty).
     * - alt: Alternate text for the link (default: empty).
     * - new_tab: Whether to open the link in a new tab (default: false).
     * @return string The HTML code for the link.
     */
    public static function get_link($url, $options = array()) {
        // Mandatory: URL
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return ''; // Return empty string if URL is invalid or empty
        }

        // Set default options
        $defaults = array(
            'text' => $url,
            'class' => '',
            'attributes' => '',
            'alt' => '',
            'new_tab' => false
        );

        // Merge provided options with defaults
        $options = wp_parse_args($options, $defaults);

        // If text is not provided, use URL as the text
        if (empty($options['text'])) {
            $options['text'] = $url;
        }

        // Sanitize URL
        $url = esc_url($url);

        // Sanitize text
        $text = esc_html($options['text']);

        // Handle CSS classes
        if (!empty($options['class'])) {
            if (is_array($options['class'])) {
                // If it's an array, implode into a string
                $class = implode(' ', array_map('esc_attr', $options['class']));
            } else {
                // If it's a string, escape and use as is
                $class = esc_attr($options['class']);
            }
        } else {
            $class = ''; // Default to empty string if no class is provided
        }

        // Sanitize extra attributes
        $attributes = '';
        foreach ((array)$options['attributes'] as $key => $value) {
            $attributes .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }

        // Sanitize alternate text
        $alt = esc_attr($options['alt']);

        // Determine if link should open in new tab
        $target = ($options['new_tab']) ? ' target="_blank" rel="noopener noreferrer"' : '';

        // Generate HTML for the link
        $html = '<a href="' . $url . '" class="' . $class . '"' . $attributes . $target . '>' . $text . '</a>';

        return $html;
    }

    /**
     * Renders a link with provided attributes and echoes it.
     *
     * @param string $url The URL of the link (mandatory).
     * @param array $options An array of options for the link (optional).
     * @return void
     */
    public static function render($url, $options = array()) {
        echo wp_kses_post(self::get_link($url, $options));
    }
}
