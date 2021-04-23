<?php
/**
 * Autoloader
 *
 * @package WordPressPluginBoilerplate
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloader
 *
 * @param   string $class The class to be loaded.
 *
 * @return  boolean
 */
function wpb_plugin_autoloader( $class ) {
	$type = 'class';

	$config = array(
		'root'          => 'inc',
		'namespace_map' => array(
			'MartinCV\Admin'  => '/admin',
			'MartinCV\API'    => '/api',
			'MartinCV\Traits' => '/traits',
			'MartinCV\Core'   => '/core',
			'MartinCV'        => '',
		),
	);

	$file_parts       = explode( '\\', $class );
	$count_file_parts = count( $file_parts );
	$class_name       = $file_parts[ $count_file_parts - 1 ];
	unset( $file_parts[ $count_file_parts - 1 ] );

	$namespace     = implode( '\\', $file_parts );
	$namespace_map = $config['namespace_map'];

	if ( ! isset( $namespace_map[ $namespace ] ) ) {
		return false;
	}

	$root_dir = '/' !== $config['root'] ? $config['root'] : '';
	$dir      = $root_dir . $namespace_map[ $namespace ];

	if ( strpos( $dir, '/trait' ) ) {
		$type = 'trait';
	}

	$class = '/' . $type . '-' . str_replace( '_', '-', strtolower( $class_name ) ) . '.php';

	$filename = WPB_PLUGIN_DIR . $dir . $class;

	if ( file_exists( $filename ) ) {
		require_once $filename;

		if ( class_exists( $class ) ) {
			return true;
		}
	}

	return false;
}

spl_autoload_register( 'wpb_plugin_autoloader' );
