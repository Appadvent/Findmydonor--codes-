<?php
/**
 * Auction notifications.
 *
 * @package Marketplace Seller Auctions
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Register_Donor_Email' ) ) {

	/**
	 * Email Auction Notification.
	 */
	class Register_Donor_Email extends WC_Email {
		/**
		 * Email method ID.
		 *
		 * @var String
		 */
		public $footer;

		public $user_id;
		public $recipient;

		public $heading;




		/**
		 * Constructor.
		 *
		 * @return void
		 */
		public function __construct() {
			$this->id            = 'wkdo_register_donor_email';
			$this->title         = __( 'Register Donor Email', 'woocommerce' );
			$this->heading       = __( 'This email is sent when a donor registers.', 'woocommerce' );
			$this->subject       = '[' . get_option( 'blogname' ) . ']' . esc_html__( 'Donor Email', 'wkmp_seller_auction' );
			$this->description   = esc_html__( 'This email is sent when a donor registers.', 'wkmp_seller_auction' );
			$this->template_html = 'emails/customer-register-donor.php';
			$this->template_base = plugin_dir_path( __FILE__ ) . 'woocommerce/';

			add_action( 'register_donor_trigger_notification', array( $this, 'trigger' ), 10, 1 );

			// Call parent constructor.
			parent::__construct();

			// Other settings.
			$this->recipient = $this->get_option( 'recipient' );

			if ( ! $this->recipient ) {
				$this->recipient = get_option( 'admin_email' );
			}
		}

		/**
		 * Trigger.
		 *
		 * @param array $data data.
		 *
		 * @return array
		 */
		public function trigger( $data ) {

			if ( empty( $data ) ) {
				return false;
			} else {
				$this->user_id = $data['user_id'];
			}
			if ( $this->is_enabled() && $this->get_recipient() ) {
				if ( ! empty( $data['attachment'] ) ) {
					$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $data['attachment'] );
				} else {
					$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
				}
			}
		}

		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html() {

			return wc_get_template_html(
				$this->template_html,
				array(
					'email_heading'  => $this->get_heading(),
					'customer_email' => $this->get_recipient(),
					'blogname'       => $this->get_blogname(),
					'user_id'        => $this->user_id,
					'sent_to_admin'  => false,
					'plain_text'     => false,
					'email'          => $this,
				),
				'',
				$this->template_base
			);
		}

		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_plain,
				array(
					'email_heading'  => $this->get_heading(),
					'email_message'  => $this->email_message,
					'customer_email' => $this->get_recipient(),
					'blogname'       => $this->get_blogname(),
					'sent_to_admin'  => false,
					'plain_text'     => true,
					'email'          => $this,
				),
				'',
				$this->template_base
			);
		}
	}
}

return new Register_Donor_Email();
