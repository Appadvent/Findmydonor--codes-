// document.addEventListener(
// 	'DOMContentLoaded',
// 	function () {
// 		document.getElementById( 'custom-registration-form' ).addEventListener(
// 			'submit',
// 			function (event) {
// 				var password = document.getElementById( 'password' ).value;
// 				if (password.length < 8) {
// 					event.preventDefault();
// 					document.getElementById( 'registration-message' ).innerHTML = 'Password must be at least 8 characters long.';
// 				}
// 			}
// 		);
// 	}
// );

jQuery( document ).ready(
	function ($) {
		jQuery( '#upload-btn' ).click(
			function (e) {
				e.preventDefault();

				var custom_uploader = wp.media(
					{
						title: 'Choose Image',
						button: {
							text: 'Choose Image'
						},
						multiple: false // Set to true if you want to allow multiple files
					}
				)
				.on(
					'select',
					function () {
						var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
						jQuery( '#my_custom_image' ).val( attachment.url );
						jQuery( '.wkdo-profile-image-preview' ).html( '<img src="' + attachment.url + '" alt="Profile Image" style="max-width: 200px; height: auto;">' )
					}
				)
				.open();
			}
		);
	}
);


function calculateAge(birthDate) {
	const birth     = new Date( birthDate );
	const today     = new Date();
	let age         = today.getFullYear() - birth.getFullYear();
	const monthDiff = today.getMonth() - birth.getMonth();
	const dayDiff   = today.getDate() - birth.getDate();

	if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
		age--;
	}

	return age;
}

jQuery( document ).ready(
	function () {
		jQuery( "#custom-registration-form" ).on(
			"submit",
			function (event) {
				const dob = jQuery( "#wkdoagdob" ).val();
				if ( ! dob) {
					jQuery( "#registration-message" ).text( "Please enter your date of birth." );
					event.preventDefault();
				}

				const age = calculateAge( dob );
				if ( age < 18 ) {
					jQuery( "#registration-message" ).text( "Error: You must be at least 18 years old." );
					event.preventDefault();
				}
			}
		);
	}
);


document.querySelectorAll('input[name="genetic_conditions"]').forEach(el => {
    el.addEventListener('change', function () {
      document.getElementById('genetic-details').style.display = this.value === 'yes' ? 'block' : 'none';
    });
  });

  // Toggle visibility for allergy details
  document.querySelectorAll('input[name="allergies"]').forEach(el => {
    el.addEventListener('change', function () {
      document.getElementById('allergy-details').style.display = this.value === 'yes' ? 'block' : 'none';
    });
  });

  jQuery(document).ready(function ($) {

	function initUploader(buttonId, previewContainerId, hiddenFieldId, type = 'image') {
	  let uploader;
  
	  $(buttonId).on('click', function (e) {
		e.preventDefault();
  
		if (uploader) {
		  uploader.open();
		  return;
		}
  
		uploader = wp.media({
		  title: type === 'video' ? 'Select a Video' : 'Select Images',
		  button: { text: type === 'video' ? 'Use This Video' : 'Use These Images' },
		  library: {
			type: type
		  },
		  multiple: type !== 'video'
		});
  
		uploader.on('select', function () {
		  const selection = uploader.state().get('selection').toJSON();
		  const urls = [];
  
		  $(previewContainerId).html('');
  
		  selection.forEach(function (file) {
			urls.push(file.url);
  
			if (file.mime.startsWith('image/')) {
			  $(previewContainerId).append(`<img src="${file.url}" width="100" style="margin:5px; border:1px solid #ccc;">`);
			} else if (file.mime.startsWith('video/')) {
			  $(previewContainerId).append(`
				<video width="200" controls style="margin:5px; border:1px solid #ccc;">
				  <source src="${file.url}" type="${file.mime}">
				  Your browser does not support the video tag.
				</video>
			  `);
			} else {
			  $(previewContainerId).append(`<p>Unsupported file: ${file.url}</p>`);
			}
		  });
  
  
		  $(hiddenFieldId).val(urls.join(','));
		});
  
		uploader.open();
	  });
	}
  
	// All uploaders
	initUploader('#upload_images_button', '#image_preview', '#uploaded_images');
	initUploader('#Genetic_Screening_Report', '#Genetic_Screening_Report_image_preview', '#Genetic_Screening_Report_image_preview_uploaded_images');
	initUploader('#Blood_report', '#Blood_report_image_preview', '#Blood_report_image_preview_uploaded_images');
	initUploader('#medical_history', '#medical_history_image_preview', '#medical_history_preview_uploaded_images');
	initUploader('#psychological_assessment', '#psychological_assessment_image_preview', '#psychological_assessment_preview_uploaded_images');
  
	// Video uploader
	initUploader('#short_video', '#short_video_image_preview', '#short_video_preview_uploaded_images',  ['image', 'video'] );
  });
  

