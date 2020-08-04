<?php
namespace WPB;
/**
 * Plugin Name: Wordpress Plugin Boilerplate
 * Description: Starter boilerplate for creating wordpress plugins.
 * Author:      MartinCV
 * Author URI:  https://www.martincv.com
 * Version:     1.0.0
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
 * @author     MartinCV
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2020, MartinCV
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
    /**
     * Instance of the plugin
     *
     * @var WordpressPluginBoilerplate
     */
	private static $_instance;

    /**
     * Plugin version
     *
     * @var string
     */
	private $_version = '1.0.0';

	public static function instance() {
		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof WordpressPluginBoilerplate ) ) {
			self::$_instance = new WordpressPluginBoilerplate;
            self::$_instance->constants();
			self::$_instance->includes();

            add_action( 'plugins_loaded', [ self::$_instance, 'objects' ] );
            add_action( 'plugins_loaded', [ self::$_instance, 'load_textdomain' ] );
        }

		return self::$_instance;
	}

    /**
     * 3rd party includes
     *
     * @return  void
     */
	private function includes() {
		require_once WPB_PLUGIN_DIR . 'inc/core/autoloader.php';
	}

    /**
     * Define plugin constants
     *
     * @return  void
     */
	private function constants() {
		// Plugin version
		if ( ! defined( 'WPB_VERSION' ) ) {
			define( 'WPB_VERSION', $this->_version );
		}

		// Plugin Folder Path
		if ( ! defined( 'WPB_PLUGIN_DIR' ) ) {
			define( 'WPB_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'WPB_PLUGIN_URL' ) ) {
			define( 'WPB_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		// Plugin Root File
		if ( ! defined( 'WPB_PLUGIN_FILE' ) ) {
			define( 'WPB_PLUGIN_FILE', __FILE__ );
		}
	}

    /**
     * Initialize classes / objects here
     *
     * @return  void
     */
	public function objects() {
		// Global objects
        \MartinCV\Shortcode::get_instance();
        \MartinCV\API\AJAX_Handler::get_instance();

        \MartinCV\API\API_Handler::get_instance();

		// Init classes if is Admin/Dashboard
		if ( is_admin() ) {
			\MartinCV\Admin\Admin_Dashboard::get_instance();
		}
	}

    /**
     * Register textdomain
     *
     * @return  void
     */
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
