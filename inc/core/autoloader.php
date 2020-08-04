<?php
/**
 * Autoloader
 *
 * @param   string  $class
 *
 * @return  boolean
 */
function wpb_plugin_autoloader( $class ) {
	$dir = '/inc';

	switch ( $class ) {
		case false !== strpos( $class, 'WPB\\Admin\\' ):
										$class = strtolower( str_replace( 'WPB\\Admin', '', $class ) );
										$dir .= '/admin';
										break;
		case false !== strpos( $class, 'WPB\\API\\' ):
										$class = strtolower( str_replace( 'WPB\\API', '', $class ) );
										$dir .= '/api';
										break;
		case false !== strpos( $class, 'WPB\\Traits\\' ):
                                        $class = strtolower( str_replace( 'WPB\\Traits', '', $class ) );
                                        $dir .= '/traits';
										break;
		case false !== strpos( $class, 'WPB\\Core\\' ):
                                        $class = strtolower( str_replace( 'WPB\\Core', '', $class ) );
                                        $dir .= '/core';
										break;
		case false !== strpos( $class, 'WPB\\' ):
                                        $class = strtolower( str_replace( 'WPB', '', $class ) );
										break;
		default: return;
	}

	$filename = dirname( __FILE__ ) . $dir . str_replace( '_', '-', str_replace( '\\', '/class-', $class ) ) . '.php';

	if ( file_exists( $filename ) ) {
		require_once $filename;

		if ( class_exists( $class ) ) {
			return true;
		}
	}

	return false;
}
spl_autoload_register( 'wpb_plugin_autoloader' );
