<?php
/**
 * Front hooks.
 */

class Wkdo_match {
	/**
	 * Become a donor form.
	 *
	 * @return string.
	 */
	public function wkdo_match() {
		ob_start();
		?>
		<style>
			.wkdom_select {
	padding: 27px 19px;
}
span.select2-selection.select2-selection--single {
	height: 54px;
}

.select-wrapper-yed span.select2.select2-container.select2-container--default{
	width: 366px !important;
}

.select-wrapper-yed .select2-container--default .select2-selection--multiple {
	border: solid #e4e4e4 1px;
	outline: 0;
}

span.select2-selection__arrow {
	display: none;
}

.EthnicityType span.select2.select2-container.select2-container--default {
	width: 372px !important;
}

.form-row {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: 20px;
		margin-bottom: 20px;
	}


		</style>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<div class="wkdom_container">
			<div class="form-card">
				<header class="form-header">
					<h1>Donor Search</h1>
					<p>Find your ideal donor</p>
				</header>
				<form action="<?php echo esc_url( site_url( 'donor-search-page' ) ); ?>" method="get" >
					<div class="form-section">
						<h2>Basic Information</h2>
						<div class="form-row">
							<div class="form-group">
								<label for="DonorType">Donor Type</label>
								<div class="select-wrapper">
									<select name="DonorType[]" id="DonorType" class="wkdom_select" multiple>
										<option value="" disabled >Select type</option>
										<option value="Egg Donor">Egg Donor</option>
										<option value="Sperm Donor">Sperm Donor</option>
										<option value="Embryo Donor">Embryo Donor</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="DonorAge">Donor Age</label>
								<div class="select-wrapper">
									<select name="DonorAgee[]" id="DonorAge"class="wkdom_select" multiple>
										<option value="" disabled >Select age</option>
										<option value="18">18-25</option>
										<option value="19">26-30</option>
										<option value="20">30+</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="bloodGroup">Blood Type</label>
								<div class="select-wrapper">
									<select name="bloodGroup[]" id="bloodGroup" class="wkdom_select" multiple>
										<option value="" disabled >Select blood type</option>
										<option value="A+">A+</option>
										<option value="A-">A-</option>
										<option value="B+">B+</option>
										<option value="B-">B-</option>
										<option value="AB+">AB+</option>
										<option value="AB-">AB-</option>
										<option value="O+">O+</option>
										<option value="O-">O-</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="form-section">
						<h2>Physical Characteristics</h2>
						<div class="form-row">
							<div class="form-group">
								<label for="EthnicityType">Ethnicity</label>
								<div class="select-wrapper EthnicityType">
									<?php 
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
									<select name="EthnicityType" class="wkdom_select_eth" id="EthnicityType[]" multiple>
									<?php foreach ( $ethnicities as $ethnicity ) { ?>
										<option value="<?php echo esc_attr( $ethnicity ); ?>"><?php echo esc_html( $ethnicity ); ?></option>
										<?php } ?>
									</select>
								</div> 
							</div>

							<div class="form-group">
								<label for="DonorHairColor">Hair Color</label>
								<div class="select-wrapper">
									<select name="DonorHairColor[]" class="wkdom_select" id="DonorHairColor" multiple>
										<option value="" disabled >Select hair color</option>
										<option value="black">Black</option>
										<option value="dark-brown">Dark Brown</option>
										<option value="brown">Brown</option>
										<option value="auburn">Auburn</option>
										<option value="chestnut">Chestnut</option>
										<option value="red/ginger">Red / Ginger Blonde</option>
										<option value="strawberry_blonde">Strawberry Blonde</option>
										<option value="dirty_blonde">'Dirty Blonde / Ash Blonde</option>
										<option value="platinum">Platinum Blonde / White Blonde Gray / Silver</option>
										<option value="white">White</option>
									</select>
								</div>
							</div>   

							<div class="form-group">
								<label for="DonorEyeColor">Eye Color</label>
								<div class="select-wrapper">
									<select name="DonorEyeColor[]" class="wkdom_select" id="DonorEyeColor" multiple>
										<option value="" disabled >Select eye color</option>
										<option value="brown">Brown</option>
										<option value="dark Brown">Dark Brown / Almost Black</option>
										<option value="hazel">Hazel</option>
										<option value="amber">Amber</option>
										<option value="green">Green</option>
										<option value="blue">Blue</option>
										<option value="gray">Gray</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group">
								<label for="RaceType">Race</label>
								<div class="select-wrapper select-wrapper-yed">
									<select name="RaceType[]" class="multiselect" multiple >
										<option value="american_indian_alaska_native">American Indian or Alaska Native</option>
										<option value="asian_east">Asian – East Asian</option>
										<option value="asian_south">Asian – South Asian </option>
										<option value="asian_southeast">Asian – Southeast Asian</option>
										<option value="black_african">Black or African Descent – African</option>
										<option value="black_caribbean">Black or African Descent – Caribbean</option>
										<option value="black_african_american">Black or African American</option>
										<option value="middle_eastern_north_african">Middle Eastern or North African</option>
										<option value="mixed_multiracial">Mixed or Multiracial</option>
										<option value="native_hawaiian_pacific_islander">Native Hawaiian or Other Pacific Islander</option>
										<option selected="selected" value="white_european">White – European</option>
										<option value="white_american">White – American</option>
										<option value="white_other">White – Other</option>
										<option value="Other">Other</option>
									</select>
								</div> 
							</div>

							<div class="form-group">
								<label for="DonorHeight">Height</label>
								<div class="select-wrapper">
									<select name="DonorHeights[]" class="wkdom_select" id="DonorHeight" multiple >
											<option value="">Select Height Range</option>
											<option <?php selected( 'below_5ft', $do_height ); ?>  value="below_5ft">Below 5'0" (152 cm)</option>
											<option <?php selected( '5ft_5ft4', $do_height ); ?> value="5ft_5ft4">5'0" - 5'4" (152 - 163 cm)</option>
											<option <?php selected( '5ft5_5ft8', $do_height ); ?> value="5ft5_5ft8">5'5" - 5'8" (165 - 173 cm)</option>
											<option <?php selected( '5ft9_6ft', $do_height ); ?> value="5ft9_6ft">5'9" - 6'0" (175 - 183 cm)</option>
											<option <?php selected( 'above_6ft', $do_height ); ?> value="above_6ft">Above 6'0" (183+ cm)</option>
										</select>

								</div>
							</div>

							<div class="form-group">
								<label for="DonorWeight">Weight</label>
								<div class="select-wrapper">
									

									<select name="DonorWeightt[]" class="wkdom_select" id="DonorWeight" multiple >
										<option <?php selected( '1', $donor_weight ); ?>  value="1">Select Weight Range</option>
										<option <?php selected( 'below_50kg', $donor_weight ); ?> value="below_50kg">Below 50 kg (110 lbs)</option>
										<option <?php selected( '50kg_60kg', $donor_weight ); ?> value="50kg_60kg">50 - 60 kg (110 - 132 lbs)</option>
										<option <?php selected( '61kg_70kg', $donor_weight ); ?> value="61kg_70kg">61 - 70 kg (134 - 154 lbs)</option>
										<option <?php selected( '71kg_85kg', $donor_weight ); ?> value="71kg_85kg">71 - 85 kg (156 - 187 lbs)</option>
										<option <?php selected( 'above_85kg', $donor_weight ); ?> value="above_85kg">Above 85 kg (187+ lbs)</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="form-section">
						<h2>Background & Demographics</h2>
						<div class="form-row">
							<div class="form-group">
								<label for="DonorEducation">Education</label>
								<div class="select-wrapper select-wrapper-gg">
									<select name="DonorEducation[]" class="wkdom_selectss" id="DonorEducation" multiple>
										<option value="" disabled >Select education</option>
										<option value="High School">High School</option>
										<option value="Some College">Some College</option>
										<option value="Associates Degree">Associates Degree</option>
										<option value="Bachelors Degree">Bachelors Degree</option>
										<option value="Masters Degree">Masters Degree</option>
										<option value="Doctorate">Doctorate</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="DonorReligion">Religion</label>
								<div class="select-wrapper">
									<select name="DonorReligion[]" class="wkdom_select" id="DonorReligion" multiple>
										<option value="Agnostic"> Agnostic </option>
										<option value="Atheist"> Atheist </option>
										<option value="Baha'i"> Baha'i </option>
										<option value="Buddhist"> Buddhist </option>
										<option value="Christian – Catholic"> Christian – Catholic </option>
										<option value="Christian – Protestant"> Christian – Protestant </option>
										<option value="Christian – Other"> Christian – Other </option>
										<option selected="selected" value="Hindu"> Hindu </option>
										<option value="Jewish"> Jewish </option>
										<option value="Jain"> Jain </option>
										<option value="Muslim"> Muslim </option>
										<option value="Pagan"> Pagan </option>
										<option value="Rastafarian"> Rastafarian </option>
										<option value="Sikh"> Sikh </option>
										<option value="Spiritual but not religious"> Spiritual but not religious </option>
										<option value="Zoroastrian"> Zoroastrian </option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label for="DonorMaritalStatus">Marital Status</label>
								<div class="select-wrapper">
									<select name="DonorMaritalStatus" class="wkdom_select" id="DonorMaritalStatus">
										<option selected="selected" value="single">Single</option>
										<option value="In a relationship">In a relationship</option>
										<option value="Engaged ">Engaged </option>
										<option value="married">Separated</option>
										<option value="Separated">Separated</option>
										<option value="Divorced">Divorced</option>
										<option value="Widowed">Widowed</option>
										<option value="In a civil partnership">In a civil partnership</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn-submit">Find Donor</button>
					</div>
				</form>
			</div>
		</div>
		<script>
			
		</script>
		<?php
		$htmlContent = ob_get_clean();
		return $htmlContent;
	}
}
