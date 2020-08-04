<?php
namespace WPB\Traits;

trait Singleton_Routes {
    /**
     * Class instance
     *
     * @var \Object
     */
	private static $_instance = null;

    /**
	 * Setup singleton instanc
	 *
	 * @return  \Object
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new static();
		}

		return self::$_instance;
	}

    /**
     * Private construct
     *
     * @return  void
     */
	private function __construct() {
        if ( method_exists( self::$_instance, '_load_routes' ) ) {
            add_action(
                'rest_api_init',
                function() {
                    $routes = self::$_instance->_load_routes();

                    self::$_instance->_setup_namespace_endpoint_prefix();

                    self::$_instance->_register_endpoints( $routes );
                }
            );
        }
	}

	/**
	 * RegisterEndpoints
	 *
	 * @return  void
	 */
	private function _register_endpoints( $routes ) {
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
				[
					'methods'  => $http_method,
					'callback' => [ $this, $method ],
                ]
			);
		}
	}

	/**
	 * Setup route namespace and if there is endpoint prefix
	 *
	 * @return  void
	 */
	private function _setup_namespace_endpoint_prefix() {
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
