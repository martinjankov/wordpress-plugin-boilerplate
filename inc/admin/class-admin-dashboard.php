<?php
namespace MartinCV\Admin;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin_Dashboard {
    use \MartinCV\Traits\Singleton;

    /**
     * Initialize class
     *
     * @return  void
     */
	private function _initialize() {
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_menu', [ $this, 'menu' ] );
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
            [ $this,'settings' ],
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

		include_once WPB_PLUGIN_DIR . 'views/admin/template-admin-dashboard.php';
	}

	/**
     * Register plugin settings
     *
     * @return  void
     */
	public function register_settings() {
		register_setting( 'wpb-settings-group', '_wpb_dashboard', [
            'sanitize_callback' => [ $this, 'sanitize_options' ]
        ] );
    }

    /**
     * Sanitize the fields before saving
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
        }

        return $option;
    }

}
