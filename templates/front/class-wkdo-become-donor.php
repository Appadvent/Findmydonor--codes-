<?php
/**
 * Front hooks.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Become donor class.
 */
class Wkdo_Become_Donor {
	/**
	 * User id.
	 *
	 * @var int $user_id user id.
	 */
	public $user_id;

	/**
	 * Construct function.
	 *
	 * @param int $user_id user id.
	 */
	public function __construct( $user_id = null ) {
		if( is_admin( ) ) {
			$user_id = str_replace("D100", "", $user_id);
		}
		$this->user_id = $user_id;
	}

	/**
	 * Registration form.
	 */
	public function wkdo_registration() {
		$username = '';
		$email    = '';
		if ( ! is_user_logged_in() ) {

			if ( isset( $_GET['action'] ) ) {
				$login_url = wc_get_page_permalink( 'myaccount' ) . '?action=recipient_user';
			} else {
				$login_url = wc_get_page_permalink( 'myaccount' );
			}

			$login_button = '<a href="' . esc_url( $login_url ) . '" class="button wc-login-button">' . esc_html__( 'Login Now', 'wdo' ) . '</a>';

			wc_print_notice( esc_html__( 'If you already have an account, please log in first.', 'wdo' ) . ' ' . $login_button, 'notice' );
		} else {
			$user     = wp_get_current_user();
			$username = $user->user_login;
			$email    = $user->user_login;
		}

		if ( ! empty( $_POST['error'] ) ) {
			echo wc_print_notice( $_POST['error'], 'error' );
		}

		?>
		<div class="wkdo-form-cont" >
			<form id="custom-registration-form" method="post">
				<?php
				wp_nonce_field( 'validate_nonce_wkdo', 'validate_nonce_wkdo' );
				?>
				<div class="wkdo-registration mb-20" >
					<div class="wkdo-registration-user ">
						<label for="username"><?php esc_html_e( 'Username:', 'wkdbq' ); ?> <span class="wk-error" > * </span> </label>
						<input type="text" name="username" id="username" value="<?php echo esc_attr( $username ); ?>" <?php echo esc_attr( ! empty( $username ) ? 'readonly' : '' ); ?> required>
					</div>

					<div class="wkdo-registration-email " >
						<label for="email"><?php esc_html_e( 'Email:', 'wkdbq' ); ?> <span class="wk-error" > * </span>  </label>
						<input type="email" name="email" id="email" value="<?php echo esc_attr( $email ); ?>" <?php echo esc_attr( ! empty( $email ) ? 'readonly' : '' ); ?> required>
					</div>
				</div>

				<div class="wkdo-registration mb-20 " >
					<div class="wkdo-registration-user ">
						<label for="first_name"><?php esc_html_e( 'First Name:', 'wkdbq' ); ?> <span class="wk-error" > * </span>  </label>
						<input type="text" name="first_name" id="first_name" required>
					</div>

					<div class="wkdo-registration-email ">
						<label for="last_name"><?php esc_html_e( 'Last Name:', 'wkdbq' ); ?> <span class="wk-error" > * </span> </label>
						<input type="text" name="last_name" id="last_name" required>
					</div>
				</div>
			
				<div class="wkdo-registration mb-20 " >
					<div class="wkdo-registration-user ">
						<label for="wkdoagdob"><?php esc_html_e( 'DOB:', 'wkdbq' ); ?> <span class="wk-error" > * </span>  </label>
						<input type="date" name="dob" class="wkdo-dob" id="wkdoagdob" required>
					</div>

					<?php
					if ( 'recipient_user' != $_GET['action'] ) {
						?>

					<div class="wkdo-registration-email ">
						<label for="dob"><?php esc_html_e( 'What are you looking for:', 'wkdbq' ); ?> <span class="wk-error" > * </span>  </label>
						<select name="donor-type" class="wkdo-select-box" required >
							<option value="donor"><?php esc_html_e( 'To Become A Donor', 'wkdbq' ); ?></option>
							<option value="recipient"><?php esc_html_e( 'To Become A Recipient ', 'wkdbq' ); ?></option>
						</select>
					</div>
						<?php
					} else {
						?>
						<input type="hidden" name="donor_redirect" value="primum" />
						<input type="hidden" name="donor-type" value="recipient" />
						<?php
					}
					?>
					
				</div>
				
				<?php
				if ( ! is_user_logged_in() ) {
					?>
				<div class="wkdo-registration mb-20" >
					<div class="wkdo-registration-user ">
						<label for="password">Password: <span class="wk-error" > * </span> </label>
						<input type="password" class="wkdo-password" name="password" id="wkd-password" required>
						<i class="wkdo fa fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 71%; transform: translateY(-50%); cursor: pointer;"></i>
					</div>
				</div>

				<div class="wkdo-registration mb-20 " >
					<div class="wkdo-disclaimer" >
						
						<p><input type="checkbox" name="age_general_acceptance" id="age_general_acceptance" required>&nbsp;&nbsp;I confirm that I am at least 18 years old and that I have read and accept FindMyDonor's <a href="<?php echo site_url('/terms-and-conditions/'); ?>" target="_blank">Terms & Conditions</a>, <a href="<?php echo site_url('/privacy-policy/'); ?>" target="_blank">Privacy Policy</a>, <a href="<?php echo site_url('/cookie-policy/'); ?>" target="_blank">Cookie Policy</a>, and <a href="<?php echo site_url('/platform-rules/'); ?>" target="_blank">Platform Rules</a>, including the sections on profile visibility, community conduct, and lawful use of the service.<span class="wk-error" > * </span> </p>
						<p>
							
						<input type="checkbox" name="sensitive_data_consent" id="sensitive_data_consent" required>&nbsp;&nbsp;I give my explicit consent for FindMyDonor to process my sensitive personal data—including medical, genetic, fertility, and biometric information—in order to verify my eligibility, facilitate donor-recipient matching, and provide safety features such as Safe-Message filtering.
					 </p>

					 <!-- Conditional Checkboxes for Donor/Recipient -->
					 <div id="donor_specific_consent" style="display: none;">
						<p>
							<input type="checkbox" name="donor_consent" id="donor_consent">&nbsp;&nbsp;I must provide accurate, up-to-date medical and lifestyle information, and I acknowledge that supplying false or misleading data may result in removal from the platform and possible legal action.<span class="wk-error"> * </span>
						</p>
					 </div>

					 <div id="recipient_specific_consent" style="display: none;">
						<p>
							<input type="checkbox" name="recipient_consent" id="recipient_consent">&nbsp;&nbsp;I remain responsible for obtaining independent medical advice and for complying with all clinical and legal requirements in my jurisdiction before proceeding with any donation, insemination, or fertility treatment arranged through FindMyDonor.<span class="wk-error"> * </span>
						</p>
					 </div>
					</div>
				</div>
				<?php } ?>

				<input type="submit" name="wkdo_submit" class="button wk-button-primary" value="Register">
			</form>

			<div id="registration-message" style="color:red"></div>
		</div>

		<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Function to toggle conditional checkboxes
			function toggleConditionalCheckboxes() {
				var donorType = $('select[name="donor-type"]').val();
				
				// Hide both checkboxes first
				$('#donor_specific_consent').hide();
				$('#recipient_specific_consent').hide();
				
				// Remove required attribute from both
				$('#donor_consent').prop('required', false);
				$('#recipient_consent').prop('required', false);
				
				// Show appropriate checkbox based on selection
				if (donorType === 'donor') {
					$('#donor_specific_consent').show();
					$('#donor_consent').prop('required', true);
				} else if (donorType === 'recipient') {
					$('#recipient_specific_consent').show();
					$('#recipient_consent').prop('required', true);
				}
			}
			
			// Initial check on page load
			toggleConditionalCheckboxes();
			
			// Listen for changes in donor-type dropdown
			$('select[name="donor-type"]').on('change', function() {
				toggleConditionalCheckboxes();
			});
		});
		</script>



		<?php
	}

	/**
	 * Register user.
	 */
	public function wkdo_register_user() {
		if ( ! empty( $_POST['validate_nonce_wkdo'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['validate_nonce_wkdo'] ) ), 'validate_nonce_wkdo' ) ) {
			if ( is_user_logged_in() ) {
				$user_id   = get_current_user_id();
				$user      = new WP_User( $user_id );
				$user_type = ! empty( $_POST['donor-type'] ) ? sanitize_text_field( wp_unslash( $_POST['donor-type'] ) ) : '';
				if ( 'donor' === $user_type ) {
					$user->set_role( 'donor' );
				} else {
					$user->set_role( 'recipient' );
				}

				update_user_meta( $user_id, 'first_name', ! empty( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '' );
				update_user_meta( $user_id, 'last_name', ! empty( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '' );
				update_user_meta( $user_id, 'dob', ! empty( $_POST['dob'] ) ? sanitize_text_field( wp_unslash( $_POST['dob'] ) ) : '' );

				$birthdate = $_POST['dob'];
				$today     = new DateTime();
				$dob       = new DateTime( $birthdate );
				$age       = $dob->diff( $today )->y;

				global $wpdb;
				if ( 'donor' === $user_type ) {
					$wpdb->insert(
						$wpdb->prefix . 'wdo_donor_user',
						array(
							'user_id' => $user_id,
							'age'     => $age,
						)
					);
				}

				update_user_meta( $user_id, 'wkdo_becom_donor_status', 'pending' );
				wc_add_notice( esc_html__( 'Thanks for registering! Our team will connect with you as soon as possible.', 'wkdo' ) );

				$user  = wp_get_current_user();
				$roles = (array) $user->roles;
				
				if ( in_array( 'donor', $roles ) ) {
					wp_redirect( site_url( 'my-account/donor-profile/' ) );
					exit;
				}
				if ( in_array( 'recipient', $roles ) ) {
					wp_redirect( site_url( 'my-account/recipient-profile/' ) );
					exit;
				}
			} else {
				$username   = ! empty( $_POST['username'] ) ? sanitize_user( wp_unslash( $_POST['username'] ) ) : '';
				$email      = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
				$first_name = ! empty( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
				$last_name  = ! empty( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
				$password   = ! empty( $_POST['password'] ) ? $_POST['password'] : ''; //phpcs:ignore
				if ( username_exists( $username ) ) {
					$_POST['error'] = esc_html__( 'Username already exists.', 'wkdo' );
					return;
				}

				if ( email_exists( $email ) ) {
					$_POST['error'] = esc_html__( 'Email already exists.', 'wkdo' );
					return;
				}

				$user_id = wp_create_user( $username, $password, $email );
				wp_set_current_user( $user_id );
				wp_set_auth_cookie( $user_id );
				$user      = new WP_User( $user_id );
				$user_type = ! empty( $_POST['donor-type'] ) ? sanitize_text_field( wp_unslash( $_POST['donor-type'] ) ) : '';
				if ( 'donor' === $user_type ) {
					$user->set_role( 'donor' );
				} else {
					$user->set_role( 'recipient' );
				}

				if ( is_wp_error( $user_id ) ) {
					$_POST['error'] = esc_html__( 'Error in registration', 'wkdo' );
				} else {
					update_user_meta( $user_id, 'first_name', ! empty( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '' );
					update_user_meta( $user_id, 'last_name', ! empty( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '' );
					update_user_meta( $user_id, 'dob', ! empty( $_POST['dob'] ) ? sanitize_text_field( wp_unslash( $_POST['dob'] ) ) : '' );

					$birthdate = $_POST['dob'];
					$today     = new DateTime();
					$dob       = new DateTime( $birthdate );
					$age       = $dob->diff( $today )->y;

					global $wpdb;
					if ( 'donor' === $user_type ) {
						$wpdb->insert(
							$wpdb->prefix . 'wdo_donor_user',
							array(
								'user_id' => $user_id,
								'age'     => $age,
							)
						);
					}

					// update_user_meta( $user_id, 'dob', ! empty( $_POST['dob'] ) ? sanitize_text_field( wp_unslash( $_POST['dob'] ) ) : '' );
					update_user_meta( $user_id, 'wkdo_becom_donor_status', 'pending' );
					wc_add_notice( esc_html__( 'Thanks for registering! Our team will connect with you as soon as possible.', 'wkdo' ) );

					if ( isset( $_GET['action'] ) ) {
						wp_redirect( site_url( 'registration/premium/' ) );
						exit;
					}else {
						$user  = wp_get_current_user();
						$roles = (array) $user->roles;

						if ( 'donor' === $user_type ) {
							wp_redirect( site_url( 'my-account/donor-profile/' ) );
							exit;
						}

						if ( 'recipient' === $user_type ) {
							wp_redirect( site_url( 'my-account/recipient-profile/' ) );
							exit;
						}
					}
				}
			}
		}
	}

	/**
	 * Show user profile data.
	 */
	public function wkdo_donor_content() {
		if( ! empty( $_GET['action'] ) && 'edit_doonor' === $_GET['action'] ) { //phpcs:ignore
			$this->wkdo_donor_edit__content();
		} else {
			?>
			<a class="wkdo_edit_profile" href="<?php echo site_url( 'my-account/donor-profile/?action=edit_doonor' ); ?>">Edit Profile <i class="fas fa-user-edit"></i></a>
			<?php
			$this->wkdo_donor_profile_data( get_current_user_id() );
		}
	}

	/**
	 * Details of donor profile.
	 *
	 * @param int $user_id user id.
	 */
	public function wkdo_donor_profile_data( $user_id ) {
		$user_data = get_user_meta( $user_id, 'wkdo_becom_donor', true );
		$user_data = ! empty( $user_data ) ? $user_data : array();
		
		$dob       = get_user_meta( $user_id, 'dob', true );
		$dob       = ! empty( $dob ) ? $dob : $user_data['wkdo_birth'];
		?>
			<div class="wkdv-containr" >
				<div class="wkdv-profile-header" >
					<?php $imge = ! empty( $user_data['wkdo_profile_image'] ) ? $user_data['wkdo_profile_image'] : ''; ?>
					<img src="<?php echo esc_url( $imge ); ?>" class="wkdv-profile-header-img" alt="">
				</div>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > User Basic Info </div>
						<div class="wkdv-content" >
							<table class="wkdv-profile-table" >
								<tr>
									<th> First name: </th>
									<td> <?php echo ! empty( $user_data['wkdo_first_name'] ) ? $user_data['wkdo_first_name'] : get_user_meta( $user_id, 'first_name', true ) ; ?></td>
								</tr>

								<tr>
									<th> Last name: </th>
									<td> <?php echo !empty( $user_data['wkdo_last_name'] ) ? $user_data['wkdo_last_name'] : get_user_meta( $user_id, 'last_name', true ); ?> </td>
								</tr>

								<tr>
									<th> Phone: </th>
									<td> <?php echo ! empty( $user_data['phone'] ) ? $user_data['phone'] : ''; ?></td>
								</tr>

								<tr>
									<th> Email: </th>
									<td> <?php echo ! empty( $user_data['email'] ) ? $user_data['email'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Date of Birth: </th>
									<td> <?php echo $dob; ?> </td>
								</tr>

								<tr>
									<th> User Age: </th>
									<td> <?php 
									$birthdate = new DateTime( $dob );
										$today = new DateTime('now');
										echo $age = $today->diff($birthdate)->y;	
									?> </td>
								</tr>

								<tr>
									<th> Gender: </th>
									<td> <?php echo ! empty( $user_data['wkdo_gender'] ) ? $user_data['wkdo_gender'] : ''; ?></td>
								</tr>
								
							

								<tr>
									<th> Place of Birth: </th>
									<td> <?php echo ! empty( $user_data['place_of_birth'] ) ? $user_data['place_of_birth'] : '-'; ?> </td>
								</tr>
								
								<tr>
									<th> Current Location: </th>
									<td> <?php echo ! empty( $user_data['wkdo_location'] ) ? $user_data['wkdo_location'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Nationality: </th>
									<td> <?php echo ! empty( $user_data['nationality'] ) ? $user_data['nationality'] : ''; ?> </td>
								</tr>	

								<tr>
									<th> Relationship Status: </th>
									<td> <?php echo ! empty( $user_data['relation_status'] ) ? $user_data['relation_status'] : ''; ?> </td>
								</tr>	

								<tr>
									<th> Race: </th>
									<td> <?php 
									$ethnicity_options = [
											'american_indian_alaska_native' => 'American Indian or Alaska Native',
											'asian_east' => 'Asian – East Asian',
											'asian_south' => 'Asian – South Asian',
											'asian_southeast' => 'Asian – Southeast Asian',
											'black_african' => 'Black or African Descent – African',
											'black_caribbean' => 'Black or African Descent – Caribbean',
											'black_african_american' => 'Black or African American',
											'middle_eastern_north_african' => 'Middle Eastern or North African',
											'mixed_multiracial' => 'Mixed or Multiracial',
											'native_hawaiian_pacific_islander' => 'Native Hawaiian or Other Pacific Islander',
											'white_european' => 'White – European (e.g., White British, German, Polish)',
											'white_american' => 'White – American',
											'white_other' => 'White – Other',
											'other' => 'Other'
										];
									
									echo ! empty( $ethnicity_options[ $user_data['wkdo_race'] ] ) ? $ethnicity_options[ $user_data['wkdo_race'] ] : ''; ?> 
									
								
								
								</td>
								</tr>

								<tr>
									<th> Ethnicity: </th>
									<td> <?php echo ! empty( $user_data['wkdo_ethnicity'] ) ? $user_data['wkdo_ethnicity'] : ''; ?> </td>
								</tr>
								

								<!-- <tr>
									<th> Where Are You Willing to Donate?: </th>
									<td> <?php echo ! empty( $user_data['wkdo_account_donor_form'] ) ? $user_data['wkdo_account_donor_form'] : ''; ?> </td>
								</tr> -->

							</table>
						</div>
					</div>

					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > Donation Preferences </div>

						<table class="wkdv-profile-table" >
							<tr>
							<th> What Type of Donor Are You?								: </th>
								<td> <?php echo ! empty( $user_data['wkdo_preference'] ) ? $user_data['wkdo_preference'] : ''; ?></td>
							</tr>

							<tr>
								<th>When Are You Available to Donate?: </th>
								<td> <?php echo ! empty( $user_data['wkdo_avalabl_donate'] ) ? implode( ', ', $user_data['wkdo_avalabl_donate'] ) : ''; ?> </td>
							</tr>
							<tr>
								<th> How Would You Like to Donate?: </th>
								<td> 
								<?php
								$v = array(
									'clinic_donate_only' => 'Clinic Donation Only',
									'home'               => 'At-Home Donation (Sperm Donors Only)',
									'Frozen'             => 'Frozen & Shipped to Recipients Clinic',
								);

								$k = ! empty( $user_data['wkdo_donation_method'] ) ? $user_data['wkdo_donation_method'] : '';
								if ( ! empty( $k ) ) {
									foreach ( $v as $key => $value ) {
										if ( $key === $k ) {
											echo esc_html( $value );
										}
									}
								}
								?>
								</td>
							</tr>

							<tr>
								<th> Your Donation Status: </th>
								<td> 
								<?php
									$donor_status      = ! empty( $user_data['wkdo_donor_status'] ) ? $user_data['wkdo_donor_status'] : '';
									$donor_status_list = array(
										'anonymous_donor' => 'Anonymous Donor',
										'18'              => 'OPEN-ID DONOR',
										'known_donor'     => 'Known Donor',
									);
									if ( ! empty( $donor_status ) ) {
										foreach ( $donor_status_list as $key => $value ) {
											if ( $key === $donor_status ) {
												echo esc_html( $value );
											}
										}
									}
									?>
							</td>
							</tr>

							<tr>
								<th> Have You Donated Before?: </th>
								<td> <?php echo ! empty( $user_data['wkdo_have_donate_before'] ) ? $user_data['wkdo_have_donate_before'] : ''; ?></td>
							</tr>

						</table>

					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > Your Health & Genetic History </div>
						<div class="wkdv-content" >
							<table class="wkdv-profile-table" >
								<tr>
									<th> Are you willing to provide medical and family history? </th>
									<td>  <?php echo ! empty( $user_data['donor_family'] ) ? $user_data['donor_family'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Blood Type: </th>
									<td>  <?php echo ! empty( $user_data['wkdo_blood_type'] ) ? $user_data['wkdo_blood_type'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Have You Had Genetic Screening?: </th>
									<td>  <?php echo ! empty( $user_data['wkdo_genetic_screen'] ) ? $user_data['wkdo_genetic_screen'] : ''; ?></td>
								</tr>

								<tr>
									<th> Do You Have Blood Test Results Available?: </th>
									<td> <?php echo ! empty( $user_data['wkdo_blod_test_avl'] ) ? $user_data['wkdo_blod_test_avl'] : ''; ?></td>
								</tr>

								<tr>
									<th> Have You Completed a Fertility Screening?: </th>
									<td> <?php echo ! empty( $user_data['wkdo_fer_screen'] ) ? $user_data['wkdo_fer_screen'] : ''; ?></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > Your Physical Traits & Background </div>
						<table class="wkdv-profile-table" >
							<tr>
								<th> Height: </th>
								<td> 
									<?php
									$height           = ! empty( $user_data['do_height'] ) ? $user_data['do_height'] : '';
										$height_array = array(
											'below_5ft' => 'Below 5\'0" (152 cm)',
											'5ft_5ft4'  => '5\'0" - 5\'4" (152 - 163 cm)',
											'5ft5_5ft8' => '5\'5" - 5\'8" (165 - 173 cm)',
											'5ft9_6ft'  => '5\'9" - 6\'0" (175 - 183 cm)',
											'above_6ft' => 'Above 6\'0" (183+ cm)',
										);

										foreach ( $height_array as $key => $value ) {
											if ( $key === $height ) {
												echo esc_html( $value );
											}
										}

										?>
								</td>
							</tr>

							<tr>
								<th>Weight: </th>
								<td> 
								<?php
								echo $weight = ! empty( $user_data['wkdo_weight'] ) ? $user_data['wkdo_weight'] : '';

										$weight_array = array(
											'below_50kg' => 'Below 50 kg (110 lbs)',
											'50kg_60kg'  => '50 - 60 kg (110 - 132 lbs)',
											'61kg_70kg'  => '61 - 70 kg (134 - 154 lbs)',
											'71kg_85kg'  => '71 - 85 kg (156 - 187 lbs)',
											'above_85kg' => 'Above 85 kg (187+ lbs)',
										);

										foreach ( $weight_array as $key => $value ) {
											if ( $key === $weight ) {
												echo esc_html( $value );
											}
										}
										?>
								</td>
							</tr>

							<tr>
								<th> Hair Color: </th>
								<td> <?php echo ! empty( $user_data['wkdo_hair_color'] ) ? $user_data['wkdo_hair_color'] : ''; ?></td>
							</tr>

							<tr>
								<th> Eye Color: </th>
								<td> <?php echo ! empty( $user_data['wkdo_eye_color'] ) ? $user_data['wkdo_eye_color'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Body Type: </th>
								<td> <?php echo ! empty( $user_data['wkdo_body_type'] ) ? $user_data['wkdo_body_type'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Distinctive Features: </th>
								<td> <?php echo ! empty( $user_data['wkdo_eye_color'] ) ? $user_data['wkdo_eye_color'] : ''; ?> </td>
							</tr>

							<tr>
								<th>Religion: </th>
								<td> <?php echo ! empty( $user_data['wkdo_religion'] ) ? $user_data['wkdo_religion'] : ''; ?></td>
							</tr>

							<tr>
								<th>Languages Spoken: </th>
								<td> <?php echo ! empty( $user_data['wkdo_lang'] ) ? $user_data['wkdo_lang'] : ''; ?></td>
							</tr>

						</table>

					</div>
				</div>




				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > Your Family & Fertility History </div>
						<div class="wkdv-content" >
							<table class="wkdv-profile-table" >
								<tr>
									<th> Do You Have Any Siblings? </th>
									<td> 
										<?php
											echo $sibling_type = ! empty( $user_data['wkdo_sibling'] ) ? $user_data['wkdo_sibling'] : '';
										?>
																			</td>
								</tr>
								<?php if ( 'Yes' == $sibling_type ) { ?>
								<tr>
									<th> Total Siblings </th>
									<td> 
										<?php
											echo ! empty( $user_data['wkdo_total_sibling'] ) ? $user_data['wkdo_total_sibling'] : '';
										?>
																			</td>
								</tr>
								<?php } ?>

								<tr>
									<th> Do You Have Children?: </th>
									<td> 
										<?php

											echo $childe_status = ! empty( $user_data['wkdo_child'] ) ? $user_data['wkdo_child'] : '';

										?>
									</td>
								</tr>

								<?php if ( 'Yes' == $childe_status ) { ?>
								<tr>
									<th> Total Children </th>
									<td> 
										<?php
											echo ! empty( $user_data['wkdo_total_childe'] ) ? $user_data['wkdo_total_childe'] : '';
										?>
																			</td>
								</tr>
								<?php } ?>

								<tr>
									<th> Have You Had a Child Naturally Conceived (Proven Fertility): </th>
									<td>  <?php echo ! empty( $user_data['wkdo_child_nat'] ) ? $user_data['wkdo_child_nat'] : ''; ?></td>
								</tr>

								<tr>
									<th> If Donating Embryos, Do You Have Stored Embryos at a Clinic?: </th>
									<td>  <?php echo ! empty( $user_data['embryos_stored'] ) ? $user_data['embryos_stored'] : ''; ?></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" > Your Education & Career </div>

						<table class="wkdv-profile-table" >
							<tr>
								<th> What Is Your Highest Level of Education?: </th>
								<td> <?php echo ! empty( $user_data['wkdo_education'] ) ? $user_data['wkdo_education'] : ''; ?></td>
							</tr>

							<tr>
								<th>What Is Your Current Occupation?: </th>
								<td> <?php echo ! empty( $user_data['wkdo_current_occ'] ) ? $user_data['wkdo_current_occ'] : ''; ?> </td>
							</tr>
						</table>

					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Your Short Bio (About Me) (Free Text Box – Introduce yourself and why you're donating.) </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_about'] ) ? $user_data['wkdo_about'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Interests and hobbies – (Free Text Box talk about your interests outside of work, passions etc). </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_hobbies'] ) ? $user_data['wkdo_hobbies'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >Why Do You Want to Be a Donor? (Free Text Box – Your motivation for donating.) </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_want_donor'] ) ? $user_data['wkdo_want_donor'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >Any Special Message for the Recipient? (Free Text Box – Optional, if you'd like to say something to potential recipients.) </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_spacial_msg'] ) ? $user_data['wkdo_spacial_msg'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >If your best friend had to describe you in three words, what would they say? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_friend_describe'] ) ? $user_data['wkdo_friend_describe'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >What your favorite way to spend a weekend? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_weekend'] ) ? $user_data['wkdo_weekend'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >If you could have dinner with any person, living or dead, who would it be and why? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['wkdo_dinner'] ) ? $user_data['wkdo_dinner'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >What one fun fact about you that most people don’t know? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['fun_fact_about'] ) ? $user_data['fun_fact_about'] : ''; ?> </div>
					</div>
				</div>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >What values are most important to you in life?	</div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['fun_most_important'] ) ? $user_data['fun_most_important'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" >Do you have a favorite book, movie, or song? Why does it resonate with you? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['fav_book'] ) ? $user_data['fav_book'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" >Personalized Donor Matching Service & Match Me Donor Bank</div>
						<div class="wkdv-content" >
							<table class="wkdv-profile-table" >
								<tr>
									<th> Would you like to be personally matched to a recipient? </th>
									<td> 
										<?php
											echo $personally_matched = ! empty( $user_data['personally_matched'] ) ? $user_data['personally_matched'] : '';
										?>
																			</td>
								</tr>
								<?php if ( 'Yes' == $personally_matched ) { ?>
									<tr>
										<th> Are you open to meeting/speaking with the recipient(s) before donation? </th>
										<td> 
											<?php
												echo ! empty( $user_data['meeting_with_rec'] ) ? $user_data['meeting_with_rec'] : '';
											?>
																					</td>
									</tr>

									<tr>
										<th>Are you willing to donate directly to Match Me’s donor bank (no recipient matching required) </th>
										<td> 
											<?php
												echo ! empty( $user_data['donate_directly'] ) ? $user_data['donate_directly'] : '';
											?>
																					</td>
									</tr>


									<tr>
										<th>Do You Have Any Known Genetic or Hereditary Conditions? </th>
										<td> 
											<?php
												echo ! empty( $user_data['genetic_conditions'] ) ? $user_data['genetic_conditions'] : '';
											?>
																					</td>
									</tr>

									<tr>
										<th>Do You Have Any Allergies? </th>
										<td> 
											<?php
												echo ! empty( $user_data['allergies'] ) ? $user_data['allergies'] : '';
											?>
																					</td>
									</tr>



								<?php } ?>

						
							</table>
						</div>
					</div>

					
				</div>
				


				<?php
					$spacil_msg = ! empty( $user_data['wkdo_gallery_image'] ) ? $user_data['wkdo_gallery_image'] : '';
					$img        = ! empty( $spacil_msg ) ? explode( ',', $spacil_msg ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Gallery Images </div>
							<div id="image_preview">
								<div class="my-gallery">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
											<a href="<?php echo esc_url( $img_url ); ?>">
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											</a>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>

				<?php
					$Genetic_Screening_Report = ! empty( $user_data['Genetic_Screening_Report'] ) ? $user_data['Genetic_Screening_Report'] : '';
					$g_img                    = ! empty( $spacil_msg ) ? explode( ',', $Genetic_Screening_Report ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " > 
						<div class="wkdv-title" > Genetic Screening Report </div>
							<div id="image_preview">
								<div class="my-gallery">
									<?php
									if ( ! empty( $g_img ) ) {
										foreach ( $g_img as $key => $img_url ) {
											?>
												<a href="<?php echo esc_url( $img_url ); ?>">
													<img src="<?php echo esc_url( $img_url ); ?>" width="150">
												</a>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>


				<?php
					$Blood_report = ! empty( $user_data['Blood_report'] ) ? $user_data['Blood_report'] : '';
					$g_img        = ! empty( $spacil_msg ) ? explode( ',', $Blood_report ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " > 
						<div class="wkdv-title" > Blood Test Results </div>
							<div id="image_preview">
								<div class="my-gallery">
									<?php
									if ( ! empty( $g_img ) ) {
										foreach ( $g_img as $key => $img_url ) {
											?>
												<a href="<?php echo esc_url( $img_url ); ?>">
													<img src="<?php echo esc_url( $img_url ); ?>" width="150">
												</a>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>


				<?php
					$medical_history = ! empty( $user_data['medical_history'] ) ? $user_data['medical_history'] : '';
					$g_img           = ! empty( $medical_history ) ? explode( ',', $medical_history ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " > 
						<div class="wkdv-title" > Medical History Form </div>
							<div id="image_preview">
								<div class="my-gallery">
									<?php
									if ( ! empty( $g_img ) ) {
										foreach ( $g_img as $key => $img_url ) {
											?>
												<a href="<?php echo esc_url( $img_url ); ?>">
													<img src="<?php echo esc_url( $img_url ); ?>" width="150">
												</a>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>


				<?php
					$psychological_assessment = ! empty( $user_data['psychological_assessment'] ) ? $user_data['psychological_assessment'] : '';
					$g_img                    = ! empty( $psychological_assessment ) ? explode( ',', $psychological_assessment ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " > 
						<div class="wkdv-title" > Personality / Psychological Assessment </div>
							<div id="image_preview">
								<div class="my-gallery">
									<?php
									if ( ! empty( $g_img ) ) {
										foreach ( $g_img as $key => $img_url ) {
											?>
												<a href="<?php echo esc_url( $img_url ); ?>">
													<img src="<?php echo esc_url( $img_url ); ?>" width="150">
												</a>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>

				<?php
					$short_video = ! empty( $user_data['short_video'] ) ? $user_data['short_video'] : '';
					$g_img       = ! empty( $short_video ) ? explode( ',', $short_video ) : array();
				?>
				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " > 
						<div class="wkdv-title" > Short introduction video </div>
							<div id="image_preview">
									<?php
									if ( ! empty( $g_img ) ) {
										foreach ( $g_img as $key => $img_url ) {
											?>
												<video width="200" controls="" style="margin:5px;">
													<source src="<?php echo esc_url( $img_url ); ?>" type="video/mp4">
												</video>
											<?php
										}
									}
									?>
								</div>
							</div>
					</div>
				</div>



			</div>
		<?php
	}

	/**
	 * Become a donor form.
	 */
	public function wkdo_donor_edit__content() {
		$this->wkd_save_becom_informattion_template();
		$user_data = array();
		if ( ! empty( $this->user_id ) ) {
			$user_data = get_user_meta( $this->user_id, 'wkdo_becom_donor', true );
			$user_data = ! empty( $user_data ) ? $user_data : array();
		}

	
		$get_user = wp_get_current_user();
		$email    = ! empty( $get_user->user_email ) ? $get_user->user_email : '';
		?>
			<div class="wkdo-form-container">
				<form class="wkdo-form" method="post" enctype="multipart/form-data" >
					<div class="wkdo-form-body">
						<div class="wkdo-b-containr">
							<div class="wkdo-form-section">
									<?php
									if ( is_admin() ) {
										?>
									<h3 class="wkdo-section-title"><?php esc_html_e( 'User Profile2', 'wpdonor' ); ?></h3>
									<?php } else { ?>
									<h3 class="wkdo-section-title"><?php esc_html_e( 'Tell Us About Yourself', 'wpdonor' ); ?></h3>
									<?php } ?>
							</div>
							<div class="wkdo-b-row">
								<?php
									$fname = ! empty( $user_data['wkdo_first_name'] ) ? $user_data['wkdo_first_name'] : get_user_meta( $this->user_id, 'first_name', true );
									$lname = ! empty( $user_data['wkdo_last_name'] ) ? $user_data['wkdo_last_name'] : get_user_meta( $this->user_id, 'last_name', true );
									$dob   = get_user_meta( $this->user_id, 'dob', true );
								?>
								<div class="wkdo-form-section wkdo-50-width">
										<label class="wkdo-label" for=""><?php esc_html_e( 'First Name', 'wpdonor' ); ?></label>
										<input type="text" id="" class="wkdo-input" name="wkdo_first_name" placeholder="<?php esc_attr_e( 'First Name', 'wpdonor' ); ?>" value="<?php echo ! empty( $fname ) ? esc_attr( $fname ) : ''; ?>" required >
								</div>

								<div class="wkdo-form-section wkdo-50-width">
										<label class="wkdo-label" for="input_2_4"><?php esc_html_e( 'Last Name', 'wpdonor' ); ?></label>
										<input type="text" id="input_2_4" class="wkdo-input" name="wkdo_last_name" placeholder="<?php esc_attr_e( 'Last Name', 'wpdonor' ); ?>" value="<?php echo ! empty( $lname ) ? esc_attr( $lname ) : ''; ?>" required >
								</div>
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">
								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_4"><?php esc_html_e( 'Phone', 'wpdonor' ); ?></label>
									<input type="text" id="input_2_4" class="wkdo-input" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'wpdonor' ); ?>" value="<?php echo ! empty( $user_data['phone'] ) ? $user_data['phone'] : ''; ?>" required>
								</div>
								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_4"><?php esc_html_e( 'Email', 'wpdonor' ); ?></label>
									<input readonly type="text" id="input_2_4" class="wkdo-input" name="email" placeholder="<?php esc_attr_e( 'Email', 'wpdonor' ); ?>" value="<?php echo esc_attr( $email ); ?>" required>
								</div>
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">
								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_8"><?php esc_html_e( 'Date of Birth', 'wpdonor' ); ?></label>
									<input type="date" id="input_2_8" class="wkdo-input datepicker" name="wkdo_birth" placeholder="<?php esc_attr_e( 'Date of Birth', 'wpdonor' ); ?>" value="<?php echo ! empty( $dob ) ? $dob : ''; ?>" required>
								</div>
								<div class="wkdo-form-section wkdo-50-width">
								<label class="wkdo-label" for="input_2_9"><?php esc_html_e( 'Gender', 'wpdonor' ); ?></label>
								<?php $gender = ! empty( $user_data['wkdo_gender'] ) ? $user_data['wkdo_gender'] : ''; ?>
								<select id="input_2_9" class="wkdo-select" name="wkdo_gender" required>
									<option <?php selected( 'Male', $gender ); ?> value="Male"><?php esc_html_e( 'Male', 'wpdonor' ); ?></option>
									<option <?php selected( 'Female', $gender ); ?> value="Female"><?php esc_html_e( 'Female', 'wpdonor' ); ?></option>
									<option <?php selected( 'Non-binary', $gender ); ?> value="Non-binary"><?php esc_html_e( 'Non-binary', 'wpdonor' ); ?></option>
									<option <?php selected( 'Other', $gender ); ?> value="Other"><?php esc_html_e( 'Other', 'wpdonor' ); ?></option>
								</select>
								</div>
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">

								<div class="wkdo-form-section wkdo-50-width" >
										<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Place of Birth', 'wpdonor' ); ?></label>

										<?php
										$place_of_birth = ! empty( $user_data['place_of_birth'] ) ? $user_data['place_of_birth'] : '';
										$countries_obj = new WC_Countries();
										$countries = $countries_obj->get_countries();
										?>

										<select name="place_of_birth" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
										<?php foreach ( $countries as $country ) : ?>
												<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $place_of_birth ); ?>>
												<?php esc_html_e( $country, 'wpdonor' ); ?>
												</option>
										<?php endforeach; ?>
										</select>

								</div>

								<div class="wkdo-form-section wkdo-50-width">
										<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Current Location', 'wpdonor' ); ?></label>

										<?php
										$wkdo_location = ! empty( $user_data['wkdo_location'] ) ? $user_data['wkdo_location'] : '';
										$countries_obj = new WC_Countries();
										$countries = $countries_obj->get_countries();
										?>

										<select name="wkdo_location" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
										<?php foreach ( $countries as $country ) : ?>
											<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $wkdo_location ); ?>>
											<?php esc_html_e( $country, 'wpdonor' ); ?>
											</option>
										<?php endforeach; ?>
										</select>

								</div>
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">

								<div class="wkdo-form-section wkdo-50-width" >
										<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Nationality', 'wpdonor' ); ?></label>

										<?php
										$nationality = ! empty( $user_data['nationality'] ) ? $user_data['nationality'] : '';
										$countries_obj = new WC_Countries();
										$countries = $countries_obj->get_countries();
										?>

										<select name="nationality" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
										<?php foreach ( $countries as $country ) : ?>
												<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $nationality ); ?>>
												<?php esc_html_e( $country, 'wpdonor' ); ?>
												</option>
										<?php endforeach; ?>
										</select>

								</div>

								<div class="wkdo-form-section wkdo-50-width">
										<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Relationship Status', 'wpdonor' ); ?></label>

										<?php
										$relation_status = ! empty( $user_data['relation_status'] ) ? $user_data['relation_status'] : '';
										?>
										
										<select name="relation_status" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
											<option <?php selected( 'single', $relation_status ); ?> value="single">Single</option>
											<option <?php selected( 'In a relationship', $relation_status ); ?> value="In a relationship">In a relationship</option>
											<option <?php selected( 'Engaged ', $relation_status ); ?> value="Engaged ">Engaged </option>
											<option <?php selected( 'married', $relation_status ); ?> value="married">Separated</option>
											<option <?php selected( 'Separated', $relation_status ); ?> value="Separated">Separated</option>
											<option <?php selected( 'Divorced', $relation_status ); ?> value="Divorced">Divorced</option>
											<option <?php selected( 'Widowed', $relation_status ); ?> value="Widowed">Widowed</option>
											<option <?php selected( 'In a civil partnership', $relation_status ); ?> value="In a civil partnership">In a civil partnership</option>
										</select>

								</div>
							</div>
						</div>


						<?php
							$wkdo_race = ! empty( $user_data['wkdo_race'] ) ? $user_data['wkdo_race'] : '';
						?>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">
								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_11"><?php esc_html_e( 'Race', 'wpdonor' ); ?></label>
									<select id="input_2_11" class="wkdo-select" name="wkdo_race" required>
										<option <?php selected( 'american_indian_alaska_native', $wkdo_race ); ?> value="american_indian_alaska_native">American Indian or Alaska Native</option>
										<option <?php selected( 'asian_east', $wkdo_race ); ?> value="asian_east">Asian – East Asian</option>
										<option <?php selected( 'asian_south', $wkdo_race ); ?> value="asian_south">Asian – South Asian </option>
										<option <?php selected( 'asian_southeast', $wkdo_race ); ?> value="asian_southeast">Asian – Southeast Asian</option>
										<option <?php selected( 'black_african', $wkdo_race ); ?> value="black_african">Black or African Descent – African</option>
										<option <?php selected( 'black_caribbean', $wkdo_race ); ?> value="black_caribbean">Black or African Descent – Caribbean</option>
										<option <?php selected( 'black_african_american', $wkdo_race ); ?> value="black_african_american">Black or African American</option>
										<option <?php selected( 'middle_eastern_north_african', $wkdo_race ); ?> value="middle_eastern_north_african">Middle Eastern or North African</option>
										<option <?php selected( 'mixed_multiracial', $wkdo_race ); ?> value="mixed_multiracial">Mixed or Multiracial</option>
										<option <?php selected( 'native_hawaiian_pacific_islander', $wkdo_race ); ?> value="native_hawaiian_pacific_islander">Native Hawaiian or Other Pacific Islander</option>
										<option <?php selected( 'white_european', $wkdo_race ); ?> value="white_european">White – European</option>
										<option <?php selected( 'white_american', $wkdo_race ); ?> value="white_american">White – American</option>
										<option <?php selected( 'white_other', $wkdo_race ); ?> value="white_other">White – Other</option>
										<option <?php selected( 'other', $wkdo_race ); ?> value="other">Other</option>
									</select>
								</div>

								<?php
									$ethnicity = ! empty( $user_data['wkdo_ethnicity'] ) ? $user_data['wkdo_ethnicity'] : '';

									$ethnicities = [
										"Afro-Caribbean",
										"African",
										"African American",
										"Albanian",
										"Arab",
										"Argentine",
										"Armenian",
										"Ashkenazi Jewish",
										"Asian",
										"Asian American",
										"Assyrian",
										"Australian Aboriginal",
										"Azerbaijani",
										"Balkan",
										"Bangladeshi",
										"Basque",
										"Belarusian",
										"Berber (Amazigh)",
										"Bhutanese",
										"Black",
										"Bosnian",
										"Brazilian",
										"British",
										"Bulgarian",
										"Burmese",
										"Cambodian",
										"Caribbean",
										"Catalan",
										"Central Asian",
										"Chinese",
										"Colombian",
										"Croatian",
										"Cuban",
										"Czech",
										"Danish",
										"Dutch",
										"Eastern European",
										"Egyptian",
										"English",
										"Eritrean",
										"Ethiopian",
										"Filipino",
										"Finnish",
										"French",
										"Ghanaian",
										"Greek",
										"Gujarati",
										"Gypsy / Roma / Traveller",
										"Haitian",
										"Han Chinese",
										"Hausa",
										"Hispanic / Latino",
										"Hungarian",
										"Icelandic",
										"Indian",
										"Indigenous Australian",
										"Indigenous Canadian",
										"Indigenous Central American",
										"Indigenous South American",
										"Indonesian",
										"Iranian / Persian",
										"Iraqi",
										"Irish",
										"Israeli",
										"Italian",
										"Jamaican",
										"Japanese",
										"Jewish",
										"Jordanian",
										"Korean",
										"Kosovar",
										"Kurdish",
										"Laotian",
										"Latvian",
										"Lebanese",
										"Liberian",
										"Libyan",
										"Lithuanian",
										"Malaysian",
										"Maltese",
										"Mauritian",
										"Mexican",
										"Middle Eastern",
										"Mizrahi Jewish",
										"Mongolian",
										"Moroccan",
										"Nepali",
										"Nigerian",
										"Norwegian",
										"Pakistani",
										"Palestinian",
										"Persian",
										"Polish",
										"Portuguese",
										"Punjabi",
										"Roma / Romani",
										"Romanian",
										"Russian",
										"Sami",
										"Saudi",
										"Scottish",
										"Serbian",
										"Sierra Leonean",
										"Singaporean",
										"Slovak",
										"Slovenian",
										"Somali",
										"South African",
										"South Asian",
										"South East Asian",
										"Spanish",
										"Sri Lankan",
										"Sudanese",
										"Swedish",
										"Syrian",
										"Tamil",
										"Thai",
										"Tibetan",
										"Trinidadian and Tobagonian",
										"Turkish",
										"Turkmen",
										"Ukrainian",
										"Uruguayan",
										"Uzbek",
										"Venezuelan",
										"Vietnamese",
										"Welsh",
										"West African",
										"White",
										"Yemeni",
										"Yoruba",
										"Zulu"
									];

								?>

								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_12"><?php esc_html_e( 'Ethnicity', 'wpdonor' ); ?></label>
									<select id="input_2_12" class="wkdo-select" name="wkdo_ethnicity" required>
										<?php 
										foreach ( $ethnicities as $ethnicity_option ) {
											?>
											<option <?php selected( $ethnicity_option, $ethnicity ); ?> value="<?php echo esc_attr( $ethnicity_option ); ?>"><?php esc_html_e( $ethnicity_option, 'wpdonor' ); ?></option>
											<?php
										}
										?>
										
									</select>
								</div>
							</div>
						</div>

						<hr>

						<?php
							$preference = ! empty( $user_data['wkdo_preference'] ) ? $user_data['wkdo_preference'] : '';
						?>
						<h3><?php esc_html_e( 'Your Donation Preferences', 'wpdonor' ); ?></h3>
						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">
								<div class="wkdo-form-section wkdo-50-width">
									
									<label class="wkdo-label" for="input_2_13"><?php esc_html_e( 'What Type of Donor Are You?', 'wpdonor' ); ?></label>
									<select name="wkdo_preference" id="input_1_35" class="" aria-invalid="false" required>
										<option <?php selected( 'Egg Donor', $preference ); ?> value="Egg Donor"><?php esc_html_e( 'Egg Donor', 'wpdonor' ); ?></option>
										<option <?php selected( 'Sperm Donor', $preference ); ?> value="Sperm Donor"><?php esc_html_e( 'Sperm Donor', 'wpdonor' ); ?></option>
										<option <?php selected( 'Embryo Donor', $preference ); ?>value="Embryo Donor"><?php esc_html_e( 'Embryo Donor', 'wpdonor' ); ?></option>
									</select>
								</div>

								<?php
									$aval_donate = ! empty( $user_data['wkdo_avalabl_donate'] ) ? $user_data['wkdo_avalabl_donate'] : '';
								?>
														
								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="wkdo_avalabl_donate"><?php esc_html_e( 'When Are You Available to Donate?', 'wpdonor' ); ?></label>

									<?php
									$aval_donate = ! empty( $user_data['wkdo_avalabl_donate'] ) ? (array) $user_data['wkdo_avalabl_donate'] : array();

									$options = array(
										'Immediately'      => __( 'Immediately', 'wpdonor' ),
										'3-6 Months'       => __( '3-6 Months', 'wpdonor' ),
										'6+ Months'        => __( '6+ Months', 'wpdonor' ),
										'Needs Discussion' => __( 'Needs Discussion', 'wpdonor' ),
									);
									?>

									<select multiple="multiple" size="7" name="wkdo_avalabl_donate[]" id="wkdo_avalabl_donate" class="large gfield_select" aria-invalid="false" >
									<?php foreach ( $options as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>" <?php echo in_array( $value, $aval_donate ) ? 'selected' : ''; ?>>
											<?php echo esc_html( $label ); ?>
											</option>
									<?php endforeach; ?>
									</select>

								</div>

								
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">

								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_15"><?php esc_html_e( 'Where Are You Willing to Donate?', 'wpdonor' ); ?></label>
									<?php
									$acc_donor_form = ! empty( $user_data['wkdo_account_donor_form'] ) ? $user_data['wkdo_account_donor_form'] : '';

									$options = array(
										'UK'            => __( 'UK', 'wpdonor' ),
										'Europe'        => __( 'Europe', 'wpdonor' ),
										'North America' => __( 'North America', 'wpdonor' ),
										'South America' => __( 'South America', 'wpdonor' ),
										'Asia'          => __( 'Asia', 'wpdonor' ),
										'Australia & New Zealand' => __( 'Australia & New Zealand', 'wpdonor' ),
										'Africa'        => __( 'Africa', 'wpdonor' ),
										'Worldwide'     => __( 'Worldwide', 'wpdonor' ),
									);
									?>

									<select id="input_2_15" class="wkdo-select" name="wkdo_account_donor_form">
									<?php foreach ( $options as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $acc_donor_form ); ?>>
											<?php echo esc_html( $label ); ?>
											</option>
									<?php endforeach; ?>
									</select>
								</div>

								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="input_2_18">
										<?php esc_html_e( 'How Would You Like to Donate?', 'wpdonor' ); ?>
									</label>
									<?php
										$donate_method = ! empty( $user_data['wkdo_donation_method'] ) ? $user_data['wkdo_donation_method'] : 'test';
									?>
									<select name="wkdo_donation_method" id="">
										<option <?php selected( $donate_method, 'clinic_donate_only' ); ?> value="clinic_donate_only"> Clinic Donation Only </option>
										<option <?php selected( $donate_method, 'home' ); ?> value="home"> At-Home Donation (Sperm Donors Only) </option>
										<option <?php selected( $donate_method, 'Frozen' ); ?> value="Frozen"> Frozen & Shipped to Recipients Clinic </option>
									</select>
								</div>
							</div>
						</div>

						<div class="wkdo-b-containr">
							<div class="wkdo-b-row">


								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="wkdo_donor_status"><?php esc_html_e( 'Your Donation Status', 'wpdonor' ); ?> </label>
									<div class="wkdo-dono-status-row" >
										<?php
											$donor_status = ! empty( $user_data['wkdo_donor_status'] ) ? $user_data['wkdo_donor_status'] : '';
										?>
										<select name="wkdo_donor_status" id="wkdo_donor_status">
											<option <?php selected( $donor_status, 'anonymous_donor' ); ?> value="anonymous_donor">Anonymous Donor</option>
											<option <?php selected( $donor_status, '18' ); ?> value="18">Open-ID Donor</option>
											<option <?php selected( $donor_status, 'known_donor' ); ?> value="known_donor">Known Donor</option>
										</select>
									</div>

								</div>

								<div class="wkdo-form-section wkdo-50-width">
									<label class="wkdo-label" for="donate_before"> <?php esc_html_e( 'Have You Donated Before?', 'wpdonor' ); ?> </label>
									<?php
										$donate_before = ! empty( $user_data['wkdo_have_donate_before'] ) ? $user_data['wkdo_have_donate_before'] : '';
									?>
									<div class="wkdo-dono-status-row" >
										<select name="wkdo_have_donate_before" id="donate_before">
											<option <?php selected( $donate_method, 'yes' ); ?> value="yes">Yes</option>
											<option <?php selected( $donate_method, 'no' ); ?> value="no">No</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<hr><?php esc_html_e( 'Your Health & Genetic History', 'wpdonor' ); ?></hr>

						<div class="wkdo-form-section wkdo-top-50">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( ' Are you willing to provide medical and family history?', 'wpdonor' ); ?></label>
							<?php
							$donor_family = ! empty( $user_data['donor_family'] ) ? $user_data['donor_family'] : 'No';
							?>
							<div class="wkdo-dono-status-row" >
								<div class="wkdo_radio_flex" >
									<input type="radio" name="donor_family" id="" value='Yes' required <?php checked( 'Yes', $donor_family ); ?> > <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
								</div>
								<div class="wkdo_radio_flex" >
									<input type="radio" name="donor_family" id="" value='No' required <?php checked( 'No', $donor_family ); ?> > <?php esc_html_e( 'No', 'wpdonor' ); ?>
								</div>
							</div>
						</div>

						<div class="wkdo-form-section">
								<label class="wkdo-label" for="input_2_19"><?php esc_html_e( 'Blood Type', 'wpdonor' ); ?></label>

								<?php
										$blood_type = ! empty( $user_data['wkdo_blood_type'] ) ? $user_data['wkdo_blood_type'] : '';

										$options = array(
											'A+'  => __( 'A+', 'wpdonor' ),
											'A-'  => __( 'A-', 'wpdonor' ),
											'B+'  => __( 'B+', 'wpdonor' ),
											'B-'  => __( 'B-', 'wpdonor' ),
											'AB+' => __( 'AB+', 'wpdonor' ),
											'AB-' => __( 'AB-', 'wpdonor' ),
											'O+'  => __( 'O+', 'wpdonor' ),
											'O-'  => __( 'O-', 'wpdonor' ),
										);
										?>

										<select id="input_2_19" class="wkdo-select" name="wkdo_blood_type">
										<?php foreach ( $options as $value => $label ) : ?>
												<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $blood_type ); ?>>
												<?php echo esc_html( $label ); ?>
												</option>
										<?php endforeach; ?>
										</select>

						</div>

						<?php
							$genetic_screen = ! empty( $user_data['wkdo_genetic_screen'] ) ? $user_data['wkdo_genetic_screen'] : 'no';
						?>
						
						<div class="wkdo-form-section wkdo-top-50" ">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Have You Had Genetic Screening?', 'wpdonor' ); ?></label>
							<div class="wkdo-dono-status-row" >
								<div class="wkdo_radio_flex" >
									<input type="radio" name="wkdo_genetic_screen" 
									value='yes' id="" required <?php checked( 'yes', $genetic_screen ); ?> ><?php esc_html_e( 'Yes', 'wpdonor' ); ?>
								</div>

								<div class="wkdo_radio_flex" >
									<input type="radio" name="wkdo_genetic_screen" 
									value='no' id="" <?php checked( 'no', $genetic_screen ); ?>  required> <?php esc_html_e( 'No', 'wpdonor' ); ?>
								</div>
							</div>
						</div>

						<?php
							$blod_test_avl = ! empty( $user_data['wkdo_blod_test_avl'] ) ? $user_data['wkdo_blod_test_avl'] : 'no';
						?>
						<div class="wkdo-form-section wkdo-top-50">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Do You Have Blood Test Results Available?', 'wpdonor' ); ?></label>
							<div class="wkdo-dono-status-row" >
								<div class="wkdo_radio_flex" >
									<input type="radio" name="wkdo_blod_test_avl" id="" value='yes' required <?php checked( 'yes', $blod_test_avl ); ?> > <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
								</div>
								<div class="wkdo_radio_flex" >
									<input type="radio" <?php checked( 'no', $blod_test_avl ); ?> name="wkdo_blod_test_avl" id="" value='no' required> <?php esc_html_e( 'No', 'wpdonor' ); ?>
								</div>
							</div>
						</div>
							

						<?php
							$wkdo_fer_screen = ! empty( $user_data['wkdo_fer_screen'] ) ? $user_data['wkdo_fer_screen'] : 'no';
						?>

						<div class="wkdo-form-section wkdo-top-50">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Have You Completed a Fertility Screening?', 'wpdonor' ); ?></label>
							<div class="wkdo-dono-status-row" >
								<div class="wkdo_radio_flex" >
									<input type="radio" name="wkdo_fer_screen" id="" value='yes' required <?php checked( 'yes', $wkdo_fer_screen ); ?> > <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
								</div>
								<div class="wkdo_radio_flex" >
									<input type="radio" name="wkdo_fer_screen" id="" value='no' <?php checked( 'no', $wkdo_fer_screen ); ?> required> <?php esc_html_e( 'No', 'wpdonor' ); ?>
								</div>
							</div>
						</div>

						<h3><?php esc_html_e( 'Your Physical Traits & Background', 'wpdonor' ); ?></h3>

						<div class="wkdo-physical-background wkdo-top-50" style="padding-top: 10px !important;" >
							<div class="wkdo-div wkdo-flex-box" >
							<label class="wkdo-label" for="input_2_18">
								<?php esc_html_e( 'Height', 'wpdonor' ); ?></label>
								
								<?php $do_height = ! empty( $user_data['do_height'] ) ? $user_data['do_height'] : ''; ?>
								<div class="wkdo_height_inputs">
									<select id="donor-height" name="do_height">
										<option value="">Select Height Range</option>
										<option <?php selected( 'below_5ft', $do_height ); ?>  value="below_5ft">Below 5'0" (152 cm)</option>
										<option <?php selected( '5ft_5ft4', $do_height ); ?> value="5ft_5ft4">5'0" - 5'4" (152 - 163 cm)</option>
										<option <?php selected( '5ft5_5ft8', $do_height ); ?> value="5ft5_5ft8">5'5" - 5'8" (165 - 173 cm)</option>
										<option <?php selected( '5ft9_6ft', $do_height ); ?> value="5ft9_6ft">5'9" - 6'0" (175 - 183 cm)</option>
										<option <?php selected( 'above_6ft', $do_height ); ?> value="above_6ft">Above 6'0" (183+ cm)</option>
									</select>
								</div>
							</div>

							<div class="wkdo-div wkdo-flex-box" >
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Weight', 'wpdonor' ); ?></label>
								<?php
									$donor_weight = ! empty( $user_data['wkdo_weight'] ) ? $user_data['wkdo_weight'] : '';
								?>
								<select id="donor-weight" name="wkdo_weight">
									<option <?php selected( '1', $donor_weight ); ?>  value="1">Select Weight Range</option>
									<option <?php selected( 'below_50kg', $donor_weight ); ?> value="below_50kg">Below 50 kg (110 lbs)</option>
									<option <?php selected( '50kg_60kg', $donor_weight ); ?> value="50kg_60kg">50 - 60 kg (110 - 132 lbs)</option>
									<option <?php selected( '61kg_70kg', $donor_weight ); ?> value="61kg_70kg">61 - 70 kg (134 - 154 lbs)</option>
									<option <?php selected( '71kg_85kg', $donor_weight ); ?> value="71kg_85kg">71 - 85 kg (156 - 187 lbs)</option>
									<option <?php selected( 'above_85kg', $donor_weight ); ?> value="above_85kg">Above 85 kg (187+ lbs)</option>
								</select>
							</div>

							<div class="wkdo-div" >
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Hair Color', 'wpdonor' ); ?></label>
								<?php $hair_color = ! empty( $user_data['wkdo_hair_color'] ) ? $user_data['wkdo_hair_color'] : ''; ?>
								<select name="wkdo_hair_color" id="wkdo_hair_color" style="width:100%">
									<option <?php selected( $hair_color, 'black' ); ?> value="black">Black</option>
									<option <?php selected( $hair_color, 'dark-brown' ); ?> value="dark-brown">Dark Brown</option>
									<option <?php selected( $hair_color, 'brown' ); ?> value="brown">Brown</option>
									<option <?php selected( $hair_color, 'auburn' ); ?> value="auburn">Auburn</option>
									<option <?php selected( $hair_color, 'chestnut' ); ?> value="chestnut">Chestnut</option>
									<option <?php selected( $hair_color, 'red/ginger' ); ?> value="red/ginger">Red / Ginger Blonde</option>
									<option <?php selected( $hair_color, 'strawberry_blonde' ); ?> value="strawberry_blonde">Strawberry Blonde</option>
									<option <?php selected( $hair_color, 'dirty_blonde' ); ?> value="dirty_blonde">'Dirty Blonde / Ash Blonde</option>
									<option <?php selected( $hair_color, 'platinum' ); ?> value="platinum">Platinum Blonde / White Blonde Gray / Silver</option>
									<option <?php selected( $hair_color, 'white' ); ?> value="white">White</option>
								</select>
							</div>

							<div class="wkdo-div">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Eye Color', 'wpdonor' ); ?></label>
								<?php $eye_color = ! empty( $user_data['wkdo_eye_color'] ) ? $user_data['wkdo_eye_color'] : ''; ?>

								<select name="wkdo_eye_color" id="wkdo_eye_color" style="width: 100%;" >
									<option <?php selected( $eye_color, 'brown' ); ?> value="brown">Brown</option>
									<option <?php selected( $eye_color, 'dark' ); ?> value="dark Brown">Dark Brown / Almost Black</option>
									<option <?php selected( $eye_color, 'hazel' ); ?> value="hazel">Hazel</option>
									<option <?php selected( $eye_color, 'amber' ); ?> value="amber">Amber</option>
									<option <?php selected( $eye_color, 'green' ); ?>  value="green">Green</option>
									<option <?php selected( $eye_color, 'blue' ); ?> value="blue">Blue</option>
									<option <?php selected( $eye_color, 'gray' ); ?> value="gray">Gray</option>
								</select>
							</div>

							<div class="wkdo-div">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Body Type', 'wpdonor' ); ?></label>
								
								<?php $wkdo_body_type = ! empty( $user_data['wkdo_body_type'] ) ? $user_data['wkdo_body_type'] : ''; ?>

								<select name="wkdo_body_type" id="wkdo_body_type" style="width: 100%;" >
									<option <?php selected( $wkdo_body_type, 'Slim' ); ?> value="Slim">Slim</option>
									<option <?php selected( $wkdo_body_type, 'Athletic' ); ?> value="Athletic">Athletic</option>
									<option <?php selected( $wkdo_body_type, 'Average' ); ?> value="Average">Average</option>
									<option <?php selected( $wkdo_body_type, 'Curvy' ); ?> value="Curvy">Curvy</option>
									<option <?php selected( $wkdo_body_type, 'Muscular' ); ?>  value="Muscular">Muscular</option>
									<option <?php selected( $wkdo_body_type, 'Other' ); ?> value="blue">Other</option>
								</select>
							</div>

							<div class="wkdo-div">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Body Type', 'wpdonor' ); ?></label>
								
								<?php $wkdo_body_type = ! empty( $user_data['wkdo_body_type'] ) ? $user_data['wkdo_body_type'] : ''; ?>

								<select name="wkdo_body_type" id="wkdo_body_type" style="width: 100%;" >
									<option <?php selected( $wkdo_body_type, 'Slim' ); ?> value="Slim">Slim</option>
									<option <?php selected( $wkdo_body_type, 'Athletic' ); ?> value="Athletic">Athletic</option>
									<option <?php selected( $wkdo_body_type, 'Average' ); ?> value="Average">Average</option>
									<option <?php selected( $wkdo_body_type, 'Curvy' ); ?> value="Curvy">Curvy</option>
									<option <?php selected( $wkdo_body_type, 'Muscular' ); ?>  value="Muscular">Muscular</option>
									<option <?php selected( $wkdo_body_type, 'Other' ); ?> value="blue">Other</option>
								</select>
							</div>


							<div class="wkdo-div">
								<div id="field_1_6" class="">
								<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Distinctive Features', 'wpdonor' ); ?></label>
									<div class="ginput_container ginput_container_number">
										<?php $distinctive_featur = ! empty( $user_data['distinctive_featur'] ) ? $user_data['distinctive_featur'] : ''; ?>
										<input type="text" name="distinctive_featur" class="Distinctive Features" id="" value="<?php echo $distinctive_featur; ?>" >
									</div>
								</div>
							</div>

							<div class="wkdo-div">
								<div id="field_1_6" class="">
								<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Religion (Optional)', 'wpdonor' ); ?></label>
									<div class="ginput_container ginput_container_number">
										<?php
											$religions = [
    "Agnostic",
    "Atheist",
    "Baha'i",
    "Buddhist",
    "Christian – Catholic",
    "Christian – Protestant",
    "Christian – Other",
    "Hindu",
    "Jewish",
    "Jain",
    "Muslim",
    "Pagan",
    "Rastafarian",
    "Sikh",
    "Spiritual but not religious",
    "Zoroastrian"
];
											$religion  = ! empty( $user_data['wkdo_religion'] ) ? $user_data['wkdo_religion'] : '';
										?>
										<select name="wkdo_religion" id="wkdo_religion" style="width:100%">
											<?php foreach ( $religions as $list ) { ?>
											<option <?php selected( $religion, $list ); ?> value="<?php echo $list; ?>"> <?php echo $list; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="wkdo-div">
								<div id="field_1_6" class="">
									<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Languages Spoken', 'wpdonor' ); ?></label>
									<div class="ginput_container ginput_container_number">
										<input name="wkdo_lang" class="wkdo-input-width" id="input_1_6" type="text" required value="<?php echo ! empty( $user_data['wkdo_lang'] ) ? $user_data['wkdo_lang'] : ''; ?>" aria-invalid="false">
									</div>
								</div>
							</div>

						</div>

						<div class="wkdo-your-family-fertility-history"> <br />
						<hr>
							<h3><?php esc_html_e( 'Your Family & Fertility History', 'wpdonor' ); ?></h3>

							<div class="wkdo-b-containr">
								<div class="wkdo-b-row">

									<div class="wkdo_sibling wkdo-50-width" >
										<?php $sibling = ! empty( $user_data['wkdo_sibling'] ) ? $user_data['wkdo_sibling'] : 'No'; ?>
										<label class="wkdo-label" for="input_2_18"> <?php esc_html_e( 'Do You Have Any Siblings?', 'wpdonor' ); ?></label>
										<div class="wkdo_radio_flex" >
											<input type="radio" class="radioOption" name="wkdo_sibling" value="Yes" id="" <?php checked( 'Yes', $sibling ); ?>> <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
										</div>

										<div class="wkdo_radio_flex" >
											<input <?php checked( 'No', $sibling ); ?> type="radio" class="radioOption" name="wkdo_sibling"  value="No"  id=""> <?php esc_html_e( 'No', 'wpdonor' ); ?>
										</div>
									</div>
										<?php
											$diplay = "style='display:block;'";
										if ( 'No' === $sibling ) {
											$diplay = "style='display:none;'";
										}
										?>
									<div class="wkdo_sibling wkdo-50-width wkdo_radio_flex wkdo_radio_flex_hide " <?php echo $diplay; ?> >
									<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'How Many?', 'wpdonor' ); ?></label>
										<?php $sibling = ! empty( $user_data['wkdo_total_sibling'] ) ? $user_data['wkdo_total_sibling'] : ''; ?>
										<input type="text"  name="wkdo_total_sibling" id="" value="<?php echo $sibling; ?>" >
									</div>
							</div>
							
							<br />

							<div class="wkdo-b-containr">
								<div class="wkdo-b-row">

									<div class="wkdo-50-width">
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Do You Have Children?', 'wpdonor' ); ?></label>
										<?php $child = ! empty( $user_data['wkdo_child'] ) ? trim( $user_data['wkdo_child'] ) : 'No'; ?>
										<div class="wkdo_radio_flex" >
											<input class="Have_Children" <?php checked( 'Yes', $child ); ?> type="radio" name="wkdo_child" id="" value="Yes" > <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
										</div>
										<div class="wkdo_radio_flex" >
											<input class="Have_Children" <?php checked( 'No', $child ); ?>  type="radio" name="wkdo_child" id="" value="No" > <?php esc_html_e( 'No', 'wpdonor' ); ?>
										</div>
									</div>
									<?php
									if ( 'No' == $child ) {
										$display = "style='display:none;'";
									} else {
										$display = "style='display:block;'";
									}
									?>
									<div class="wkdo_sibling wkdo-50-width wkdo_radio_flex Have_Children_Hide" <?php echo $display; ?> >
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'How Many?', 'wpdonor' ); ?></label>
										<?php $childe = ! empty( $user_data['wkdo_total_childe'] ) ? $user_data['wkdo_total_childe'] : ''; ?>
										<input type="text"  name="wkdo_total_childe" id="" value="<?php echo $childe; ?>" >
									</div>
									
								</div>
							</div>
							
							
							<br />
							<div class="wkdo-b-containr">
								<div class="wkdo-b-row">

									<div class="wkdo-50-width" >
										<?php $child_nat = ! empty( $user_data['wkdo_child_nat'] ) ? $user_data['wkdo_child_nat'] : 'No'; ?>
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Have You Had a Child Naturally Conceived (Proven Fertility)?', 'wpdonor' ); ?></label>

										<div class="wkdo_radio_flex" >
											<input <?php checked( 'Yes', $child_nat ); ?> type="radio" name="wkdo_child_nat" id="" value="Yes" > <?php esc_html_e( 'Yes', 'wpdonor' ); ?>
										</div>
										<div class="wkdo_radio_flex" >
											<input <?php checked( 'No', $child_nat ); ?> type="radio" name="wkdo_child_nat" id="" value="No" > <?php esc_html_e( 'No', 'wpdonor' ); ?>
										</div>
									</div>
									<!-- </div> -->
								
									<div class="wkdo_sibling wkdo-50-width wkdo_radio_flex" >
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'If Donating Embryos, Do You Have Stored Embryos at a Clinic?', 'wpdonor' ); ?></label>
										<?php $embryos_stored = ! empty( $user_data['embryos_stored'] ) ? $user_data['embryos_stored'] : ''; ?>

										<select name="embryos_stored" id="embryos_stored" style="width: 100%;" >
											<option <?php selected( $embryos_stored, 'Yes' ); ?> value="Yes">Yes</option>
											<option <?php selected( $embryos_stored, 'No' ); ?> value="No">No</option>
											<option <?php selected( $embryos_stored, 'Not applicable' ); ?> value="Not applicable">Not applicable</option>
										</select>

									</div>

								</div>
							</div>
						</div>
						<br />
						<hr>
						<div class="wkdo-education-history">
							
							<h3><?php esc_html_e( 'Your Education & Career', 'wpdonor' ); ?></h3>
							<div class="wkdo-b-containr">
								<div class="wkdo-b-row">
									<?php $child_nat = ! empty( $user_data['wkdo_education'] ) ? $user_data['wkdo_education'] : ''; ?>
									<div class="wkdo_eduction_flex">
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'What Is Your Highest Level of Education?', 'wpdonor' ); ?></label>
										<select name="wkdo_education" id="input_1_57" class="" aria-invalid="false">
												<option <?php selected( 'No Formal Education', $child_nat ); ?> value="No Formal Education">
														<?php esc_html_e( 'No Formal Education', 'wpdonor' ); ?>
												</option>
												<option <?php selected( 'High School / GCSE / O Levels', $child_nat ); ?> value="High School / GCSE / O Levels">
														<?php esc_html_e( 'High School / GCSE / O Levels', 'wpdonor' ); ?>
												</option>

												<option <?php selected( 'A-Levels / IB / College Diploma', $child_nat ); ?> value="A-Levels / IB / College Diploma">
														<?php esc_html_e( 'A-Levels / IB / College Diploma', 'wpdonor' ); ?>
												</option>

												<option <?php selected( 'Bachelor Degree', $child_nat ); ?> value="Bachelor Degree"><?php esc_html_e( 'Bachelor\'s Degree', 'wpdonor' ); ?></option>

												<option <?php selected( 'Master Degree', $child_nat ); ?> value="Master Degree">
														<?php esc_html_e( 'Master\'s Degree', 'wpdonor' ); ?>
												</option>

												<option <?php selected( 'PHD / Doctorate', $child_nat ); ?> value="PhD / Doctorate">
														<?php esc_html_e( 'PHD / Doctorate', 'wpdonor' ); ?>
												</option>

												<option <?php selected( 'Other', $child_nat ); ?> value="Other">
														<?php esc_html_e( 'Other', 'wpdonor' ); ?>
												</option>
										</select>
									</div>
									<div class="wkdo_eduction_flex">
										<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'What Is Your Current Occupation?', 'wpdonor' ); ?></label>
										<input name="wkdo_current_occ" type="text"  aria-invalid="false" value="<?php echo ! empty( $user_data['wkdo_current_occ'] ) ? $user_data['wkdo_current_occ'] : ''; ?>" >
									</div>
								</div>
							</div>
						</div>

						<div class="wkdo-form-section">
							<h3 class="wkdo-section-title"><?php esc_html_e( 'Tell Us More About You', 'wpdonor' ); ?></h3>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Your Short Bio (About Me) (Free Text Box – Introduce yourself and why you\'re donating.)', 'wpdonor' ); ?></label>
							<textarea id="input_2_29" class="wkdo-textarea" name="wkdo_about" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_about'] ) ? $user_data['wkdo_about'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Interests and hobbies – (Free Text Box talk about your interests outside of work, passions etc.)', 'wpdonor' ); ?></label>
							<textarea id="input_2_31" class="wkdo-textarea" name="wkdo_hobbies" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_hobbies'] ) ? $user_data['wkdo_hobbies'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Why Do You Want to Be a Donor? (Free Text Box – Your motivation for donating.)', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="wkdo_want_donor" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_want_donor'] ) ? $user_data['wkdo_want_donor'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Any Special Message for the Recipient? (Free Text Box – Optional, if you\'d like to say something to potential recipients.)', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="wkdo_spacial_msg" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_spacial_msg'] ) ? $user_data['wkdo_spacial_msg'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'If your best friend had to describe you in three words, what would they say?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="wkdo_friend_describe" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_friend_describe'] ) ? $user_data['wkdo_friend_describe'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'What your favorite way to spend a weekend?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="wkdo_weekend" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_weekend'] ) ? $user_data['wkdo_weekend'] : ''; ?></textarea>
						</div>


						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'If you could have dinner with any person, living or dead, who would it be and why?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="wkdo_dinner" rows="10" cols="50"><?php echo ! empty( $user_data['wkdo_dinner'] ) ? $user_data['wkdo_dinner'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'What one fun fact about you that most people don’t know?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="fun_fact_about" rows="10" cols="50"><?php echo ! empty( $user_data['fun_fact_about'] ) ? $user_data['fun_fact_about'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'What values are most important to you in life?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="fun_most_important" rows="10" cols="50"><?php echo ! empty( $user_data['fun_most_important'] ) ? $user_data['fun_most_important'] : ''; ?></textarea>
						</div>

						<div class="wkdo-form-section">
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Do you have a favorite book, movie, or song? Why does it resonate with you?', 'wpdonor' ); ?></label>
							<textarea id="input_2_30" class="wkdo-textarea" name="fav_book" rows="10" cols="50"><?php echo ! empty( $user_data['fav_book'] ) ? $user_data['fav_book'] : ''; ?></textarea>
						</div>
								
						<hr>
						<h3>Personalized Donor Matching Service & Match Me Donor Bank</h3>


						<div id="field_1_76" class="gfield gfield--type-section gfield--input-type-section gsection field_sublabel_below gfield--has-description field_description_below field_validation_below gfield_visibility_visible" data-js-reload="field_1_76">
							<div class="gsection_description" id="gfield_description_1_76">
								<label class="wkdo-label" for="input_2_18"> What is the Personalized Matching Service? </label> <br/>  
								<div style="font-size: 14px; margin-bottom: 17px;" >							
									<img style="width: 16px;" draggable="false" role="img" class="emoji" alt="✔" src="https://s.w.org/images/core/emoji/15.0.3/svg/2714.svg"> MatchMe will personally match you with recipients, handle any additional screening, and liaise with recipients on your behalf. <br>
									<img style="width: 16px;" draggable="false" role="img" class="emoji" alt="✔" src="https://s.w.org/images/core/emoji/15.0.3/svg/2714.svg"> We will also arrange sample collection, shipping, and all necessary logistics. <br>
									<img style="width: 16px;" draggable="false" role="img" class="emoji" alt="✔" src="https://s.w.org/images/core/emoji/15.0.3/svg/2714.svg"> We act on your behalf, making the process smooth and stress-free.
								</div>
							</div>
						</div>

						<div class="wkdo_sibling  wkdo_radio_flex flex-direction" >
							<label class="wkdo-label" for="input_2_18"><?php esc_html_e( 'Would you like to be personally matched to a recipient?', 'wpdonor' ); ?></label>
							<?php $personally_matched = ! empty( $user_data['personally_matched'] ) ? $user_data['personally_matched'] : ''; ?>

							<select name="personally_matched" id="personally_matched" style="width: 100%;" >
								<option <?php selected( $personally_matched, 'No' ); ?> value="No">No</option>
								<option <?php selected( $personally_matched, 'Yes' ); ?> value="Yes">Yes</option>
							</select>
						</div>

						<?php
							$style = "style='display:none;'";
						if ( 'Yes' === $personally_matched ) {
							$style = "style='display:block;'";
						}
						?>
						
						<div class="ifyes" <?php echo $style; ?>< >

							<div class="wkdo_sibling  wkdo_radio_flex flex-direction" >
								<label class="wkdo-label" for="input_2_18"><?php esc_html_e( ' Are you open to meeting/speaking with the recipient(s) before donation?', 'wpdonor' ); ?></label>
								<?php $meeting_with_rec = ! empty( $user_data['meeting_with_rec'] ) ? $user_data['meeting_with_rec'] : ''; ?>

								<select name="meeting_with_rec" id="meeting_with_rec" style="width: 100%;" >
									<option <?php selected( $meeting_with_rec, 'Yes' ); ?> value="Yes">Yes</option>
									<option <?php selected( $meeting_with_rec, 'No' ); ?> value="No">No</option>
									<option <?php selected( $meeting_with_rec, 'Maybe' ); ?> value="Maybe">Maybe</option>
								</select>
							</div>

							<div class="wkdo_sibling  wkdo_radio_flex flex-direction" >
								<label class="wkdo-label" for="input_2_18"><?php esc_html_e( ' Are you willing to donate directly to Match Me’s donor bank (no recipient matching required)', 'wpdonor' ); ?></label>
								<?php $donate_directly = ! empty( $user_data['donate_directly'] ) ? $user_data['donate_directly'] : ''; ?>

								<select name="donate_directly" id="donate_directly" style="width: 100%;" >
									<option <?php selected( $donate_directly, 'Yes' ); ?> value="Yes">Yes</option>
									<option <?php selected( $donate_directly, 'No' ); ?> value="No">No</option>
								</select>
							</div>



							<div class="wkdo_sibling  wkdo_radio_flex flex-direction" >
								<label class="wkdo-label" for="input_2_18"><?php esc_html_e( ' Are you open to meeting/speaking with the recipient(s) before donation?', 'wpdonor' ); ?></label>
								<?php $meeting_with_rec = ! empty( $user_data['meeting_with_rec'] ) ? $user_data['meeting_with_rec'] : ''; ?>

								<select name="meeting_with_rec" id="meeting_with_rec" style="width: 100%;" >
									<option <?php selected( $meeting_with_rec, 'Yes' ); ?> value="Yes">Yes</option>
									<option <?php selected( $meeting_with_rec, 'No' ); ?> value="No">No</option>
									<option <?php selected( $meeting_with_rec, 'Maybe' ); ?> value="Maybe">Maybe</option>
								</select>
							</div>

							<hr>
							<h2> Enhanced Family & Medical History (For Personalized Matching)</h2>
							<?php $genetic_conditions = ! empty( $user_data['genetic_conditions'] ) ? $user_data['genetic_conditions'] : 'no'; ?>

							<div class="form-group">
								<label class="wkdo-label" for="input_2_18">Do You Have Any Known Genetic or Hereditary Conditions?</label><br>
								<label class="wkdo-label" for="input_2_18"><input <?php checked( 'yes', $genetic_conditions ); ?> type="radio" name="genetic_conditions" value="yes" required> Yes</label>
								<label class="wkdo-label" for="input_2_18"><input <?php checked( 'no', $genetic_conditions ); ?> type="radio" name="genetic_conditions" value="no"> No</label>
							</div>

							<div class="form-group" id="genetic-details" style="display: none;">
								<?php $genetic_details = ! empty( $user_data['genetic_details'] ) ? $user_data['genetic_details'] : ''; ?>
								<label class="wkdo-label" for="input_2_18">Provide Details (Family Members Affected and Diagnoses):</label><br>
								<textarea style="width:100%" name="genetic_details" rows="4" cols="50" placeholder="E.g., Mother - Breast Cancer, Grandfather - Diabetes"><?php echo $genetic_details; ?></textarea>
							</div>

							<!-- Allergies -->
							<div class="form-group">
								<label class="wkdo-label" for="input_2_18">Do You Have Any Allergies?</label><br>
								<?php $allergies = ! empty( $user_data['allergies'] ) ? $user_data['allergies'] : 'no'; ?>
								
								<label class="wkdo-label" for="input_2_18">
									<input <?php checked( 'yes', $allergies ); ?> type="radio" name="allergies" value="yes" required> Yes
								</label>
								
								<label class="wkdo-label" for="input_2_18">
									<input <?php checked( 'no', $allergies ); ?> type="radio" name="allergies" value="no"> No
								</label>
							</div>

							<div class="form-group" id="allergy-details" style="display: none;">
								<label class="wkdo-label" for="input_2_18">List Your Allergies:</label><br>
								<?php $allergy_details = ! empty( $user_data['allergy_details'] ) ? $user_data['allergy_details'] : ''; ?>
								<textarea style="width:100%" name="allergy_details" rows="3" cols="50" placeholder="E.g., Peanuts, Penicillin, Dust"><?php echo $allergy_details; ?></textarea>
							</div>
						</div>

						<div class="wkdo-custom-upload">

								<?php
									$spacil_msg = ! empty( $user_data['wkdo_profile_image'] ) ? $user_data['wkdo_profile_image'] : 'https://png.pngtree.com/png-vector/20221203/ourmid/pngtree-cartoon-style-male-user-profile-icon-vector-illustraton-png-image_6489287.png';
								?>

								<input type="hidden" name="wkdo_profile_image" id="my_custom_image" class="regular-text" value="<?php echo esc_url( $spacil_msg ); ?>">
								<div class="wkdo-profile-image-preview">
									<img src="<?php echo esc_url( $spacil_msg ); ?>" alt="" class="wkdo-profile" width="200" srcset="">
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="upload-btn" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
									
								<?php } ?>
							</div>
							<hr />
							<?php
								$spacil_msg = ! empty( $user_data['wkdo_gallery_image'] ) ? $user_data['wkdo_gallery_image'] : '';
								$img        = ! empty( $spacil_msg ) ? explode( ',', $spacil_msg ) : array();

							?>
							<label class="wkdo-label" for="input_2_18"> Gallery image </label>
							<div class="wkdo-milti-upload-file">
								<input type="hidden" value="<?php echo $spacil_msg; ?>" id="uploaded_images" name="wkdo_gallery_image">
								<div id="image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="upload_images_button" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
							</div>



							<?php
								$Genetic_Screening_Report = ! empty( $user_data['Genetic_Screening_Report'] ) ? $user_data['Genetic_Screening_Report'] : '';
								$img                      = ! empty( $Genetic_Screening_Report ) ? explode( ',', $Genetic_Screening_Report ) : array();

							?>

							<label class="wkdo-label" for="input_2_18">  Upload Your Genetic Screening Report (Optional) </label>
							<div class="wkdo-milti-upload-file">
								
								<input type="hidden" value="<?php echo $Genetic_Screening_Report; ?>" id="Genetic_Screening_Report_image_preview_uploaded_images" name="Genetic_Screening_Report">
								<div id="Genetic_Screening_Report_image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="Genetic_Screening_Report" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
								<br>
							</div>


							<?php
								$Blood_report = ! empty( $user_data['Blood_report'] ) ? $user_data['Blood_report'] : '';
								$img          = ! empty( $Blood_report ) ? explode( ',', $Blood_report ) : array();

							?>

							<label class="wkdo-label" for="input_2_18">  Upload Your Blood Test Results (Optional) </label>
							<div class="wkdo-milti-upload-file">
								
								<input type="hidden" value="<?php echo $Blood_report; ?>" id="Blood_report_image_preview_uploaded_images" name="Blood_report">
								<div id="Blood_report_image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="Blood_report" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
								<br>
							</div>




							<?php
								$medical_history = ! empty( $user_data['medical_history'] ) ? $user_data['medical_history'] : '';
								$img             = ! empty( $medical_history ) ? explode( ',', $medical_history ) : array();

							?>

							<label class="wkdo-label" for="input_2_18">Upload Your Medical History Form (Optional) </label>
							<div class="wkdo-milti-upload-file">
								
								<input type="hidden" value="<?php echo $medical_history; ?>" id="medical_history_preview_uploaded_images" name="medical_history">
								<div id="medical_history_image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="medical_history" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
								<br>
							</div>


								

							<?php
								$psychological_assessment = ! empty( $user_data['psychological_assessment'] ) ? $user_data['psychological_assessment'] : '';
								$img                      = ! empty( $psychological_assessment ) ? explode( ',', $psychological_assessment ) : array();

							?>

							<label class="wkdo-label" for="input_2_18">Upload Your Personality / Psychological Assessment (Optional)</label>
							<div class="wkdo-milti-upload-file">
								
								<input type="hidden" value="<?php echo $psychological_assessment; ?>" id="psychological_assessment_preview_uploaded_images" name="psychological_assessment">
								<div id="psychological_assessment_image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<img src="<?php echo esc_url( $img_url ); ?>" width="150">
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="psychological_assessment" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>

								<br>
							</div>


							<?php
								$short_video = ! empty( $user_data['short_video'] ) ? $user_data['short_video'] : '';
								$img         = ! empty( $short_video ) ? explode( ',', $short_video ) : array();
							?>

							<label class="wkdo-label" for="input_2_18"> Upload Your short introduction video or audio for recipients (Optional)</label>
							<div class="wkdo-milti-upload-file">
								
								<input type="hidden" value="<?php echo $short_video; ?>" id="short_video_preview_uploaded_images" name="short_video">
								<div id="short_video_image_preview">
									<?php
									if ( ! empty( $img ) ) {
										foreach ( $img as $key => $img_url ) {
											?>
												<video width="200" controls style="margin:5px;">
													<source src="<?php echo esc_url( $img_url ); ?>" type="video/mp4">
												</video>
											<?php
										}
									}
									?>
								</div>
								<?php if ( ! is_admin() ) { ?>
									<i id="short_video" class="fa fa-upload wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
							</div>


							<div id="registration-message" style="color:red" ></div>						
							<div class="wkdo-form-section">
								<!-- -->
								<?php
								if ( ! is_admin() ) {
									?>
								<button type="submit" name="wkdo_save_details" class="wkdo-submit-button"><?php esc_html_e( 'Update Profile', 'wpdonor' ); ?></button>
									<?php
								} else {
									?>
								<button type="submit" name="wkdo_save_details" class="wkdo-submit-button"><?php esc_html_e( 'Update Profile', 'wpdonor' ); ?></button>
										<?php
								}
								?>
							</div>
					</div>
				</form>
			</div>
		<?php
	}

	/**
	 * Save the uer details.
	 */
	public function wkd_save_becom_informattion_template() {
		if ( isset( $_POST['wkdo_save_details'] ) ) {
				$user_id = get_current_user_id();
			if ( is_admin() ) {
				// $user_id = ! empty( $_GET['pid'] ) ? $_GET['pid'] : '';
				// if( is_admin( ) ) {
				// 	$user_id = str_replace("D100", "", $user_id);
				// }
				 $user_id = $this->user_id;

			}
			if ( ! empty( $user_id ) ) {
					$data = maybe_unserialize( $_POST );
					update_user_meta( $user_id, 'first_name', $_POST['wkdo_first_name'] );
					update_user_meta( $user_id, 'last_name', $_POST['wkdo_last_name'] );
					update_user_meta( $user_id, 'wkdo_becom_donor', $data );

					update_user_meta( $user_id, 'wkdo_becom_donor', $data );

					update_user_meta( $user_id, 'wkdo_becom_donor_gender', $_POST['wkdo_gender'] );
					update_user_meta( $user_id, 'wkdo_becom_donor_blood', $_POST['wkdo_blood_type'] );
					update_user_meta( $user_id, 'wkdo_becom_donor_eyes', $_POST['do_eye_color'] );
					update_user_meta( $user_id, 'wkdo_becom_donor_hair ', $_POST['do_ha_col'] );

					global $wpdb;
					$table_name          = $wpdb->prefix . 'wdo_donor_user';
					$available_to_donate = ! empty( $_POST['wkdo_avalabl_donate'] ) ? implode( ',', $_POST['wkdo_avalabl_donate'] ) : '';
					$update_data         = array(
						'gender'                  => $_POST['wkdo_gender'],
						'current_location'        => $_POST['wkdo_location'],
						'race'                    => $_POST['wkdo_race'],
						'ethnicity'               => $_POST['wkdo_ethnicity'],
						'donation_preferences'    => $_POST['wkdo_preference'],
						'available_to_donate'     => $available_to_donate,
						'where_donate'            => $_POST['wkdo_account_donor_form'],
						'donation_method'         => $_POST['wkdo_donation_method'],
						'donation_status'         => $_POST['wkdo_donor_status'],
						'have_you_donated_before' => $_POST['wkdo_have_donate_before'],
						'blood_type'              => $_POST['wkdo_blood_type'],
						'height'                  => $_POST['feet'] . '-' . $_POST['inches'],
						'weight'                  => $_POST['wkdo_weight'],
						'hair_color'              => $_POST['wkdo_hair_color'],
						'eye_color'               => $_POST['wkdo_eye_color'],
						'religion'                => $_POST['wkdo_religion'],
						'languages_spoken'        => $_POST['wkdo_lang'],
						'education'               => $_POST['wkdo_education'],
						'occupation'              => $_POST['wkdo_current_occ'],
					);

					$where_conditions = array(
						'user_id' => $user_id,
					);

					$wpdb->update( $table_name, $update_data, $where_conditions, array_fill( 0, count( $update_data ), '%s' ), array( '%d' ) );

					if ( is_admin() ) {
						wp_admin_notice(
							esc_html__( 'User profile updated successfully.', 'wkdo' ),
							array(
								'type'        => 'success',
								'dismissible' => true,
								'id'          => 'message',
							)
						);
					} else {
						wc_print_notice( esc_html__( 'User profile updated successfully.', 'wkdo' ) );
						$data['user_id'] = $user_id;
						// do_action( 'register_donor_trigger', $data );
					}
			}
		}
	}
}
