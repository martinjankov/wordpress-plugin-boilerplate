<?php
namespace MartinCV\Traits;

trait Singleton {
    /**
	 * Instance of the object
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
	 * Private consturct
	 *
	 * @return  void
	 */
	private function __construct() {
		if ( method_exists( $this, '_initialize' ) ) {
			$this->_initialize();
		}
	}
}
