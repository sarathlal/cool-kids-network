<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sarathlal.com
 * @since      1.0.0
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and methods for public facing functionality.
 *
 * @package    Cool_Kids_Network
 * @subpackage Cool_Kids_Network/public
 * @author     Sarathlal N <hello@sarathlal.com>
 */
class Cool_Kids_Network_Public {

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
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cool-kids-network-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cool-kids-network-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register a custom shortcode.
	 *
	 * @since    1.0.0
	 */
	public function register_short_code() {
		add_shortcode( 'cool_kids_network', array( $this, 'render_cool_kids_network' ) );
	}

	/**
	 * Shortcode callback function.
	 *
	 * @since    1.0.0
	 *
	 * @return string The content to display.
	 */
	public function render_cool_kids_network() {

		// Check if the user is logged in.
		if ( is_user_logged_in() ) {
			return $this->display_user_data();
		}

		// Determine the active tab based on the URL's 'action' parameter.
		$action     = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : 'login'; // phpcs:ignore
		$active_tab = ( 'register' === $action ) ? 'register' : 'login';

		ob_start();
		?>
		<div class="cool-kids-network-wrap">

			<?php  // phpcs:ignore
			if ( ! empty( $_GET['registration'] ) && 'success' === $_GET['registration'] ) { ?>
				<p class="success message"><?php esc_html_e( 'Registration successful! Please log in to access your account.', 'cool-kids-network' ); ?></p>
			<?php } ?>

			<div class="cool-kids-network-tabs">
				<!-- Tab Navigation -->
				<ul class="tabs">
					<li class="<?php echo ( 'login' === $active_tab ) ? 'active' : ''; ?>">
						<a href="?action=login"><?php esc_html_e( 'Login', 'cool-kids-network' ); ?></a>
					</li>
					<li class="<?php echo ( 'register' === $active_tab ) ? 'active' : ''; ?>">
						<a href="?action=register"><?php esc_html_e( 'Register', 'cool-kids-network' ); ?></a>
					</li>
				</ul>

				<!-- Tab Content -->
				<div class="tab-content">
					<?php if ( 'login' === $active_tab ) : ?>
						<div id="login" class="tab-pane active">
							<?php $this->render_login_form(); ?>
						</div>
					<?php elseif ( 'register' === $active_tab ) : ?>
						<div id="register" class="tab-pane active">
							<?php $this->render_register_form(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render the registration form.
	 *
	 * This function outputs the HTML structure for the registration form,
	 * which includes fields for the user's email and password, as well as a submit button.
	 * The form submits data to the WordPress `admin-post.php` endpoint for processing.
	 *
	 * @since 1.0.0
	 */
	public function render_register_form() {
		?>
		<form class="cool-kids-network-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ckn_register">
			<p>
				<label for="user_email"><?php esc_html_e( 'Email', 'cool-kids-network' ); ?></label>
				<input type="email" id="user_email" name="user_email" required>
			</p>
			<p>
				<label for="user_password"><?php esc_html_e( 'Password', 'cool-kids-network' ); ?></label>
				<input type="password" id="user_password" name="user_password" required>
			</p>
			<p>
				<button type="submit" name="register_submit"><?php esc_html_e( 'Register', 'cool-kids-network' ); ?></button>
			</p>
			<?php wp_nonce_field( 'cool-kids-network-register' ); ?>
		</form>
		<?php
	}

	/**
	 * Render the login form.
	 *
	 * This function outputs the HTML structure for the login form,
	 * which includes fields for the user's email and password, as well as a submit button.
	 * The form submits data to the WordPress `admin-post.php` endpoint for processing.
	 *
	 * @since 1.0.0
	 */
	public function render_login_form() {
		?>
		<form class="cool-kids-network-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ckn_login">
			<p>
				<label for="user_email"><?php esc_html_e( 'Email', 'cool-kids-network' ); ?></label>
				<input type="email" id="user_email" name="user_email" required>
			</p>
			<p>
				<label for="user_password"><?php esc_html_e( 'Password', 'cool-kids-network' ); ?></label>
				<input type="password" id="user_password" name="user_password" required>
			</p>
			<p>
				<button type="submit" name="login_submit"><?php esc_html_e( 'Login', 'cool-kids-network' ); ?></button>
			</p>
			<?php wp_nonce_field( 'cool-kids-network-login' ); ?>
		</form>
		<?php
	}

	/**
	 * Handles the custom login functionality for the plugin.
	 *
	 * This function processes a login form submitted via POST, verifies the
	 * provided nonce for security, authenticates the user using their email
	 * and password, and logs them into the WordPress site. If the login
	 * process fails at any stage, an appropriate error message is displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 * @throws WP_Error Displays an error message and halts execution if login fails.
	 */
	public function login() {
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['login_submit'] ) ) {

			// Verify the nonce to ensure the request is valid.
			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'cool-kids-network-login' ) ) {
				wp_die( esc_html__( 'Security check failed!', 'cool-kids-network' ) );
			}

