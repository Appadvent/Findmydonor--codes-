<?php
/**
 * Front hooks.
 */

class Wkdo_Front {
	/**
	 * Add script
	 */
	public function front_scripts_method() {
		wp_enqueue_media();
		wp_enqueue_script( 'wkdo-front-script', WKDO_PLUGIN_URI . '/assets/front/front.js', array( 'jquery' ), '8.0.1', true );
		wp_enqueue_style( 'wkdsdo-front-style', WKDO_PLUGIN_URI . 'assets/front/front.css', array(), '5.0.4', 'all' );
		$user_id = (int) ! empty( $_GET['userid'] ) ? trim( str_replace( 'D100', '', $_GET['userid'] ) ) : 0;

		wp_enqueue_script( 'magnific-js', 'https://cdn.jsdelivr.net/npm/magnific-popup/dist/jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'magnific-css', 'https://cdn.jsdelivr.net/npm/magnific-popup/dist/magnific-popup.css' );

		wp_enqueue_style( 'mp-pro-account', site_url('wp-content/plugins/memberpress/css/account.css'), array( ), '1.12.2', true );
		wp_enqueue_style( 'mp-pro-account21', site_url('wp-content/plugins/memberpress/css/readylaunch/theme.css'), array( ), '1.12.2', true );
		wp_enqueue_style( 'mp-pro-account2', site_url('wp-content/plugins/memberpress/css/readylaunch/login.css'), array( ), '1.12.2', true );
		wp_enqueue_style( 'mp-pro-account3', site_url('wp-content/plugins/memberpress/css/readylaunch/fonts.css'), array( ), '1.12.2', true );
		wp_enqueue_style( 'mp-pro-account4', site_url('wp-content/plugins/memberpress/css/readylaunch/account.css'), array( ), '1.12.2', true );
		wp_enqueue_script( 'mp-pro-account5', site_url('wp-content/plugins/memberpress/js/vendor/popper.min.js'), array( 'jquery' ), '1.12.2', false );
		wp_enqueue_script( 'mp-pro-account6', site_url('wp-content/plugins/memberpress/js/vendor/alpine.min.js'), array( 'jquery' ), '1.12.2', false );
		wp_enqueue_script( 'mp-pro-account7', site_url('wp-content/plugins/memberpress/js/readylaunch/account.js'), array( 'jquery' ), '1.12.2', false );
		$current_user = wp_get_current_user();

		wp_localize_script(
			'wkdo-front-script',
			'wkdoscript',
			array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'pid'       => $user_id,
				'user_name' => $current_user->display_name,
				'nonce'     => wp_create_nonce( 'wdo_booking_nonce' ),
				'site_url'  => site_url(),
			)
		);
	}

	/**
	 * Add custom profile tabe.
	 */
	public function custom_add_profile_tab() {
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;
		if ( in_array( 'donor', $roles ) ) {
			bp_core_new_nav_item(
				array(
					'name'                => 'Donor profile',
					'slug'                => 'donor-profile',
					'position'            => 1,
					'screen_function'     => array( $this, 'custom_tab_content' ),
					'default_subnav_slug' => 'Profile',
				)
			);
		} elseif ( in_array( 'recipient', $roles ) ) {
			bp_core_new_nav_item(
				array(
					'name'                => 'Recipient profile',
					'slug'                => 'recipient',
					'position'            => 1,
					'screen_function'     => array( $this, 'recipient_tab_content' ),
					'default_subnav_slug' => 'Profile',
				)
			);
		}
	}

