<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/DevWael
 * @since      1.0.0
 *
 * @package    Ibn
 * @subpackage Ibn/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ibn
 * @subpackage Ibn/public
 * @author     Ahmad Wael <dev.ahmedwael@gmail.com>
 */
class Ibn_Public {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
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
		 * defined in Ibn_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ibn_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ibn-public.css', array(), $this->version, 'all' );

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
		 * defined in Ibn_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ibn_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ibn-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Modify the header of the theme to add breaking news bar
	 *
	 * @param $name string header name
	 * @param $args array header arguments
	 *
	 * @return void
	 */
	function modify_header( $name = null, $args = array() ) {
		// Remove the current function from the action hook, so it doesn't run again.
		remove_action( 'get_header', [ $this, 'modify_header' ] );
		// Run the function get_header with the arguments specified from the theme.
		get_header( $name, $args );
		// Include the breaking news bar template.
		if ( file_exists( get_template_directory() . '/ibn-templates/ibn-public-display.php' ) ) {
			// Include the breaking news bar template from theme directory.
			include_once get_template_directory() . '/ibn-templates/ibn-public-display.php';
		} else {
			// Include the breaking news bar template from plugin directory.
			include_once IBN_PLUGIN_DIR . 'public/partials/ibn-public-display.php';
		}
	}

	/**
	 * Add support for full site editing themes and add the ability to modify the header.
	 *
	 * @param $block_content
	 * @param $block
	 *
	 * @return mixed|string
	 */
	function append_to_fse_themes( $block_content, $block ) {

		// load block content normally if we are on admin page or there is a json request
		if ( is_admin() || wp_is_json_request() ) {
			return $block_content;
		}

		// If the get_header action ran we use the classic output method above.
		if ( did_action( 'get_header' ) ) {
			return $block_content;
		}

		// load block content normally if the block is not header block.
		if ( 'core/template-part' !== $block['blockName'] ) {
			return $block_content;
		}

		// load block content and include the breaking news bar template.
		if ( isset( $block['attrs']['tagName'] ) && 'header' == $block['attrs']['tagName'] ) {
			ob_start(); // start output buffering so we can return the output.
			if ( file_exists( get_template_directory() . '/ibn-templates/ibn-public-display.php' ) ) {
				// Include the breaking news bar template from theme directory.
				include_once get_template_directory() . '/ibn-templates/ibn-public-display.php';
			} else {
				// Include the breaking news bar template from plugin directory.
				include_once IBN_PLUGIN_DIR . 'public/partials/ibn-public-display.php';
			}
			$breaking_news_bar_content = ob_get_clean(); // get the output and clean the buffer.

			return $block_content . $breaking_news_bar_content; // return the block content with the breaking news bar template.
		}

		return $block_content;
	}
}
