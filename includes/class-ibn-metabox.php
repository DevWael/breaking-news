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
class Ibn_Metabox {

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

	public function gutenberg_metabox() {
		register_block_type( IBN_PLUGIN_DIR . 'admin/js/block-editor/build' );

		register_setting(
			'ibn',
			'ibn_breaking_news_post_id',
			[
				'default'      => '',
				'show_in_rest' => true,
				'type'         => 'number',
			]
		);

		register_meta(
			'post',
			'ibn_post_custom_title',
			[
				'default'      => '',
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			]
		);

		register_post_meta( 'post', 'ibn_post_expiry_date_toggle', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'boolean',
		] );

		register_post_meta( 'post', 'ibn_post_expiry_date', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string'
		] );
	}
}
