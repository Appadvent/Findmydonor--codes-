<?php
/**
 * Admin hooks.
 */

class Wkdo_Admin {
	/**
	 * Admin menu.
	 *
	 * @return void
	 */
	public function wkdo_custom_admin_menu() {
		add_menu_page(
			'Donor Dashboard',
			'Donor Dashboard',
			'manage_options',
			'donor-dashboard',
			array( $this, 'wkdo_donor_dashboard_callback' ),
			'-',
			99
		);

		add_submenu_page(
			'donor-dashboard',
			'test',
			'All Donor',
			'manage_options',
			'all-donor',
			array( $this, 'wkdo_add_donor_callback' )
		);

		add_submenu_page(
			'donor-dashboard',
			'test',
			'All Recipient',
			'manage_options',
			'all-recipient',
			array( $this, 'wkdo_add_recipient_callback' )
		);

		add_submenu_page(
			'donor-dashboard',
			'Recipient Query',
			'Recipient Query',
			'manage_options',
			'recipient-query',
			array( $this, 'wkdo_add_recipient_query' )
		);

		add_submenu_page(
			'donor-dashboard',
			'BooKing',
			'BooKing Query',
			'manage_options',
			'booking-query',
			array( $this, 'wkdo_add_booking_query' )
		);
	}


	public function wkdo_donor_dashboard_callback() {
	}

	/**
	 * Add custom css.
	 */
	public function wkdo_enqueue_admin_styles() {

		wp_enqueue_style( 'wkdo-admin-style', WKDO_PLUGIN_URI . 'assets/admin/admin.css', array(), '8.0.1', );
		wp_enqueue_script( 'wkdo-admin-script', WKDO_PLUGIN_URI . 'assets/admin/admin.js', array( 'jquery' ), '8.0.1', true );

		wp_enqueue_script( 'magnific-js', 'https://cdn.jsdelivr.net/npm/magnific-popup/dist/jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'magnific-css', 'https://cdn.jsdelivr.net/npm/magnific-popup/dist/magnific-popup.css' );
		$current_user = wp_get_current_user();
		wp_localize_script(
			'wkdo-admin-script',
			'wkd_ajax_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'user_name' => $current_user->display_name,
			)
		);
		wp_enqueue_editor();
	}

