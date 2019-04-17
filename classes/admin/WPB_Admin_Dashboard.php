<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPB_Admin_Dashboard {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'wpb_register_settings' ) );
		add_action( 'admin_menu', array( $this, 'wpb_menu' ) );
	}

	public function wpb_menu() {
		add_menu_page(
            'WP Simple Post Navigation',
            'WPB Settings',
            'administrator',
            'wpb-settings',
            array( $this,'wpb_settings' ),
            'dashicons-admin-generic'
        );
	}

	public function wpb_settings() {
		@include_once WPB_PLUGIN_DIR . 'views/admin/template-admin-dashboard.php';
	}

	public function wpb_register_settings() {
		register_setting( 'wpb-settings-group', 'wpb_activation' );
	}

}
