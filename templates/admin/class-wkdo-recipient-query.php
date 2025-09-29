<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Donor list.
 */
class Wkdo_Recipient_Query extends WP_List_Table {
	/**
	 * The single instance of the class.
	 *
	 * @var $instance
	 * @since 1.0.0
	 */
	protected static $instance = null;

	/**
	 * Constructor function.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => esc_html__( 'Auction Product List', 'wkmp_seller_auction' ),
				'plural'   => esc_html__( 'Auction Products List', 'wkmp_seller_auction' ),
				'ajax'     => false,
			)
		);
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function prepare_items() {
		$this->enbale_chat();
		$this->wkdo_change_the_staus();
		$columns  = $this->get_columns();
		$sortable = $this->wksa_get_sortable_columns();
		$hidden   = $this->wksa_get_hidden_columns();
		$this->process_bulk_action();
		$data                  = $this->wksa_table_data();
		$total_items           = count( $data );
		$per_page              = 20;
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$current_page          = $this->get_pagenum();
		$data                  = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$this->items = $data;
	}

	/**
	 * Bulk actions on list.
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'trash' => esc_html__( 'Move To Trash', 'wkmp_seller_auction' ),
		);

		return $actions;
	}

	/**
	 * Extra table navigation.
	 *
	 * @param string $which location.
	 *
	 * @return void
	 */
	public function extra_tablenav( $which ) {
		if ( 'top' === $which ) {
			// esc_html_e( 'List of auction products with all details.', 'wkmp_seller_auction' );
		}
	}

	/**
	 * Define the columns that are going to be used in the table.
	 *
	 * @return array $columns, the array of columns to use with the table.
	 */
	public function get_columns() {
		return array(
			'rid'        => 'Recipient Profile',
			'uid'        => 'Donor Profile',
			'mail_rec'   => 'Mail To Racepient',
			'mail_donor' => 'Mail To Donor',
			'donor_chat' => 'Chat',
			'chat_user'  => 'Chat With User',
		);
	}


	/**
	 * Column default.
	 *
	 * @param array  $item        item.
	 * @param string $column_name column name.
	 *
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'rid':
			case 'uid':
			case 'mail_rec':
			case 'mail_donor':
			case 'donor_chat':
			case 'chat_user':
				return $item[ $column_name ];
			default:
				return $item;
		}
	}

	/**
	 * Decide which columns to activate the sorting functionality on.
	 *
	 * @return array $sortable, the array of columns that can be sorted by the user.
	 */
	public function wksa_get_sortable_columns() {
		$sortable = array();

		return $sortable;
	}


		/**
		 * Hidden columns.
		 *
		 * @return array.
		 */
	public function wksa_get_hidden_columns() {
		return array();
	}


	/**
	 * Table data.
	 *
	 * @return array
	 */
	private function wksa_table_data() {
		global $wpdb;
		$data      = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wdo_intrest_user order by id desc ", ARRAY_A );
		$user_list = array();

		foreach ( $data as $list ) {
			$rid       = $list['rid'];
			$uid       = $list['uid'];
			$user_data = get_userdata( $rid );

			$u_data = get_userdata( $uid );

			$rp_html = '<a href="' . esc_url( admin_url( 'admin.php?page=all-recipient&action=view_recipient&pid=' . $rid . '&section=view_recipient' ) ) . '">'
			. esc_html( $user_data->user_login ) . '</a>';

			$upi_html = '<a href="' . esc_url( admin_url( 'admin.php?page=all-donor&action=view_donor&pid=' . $uid . '&section=view_recipient' ) ) . '">'
			. esc_html( $u_data->user_login ) . '</a>';

			$mail_rec = '<a href="' . esc_url( admin_url( 'admin.php?page=all-recipient&action=mail_to_recipient&pid=' . $rid . '&row_id=' . $list['id'] ) ) . '"> Send recipent </a>';

			$mail_donor = '<a href="' . esc_url( admin_url( 'admin.php?page=all-recipient&action=mail_to_donor&uid=' . $uid . '&row_id=' . $list['id'] ) ) . '"> Send Donor </a>';

			if ( ! $this->check_chat_status( $list['id'] ) ) {
				$donor_chat = '<a href="' . esc_url( admin_url( 'admin.php?page=recipient-query&action=enable_chat&row_id=' . $list['id'] ) ) . '"> Enable </a>';
			} else {
				$donor_chat = '<a href="' . esc_url( admin_url( 'admin.php?page=recipient-query&action=disable_chat&row_id=' . $list['id'] ) ) . '"> Disable </a>';
			}

			$chat_user = '<a href="' . esc_url( admin_url( 'admin.php?page=recipient-query&action=chat_with_user&group_id=' . $list['id'] ) ) . '"> Chat </a>';

			$user_list[] = array(
				'rid'        => $rp_html,
				'uid'        => $upi_html,
				'mail_rec'   => $mail_rec,
				'mail_donor' => $mail_donor,
				'donor_chat' => $donor_chat,
				'chat_user'  => $chat_user,
			);
		}

		return ! empty( $user_list ) ? $user_list : array();
	}

