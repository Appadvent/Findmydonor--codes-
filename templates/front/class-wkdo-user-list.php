<?php
/**
 * Front hooks.
 */

class Wkdo_USER_List {
	/**
	 * Construct function.
	 */
	public function profile_list() {
		ob_start();
		$donor_type = array(
			'sperm'  => 'Sperm',
			'egg'    => 'Egg Donor',
			'embryo' => 'Embryo',
		);

		$eyes_color = array(
			'brown'      => 'Brown',
			'dark Brown' => 'Dark Brown / Almost Black',
			'hazel'      => 'Hazel',
			'amber'      => 'Amber',
			'green'      => 'Green',
			'blue'       => 'Blue',
			'gray'       => 'Gray',
		);

		$race = array(
			'caucasian'     => 'Caucasian',
			'african'       => 'African',
			'asian'         => 'Asian',
			'hispanic'      => 'Hispanic/Latino',
			'middleeastern' => 'Middle Eastern',
			'pacific'       => 'Pacific Islander',
			'indigenous'    => 'Indigenous',
			'mixed'         => 'Mixed Race',
		);

		$ethnicity = array(
			'british'  => 'British',
			'irish'    => 'Irish',
			'italian'  => 'Italian',
			'german'   => 'German',
			'french'   => 'French',
			'chinese'  => 'Chinese',
			'indian'   => 'indian',
			'japanese' => 'Japanese',
			'nigerian' => 'Nigerian',
			'arab'     => 'Arab',
			'jewish'   => 'jewish',
			'mixed'    => 'Mixed Ethnicity',
			'other'    => 'Other',
		);

		$height_list = array(
			'below_5ft' => 'Below 5\'0" (152 cm)',
			'5ft_5ft4'  => '5\'0" - 5\'4" (152 - 163 cm)',
			'5ft5_5ft8' => '5\'5" - 5\'8" (165 - 173 cm)',
			'5ft9_6ft'  => '5\'9" - 6\'0" (175 - 183 cm)',
			'above_6ft' => 'Above 6\'0" (183+ cm)',
		);

		$hair_colors = array(
			'black'             => 'Black',
			'dark-brown'        => 'Dark Brown',
			'brown'             => 'Brown',
			'auburn'            => 'Auburn',
			'chestnut'          => 'Chestnut',
			'red/ginger'        => 'Red / Ginger Blonde',
			'strawberry_blonde' => 'Strawberry Blonde',
			'dirty_blonde'      => 'Dirty Blonde / Ash Blonde',
			'platinum'          => 'Platinum Blonde / White Blonde Gray / Silver',
			'white'             => 'White',
		);

		$blood_list = array(
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
		<style>.container { max-width: 1400px;}</style>
			<div class="wps-section">
				<div class="wps-filtter" style="width:22%; background-color: white; height: 1000px;">
					<div class="wkdp-form-filter" >
						<form action="<?php echo site_url( 'donor-search-page' ); ?>">

							<div class="wdpo-wrap">
								<button class="wdpo-button" >Donor Type</button>
								<div class="wdpo-select">
									<?php foreach ( $donor_type as $key => $donor_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $donor_name ); ?>">
										<?php
										$dot_type = ! empty( $_GET['DonorType'] ) ? $_GET['DonorType'] : '';
										if ( is_array( $dot_type ) && in_array( $key, $dot_type ) ) {
											$checked = 'checked';
										} else {
											$checked = '';
										}
										?>
										<input <?php echo esc_attr( $checked ); ?> name="DonorType[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $donor_name ); ?>" type="checkbox" >
										<?php echo esc_html( $donor_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>


							<div class="wdpo-wrap">
								<button class="wdpo-button" >Eyes Color</button>
								<div class="wdpo-select">
									<?php foreach ( $eyes_color as $key => $eyes_color_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $eyes_color_name ); ?>">
										<?php
										$select_eyes = ! empty( $_GET['DonorEyeColor'] ) ? $_GET['DonorEyeColor'] : '';
										if ( is_array( $select_eyes ) && in_array( $key, $select_eyes ) ) {
											$eyes_checked = 'checked';
										} else {
											$eyes_checked = '';
										}
										?>
										<input <?php echo esc_attr( $eyes_checked ); ?> name="DonorEyeColor[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $eyes_color_name ); ?>" type="checkbox" >
										<?php echo esc_html( $eyes_color_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>

							<div class="wdpo-wrap">
								<button class="wdpo-button" >Race</button>
								<div class="wdpo-select">
									<?php foreach ( $race as $key => $race_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $race_name ); ?>">
										<?php
										$DonorRace = ! empty( $_GET['DonorRace'] ) ? $_GET['DonorRace'] : '';
										if ( is_array( $DonorRace ) && in_array( $key, $DonorRace ) ) {
											$race_checked = 'checked';
										} else {
											$race_checked = '';
										}
										?>
										<input <?php echo esc_attr( $race_checked ); ?> name="DonorRace[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $race_name ); ?>" type="checkbox" >
										<?php echo esc_html( $race_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>


							<div class="wdpo-wrap">
								<button class="wdpo-button" >Ethnicity</button>
								<div class="wdpo-select">
									<?php foreach ( $ethnicity as $key => $ethnicity_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $ethnicity_name ); ?>">
										<?php
											$ethnicity_se = ! empty( $_GET['DonorEthnicity'] ) ? $_GET['DonorEthnicity'] : '';
										if ( is_array( $ethnicity_se ) && in_array( $key, $ethnicity_se ) ) {
											$ethnicity_checked = 'checked';
										} else {
											$ethnicity_checked = '';
										}
										?>
										<input <?php echo esc_attr( $ethnicity_checked ); ?> name="DonorEthnicity[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $ethnicity_name ); ?>" type="checkbox" >
										<?php echo esc_html( $ethnicity_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>



							<div class="wdpo-wrap">
								<button class="wdpo-button" >Height </button>
								<div class="wdpo-select">
									<?php foreach ( $height_list as $key => $height_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $height_name ); ?>">
										<?php
											$donor_height = ! empty( $_GET['DonorHeight'] ) ? $_GET['DonorHeight'] : '';
										if ( is_array( $donor_height ) && in_array( $key, $donor_height ) ) {
											$donor_height_checked = 'checked';
										} else {
											$donor_height_checked = '';
										}
										?>
										<input <?php echo esc_attr( $donor_height_checked ); ?> name="DonorHeight[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $height_name ); ?>" type="checkbox" >
										<?php echo esc_html( $height_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>

							<div class="wdpo-wrap">
								<button class="wdpo-button" >Hair Colour </button>
								<div class="wdpo-select">
									<?php foreach ( $hair_colors as $key => $hair_colors_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $hair_colors_name ); ?>">
										<?php
											$hair_color = ! empty( $_GET['DonorHairColor'] ) ? $_GET['DonorHairColor'] : '';
										if ( is_array( $hair_color ) && in_array( $key, $hair_color ) ) {
											$hair_color_checked = 'checked';
										} else {
											$hair_color_checked = '';
										}
										?>
										<input <?php echo esc_attr( $hair_color_checked ); ?> name="DonorHairColor[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $hair_colors_name ); ?>" type="checkbox" >
										<?php echo esc_html( $hair_colors_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>

							<div class="wdpo-wrap">
								<button class="wdpo-button" >Blood Type </button>
								<div class="wdpo-select">
									<?php foreach ( $blood_list as $key => $blood_name ) { ?>
									<label class="wdpo-label" for="<?php echo esc_html( $blood_name ); ?>">
										<?php
											$bloodGroup = ! empty( $_GET['bloodGroup'] ) ? $_GET['bloodGroup'] : '';
										if ( is_array( $bloodGroup ) && in_array( $key, $bloodGroup ) ) {
											$bloodGroupr_checked = 'checked';
										} else {
											$bloodGroupr_checked = '';
										}
										?>
										<input <?php echo esc_attr( $bloodGroupr_checked ); ?> name="bloodGroup[]" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_html( $blood_name ); ?>" type="checkbox" >
										<?php echo esc_html( $blood_name ); ?>
									</label>
									<?php } ?>
								</div>
							</div>



							<div class="wkdo_button_search" >
								<button type="submit" class="wkdo_search_button_form" >Search</button>
								<button type="reset" class="wkdo_search_button_form wkdo_clear_button" style="margin-left: 10px; background-color: #f44336;">Clear</button>
							</div>
						</form>
					</div>
				</div>
				<div class="wps-prfil-details">
					<?php
						$this->get_user_list();
					?>
				</div>
			</div>
		<?php
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * USer list.
	 */
	public function get_user_list() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'wdo_donor_user';
		$query      = "SELECT * FROM {$table_name} WHERE 1=1 ";
		$params     = array();
		
		// Check if any search filters are applied
		$has_filters = false;

		if ( ! empty( $_GET['DonorType'] ) && is_array( $_GET['DonorType'] ) ) {
			// Map search form values to database values
			$donor_type_mapping = array(
				'sperm'  => 'Sperm Donor',
				'egg'    => 'Egg Donor',
				'embryo' => 'Embryo Donor',
			);
			
			$mapped_values = array();
			foreach ( $_GET['DonorType'] as $donor_type ) {
				if ( isset( $donor_type_mapping[ $donor_type ] ) ) {
					$mapped_values[] = $donor_type_mapping[ $donor_type ];
				}
			}
			
			if ( ! empty( $mapped_values ) ) {
				$placeholders = implode( ',', array_fill( 0, count( $mapped_values ), '%s' ) );
				$query       .= " AND donation_preferences IN ($placeholders)";
				$params       = array_merge( $params, $mapped_values );
				$has_filters  = true;
			}
		}

		if ( ! empty( $_GET['DonorAge'] ) && is_array( $_GET['DonorAge'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorAge'] ), '%s' ) );
			$query       .= " AND age IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorAge'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['bloodGroup'] ) && is_array( $_GET['bloodGroup'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['bloodGroup'] ), '%s' ) );
			$query       .= " AND blood_type IN ($placeholders)";
			$params       = array_merge( $params, $_GET['bloodGroup'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorEthnicity'] ) && is_array( $_GET['DonorEthnicity'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorEthnicity'] ), '%s' ) );
			$query       .= " AND ethnicity IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorEthnicity'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorRace'] ) && is_array( $_GET['DonorRace'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorRace'] ), '%s' ) );
			$query       .= " AND race IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorRace'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorHeight'] ) && is_array( $_GET['DonorHeight'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorHeight'] ), '%s' ) );
			$query       .= " AND height IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorHeight'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorHairColor'] ) && is_array( $_GET['DonorHairColor'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorHairColor'] ), '%s' ) );
			$query       .= " AND hair_color IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorHairColor'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorEyeColor'] ) && is_array( $_GET['DonorEyeColor'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorEyeColor'] ), '%s' ) );
			$query       .= " AND eye_color IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorEyeColor'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorEducation'] ) && is_array( $_GET['DonorEducation'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorEducation'] ), '%s' ) );
			$query       .= " AND education IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorEducation'] );
			$has_filters  = true;
		}

		if ( ! empty( $_GET['DonorReligion'] ) && is_array( $_GET['DonorReligion'] ) ) {
			$placeholders = implode( ',', array_fill( 0, count( $_GET['DonorReligion'] ), '%s' ) );
			$query       .= " AND religion IN ($placeholders)";
			$params       = array_merge( $params, $_GET['DonorReligion'] );
			$has_filters  = true;
		}

		// **Sorting Logic**//
		if ( ! $has_filters ) {
			// If no filters are applied, show all donors but sort by user preference
			$user_id = get_current_user_id();
			$r_data  = get_user_meta( $user_id, 'wkdo_becom_donor', true );
			$donor   = ! empty( $r_data['type_donor'] ) ? $r_data['type_donor'] : '';

			if ( ! empty( $donor ) ) {
				$query   .= ' ORDER BY
					CASE
						WHEN donation_preferences LIKE %s THEN 1
						ELSE 2
					END';
				$params[] = '%' . $wpdb->esc_like( $donor ) . '%';
			}
		} else {
			// If filters are applied, sort by donor type preference if available
			$user_id = get_current_user_id();
			$r_data  = get_user_meta( $user_id, 'wkdo_becom_donor', true );
			$donor   = ! empty( $r_data['type_donor'] ) ? $r_data['type_donor'] : '';

			if ( ! empty( $donor ) ) {
				$query   .= ' ORDER BY
					CASE
						WHEN donation_preferences LIKE %s THEN 1
						ELSE 2
					END';
				$params[] = '%' . $wpdb->esc_like( $donor ) . '%';
			}
		}

		// **Execute Query**
		if ( ! empty( $params ) ) {
			$prepared_query = $wpdb->prepare( $query, $params );
		} else {
			$prepared_query = $query;
		}
		$all_user = $wpdb->get_results( $prepared_query );

		
		if ( ! empty( $all_user ) ) {
			$user_list = array();
			foreach ( $all_user as $value ) {
				$user_id = $value->user_id;
				$status  = get_user_meta( $user_id, 'wkdo_becom_donor_status', true );

				if ( $status === 'approved' ) {
					$user_data        = get_userdata( $user_id );
					$user_status_html = '';

					$all_data = get_user_meta( $user_id, 'wkdo_becom_donor', true );
					$profile  = ! empty( $all_data['wkdo_profile_image'] ) ? $all_data['wkdo_profile_image'] : 'https://sperm-donor.appadvent.com/wp-content/uploads/2025/03/pngtree-user-profile-avatar-png-image_13369988.png';
					$img_html = '';					$dob          = ! empty( $all_data['wkdo_birth'] ) ? $all_data['wkdo_birth'] : '';
					$location     = ! empty( $all_data['wkdo_location'] ) ? $all_data['wkdo_location'] : '';
					$do_eye_color = ! empty( $all_data['wkdo_eye_color'] ) ? $all_data['wkdo_eye_color'] : '';
					$do_ha_col    = ! empty( $all_data['wkdo_hair_color'] ) ? $all_data['wkdo_hair_color'] : '';

					$dob   = new DateTime( $dob );
					$today = new DateTime();
					$age   = $today->diff( $dob );
					?>

					<div class="wps-profile-card">
						<div class="wps-profile-header" style="background-image:url('<?php echo esc_url( $profile ); ?>'); background-repeat: no-repeat; background-size: cover;background-position: center;"  >
							<div class="wps-profile-header-hover">
								<div class="wps-profile-info">
									<div class="wps-bio">
										<div class="wps-info-item">
											<div class='p-flex' >
												<span class="p-title" >Age</span>
											</div>
											<span class="p-info"><?php echo esc_html( ucfirst( $age->y ) ); ?> years </span>
										</div>
										<div class="wps-info-item">
											<div class='p-flex' >
												<span class="p-title" >Country</span>
											</div>

											<span class="p-info"><?php echo esc_html( ucfirst( $location ) ); ?></span>
										</div>
									</div>
									<div class="wps-bio">
										<div class="wps-info-item">
											<div class='p-flex' >
												<span class="p-title" >Eye Color</span>
											</div>
											<span class="p-info"><?php echo esc_html( ucfirst( $do_eye_color ) ); ?></span>
										</div>
										<div class="wps-info-item">
											<div class='p-flex' >
												<span class="p-title" >Hair</span>
											</div>
											<span class="p-info"><?php echo esc_html( ucfirst( $do_ha_col ) ); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="wps-user-basic">

							<div class="button-donor id button " >ID: D100<?php echo esc_html( $user_id ); ?></div>
							<?php
							if ( ! is_user_logged_in() ) {
								$redirect_url = site_url( 'donor-search-page/' );
								?>
										<a class=" button wps-view-profiles" href="<?php echo esc_url( site_url( 'my-account' ) . '?redirect_url=' . $redirect_url ); ?>"> Login Now </a>
									<?php
							} elseif ( is_user_logged_in() ) {
								$membership = check_user_membership();
								$membership = true;
								if ( ! $membership ) {
									?>
											<a class=" button wps-view-profiles" href="<?php echo esc_url( site_url( 'registration/premium' ) ); ?>"> Buy Membership </a>
										<?php
								} else {
									$rend = rand( 0, 99 );

									?>
									<a class="button wps-view-profiles" href="<?php echo esc_url( site_url() . '/donor-search-page?userp=' . $rend . '&userid=D100' . $user_id ); ?>">View Profile </a>
										<?php
								}
							}
							?>
							</div>
						</div>
					</div>
					<?php
				}
			}
		} else {
			echo '<h2 style="text-align:center">No donor found</h2>';
		}
	}

	/**
	 * View user profile.
	 */
	public function view_user_profile() {
		// $status   = get_user_meta( $user_id, 'wkdo_becom_donor_status', true );
		//
		$user_id    = (int) ! empty( $_GET['userid'] ) ? trim( str_replace( 'D100', '', $_GET['userid'] ) ) : 0;
		$all_data   = get_user_meta( $user_id, 'wkdo_becom_donor', true );
		$spacil_msg = ! empty( $all_data['wkdo_profile_image'] ) ? $all_data['wkdo_profile_image'] : 'https://www.shareicon.net/data/128x128/2016/05/24/770137_man_512x512.png';

		$gal_msg = ! empty( $all_data['wkdo_gallery_image'] ) ? $all_data['wkdo_gallery_image'] : '';
		$img     = ! empty( $gal_msg ) ? explode( ',', $gal_msg ) : array();
		?>
		<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
		<style>
			.my-gallery {
				display: flex;
				align-items: center;
			}
		</style>
		<div class="grid grid-cols-1 md:grid-cols-12 gap-0">
			<div class="md:col-span-3 bg-gray-100 p-4">
				<div class="relative">
					<img src="<?php echo esc_url( $spacil_msg ); ?>" id="mainDonorImage"
						alt="Donor profile" class="w-full h-80 object-cover rounded-md" />
					<!-- <button id="favoriteBtn"
						class="absolute top-2 right-2 p-2 rounded-full bg-white/80 hover:bg-white shadow-sm">
						<i data-lucide="heart" class="h-6 w-6 text-gray-500"></i>
					</button> -->
					<div
						class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-3 flex justify-center items-center gap-2 cursor-pointer">
						<i data-lucide="image" class="h-5 w-5"></i>
						<span class="text-sm font-medium">VIEW GALLERY</span>
					</div>
				</div>

				<div class="mt-4 flex gap-2 overflow-x-auto pb-2" id="gallery-thumbs">
					<img src="<?php echo esc_url( $spacil_msg ); ?>" alt="Donor thumbnail 1"
						class="donor-thumb hover:opacity-80 transition-opacity cursor-pointer" />
					<?php foreach ( $img as $imgs ) { ?>
					<img src="<?php echo esc_url( $imgs ); ?>"
						alt="Donor thumbnail 2" class="donor-thumb hover:opacity-80 transition-opacity cursor-pointer" />
					<?php } ?>
				</div>

				<div class="mt-8 text-center">
					<p class="text-gray-600 mb-2">
						Contact us for more information<br />
						or to move forward with this<br />
						donor.
					</p>
					<?php
					$status = $this->wp_wdo_intrest_user();
					if ( empty( $status ) ) {
						?>
					<button data-user="<?php echo esc_html( $user_id ); ?>" id="do_contact"
						class="bg-blue-800 hover:bg-blue-900 text-white font-semibold py-3 px-6 rounded-full w-full mt-4">
						CONTACT US
					</button>
						<?php
					} else {
						echo '<b style="color:green" > You have already applied for this profile. </b>';
					}
					?>

					<div style="color:red" id ="show_text" ></div>
				</div>
			</div>

			<div class="md:col-span-9 p-6">
				<div class="flex justify-between items-center mb-8">
					<h1 class="text-2xl font-bold text-blue-800">ID: <?php echo esc_html( $_GET['userid'] ); ?></h1>
				</div>

				<div class="border-b border-gray-200">
					<div class="flex overflow-x-auto pb-px">
						<button class="donor-tab active" data-tab="overview">
							<i data-lucide="file-text" class="h-5 w-5"></i>
							<span>Basic Information</span>
						</button>
						<button class="donor-tab" data-tab="medical">
							<i data-lucide="activity" class="h-5 w-5"></i>
							<span>Donation preference</span>
						</button>
						<button class="donor-tab" data-tab="health_genetic">
							<i data-lucide="users" class="h-5 w-5"></i>
							<span>Medical and Genetic History</span>
						</button>


						<button class="donor-tab" data-tab="fertility_histor">
							<i data-lucide="flask-conical" class="h-5 w-5"></i>
							<span>Family and Fertility History</span>
						</button>

						<button class="donor-tab" data-tab="Document_report">
							<i data-lucide="flask-conical" class="h-5 w-5"></i>
							<span>Reports and Documents</span>
						</button>


						<button class="donor-tab" data-tab="more_info">
							<i data-lucide="flask-conical" class="h-5 w-5"></i>
							<span>Personality</span>
						</button>


					</div>
				</div>

				

				<div class="py-6">
					<div class="tab-content" id="overview-tab">
						<div class="donor-accordion-title" data-section="characteristics">
							<span>User Details</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
							</svg>
						</div>

						<div class="donor-grid" id="characteristics-section">
							
							<div class="donor-info-group">
								<span class="donor-info-label">Age</span>
								<span class="donor-info-value"><?php 
								$birthdate = new DateTime($all_data['wkdo_birth']);
$today = new DateTime('now');
echo $today->diff($birthdate)->y; ?>
								</span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Gender </span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_gender'] ) ? esc_html( $all_data['wkdo_gender'] ) : '-'; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Place of Birth</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_race'] ) ? esc_html( $all_data['wkdo_race'] ) : '-'; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Current Location</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_location'] ) ? esc_html( $all_data['wkdo_location'] ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Nationality</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['nationality'] ) ? esc_html( $all_data['nationality'] ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Relationship Status</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['relation_status'] ) ? esc_html( ucfirst( $all_data['relation_status'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Race</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_race'] ) ? esc_html( $all_data['wkdo_race'] ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Ethnicity</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_ethnicity'] ) ? esc_html( $all_data['wkdo_ethnicity'] ) : ''; ?></span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Highest Level of Education</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_education'] ) ? esc_html( $all_data['wkdo_education'] ) : ''; ?></span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Donor Occupation</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_current_occ'] ) ? esc_html( ucfirst( $all_data['wkdo_current_occ'] ) ) : ''; ?></span>
							</div>



						</div>

						<hr class="my-8 border-gray-200" />
						<br/> <br/>
						<div class="donor-accordion-title" data-section="background">
							<span>Physical Traits & Background</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
							</svg>
						</div>

						<div class="donor-grid" id="background-section">
							<div class="donor-info-group">
								<span class="donor-info-label">Height</span>
								<span class="donor-info-value">
								<?php
								$height = ! empty( $all_data['do_height'] ) ? esc_html( $all_data['do_height'] ) : '-';

								$donor_height_options = array(
									''          => 'Select Height Range',
									'below_5ft' => "Below 5'0\" (152 cm)",
									'5ft_5ft4'  => "5'0\" - 5'4\" (152 - 163 cm)",
									'5ft5_5ft8' => "5'5\" - 5'8\" (165 - 173 cm)",
									'5ft9_6ft'  => "5'9\" - 6'0\" (175 - 183 cm)",
									'above_6ft' => "Above 6'0\" (183+ cm)",
								);

								echo array_key_exists( $height, $donor_height_options ) ? $donor_height_options[ $height ] : 'Unknown';

								?>
								</span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Weight</span>
								<span class="donor-info-value">

								<?php

									$weight = ! empty( $all_data['wkdo_weight'] ) ? esc_html( $all_data['wkdo_weight'] ) : '-';

									$donor_weight_options = array(
										'1'          => 'Select Weight Range',
										'below_50kg' => 'Below 50 kg (110 lbs)',
										'50kg_60kg'  => '50 - 60 kg (110 - 132 lbs)',
										'61kg_70kg'  => '61 - 70 kg (134 - 154 lbs)',
										'71kg_85kg'  => '71 - 85 kg (156 - 187 lbs)',
										'above_85kg' => 'Above 85 kg (187+ lbs)',
									);

									echo array_key_exists( $weight, $donor_weight_options ) ? $donor_weight_options[ $weight ] : 'Unknown';

									?>
								</span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Hair Color</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_hair_color'] ) ? esc_html( ucfirst( $all_data['wkdo_hair_color'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Eye Color</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_eye_color'] ) ? esc_html( ucfirst( $all_data['wkdo_eye_color'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Body Type</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_body_type'] ) ? esc_html( $all_data['wkdo_body_type'] ) : ''; ?></span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Distinctive Features</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['distinctive_featur'] ) ? esc_html( ucfirst( $all_data['distinctive_featur'] ) ) : ''; ?></span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Religion</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_religion'] ) ? esc_html( ucfirst( $all_data['wkdo_religion'] ) ) : ''; ?></span>
							</div>


							<div class="donor-info-group">
								<span class="donor-info-label">Languages Spoken</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_lang'] ) ? esc_html( ucfirst( $all_data['wkdo_lang'] ) ) : ''; ?></span>
							</div>
						</div>

						<hr class="my-8 border-gray-200" />
						<br/> <br/>
						<div class="donor-accordion-title" data-section="description">
							<span>About Donor</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
							</svg>
						</div>

						<div id="description-section">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_about'] ) ? esc_html( $all_data['wkdo_about'] ) : ''; ?></p>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-content hidden" id="medical-tab">
						<div class="donor-grid" >
							<div class="donor-info-group">
								<span class="donor-info-label">Sperm Donor</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_preference'] ) ? esc_html( $all_data['wkdo_preference'] ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Availability</span>
								<span class="donor-info-value">
								<?php
								echo ! empty( $all_data['wkdo_avalabl_donate'] ) ? esc_html( implode( ',', $all_data['wkdo_avalabl_donate'] ) ) : '';

								?>
								</span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label"> Country preference for Donation </span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_account_donor_form'] ) ? esc_html( $all_data['wkdo_account_donor_form'] ) : ''; ?> </span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Donation preference</span>
								<span class="donor-info-value">
									<?php
										$donate_where = ! empty( $all_data['wkdo_donation_method'] ) ? esc_html( $all_data['wkdo_donation_method'] ) : '';

										$donation_method_options = array(
											'clinic_donate_only' => 'Clinic Donation Only',
											'home'   => 'At-Home Donation (Sperm Donors Only)',
											'Frozen' => 'Frozen & Shipped to Recipients Clinic',
										);

										echo array_key_exists( $donate_where, $donation_method_options ) ? $donation_method_options[ $donate_where ] : 'Unknown';
										?>
								</span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Donation Status </span>
								<span class="donor-info-value">
								<?php
									$donor_status         = ! empty( $all_data['wkdo_donor_status'] ) ? esc_html( $all_data['wkdo_donor_status'] ) : '';
									$donor_status_options = array(
										'anonymous_donor' => 'Anonymous Donor',
										'18'              => 'Open-ID Donor',
										'known_donor'     => 'Known Donor',
									);

									echo array_key_exists( $donor_status, $donor_status_options ) ? $donor_status_options[ $donor_status ] : 'Unknown';

									?>
								</span>
							</div>

								<div class="donor-info-group">
									<span class="donor-info-label">Have You Donated Before</span>
									<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_have_donate_before'] ) ? esc_html( ucfirst( $all_data['wkdo_have_donate_before'] ) ) : ''; ?></span>
								</div>


							</div>
						</div>

					



					<div class="tab-content hidden" id="health_genetic-tab">
						<div class="donor-grid">
							<div class="donor-info-group">
								<span class="donor-info-label">Donor medical and family documents available</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['donor_family'] ) ? esc_html( $all_data['donor_family'] ) : '-'; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label"> Blood Type </span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_blood_type'] ) ? esc_html( $all_data['wkdo_blood_type'] ) : '-'; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Donor Genetic Screening?</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_genetic_screen'] ) ? esc_html( ucfirst( $all_data['wkdo_genetic_screen'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Donor Blood Test Results Available</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_blod_test_avl'] ) ? esc_html( ucfirst( $all_data['wkdo_blod_test_avl'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">Donor Completed a Fertility Screening</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_fer_screen'] ) ? esc_html( ucfirst( $all_data['wkdo_fer_screen'] ) ) : ''; ?></span>
							</div>

						</div>
					</div>

					<div class="tab-content hidden" id="fertility_histor-tab">
						<div class="donor-grid">
							<div class="donor-info-group">
								<span class="donor-info-label">Do You Have Any Siblings?</span>
								<span class="donor-info-value">
								<?php

								echo $sibling = ! empty( $all_data['wkdo_sibling'] ) ? esc_html( $all_data['wkdo_sibling'] ) : '-';

								?>
								</span>
							</div>
							<?php
							if ( $sibling == 'Yes' ) {
								?>
							<div class="donor-info-group">
								<span class="donor-info-label"> Total Siblings </span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_total_sibling'] ) ? esc_html( $all_data['wkdo_total_sibling'] ) : '-'; ?></span>
							</div>
							<?php } ?>

							<div class="donor-info-group">
								<span class="donor-info-label">Do You Have Children? </span>
								<span class="donor-info-value"><?php echo $total_child = ! empty( $all_data['wkdo_child'] ) ? esc_html( ucfirst( $all_data['wkdo_child'] ) ) : ''; ?></span>
							</div>
							<?php
							if ( $total_child == 'Yes' ) {
								?>

							<div class="donor-info-group">
								<span class="donor-info-label">Total Children</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_total_childe'] ) ? esc_html( ucfirst( $all_data['wkdo_total_childe'] ) ) : ''; ?></span>
							</div>
							<?php } ?>
							<div class="donor-info-group">
								<span class="donor-info-label">Have You Had a Child Naturally Conceived (Proven Fertility)</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_child_nat'] ) ? esc_html( ucfirst( $all_data['wkdo_child_nat'] ) ) : ''; ?></span>
							</div>

							<div class="donor-info-group">
								<span class="donor-info-label">If Donating Embryos, Do You Have Stored Embryos at a Clinic</span>
								<span class="donor-info-value"><?php echo ! empty( $all_data['wkdo_child_nat'] ) ? esc_html( ucfirst( $all_data['embryos_stored'] ) ) : ''; ?></span>
							</div>

						</div>
					</div>

					<div class="tab-content hidden" id="more_info-tab">

						<div class="donor-accordion-title" data-section="intrest">
							<span>Interests and hobbies</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="intrest-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_hobbies'] ) ? esc_html( $all_data['wkdo_hobbies'] ) : ''; ?></p>
								</div>
							</div>
						</div>


						<div class="donor-accordion-title" data-section="why_dononr">
							<span>Why Do You Want to Be a Donor</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="why_dononr-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_want_donor'] ) ? esc_html( $all_data['wkdo_want_donor'] ) : ''; ?></p>
								</div>
							</div>
						</div>


						<div class="donor-accordion-title" data-section="special_message">
							<span>Special Message for the Recipient</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="special_message-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_spacial_msg'] ) ? esc_html( $all_data['wkdo_spacial_msg'] ) : ''; ?></p>
								</div>
							</div>
						</div>

						<div class="donor-accordion-title" data-section="favorite-weekend">
							<span>Donor favorite way to spend a weekend</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="favorite-weekend-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_weekend'] ) ? esc_html( $all_data['wkdo_weekend'] ) : ''; ?></p>
								</div>
							</div>
						</div>


						<div class="donor-accordion-title" data-section="dinner-guest">
							<span>A Dream Dinner Guest</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="dinner-guest-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['wkdo_dinner'] ) ? esc_html( $all_data['wkdo_dinner'] ) : ''; ?></p>
								</div>
							</div>
						</div>


						<div class="donor-accordion-title" data-section="fun-fact">
							<span>A Fun Fact You Might Not Know</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="fun-fact-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['fun_fact_about'] ) ? esc_html( $all_data['fun_fact_about'] ) : ''; ?></p>
								</div>
							</div>
						</div>

						<div class="donor-accordion-title" data-section="life_value">
							<span>The Life Values</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="life_value-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['fun_most_important'] ) ? esc_html( $all_data['fun_most_important'] ) : ''; ?></p>
								</div>
							</div>
						</div>


						<div class="donor-accordion-title" data-section="fav_movbe">
							<span>Favorite Book, Movie, or Song</span>
							<svg class="ml-2 h-5 w-5 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</div>

						<div id="fav_movbe-section" class="">
							<div class="bg-blue-50 border-l-4 border-blue-700 p-4 pl-6">
								<div class="mb-6">
									<h3 class="text-md font-semibold text-blue-800 mb-2">Short Description</h3>
									<p class="text-gray-700"><?php echo ! empty( $all_data['fav_book'] ) ? esc_html( $all_data['fav_book'] ) : ''; ?></p>
								</div>
							</div>
						</div>


					</div>


					<div class="tab-content hidden" id="Document_report-tab">

					<?php
					$Genetic_Screening_Report = ! empty( $all_data['Genetic_Screening_Report'] ) ? $all_data['Genetic_Screening_Report'] : '';
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
    					$Blood_report = ! empty( $all_data['Blood_report'] ) ? $all_data['Blood_report'] : '';
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
    					$medical_history = ! empty( $all_data['medical_history'] ) ? $all_data['medical_history'] : '';
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
    					$psychological_assessment = ! empty( $all_data['psychological_assessment'] ) ? $all_data['psychological_assessment'] : '';
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
    					$short_video = ! empty( $all_data['short_video'] ) ? $all_data['short_video'] : '';
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

				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Check apply or not
	 */
	public function wp_wdo_intrest_user() {
		global $wpdb;
		$user_id = get_current_user_id();
		$pid     = ! empty( $_GET['userid'] ) ? (int) str_replace( 'D100', '', $_GET['userid'] ) : 0;
		$table   = $wpdb->prefix . 'wdo_intrest_user';

		$query = $wpdb->prepare(
			"SELECT * FROM {$table} WHERE uid = %d AND rid = %d AND status = %s",
			$pid,
			$user_id,
			'pending'
		);

		$row = $wpdb->get_row( $query );
		return $row;
	}
}
