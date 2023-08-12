<?php

// Checking if cancel request was made
if (isset($_POST['cancesRequest'])) {
  header("location:../index.php?login");
}

// Including the database connection file
include '../classes/dbConnection.php';

// Function to handle errors and redirect
function erroFunc($alertmsg) {  
    // Redirecting to the previous page with error message as cookie
    header("Location: " . $_SERVER['HTTP_REFERER']);
    setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
    exit();
}

// Defining the 'forgotEmailcheckClass' class that extends 'dbClass'
class forgotEmailcheckClass extends dbClass{
  
  // Function to check if given email exists in the database
  public function checkEmailExist($email){
    $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? ');

    if (!$stmt->execute(array( $email))) {
       $stmt = null;
       erroFunc('Unexpected Error! Please try again...');
    }

    if ($stmt->rowCount() == 0) {
      $stmt = null;
      erroFunc('User not found, please signup...');
    } else {
      return true;
      $stmt = null;
      exit();
    }
  }
}

// Checking if password reset request was made
if (isset($_POST['pwd-reset-request'])) {
    $reqEmail = $_POST['email'];

    // Validating if email field is empty
    if(empty($reqEmail)){
        erroFunc("Please insert all input filed!");
    }

    // Creating an instance of 'forgotEmailcheckClass'
    $forgotEmailcheckClass = new forgotEmailcheckClass;
    
    // Checking if email exists using the 'checkEmailExist' method
    if ($forgotEmailcheckClass->checkEmailExist($reqEmail) === true) {
      
      // Including mailer setup file
      include 'mailer-setup.php';

      // Creating an instance of 'mailerSetup' class and passing the email
      $mailerSetupclass = new mailerSetup($reqEmail);      
    }
}

?>
