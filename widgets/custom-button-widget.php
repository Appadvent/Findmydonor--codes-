<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Custom_Button_Widget extends Widget_Base {

	public function get_name() {
		return 'wkdo_member_button';
	}

	public function get_title() {
		return __( 'Membership button', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {

		// Button Text
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Button', 'plugin-name' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => __( 'Text', 'plugin-name' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Click Me', 'plugin-name' ),
			)
		);

		// Button Link
		$this->add_control(
			'button_link',
			array(
				'label'         => __( 'Link', 'plugin-name' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'plugin-name' ),
				'default'       => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
				'show_external' => true,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( is_user_logged_in() ) {
			if ( ! current_user_can( 'donor' ) ) {

				$user_id = get_current_user_id();
				$subscriptions = MeprSubscription::get_all_active_by_user_id($user_id);

				$has_active_subscription = false;

				foreach ( $subscriptions as $subscription ) {
					if ( $subscription->status == 'active' ) {
						$has_active_subscription = true;
						
					}
				}

				if ( $has_active_subscription ) {
					?>  
						<a class="wkdo-membership-button" href="<?php echo site_url( 'match-making/' ); ?>" rel="noopener noreferrer"> Search Profile </a>
					<?php
				} else {
					?>
							<a class="wkdo-membership-button" href="<?php echo site_url( 'registration/premium' ); ?>"  rel="noopener noreferrer"> Get Premium </a>
					<?php
				}
			}
		} else {
			?>
		<a class="wkdo-membership-button" href="<?php echo site_url( 'registration/?action=recipient_user' ); ?>"  rel="noopener noreferrer"> Get Premium </a>
			<?php
		}
		// registration/premium/
		// echo '<a ' . $this->get_render_attribute_string( 'button' ) . '>';
		// echo esc_html( $settings['button_text'] );
		// echo '</a>';
	}
}
