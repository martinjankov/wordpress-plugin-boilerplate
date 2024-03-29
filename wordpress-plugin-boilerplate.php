<?php
/**
 * Plugin Name: WordPress Plugin Boilerplate
 * Description: Starter boilerplate for creating WordPress Plugins.
 * Author:      MartinCV
 * Author URI:  https://www.martincv.com
 * Version:     1.0.5
 * Text Domain: wpb
 * Domain Path: /languages
 *
 * WordPress Plugin Boilerplate is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * WordPress Plugin Boilerplate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress Plugin Boilerplate. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    WordPressPluginBoilerplate
 * @author     MartinCV
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2023, MartinCV
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NOTICE!!!
 * It is strongly suggeted that you rename the global constants (WPB_PLUGING_DIR,WPB_VERSION,WPB_PLUGIN_URL,WPB_PLUGIN_FILE),
 * the script/style hook names (wpb-style, wpb-script, wpb-admin-style, wpb-admin-script),
 * as well as the class name (WordPressPluginBoilerplate).
 * This is only for demonstration purposes and it may confict with other plugin's constants and hook names if not changed to unique.
 *
 * You can add/remove any functions/files you need or don't.
 */

/**
 * WordPress Main Plugin Class
 */
final class WordPressPluginBoilerplate {
	/**
	 * Instance of the plugin
	 *
	 * @var WordPressPluginBoilerplate
	 */
	private static $instance;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version = '1.0.5';

	/**
	 * Instanciate the plugin
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WordPressPluginBoilerplate ) ) {
			self::$instance = new WordPressPluginBoilerplate();
			self::$instance->constants();
			self::$instance->includes();

			add_action( 'plugins_loaded', array( self::$instance, 'run' ) );
		}

		return self::$instance;
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
		// Plugin version.
		if ( ! defined( 'WPB_VERSION' ) ) {
			define( 'WPB_VERSION', $this->version );
		}

		// Plugin Folder Path.
		if ( ! defined( 'WPB_PLUGIN_DIR' ) ) {
			define( 'WPB_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'WPB_PLUGIN_URL' ) ) {
			define( 'WPB_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		// Plugin Root File.
		if ( ! defined( 'WPB_PLUGIN_FILE' ) ) {
			define( 'WPB_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Initialize classes / objects here
	 *
	 * @return  void
	 */
	public function run() {
		$this->load_textdomain();

		// Global objects.
		\MartinCV\Shortcode::get_instance();
		\MartinCV\AJAX\AJAX_Handler::get_instance();

		\MartinCV\API\API_Handler::get_instance();

		// Init classes if is Admin/Dashboard.
		if ( is_admin() ) {
			\MartinCV\Admin\Dashboard::get_instance();
		}
	}

	/**
	 * Register textdomain
	 *
	 * @return  void
	 */
	private function load_textdomain() {
		load_plugin_textdomain( 'wpb', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
}

WordPressPluginBoilerplate::get_instance();