	/**
	 * Recipient tab content.
	 */
	public function recipient_tab_content() {
		add_action( 'bp_template_content', array( $this, 'custom_tab_recipient_display' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Display content.
	 */
	public function custom_tab_recipient_display() {
		if ( ! empty( $_GET['edit_ricipient'] ) ) {
			$this->wkdo_show_recipeint_edit_content();
		} else {
			?>
			<a class="wkdo_edit_profile" href="<?php echo site_url( 'my-account/recipient-profile/?edit_ricipient=edit_ricipient' ); ?>">Edit Profile <i class="fas fa-user-edit"></i></a>
			<?php
			$this->show_re_pr_data( get_current_user_id() );

		}
	}

	public function show_re_pr_data( $user_id ) {
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
								<tr>
									<th> Application Type: </th>
									<td><?php echo ! empty( $user_data['application_type'] ) ? $user_data['application_type'] : ''; ?></td>
								</tr>
								<?php if (  ! current_user_can( 'donor' ) ) { ?>
								<tr>
									<th> First name: </th>
									<td> <?php echo !empty($user_data['wkdo_first_name']) ? $user_data['wkdo_first_name'] : get_user_meta( $user_id, 'first_name', true ) ; ?></td>
								</tr>

								<tr>
									<th> Last name: </th>
									<td> <?php echo ! empty( $user_data['wkdo_last_name'] ) ? $user_data['wkdo_last_name'] : get_user_meta( $user_id, 'last_name', true ); ?> </td>
								</tr>
							<?php 
							
								}
							
							if ( ! isset( $_GET['reuserp'] ) ) { ?>
								<tr>
									<th> Phone: </th>
									<td>  <?php echo ! empty( $user_data['phone'] ) ? $user_data['phone'] : ''; ?></td>
								</tr>

								<tr>
									<th> Email: </th>
									<td>  <?php echo ! empty( $user_data['email'] ) ? $user_data['email'] : ''; ?></td>
								</tr>
								<?php } ?>
								
								<?php if (  ! current_user_can( 'donor' ) ) {  ?>
								<tr>
									<th> Date of Birth: </th>
									<td> <?php echo $dob; ?> </td>
								</tr>
                                <?php } ?>
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


				<div class="wkdv-col wkdv-col-1" >
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
					<div class="wkdv-col wkdv-col-1" >
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


	public function wkdo_show_recipeint_edit_content() {
		$object = new Wkdo_Recipient( get_current_user_id() );
		$object->wkdo_recipient_content();
	}

	/**
	 * Save user details.
	 */
	public function wkdo_register_user() {
		$obj = new Wkdo_Become_Donor();
		$obj->wkdo_register_user();
	}

	/**
	 * Add custom tab content.
	 */
	public function custom_tab_content() {
		add_action( 'bp_template_content', array( $this, 'custom_tab_content_display' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Display coustom content.
	 */
	public function custom_tab_content_display() {
		echo '<div class="Profile-content">';
		$user_id = get_current_user_id();
		$obj     = new Wkdo_Become_Donor( $user_id );
		$obj->wkdo_donor_content();
		echo '</div>';
	}

	/**
	 * Remove profile.
	 */
	public function custom_remove_profile_tabs() {
		global $bp;
		bp_core_remove_nav_item( 'profile' ); // Remove the Profile tab.
	}

	/**
	 * Become a donor form.
	 *
	 * @return string.
	 */
	public function wkdo_donor_form_shortcode() {
		$object    = new Wkdo_Become_Donor();
		$user      = wp_get_current_user();
		$user_name = ! empty( $user->user_login ) ? $user->user_login : '';
		if ( current_user_can( 'donor' ) ) {
			$login_url = Site_url( 'my-account' );
		} else {
			$login_url = Site_url( 'my-account' );
		}
		ob_start();
		if ( ! current_user_can( 'administrator' ) ) {
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
				$status  = get_user_meta( $user_id, 'wkdo_becom_donor_status', true );
				if ( empty( $status ) ) {
					$object->wkdo_registration();
				} elseif ( 'pending' === $status ) {
					$login_button = '<a href="' . esc_url( $login_url ) . '" class="button wc-login-button">' . esc_html__( 'View Profile', 'woocommerce' ) . '</a>';
					wc_print_notice(
						esc_html__( 'Your account is created kindly complete your profile ', 'woocommerce' ) . ' ' . $login_button,
						'notice'
					);
				} elseif ( 'approved' === $status ) {
					$login_button = '<a href="' . esc_url( $login_url ) . '" class="button wc-login-button">' . esc_html__( 'View Profile', 'woocommerce' ) . '</a>';
					wc_print_notice(
						esc_html__( 'Your account is approved. Thank you for your patience! ', 'woocommerce' ) . ' ' . $login_button,
						'success'
					);
				} elseif ( 'rejected' === $status ) {
					wc_print_notice( esc_html__( 'Your account is rejected kindly discuss with team.' ), 'success' );
				}
			} else {
				$object->wkdo_registration();
			}
		} else {
			wc_print_notice( esc_html__( 'Administrators are not allowed to apply as a donor.' ), 'error' );
		}

		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * Match form.
	 */
	public function wkdo_donor_match_form() {
		$object = new Wkdo_match();
		return $object->wkdo_match();
	}

	/**
	 * Show user list.
	 */
	public function wkdo_donor_user_list() {
		$data = new Wkdo_USER_List();
		if ( ! empty( $_GET['userp'] ) ) {
			$data->view_user_profile();
		} else {
			return $data->profile_list();
		}
	}

	/**
	 * Add custom roll.
	 */
	public function wkdo_add_donor_profile_endpoint() {
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		if ( in_array( 'donor', $roles ) ) {
			add_rewrite_endpoint( 'donor-profile', EP_PAGES );
			add_rewrite_endpoint( 'interest_recipent', EP_PAGES );
			add_rewrite_endpoint( 'customer_chat', EP_PAGES );
		}

		if ( in_array( 'recipient', $roles ) ) {
			add_rewrite_endpoint( 'recipient-profile', EP_PAGES );
			add_rewrite_endpoint( 'interest_user', EP_PAGES );
			add_rewrite_endpoint( 'member_ship_list', EP_PAGES );
			add_rewrite_endpoint( 'customer_chat', EP_PAGES );
		}
	}

	/**
	 * Add menu name in list.
	 *
	 * @param array $items items.
	 */
	public function wkdo_add_donor_profile_menu_item( $items ) {
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		if ( in_array( 'donor', $roles ) ) {
			$new_items = array();
			if ( empty( $items['donor-profile'] ) ) {
				$new_items['donor-profile'] = __( 'My Profile', 'woocommerce' );
			}
			$new_items['interest_recipent'] = __( 'Shortlisted Recipient', 'woocommerce' );
			$new_items['customer_chat'] = __( 'Chat', 'woocommerce' );
			$items                          = $new_items + $items;
		}

		if ( in_array( 'recipient', $roles ) ) {
			$new_items = array();
			if ( empty( $items['recipient-profile'] ) ) {
				$new_items['recipient-profile'] = __( 'My Profile', 'woocommerce' );
			}
			$new_items['interest_user']    = __( 'Shortlisted Donors', 'woocommerce' );
			$new_items['member_ship_list'] = __( 'Subscription', 'woocommerce' );
			$new_items['customer_chat'] = __( 'Chat', 'woocommerce' );

			$items = $new_items + $items;
		}

		return $items;
	}

	public function wkdo_member_ship_list_recipient() {
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		if ( in_array( 'recipient', $roles ) ) {
			// echo '<div id="mepr-account-content" class="mp_wrapper">';
			// 	$this->subscriptions();
			// 	echo '</div>';

			?>
			<style>
				div#mepr-account-nav {
    				display: flex;
				}
				span.mepr-nav-item.mepr-home {
					display : none !important;
				}
				a#mepr-account-logout {
    display: none !important;
}
			</style>
			<?php

			$account_ctrl = MeprCtrlFactory::fetch('account');
                       echo $content      = $account_ctrl->display_account_form();


		} else {
			echo '<p>' . __( 'This section is only available for recipients.', 'woocommerce' ) . '</p>';
		}
	}

	public function subscriptions( $message = '', $errors = array(), $args = array() ) {
		global $wpdb;
		$mepr_current_user = MeprUtils::get_currentuserinfo();
		$mepr_options      = MeprOptions::fetch();
		$account_url       = $_SERVER['REQUEST_URI']; // Use URI for BuddyPress compatibility
		$delim             = MeprAppCtrl::get_param_delimiter_char( $account_url );
		$perpage           = MeprHooks::apply_filters( 'mepr_subscriptions_per_page', 10 );
		$curr_page         = ( isset( $_GET['currpage'] ) && is_numeric( $_GET['currpage'] ) ) ? $_GET['currpage'] : 1;
		$start             = ( $curr_page - 1 ) * $perpage;
		$end               = $start + $perpage;

		// This is necessary to optimize the queries ... only query what we need
		$sub_cols = array( 'id', 'user_id', 'product_id', 'subscr_id', 'status', 'created_at', 'expires_at', 'active' );

		if ( isset( $args['mode'] ) && 'readylaunch' == $args['mode'] ) {
			$perpage = isset( $args['count'] ) ? $args['count'] + $perpage : $perpage;
		}

		$table = MeprSubscription::account_subscr_table(
			'created_at',
			'DESC',
			$curr_page,
			'',
			'any',
			$perpage,
			false,
			array(
				'member'   => $mepr_current_user->user_login,
				'statuses' => array(
					MeprSubscription::$active_str,
					MeprSubscription::$suspended_str,
					MeprSubscription::$cancelled_str,
				),
			),
			$sub_cols
		);

		$subscriptions = $table['results'];
		$all           = $table['count'];
		$next_page     = ( ( $curr_page * $perpage ) >= $all ) ? false : $curr_page + 1;
		$prev_page     = ( $curr_page > 1 ) ? $curr_page - 1 : false;

		if ( $mepr_options->design_enable_account_template ) {
			MeprView::render( '/readylaunch/shared/errors', get_defined_vars() );
			MeprView::render( '/readylaunch/account/subscriptions', get_defined_vars() );
		} else {
			MeprView::render( '/shared/errors', get_defined_vars() );
			MeprView::render( '/account/subscriptions', get_defined_vars() );
		}
	}

	/**
	 * Refresh link.
	 */
	public function wkdo_flush_rewrite_rules() {
		flush_rewrite_rules();
	}

	/**
	 * Hide account menu.
	 *
	 * @param array $items items.
	 *
	 * @return array
	 */
	public function custom_remove_my_account_menu_items( $items ) {
		// Remove specific menu items.
		unset( $items['dashboard'] );
		unset( $items['downloads'] );
		unset( $items['edit-address'] );
		unset( $items['payment-methods'] );
		unset( $items['edit-account'] );

		return $items;
	}

	/**
	 * Logout redirect.
	 */
	public function custom_logout_redirect() {
		$redirect_url = site_url( 'my-account' );

		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Login redirect.
	 *
	 * @param string $redirect_url redirect url.
	 * @param object $user user object.
	 */
	public function custom_login_redirect( $redirect_url, $user ) {
		if ( ! empty( $_GET['redirect_url'] ) ) {
			$redirect_url = esc_url( $_GET['redirect_url'] );
		}

		return $redirect_url;
	}


	/**
	 * Select donor by recipient.
	 */
	public function wkdo_select_donor_by_recipient() {

		if ( isset( $_GET['action'] ) && 'send_mail' == $_GET['action'] && ! empty( $_GET['row_id'] ) && ! empty( $_GET['rdid'] ) ) {

			$admin_user = get_users(
				array(
					'role'    => 'administrator',
					'number'  => 1,
					'orderby' => 'ID',
					'order'   => 'ASC',
				)
			);

			$admin_id    = ! empty( $admin_user[0]->ID ) ? $admin_user[0]->ID : 1;
			$admin_email = ! empty( $admin_user[0]->user_email ) ? $admin_user[0]->user_email : 1;
			$order_id    = ! empty( $_GET['row_id'] ) ? $_GET['row_id'] : '';

			if ( current_user_can( 'donor' ) ) {
				$type = 'donor';
			} else {
				$type = 'recipient';
			}

			$rid = ! empty( $_GET['rid'] ) ? $_GET['rid'] : 0;

			$this->save_and_send_mail( $order_id, $admin_id, $admin_id, $type, $rid );

			echo "<div class='wkdo_recipent_converstion' id='wkdo_recipent_converstion' >";

			$data = $this->get_all_conversation();

			foreach ( $data  as $key => $value ) {
				$sender_id  = ! empty( $value['sender'] ) ? $value['sender'] : 0;
				$reciver_id = ! empty( $value['sender'] ) ? $value['sender'] : 0;

				$user         = get_userdata( $sender_id );
				$user_message = ! empty( $value['user_message'] ) ? maybe_unserialize( $value['user_message'] ) : 0;
				echo "<div class='wkdo_user_meassges' >";

				if ( in_array( 'recipient', $user->roles ) ) {
					echo "<div class='wkm-recipient-mail-box' > ";
					echo " <div class='wkdo-send-by-recipent' > recipient";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';
					echo '<div class=wkdo-send-by-re-mess > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';
				} elseif ( in_array( 'donor', $user->roles ) ) {
					echo "<div class='wkm-recipient-mail-box' > ";
					echo " <div class='wkdo-send-by-donor' >Donor";
					echo '</div>';
					echo '<br/>';
					echo '<br/>';
					echo '<div class=wkdo-send-by-re-mess > ';
					echo $user_message['messgae'];
					echo '</div>';
					echo '</div>';
				} else {
					echo "<div class='wkm-admin-mail-box' > ";
					echo " <div class='wkdo-send-by-admin' > Admin";
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
			$this->send_mail_to_admin( $order_id, $admin_email, $type, $admin_id, $rid );

		} elseif ( isset( $_GET['action'] ) && 'caht' == $_GET['action'] && ! empty( $_GET['row_id'] ) && ! empty( $_GET['rdid'] ) ) {
			$this->wkdo_chat_content();
		} elseif ( ! empty( $_GET['douserp'] ) ) {
				$this->wkdo_show_donor_in_recipient_profile( $_GET['douserp'] );
		} elseif ( ! empty( $_GET['reuserp'] ) ) {
			$this->show_re_pr_data( $_GET['reuserp'] );
		} else {
			$this->intrest_donor_list();
		}
	}

	public function wkdo_chat_content() {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_messages';
		if ( current_user_can( 'donor' ) ) {
			$wpdb->query( $wpdb->prepare( "UPDATE $table SET donor_read = %d WHERE group_id = %d", 1, $_GET['row_id'] ) );
		} else{
			$wpdb->query( $wpdb->prepare( "UPDATE $table SET recipient_read = %d WHERE group_id = %d", 1, $_GET['row_id'] ) );
		}

		?>
			<input type="hidden" id="sender_id" value="<?php echo get_current_user_id(); ?>">
			<input type="hidden" id="recipient_id" value="0">
			<input type="hidden" id="donor_id" value="0">
			<input type="hidden" id="group_id" value="<?php echo $_GET['row_id']; ?>">
			<input  type="hidden" id="message" value="Short Message">
			<div class="wkdo-chat-container">
				<div class="wkdo-chat-header">Chat </div>
				<div id="wkdo-chat-body" class="wkdo-chat-body">
					<?php $this->get_all_chat( $_GET['row_id'] ); ?>
				</div>
				<div class="wkdo-chat-footer">
					<input type="text" id="wkcontent" placeholder="Type a message...">
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
	 * Get select donor and recipient list.
	 */
	public function intrest_donor_list() {
		$all_profile = $this->get_interest_profile();
			$i       = 0;
		?>
		<style>
		 @media only screen and (max-width: 600px) {
		    .table-container {
                max-width: 356px !important;
                overflow-x: auto !important;
                display: block !important;
            }
            
            
		 }
		</style>
        <div class="table-container">
			<table>
				<tr>
					<th>Sr No.</th>
					<?php if ( current_user_can( 'donor' ) ) { ?>
						<th>Recipient ID</th>
					<?php } else { ?>
					<th>
						Donor ID
					</th>
					<?php } ?>


					<?php if ( current_user_can( 'donor' ) ) { ?>
						<th>Recipient Name</th>
					<?php } else { ?>
					<th>
						Donor name
					</th>
					<?php } ?>



					<th>Action</th>
					<th>Chat</th>
				</tr>
				<?php foreach ( $all_profile as $key => $value ) { ?>
					<?php ++$i; ?>
				<tr>
					<th><?php echo $i; ?></th>
					<th>
						<?php
						if ( current_user_can( 'donor' ) ) {
							$user_data = get_userdata( $value['rid'] );
							?>
							<a href="<?php echo esc_url( site_url() . '/my-account/interest_recipent?reuserp=' . $user_data->ID ); ?>" > <?php echo esc_html( 'R100' . $user_data->ID ); ?> </a>
							<?php
						} else {
							$user_data = get_userdata( $value['uid'] );
							?>
								<a href="<?php echo esc_url( site_url() . '/donor-search-page/?userp=87&userid='.esc_html( 'D100' . $user_data->ID ) ); ?>" > <?php echo esc_html( 'D100' . $user_data->ID ); ?> </a>
							<?php
						}

						?>
					</th>

					<th>
						<?php
							echo esc_html( $user_data->user_login );

						?>
					</th>


					<?php

					if ( current_user_can( 'donor' ) ) {
						$donor_id = $value['rid'];
						?>
							<th> <a style="background:blue; color:white; border-radius:10px " class="button button-primary" href="<?php echo esc_url( site_url() . '/my-account/interest_recipent?action=send_mail&row_id=' . $value['id'] . '&rdid=' . $donor_id ); ?>" > Send mail </a> </th>
							<th><?php if($this->get_chat_status( $value['id'] )) { ?>
								<a style="background:#bd7100; color:white; border-radius:10px " class="button button-primary" href="<?php echo esc_url( site_url() . '/my-account/interest_recipent?action=caht&row_id=' . $value['id'] . '&rdid=' . $donor_id ); ?>" > Chat </a>
							<?php } ?>  </th>
						<?php
					} else {
						$donor_id = $value['uid'];
						?>
							<th> <a style="background:green; color:white; border-radius:10px " class="button button-primary" href="<?php echo esc_url( site_url() . '/my-account/interest_user?action=send_mail&row_id=' . $value['id'] . '&rdid=' . $value['rid'] ); ?>" > Send mail </a> </th>
							<th> <?php if($this->get_chat_status( $value['id'] )) { ?>
								<a style="background:#bd7100; color:white; border-radius:10px " class="button button-primary" href="<?php echo esc_url( site_url() . '/my-account/interest_user?action=caht&row_id=' . $value['id'] . '&rdid=' . $value['rid'] ); ?>" > Chat </a>
							<?php } ?>
							</th>
						<?php
					}
					?>


				</tr>
				<?php } ?>
			</table>
		</div>

		<?php
	}

	/**
	 * Get chat status.
	 *
	 * @param int $rid request id.
	 */
	public function get_chat_status($rid) {
		global $wpdb;
		$table = $wpdb->prefix . 'wdo_chat_status';
		$data = $wpdb->get_row( "Select * from $table where request_id = '$rid' ", ARRAY_A );

			if ( ! empty( $data ) ) {
				if('enable' == $data['donor_staus']) {
					return true;
				} else {
					return false;
				}
			} else{
				return false;
			}
	}

	/**
	 * Details of donor profile.
	 *
	 * @param int $user_id user id.
	 */
	public function wkdo_show_donor_in_recipient_profile( $user_id ) {
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
								<tr>
									<th> User name: </th>
									<td> <?php echo $user_name; ?></td>
								</tr>

								<!-- <tr>
									<th> Phone: </th>
									<td> <?php echo ! empty( $user_data['phone'] ) ? $user_data['phone'] : ''; ?></td>
								</tr> -->

								<!-- <tr>
									<th> Email: </th>
									<td> <?php echo ! empty( $user_data['email'] ) ? $user_data['email'] : ''; ?> </td>
								</tr> -->

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
									
									echo ! empty( $ethnicity_options[ $user_data['wkdo_race'] ] ) ? $ethnicity_options[ $user_data['wkdo_race'] ] : ''; ?>  </td>
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
	 * Get all interest profile.
	 */
	public function get_interest_profile() {
		global $wpdb;
		$user_id = get_current_user_id();
		if ( current_user_can( 'donor' ) ) {
			$data = $wpdb->get_results( "select * from {$wpdb->prefix}wdo_intrest_user where uid = '$user_id' ", ARRAY_A );
		} else {
			$data = $wpdb->get_results( "select * from {$wpdb->prefix}wdo_intrest_user where rid = '$user_id' ", ARRAY_A );
		}
		return ! empty( $data ) ? $data : array();
	}

	/**
	 * Mail layout.
	 */
	public function send_mail_to_admin( $order_id, $admin_email, $type, $admin_id, $rid ) {
		?>
		<form action="" method="post">
			<div class="wkm-mail-contair" >
				<div class="mail-to" >
					<input type="text" value="<?php echo $admin_email; ?>" class="wkdo_mail_to" name="sent-to" id="" readonly>
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
				<input type="submit" name="wkdo_send_mail" class="button button-primay wkdo_send_mail" value="Send mail">
			</div>

		</form>
		<?php
	}

	/**
	 * Send mail to user.
	 */
	public function save_and_send_mail( $order_id, $to, $mail, $type, $rid ) {
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

			if ( current_user_can( 'donor' ) ) {
				$url = admin_url( 'admin.php?page=all-recipient&action=mail_to_donor&uid=' . $rid . '&row_id=' . $order_id );
			} else {
				$url = admin_url( 'admin.php?page=all-recipient&action=mail_to_recipient&pid=' . $rid . '&row_id=' . $order_id );
			}

			$message = "<b>Hello admin </b><br/> <br/>
				New message received on the conversation kindly check.<br /> <br/>
				<a href = '" . $url . "' style='display: inline-block; background-color: #0073aa; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-weight: bold;' > View Conversation
				</a>
			";
			$headers = array( 'Content-Type: text/html; charset=UTF-8' );

			if ( wp_mail( $to, $subject, $message, $headers ) ) {
				echo '<div class="woocommerce-message">Email sent successfully!</div>';
			} else {
				echo '<div class="woocommerce-error">Failed to send email.</div>';
			}
		}
	}

	/**
	 * Get all conversation.
	 */
	public function get_all_conversation() {
		global $wpdb;
		$table  = $wpdb->prefix . 'wdo_send_mail';
		$row_id = ! empty( $_GET['row_id'] ) ? $_GET['row_id'] : 0;
		$rid    = get_current_user_id();

		if ( current_user_can( 'donor' ) ) {
			$type = 'donor';
		} else {
			$type = 'recipient';
		}

		$data = $wpdb->get_results( "select * from  $table where  ( sender = '$rid' OR reciver = '$rid' ) AND order_id = '$row_id' AND user_type ='$type' ", ARRAY_A );
		return ! empty( $data ) ? $data : array();
	}

	/**
	 * THank you page.
	 */
	public function wkdo_member_thank_you() {
		ob_start();

		$trans_num = sanitize_text_field( $_GET['trans_num'] );
		if ( ! empty( $trans_num ) ) {
			?>
			<style>
				h1.entry-title {
					display: none;
				}
			</style>
			<?php
		}
		// Transaction details fetch karein
		$transaction = MeprTransaction::get_one_by_trans_num( $trans_num );
		$transaction->id;
		$membership_id = $transaction->product_id;
		if(!empty($_GET['membership_id'])) {
			$membership_id = $_GET['membership_id'];
		}

		$membership    = new MeprProduct( $membership_id );

		?>
		<div class="wkdomm-container">
			<div class="wkdomm-header">
				<h1 class="wkdomm-title">Thank you for your purchase</h1>
				<div class="wkdomm-subtitle">Payment Successful</div>
				<div class="wkdomm-order-id">Order: <?php echo $transaction->trans_num; ?></div>
			</div>

			<div class="wkdomm-amount">£<?php echo $membership->price . ' ' . MeprOptions::fetch()->currency; ?> </div>

			<table class="wkdomm-details">
				<tr>
					<th>Description</th>
					<th>Amount</th>
				</tr>
				<tr>
					<td>Premium </td>
					<td>£<?php echo $membership->price . ' ' . MeprOptions::fetch()->currency; ?></td>
				</tr>
				<tr>
					<td>Payment</td>
					<td></td>
				</tr>
				<tr class="wkdomm-total">
					<td>Total</td>
					<td>£<?php echo $membership->price . ' ' . MeprOptions::fetch()->currency; ?></td>
				</tr>
			</table>

			<a href="<?php echo site_url( 'my-account' ); ?>" class="wkdomm-button">Back to home</a>
		</div>

		<?php

		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * Chat tab
	 */
	public function wkdo_member_customer_chat() {
		global $wpdb;
		$user_id = get_current_user_id();
		$query = "SELECT * FROM {$wpdb->prefix}wdo_group_member where user_id = '$user_id' ";
		$data  = $wpdb->get_results( $query, ARRAY_A );
		echo '<div style="overflow-x: auto;">';
		echo "<table>";
		if( !empty($data) ) {
			?>
			<tr>
				<th>Chat ID</th>
				<th>Name</th>
				<th>Chat </th>
			</tr>

			<?php
			$user_id = get_current_user_id();
			
			foreach ( $data as $key => $value ) {
				$row_id = $this->get_group_row_id( $value['group_id'] );

				if( $this->get_chat_status( $row_id ) ) {
					
					$user_data_name = $this->ge_user( $row_id );
				
					?>
						<tr>
							<td>G100<?php echo $row_id; ?></td>
							
							<?php
								if ( current_user_can( 'donor' ) ) {

									$id 			= $user_data_name['rid'];
									$user_data      = get_userdata( $id );
									$first_name     = ! empty( $user_data->first_name ) ? $user_data->first_name : '';
							?>
							<td> <?php echo $first_name; ?> </td>
							<td> <a href="<?php echo site_url('my-account/interest_recipent?action=caht&row_id='.$row_id.'&rdid='.$user_id); ?>" class="button button-primary"> Chat </a> </td>
							<?php } else { 

							$id 			= $user_data_name['uid'];
							$user_data      = get_userdata( $id );
							$first_name     = ! empty( $user_data->first_name ) ? $user_data->first_name : '';
															
															
								?>
								<td> <?php echo $first_name; ?> </td>
								<td> <a href="<?php echo site_url('my-account/interest_user?action=caht&row_id='.$row_id.'&rdid='.$user_id); ?>" class="button button-primary"> Chat </a> </td>
							<?php } ?>
						</tr>
					<?php
				}
			}
		}
		echo "</table>";
		echo "</div>";
	}

	public function get_group_row_id( $id ){

		global $wpdb;
		$query = "SELECT * FROM {$wpdb->prefix}wdo_group where id = '$id' ";
		$data  = $wpdb->get_row( $query, ARRAY_A );

		return !empty( $data['inquery_id'] ) ? $data['inquery_id'] : 0;

	}

	public function ge_user( $id ) {
		
		global $wpdb;
		$user_id = get_current_user_id();
		$query = "SELECT * FROM {$wpdb->prefix}wdo_intrest_user where id = '$id' ";
		$data  = $wpdb->get_row( $query, ARRAY_A );
		return !empty( $data ) ? $data : array();
	}
}

