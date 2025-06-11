<?php

defined('WPINC') or die;

/**
 * Template loader for PW Sample Plugin.
 *
 * Only need to specify class properties here.
 *
 */
class Atomic_Template_Loader extends Atomic_Base_Template_Loader {

    /**
     * Prefix for filter names.
     *
     * @since 1.0.0
     * @type string
     */
    protected $filter_prefix = 'templates';

    /**
     * Directory name where custom templates for this plugin should be found in the theme.
     *
     * @since 1.0.0
     * @type string
     */
    protected $theme_template_directory = 'atomic-events';

    /**
     * Reference to the root directory path of this plugin.
     *
     * @since 1.0.0
     * @type string
     */
    protected $plugin_directory = ATOMIC_EVENTS_PLUGIN_DIR;
}
