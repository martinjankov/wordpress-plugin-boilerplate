<?php
namespace WPB\API;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AJAX_Handler {
    use \WPB\Traits\Singleton;

    /**
     * Initialize class
     *
     * @return  void
     */
    public function _initialize() {
        add_action( 'wp_ajax_wpb_get_result', [ $this, 'wpb_get_result' ] );
        add_action( 'wp_ajax_nopriv_wpb_get_result', [ $this, 'wpb_get_result' ] );
    }

    /**
     * Execute some AJAX code here
     *
     * @return  \JSON
     */
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

        $result = [ 'status' => true ];

        wp_send_json_success( $result );
    }
}
