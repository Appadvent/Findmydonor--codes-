<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_email_header', $email_heading, $email );

$user_data = get_userdata( $user_id );

?>

<?php if ( 'admin' === $user_type ) : ?>
	<p><?php printf( esc_html__( 'A new donor has registered: %s', 'woocommerce' ), esc_html( $user_data->user_login ) ); ?></p>
	<p><?php esc_html_e( 'Donor details:', 'woocommerce' ); ?></p>
<?php else : ?>
	<p><?php printf( esc_html__( 'Hello %s,', 'woocommerce' ), esc_html( $user_data->user_login ) ); ?></p>
	<p><?php esc_html_e( 'Thank you for registering as a donor! We appreciate your support.', 'woocommerce' ); ?></p>
	<p><?php esc_html_e( 'Here are your registration details:', 'woocommerce' ); ?></p>
<?php endif; ?>

<ul>
	<li><strong><?php esc_html_e( 'Username:', 'woocommerce' ); ?></strong> <?php echo esc_html( $user_data->user_login ); ?></li>
	<li><strong><?php esc_html_e( 'Email:', 'woocommerce' ); ?></strong> <?php echo esc_html( $user_data->user_email ); ?></li>
</ul>

<?php if ( 'admin' !== $user_type ) : ?>
	<p><?php esc_html_e( 'You can log in to your account using the link below:', 'woocommerce' ); ?></p>
	<p><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Login to Your Account', 'woocommerce' ); ?></a></p>
<?php endif; ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>