<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/DevWael
 * @since      1.0.0
 *
 * @package    Ibn
 * @subpackage Ibn/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ibn
 * @subpackage Ibn/admin
 * @author     Ahmad Wael <dev.ahmedwael@gmail.com>
 */
class Ibn_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
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
		 * defined in Ibn_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ibn_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ibn-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ibn_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ibn_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        //todo: load only on post edit page
		wp_enqueue_script( $this->plugin_name . '-metabox', plugin_dir_url( __FILE__ ) . 'js/classic-editor/metabox.js', array(
			'jquery',
		), $this->version, true );

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ibn-admin.js', array(
			'jquery',
			'wp-color-picker'
		), $this->version, true );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * This page will be available only for administrator user role.
	 *
	 * @return void
	 */
	public function options_page() {

		add_menu_page(
			esc_html__( 'Breaking News', 'ibn' ),
			esc_html__( 'Breaking News', 'ibn' ),
			'manage_options',
			'ibn-breaking-news-admin',
			array( $this, 'options_page_html' ),
			'dashicons-welcome-widgets-menus'
		);

	}

	/**
	 * Display the admin page content for this plugin.
	 * @return void
	 */
	public function options_page_html() {
		require_once IBN_PLUGIN_DIR . 'admin/partials/ibn-admin-display.php';
	}

	/**
	 * Save the plugin options came from POST request from plugin options page.
	 *
	 * @return void
	 */
	public function save_options() {

		// Check if the current user has permission to save options (only administrators).
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_safe_redirect( add_query_arg( array(
				'page'   => 'ibn-breaking-news-admin',
				'result' => 'fail',
				'code'   => 0, //code will be used to display the error message.
			), admin_url( 'admin.php' ) ) );
			exit;
		}

		// Check if the current request contains nonce code
		if ( ! isset( $_POST['ibn_nonce'] ) ) {
			wp_safe_redirect( add_query_arg( array(
				'page'   => 'ibn-breaking-news-admin',
				'result' => 'fail',
				'code'   => 1,
			), admin_url( 'admin.php' ) ) );
			exit;
		}

		// Check if the nonce code is valid.
		if ( ! wp_verify_nonce( $_POST['ibn_nonce'], 'ibn-settings' ) ) {
			wp_safe_redirect( add_query_arg( array(
				'page'   => 'ibn-breaking-news-admin',
				'result' => 'fail',
				'code'   => 2,
			), admin_url( 'admin.php' ) ) );
			exit;
		}

		// collect general settings data from POST request.
		$data = array(
			'ibn-title'           => isset( $_POST['ibn-title'] ) ? sanitize_text_field( $_POST['ibn-title'] ) : '',
			'ibn-title-bg'        => isset( $_POST['ibn-title-bg'] ) ? sanitize_hex_color( $_POST['ibn-title-bg'] ) : '',
			'ibn-title-color'     => isset( $_POST['ibn-title-color'] ) ? sanitize_hex_color( $_POST['ibn-title-color'] ) : '',
			'ibn-post-bg'         => isset( $_POST['ibn-post-bg'] ) ? sanitize_hex_color( $_POST['ibn-post-bg'] ) : '',
			'ibn-post-color'      => isset( $_POST['ibn-post-color'] ) ? sanitize_hex_color( $_POST['ibn-post-color'] ) : '',
			'ibn-bar-placement'   => ( isset( $_POST['ibn-bar-placement'] ) && $_POST['ibn-bar-placement'] === 'manual' ) ? 'manual' : 'automatic',
			'ibn-css-selector'    => isset( $_POST['ibn-css-selector'] ) ? sanitize_text_field( $_POST['ibn-css-selector'] ) : '',
			'ibn-rounded-corners' => isset( $_POST['ibn-rounded-corners'] ) ? 1 : 0,
			'ibn-active'          => isset( $_POST['ibn-active'] ) ? 1 : 0,
		);

		// Save general settings data to database.
		Ibn_Settings::set_general_settings( $data );

		// return to the plugin options page after successful saving data attempt.
		wp_safe_redirect( add_query_arg( array(
			'page'   => 'ibn-breaking-news-admin',
			'result' => 'success',
			'code'   => 0,
		), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Display admin notices after submitting the plugin options page.
	 * @return void
	 */
	public function admin_notice() {
		if ( isset( $_GET['result'] ) && $_GET['result'] == 'success' ) { // success.
			?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e( 'Settings saved successfully.', 'ibn' ); ?></p>
            </div>
			<?php
		} else if ( isset( $_GET['result'] ) && $_GET['result'] == 'fail' ) { //if failure, display error message.
            // display error message based on error code
			$messages = array(
				0 => esc_html__( 'You don\'t have the permissions to do this action!', 'ibn' ),
				1 => esc_html__( 'Invalid request, Cannot find nonce key!', 'ibn' ),
				2 => esc_html__( 'Invalid nonce code!', 'ibn' ),
			);
			if ( isset( $_GET['code'] ) && $_GET['code'] <= count( $messages ) - 1 ) {
				?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo $messages[ $_GET['code'] ]; ?></p>
                </div>
				<?php
			}
		}
	}
}
