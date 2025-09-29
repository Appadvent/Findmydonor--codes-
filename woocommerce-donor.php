<?php
/*
 * Plugin Name:       Woocommerce Donor
 * Plugin URI:
 * Description:       Created this plug-in for donor profile and recipient profile features where admin and customer can manage their appropriate information.
 * Version:           3.2.2
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Author:            Mohammad Jasim
 * Author URI:        www.mojasim.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpdonor
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

defined( 'WKDO_DIR' ) || define( 'WKDO_DIR', plugin_dir_path( __FILE__ ) );
defined( 'WKDO_PLUGIN_URI' ) || define( 'WKDO_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
defined( 'WKDO_SCRIPT_VERSION' ) || define( 'WKDO_SCRIPT_VERSION', '1.0.0' );

require_once WKDO_DIR . 'autoloader/class-wkdo-autoloader.php';

new Wkdo_File_Handler();
// add_action( 'admin_bar_menu', 'wkdo_remove_menu_admin_bar', 999 );


// function wkdo_remove_menu_admin_bar( $wp_admin_bar ) {
// $wp_admin_bar->remove_node( 'my-account-xprofile' );
// $wp_admin_bar->remove_node( 'my-account-buddypress' );
// $wp_admin_bar->remove_node( 'my-account-xprofile-public' );
// $wp_admin_bar->remove_node( 'my-account-xprofile-change-avatar' );

// $wp_admin_bar->remove_node( 'my-account-xprofile-change-cover-image' );

// $wp_admin_bar->remove_node( 'my-account-settings' );
// $wp_admin_bar->remove_node( 'my-account-settings-general' );
// $wp_admin_bar->remove_node( 'my-account-settings-notificationsc' );

// $wp_admin_bar->remove_node( 'my-account-settings-profile' );

// $wp_admin_bar->remove_node( 'my-account-settings-export' );

// $wp_admin_bar->remove_node( 'user-info' );
// $wp_admin_bar->remove_node( 'my-account-settings-notificationsc' );
// }

/**
 *
 */
function wkdo_add_custom_menu_admin_bar( $wp_admin_bar ) {
	// Add a parent menu item
	$wp_admin_bar->add_node(
		array(
			'id'    => 'custom_tab',
			'title' => 'My Custom Tab',
			'href'  => admin_url( 'admin.php?page=my-custom-page' ),
			'meta'  => array(
				'class' => 'custom-tab-class',
			),
		)
	);

	$wp_admin_bar->add_node(
		array(
			'id'     => 'custom_tab_after_logout',
			'title'  => 'My Custom Tab After Logout',
			'href'   => admin_url( 'admin.php?page=my-custom-page' ),
			'parent' => 'top-secondary',
			'meta'   => array(
				'class' => 'custom-tab-class-after-logout',
			),
		)
	);
}

add_action( 'admin_bar_menu', 'wkdo_add_custom_menu_admin_bar', 1000 );

add_action( 'wp_head', 'misha_link_custom_icon', 999 );
function misha_link_custom_icon() {
	?><style>
	.woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link--donor-profile a:before{
		content: "\ee74";
	}
	</style>
	<?php
}


function register_custom_button_widget( $widgets_manager ) {

	require_once __DIR__ . '/widgets/custom-button-widget.php';

	$widgets_manager->register( new \Custom_Button_Widget() );
}
add_action( 'elementor/widgets/register', 'register_custom_button_widget' );


function check_user_membership() {
	$user_id = get_current_user_id();

	if ( $user_id ) {
		$mepr_subscriptions = MeprSubscription::get_all_active_by_user_id( $user_id );

		if ( ! empty( $mepr_subscriptions ) ) {
			return true;
		} else {
			return false;
		}
	}
}

function custom_my_account_menu_item_urls( $items ) {
	if ( isset( $items['member_ship_list'] ) ) {
		$items['member_ship_list'] = add_query_arg( 'action', 'subscriptions', wc_get_account_endpoint_url( 'member_ship_list' ) );
	}
	return $items;
}
add_filter( 'woocommerce_get_account_menu_item_urls', 'custom_my_account_menu_item_urls' );



add_filter( 'wp_get_nav_menu_items', 'hide_menu_items_by_user_role', 10, 2 );

function hide_menu_items_by_user_role( $items, $menu ) {

	if ( is_user_logged_in() ) {
		$user  = wp_get_current_user();
		$roles = $user->roles;
		foreach ( $items as $key => $item ) {

			if ( in_array( 'donor', $roles ) ) {
				if ( $item->title == 'Membership Plans' || 'Become a Donor' == $item->title || 'Premium Donor Search' == $item->title || 'Match Making' == $item->title
				) {
					unset( $items[ $key ] );
				}
			}

			if ( in_array( 'recipient', $roles ) ) {
				if ( $item->title == 'Become Recipient' ) {
					unset( $items[ $key ] );
				}
			}

			if ( $item->title == 'Sign Up' ) {
				unset( $items[ $key ] );
			}

			if ( $item->title == 'Sign In' ) {
				unset( $items[ $key ] );
			}
		}
	} else {
		foreach ( $items as $key => $item ) {
			if ( $item->title == 'Account' ) {
				unset( $items[ $key ] );
			}
		}
	}

	return $items;
}


// add_action('init', function() {

//     if (!current_user_can('manage_options') && !wp_doing_ajax()) {
//         wp_redirect(home_url('/my-account'));
//         exit;
//     }
// }, 9999 );

add_action('init', function() {
    if (is_admin() && is_user_logged_in() && !current_user_can('administrator') && !wp_doing_ajax() ) {
        $current_url = $_SERVER['REQUEST_URI'];

        // Allow profile.php access (optional)
        if (strpos($current_url, 'profile.php') === false) {
            wp_redirect(home_url('/my-account'));
            exit;
        }
    }
});



add_filter( 'woocommerce_get_endpoint_url', 'custom_account_menu_item_url', 10, 4 );
function custom_account_menu_item_url( $url, $endpoint, $value, $permalink ) {

    if ( $endpoint === 'member_ship_list' ) {
        return home_url( '/my-account/member_ship_list/?action=subscriptions' );
    }
    return $url;
}


add_action( 'wp_ajax_wkd_fetch_messages_admin',  'wkd_fetch_messages_callback_admin' );
		add_action( 'wp_ajax_nopriv_wkd_fetch_messages_admin','wkd_fetch_messages_callback_admin' );


	function wkd_fetch_messages_callback_admin() {
		global $wpdb;


		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;

		if (!$group_id) {
			wp_send_json_error('Group ID missing');
		}

		$table = $wpdb->prefix . 'wdo_messages';

		$user_id = get_current_user_id();

			$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id, sender_id, content, sent_at 
				FROM $table 
				WHERE group_id = %d 
				AND (admin_read IS NULL OR admin_read != 1) 
				AND sender_id != %d 
				ORDER BY sent_at ASC",
				$group_id,
				$user_id
			),
			ARRAY_A
		);

		foreach ($results as $row) {
			$messages[] = [
				'id'        => $row['id'],
				'sender_id' => $row['sender_id'],
				'content'   => esc_html($row['content']),
				'sent_at'   => $row['sent_at'],
				'sender_name' => get_the_author_meta('display_name', $row['sender_id']),
			];
		}

		$table = $wpdb->prefix . 'wdo_messages';
		
		$wpdb->query( $wpdb->prepare( "UPDATE $table SET admin_read = %d WHERE group_id = %d", 1, $group_id ) );
		
		wp_send_json_success( $messages );
	}