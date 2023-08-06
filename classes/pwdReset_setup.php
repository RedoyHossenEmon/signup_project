<?php
include 'dbConnection.php';


function erroFunc($alertmsg) {  
  header("location:../index.php?pwd-reset");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  // setformback();
}


function mailSendingFunc($userEmail,$subject,$message ){


require '../mailer/PHPMailerAutoload.php'; // Include PHPMailer library files



$mail = new PHPMailer;
$senderemail ='redoy.hossen.emon@gmail.com';

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';												 // Your SMTP host
$mail->isHTML(true);
$mail->SMTPAuth =true;
$mail->Username = $senderemail;			                   // Your SMTP username
$mail->Password = 'vnjsztvzimpcxuxq';									 // Your SMTP password
$mail->SMTPSecure = 'tls'; 														 // Encryption type (ssl or tls)
$mail->Port = 587; 																		 // SMTP port (usually 587)

$mail->setFrom($senderemail);                          // Sender's email and name

$mail->addAddress($userEmail);                        // Recipient's email and name (optional)

$mail->Subject = $subject; 									          // Email subject
$mail->Body = $message; 						                  // Email body
$mail->headers = "From: redoy.hossen.emon@gmail.com\r\n"; // Replace with your email address
$mail->headers .= "MIME-Version: 1.0\r\n";
$mail->headers .= "Content-type: text/html; charset=utf-8\r\n"; // Set content-type to HTML



if ($mail->send()) {
    header('location:../index.php?pwd-reset-done');
    setcookie('erroralert', "Please Check your email..", time() + 2, '/signup_project');

} else {
   erroFunc("Unexpected error! Please try again..");
   exit();
  
}









// if ($mailer->mail($userEmail, $subject, $message)) {
  
// } else {        

// }
  
}




class pwdReset extends dbClass {
    private $userEmail;

    public function __construct($userEmail) {
        $this->userEmail = $userEmail;
    }

    public function pwdResetFunc() {

      if(!filter_var($this->userEmail, FILTER_VALIDATE_EMAIL)){
          erroFunc("Please insert A valied email!");
          exit();
      }

        // Generate token and URL
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $url = 'localhost/signup_project/includes/resetting-pwd.php?selector=' . $selector . '&token=' . bin2hex($token);
        $expires = date('U') + 1800;

        // Delete any existing records with the given email from the "pwdreset" table
        $sql = "DELETE FROM pwdreset WHERE resetEmail = ?";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute([$this->userEmail])) {
            $stmt->closeCursor();

            // Insert the new reset token and details into the "pwdreset" table
            $sql = "INSERT INTO pwdreset (resetEmail, resetSelector, resetToken, resetExpires) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);

            if ($stmt->execute([$this->userEmail, $selector, $hashedToken, $expires])) {
                $stmt->closeCursor();
                // Send the reset URL to the user's email
            
                
                $subject = "Reset your password to login";
                $message = "<html>
                <head>
                    <title>HTML Email</title>
                </head>
                <body><p  style='font-size: 18px;'>
                We hope this email finds you well. It appears that a password reset request has been initiated for your account at [Your Website/Application Name]. Your security is our top priority, and we are here to help you regain access to your account.
                To proceed with the password reset, please follow the instructions below</p>
                <p>Click on the following link or copy and paste it into your web browser:<br/>
                <a href='http://".$url."'>".$url ."</a> </p></body>
                </html>'";

                mailSendingFunc($this->userEmail,$subject,$message );
                // (You would need to implement this part separately)
              
                // mail($this->userEmail, $subject, $massege);





            } else {
              erroFunc("Unexpected error! Please try again..");
                exit();
            }
        } else {
          erroFunc("Unexpected error! Please try again..");
            exit();
        }
    }
}



if (isset($_POST['pwd-reset-submit'])) {
  $email = $_POST['email'] ;
  $signup = new pwdReset( $email);
  $signup->pwdResetFunc();


}else{
  header('Location: ../index.php');

}









?>