jQuery( document ).ready(

document.addEventListener(
	"DOMContentLoaded",
	function () {
		//lucide.createIcons();

		const tabs        = document.querySelectorAll( ".donor-tab" );
		const tabContents = document.querySelectorAll( ".tab-content" );

		tabs.forEach(
			(tab) => {
            tab.addEventListener(
					"click",
					() => {
                    tabs.forEach( (t) => t.classList.remove( "active" ) );
                    tab.classList.add( "active" );
                    tabContents.forEach( (content) => content.classList.add( "hidden" ) );
                    const tabId = tab.getAttribute( "data-tab" );
                   document.getElementById( tabId+'-tab' ).classList.remove( "hidden" );
					}
				);
			}
		);

		const accordionTitles = document.querySelectorAll( ".donor-accordion-title" );

		accordionTitles.forEach(
			(title) => {
            title.addEventListener(
					"click",
					() => {
                    const section = title.getAttribute( "data-section" );
                    const content = document.getElementById( section+'-section' );
                    const arrow   = title.querySelector( "svg" );
                    content.classList.toggle( "collapsed" );
                    if (content.classList.contains( "collapsed" )) {
                        arrow.classList.remove( "rotate-180" );
                        arrow.classList.add( "rotate-0" );
                    } else {
                    arrow.classList.remove( "rotate-0" );
                    arrow.classList.add( "rotate-180" );
                    }
					}
				);
			}
		);

		const galleryThumbs = document.querySelectorAll( ".donor-thumb" );
		const mainImage     = document.querySelector( ".relative > img" );

		galleryThumbs.forEach(
			(thumb) => {
            thumb.addEventListener(
					"click",
					() => {
                    const src = thumb.getAttribute( "src" );
                    mainImage.setAttribute( "src", src );
					}
				);
			}
		);
	}
)
);


jQuery(document).ready(function($) {
    jQuery('#do_contact').click(function() {
		jQuery('#do_contact').hide();
		jQuery('#show_text').html('Please wait...');
		jQuery.ajax({
            type: 'POST',
            url: wkdoscript.ajaxurl,
            data: {
                action: 'wkdo_ajax_action',
                pid: wkdoscript.pid
            },
            success: function( response ) {
				jQuery('#show_text').html('');
                alert( response );
            }
        });
    });
});


jQuery(document).ready(function($) {

	jQuery("#DonorType").select2({
		placeholder: "Select type",
		allowClear: true
	});
	jQuery("#DonorAge").select2({
		placeholder: "Select age",
		allowClear: true
	});
	jQuery("#bloodGroup").select2({
		placeholder: "Select blood type",
		allowClear: true
	});

	jQuery("#DonorHairColor").select2({
		placeholder: "Select hair color",
		allowClear: true
	});

	jQuery("#DonorEyeColor").select2({
		placeholder: "Select eye color",
		allowClear: true
	});

	jQuery("#DonorHeight").select2({
		placeholder: "Select height",
		allowClear: true
	});


	jQuery("#DonorWeight").select2({
		placeholder: "Select weight",
		allowClear: true
	});

	jQuery("#DonorReligion").select2({
		placeholder: "Select religion",
		allowClear: true
	});

	jQuery("#DonorMaritalStatus").select2({
		placeholder: "Select type",
		allowClear: true
	});

	jQuery("#wkdo_avalabl_donate").select2({
		placeholder: "Select type",
		allowClear: true
	});


	jQuery(".wkdo-select-multi").select2({
		
		allowClear: true
	});

	jQuery(".multiselect").select2({
		
		allowClear: true
	});

	jQuery(".wkdom_selectss").select2({
		
		allowClear: true
	});

	jQuery(".wkdom_select_eth").select2({
		
		allowClear: true
	});


	});


