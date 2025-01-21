<?php
/**
 * The REST route registering & related functionalities in the plugin.
 *
 * @link       https://sarathlal.com
 * @since      1.0.0
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/api
 */

/**
 * The API controller of the plugin.
 *
 * Defines the plugin name, version, and register REST route function.
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/api
 * @author     Sarathlal N <hello@sarathlal.com>
 */
class Cool_Kids_Network_Role_Controller extends WP_REST_Controller {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->namespace   = 'cool-kids-network/v1';
		$this->rest_base   = 'role';
	}

	/**
	 * Registers the routes for the custom REST controller.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::EDITABLE, // Allows PUT or PATCH requests.
					'callback'            => array( $this, 'update_user_role' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_endpoint_args(),
				),
			)
		);
	}

	/**
	 * Callback to handle the request and update user role.
	 *
	 * @param WP_REST_Request $request The REST API request object.
	 * @return WP_REST_Response
	 */
	public function update_user_role( WP_REST_Request $request ) {
		$email         = $request->get_param( 'email' );
		$first_name    = $request->get_param( 'first_name' );
		$last_name     = $request->get_param( 'last_name' );
		$new_role      = $request->get_param( 'role' );
		$allowed_rules = array( 'cool_kid', 'cooler_kid', 'coolest_kid' );

		// Validate role.
		if ( ! in_array( $new_role, $allowed_rules, true ) ) {
			return new WP_REST_Response(
				array(
					'status'  => 'error',
					'message' => 'Invalid role provided.',
				),
				400
			);
		}

		// Find user by email or name combination.
		$user = null;

		if ( ! empty( $email ) ) {
			$user = get_user_by( 'email', $email );
		} elseif ( ! empty( $first_name ) && ! empty( $last_name ) ) {
			$user_query = new WP_User_Query(
				array(
					'meta_query' => array(  // phpcs:ignore
						'relation' => 'AND',
						array(
							'key'   => 'first_name',
							'value' => $first_name,
						),
						array(
							'key'   => 'last_name',
							'value' => $last_name,
						),
					),
				)
			);
			$users      = $user_query->get_results();
			if ( ! empty( $users ) ) {
				$user = $users[0];
			}
		}

		if ( ! $user ) {
			return new WP_REST_Response(
				array(
					'status'  => 'error',
					'message' => 'User not found.',
				),
				404
			);
		}

		// Update role.
		$user->set_role( $new_role );

		return new WP_REST_Response(
			array(
				'status'  => 'success',
				'message' => 'User role updated successfully.',
				'user_id' => $user->ID,
			),
			200
		);
	}

	/**
	 * Permission check callback.
	 *
	 * @param WP_REST_Request $request The REST API request.
	 * @return bool
	 */
	public function permissions_check( $request ) {
		return current_user_can( 'edit_users' ); // Only allow users with the `edit_users` capability.
	}

	/**
	 * Arguments schema for the endpoint.
	 *
	 * @return array
	 */
	public function get_endpoint_args() {
		return array(
			'email'      => array(
				'required'          => false,
				'type'              => 'string',
				'validate_callback' => function ( $param ) {
					return is_email( $param ); // Validate email format.
				},
			),
			'first_name' => array(
				'required' => false,
				'type'     => 'string',
			),
			'last_name'  => array(
				'required' => false,
				'type'     => 'string',
			),
			'role'       => array(
				'required' => true,
				'type'     => 'string',
			),
		);
	}
}
