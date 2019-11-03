<?php
namespace WPB;
/**
 * Plugin Name: Wordpress Plugin Boilerplate
 * Description: Starter boilerplate for creating wordpress plugins.
 * Author:      Martin Jankov
 * Author URI:  https://www.martincv.com
 * Version:     0.0.1
 * Text Domain: wpb
 * Domain Path: /languages
 *
 * Wordpress Plugin Boilerplate is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Wordpress Plugin Boilerplate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wordpress Plugin Boilerplate. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    WordpressPluginBoilerplate
 * @author     Martin Jankov
 * @since      0.0.1
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2019, Martin Jankov
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NOTICE!!!
 * It is strongly suggeted that you rename the global constants (WPB_PLUGING_DIR,WPB_VERSION,WPB_PLUGIN_URL,WPB_PLUGIN_FILE),
 * the script/style hook names (wpb-style, wpb-script, wpb-admin-style, wpb-admin-script),
 * as well as the class name (WordpressPluginBoilerplate).
 * This is only for demonstration purposes and it may confict with other plugin's constants and hook names if not changed to unique.
 *
 * You can add/remove any functions/files you need or don't.
 */

final class WordpressPluginBoilerplate {

	private static $_instance;

	private $_version = '0.0.1';

	public $api_handler;

	public static function instance() {
		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof WordpressPluginBoilerplate ) ) {
			self::$_instance = new WordpressPluginBoilerplate;
            self::$_instance->constants();
			self::$_instance->includes();

            add_action( 'plugins_loaded', [ self::$_instance, 'objects' ] );
            add_action( 'plugins_loaded', [ self::$_instance, 'load_textdomain' ] );
			add_action( 'admin_enqueue_scripts', [ self::$_instance, 'load_global_admin_assets' ] );
			add_action( 'wp_enqueue_scripts', [ self::$_instance, 'load_global_frontend_assets' ] );
        }

		return self::$_instance;
	}

	private function includes() {
		//Libraries
		require_once WPB_PLUGIN_DIR . 'libraries/library.php';

		// Global includes
		require_once WPB_PLUGIN_DIR . 'includes/functions.php';

		// Classes
        require_once WPB_PLUGIN_DIR . 'classes/class-wpb-shortcode.php';

        //API
        require_once WPB_PLUGIN_DIR . 'api/class-wpb-api-handler.php';
        require_once WPB_PLUGIN_DIR . 'api/class-wpb-ajax-handler.php';

		// Admin/Dashboard only includes
		if ( is_admin() ) {
			require_once WPB_PLUGIN_DIR . 'classes/admin/class-wpb-admin-dashboard.php';
		}
	}

	private function constants() {
		// Plugin version
		if ( ! defined( 'WPB_VERSION' ) ) {
			define( 'WPB_VERSION', $this->_version );
		}

		// Plugin Folder Path
		if ( ! defined( 'WPB_PLUGIN_DIR' ) ) {
			define( 'WPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'WPB_PLUGIN_URL' ) ) {
			define( 'WPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'WPB_PLUGIN_FILE' ) ) {
			define( 'WPB_PLUGIN_FILE', __FILE__ );
		}
	}

	public function objects() {
		// Global objects
        new \WPB\Classes\WPB_Shortcode;
        new \WPB\API\WPB_AJAX_Handler;

        (new \WPB\API\WPB_API_Handler)->init();

		// Init classes if is Admin/Dashboard
		if ( is_admin() ) {
			new \WPB\Admin\WPB_Admin_Dashboard;
		}
	}

	public function load_global_admin_assets( $hook ) {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		wp_enqueue_style(
			'wpb-admin-style',
			WPB_PLUGIN_URL . 'assets/admin/css/style.css',
			[],
			WPB_VERSION
		);

		wp_enqueue_script(
			'wpb-admin-script',
			WPB_PLUGIN_URL . 'assets/admin/js/script.js',
			['jquery'],
			WPB_VERSION,
			true
		);
	}

	public function load_global_frontend_assets( $hook ){
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		wp_enqueue_style(
			'wpb-style',
			WPB_PLUGIN_URL . 'assets/public/css/style.css',
			[],
			WPB_VERSION
		);

		wp_enqueue_script(
			'wpb-script',
			WPB_PLUGIN_URL . 'assets/public/js/script.js',
			['jquery'],
			WPB_VERSION,
			true
		);
    }

    public function load_textdomain() {
		load_plugin_textdomain( 'wpb', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
}

/**
 * Use this function as global in all other classes and/or files.
 *
 * You can do wpb()->object1->some_function()
 * You can do wpb()->object2->some_function()
 *
 */
function wpb() {
	return WordpressPluginBoilerplate::instance();
}
wpb();