jQuery(document).ready(function () {


	jQuery('#select_clinic').change(function () {

		if (jQuery(this).val() === "Yes") {
		   jQuery('.if-yes').show();
		   jQuery('.if-no').hide();
		} else{
			jQuery('.if-no').show();
			jQuery('.if-yes').hide();
		}
	});

	jQuery('#personally_matched').change(function () {

		if (jQuery(this).val() === "Yes") {
		   jQuery('.ifyes').show();
		} else{
			jQuery('.ifyes').hide();
		}
	});



	jQuery('.radioOption').change(function () {
		 if (jQuery('.radioOption:checked').val() === "Yes") {
			jQuery('.wkdo_radio_flex_hide').show();
		 } else{
			jQuery('.wkdo_radio_flex_hide').hide();
		 }
	 });

	 jQuery('.Have_Children').change(function () {
		if (jQuery('.Have_Children:checked').val() === "Yes") {
		   jQuery('.Have_Children_Hide').show();
		} else{
		   jQuery('.Have_Children_Hide').hide();
		}
     });


    function scrollToBottom() {
        var div = document.getElementById("wkdo_recipent_converstion");
        if (div) {
            div.scrollTop = div.scrollHeight;
        }
    }

    window.onload = scrollToBottom;
 });

 jQuery(document).ready(function () {

	const openModal = document.getElementById('wkdb-open-booking');
        const closeModal = document.getElementById('wkdb-close-modal');
        const modal = document.getElementById('wkdb-booking-modal');

     if (openModal) {
         // Open modal function
         openModal.addEventListener('click', function () {
             modal.style.display = 'flex';
         });
     }

        // Close modal function
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });


 });

 document.addEventListener('DOMContentLoaded', function () {
	const bookingForm = document.getElementById('wkdb-booking-form');
	const modal = document.getElementById('wkdb-booking-modal');
	bookingForm.addEventListener('submit', function (event) {
		event.preventDefault();

		const formData = {
			action: 'wdo_save_booking',
			email: document.getElementById('wkdb-email').value,
			phone: document.getElementById('wkdb-mobile').value,
			date: document.getElementById('wkdb-date').value,
			message: document.getElementById('wkdb-message').value,
			_ajax_nonce: wkdoscript.nonce
		};

		fetch(wkdoscript.ajaxurl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: new URLSearchParams(formData)
		})
		.then(res => res.json())
		.then(response => {
			if (response.success) {
				alert(response.data.message);
				modal.style.display = 'none';
				bookingForm.reset();
			} else {
				alert('Booking failed.');
			}
		});
	});
 });




jQuery(document).ready(function($) {
   jQuery('#wkd_send_message').on('click', function(e) {
        e.preventDefault();

        const content = $('#wkcontent').val();

        if (!content.trim()) {
            alert('Please enter a message.');
            return;
        }

        const data = {
            action: 'wkd_send_message',
            sender_id: $('#sender_id').val(),
            recipient_id: $('#recipient_id').val(),
            donor_id: $('#donor_id').val(),
            group_id: $('#group_id').val(),
            content: content,
            sent_at: new Date().toISOString(),
            read_at: '',
        };

		var html_cont = ' <div class="wkdo-message wkdo-sent"> ' + '<span class="username">'+wkdoscript.user_name+'</span>' + content + '</div>';

		jQuery('#wkdo-chat-body').append(html_cont);
		var chatBox = document.getElementById("wkdo-chat-body");
		chatBox.scrollTop = chatBox.scrollHeight;
		jQuery('#wkcontent').val('');

        jQuery.post(wkdoscript.ajaxurl, data, function(response) {
            if (response.success) {

              
            } else {
                console.error('Error:', response.data);
                alert('Message failed to send.');
            }
        }).fail(function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            alert('Server error occurred.');
        });
    });
});
jQuery(document).ready(function($) {
    let isFetching = false;

    function fetchMessages() {
        if ($('#wkd_send_message').length && !isFetching) {
            isFetching = true;

            $.ajax({
                url: wkdoscript.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'wkd_fetch_messages',
                    group_id: $('#group_id').val()
                },
                success: function(response) {
                    console.log("AJAX response:", response); // For debugging

                    if (response.success && Array.isArray(response.data)) {
                        var messagesHtml = '';
                        response.data.forEach(function(message) {
                            messagesHtml += '<div class="wkdo-message wkdo-received">' +
                                '<span class="username">' + message.sender_name + ':</span> ' +
                                '<span>' + message.content + '</span>' +
                                '</div>';
                        });

                        $('#wkdo-chat-body').append(messagesHtml);

                        var chatBox = document.getElementById("wkdo-chat-body");
                        chatBox.scrollTop = chatBox.scrollHeight;
                    } else {
                        console.warn('Unexpected response format:', response);
                    }
                },
                error: function(err) {
                    console.error('AJAX error:', err);
                },
                complete: function() {
                    isFetching = false;
                }
            });
        }
    }

    setInterval(fetchMessages, 3000); // Run every 3 seconds
});




  /**  
    //const ws      = new WebSocket("ws://localhost:8080");
    const ws = new WebSocket("wss://sperm-donor.appadvent.com:8080");
    const chatBox = document.getElementById("wkdo-chat-body");
	const wgroup_id = jQuery('#group_id').val();

	

       ws.onmessage = (event) => {
        const msg = JSON.parse(event.data);
		if( msg.group_id == wgroup_id ) {



			const messageDiv = document.createElement("div");
			if( jQuery('#sender_id').val() == msg.user_id ) {
				messageDiv.className = "wkdo-message wkdo-sent";
			} else{
				messageDiv.className = "wkdo-message wkdo-received";
			}

			messageDiv.innerHTML = `<span class="username">${msg.user}</span> ${msg.text}`;

			chatBox.appendChild(messageDiv);
			chatBox.scrollTop = chatBox.scrollHeight;
		}
    };
***/
//     document.getElementById("wkd_send_message").addEventListener("click", function(e) {
//         e.preventDefault();

