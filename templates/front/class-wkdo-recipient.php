<?php
/**
 * Front hooks.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Recipient user.
 */
class Wkdo_Recipient {
	/**
	 * User id.
	 *
	 * @var int user id.
	 */
	public $user_id;

	/**
	 * Construct function.
	 *
	 * @param int $user_id user id.
	 */
	public function __construct( $user_id = null ) {
		$this->user_id = $user_id;
	}

	/**
	 * Become a donor form.
	 */
	public function wkdo_recipient_content() {
		$this->wkd_save_recipient_informattion_template();
		$user_data = array();
		if ( ! empty( $this->user_id ) ) {
			if(is_admin()) {
				$this->user_id = str_replace("R100", "", $original_string);
			}
		}

		if(is_admin()) {
			$this->user_id = str_replace("R100", "", $_GET['pid']);
		}

		$user_data = get_user_meta( $this->user_id, 'wkdo_becom_donor', true );
		$user_data = ! empty( $user_data ) ? $user_data : array();

		$user  = wp_get_current_user();
		$email = ! empty( $user->user_email ) ? $user->user_email : '';
		?>
			<div class="wkdo-form-container">
					<form class="wkdo-form" method="post" enctype="multipart/form-data" >
							<div class="wkdo-form-body">
									<div class="wkdo-b-containr">
											<div class="wkdo-form-section">

													<?php
													if ( is_admin() ) {
														?>
													<h3 class="wkdo-section-title"><?php esc_html_e( 'User Profile', 'wpdonor' ); ?></h3>
													<?php } else { ?>
													<h3 class="wkdo-section-title"><?php esc_html_e( 'Tell Us About Yourself', 'wpdonor' ); ?></h3>
													<?php } ?>
											</div>

											<div class="wkdo-b-row">
												<div class="wkdo-form-section wkdo-50-width">
													<?php
														$barth = ! empty( $user_data['application_type'] ) ? $user_data['application_type'] : '';
													?>
													<label class="wkdo-label" for=""><?php esc_html_e( 'Application Type', 'wpdonor' ); ?></label>
													<select name="application_type" id="">
														<option <?php selected( 'single', $barth ); ?> value="Single">Single</option>
														<option <?php selected( 'Joint', $barth ); ?> value="Joint">Joint (Couple Applying Together)</option>
													</select>
												</div>
											</div>
											
											<div class="wkdo-b-row">
													<?php
														$fname = $user_data['wkdo_first_name'];
														$lname = $user_data['wkdo_last_name'];
														$dob   = get_user_meta( $this->user_id, 'dob', true );
													?>
													<div class="wkdo-form-section wkdo-50-width">
															<label class="wkdo-label" for=""><?php esc_html_e( 'First Name', 'wpdonor' ); ?></label>
															<input type="text" id="" class="wkdo-input" name="wkdo_first_name" placeholder="<?php esc_attr_e( 'First Name', 'wpdonor' ); ?>" value="<?php echo ! empty( $fname ) ? esc_attr( $fname ) : get_user_meta( $this->user_id, 'first_name', true ); ?>" required >
													</div>

													<div class="wkdo-form-section wkdo-50-width">
															<label class="wkdo-label" for="input_2_4"><?php esc_html_e( 'Last Name', 'wpdonor' ); ?></label>
															<input type="text" id="input_2_4" class="wkdo-input" name="wkdo_last_name" placeholder="<?php esc_attr_e( 'Last Name', 'wpdonor' ); ?>" value="<?php echo ! empty( $lname ) ? esc_attr( $lname ) : get_user_meta( $this->user_id, 'last_name', true ); ?>" required >
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
															<label class="wkdo-label" for="wkdoagdob"><?php esc_html_e( 'Date of Birth', 'wpdonor' ); ?></label>
															<input type="date" id="wkdoagdob" class="wkdo-input datepicker" name="wkdo_birth" placeholder="<?php esc_attr_e( 'Date of Birth', 'wpdonor' ); ?>" value="<?php echo ! empty( $dob ) ? $dob : ''; ?>" required>
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

									
									<div class="wkdo-form-section">
											<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Place of Birth', 'wpdonor' ); ?></label>

											<?php
											$barth     = ! empty( $user_data['wkido-place-birth'] ) ? $user_data['wkido-place-birth'] : '';
											$countries_obj = new WC_Countries();
											$countries = $countries_obj->get_countries();
											?>

											<select name="wkido-place-birth" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
											<?php
											foreach ( $countries as $country ) {
												?>
													<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $barth ); ?>>
													<?php echo esc_html( $country ); ?>
													</option>
												<?php
											}
											?>
											</select>

