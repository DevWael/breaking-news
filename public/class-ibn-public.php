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

	private function breaking_news_options() {
		return Ibn_Settings::get_general_settings();
	}

	public function bar_styling() {
		$options = $this->breaking_news_options();
		$css     = '';
		if ( isset( $options['ibn-title-bg'] ) && ! empty( $options['ibn-title-bg'] ) ) {
			$css .= '.ibn-news-ticker{background-color:' . sanitize_hex_color( $options['ibn-title-bg'] ) . ';}';
		}
		if ( isset( $options['ibn-title-color'] ) && ! empty( $options['ibn-title-color'] ) ) {
			$css .= '.ibn-news-ticker .ticker-title h3{color:' . sanitize_hex_color( $options['ibn-title-color'] ) . ';}';
		}
		if ( isset( $options['ibn-post-bg'] ) && ! empty( $options['ibn-post-bg'] ) ) {
			$css .= '.ibn-news-ticker .ticker-content{background-color:' . sanitize_hex_color( $options['ibn-post-bg'] ) . ';}';
		}
		if ( isset( $options['ibn-post-color'] ) && ! empty( $options['ibn-post-color'] ) ) {
			$css .= '.ibn-news-ticker .ticker-content a{color:' . sanitize_hex_color( $options['ibn-post-color'] ) . ';}';
		}
		if ( $css ) {
			return $css;
		}

		return false;
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
		if ( ! $this->can_display_bar() ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ibn-public.css', array(), $this->version, 'all' );

		if ( $this->bar_styling() ) {
			wp_add_inline_style( $this->plugin_name, $this->bar_styling() );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! $this->can_display_bar() ) {
			return;
		}

		$options = $this->breaking_news_options();

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ibn-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'ibn_obj', array(
			'header_placement' => isset( $options['ibn-bar-placement'] ) ? esc_js( $options['ibn-bar-placement'] ) : 'automatic',
			'header_selector'  => isset( $options['ibn-css-selector'] ) ? esc_js( $options['ibn-css-selector'] ) : '',
		) );
	}

	/**
	 * Check if the bar should be displayed.
	 *
	 * Check if there is any post to display.
	 * Check if the post is existing published.
	 * Check if the post expiry date is not expired.
	 * Check if the bar is enabled.
	 * @return bool
	 */
	public function can_display_bar() {
		$status      = true;
		$bar_options = Ibn_Settings::get_general_settings();
		// check if user choose to show the bar on the front-end.
		if ( isset( $bar_options['ibn-active'] ) && $bar_options['ibn-active'] !== 1 ) {
			$status = false;
		}
		$post_id = get_option( 'ibn_breaking_news_post_id' );
		if ( ! $post_id || ! is_numeric( $post_id ) ) {
			$status = false;
		}
		if ( 'publish' !== get_post_status( $post_id ) ) {
			$status = false;
		}
		$post_expiry_toggle = get_post_meta( $post_id, 'ibn_post_expiry_date_toggle', true );
		if ( $post_expiry_toggle ) {
			$post_expiry_date = get_post_meta( $post_id, 'ibn_post_expiry_date', true );
			//todo check if the date is not expired.
		}

		return apply_filters( 'ibn_can_display_bar', $status );
	}

	/**
	 * Modify the header of the theme to add breaking news bar
	 *
	 * @param $name string header name
	 * @param $args array header arguments
	 *
	 * @return void
	 */
	public function modify_header( $name = null, $args = array() ) {
		// Remove the current function from the action hook, so it doesn't run again.
		remove_action( 'get_header', [ $this, 'modify_header' ] );
		// Run the function get_header with the arguments specified from the theme.
		get_header( $name, $args );
		if ( $this->can_display_bar() ) {
			// Include the breaking news bar template.
			if ( file_exists( get_template_directory() . '/ibn-templates/ibn-public-display.php' ) ) {
				// Include the breaking news bar template from theme directory.
				include_once get_template_directory() . '/ibn-templates/ibn-public-display.php';
			} else {
				// Include the breaking news bar template from plugin directory.
				include_once IBN_PLUGIN_DIR . 'public/partials/ibn-public-display.php';
			}
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
	public function append_to_fse_themes( $block_content, $block ) {

		if ( ! $this->can_display_bar() ) {
			return $block_content;
		}

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
