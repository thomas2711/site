<?php

$response = validate_input($_POST['response']);
$name = validate_input($_POST['name']);
$email = validate_input($_POST['email']);
$message = validate_input($_POST['message']);
$ip = $_SERVER['REMOTE_ADDR'];

//POST Google reCAPTCHA

if (isValid($response, $ip)) {

	if (strcmp($name, "") == 0 && strcmp($email, "") == 0) {
		die();
	}

	$test = "name: $name, email: $email, ip: $ip, message: $message";

	$credentials = file("contact.txt");

	require 'php/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com;smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $credentials[0];                 // SMTP username
	$mail->Password = $credentials[1];                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom($credentials[0]);
	$mail->addAddress($credentials[0]);     // Add a recipient

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'contact form submission';
	$mail->Body    = $test; //'This is the HTML message body <b>in bold!</b>';
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	    //echo 'Message could not be sent.';
	    //echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    //echo 'Message has been sent';
	}
}

function validate_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function isValid($resp, $ip) {

	$secret = file("secret.txt");

    try {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secret[0],
                 'response' => $resp,
                 'remoteip' => $ip];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data) 
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }
    catch (Exception $e) {
        return false;
    }
}