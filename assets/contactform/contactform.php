<?php

 
$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];	
			
mailler($name, $email,  $subject, $message);			
	   die("success");
	   
	   

use PHPMailer\PHPMailer\PHPMailer;
function mailler($name, $email,  $subject, $message){

require '../../mailer/src/PHPMailer.php';
require '../../mailer/src/Exception.php';
 

$mssg = $message;

die("OK");


//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom("contact@talentsfetcher.com", 'Talentsfetcher Contact Me');
//Set an alternative reply-to address
$mail->addReplyTo($email, $name);
//Set who the message is to be sent to
$mail->addAddress("info@talentsfetcher.com");
//Set the subject line
$mail->Subject = $subject;

$mail->msgHTML($mssg);
//Replace the plain text body with one created manually
$mail->AltBody = $message;

//Attach an image file
//$mail->addAttachment('1473787167.5497.JPEG');

if (!$mail->send()) {
    return "error";
} else {
    return "good";
}


}

	           ?>