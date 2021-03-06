<?php
/**
 * Admin dashboard
 *
 * @package WordPressPluginBoilerplate
 */

namespace MartinCV\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard class
 */
class Dashboard {
	use \MartinCV\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'menu' ) );
	}

	/**
	 * Register menu page
	 *
	 * @return  void
	 */
	public function menu() {
		add_menu_page(
			'Boilerplate Plugin',
			'Boilerplate Plugin Settings',
			'administrator',
			'wpb-settings',
			array( $this, 'settings' ),
			'dashicons-admin-generic'
		);
	}

	/**
	 * Show page settings
	 *
	 * @return  void
	 */
	public function settings() {
		$dashboard_settings = get_option( '_wpb_dashboard' );

		include_once WPB_PLUGIN_DIR . 'views/admin/template-dashboard.php';
	}

	/**
	 * Register plugin settings
	 *
	 * @return  void
	 */
	public function register_settings() {
		register_setting(
			'wpb-settings-group',
			'_wpb_dashboard',
			array(
				'sanitize_callback' => array( $this, 'sanitize_options' ),
			)
		);
	}

	/**
	 * Sanitize the fields before saving
	 *
	 * @param mixed<string|array> $option The option value to be sanitized.
	 *
	 * @return  array
	 */
	public function sanitize_options( $option ) {
		if ( is_array( $option ) ) {
			foreach ( $option as $field => $value ) {
				if ( is_numeric( $value ) ) {
					$option[ $field ] = absint( $value );
				} else {
					$option[ $field ] = sanitize_text_field( $value );
				}
			}
		} else {
			$option = sanitize_text_field( $option );
		}

		return $option;
	}
}
