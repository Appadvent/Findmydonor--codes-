<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Donor list.
 */
class Wkdo_User_Booking extends WP_List_Table {
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
			'id'           => 'Recipient Profile',
			'user_email'   => 'Email',
			'PHone'        => 'Phone',
			'booking_date' => 'Booking Date',
			'message'      => 'Message',
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
			case 'id':
			case 'user_email':
			case 'PHone':
			case 'booking_date':
			case 'message':
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
		$data      = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wdo_booking ", ARRAY_A );
		$user_list = array();
		return ! empty( $data ) ? $data : array();
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
