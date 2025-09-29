<?php
/**
 * Wkdo send mail
 */

class Wkdo_Send_Mail {

	/**
	 * Comstruct function.
	 */
	public function __construct() {
		$this->wkdo_mail_send_temp();
	}

	/**
	 * Template.
	 */
	public function wkdo_mail_send_temp() {
		$get    = ! empty( $_GET ) ? wc_clean( $_GET ) : array();
		$action = ! empty( $get['action'] ) ? $get['action'] : '';
		$pid    = ! empty( $get['pid'] ) ? $get['pid'] : '';
		$row_id = ! empty( $get['row_id'] ) ? $get['row_id'] : '';
		$uid    = ! empty( $get['uid'] ) ? $get['uid'] : '';

		if ( 'mail_to_recipient' === $action && ! empty( $pid ) && ! empty( $row_id ) ) {
			$data = get_user_meta( $pid, 'wkdo_becom_donor', true );

			if ( ! empty( $data['email'] ) ) {
				$email = $data['email'];
			} else {
				$user_details = get_userdata( $to );
				$email        = ! empty( $user_details->user_email ) ? $user_details->user_email : '';
			}

			$this->save_and_send_mail( $row_id, $pid, $email, 'recipient' );
			$data = $this->get_all_conversation();

			echo "<div class='wkdo_recipent_converstion' id='wkdo_recipent_converstion' >";

			foreach ( $data  as $value ) {
				$sender_id    = ! empty( $value['sender'] ) ? $value['sender'] : 0;
				$user         = get_userdata( $sender_id );
				$user_message = ! empty( $value['user_message'] ) ? maybe_unserialize( $value['user_message'] ) : 0;
				echo "<div class='wkdo_user_meassges' >";

				if ( in_array( 'recipient', $user->roles ) ) {
					echo "<div class='wkm-recipient-mail-box' > ";
					echo " <div class='wkdo-send-by-recipent' > Recipient";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';
					echo '<div class=wkdo-send-by-re-mess > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';
				} else {
					echo "<div class='wkm-admin-mail-box' > ";
					echo " <div class='wkdo-send-by-admin' >Admin";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';

					echo '<div class=wkdo-send-by-re-admin > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';

				}

				echo '</div>';
				echo '<hr/>';
			}
			echo '</div>';
			$this->mail_layout( $row_id, $pid, 'recipient' );
		} elseif ( 'mail_to_donor' === $action && ! empty( $uid ) && ! empty( $row_id ) ) {

			$this->save_and_send_mail( $row_id, $uid, $data['email'], 'donor' );
			$data = $this->get_all_conversation( 'donor' );
			echo "<div class='wkdo_recipent_converstion' >";

			foreach ( $data  as $value ) {
				$sender_id  = ! empty( $value['sender'] ) ? $value['sender'] : 0;
				$reciver_id = ! empty( $value['sender'] ) ? $value['sender'] : 0;

				$user         = get_userdata( $sender_id );
				$user_message = ! empty( $value['user_message'] ) ? maybe_unserialize( $value['user_message'] ) : 0;
				echo "<div class='wkdo_user_meassges' >";

				if ( in_array( 'donor', $user->roles ) ) {
					echo "<div class='wkm-recipient-mail-box' > ";
					echo " <div class='wkdo-send-by-recipent' >Donor";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';
					echo '<div class=wkdo-send-by-re-mess > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';
				} else {
					echo "<div class='wkm-admin-mail-box' > ";
					echo " <div class='wkdo-send-by-admin' >Admin";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';

					echo '<div class=wkdo-send-by-re-admin > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';

				}

				echo '</div>';
				echo '<hr/>';
			}
			echo '</div>';

			$this->mail_layout( $row_id, $uid, 'donor' );
		}
	}

	/**
	 * Mail layout.
	 */
	public function mail_layout( $order_id, $to, $type ) {

		$data = get_user_meta( $to, 'wkdo_becom_donor', true );
		if ( empty( $data ) ) {
			$user_details = get_userdata( $to );
			$email        = ! empty( $user_details->user_email ) ? $user_details->user_email : '';

		} else {
			$email = ! empty( $data['email'] ) ? $data['email'] : '';
		}
		?>
		<form action="" method="post">
			<div class="wkm-mail-contair" >
				<div class="mail-to" >
					<input type="text" value="<?php echo $email; ?>" class="wkdo_mail_to" name="sent-to" id="" readonly>
				</div>

				<div class="mail-desc" >
					<?php
						$content   = '';
						$editor_id = 'wkdo_mail_editor_content';
						$settings  = array(
							'textarea_name' => 'wkdo_mail_editor_content',
							'media_buttons' => true,
							'editor_height' => 200,
							'tinymce'       => true,
							'quicktags'     => true,
						);
						wp_editor( $content, $editor_id, $settings );
						?>
				</div>
				<input type="submit" name="wkdo_send_mail" class="button button-primay" value="Send mail">
			</div>

		</form>
		<?php
	}

	/**
	 * Send mail to user.
	 */
	public function save_and_send_mail( $order_id, $to, $mail, $type ) {
		if ( isset( $_POST['wkdo_send_mail'] ) ) {
			global $wpdb;
			$table   = $wpdb->prefix . 'wdo_send_mail';
			$user_id = get_current_user_id();
			$wpdb->insert(
				$table,
				array(
					'order_id'     => $order_id,
					'sender'       => $user_id,
					'reciver'      => $to,
					'user_type'    => $type,
					'user_message' => maybe_serialize( array( 'messgae' => $_POST['wkdo_mail_editor_content'] ) ),
				)
			);

			$subject = 'Conversation mail';

			$user = get_userdata( $user_id );

			if ( in_array( 'donor', $user->roles ) ) {
				$url = site_url( 'my-account/interest_recipent/?action=send_mail&row_id=' . $order_id . '&rdid=' . $to ); // for  donor.
			} else {
				$url = site_url( 'my-account/interest_user/?action=send_mail&row_id=' . $order_id . '&rdid=' . $to ); // for  recipient.
			}

			$message = "<b>Hello There </b><br/> <br/>
				New message received on the conversation kindly check.<br /> <br/>
				<a href = '" . $url . "' style='display: inline-block; background-color: #0073aa; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-weight: bold;' > View Conversation
				</a>
			";

			$headers = array( 'Content-Type: text/html; charset=UTF-8' );

			if ( wp_mail( $to, $subject, $message, $headers ) ) {
				wp_admin_notice(
					__( 'Email sent successfully!' ),
					array(
						'type'        => 'success',
						'dismissible' => true,
						'id'          => 'message',
					)
				);
			} else {
				wp_admin_notice(
					__( 'Failed to send email.' ),
					array(
						'type'        => 'errors',
						'dismissible' => true,
						'id'          => 'message',
					)
				);

			}
		}
	}

	/**
	 * Get all conversation.
	 */
	public function get_all_conversation( $type = 'recipient' ) {
		global $wpdb;
		$table  = $wpdb->prefix . 'wdo_send_mail';
		$row_id = ! empty( $_GET['row_id'] ) ? $_GET['row_id'] : 0;
		$rid    = get_current_user_id();

		$data = $wpdb->get_results( "select * from  $table where ( sender = '$rid' OR reciver = '$rid' ) AND order_id = '$row_id' AND user_type ='$type' ", ARRAY_A );

		return ! empty( $data ) ? $data : array();
	}
}
