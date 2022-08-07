<?php

/**
 * Metabox-specific functions.
 *
 * @link       https://github.com/DevWael
 * @since      1.0.0
 *
 * @package    Ibn
 * @subpackage Ibn/admin
 */

/**
 * This class defines all functions related to the plugin meta boxes.
 *
 * @package    Ibn
 * @subpackage Ibn/admin
 * @author     Ahmad Wael <dev.ahmedwael@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Ibn_Metabox {

	/**
	 * Define the meta-box and option keys for gutenberg editor
	 * @return void
	 */
	public function gutenberg_metabox() {
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type( IBN_PLUGIN_DIR . 'admin/js/block-editor/build' );
		}

		// register option key that will hold the breaking news post id.
		register_setting(
			'ibn',
			'ibn_breaking_news_post_id',
			array(
				'default'      => '',
				'show_in_rest' => true,
				'type'         => 'number',
			)
		);

		// register meta key that will hold the custom title.
		register_post_meta(
			'post',
			'ibn_post_custom_title',
			array(
				'default'      => '',
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);

		// register meta key that will hold the expiry date toggle status
		register_post_meta(
			'post',
			'ibn_post_expiry_date_toggle',
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'boolean',
			)
		);

		// register meta key that will hold the actual expiry date.
		register_post_meta(
			'post',
			'ibn_post_expiry_date',
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
	}

	/**
	 * Adds the classic editor meta box.
	 */
	public function register_meta_boxes() {
		add_meta_box(
			'ibn_meta_boxss',
			'Meta Box',
			array( $this, 'render_meta_box' ),
			'post',
			'side',
			'default',
			array(
				'__back_compat_meta_box' => true,
			)
		);
	}

	/**
	 * Renders the meta box.
	 */
	public function render_meta_box( $post ) {
		require_once IBN_PLUGIN_DIR . 'admin/partials/ibn-admin-post-metabox.php';
	}

	/**
	 * Validate date against format 2022-08-08T22:06 Y-m-d\TH:i
	 */
	public function validate_date( $date, $format = 'Y-m-d\TH:i' ) {
		$d = DateTime::createFromFormat( $format, $date );

		// check if the date output from the formatted date is equal to the provided date.
		return $d && $d->format( $format ) == $date;
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int $post_id Post ID.
	 * @param WP_Post $post Post object.
	 *
	 * @return null
	 */
	public function save_post( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['ibn_nonce'] ) ? $_POST['ibn_nonce'] : '';
		$nonce_action = 'ibn_breaking_news_post';

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( isset( $_POST['ibn_breaking_news_post_id'] ) && is_numeric( $_POST['ibn_breaking_news_post_id'] ) ) {
			update_option( 'ibn_breaking_news_post_id', sanitize_text_field( $_POST['ibn_breaking_news_post_id'] ) );
		} elseif ( $post_id == get_option( 'ibn_breaking_news_post_id' ) ) {
			update_option( 'ibn_breaking_news_post_id', 0 );
		}

		if ( isset( $_POST['ibn_post_custom_title'] ) ) {
			update_post_meta( $post_id, 'ibn_post_custom_title', sanitize_text_field( $_POST['ibn_post_custom_title'] ) );
		}

		if ( isset( $_POST['ibn_post_expiry_date_toggle'] ) ) {
			update_post_meta( $post_id, 'ibn_post_expiry_date_toggle', 1 );
			if ( isset( $_POST['ibn_post_expiry_date'] ) && $this->validate_date( $_POST['ibn_post_expiry_date'] ) ) {
				update_post_meta( $post_id, 'ibn_post_expiry_date', sanitize_text_field( $_POST['ibn_post_expiry_date'] ) );
			} else {
				// delete the expiry date toggle value if it is not a valid date.
				delete_post_meta( $post_id, 'ibn_post_expiry_date_toggle' );
			}
		} else {
			delete_post_meta( $post_id, 'ibn_post_expiry_date_toggle' );
		}
	}
}
