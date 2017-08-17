function verify_form() {
	if (verify_field()) {
		console.log("submitting reCAPTCHA")
		$('#submit_button').prop("disabled",true);
		grecaptcha.execute();
	}
}

function verify_field() {
	$('.error').hide();
	var name = $("input#name").val();
	if (name == "") {
		$("label#name_error").show();
		$("input#name").focus();
		return false;
	}
	var email = $("input#email").val();
	if (email == "") {
		$("label#email_error").show();
		$("input#email").focus();
		return false;
	} 
	return true;
}


function submit_contact(token) {
	//grecaptcha.render();
	//console.log(token);

	var name = $("input#name").val();

	var email = $("input#email").val();

	var message = $("textarea#message").val();

	var dataString = 'response=' + token + '&csrfmiddlewaretoken=' + csrf + '&name='+ name + '&email=' + email + '&message=' + message;

	//alert (dataString);
	//return false;

	$.ajax({
		type: "POST",
		url: "contact_",
		data: dataString,
		success: function() {
			$('#contact_form').html("<div id='return_message'></div>");	
			$('#return_message').html("<h5>Contact form submitted!</h5>");
		},
		error: function() {
			alert("Contact form submission failed, please reload the page and try again.");
		}
	});
	return false;
}