<?php

// Including the database connection file
include '../classes/dbConnection.php';

// Function to handle errors and redirect
function erroFunc($alertmsg) {  
  header("Location:../index.php?forgot-password=create-new-password");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  exit();
}

// Defining the 'resetPwdSetup' class that extends 'dbClass'
class resetPwdSetup extends dbClass {
  private $password;
  private $confirmPwd;

  public function __construct($password, $confirmPwd){
    $this->password = $password;
    $this->confirmPwd = $confirmPwd;
  }

  // Function to validate and reset the password
  public function resetPwdFunc(){
    if(empty($this->password) || empty($this->confirmPwd)){
      erroFunc('Please insert all input fields.');
    }
    
    if($this->password !== $this->confirmPwd){
      erroFunc('Passwords do not match!');
    }
  }

  // Function to setup a new password
  public function setupnewpassword(){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    } 

    $requsetselector = $_SESSION['selector'];
    $requsettoken = $_SESSION['token'];
    $tokenhexcode = hex2bin($_SESSION['token']);

    $stmt = $this->connect()->prepare('SELECT * FROM pwdreset WHERE resetSelector = ? ');
    $stmtexcute = $stmt->execute(array($requsetselector));

    if (!$stmtexcute) {
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
    }

    if ($stmt->rowCount() == 0) {
      $stmt = null;
      erroFunc('Could not validate your request, please try again...');
    }

    $usergoted = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $userbdtoken = $usergoted[0]['resetToken'];
    $tokenverify = password_verify($tokenhexcode, $userbdtoken);
   
    $currentDate = date("U");
    
    if($currentDate > $usergoted[0]['resetExpires']){
      erroFunc('No longer have your Request!');
    }

    if($tokenverify){
      $stmt = $this->connect()->prepare("UPDATE users SET user_pwd = '$this->password' WHERE user_email = ?");
      $updatepwdsql = $stmt->execute(array($usergoted[0]['resetEmail']));

      $stmt = $this->connect()->prepare('DELETE FROM pwdreset WHERE resetSelector = ? ');
      $deletetokensql = $stmt->execute(array($requsetselector));

      if (!$updatepwdsql || !$deletetokensql) {
        $stmt = null;
        erroFunc('Unexpected Error! Please try again...');
      }

      setcookie('erroralert', 'Your new password setup successful...', time() + 2, '/signup_project');
      unset($usergoted[0]['selector']);
      unset($_SESSION['token']);
      header('location:../index.php');
      exit();
    } else {
      $stmt = null;
      erroFunc('Could not validate your request, please try again...');
      exit();
    }
  }
}

// Checking if password reset form was submitted
if(isset($_POST['pwd-reset-submit'])){
  $password = $_POST['password'];
  $confirmPwd = $_POST['confirm-password'];

  // Creating an instance of 'resetPwdSetup' class and calling necessary methods
  $resetPwdSetup = new resetPwdSetup($password, $confirmPwd);
  $resetPwdSetup->resetPwdFunc();
  $resetPwdSetup->setupnewpassword();
}

?>
