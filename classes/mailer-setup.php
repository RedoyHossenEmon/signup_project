<?php

// MyMailer.php

require '../mailer/PHPMailerAutoload.php'; // Include PHPMailer library files



$mail = new PHPMailer;
$senderemail ='redoy.hossen.emon@gmial.com';

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';												 // Your SMTP host
$mail->SMTPAuth =true;
$mail->Username = $senderemail;			 // Your SMTP username
$mail->Password = 'trciphxzovtondtz';									 // Your SMTP password
$mail->SMTPSecure = 'tls'; 														// Encryption type (ssl or tls)
$mail->Port = 587; 																		// SMTP port (usually 587)

$mail->setFrom($senderemail); // Sender's email and name

$mail->addAddress($reciptemail); // Recipient's email and name (optional)

$mail->Subject = $emailsubject; 									// Email subject
$mail->Body = $emailbody; 						// Email body

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
// $mail->Debugoutput = function ($str, $level) {
//     print_r(" Debug: $level; $str");
// };


if ($mail->send()) {
    echo 'Email sent successfully';
} else {
    echo 'Error sending email: ' . $mail->ErrorInfo;
}








?>