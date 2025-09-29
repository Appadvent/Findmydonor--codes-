<?php
/**
 * Common function.
 */

class Wkdo_Common_Hook {
	public function __construct() {
		$object = new Wkdo_Common();
		add_action( 'init', array( $object, 'wkdo_add_donor_role' ) );
		add_filter( 'woocommerce_email_classes', array( $object, 'add_register_donor_email_class' ) );
		add_filter( 'woocommerce_email_actions', array( $object, 'wksa_auction_add_auction_notification_actions' ) );
		add_action( 'init', array( $object, 'add_customer_upload_capability' ), 999 );
		add_action( 'pre_get_posts', array( $object, 'restrict_customer_media_library' ) );

		add_action( 'wp_ajax_wkdo_ajax_action', array( $object, 'my_ajax_function' ) );
		add_action( 'wp_ajax_nopriv_wkdo_ajax_action', array( $object, 'my_ajax_function' ) );
		add_action( 'plugins_loaded', array( $object, 'my_custom_table_install' ) );

		add_action( 'wp_ajax_wdo_save_booking', array( $object, 'wdo_save_booking' ) );
		add_action( 'wp_ajax_nopriv_wdo_save_booking', array( $object, 'wdo_save_booking' ) );
		add_action( 'wp_footer', array( $object, 'wdo_booking_poup' ) );

		add_action( 'wp_ajax_wkd_send_message', array( $object, 'wkd_send_message_handler' ) );
		add_action( 'wp_ajax_nopriv_wkd_send_message', array( $object, 'wkd_send_message_handler' ) );
		add_filter( 'upload_mimes', array( $object, 'wkdo_custom_mime_types' ) );

		add_action( 'wp_ajax_wkd_fetch_messages', array( $object, 'wkd_fetch_messages_callback' ) );
		add_action( 'wp_ajax_nopriv_wkd_fetch_messages', array( $object, 'wkd_fetch_messages_callback' ) );

		


	}
}
