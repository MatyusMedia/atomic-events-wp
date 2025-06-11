<?php
defined('WPINC') or die;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://lehelmatyus.com
 * @since      1.0.0
 *
 * @package    Atomic_Events
 * @subpackage Atomic_Events/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Atomic_Events
 * @subpackage Atomic_Events/admin
 * @author     Lehel Matyus <contact@lehelmatyus.com>
 */
class Atomic_Events_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Atomic_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Atomic_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/atomic-events-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Atomic_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Atomic_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/atomic-events-admin.js', array('jquery'), $this->version, false);

		// only add the script is we are on the page where we are adding a new event

		$screen = get_current_screen();

		// Check if we're on the edit or add new page for "atomic-event" post type
		if ('post' === $screen->base && 'atomic-event' === $screen->post_type) {
			wp_enqueue_script($this->plugin_name . "add-new", plugin_dir_url(__FILE__) . 'js/atomic-events-admin-new-event.js', array('jquery'), $this->version, false);
		}
	}
}