			$email = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
			// Skipped sanitization on password field to ensure original password. Function wp_signon internnaly sanitize and validate password data & so it's okay to skip.
			$password = isset( $_POST['user_password'] ) ? wp_unslash( $_POST['user_password'] ) : ''; // phpcs:ignore

			// Find the user by email.
			$user = get_user_by( 'email', $email );
			if ( ! $user ) {
				// User not found.
				wp_die( esc_html__( 'Invalid email address. Please try again.', 'cool-kids-network' ), esc_html__( 'Login Failed', 'cool-kids-network' ), array( 'back_link' => true ) );
			}

			// Prepare credentials for wp_signon.
			$creds = array(
				'user_login'    => $user->user_login, // Use the username, not the email.
				'user_password' => $password,
				'remember'      => true, // Set to false if you don't want the user remembered.
			);

			// Attempt to sign the user in.
			$user_signon = wp_signon( $creds, false );

			if ( is_wp_error( $user_signon ) ) {
				// Authentication failed.
				wp_die(
					$user_signon->get_error_message(), // phpcs:ignore
					esc_html__( 'Login Failed', 'cool-kids-network' ),
					array( 'back_link' => true )
				);
			}

			$referer = wp_get_referer();

			// List of query keys to remove.
			$keys_to_remove = array( 'action', 'registration' );

			// Remove the specified query arguments.
			$clean_url = remove_query_arg( $keys_to_remove, $referer );

