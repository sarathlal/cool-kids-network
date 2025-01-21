<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sarathlal.com
 * @since      1.0.0
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and other methods.
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/admin
 * @author     Sarathlal N <hello@sarathlal.com>
 */
class Cool_Kids_Network_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Adds custom user roles with specific capabilities.
	 *
	 * This function defines three custom user roles for the "Cool Kids Network" plugin:
	 * - **Cool Kid**: Can read their own data.
	 * - **Cooler Kid**: Can read their own data and view other users' data (except protected fields).
	 * - **Coolest Kid**: Can read their own data, view other users' data, and view protected data.
	 *
	 * Each role is created with a unique set of capabilities:
	 * - `ckn_read`: Allows users to read their own data.
	 * - `ckn_view_others_data`: Allows users to view other users' data (non-protected).
	 * - `ckn_view_protected_data`: Allows users to view all data, including protected fields.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function custom_user_roles() {
		// Add Cool Kid role.
		add_role(
			'cool_kid',
			__( 'Cool Kid', 'cool-kids-network' ),
			array(
				'ckn_read' => true, // Can read own data.
			)
		);

		// Add Cooler Kid role.
		add_role(
			'cooler_kid',
			__( 'Cooler Kid', 'cool-kids-network' ),
			array(
				'ckn_read'             => true, // Can read own data.
				'ckn_view_others_data' => true, // Custom capability to view other user data.
			)
		);

		// Add Coolest Kid role.
		add_role(
			'coolest_kid',
			__( 'Coolest Kid', 'cool-kids-network' ),
			array(
				'ckn_read'                => true, // Can read own data.
				'ckn_view_others_data'    => true, // Can view other user data.
				'ckn_view_protected_data' => true, // Custom capability to view protected data.
			)
		);
	}
}
