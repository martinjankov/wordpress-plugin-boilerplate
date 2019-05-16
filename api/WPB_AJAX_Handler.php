<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPB_AJAX_Handler {
    public function __construct() {
        add_action( 'wp_ajax_wpb_load_users', array( $this, 'wpb_load_users') );
        add_action( 'wp_ajax_nopriv_wpb_load_users', array( $this, 'wpb_load_users') );
    }

    // Function called with AJAX.
    public function wpb_get_result() {
        if ( ! current_user_can( 'administrator' ) ) {
            wp_send_json_error(
                __( 'You don\'t have permission to see this', 'wpb' ),
                403
            );
        }

        $args = $_GET;

        if ( ! wp_verify_nonce( $args['wp_nonce'], 'ajax-nonce' ) ) {
            wp_send_json_error(
                __( 'Invalid nonce', 'wpb' ),
                403
            );
        }

        $result = array( 'status' => true );

        wp_send_json( $result );
    }
}
