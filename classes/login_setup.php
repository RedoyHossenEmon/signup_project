<?php

// Including the database connection file
include "dbConnection.php";

// Function to handle errors and redirect
function erroFunc($alertmsg) {  
  header("location:../index.php?login");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  if (isset($_POST['email'])) {
    setcookie('inputemail', $_POST['email'], time() + 2, '/signup_project');
  }
  exit();
}

// Defining a class 'signup' that extends 'dbClass'
class signup extends dbClass{
   
  // Function to check user credentials
  public function checkuser($email,$password){
    $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? OR username =? ');
    
    if (!$stmt->execute(array( $email, $password))) {
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
    }

    if ($stmt->rowCount() == 0) {
      $stmt = null;
      erroFunc('User not found, please Signup..');
      setcookie('inputemail', $email, time() + 2, '/signup_project');
    }

    $usergoted = $stmt->fetchAll(PDO::FETCH_ASSOC);
     $pwdVerify = password_verify($password,  $usergoted[0]['user_pwd']);
    if($pwdVerify){
      setcookie('erroralert', 'Login successfull...', time() + 2, '/signup_project');
      $username =  $usergoted[0]['username'];
      $_SESSION['username'] = $username;
      header('location:../index.php');
      exit();
    }else{
      return false;
      $stmt = null;
      exit();
    }
  }
}

// Defining a class 'login_cntlr' that extends 'signup'
class login_cntlr extends signup{
  private $password;
  private $email;

  public function __construct($password,$email){
    $this->password = $password;
    $this->email = $email;
  }

  // Function to initiate user login
  public function login_user(){
    if (empty($this->password) || empty($this->email)) {
      erroFunc("Please Insert all input filed!");
    } elseif($this->checkuser( $this->email, $this->password) == false){
      erroFunc('Wrong password, please try again...');
      setcookie('inputemail', $email, time() + 2, '/signup_project');
    }
  }
}

// Checking if the form was submitted
if (isset($_POST['submit'])) {
  $email = $_POST['email'] ;
  $password = $_POST['password'] ;

  // Creating an instance of 'login_cntlr' class and calling 'login_user' method
  $signup = new login_cntlr($password, $email);
  $signup->login_user();
}

?>