	/**
	 * Add custom css.
	 */
	public function wkdo_custom_admin_css() {
		echo '<style>
            #adminmenu .menu-top.toplevel_page_donor-dashboard .wp-menu-image {
                background: url(" ' . WKDO_PLUGIN_URI . 'assets/images/logo.webp") no-repeat center center !important;
                background-size: contain !important;
            }
        </style>';
	}

	/**
	 * Donor list.
	 */
	public function wkdo_add_donor_callback() {

		$get = ! empty( $_GET ) ? wc_clean( $_GET ) : array();
		if ( ! empty( $get['action'] ) && 'edit_doonor' === $get['action'] && ! empty( $get['pid'] ) ) {
			$this->wkdo_edit_information_by_admin( $get['pid'] );
		} elseif ( ! empty( $get['action'] ) && 'view_donor' === $get['action'] && ! empty( $get['pid'] ) ) {
			$this->wkdo_view_donor_profile();
		} else {
			echo '<div class="wrap"><h1>' . esc_html__( 'Donor List', 'wpdo' ) . '</h1>';
			$donor_list = Wkdo_Donor_List::get_instance();
			$donor_list->wksa_prepare();
		}
	}

	/**
	 * All recipient_user.
	 */
	public function wkdo_add_recipient_callback() {
		$get = ! empty( $_GET ) ? wc_clean( $_GET ) : array();
		if ( ! empty( $get['action'] ) && 'edit_recipient' === $get['action'] && ! empty( $get['pid'] ) ) {
			$this->wkdo_edit_recipient( $get['pid'] );
		} elseif ( ! empty( $get['action'] ) && 'view_recipient' === $get['action'] && ! empty( $get['pid'] ) ) {
			$this->wkdo_view_recipent_profile();
		} elseif ( ! empty( $get['action'] ) && 'mail_to_recipient' === $get['action'] && ! empty( $get['pid'] ) && ! empty( $get['row_id'] ) ) {
			new Wkdo_Send_Mail();
		} elseif ( ! empty( $get['action'] ) && 'mail_to_donor' === $get['action'] && ! empty( $get['uid'] ) && ! empty( $get['row_id'] ) ) {

			new Wkdo_Send_Mail();
		} else {
			echo '<div class="wrap"><h1>' . esc_html__( 'Recipient List', 'wkdo' ) . '</h1>';
			$donor_list = Wkdo_Recipient_List::get_instance();
			$donor_list->wksa_prepare();
		}
	}

	/**
	 * Edit user profile.
	 *
	 * @param int $user_id user id.
	 */
	public function wkdo_edit_information_by_admin( $user_id ) {
		$object = new Wkdo_Become_Donor( $user_id );
		$object->wkdo_donor_content();
	}

		/**
		 * Edit user profile.
		 *
		 * @param int $user_id user id.
		 */
	public function wkdo_edit_recipient( $user_id ) {
		$object = new Wkdo_Recipient( $user_id );
		$object->wkdo_recipient_content();
	}

	/**
	 * View user profile.
	 */
	public function wkdo_view_donor_profile() {
		if ( isset( $_POST['wdo_submit'] ) ) {
			$user_id = ! empty( $_GET['pid'] ) ? $_GET['pid'] : '';
			$status  = ! empty( $_POST['user_status'] ) ? $_POST['user_status'] : '';
			if ( ! empty( $status ) && ! empty( $user_id ) ) {
				update_user_meta( $user_id, 'wkdo_becom_donor_status', $status );
				echo '<div class="updated"><p>' . esc_html__( 'Status updated successfully.', 'wpdo' ) . '</p></div>';
			}
		}
		$user_id   = ! empty( $_GET['pid'] ) ? $_GET['pid'] : '';

		if(is_admin()) {
			$user_id = (int) str_replace("D100", "", $user_id);

		}
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
									<th> Donor ID: </th>
									<td> <?php echo $_GET['pid']; ?></td>
								</tr>
								<tr>
									<th> First name: </th>
									<td> <?php echo !empty($user_data['wkdo_first_name']) ? $user_data['wkdo_first_name'] : get_user_meta( $user_id, 'first_name', true ) ; ?></td>
								</tr>

								<tr>
									<th> Last name: </th>
									<td> <?php echo !empty($user_data['wkdo_last_name']) ? $user_data['wkdo_last_name'] : get_user_meta( $user_id, 'last_name', true ) ; ?> </td>
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
									<td>
									<?php 
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
	 * View user profile.
	 */
	public function wkdo_view_recipent_profile() {
				$user_id   = ! empty( $_GET['pid'] ) ? $_GET['pid'] : '';
				if( is_admin() ) {
					$user_id = (int) str_replace("R100", "", $user_id);
				}

				$user_data = get_user_meta( $user_id, 'wkdo_becom_donor', true );
				$user_data = ! empty( $user_data ) ? $user_data : array();
				$user_name = get_user_meta( $user_id, 'first_name', true ) . ' ' . get_user_meta( $user_id, 'last_name', true );
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

							<?php 
								if( is_admin() ) {
									?>
									<tr>
									<th> Recipient ID: </th>
									<td> <?php echo $_GET['pid']; ?></td>

									<?php
								}


?>
								<tr>
									<th> Application Type: </th>
									<td><?php echo ! empty( $user_data['application_type'] ) ? $user_data['application_type'] : ''; ?></td>
								</tr>
								
								<tr>
									<th>First name</th>
									<td><?php echo !empty($all_data['wkdo_first_name']) ? $all_data['wkdo_first_name'] : get_user_meta( $user_id, 'first_name', true ); ?></td>
								</tr>

								<tr>
									<th>Last name</th>
									<td><?php echo  !empty($all_data['wkdo_last_name']) ? $all_data['wkdo_last_name'] : get_user_meta( $user_id, 'last_name', true ); ?></td>
								</tr>

								<tr>
									<th> Phone: </th>
									<td>  <?php echo ! empty( $user_data['phone'] ) ? $user_data['phone'] : ''; ?></td>
								</tr>

								<tr>
									<th> Email: </th>
									<td>  <?php echo ! empty( $user_data['email'] ) ? $user_data['email'] : ''; ?></td>
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
									<td> <?php echo ! empty( $user_data['wkido-place-birth'] ) ? $user_data['wkido-place-birth'] : ''; ?></td>
								</tr>

								<tr>
									<th> Nationality: </th>
									<td> <?php echo ! empty( $user_data['wkdo_location'] ) ? $user_data['wkdo_location'] : ''; ?> </td>
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
									
									echo ! empty( $ethnicity_options[ $user_data['wkdo_race'] ] ) ? $ethnicity_options[ $user_data['wkdo_race'] ] : ''; ?>  </td>
								</tr>

								<tr>
									<th> Ethnicity: </th>
									<td> <?php echo ! empty( $user_data['wkdo_ethnicity'] ) ? $user_data['wkdo_ethnicity'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Relationship Status: </th>
									<td> <?php echo ! empty( $user_data['wkdo_re_status'] ) ? $user_data['wkdo_re_status'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Current Location: </th>
									<td> <?php echo ! empty( $user_data['wkdo_c_location'] ) ? $user_data['wkdo_c_location'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Willing to Accept a Donor From: </th>
									<td> <?php echo ! empty( $user_data['input_15'] ) ? $user_data['input_15'] : ''; ?> </td>
								</tr>

							</table>
						</div>
					</div>

					<div class="wkdv-col wkdv-col-1" >
						<div class="wkdv-title" >Donor  Preferences </div>

						<table class="wkdv-profile-table" >
							<tr>
								<th> What Type of Donor Are You Looking For: </th>
								<td> <?php echo ! empty( $user_data['type_donor'] ) ? $user_data['type_donor'] : ''; ?></td>
							</tr>

							<tr>
								<th> Preferred Donor Ethnicity: </th>
								<td> <?php echo ! empty( $user_data['donor_ethnicity'] ) ? implode( ',', $user_data['donor_ethnicity'] ) : ''; ?> </td>
							</tr>

							<tr>
								<th> Preferred Donor Blood Type: </th>
								<td> <?php echo ! empty( $user_data['wkdo_blood_type'] ) ? implode( ',', $user_data['wkdo_blood_type'] ) : ''; ?></td>
							</tr>

							<tr>
								<th> Preferred Donor Eye Color: </th>
								<td> <?php echo ! empty( $user_data['do_eye_color'] ) ? implode( ',', $user_data['do_eye_color'] ) : ''; ?> </td>
							</tr>

							<tr>
								<th> Preferred Donor Hair Color: </th>
								<td> <?php echo ! empty( $user_data['do_ha_col'] ) ? implode( ',', $user_data['do_ha_col'] ) : ''; ?></td>
							</tr>

							<tr>
								<th> Preferred Donor Religion: </th>
								<td> <?php echo ! empty( $user_data['don_reli'] ) ? implode( ',', $user_data['don_reli'] ) : ''; ?> </td>
							</tr>

							<tr>
								<th> Height Preference (cm or ft/in): </th>
								<td> <?php echo ! empty( $user_data['do_height'] ) ? $user_data['do_height'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Weight Preference (cm or ft/in): </th>
								<td> <?php echo ! empty( $user_data['donor_weight'] ) ? $user_data['donor_weight'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Preferred Donor Education Level: </th>
								<td> <?php echo ! empty( $user_data['donor_education'] ) ? implode( ', ', $user_data['donor_education'] ) : ''; ?> </td>
							</tr>

							<tr>
								<th> Do You Want a Donor Who Is Open to Contact?: </th>
								<td> <?php echo ! empty( $user_data['oprn_to_contsct'] ) ? $user_data['oprn_to_contsct'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Would You Prefer a Donor with Proven Fertility (Has Biological Children)?: </th>
								<td> <?php echo ! empty( $user_data['biological_child'] ) ? $user_data['biological_child'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Do you prefer a first-time donor or an experienced donor?: </th>
								<td> <?php echo ! empty( $user_data['like-person-type'] ) ? $user_data['like-person-type'] : ''; ?>  </td>
							</tr>
						</table>

					</div>
				</div>


				<div class="wkdv-col wkdv-col-1"  style="width:100% !important" >
					<div class="wkdv-title" >Donation Preferences </div>

						<table class="wkdv-profile-table" >
							<tr>
								<th> Preferred Donation Method: </th>
								<td> <?php echo ! empty( $user_data['wkDonor'] ) ? implode( ',', $user_data['wkDonor'] ) : ''; ?></td>
							</tr>

							<tr>
								<th> Would You Accept: </th>
								<td> <?php echo ! empty( $user_data['wkdoaccpt'] ) ? implode( ',', $user_data['wkdoaccpt'] ) : ''; ?> </td>
							</tr>

							<tr>
								<th> Are You Looking for a Donor Who Will Play a Role in the Child’s Life?: </th>
								<td> <?php echo ! empty( $user_data['donor_rool_for_childe'] ) ? $user_data['donor_rool_for_childe'] : ''; ?></td>
							</tr>

							<tr>
								<th> Would You Like Updates on the Donor's Medical History Over Time?: </th>
								<td> <?php echo ! empty( $user_data['donor_medical_history'] ) ? $user_data['donor_medical_history'] : ''; ?> </td>
							</tr>

							<tr>
								<th> Do you already have a fertility clinic selected? </th>
								<td> 
								<?php
								echo $clininc_status = ! empty( $user_data['select_fertiity_clicinc'] ) ? $user_data['select_fertiity_clicinc'] : '';
								?>
								</td>
							</tr>
							<?php if ( 'Yes' === $clininc_status ) { ?>
								<tr>
								<th> Fill the name of fertility clinic </th>
								<td> 
								<?php
								echo ! empty( $user_data['selected_clinic_name'] ) ? $user_data['selected_clinic_name'] : '';
								?>
								</td>
							</tr>
								<?php } ?>

							<tr>
								<th> Which fertility treatments are you considering?: </th>
								<td> <?php echo ! empty( $user_data['type_fertility_treatments'] ) ? implode( ',', $user_data['type_fertility_treatments'] ) : ''; ?> </td>
							</tr>
						</table>

					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Tell Us About You </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['short_bio'] ) ? $user_data['short_bio'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > What Are You Looking for in a Donor? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['lookinf_for'] ) ? $user_data['lookinf_for'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > What Would You Like Your Future Child to Know About Their Origin </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['future_child'] ) ? $user_data['future_child'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Do You Have a Parenting Philosophy? (Describe values, beliefs, or approaches you plan to take.) </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['parenting_philosophy'] ) ? $user_data['parenting_philosophy'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > What Hobbies, Interests, or Activities Do You Enjoy? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['doonor_hobies'] ) ? $user_data['doonor_hobies'] : ''; ?> </div>
					</div>
				</div>


				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
						<div class="wkdv-title" > Any Special Message for the Donor? </div>
						<div class="wkdv-about-disc" > <?php echo ! empty( $user_data['spacil_msg'] ) ? $user_data['spacil_msg'] : ''; ?> </div>
					</div>
				</div>

				<div class="wkdv-profile-row" >
					<div class="wkdv-col wkdv-col-1"  style="width:100% !important" >
						<div class="wkdv-title" >Enhanced Matching Preferences </div>

							<table class="wkdv-profile-table" >
								<tr>
									<th> Do You Have Any Genetic Conditions That Should Be Considered?: </th>
									<td> <?php echo ! empty( $user_data['genetic_condition'] ) ? $user_data['genetic_condition'] : ''; ?></td>
								</tr>

								<tr>
									<th> Would You Like to Be Matched with a Donor Who Has a Similar Background to Yours?: </th>
									<td> <?php echo ! empty( $user_data['similr_background'] ) ? $user_data['similr_background'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Would You Be Open to Meeting or speak to Your Donor Before or After Donation?: </th>
									<td> <?php echo ! empty( $user_data['donor_rool_for_childe'] ) ? $user_data['donor_rool_for_childe'] : ''; ?></td>
								</tr>

								<tr>
									<th> Would You Like Updates on the Donor's Medical History Over Time?: </th>
									<td> <?php echo ! empty( $user_data['meeting_with_donor'] ) ? $user_data['meeting_with_donor'] : ''; ?> </td>
								</tr>

								<tr>
									<th> Do you already have a fertility clinic selected? </th>
									<td> 
									<?php
									echo $clininc_status = ! empty( $user_data['select_fertiity_clicinc'] ) ? $user_data['select_fertiity_clicinc'] : '';
									?>
									</td>
								</tr>
								
								<tr>
									<th> Are You Interested in Connecting with Other Recipients Who Have Used the Same Donor?: </th>
									<td> <?php echo ! empty( $user_data['same-donor'] ) ? $user_data['same-donor'] : ''; ?> </td>
								</tr>
							</table>

						</div>
					</div>

				<?php
					$spacil_msg = ! empty( $user_data['wkdo_gallery_image'] ) ? $user_data['wkdo_gallery_image'] : '';
					$img        = ! empty( $spacil_msg ) ? explode( ',', $spacil_msg ) : array();

				?>
					<div class="wkdv-profile-row" >
						<div class="wkdv-col wkdv-col-1 wkdv-col-2 " >
							<div class="wkdv-title" >  Gallery Images </div>
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
							</div>
						</div>
					</div>
				</div>


				
			</div>
		<?php
	}

	/**
	 * Recipient query.
	 */
	public function wkdo_add_recipient_query() {
		global $wpdb;
		if ( 'chat_with_user' == $_GET['action'] ) {
			$table = $wpdb->prefix . 'wdo_messages';
			$wpdb->query( $wpdb->prepare( "UPDATE $table SET admin_read = %d WHERE group_id = %d", 1, $_GET['group_id'] ) );

			?>
			<input type="hidden" id="sender_id" value="<?php echo get_current_user_id(); ?>">
			<input type="hidden" id="recipient_id" value="0">
			<input type="hidden" id="donor_id" value="0">
			<input type="hidden" id="group_id" value="<?php echo esc_attr( $_GET['group_id'] ); ?>">
			<input  type="hidden" id="message" value="Short Message">
			<div class="wkdo-chat-container">
				<div class="wkdo-chat-header">Chat</div>
				<div id="wkdo-chat-body" class="wkdo-chat-body">
					<?php $this->get_all_chat( $_GET['group_id'] ); ?>
				</div>
				<div class="wkdo-chat-footer">
					<input type="text" id="content" placeholder="Type a message...">
					<button id="wkd_send_message" >Send</button>
				</div>
			</div>

			<?php
			$current_user = wp_get_current_user();
			?>
			<script>
				const user = {
					name: "<?php echo esc_js( $current_user->display_name ); ?>",
					role: "<?php echo esc_js( $current_user->roles[0] ?? 'guest' ); ?>"
				};
			</script>

			<?php
		} else {
			?>
			<h3>Interest profile buy Recipient</h3>
			<?php
			$obj = new Wkdo_Recipient_Query();
			$obj->wksa_prepare();
		}
	}

	/**
	 * Group Chat.
	 */
	public function get_all_chat( $group_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_messages';
		$data  = $wpdb->get_results( "select * from $table where group_id = '$group_id' ", ARRAY_A );

		foreach ( $data as $details ) {
			$sender_id    = $details['sender_id'];
			$recipient_id = $details['recipient_id'];
			$donor_id     = $details['donor_id'];
			$message      = $details['content'];
			$created_at   = $details['created_at'];
			$user_d       = get_userdata( $sender_id );
			if ( $sender_id == get_current_user_id() ) {
				?>
				<div class="wkdo-message wkdo-sent">
					<span class="username"><?php echo esc_html( $user_d->display_name ); ?></span>
					<?php echo esc_html( $message ); ?>
				</div>
				<?php
			} else {
				?>
				<div class="wkdo-message wkdo-received">
					<span class="username"><?php echo esc_html( $user_d->display_name ); ?></span>
					<?php echo esc_html( $message ); ?>
				</div>
				<?php
			}
		}
	}

	/**
	 * Booking query.
	 */
	public function wkdo_add_booking_query() {
		?>
		<h3>Booking Details</h3>
		<?php
		$obj = new Wkdo_User_Booking();
		$obj->wksa_prepare();
		echo 'hello';
	}
}
