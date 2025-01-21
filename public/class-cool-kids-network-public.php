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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cool-kids-network-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
			$current_user = wp_get_current_user();
			return $current_user->display_name;
		}

		// Determine the active tab based on the URL's 'action' parameter.
		$action     = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : 'login'; // phpcs:ignore
		$active_tab = ( 'register' === $action ) ? 'register' : 'login';

		ob_start();
		?>
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
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<h3><?php esc_html_e( 'Register', 'cool-kids-network' ); ?></h3>
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
			<?php wp_nonce_field( 'coll-kids-network-register' ); ?>
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
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ckn_login">
			<h3><?php esc_html_e( 'Login', 'cool-kids-network' ); ?></h3>
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
			<?php wp_nonce_field( 'coll-kids-network-login' ); ?>
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
			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'coll-kids-network-login' ) ) {
				wp_die( esc_html__( 'Security check failed!', 'cool-kids-network' ) );
			}

			$email    = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
			$password = isset( $_POST['user_password'] ) ? sanitize_text_field( wp_unslash( $_POST['user_password'] ) ) : '';

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
				wp_die( esc_html__( 'The password you entered is incorrect.', 'cool-kids-network' ), esc_html__( 'Login Failed', 'cool-kids-network' ), array( 'back_link' => true ) );
			}

			wp_safe_redirect( wp_get_referer() );
			exit;
		}
	}
}
