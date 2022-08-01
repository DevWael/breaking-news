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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ibn-admin.js', array( 'jquery' ), $this->version, false );

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

}
