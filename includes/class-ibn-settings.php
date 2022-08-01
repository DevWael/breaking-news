<?php

/**
 * The plugin settings array setter and getter static class.
 *
 * @link       https://github.com/DevWael
 * @since      1.0.0
 *
 * @package    Ibn
 * @subpackage Ibn/includes
 */

/**
 * The plugin settings controller.
 *
 *
 * @package    Ibn
 * @subpackage Ibn/includes
 * @author     Ahmad Wael <dev.ahmedwael@gmail.com>
 */
class Ibn_Settings {

	/**
	 * Get the plugin general settings.
	 *
	 * @return array|bool the settings array or false if not found.
	 */
	public static function get_general_settings() {
		/**
		 * filter to apply modifications on the returned settings array.
		 *
		 * @return array|bool the settings array or false if not found.
		 */
		return apply_filters( 'ibn_general_settings', get_option( 'ibn_general_settings' ) );
	}

	/**
	 * Get specified plugin setting by key.
	 *
	 * @param string $key the setting key.
	 * @return array|null the settings array or null if not found.
	 */
	public static function get_general_settings_by_key( $key ) {
		$settings = self::get_general_settings();
		return isset( $settings[ $key ] ) ? $settings[ $key ] : null;
	}

	/**
	 * Save the plugin general settings.
	 * @param $settings array the settings array.
	 *
	 * @return void
	 */
	public static function set_general_settings( $settings ) {
		update_option( 'ibn_general_settings', $settings );
	}
}
