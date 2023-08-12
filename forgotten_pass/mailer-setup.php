<?php

// Function to send emails
function mailSendingFunc($userEmail, $subject, $message) {

    require 'mailer/PHPMailerAutoload.php'; // Include PHPMailer library files

    // Initialize PHPMailer
    $mail = new PHPMailer;
    $senderemail = 'redoy.hossen.emon@gmail.com';

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->isHTML(true);
    $mail->SMTPAuth = true;
    $mail->Username = $senderemail; 
    $mail->Password = 'vnjsztvzimpcxuxq'; 
    $mail->SMTPSecure = 'tls'; // Encryption type (ssl or tls)
    $mail->Port = 587; // SMTP port (usually 587)

    // Set sender information
    $mail->setFrom($senderemail); 
    $mail->addAddress($userEmail); 
    $mail->Subject = $subject; 
    $mail->Body = $message; 
    $mail->headers = "From: redoy.hossen.emon@gmail.com\r\n"; 
    $mail->headers .= "MIME-Version: 1.0\r\n";
    $mail->headers .= "Content-type: text/html; charset=utf-8\r\n"; 

    // Send the email
    if ($mail->send()) {
        header("Location: ../index.php");
        setcookie('erroralert', "Please check your email and set up your new password within 15 minutes.", time() + 2, '/signup_project');
    } else {
        erroFunc("Unexpected error! Please try again..");
    }
}

// Defining the 'mailerSetup' class that extends 'dbClass'
class mailerSetup extends dbClass {
    private $userEmail;

    public function __construct($userEmail) {
        $this->userEmail = $userEmail;

        // Generate token and URL
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $expires = date('U') + 1800;
        $url = 'localhost/signup_project/forgotten_pass/create-pwd-req.php?selector=' . $selector . '&token=' . bin2hex($token);

        // Delete any existing records with the given email from the "pwdreset" table
        $sql = "DELETE FROM pwdreset WHERE resetEmail = ?";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$this->userEmail])) {
            $stmt->closeCursor();
        }

        // Send the reset URL to the user's email
        $subject = "Reset your password to login";
        $message = "<html>
        <head>
            <title>HTML Email</title>
        </head>
        <body><p style='font-size: 18px;'>
        We hope this email finds you well. It appears that a password reset request has been initiated for your account at [Your Website/Application Name]. Your security is our top priority, and we are here to help you regain access to your account.
        To proceed with the password reset, please follow the instructions below</p>
        <p>Click on the following link or copy and paste it into your web browser:<br/>
        <a href='http://" . $url . "'>" . $url . "</a> </p></body>
        </html>'";

        // Call the mailSendingFunc to send the email
        mailSendingFunc($this->userEmail, $subject, $message);

        // Insert the new reset token and details into the "pwdreset" table
        $sql = "INSERT INTO pwdreset (resetEmail, resetSelector, resetToken, resetExpires) VALUES (?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$this->userEmail, $selector, $hashedToken, $expires])) {
            erroFunc("Unexpected error! Please try again..");
            exit();
        }
        exit();
    }
}

?>
