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
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
	}

	/**
	 * Load assets
	 *
	 * @param  string $location The location where the hook is executed.
	 *
	 * @return void
	 */
	public function load_assets( $location ) {
		if ( 'toplevel_page_wpb-settings' !== $location ) {
			return;
		}

		// Change file path to coresponding css file.
		wp_enqueue_style(
			'wpb-admin-related-style',
			WPB_PLUGIN_URL . 'assets/css/admin/style.css',
			array(),
			WPB_VERSION
		);

		// Change file path to coresponding js file.
		wp_enqueue_script(
			'wpb-admin-related-script',
			WPB_PLUGIN_URL . 'assets/js/admin/script.js',
			array( 'jquery' ),
			WPB_VERSION,
			true
		);
	}

	/**
	 * Register menu page
	 *
	 * @return  void
	 */
	public function menu() {
		add_menu_page(
			__( 'Boilerplate Plugin', 'wpb' ),
			__( 'Boilerplate Plugin Settings', 'wpb' ),
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
		$dashboard_settings = get_option( '_wpb_dashboard', array() );

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
				if ( empty( $value ) ) {
					unset( $option[ $field ] );
					continue;
				}

				if ( is_numeric( $value ) ) {
					$option[ $field ] = $value;
				} else {
					if ( is_array( $value ) ) {
						$option[ $field ] = $this->sanitize_options( $value );
					} else {
						$option[ $field ] = sanitize_text_field( $value );
					}
				}
			}

			return array_filter( $option );
		}

		return $option;
	}
}
