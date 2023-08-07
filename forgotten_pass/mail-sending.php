<?php

if (isset($_POST['cancesRequest'])) {
  header("location:../index.php?login");
}


include '../classes/dbConnection.php';

function erroFunc($alertmsg) {  

    header("Location: " . $_SERVER['HTTP_REFERER']);
    setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
    exit();
}
 
class forgotEmailcheckClass extends dbClass{

 public function checkEmailExist($email){
    
    $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? ');
  
  if (!$stmt->execute(array( $email))) {
       $stmt = null;
    erroFunc('Unexpected Error! Please try again...');
  }

  if ($stmt->rowCount() == 0) {
      $stmt = null;
    erroFunc('User not found, please signup...');
  
  }else{
    return true;
    $stmt = null;
    exit();
  }

 }
}

if (isset($_POST['pwd-reset-request'])) {
    $reqEmail = $_POST['email'];


    if(!filter_var($reqEmail, FILTER_VALIDATE_EMAIL)){
        erroFunc("Please insert A valied Email!");
    }

    $forgotEmailcheckClass = new forgotEmailcheckClass;
    if ( $forgotEmailcheckClass->checkEmailExist($reqEmail) === true) {
        
      include 'mailer-setup.php';

      $mailerSetupclass = new mailerSetup($reqEmail);      


    }

    


}




?>