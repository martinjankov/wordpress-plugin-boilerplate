<?php
/**
 * Routes trait
 *
 * @package WordPressPluginBoilerplate
 */

namespace MartinCV\Traits;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Routes {
	/**
	 * Init routes
	 *
	 * @return  void
	 */
	private function init_routes() {
		if ( method_exists( $this, 'load_routes' ) ) {
			add_action(
				'rest_api_init',
				function() {
					$routes = $this->load_routes();

					$this->setup_namespace_endpoint_prefix();

					$this->register_endpoints( $routes );
				}
			);
		}
	}

	/**
	 * RegisterEndpoints
	 *
	 * @param array $routes The routs to be registered.
	 *
	 * @return  void
	 */
	private function register_endpoints( $routes ) {
		if ( ! is_array( $routes ) ) {
			return;
		}

		foreach ( $routes as $action => $http_method ) {
			$action_params = explode( '@', $action );
			$endpoint      = $action_params[0];
			$method        = $action_params[1];

			register_rest_route(
				$this->namespace,
				'/' . $this->endpoint_prefix . $endpoint,
				array(
					'methods'  => $http_method,
					'callback' => array( $this, $method ),
				)
			);
		}
	}

	/**
	 * Setup route namespace and if there is endpoint prefix
	 *
	 * @return  void
	 */
	private function setup_namespace_endpoint_prefix() {
		if ( ! isset( $this->namespace ) ) {
			$this->namespace = 'routes/v1';
		}

		if ( ! isset( $this->endpoint_prefix ) ) {
			$this->endpoint_prefix = '';
		} else {
			$this->endpoint_prefix = trailingslashit( $this->endpoint_prefix );
		}
	}
}
