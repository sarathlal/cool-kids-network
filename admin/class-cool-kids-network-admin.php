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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cool_Kids_Network_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cool_Kids_Network_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cool-kids-network-admin.css', array(), $this->version, 'all' );
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
		 * defined in Cool_Kids_Network_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cool_Kids_Network_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cool-kids-network-admin.js', array( 'jquery' ), $this->version, false );
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