			wp_safe_redirect( esc_url( $clean_url ) );
			exit;
		}
	}

	/**
	 * Handles the user registration process for the plugin.
	 *
	 * This function processes the registration form submitted via POST. It performs
	 * necessary validation, including nonce verification and duplicate email checks,
	 * creates a new user account, and redirects the user to the referring page with
	 * query parameters indicating the registration status.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 * @throws WP_Error If the user registration process fails due to invalid data or
	 *                  an existing user with the same email.
	 */
	public function register() {
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['register_submit'] ) ) {

			// Verify the nonce to ensure the request is valid.
			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'cool-kids-network-register' ) ) {
				wp_die( esc_html__( 'Security check failed!', 'cool-kids-network' ) );
			}

			$email = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
			// Skipped sanitization on password field to ensure original password. Function wp_create_user internnaly sanitize and validate password data & so it's okay to skip.
			$password = isset( $_POST['user_password'] ) ? wp_unslash( $_POST['user_password'] ) : ''; // phpcs:ignore

			// Check if the email already exists.
			if ( email_exists( $email ) ) {
				wp_die(
					esc_html__( 'The email address is already registered. Please use a different email or log in.', 'cool-kids-network' ),
					esc_html__( 'Registration Error', 'cool-kids-network' ),
					array( 'back_link' => true )
				);
			}

			// Create the user.
			$user_id = wp_create_user( $email, $password, $email ); // Using email as user name.

			if ( is_wp_error( $user_id ) ) {
				write_log( 'Registration Error' );
				write_log( $user_id->get_error_message() ); // phpcs:ignore
				wp_die(
					$user_id->get_error_message(), // phpcs:ignore
					esc_html__( 'Registration Error', 'cool-kids-network' ),
					array( 'back_link' => true )
				);
			}

			// Assign "Cool Kid" role to the user.
			$user = new WP_User( $user_id );
			$user->set_role( 'cool_kid' );

			// Fetch additional data from the API and update user meta.
			$this->update_fake_data( $user_id );

			$referer      = wp_get_referer(); // Get the referer URL.
			$redirect_url = add_query_arg(
				array(
					'action'       => 'login',
					'registration' => 'success',
				),
				$referer
			);

			// Safely redirect to the modified URL.
			wp_safe_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Fetches user data from the randomuser.me API and updates the user meta after ensuring uniqueness.
	 *
	 * This function ensures the combination of first name and last name is unique in the database.
	 * If the combination already exists, it makes additional API requests until a unique combination is found.
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id The ID of the user to update.
	 *
	 * @return void
	 */
	public function update_fake_data( $user_id ) {
		$api_url      = 'https://randomuser.me/api/';
		$max_attempts = 20; // Limit the number of attempts to avoid infinite loops.
		$attempts     = 0;

		$first_name = '';
		$last_name  = '';
		$user_data  = array();

		do {
			$response = wp_safe_remote_get( $api_url );

			if ( is_wp_error( $response ) ) {
				write_log( 'Failed to fetch data from randomuser.me: ' . $response->get_error_message() );
				return;
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( empty( $data['results'][0] ) ) {
				write_log( 'Invalid response from randomuser.me API.' );
				return;
			}

			$user_data = $data['results'][0];

			// Extract first name and last name.
			$first_name = isset( $user_data['name']['first'] ) ? $user_data['name']['first'] : '';
			$last_name  = isset( $user_data['name']['last'] ) ? $user_data['name']['last'] : '';

			// Check if the combination already exists.
			$existing_users = get_users(
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
					'fields'     => 'ID',
				)
			);

			++$attempts;

			// Continue fetching if the combination exists.
		} while ( ! empty( $existing_users ) && $attempts < $max_attempts );

		// If we reached the max attempts and still found duplicates, log an error and return.
		if ( $attempts >= $max_attempts ) {
			write_log( 'Failed to generate a unique name after ' . $max_attempts . ' attempts.' );
			return;
		}

		// Extract country.
		$country = isset( $user_data['location']['country'] ) ? $user_data['location']['country'] : '';

		// Update user meta.
		if ( $first_name ) {
			update_user_meta( $user_id, 'first_name', $first_name );
		}

		if ( $last_name ) {
			update_user_meta( $user_id, 'last_name', $last_name );
		}

		if ( $country ) {
			update_user_meta( $user_id, 'country', sanitize_text_field( $country ) );
		}
	}

	/**
	 * Generates HTML to display user-specific data based on capabilities.
	 *
	 * This function retrieves and displays user-specific data depending on the logged-in user's
	 * capabilities. The displayed data and its structure can vary based on the capabilities
	 * assigned to the user.
	 *
	 * Key capabilities:
	 * - `ckn_read`: Allows the user to view their own data.
	 *
	 * @since 1.0.0
	 *
	 * @return string The generated HTML containing the user-specific data.
	 */
	private function display_user_data() {
		$current_user   = wp_get_current_user();
		$users_per_page = 20; // Number of users per page.
		// phpcs:ignore
		$paged          = isset( $_GET['page_num'] ) ? absint( $_GET['page_num'] ) : 1; // Get the current page from query parameter.

		ob_start();
		?>
		<div class="cool-kids-network-details-wrap">
			<?php
			// Check if the user has the 'ckn_read' capability.
			if ( current_user_can( 'ckn_read' ) ) { // phpcs:ignore
				// Display own data.
				?>
				<h2><?php esc_html_e( 'Your details', 'cool-kids-network' ); ?></h2>
				<table>
					<tbody>
						<tr>
							<th><?php esc_html_e( 'First Name', 'cool-kids-network' ); ?></th>
							<td><?php echo esc_html( get_user_meta( $current_user->ID, 'first_name', true ) ); ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Last Name', 'cool-kids-network' ); ?></th>
							<td><?php echo esc_html( get_user_meta( $current_user->ID, 'last_name', true ) ); ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Country', 'cool-kids-network' ); ?></th>
							<td><?php echo esc_html( get_user_meta( $current_user->ID, 'country', true ) ); ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Email', 'cool-kids-network' ); ?></th>
							<td><?php echo esc_html( $current_user->user_email ); ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Role', 'cool-kids-network' ); ?></th>
							<td><?php echo esc_html( implode( ', ', $current_user->roles ) ); ?></td>
						</tr>
					</tbody>
				</table>

				<?php
			}

			// Check if the user has the 'ckn_view_others_data' capability to display other users' data.
			if ( current_user_can( 'ckn_view_others_data' ) ) { // phpcs:ignore
				?>
				<h2><?php esc_html_e( 'Other Cool Kids', 'cool-kids-network' ); ?></h2>
				<?php
				$user_query = new WP_User_Query(
					array(
						'exclude'  => array( $current_user->ID ), // Exclude the logged-in user.
						'role__in' => array( 'cool_kid', 'cooler_kid', 'coolest_kid' ), // Include specific roles.
						'number'   => $users_per_page, // Users per page.
						'paged'    => $paged, // Current page.
						'orderby'  => 'user_registered', // Order by registration date.
						'order'    => 'ASC', // Ascending order.
					)
				);

				$all_users   = $user_query->get_results();
				$total_users = $user_query->get_total();
				$total_pages = ceil( $total_users / $users_per_page );

				if ( ! empty( $all_users ) ) {
					?>
					<table class="cool-kids-network-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'First Name', 'cool-kids-network' ); ?></th>
								<th><?php esc_html_e( 'Last Name', 'cool-kids-network' ); ?></th>
								<th><?php esc_html_e( 'Country', 'cool-kids-network' ); ?></th>
								<?php if ( current_user_can( 'ckn_view_protected_data' ) ) :  // phpcs:ignore ?>
									<th><?php esc_html_e( 'Email', 'cool-kids-network' ); ?></th>
									<th><?php esc_html_e( 'Role', 'cool-kids-network' ); ?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $all_users as $user ) : ?>
								<tr>
									<?php
									$first_name = get_user_meta( $user->ID, 'first_name', true );
									$last_name  = get_user_meta( $user->ID, 'last_name', true );
									$country    = get_user_meta( $user->ID, 'country', true );
									?>
									<td><?php echo esc_html( $first_name ); ?></td>
									<td><?php echo esc_html( $last_name ); ?></td>
									<td><?php echo esc_html( $country ); ?></td>
									<?php if ( current_user_can( 'ckn_view_protected_data' ) ) :  // phpcs:ignore ?>
										<td><?php echo esc_html( $user->user_email ); ?></td>
										<td><?php echo esc_html( implode( ', ', $user->roles ) ); ?></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php if ( $total_pages > 1 ) : ?>
						<div class="paginate">

							<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
								<a href="?page_num=<?php echo absint( $i ); ?>" 
									class="<?php echo ( $i === $paged ) ? 'active' : ''; ?>">
									<?php echo absint( $i ); ?>
								</a>
							<?php endfor; ?>

						</div>
					<?php endif; ?>

				<?php } else { ?>
					<p><?php echo esc_html__( 'No users found matching the criteria.', 'cool-kids-network' ); ?></p>
					<?php
				}
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}
