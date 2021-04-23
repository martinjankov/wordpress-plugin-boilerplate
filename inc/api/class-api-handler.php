<?php
/**
 * API Hanler example class
 *
 * @package WordPressPluginBoilerplate
 */

namespace MartinCV\API;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Api handler
 */
class API_Handler {
	use \MartinCV\Traits\Singleton, \MartinCV\Traits\Routes;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		$this->init_routes();
	}

	/**
	 * Load routes
	 *
	 * Format: endpoint@callback => http_method
	 */
	private function load_routes() {
		$this->namespace       = 'wpb/v1';
		$this->endpoint_prefix = 'prefix_or_leave_empty';

		return array(
			'endpoint@execute_endpoint' => 'post',
		);
	}

	/**
	 * Some endpoint data
	 *
	 * @param   \WP_REST_Request $request The request received from the API call.
	 */
	public function execute_endpoint( \WP_REST_Request $request ) {
		wp_send_json_success( 'Success' );
	}
}
