function scrollToBottom() {
	var div       = document.getElementById( "wkdo_recipent_converstion" );
	//div.scrollTop = div.scrollHeight;
}

// Scroll to bottom when the page loads
window.onload = scrollToBottom;


jQuery( document ).ready(
	function ($) {
		jQuery( '#wkd_send_message' ).on(
			'click',
			function (e) {
				e.preventDefault();

				const data = {
					action: 'wkd_send_message',
					sender_id: jQuery( '#sender_id' ).val(),
					recipient_id: jQuery( '#recipient_id' ).val(),
					donor_id: jQuery( '#donor_id' ).val(),
					group_id: jQuery( '#group_id' ).val(),
					content: jQuery( '#content' ).val(),
					sent_at: new Date().toISOString(),
					read_at: '',
					message: jQuery( '#message' ).val(),
				};
				var content = jQuery( '#content' ).val();
				var html_cont = ' <div class="wkdo-message wkdo-sent"> ' + '<span class="username">'+wkd_ajax_obj.user_name+'</span>' + content + '</div>';

				jQuery('#wkdo-chat-body').append(html_cont);
				var chatBox = document.getElementById("wkdo-chat-body");
				chatBox.scrollTop = chatBox.scrollHeight;

				jQuery.post(
					wkd_ajax_obj.ajax_url,
					data,
					function (response) {
						$( '#content' ).val( '' );
					}
				);
			}
		);



		jQuery(document).ready(function($) {
    		let isFetching = false;

			function fetchMessages() {
				console.log("Fetching messages..."); // For debugging
				if (jQuery('#wkd_send_message').length && !isFetching) {
					isFetching = true;

					jQuery.ajax({
						url: wkd_ajax_obj.ajax_url,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'wkd_fetch_messages_admin',
							group_id: jQuery('#group_id').val()
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

								jQuery('#wkdo-chat-body').append(messagesHtml);

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

    		setInterval(fetchMessages, 3000); 
		});








       /**
		// const ws      = new WebSocket("ws://localhost:8080");
		const ws        = new WebSocket( "wss://sperm-donor.appadvent.com:8080" );
		const chatBox   = document.getElementById( "wkdo-chat-body" );
		const wgroup_id = jQuery( '#group_id' ).val();

		ws.onmessage  = (event) => {
			const msg = JSON.parse( event.data );
			if ( msg.group_id == wgroup_id ) {
				const messageDiv = document.createElement( "div" );

				if ( jQuery( '#sender_id' ).val() == msg.user_id ) {
					messageDiv.className = "wkdo-message wkdo-sent";
				} else {
					messageDiv.className = "wkdo-message wkdo-received";
				}

				messageDiv.innerHTML = ` < span class = "username" > ${msg.user} < / span > ${msg.text}`;

				chatBox.appendChild( messageDiv );
				chatBox.scrollTop = chatBox.scrollHeight;
			}
		};

		

		document.getElementById( "wkd_send_message" ).addEventListener(
			"click",
			function (e) {
				e.preventDefault();

				const content = document.getElementById( "content" );
				const message = content.value;

				if (message.trim()) {
					ws.send(
						JSON.stringify(
							{
								user: user.name,
								role: user.role,
								text: message,
								group_id: jQuery( '#group_id' ).val(),
								user_id: jQuery( '#sender_id' ).val(),
							}
						)
					);

					content.value = ""; // Clear the textarea
				}
			}
		);

		*/

	}
);


jQuery( document ).ready(
	function ($) {

		jQuery( "#DonorType" ).select2(
			{
				placeholder: "Select type",
				allowClear: true
			}
		);
		jQuery( "#DonorAge" ).select2(
			{
				placeholder: "Select age",
				allowClear: true
			}
		);
		jQuery( "#bloodGroup" ).select2(
			{
				placeholder: "Select blood type",
				allowClear: true
			}
		);

		jQuery( "#DonorHairColor" ).select2(
			{
				placeholder: "Select hair color",
				allowClear: true
			}
		);

		jQuery( "#DonorEyeColor" ).select2(
			{
				placeholder: "Select eye color",
				allowClear: true
			}
		);

		jQuery( "#DonorHeight" ).select2(
			{
				placeholder: "Select height",
				allowClear: true
			}
		);

		jQuery( "#DonorWeight" ).select2(
			{
				placeholder: "Select weight",
				allowClear: true
			}
		);

		jQuery( "#DonorReligion" ).select2(
			{
				placeholder: "Select religion",
				allowClear: true
			}
		);

		jQuery( "#DonorMaritalStatus" ).select2(
			{
				placeholder: "Select type",
				allowClear: true
			}
		);

		jQuery( "#wkdo_avalabl_donate" ).select2(
			{
				placeholder: "Select type",
				allowClear: true
			}
		);

		jQuery( ".wkdo-select-multi" ).select2(
			{

				allowClear: true
			}
		);

	}
);


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