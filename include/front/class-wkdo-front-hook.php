<?php
/**
 * Front hooks.
 */

class Wkdo_Front_Hook {
	/**
	 * Construct function. 
	 */
	public function __construct() {
		$object = new Wkdo_Front();
		add_shortcode( 'wkdo_donor_form', array( $object, 'wkdo_donor_form_shortcode' ) );
		add_shortcode( 'wkdo_donor_match', array( $object, 'wkdo_donor_match_form' ) );
		add_action( 'wp_enqueue_scripts', array( $object, 'front_scripts_method' ) );
		add_action( 'bp_setup_nav', array( $object, 'custom_add_profile_tab' ), 100 );
		add_action( 'init', array( $object, 'wkdo_register_user' ), 9999 );
		add_shortcode( 'wkdo_donor_test', array( $object, 'custom_tab_content_display' ) );
		add_action( 'bp_setup_nav', array( $object, 'custom_remove_profile_tabs' ), 15 );
		add_shortcode( 'wkdo_user_list', array( $object, 'wkdo_donor_user_list' ) );
		add_action( 'init', array( $object, 'wkdo_add_donor_profile_endpoint' ) );

		add_filter( 'woocommerce_account_menu_items', array( $object, 'wkdo_add_donor_profile_menu_item' ) );
		add_action( 'woocommerce_account_donor-profile_endpoint', array( $object, 'custom_tab_content_display' ) );
		add_action( 'woocommerce_account_recipient-profile_endpoint', array( $object, 'custom_tab_recipient_display' ) );
		add_action( 'init', array( $object, 'wkdo_flush_rewrite_rules' ), 999 );
		add_filter( 'woocommerce_account_menu_items', array( $object, 'custom_remove_my_account_menu_items' ) );
		add_action( 'wp_logout', array( $object, 'custom_logout_redirect' ) );
		add_filter( 'woocommerce_login_redirect', array( $object, 'custom_login_redirect' ), 10, 2 );
		add_action( 'woocommerce_account_interest_user_endpoint', array( $object, 'wkdo_select_donor_by_recipient' ) );
		add_action( 'woocommerce_account_interest_recipent_endpoint', array( $object, 'wkdo_select_donor_by_recipient' ) );
		add_action( 'woocommerce_account_member_ship_list_endpoint', array( $object, 'wkdo_member_ship_list_recipient' ) );
		add_action( 'woocommerce_account_customer_chat_endpoint', array( $object, 'wkdo_member_customer_chat' ) );
		add_shortcode( 'wkdo_member_thank_you', array( $object, 'wkdo_member_thank_you' ) );
	}
}
