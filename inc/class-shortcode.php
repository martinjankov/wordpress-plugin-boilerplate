<?php
/**
 * Shortcode class
 *
 * @package WordPressPluginBoilerplate
 */

namespace MartinCV;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register shortcode class
 */
class Shortcode {
	use \MartinCV\Traits\Singleton;

	/**
	 * Initialize the class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_shortcode( 'wpb_shortcode', array( $this, 'create_shortcode' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ), 20 );
	}

	/**
	 * Load assets
	 *
	 * @return  void
	 */
	public function load_assets() {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		if ( has_shortcode( $post->post_content, 'wpb_shortcode' ) ) {
			// Change file path to coresponding css file.
			wp_enqueue_style(
				'wpb-shortcode-related-style',
				WPB_PLUGIN_URL . 'assets/public/css/style.css',
				array(),
				WPB_VERSION
			);

			// Change file path to coresponding js file.
			wp_enqueue_script(
				'wpb-shortcode-related-script',
				WPB_PLUGIN_URL . 'assets/public/js/script.js',
				array( 'jquery' ),
				WPB_VERSION,
				true
			);

			wp_localize_script(
				'wpb-shortcode-related-script',
				'wpb',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'wp_nonce' => wp_create_nonce( 'ajax-nonce' ),
				)
			);
		}
	}

	/**
	 * Create the shortcode
	 *
	 * @param   array $attr Shortcode attributes.
	 *
	 * @return  string
	 */
	public function create_shortcode( $attr ) {
		if ( ! current_user_can( 'administrator' ) ) {
			return __( 'You don\'t have permission to see this', 'wpb' );
		}

		$attr = shortcode_atts(
			array(
				'title' => esc_attr( 'This is wordpress boilerplate shortcode' ),
			),
			$attr
		);

		return $attr['title'];
	}
}
