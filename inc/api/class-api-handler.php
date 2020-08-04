<?php
namespace MartinCV\API;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class API_Handler {
    use \MartinCV\Traits\Singleton_Routes;

    /**
	 * Load routes
	 *
	 * Format: endpoint@callback => http_method
	 *
	 * @return  void
	 */
	private function _load_routes() {
		$this->namespace       = 'wpb/v1';
		$this->endpoint_prefix = 'prefix_or_leave_empty';

		return [
			'endpoint@execute_endpoint'  => 'post',
        ];
    }

    /**
	 * Some endpoint data
	 *
	 * @param   \WP_REST_Request  $request
	 *
	 * @return  \JSON
	 */
    public function execute_endpoint( \WP_REST_Request $request ) {
        wp_send_json_success('Success');
    }
}
