<?php
/**
 * File handler.
 */

class Wkdo_File_Handler {
	public function __construct() {
		if ( is_admin() ) {
			new Wkdo_Admin_Hook();
		} else {
			new Wkdo_Front_Hook();
		}
		new Wkdo_Common_Hook();
	}
}
