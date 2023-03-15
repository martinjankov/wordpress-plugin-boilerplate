<?php
/**
 * JJAX Handler example
 *
 * @package WordPressPluginBoilerplate
 */

namespace MartinCV\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajax handler class
 */
class AJAX_Handler {
	use \MartinCV\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	public function initialize() {
		add_action( 'wp_ajax_wpb_get_result', array( $this, 'wpb_get_result' ) );
		add_action( 'wp_ajax_nopriv_wpb_get_result', array( $this, 'wpb_get_result' ) );
	}

	/**
	 * Execute some AJAX code here
	 */
	public function wpb_get_result() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error(
				__( 'You don\'t have permission to see this', 'wpb' ),
				403
			);
		}

		$nonce_check = check_ajax_referer( 'ajax-nonce', 'wp_nonce', false );

		if ( ! $nonce_check ) {
			wp_send_json_error(
				__( 'Invalid nonce', 'wpb' ),
				403
			);
		} elseif ( $nonce_check > 1 ) {
			wp_send_json_error(
				__( 'The form expired. Please refresh the page and try agian.', 'wpb' ),
				403
			);
		}

		$result = array( 'status' => true );

		wp_send_json_success( $result );
	}
}