//         const content = document.getElementById("wkcontent");
//         const message = content.value;
       
//         if (message.trim()) {
			

//             // ws.send(JSON.stringify({
//             //     user: user.name,
//             //     role: user.role,
//             //     text: message,
// 			// 	group_id: jQuery('#group_id').val(),
// 			// 	user_id: jQuery('#sender_id').val(),
//             // }));

//             // content.value = ""; 
			
//         }
//     });

// });


jQuery(document).ready(function($) {
	Fancybox.bind('[data-fancybox="gallery"]', {
		Toolbar: {
		  display: [
			"zoom",
			"slideshow",
			"download", // ✅ Show download button
			"close"
		  ]
		}
	  });
});  

jQuery(document).ready(function() {
    jQuery('.wdpo-button').on('click', function(e) {
        e.preventDefault();

        const $this = jQuery(this);

        // Hide all other dropdowns and remove their active class
        jQuery('.wdpo-button').not($this).removeClass('active').siblings('div.wdpo-select').slideUp();

        // Toggle current dropdown and active class
        $this.toggleClass('active').siblings('div.wdpo-select').slideToggle();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('wkd-password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle icon class
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('custom-registration-form');
    const submitButton = form.querySelector('input[type="submit"]');
    const inputs = form.querySelectorAll('input[required], select[required]');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');

    submitButton.addEventListener('click', function(e) {
        let isValid = true;
        let errorMessage = "";

        inputs.forEach(function(input) {
            if (input.value.trim() === '') {
                input.classList.add('error-border');
                isValid = false;
            }
        });

        // Username Format Validation
        const usernameRegex = /^[a-zA-Z0-9._]+$/; 
        if (usernameField && usernameField.value.trim() !== '') {
            if (!usernameRegex.test(usernameField.value.trim())) {
                usernameField.classList.add('error-border');
                isValid = false;
                errorMessage = "Invalid username format. Only letters, numbers, dot (.) and underscore (_) are allowed.";
            }
        }

        // Email Format Validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField && emailField.value.trim() !== '') {
            if (!emailRegex.test(emailField.value.trim())) {
                emailField.classList.add('error-border');
                isValid = false;
                errorMessage = "Invalid email address format.";
            }
        }

        if (!isValid) {
            e.preventDefault();
            document.getElementById('registration-message').innerText = errorMessage !== "" ? errorMessage : "Please fill all required fields.";
        } else {
            document.getElementById('registration-message').innerText = "";
        }
    });

    inputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            input.classList.remove('error-border');
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mepr-open-cancel-confirm').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault(); // Stop default anchor behavior

            // Extract ID from href
            const href = this.getAttribute('href'); // e.g., "#mepr-cancel-sub-39"
            const match = href.match(/#mepr-cancel-sub-(\d+)/);

            if (match && match[1]) {
                const subId = match[1]; // e.g., 39
                const confirmed = confirm("Are you sure you want to cancel this subscription?");
                if (confirmed) {
                    // Redirect to your desired URL with the subscription ID
                    window.location.href =  wkdoscript.site_url + '/my-account/member_ship_list/?action=cancel&sub=' + subId;
                }
            }
        });
    });
});