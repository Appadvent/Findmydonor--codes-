<?php
/**
 * Front hooks.
 */

class Wkdo_reister {
	public $user_id;

	/**
	 * Construct function.
	 */
	public function __construct( $user_id = null ) {
		$this->user_id = $user_id;
	}

	/**
	 * Become a donor form.
	 *
	 * @return string.
	 */
	public function wkdo_donor_content() {
		$user_data = array();
		if ( ! empty( $this->user_id ) ) {
			$user_data =
		}
		?>
		<div class="wkdo-form-container">
			<form class="wkdo-form" method="post" enctype="multipart/form-data" id="gform_2" action="/recipient-registration/" data-formid="2" novalidate="">
				<div class="wkdo-form-body">
					<div class="wkdo-form-section">
						<h3 class="wkdo-section-title">Tell Us About Yourself</h3>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_4">Full Name</label>
						<input type="text" id="input_2_4" class="wkdo-input" name="input_4" placeholder="Full Name">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_7">Phone</label>
						<input type="tel" id="input_2_7" class="wkdo-input" name="input_7">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_6">Email</label>
						<input type="email" id="input_2_6" class="wkdo-input" name="input_6">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_8">Date of Birth</label>
						<input type="text" id="input_2_8" class="wkdo-input datepicker" name="input_8" placeholder="Date of Birth">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_9">Gender</label>
						<select id="input_2_9" class="wkdo-select" name="input_9">
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Non-binary">Non-binary</option>
							<option value="Other">Other</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_10">Nationality</label>

						<select name="input_10" id="input_2_10" class="wkdo-select" aria-invalid="false"><option value="" selected="selected" class="gf_placeholder">Nationality</option><option value="Afghanistan">Afghanistan</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="Bouvet Island">Bouvet Island</option><option value="Brazil">Brazil</option><option value="British Indian Ocean Territory">British Indian Ocean Territory</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cabo Verde">Cabo Verde</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Cocos Islands">Cocos Islands</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Curaçao">Curaçao</option><option value="Cyprus">Cyprus</option><option value="Czechia">Czechia</option><option value="Côte d'Ivoire">Côte d'Ivoire</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Eswatini">Eswatini</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands">Falkland Islands</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="French Southern Territories">French Southern Territories</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option><option value="Holy See">Holy See</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Isle of Man">Isle of Man</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jersey">Jersey</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option><option value="Korea, Republic of">Korea, Republic of</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montenegro">Montenegro</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk Island">Norfolk Island</option><option value="North Macedonia">North Macedonia</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau">Palau</option><option value="Palestine, State of">Palestine, State of</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Pitcairn">Pitcairn</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Réunion">Réunion</option><option value="Saint Barthélemy">Saint Barthélemy</option><option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option><option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Martin">Saint Martin</option><option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option><option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia">Serbia</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Sint Maarten">Sint Maarten</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option><option value="South Sudan">South Sudan</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syria Arab Republic">Syria Arab Republic</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania, the United Republic of">Tanzania, the United Republic of</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks and Caicos Islands">Turks and Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="Türkiye">Türkiye</option><option value="US Minor Outlying Islands">US Minor Outlying Islands</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United Kingdom">United Kingdom</option><option value="United States">United States</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Venezuela">Venezuela</option><option value="Viet Nam">Viet Nam</option><option value="Virgin Islands, British">Virgin Islands, British</option><option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option><option value="Wallis and Futuna">Wallis and Futuna</option><option value="Western Sahara">Western Sahara</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option><option value="Åland Islands">Åland Islands</option></select>

					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_11">Race</label>
						<select id="input_2_11" class="wkdo-select" name="input_11">
							<option value="">Race</option>
							<option value="Black">Black</option>
							<option value="White">White</option>
							<option value="Asian">Asian</option>
							<option value="Mixed">Mixed</option>
							<option value="Indigenous">Indigenous</option>
							<option value="Other">Other</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_12">Ethnicity</label>
						<select id="input_2_12" class="wkdo-select" name="input_12">
							<option value="">Ethnicity</option>
							<option value="African">African</option>
							<option value="Caribbean">Caribbean</option>
							<option value="South Asian">South Asian</option>
							<option value="Middle Eastern">Middle Eastern</option>
							<option value="Hispanic">Hispanic</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_13">Relationship Status</label>
						<select id="input_2_13" class="wkdo-select" name="input_13">
							<option value="">Relationship Status</option>
							<option value="Single">Single</option>
							<option value="Married">Married</option>
							<option value="In a Relationship">In a Relationship</option>
							<option value="LGBTQ+ Couple">LGBTQ+ Couple</option>
							<option value="Heterosexual Couple">Heterosexual Couple</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_14">Current Location</label>
						<select id="input_2_14" class="wkdo-select" name="input_14">
							<!-- Add more options as needed -->
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_15">Willing to Accept a Donor From:</label>
						<select id="input_2_15" class="wkdo-select" name="input_15">
							<option value="UK Only">UK Only</option>
							<option value="Europe">Europe</option>
							<option value="North America">North America</option>
							<option value="South America">South America</option>
							<option value="Asia">Asia</option>
							<option value="Australia &amp; New Zealand">Australia &amp; New Zealand</option>
							<option value="Africa">Africa</option>
							<option value="Worlwide">Worlwide</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<h3 class="wkdo-section-title">Donor Preferences</h3>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_18">What Type of Donor Are You Looking For</label>
						<select id="input_2_18" class="wkdo-select" name="input_18">
							<option value="">What Type of Donor Are You Looking For</option>
							<option value="Egg">Egg</option>
							<option value="Sperm">Sperm</option>
							<option value="Embryo Donor">Embryo Donor</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_16">Preferred Donor Ethnicity</label>
						<select id="input_2_16" class="wkdo-select" name="input_16">
							<option value="">Preferred Donor Ethnicity</option>
							<option value="African">African</option>
							<option value="Caribbean">Caribbean</option>
							<option value="South Asia">South Asia</option>
							<option value="Middle Ester">Middle Ester</option>
							<option value="Hispanic">Hispanic</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_19">Preferred Donor Blood Type</label>
						<select id="input_2_19" class="wkdo-select" name="input_19">
							<option value="">Preferred Donor Blood Type</option>
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

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_20">Preferred Donor Eye Color</label>
						<select id="input_2_20" class="wkdo-select" name="input_20">
							<option value="">Preferred Donor Eye Color</option>
							<option value="Black">Black</option>
							<option value="Brown">Brown</option>
							<option value="Blue">Blue</option>
							<option value="Green">Green</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_21">Preferred Donor Hair Color</label>
						<select id="input_2_21" class="wkdo-select" name="input_21">
							<option value="">Preferred Donor Hair Color</option>
							<option value="Black">Black</option>
							<option value="Blonde">Blonde</option>
							<option value="Brown">Brown</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_22">Preferred Donor Religion</label>
						<select id="input_2_22" class="wkdo-select" name="input_22">
							<option value="">Preferred Donor Religion</option>
							<option value="Christianity">Christianity</option>
							<option value="Islam">Islam</option>
							<option value="Hinduism">Hinduism</option>
							<option value="Buddhism">Buddhism</option>
						</select>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_23">Height Preference (cm or ft/in)</label>
						<input type="number" id="input_2_23" class="wkdo-input" name="input_23" placeholder="Height Preference (cm or ft/in)">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_24">Weight Preference (cm or ft/in)</label>
						<input type="number" id="input_2_24" class="wkdo-input" name="input_24" placeholder="Weight Preference (cm or ft/in)">
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label">Preferred Donation Method:</label>
						<div class="wkdo-checkbox-group">
							<input type="checkbox" id="choice_2_25_1" name="input_25.1" value="Anonymous Donor">
							<label for="choice_2_25_1">Anonymous Donor</label>
							<input type="checkbox" id="choice_2_25_2" name="input_25.2" value="Open-ID Donor (Willing to be identified at 18+)">
							<label for="choice_2_25_2">Open-ID Donor (Willing to be identified at 18+)</label>
							<input type="checkbox" id="choice_2_25_3" name="input_25.3" value="Known Donor (Willing to be in contact immediately)">
							<label for="choice_2_25_3">Known Donor (Willing to be in contact immediately)</label>
						</div>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label">Would You Accept</label>
						<div class="wkdo-checkbox-group">
							<input type="checkbox" id="choice_2_26_1" name="input_26.1" value="Clinic Donation Only">
							<label for="choice_2_26_1">Clinic Donation Only</label>
							<input type="checkbox" id="choice_2_26_2" name="input_26.2" value="At-Home Donation (Sperm Donors Only)">
							<label for="choice_2_26_2">At-Home Donation (Sperm Donors Only)</label>
							<input type="checkbox" id="choice_2_26_3" name="input_26.3" value="Frozen Samples Shipped to Clinic of Choice from Overseas">
							<label for="choice_2_26_3">Frozen Samples Shipped to Clinic of Choice from Overseas</label>
						</div>
					</div>

					<div class="wkdo-form-section">
						<h3 class="wkdo-section-title">Tell Us About You</h3>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_29">Your Short Bio / Our Story / My Story</label>
						<textarea id="input_2_29" class="wkdo-textarea" name="input_29" rows="10" cols="50"></textarea>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_31">What Are You Looking for in a Donor?</label>
						<textarea id="input_2_31" class="wkdo-textarea" name="input_31" rows="10" cols="50"></textarea>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label" for="input_2_30">Any Special Message for the Donor?</label>
						<textarea id="input_2_30" class="wkdo-textarea" name="input_30" rows="10" cols="50"></textarea>
					</div>

					<div class="wkdo-form-section">
						<h3 class="wkdo-section-title">Membership Plan for Recipients</h3>
					</div>

					<div class="wkdo-form-section">
						<label class="wkdo-label">Choose Membership Level</label>
						<div class="wkdo-radio-group">
							<input type="radio" id="choice_2_34_0" name="input_34" value="Free: Browse donor profiles only">
							<label for="choice_2_34_0">Free: Browse donor profiles only</label>
							<input type="radio" id="choice_2_34_1" name="input_34" value="Premium: Can request contact with a donor through admin (Paid Subscription Required)">
							<label for="choice_2_34_1">Premium: Can request contact with a donor through admin (Paid Subscription Required)</label>
						</div>
					</div>

					<div class="wkdo-form-section">
						<button type="submit" class="wkdo-submit-button">Submit</button>
					</div>
				</div>
			</form>
		</div>
		<?php
	}
}
