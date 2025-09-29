<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Donor list.
 */
class Wkdo_Donor_List extends WP_List_Table {
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
			'cb'         => '<input type="checkbox" />',
			'ID'         => 'Donor ID',
			'user_login' => 'First name',
			'user_last'  => 'Last name',
			'user_email' => 'Email',
			'status'     => 'Status',
			'profile'    => 'Profile',
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
			case 'user_login':
			case 'user_email':
			case 'status':
			case 'profile':
			case 'user_last':
			case 'ID':
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
	 * Column callback.
	 *
	 * @param array $item item.
	 *
	 * @return string.
	 */
	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" id="product_%s" name="rule[]" value="%s" />', $item['ID'], $item['ID'] );
	}

	/**
	 * Column callback.
	 *
	 * @param array $item item.
	 *
	 * @return string.
	 */
	public function column_ID( $item ) {
		return $item['ID'];
	}

	/**
	 * Table data.
	 *
	 * @return array
	 */
	private function wksa_table_data() {
		$args = array(
			'role'    => 'donor',
			'fields'  => array( 'ID', 'display_name', 'user_email' ),
			'orderby' => 'display_name',
			'order'   => 'DESC',
		);

		$user_query = new WP_User_Query( $args );
		$data       = $user_query->get_results();

		if ( ! empty( $data ) ) {
			$user_list = array();
			foreach ( $data as $value ) {
				$user_id          = $value->ID;
				$user_data        = get_userdata( $user_id );
				$user_status_html = '';

				$status   = get_user_meta( $user_id, 'wkdo_becom_donor_status', true );
				$all_data = get_user_meta( $user_id, 'wkdo_becom_donor', true );

			

				$name = !empty($all_data['wkdo_first_name']) ? $all_data['wkdo_first_name'] : get_user_meta( $user_id, 'first_name', true );
				$last_name = !empty($all_data['wkdo_last_name']) ? $all_data['wkdo_last_name'] : get_user_meta( $user_id, 'last_name', true );

				$profile  = ! empty( $all_data['wkdo_profile_image'] ) ? $all_data['wkdo_profile_image'] : '';
				$img_html = '';
				if ( ! empty( $profile ) ) {
					$img_html = '<img src=' . $profile . " class='wkdo-p-img' width='100' />";
				}

				if ( 'pending' === $status ) {
					$user_status_html = "<a href='" . admin_url( 'admin.php?page=all-donor&status=approved&did=' . $user_id ) . "'  class='button butn-green' /> Pending To Approved </a> ";
				} elseif ( 'approved' === $status ) {
					$user_status_html = "<a href='" . admin_url( 'admin.php?page=all-donor&status=pending&did=' . $user_id ) . "' class='button butn-orange'  /> Approved To Pending </a> ";
				} elseif ( 'rejected' === $status ) {
					$user_status_html = "<a href='" . admin_url( 'admin.php?page=all-donor&status=pending&did=' . $user_id ) . "' class='button butn-danger' />  Rejected To Pending </a> ";
				}

				$user_list[ $user_id ] = array(
					'ID'         => 'D100'.$value->ID,
					'status'     => $user_status_html,
					'user_login' => $name,
					'user_last'  => $last_name,
					'user_email' => $user_data->user_email,
					'profile'    => $img_html,
				);
			}

			return $user_list;
		}
		return array();
	}

	/**
	 * Column product id.
	 *
	 * @param array $item item.
	 *
	 * @return string.
	 */
	public function column_user_login( $item ) {
		$actions = array(
			'edit'   => sprintf( '<a href="admin.php?page=all-donor&action=edit_doonor&pid=%s&section=edit_donor">' . __( 'Edit', 'wkmp_seller_auction' ) . '</a>', $item['ID'] ),
			'manage' => sprintf( '<a href="admin.php?page=all-donor&action=view_donor&pid=%s&section=view_donor" >' . __( 'View', 'wkmp_seller_auction' ) . '</a>', $item['ID'] ),
		);

		return sprintf( '%1$s %2$s', $item['user_login'], $this->row_actions( $actions ) );
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
				<form method="post">
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
	 * Update the user status.
	 */
	public function wkdo_change_the_staus() {
		$get = ! empty( $_GET ) ? wc_clean( $_GET ) : array();
		if ( ! empty( $get['status'] ) && ! empty( $get['did'] ) && 'approved' === $get['status'] ) {
			$staus = update_user_meta( $get['did'], 'wkdo_becom_donor_status', 'approved' );
			if ( $staus ) {
				echo wp_admin_notice(
					esc_html__( 'User account status change from Pending to Approved', '' ),
					array(
						'type'        => 'success',
						'dismissible' => true,
						'id'          => 'message',
					)
				);
			}
		} elseif ( ! empty( $get['status'] ) && ! empty( $get['did'] ) && 'pending' === $get['status'] ) {
			$staus = update_user_meta( $get['did'], 'wkdo_becom_donor_status', 'pending' );
			echo wp_admin_notice(
				esc_html__( 'User account status change from Approved To Pending', '' ),
				array(
					'type'        => 'success',
					'dismissible' => true,
					'id'          => 'message',
				)
			);
		} elseif ( ! empty( $get['status'] ) && ! empty( $get['did'] ) && 'approved' === $get['status'] ) {
			echo wp_admin_notice(
				esc_html__( 'User account status change from Rejected To Pending', '' ),
				array(
					'type'        => 'success',
					'dismissible' => true,
					'id'          => 'message',
				)
			);
		}
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
