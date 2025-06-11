<?php

defined('WPINC') or die;

class AtomicEvent_TemplateUtils {
    public function __construct() {
    }

    function get_template_path($relative_file_path) {


        //load from child theme
        $child_theme_directory = get_stylesheet_directory();
        $absolute_file_path = $child_theme_directory . "/atomic-events/" . $relative_file_path;
        if (file_exists($absolute_file_path)) {
            return $absolute_file_path;
        }

        //load from theme
        $theme_directory = get_template_directory();
        $absolute_file_path = $theme_directory . "/atomic-events/" . $relative_file_path;
        if (file_exists($absolute_file_path)) {
            return $absolute_file_path;
        }

        // plugin path
        $absolute_file_path = plugin_dir_path(__FILE__) . '../templates/' . $relative_file_path;
        if (file_exists($absolute_file_path)) {
            return $absolute_file_path;
        }

        return '';
    }

    function load_custom_single_event_template($template) {
        global $post;
        if ($post->post_type == 'atomic-event' && is_single()) {
            $template_path = $this->get_template_path('single/single-atomic-event.php');

            if (!empty($template_path)) {
                return $template_path;
            }
        }

        return $template;
    }
}
