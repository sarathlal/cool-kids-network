<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sarathlal.com
 * @since             1.0.0
 * @package           Cool_Kids_Network
 *
 * @wordpress-plugin
 * Plugin Name:       Cool Kids Network
 * Plugin URI:        https://sarathlal.com
 * Description:       This is a proof of concept project for RankMath.
 * Version:           1.0.0
 * Author:            Sarathlal N
 * Author URI:        https://sarathlal.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cool-kids-network
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COOL_KIDS_NETWORK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cool-kids-network-activator.php
 */
function activate_cool_kids_network() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-network-activator.php';
	Cool_Kids_Network_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cool-kids-network-deactivator.php
 */
function deactivate_cool_kids_network() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-network-deactivator.php';
	Cool_Kids_Network_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cool_kids_network' );
register_deactivation_hook( __FILE__, 'deactivate_cool_kids_network' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-network.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cool_kids_network() {

	$plugin = new Cool_Kids_Network();
	$plugin->run();
}
run_cool_kids_network();


if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Writes custom data to the WordPress debug.log file.
	 *
	 * This function checks if WP_DEBUG is enabled and writes the provided
	 * data to the debug.log file. It handles arrays and objects by converting
	 * them into a readable format.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $log The data to log. Can be a string, array, object, or any data type.
	 */
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) ); // phpcs:ignore
			} else {
				error_log( $log ); // phpcs:ignore
			}
		}
	}
}