									</div>

									<div class="wkdo-form-section">
											<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Nationality', 'wpdonor' ); ?></label>

											<?php
											$wkdo_location = ! empty( $user_data['wkdo_location'] ) ? $user_data['wkdo_location'] : '';
											$countries_obj = new WC_Countries();
											$countries = $countries_obj->get_countries();
											?>

											<select name="wkdo_location" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
											<?php
											foreach ( $countries as $country ) {
												?>
													<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $wkdo_location ); ?>>
													<?php echo esc_html( $country ); ?>
													</option>
												<?php
											}
											?>
											</select>

									</div>
									<?php
									$wkdo_race = ! empty( $user_data['wkdo_race'] ) ? $user_data['wkdo_race'] : '';
									?>
									<div class="wkdo-form-section">
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
									]
									?>

									<div class="wkdo-form-section">
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


									<?php
									$wkdo_re_status = ! empty( $user_data['wkdo_re_status'] ) ? $user_data['wkdo_re_status'] : '';
									?>

									<div class="wkdo-form-section">
											<label class="wkdo-label" for="input_2_12">
													<?php esc_html_e( 'Relationship Status', 'wpdonor' ); ?></label>
											<select id="input_2_12" class="wkdo-select" name="wkdo_re_status" required>
												<option <?php selected( 'single', $relation_status ); ?> value="single">Single</option>
												<option <?php selected( 'In a relationship', $relation_status ); ?> value="In a relationship">In a relationship</option>
												<option <?php selected( 'Engaged ', $relation_status ); ?> value="Engaged ">Engaged </option>
												<option <?php selected( 'married', $relation_status ); ?> value="married">Separated</option>
												<option <?php selected( 'Separated', $relation_status ); ?> value="Separated">Separated</option>
												<option <?php selected( 'Divorced', $relation_status ); ?> value="Divorced">Divorced</option>
												<option <?php selected( 'Widowed', $relation_status ); ?> value="Widowed">Widowed</option>
												<option <?php selected( 'In a civil partnership', $relation_status ); ?> value="In a civil partnership">In a civil partnership</option>
										Religion
											</select>
									</div>


									<div class="wkdo-form-section">
											<label class="wkdo-label" for="input_2_10"><?php esc_html_e( 'Current Location', 'wpdonor' ); ?></label>

											<?php
											$wkdo_location = ! empty( $user_data['wkdo_c_location'] ) ? $user_data['wkdo_c_location'] : '';
											$countries_obj = new WC_Countries();
											$countries = $countries_obj->get_countries();
											?>

											<select name="wkdo_c_location" id="input_2_10" class="wkdo-select" aria-invalid="false" required>
											<?php foreach ( $countries as $country ) : ?>
													<option value="<?php echo esc_attr( $country ); ?>" <?php selected( $country, $wkdo_location ); ?>>
													<?php esc_html_e( $country, 'wpdonor' ); ?>
													</option>
											<?php endforeach; ?>
											</select>

									</div>

									<div class="wkdo-form-section">
											<?php
												echo $wkddo_acc_do = ! empty( $user_data['accept_donor_from'] ) ? $user_data['accept_donor_from'] : '';
											?>
											<label class="wkdo-label" for="input_2_15">Willing to Accept a Donor From:</label>
											<select id="input_2_15" class="wkddo_acc_do" name="accept_donor_from">
													<option <?php selected( 'UK Only', $wkddo_acc_do ); ?> value="UK Only">UK Only</option>
													<option <?php selected( 'Europe', $wkddo_acc_do ); ?> value="Europe">Europe</option>
													<option <?php selected( 'North America', $wkddo_acc_do ); ?> value="North America">North America</option>
													<option <?php selected( 'South America', $wkddo_acc_do ); ?> value="South America">South America</option>
													<option <?php selected( 'Asia', $wkddo_acc_do ); ?> value="Asia">Asia</option>
													<option <?php selected( 'Australia', $wkddo_acc_do ); ?> value="Australia &amp; New Zealand">Australia &amp; New Zealand</option>
													<option <?php selected( 'Africa', $wkddo_acc_do ); ?> value="Africa">Africa</option>
													<option <?php selected( 'Worlwide', $wkddo_acc_do ); ?> value="Worlwide">Worlwide</option>
											</select>
									</div>


									<div class="wkdo-form-section">
										<h3 class="wkdo-section-title">Donor Preferences</h3>
									</div>

									<?php
											$type_donor = ! empty( $user_data['type_donor'] ) ? $user_data['type_donor'] : '';
									?>

									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_18">What Type of Donor Are You Looking For</label>
										<select id="input_2_18" class="wkdo-select" name="type_donor">
											<option <?php selected( 'What Type of Donor Are You Looking For', $type_donor ); ?> value="">What Type of Donor Are You Looking For</option>
											<option <?php selected( 'Egg', $type_donor ); ?>  value="Egg">Egg</option>
											<option <?php selected( 'Sperm', $type_donor ); ?> value="Sperm">Sperm</option>
											<option <?php selected( 'Embryo Donor', $type_donor ); ?> value="Embryo Donor">Embryo Donor</option>
										</select>
									</div>
									<?php
										$donor_ethnicity = ! empty( $user_data['donor_ethnicity'] ) ? $user_data['donor_ethnicity'] : '';
										$ethnicity = [
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
									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_16">Preferred Donor Ethnicity</label>
										<select id="input_2_16" class="wkdo-select-multi" name="donor_ethnicity[]" multiple> >
										<?php
										foreach ( $ethnicity as $lists ) {
											if ( ! empty( $donor_ethnicity ) && in_array( $lists, $donor_ethnicity ) ) {
												$selected = 'selected';
											} else {
												$selected = '';
											}

											echo '<option ' . $selected . ' value="' . $lists . '">' . $lists . '</option>';
										}
										?>
										</select>
									</div>
									<?php
											$wkdo_blood_type = ! empty( $user_data['wkdo_blood_type'] ) ? $user_data['wkdo_blood_type'] : '';
											$blood_type      = array(
												'A+',
												'A-',
												'B+',
												'B-',
												'AB+',
												'AB-',
												'O+',
												'O-',
											);
											?>
									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_19">Preferred Donor Blood Type</label>
										<select id="input_2_19" class="wkdo-select-multi" name="wkdo_blood_type[]" multiple>
											<?php
											foreach ( $blood_type as $lists ) {
												if ( ! empty( $wkdo_blood_type ) && in_array( $lists, $wkdo_blood_type ) ) {
													$selected = 'selected';
												} else {
													$selected = '';
												}

												echo '<option ' . $selected . ' value="' . $lists . '">' . $lists . '</option>';
											}
											?>
										</select>
									</div>
									<?php
											$dono_eye_co = ! empty( $user_data['do_eye_color'] ) ? $user_data['do_eye_color'] : '';
											$eye_color   = array(
												'Dark Brown / Almost Black',
												'Brown',
												'Blue',
												'Green',
												'Hazel',
												'Gray',
											);

											?>
									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_20">Preferred Donor Eye Color</label>
										<select id="input_2_20" class="wkdo-select-multi" name="do_eye_color[]" multiple>
											<?php
											foreach ( $eye_color as $lists ) {
												if ( ! empty( $dono_eye_co ) && in_array( $lists, $dono_eye_co ) ) {
													$selected = 'selected';
												} else {
													$selected = '';
												}

												echo '<option ' . $selected . ' value="' . $lists . '">' . $lists . '</option>';
											}
											?>
										</select>
									</div>
									<?php
										$do_ha_col  = ! empty( $user_data['do_ha_col'] ) ? $user_data['do_ha_col'] : '';
										$hair_color = array(
											'Black',
											'Dark Brown',
											'Brown',
											'Auburn',
											'Chestnut',
											'Red / Ginger',
											'Strawberry Blonde',
											'Dirty Blonde / Ash Blonde',
											'Platinum Blonde / White Blonde',
											'Gray / Silver',
											'White',
										);

										?>
									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_21">Preferred Donor Hair Color</label>
										<select id="input_2_21" class="wkdo-select-multi" name="do_ha_col[]" multiple>
											<?php
											foreach ( $hair_color as $lists ) {
												if ( ! empty( $do_ha_col ) && in_array( $lists, $do_ha_col ) ) {
													$selected = 'selected';
												} else {
													$selected = '';
												}

												echo '<option ' . $selected . ' value="' . $lists . '">' . $lists . '</option>';
											}
											?>
										
										</select>
									</div>

									<?php
										$don_reli   = ! empty( $user_data['don_reli'] ) ? $user_data['don_reli'] : '';
										$region_lit = [
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

										?>

									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_22">Preferred Donor Religion</label>
										<select id="input_2_22" class="wkdo-select wkdo-select wkdo-select-multi" name="don_reli[]" multiple>
											<?php
											foreach ( $region_lit as $list ) {
												if ( ! empty( $don_reli ) && in_array( $list, $don_reli ) ) {
													$selected = 'selected';
												} else {
													$selected = '';
												}

												echo '<option ' . $selected . ' value="' . $list . '">' . $list . '</option>';
											}
											?>
										</select>
									</div>

									<?php
										$do_height = ! empty( $user_data['do_height'] ) ? $user_data['do_height'] : '';
									?>

									<div class="wkdo-form-section">
										<label class="wkdo-label" for="input_2_23">Height Preference (cm or ft/in)</label>
										<select id="donor-height" name="do_height">
											<option value="">Select Height Range</option>
											<option <?php selected( 'below_5ft', $do_height ); ?>  value="below_5ft">Below 5'0" (152 cm)</option>
											<option <?php selected( '5ft_5ft4', $do_height ); ?> value="5ft_5ft4">5'0" - 5'4" (152 - 163 cm)</option>
											<option <?php selected( '5ft5_5ft8', $do_height ); ?> value="5ft5_5ft8">5'5" - 5'8" (165 - 173 cm)</option>
											<option <?php selected( '5ft9_6ft', $do_height ); ?> value="5ft9_6ft">5'9" - 6'0" (175 - 183 cm)</option>
											<option <?php selected( 'above_6ft', $do_height ); ?> value="above_6ft">Above 6'0" (183+ cm)</option>
										</select>
									</div>

									<?php
										$donor_weight = ! empty( $user_data['donor_weight'] ) ? $user_data['donor_weight'] : '';
									?>

								<div class="wkdo-form-section">
									<label class="wkdo-label" for="input_2_24">Weight Preference (cm or ft/in)</label>
									<select id="donor-weight" name="donor_weight">
										<option <?php selected( '1', $donor_weight ); ?>  value="1">Select Weight Range</option>
										<option <?php selected( 'below_50kg', $donor_weight ); ?> value="below_50kg">Below 50 kg (110 lbs)</option>
										<option <?php selected( '50kg_60kg', $donor_weight ); ?> value="50kg_60kg">50 - 60 kg (110 - 132 lbs)</option>
										<option <?php selected( '61kg_70kg', $donor_weight ); ?> value="61kg_70kg">61 - 70 kg (134 - 154 lbs)</option>
										<option <?php selected( '71kg_85kg', $donor_weight ); ?> value="71kg_85kg">71 - 85 kg (156 - 187 lbs)</option>
										<option <?php selected( 'above_85kg', $donor_weight ); ?> value="above_85kg">Above 85 kg (187+ lbs)</option>
									</select>
								</div>

								<div class="wkdo-form-section">
									<?php
									$donor_education = ! empty( $user_data['donor_education'] ) ? $user_data['donor_education'] : '';
									$education       = array(
										'No Formal Education',
										'High School',
										'A-Levels/IB',
										'Bachelor’s',
										'Master’s, PhD',
									);

									?>
									<label class="wkdo-label" for="input_2_24">Preferred Donor Education Level</label>
									<select id="donor-weight" name="donor_education[]" class="wkdo-select-multi" multiple>
										<option value="">Select Education Level</option>
										<?php
										foreach ( $education as $edu ) {
											if ( ! empty( $donor_education ) && in_array( $edu, $donor_education ) ) {
												$selected = 'selected';
											} else {
												$selected = '';
											}

											echo '<option ' . $selected . ' value="' . $edu . '">' . $edu . '</option>';
										}
										?>
									</select>
								</div>


								<div class="wkdo-form-section">
									<?php
										$oprn_to_contsct = ! empty( $user_data['oprn_to_contsct'] ) ? $user_data['oprn_to_contsct'] : '';
									?>
									<label class="wkdo-label" for="input_2_24"> Do You Want a Donor Who Is Open to Contact?</label>
									<select id="donor-weight" name="oprn_to_contsct" class="" >
										<option <?php selected( 'Yes', $oprn_to_contsct ); ?> value="Yes">Yes</option>
										<option <?php selected( 'No', $oprn_to_contsct ); ?> value="No">No</option>
										<option <?php selected( 'Maybe', $oprn_to_contsct ); ?> value="Maybe">Maybe</option>
									</select>
								</div>
								
								<div class="wkdo-form-section">
									<?php
										$biological_child = ! empty( $user_data['biological_child'] ) ? $user_data['biological_child'] : '';
									?>
									<label class="wkdo-label" for="input_2_24"> Would You Prefer a Donor with Proven Fertility (Has Biological Children)? </label>
									<select id="donor-weight" name="biological_child" class="">
										<option <?php selected( 'Yes', $biological_child ); ?> value="Yes">Yes</option>
										<option <?php selected( 'No', $biological_child ); ?> value="No">No</option>
										<option <?php selected( 'No Preference', $biological_child ); ?> value="No Preference">No Preference</option>
									</select>
								</div>

								<div class="wkdo-form-section">
									<?php
										$type = ! empty( $user_data['like-person-type'] ) ? $user_data['like-person-type'] : '';
									?>
									<label class="wkdo-label" for="input_2_24"> Do you prefer a first-time donor or an experienced donor? </label>
									<select id="donor-weight" class="selet45" name="like-person-type" class="" >
										<option <?php selected( 'First-time donor', $type ); ?> value="First-time donor">First-time donor</option>
										<option <?php selected( 'Experienced donor', $type ); ?> value="Experienced donor">Experienced donor</option>
										<option <?php selected( 'No preference', $type ); ?> value="No preference">No preference</option>
									</select>
								</div>

								<hr>
								<h3>Donation Preferences</h3>

								<div class="wkdo-form-section">
									<label class="wkdo-label">Preferred Donation Method:</label>
									<div class="wkdo-checkbox-group">
									<?php
										$wkDonor = ! empty( $user_data['wkDonor'] ) ? $user_data['wkDonor'] : array();
									?>

										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_25_1" name="wkDonor[]" value="Anonymous Donor"
												<?php
												if ( in_array( 'Anonymous Donor', $wkDonor ) ) {
													echo 'checked';
												}

												?>
											>
											<label for="choice_2_25_1">Anonymous Donor</label>
										</div>

										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_25_2" name="wkDonor[]" value="Open-ID Donor (Willing to be identified at 18+)"
											<?php
											if ( in_array( 'Open-ID Donor (Willing to be identified at 18+)', $wkDonor ) ) {
												echo 'checked';
											}

											?>
											>
											<label for="choice_2_25_2">Open-ID Donor (Willing to be identified at 18+)</label>
										</div>

										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_25_3" name="wkDonor[]" value="Known Donor (Willing to be in contact immediately)"

											<?php
											if ( in_array( 'Known Donor (Willing to be in contact immediately)', $wkDonor ) ) {
												echo 'checked';
											}

											?>
												>
											<label for="choice_2_25_3">Known Donor (Willing to be in contact immediately)</label>
										</div>
									</div>
								</div>

								<div class="wkdo-form-section">
									<label class="wkdo-label">Would You Accept</label>
									<div class="wkdo-checkbox-group">
									<?php
										$wkdoaccpt = ! empty( $user_data['wkdoaccpt'] ) ? $user_data['wkdoaccpt'] : array();
									?>
										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_26_1" name="wkdoaccpt[]" value="Clinic Donation Only"

											<?php
											if ( in_array( 'Clinic Donation Only', $wkdoaccpt ) ) {
												echo 'checked';
											}

											?>
												>
											<label for="choice_2_26_1">Clinic Donation Only</label>
										</div>


										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_26_2" name="wkdoaccpt[]" value="At-Home Donation (Sperm Donors Only)"

											<?php
											if ( in_array( 'At-Home Donation (Sperm Donors Only)', $wkdoaccpt ) ) {
												echo 'checked';
											}

											?>
											>
											<label for="choice_2_26_2">At-Home Donation (Sperm Donors Only)</label>
										</div>


										<div class="wkdo-check-box-flax" >
											<input type="checkbox" id="choice_2_26_3" name="wkdoaccpt[]" value="Frozen Samples Shipped to Clinic of Choice from Overseas"

											<?php
											if ( in_array( 'Frozen Samples Shipped to Clinic of Choice from Overseas', $wkdoaccpt ) ) {
												echo 'checked';
											}

											?>
												>
											<label for="choice_2_26_3">Frozen Samples Shipped to Clinic of Choice from Overseas</label>
										</div>
									</div>
								</div>

								
								<div class="wkdo-form-section">
									<?php
										$donor_rool_for_childe = ! empty( $user_data['donor_rool_for_childe'] ) ? $user_data['donor_rool_for_childe'] : array();
									?>
									<label class="wkdo-label" for="input_2_24"> Are You Looking for a Donor Who Will Play a Role in the Child’s Life? </label>
									<select id="donor-weight" name="donor_rool_for_childe" >
										<option <?php selected( 'Yes', $donor_rool_for_childe ); ?> value="Yes">Yes</option>
										<option <?php selected( 'No', $donor_rool_for_childe ); ?> value="No">No</option>
										<option <?php selected( 'Open to Discussion', $donor_rool_for_childe ); ?> value="Open to Discussion">Open to Discussion</option>
									</select>
								</div>
								

								<div class="wkdo-form-section">
									<?php
										$donor_medical_history = ! empty( $user_data['donor_medical_history'] ) ? $user_data['donor_medical_history'] : array();
									?>
									<label class="wkdo-label" for="input_2_24"> Would You Like Updates on the Donor's Medical History Over Time? </label>
									<select id="donor-weight" name="donor_medical_history" >
										<option <?php selected( 'Yes', $donor_medical_history ); ?> value="Yes">Yes</option>
										<option <?php selected( 'No', $donor_medical_history ); ?> value="No">No</option>
										<option <?php selected( 'Open to Discussion', $donor_medical_history ); ?> value="Open to Discussion">Open to Discussion</option>
									</select>
								</div>


								<div class="wkdo-form-section">
									<?php
										$select_clicnic = ! empty( $user_data['select_fertiity_clicinc'] ) ? $user_data['select_fertiity_clicinc'] : '';
										$select_clicnic = ! empty( $select_clicnic ) ? $select_clicnic : 'no';
										$select_yes     = "style='display:none'";
										$select_no      = "style='display:none'";

									if ( $select_clicnic == 'yes' ) {
										$select_yes = "style='display:block'";
									} else {
										$select_no = "style='display:block'";
									}

									?>
									<label class="wkdo-label" for="select_clinic"> Do you already have a fertility clinic selected? </label>
									<select id="select_clinic" name="select_fertiity_clicinc">
										<option <?php selected( 'No', $select_clicnic ); ?> value="No">No</option>
										<option <?php selected( 'Yes', $select_clicnic ); ?> value="Yes">Yes</option>
									</select>
								</div>
										
								<div class="wkdo-form-section"  >
									<?php $need_clinic = ! empty( $user_data['need_clinic'] ) ? $user_data['need_clinic'] : ''; ?>
									<label class="wkdo-label if-no" for="input_2_24" <?php echo $select_no; ?>> Do you need help finding a clinic?  </label>
									<select id="need_clinic" class="if-no" name="need_clinic" <?php echo $select_no; ?>>
										<option <?php selected( 'No', $need_clinic ); ?> value="No">No</option>
										<option <?php selected( 'Yes', $need_clinic ); ?> value="Yes">Yes</option>
									</select>
								</div>

								<div class="wkdo-form-section if-yes" <?php echo $select_yes; ?>>
									<?php $selected_clinic_name = ! empty( $user_data['selected_clinic_name'] ) ? $user_data['selected_clinic_name'] : ''; ?>
									<label class="wkdo-label" for="input_2_24"> Fill the name of fertility clinic </label>
									<input type="text" name="selected_clinic_name" id="" value="<?php echo $selected_clinic_name; ?>" class="wkdo-text" />
								</div>

								
								<div class="wkdo-form-section">
									<?php

									$type_fertility_treatments = ! empty( $user_data['type_fertility_treatments'] ) ? $user_data['type_fertility_treatments'] : '';
									$treatment                 = array(
										'IVF',
										'IUI',
										'At-home Insemination [Sperm Only]',
									);

									?>
									<label class="wkdo-label" for="input_2_24"> Which fertility treatments are you considering? </label>
									<select id="donor-weight" name="type_fertility_treatments[]" class="wkdo-select-multi" multiple >
										<option value="">Select Fertility Treatments</option>
										<?php
										foreach ( $treatment as $treat ) {
											if ( ! empty( $type_fertility_treatments ) && in_array( $treat, $type_fertility_treatments ) ) {
												$selected = 'selected';
											} else {
												$selected = '';
											}

											echo '<option ' . $selected . ' value="' . $treat . '">' . $treat . '</option>';
										}
										?>
									</select>
								</div>
											


							<div class="wkdo-form-section">
								<h3 class="wkdo-section-title">Tell Us About You</h3>
							</div>

							<?php
								$short_bio = ! empty( $user_data['short_bio'] ) ? $user_data['short_bio'] : '';
							?>

							<div class="wkdo-form-section">
								<label class="wkdo-label" for="input_2_29">Your Short Bio / Our Story / My Story</label>
								<textarea id="input_2_29" class="wkdo-textarea" name="short_bio" rows="10" cols="50"><?php echo $short_bio; ?></textarea>
							</div>

							<?php
								$lookinf_for = ! empty( $user_data['lookinf_for'] ) ? $user_data['lookinf_for'] : '';
							?>

							<div class="wkdo-form-section">
								<label class="wkdo-label" for="input_2_31">What Are You Looking for in a Donor?</label>
								<textarea id="input_2_31" class="wkdo-textarea" name="lookinf_for" rows="10" cols="50"><?php echo $lookinf_for; ?></textarea>
							</div>

							<div class="wkdo-form-section">
								<?php
									$lookinf_for = ! empty( $user_data['future_child'] ) ? $user_data['future_child'] : '';
								?>
								<label class="wkdo-label" for="input_2_31">What Would You Like Your Future Child to Know About Their Origin? (Optional)</label>
								<textarea id="input_2_31" class="wkdo-textarea" name="future_child" rows="10" cols="50"><?php echo $lookinf_for; ?></textarea>
							</div>


							<div class="wkdo-form-section">
								<?php
									$parenting_philosophy = ! empty( $user_data['parenting_philosophy'] ) ? $user_data['parenting_philosophy'] : '';
								?>
								<label class="wkdo-label" for="input_2_31">Do You Have a Parenting Philosophy? (Describe values, beliefs, or approaches you plan to
								take.)</label>
								<textarea id="input_2_31" class="wkdo-textarea" name="parenting_philosophy" rows="10" cols="50"><?php echo $parenting_philosophy; ?></textarea>
							</div>


							<div class="wkdo-form-section">
								<?php
									$doonor_hobies = ! empty( $user_data['doonor_hobies'] ) ? $user_data['doonor_hobies'] : '';
								?>
								<label class="wkdo-label" for="input_2_31">What Hobbies, Interests, or Activities Do You Enjoy?</label>
								<textarea id="input_2_31" class="wkdo-textarea" name="doonor_hobies" rows="10" cols="50"><?php echo $doonor_hobies; ?></textarea>
							</div>

							<?php
								$spacil_msg = ! empty( $user_data['spacil_msg'] ) ? $user_data['spacil_msg'] : '';
							?>

							<div class="wkdo-form-section">
								<label class="wkdo-label" for="input_2_30">Any Special Message for the Donor?</label>
								<textarea id="input_2_30" class="wkdo-textarea" name="spacil_msg" rows="10" cols="50"><?php echo $spacil_msg; ?></textarea>
							</div>

							<hr /> 

							<h3>Enhanced Matching Preferences (For Personalied Matching Service) </h3>


							<div class="wkdo-form-section">
								<?php
									$genetic_condition = ! empty( $user_data['genetic_condition'] ) ? $user_data['genetic_condition'] : '';
								?>
								<label class="wkdo-label" for="input_2_24"> Do You Have Any Genetic Conditions That Should Be Considered? </label>
								<select id="donor-weight" name="genetic_condition" >
									<option <?php selected( 'Yes', $genetic_condition ); ?> value="Yes">Yes</option>
									<option <?php selected( 'No', $genetic_condition ); ?> value="No">No</option>
								</select>
							</div>


							<div class="wkdo-form-section">
								<?php
									$similr_background = ! empty( $user_data['similr_background'] ) ? $user_data['similr_background'] : '';
								?>
								<label class="wkdo-label" for="input_2_24"> Would You Like to Be Matched with a Donor Who Has a Similar Background to Yours? </label>
								<select id="donor-weight" name="similr_background" >
									<option <?php selected( 'Yes', $similr_background ); ?> value="Yes">Yes</option>
									<option <?php selected( 'No', $similr_background ); ?> value="No">No</option>
									<option <?php selected( 'No Preference', $similr_background ); ?> value="No Preference"> No Preference </option>
								</select>
							</div>


							<div class="wkdo-form-section">
								<?php
									$meeting_with_donor = ! empty( $user_data['meeting_with_donor'] ) ? $user_data['meeting_with_donor'] : '';
								?>
								<label class="wkdo-label" for="input_2_24"> Would You Be Open to Meeting or speak to Your Donor Before or After Donation? </label>
								<select id="donor-weight" name="meeting_with_donor" >
									<option <?php selected( 'Yes', $meeting_with_donor ); ?> value="Yes">Yes</option>
									<option <?php selected( 'No', $meeting_with_donor ); ?> value="No">No</option>
									<option <?php selected( 'Maybe', $meeting_with_donor ); ?> value="Maybe">Maybe</option>
								</select>
							</div>


							<div class="wkdo-form-section">
								<?php
									$same_donor = ! empty( $user_data['same-donor'] ) ? $user_data['same-donor'] : '';
								?>
								<label class="wkdo-label" for="input_2_24"> Are You Interested in Connecting with Other Recipients Who Have Used the Same Donor? </label>
								<select id="donor-weight" name="same-donor" >
									<option <?php selected( 'Yes', $same_donor ); ?> value="Yes">Yes</option>
									<option <?php selected( 'No', $same_donor ); ?> value="No">No</option>
									<option <?php selected( 'Maybe', $same_donor ); ?> value="Maybe">Maybe</option>
								</select>
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
									<i id="upload-btn" class="fa fa-pencil wkdo-edit-profile-imagel" aria-hidden="true"></i>
									<!-- <input type="button" name="upload-btn" id="upload-btn" class="wkdo-button-secondary" value="Upload Profile Image"> -->
								<?php } ?>
							</div>
							<hr />
							<?php
								$spacil_msg = ! empty( $user_data['wkdo_gallery_image'] ) ? $user_data['wkdo_gallery_image'] : '';
								$img        = ! empty( $spacil_msg ) ? explode( ',', $spacil_msg ) : array();

							?>
							
							<div class="wkdo-milti-upload-file">
								<input type="hidden" value="<?php echo $spacil_msg; ?>" id="uploaded_images" name="wkdo_gallery_image">
								<div id="image_preview">
								<label for=""> Gallery image </label>
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
								<i id="upload_images_button" class="fa fa-pencil wkdo-edit-profile-imagel" aria-hidden="true"></i>
								<?php } ?>
							</div>

							<div id="registration-message" style="color:red" >

							</div>

							<div class="wkdo-form-section">
								<button type="submit" name="wkdo_save_details" class="wkdo-submit-button"><?php esc_html_e( 'Update Profile', 'wpdonor' ); ?></button>
							</div>

						</div>
					</form>
			</div>
		<?php
	}

		/**
		 * Save the uer details.
		 */
	public function wkd_save_recipient_informattion_template() {
		if ( isset( $_POST['wkdo_save_details'] ) ) {
			$user_id = get_current_user_id();
			if ( is_admin() ) {
				$user_id = ! empty( $_GET['pid'] ) ? $_GET['pid'] : '';
				$user_id = str_replace( "R100", "", $user_id );
			}
			if ( ! empty( $user_id ) ) {
				$data = maybe_unserialize( $_POST );
				update_user_meta( $user_id, 'first_name', sanitize_text_field( wp_unslash( $_POST['wkdo_first_name'] ) ) );
				update_user_meta( $user_id, 'last_name', sanitize_text_field( wp_unslash( $_POST['wkdo_last_name'] ) ) );
				update_user_meta( $user_id, 'wkdo_becom_donor', $data );

				update_user_meta( $user_id, 'wkdo_donor_nationality', sanitize_text_field( wp_unslash( $_POST['wkdo_location'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_relationship', sanitize_text_field( wp_unslash( $_POST['wkdo_re_status'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_blood', sanitize_text_field( wp_unslash( $_POST['wkdo_blood_type'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_location', sanitize_text_field( wp_unslash( $_POST['wkdo_c_location'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_eye', sanitize_text_field( wp_unslash( $_POST['do_eye_color'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_hair ', sanitize_text_field( wp_unslash( $_POST['do_ha_col'] ) ) );
				update_user_meta( $user_id, 'wkdo_donor_religion', sanitize_text_field( wp_unslash( $_POST['don_reli'] ) ) );

				// update_user_meta( $user_id, 'wkdo_becom_donor_status', 'pending' );
				if ( is_admin() ) {
					wp_admin_notice(
						esc_html__( 'User profile updated successfully.', '' ),
						array(
							'type'        => 'success',
							'dismissible' => true,
							'id'          => 'message',
						)
					);
				} else {
					wc_print_notice( esc_html__( 'Profile Updated sucessfully thanks you.', '' ) );
					$data['user_id'] = $user_id;
					$data['user_id'] = $user_id;
					// do_action( 'register_donor_trigger', $data, 'user' );
					// do_action( 'register_donor_trigger', $data, 'admin' );
				}
			}
		}
	}
}
