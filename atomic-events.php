<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://lehelmatyus.com
 * @since             1.0.0
 * @package           Atomic_Events
 *
 * @wordpress-plugin
 * Plugin Name:       Atomic Events
 * Plugin URI:        https://lehelmatyus.com/atomicevents-io
 * Description:       Really Simple Events Plugin That's ready to use out of the box. Extra features available.
 * Version:           1.0.0
 * Author:            Lehel Matyus
 * Author URI:        https://lehelmatyus.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       atomic-events
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ATOMIC_EVENTS_VERSION', '1.0.0');
define('ATOMIC_EVENTS_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-atomic-events-activator.php
 */
function ATMC_activate_atomic_events() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-atomic-events-activator.php';
	Atomic_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-atomic-events-deactivator.php
 */
function ATMC_deactivate_atomic_events() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-atomic-events-deactivator.php';
	Atomic_Events_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'ATMC_activate_atomic_events');
register_deactivation_hook(__FILE__, 'ATMC_deactivate_atomic_events');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-atomic-events.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ATMC_run_atomic_events() {

	$plugin = new Atomic_Events();
	$plugin->run();
}
ATMC_run_atomic_events();
