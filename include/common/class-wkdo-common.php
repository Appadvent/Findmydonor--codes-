<?php
/**
 * Common hooks.
 */

class Wkdo_Common {
	/**
	 * Add custom roll.
	 *
	 * @return void
	 */
	public function wkdo_add_donor_role() {
		add_role(
			'donor',
			__( 'Donor', 'wkdo' ),
			array(
				'read'         => true,
				'edit_posts'   => false,
				'delete_posts' => false,
			)
		);

		add_role(
			'recipient',
			__( 'Recipient User', 'wkdo' ),
			array(
				'read'         => true,
				'edit_posts'   => false,
				'delete_posts' => false,
			)
		);
	}

	/**
	 * Register temp.
	 *
	 * @var array $email_classes Email collection.
	 *
	 * @return array
	 */
	public function add_register_donor_email_class( $email_classes ) {

		$email_classes['WC_Email_Auction_Notification'] = include WKDO_DIR . 'custom-email-class.php';
		return $email_classes;
	}


	/**
	 * Add notification.
	 *
	 * @param array $actions actions.
	 *
	 * @return array
	 */
	public function wksa_auction_add_auction_notification_actions( $actions ) {
		$actions[] = 'register_donor_trigger';

		return $actions;
	}

	/**
	 * Set capability to user.
	 */
	public function add_customer_upload_capability() {
		$role = get_role( 'donor' );

		if ( $role ) {
				$role->add_cap( 'upload_files' );
				$role->add_cap( 'edit_posts' );
		}

		$role = get_role( 'recipient' );

		if ( $role ) {
				$role->add_cap( 'upload_files' );
				$role->add_cap( 'edit_posts' );
		}
	}

	/**
	 * Add restriction for image.
	 */
	public function restrict_customer_media_library( $query ) {
		if ( ! is_admin() || $query->get( 'post_type' ) !== 'attachment' ) {
			return;
		}
		$user = wp_get_current_user();
		if ( in_array( 'donor', (array) $user->roles ) ) {
			$query->set( 'author', $user->ID );
		}
	}

	/**
	 * Save data in database.
	 */
	public function my_ajax_function() {
		global $wpdb;
		$pid     = ! empty( $_POST['pid'] ) ? $_POST['pid'] : 0;
		$user_id = get_current_user_id();
		$table   = $wpdb->prefix . 'wdo_intrest_user';

		$insert = $wpdb->insert(
			$table,
			array(
				'rid'    => $user_id,
				'uid'    => $pid,
				'status' => 'pending',
			),
			array( '%d', '%d', '%s' )
		);

		if ( $insert ) {
			echo 'Thank you for your interest in this profile. Our team will connect with you as soon as possible.';
		}
		wp_die();
	}

	/**
	 * Save booking data.
	 */
	public function wdo_save_booking() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'wdo_booking';

		$email   = sanitize_email( $_POST['email'] );
		$phone   = sanitize_text_field( $_POST['phone'] );
		$date    = sanitize_text_field( $_POST['date'] );
		$message = sanitize_text_field( $_POST['message'] );

		$wpdb->insert(
			$table_name,
			array(
				'user_email'   => $email,
				'phone'        => $phone,
				'booking_date' => $date,
				'message'      => $message,
			)
		);

