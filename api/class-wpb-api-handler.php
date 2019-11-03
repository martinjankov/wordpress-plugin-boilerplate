<?php
namespace WPB\API;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPB_API_Handler {
    public function __construct() {

    }

    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        // Update route here and add additional verifications and permissions.
		register_rest_route( 'wpb/v1', '/wpb_route_path/', [
		    'methods' => 'GET',
		    'callback' => [ $this, 'get_result' ],
        ] );
    }

    public function get_result( WP_REST_Request $request ) {
        // do something here
    }
}
