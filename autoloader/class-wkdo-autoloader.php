<?php
/**
 * Autoloader file.
 */

defined( 'ABSPATH' ) || exit;

class Wkdo_Autoloader {
	public static function register() {
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	public static function autoload( $class ) {
		// Only load classes starting with 'WKDO_'
		if ( strpos( $class, 'Wkdo' ) !== 0 ) {
			return;
		}

		// Convert class name to file name
		$filename = strtolower( str_replace( '_', '-', $class ) ) . '.php';

		// Define the directories to search
		$paths = array(
			WKDO_DIR . 'include/',
			WKDO_DIR . 'include/admin/',
			WKDO_DIR . 'include/front/',
			WKDO_DIR . 'include/common/',
			WKDO_DIR . 'templates/',
			WKDO_DIR . 'templates/admin/',
			WKDO_DIR . 'templates/front/',
		);

		foreach ( $paths as $path ) {
			$file = $path . 'class-' . $filename;
			if ( file_exists( $file ) ) {
				include_once $file;
				return;
			}
		}
	}
}

// Register the autoloader
Wkdo_Autoloader::register();