		wp_send_json_success( array( 'message' => 'Booking saved successfully.' ) );
	}

	/**
	 * Installation.
	 */
	public function my_custom_table_install() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'wdo_intrest_user';
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			rid VARCHAR(255) NOT NULL,
			uid VARCHAR(255) NOT NULL,
			status VARCHAR(255) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		/** Register user table  */
		$table_names = $wpdb->prefix . 'wdo_donor_user';
		$sql         = "CREATE TABLE IF NOT EXISTS $table_names (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_id VARCHAR( 255 ) NOT NULL,
			age VARCHAR( 255 ) NOT NULL,
			gender VARCHAR( 255 ) NOT NULL,
			current_location VARCHAR( 255 ) NOT NULL,
			race VARCHAR( 255 ) NOT NULL,
			ethnicity VARCHAR( 255 ) NOT NULL,
			donation_preferences VARCHAR( 255 ) NOT NULL,
			available_to_donate VARCHAR( 255 ) NOT NULL,
			where_donate VARCHAR( 255 ) NOT NULL,
			donation_method VARCHAR( 255 ) NOT NULL,
			donation_status VARCHAR( 255 ) NOT NULL,
			have_you_donated_before VARCHAR( 255 ) NOT NULL,
			blood_type VARCHAR( 255 ) NOT NULL,
			height VARCHAR( 255 ) NOT NULL,
			weight VARCHAR( 255 ) NOT NULL,
			hair_color VARCHAR( 255 ) NOT NULL,
			eye_color VARCHAR( 255 ) NOT NULL,
			religion VARCHAR( 255 ) NOT NULL,
			languages_spoken VARCHAR( 255 ) NOT NULL,
			education VARCHAR( 255 ) NOT NULL,
			occupation VARCHAR( 255 ) NOT NULL,

			status VARCHAR( 255 ) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		/** Register user table  */
		$table_namess = $wpdb->prefix . 'wdo_send_mail';
		$sqla         = "CREATE TABLE IF NOT EXISTS $table_namess (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			order_id VARCHAR( 255 ) NOT NULL,
			sender VARCHAR( 255 ) NOT NULL,
			reciver VARCHAR( 255 ) NOT NULL,
			user_type VARCHAR( 255 ) NOT NULL,
			user_message  LONGTEXT NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sqla );

		/**_________________ */

		$table_name      = $wpdb->prefix . 'wdo_booking';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_book        = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_email VARCHAR(255) NOT NULL,
			PHone VARCHAR(255) NOT NULL,
			booking_date VARCHAR(255) NOT NULL,
			message varchar(100) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_book );

		// chat table

		$table_name      = $wpdb->prefix . 'wdo_messages';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_book        = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			sender_id VARCHAR(255) NOT NULL,
			recipient_id VARCHAR(255) NOT NULL,
			donor_id VARCHAR(255) NOT NULL,
			group_id VARCHAR(255) NOT NULL,
			content VARCHAR(3000) NOT NULL,
			sent_at VARCHAR(255) NOT NULL,
			read_at VARCHAR(255) NOT NULL,

			message varchar(100) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_book );

		$table_name      = $wpdb->prefix . 'wdo_group_member';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_book        = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			group_id VARCHAR(255) NOT NULL,
			user_id VARCHAR(255) NOT NULL,
			join_at VARCHAR(255) NOT NULL,

			message varchar(100) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_book );

		$table_name      = $wpdb->prefix . 'wdo_group';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_book        = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			group_name VARCHAR(255) NOT NULL,
			inquery_id VARCHAR(255) NOT NULL,
			create_at VARCHAR(255) NOT NULL,

			message varchar(100) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_book );

		$table_name      = $wpdb->prefix . 'wdo_chat_status';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_book        = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			request_id VARCHAR(255) NOT NULL,
			recipient_status VARCHAR(255) NOT NULL,
			donor_staus VARCHAR(255) NOT NULL
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_book );
	}

	/**
	 * Save data in table
	 */
	public function wkd_send_message_handler() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'wdo_messages'; // Replace with actual table name

		$data = array(
			'sender_id'    => sanitize_text_field( $_POST['sender_id'] ),
			'recipient_id' => sanitize_text_field( $_POST['recipient_id'] ),
			'donor_id'     => sanitize_text_field( $_POST['donor_id'] ),
			'group_id'     => sanitize_text_field( $_POST['group_id'] ),
			'content'      => sanitize_textarea_field( $_POST['content'] ),
			'sent_at'      => sanitize_text_field( $_POST['sent_at'] ),
			'read_at'      => sanitize_text_field( $_POST['read_at'] ),
			'message'      => sanitize_text_field( $_POST['content'] ),
		);

		$inserted = $wpdb->insert( $table_name, $data );

		if ( $inserted ) {
			wp_send_json_success( 'Message sent successfully!' );
		} else {
			wp_send_json_error( 'Failed to send message.' );
		}
	}

	/**
	 * Booking popup.
	 */
	public function wdo_booking_poup() {
		?>
		<div id="wkdb-booking-modal" class="wkdb-modal-overlay">
			<div class="wkdb-modal">
				<div class="wkdb-modal-header">
					<h2 class="wkdb-modal-title">Booking Details</h2>
					<button id="wkdb-close-modal" class="wkdb-close-btn">&times;</button>
				</div>
				<div class="wkdb-modal-body">
					<form id="wkdb-booking-form" class="wkdb-booking-form">
						<?php if ( ! is_user_logged_in() ) { ?>
						<div class="wkdb-form-group">
							<label for="wkdb-email">Email</label>
							<input type="email" id="wkdb-email" class="wkdb-form-control" required>
						</div>
						<?php } else { ?>
						<div class="wkdb-form-group">
							<label for="wkdb-email">Email</label>
							<input type="email" id="wkdb-email" class="wkdb-form-control" value="<?php echo esc_attr( wp_get_current_user()->user_email ); ?>" readonly>
						</div>
						<?php } ?>
						<div class="wkdb-form-group">
							<label for="wkdb-mobile">Mobile</label>
							<input type="tel" id="wkdb-mobile" class="wkdb-form-control" required>
						</div>
						<div class="wkdb-form-group">
							<label for="wkdb-date">Date</label>
							<input type="date" id="wkdb-date" class="wkdb-form-control" required>
						</div>
						<div class="wkdb-form-group">
							<label for="wkdb-message">Message</label>
							<textarea id="wkdb-message" class="wkdb-form-control wkdb-textarea"></textarea>
						</div>
						<button type="submit" class="wkdb-submit-btn">Submit Booking</button>
					</form>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Custom mime types.
	 *
	 * @param array $mimes mimes.
	 *
	 * @return array
	 */
	public function wkdo_custom_mime_types( $mimes ) {
		$mimes['pdf']  = 'application/pdf';
		$mimes['doc']  = 'application/msword';
		$mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
		$mimes['mp4']  = 'video/mp4';
		$mimes['mov']  = 'video/quicktime';
		return $mimes;
	}

	public function wkd_fetch_messages_callback() {
		global $wpdb;

		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;

		if (!$group_id) {
			wp_send_json_error('Group ID missing');
		}

		$table = $wpdb->prefix . 'wdo_messages';

		$user_id = get_current_user_id();

		if ( current_user_can( 'donor' ) ) {
			$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id, sender_id, content, sent_at 
				FROM $table 
				WHERE group_id = %d 
				AND (donor_read IS NULL OR donor_read != 1) 
				AND sender_id != %d 
				ORDER BY sent_at ASC",
				$group_id,
				$user_id
			),
			ARRAY_A
		);
		} else{
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT id, sender_id, content, sent_at 
					FROM $table 
					WHERE group_id = %d 
					AND (recipient_read IS NULL OR recipient_read != 1) 
					AND sender_id != %d 
					ORDER BY sent_at ASC",
					$group_id,
					$user_id
				),
				ARRAY_A
			);
		}

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
		if ( current_user_can( 'donor' ) ) {
			$wpdb->query( $wpdb->prepare( "UPDATE $table SET donor_read = %d WHERE group_id = %d", 1, $group_id ) );
		} else{
			$wpdb->query( $wpdb->prepare( "UPDATE $table SET recipient_read = %d WHERE group_id = %d", 1, $group_id ) );
		}

		wp_send_json_success( $messages );
	}


	

}
