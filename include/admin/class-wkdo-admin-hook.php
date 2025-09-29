<?php
/**
 * Admin hooks.
 */

class Wkdo_Admin_Hook {
	/**
	 * COnstruct function.
	 */
	public function __construct() {
		$object = new Wkdo_Admin();
		add_action( 'admin_menu', array( $object, 'wkdo_custom_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $object, 'wkdo_enqueue_admin_styles' ) );
		add_action( 'admin_head', array( $object, 'wkdo_custom_admin_css' ) );
	}
}
