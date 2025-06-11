<?php
defined('WPINC') or die;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://lehelmatyus.com
 * @since      1.0.0
 *
 * @package    Atomic_Events
 * @subpackage Atomic_Events/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Atomic_Events
 * @subpackage Atomic_Events/includes
 * @author     Lehel Matyus <contact@lehelmatyus.com>
 */
class Atomic_Events_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'atomic-events',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