	/**
	 * Enable disable chat
	 */
	public function enbale_chat() {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_chat_status';

		if ( ! empty( $_GET['action'] ) && ( 'enable_chat' === $_GET['action'] || 'disable_chat' === $_GET['action'] ) ) {

			$rid  = ! empty( $_GET['row_id'] ) ? $_GET['row_id'] : 0;
			$data = $wpdb->get_row( "Select * from $table where request_id = '$rid' ", ARRAY_A );
			if ( ! empty( $data ) ) {

				$status = 'enable';

				if ( 'disable_chat' == $_GET['action'] ) {
					$status = 'disable';
				} elseif ( 'enable_chat' === $_GET['action'] ) {

				}

				$status = $wpdb->update( $table, array( 'donor_staus' => $status ), array( 'request_id' => $rid ) );
				if ( $status ) {
					echo 'status change succesfully';
				}
			} else {
				$status = $wpdb->insert(
					$table,
					array(
						'request_id'  => $rid,
						'donor_staus' => 'enable',
					)
				);
				if ( $status ) {
					echo 'status change succesfully';
				}

				// First create group.
				$group_table  = $wpdb->prefix . 'wdo_group';
				$current_date = current_time( 'Y-m-d' );
				$group_stauts = $wpdb->insert(
					$group_table,
					array(
						'group_name' => $rid,
						'inquery_id' => $rid,
						'create_at'  => $current_date,
					)
				);

				if ( $group_stauts ) {
					$group_mem = $wpdb->prefix . 'wdo_group_member';
					$group_id  = $wpdb->insert_id;
					$list      = $this->intres_profile_user( $rid );
					$res_id    = ! empty( $list['rid'] ) ? $list['rid'] : 0;
					$donor_id  = ! empty( $list['uid'] ) ? $list['uid'] : 0;
					$wpdb->insert(
						$group_mem,
						array(
							'group_id' => $group_id,
							'user_id'  => $res_id,
							'join_at'  => $current_date,
						)
					);
					$wpdb->insert(
						$group_mem,
						array(
							'group_id' => $group_id,
							'user_id'  => $donor_id,
							'join_at'  => $current_date,
						)
					);
				}
			}
		}
	}

	/**
	 * Intrest user.
	 */
	public function intres_profile_user( $rid ) {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_intrest_user';
		$data  = $wpdb->get_row( "select * from $table where id = '$rid'", ARRAY_A );
		return ! empty( $data ) ? $data : array();
	}

	/**
	 * Chat system
	 */
	public function check_chat_status( $rid ) {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_chat_status';
		$data  = $wpdb->get_row( "Select * from $table where request_id = '$rid' ", ARRAY_A );

		if ( ! empty( $data ) ) {
			if ( ! empty( $data['donor_staus'] ) ) {
				if ( 'enable' === $data['donor_staus'] ) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}




	/**
	 * Prepare wp_list table.
	 *
	 * @return void
	 */
	public function wksa_prepare() {
		$this->prepare_items();
		$request      = ! empty( $_GET ) ? wc_clean( $_GET ) : array();
		$request_page = ! empty( $request['page'] ) ? $request['page'] : '';
		?>
		<form method="POST">
			<input type="hidden" name="page" value="<?php echo esc_attr( $request_page ); ?>" />
		<?php
			// $this->search_box( esc_html__( 'Search products', 'wkmp_seller_auction' ), 'search-id' );
			$this->display();
			wp_nonce_field( 'add_auction_nonce', 'auction_nonce' );
		?>
		</form>
		<?php
	}

	/**
	 * This is a singleton page, access the single instance just using this method.
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
