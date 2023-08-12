<?php

// Including the database connection file
include "dbConnection.php";

// Function to check if a user session exists, redirect if true
function checksession() { 
  if(isset($_SESSION['username'])){
    header("location:../index.php");
  }
}
// Calling the session check function
checksession();

// Function to handle errors and redirect with cookies
function erroFunc($alertmsg, $focusId=null) {  
  header("location:../index.php?signup");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  setcookie('focus', $focusId, time() + 2, '/signup_project');

  if (isset($_POST['name'])){
    setcookie('inputname', $_POST['name'], time() + 2, '/signup_project');
  }
  if (isset($_POST['email'])) {
    setcookie('inputemail', $_POST['email'], time() + 2, '/signup_project');
  }
}

// Defining the 'signup' class that extends 'dbClass'
class signup extends dbClass{
  
  // Function to insert user data into the database
  public function setUser($username, $password, $email) {
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT)
    $stmt = $this->connect()->prepare("INSERT INTO users (username, user_pwd, user_email) VALUES (?, ?, ?)");

    if ($stmt->execute(array($username, $password, $email))) {
      setcookie('erroralert', 'Signup successfull...', time() + 2, '/signup_project');
      $userId =  $username;
      $_SESSION['username'] = $username;
      checksession();
      exit();
    } else { 
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
      exit();
    }

    $stmt = null;
  }

  // Function to check if a user already exists
  public function checkuser($promtuser, $dbcollum){
    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE $dbcollum =  ? ");
    $stmtStatus = $stmt->execute(array($promtuser));

    if (!$stmtStatus) {
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
      exit();
    }

    $checkresult = ($stmt->rowCount() == 0) ? true : false;
    return $checkresult;
  }
}

// Defining the 'Signup_cntlr' class that extends 'signup'
class Signup_cntlr extends signup{

  private $username;
  private $password;
  private $co_password;
  private $email;

  public function __construct($username,$password,$co_password, $email){
    $this->username = $username;
    $this->password = $password;
    $this->co_password = $co_password;
    $this->email = $email;
  }
  
  // Function to process user signup
  public function signup_user(){

    if (empty($this->username) || empty($this->password) || empty($this->co_password) || empty($this->email)) {
      erroFunc("Please Insert all input filed!");
      exit();
    }
    elseif(!preg_match("/^[1-9a-zA-Z]*$/", $this->username)){
      erroFunc("Please insert A valid username! You can not use any symbol or space","name");
      exit();
    }
    elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
      erroFunc("Please insert A valid email!","email");
      exit();
    }
    elseif($this->password !== $this->co_password){
      erroFunc("Passwords do not match!","confirm-password");
      exit();
    }
    elseif($this->checkuser($this->username,'username') == false){
      erroFunc("This username is already used! Please use a unique name, You can use letters and numbers.","name");
      exit();
    }
    elseif($this->checkuser($this->email, 'user_email') == false){
      erroFunc("This Email is already used! Please login with this email", "email");
      exit();
    }
  
    $this->setUser($this->username,$this->password,$this->email);
  }
}

if (isset($_POST['submit'])) {
  $username = $_POST['name'] ;
  $email = $_POST['email'] ;
  $password = $_POST['password'] ;
  $co_password = $_POST['confirm-password'] ;
  
  // Creating an instance of 'Signup_cntlr' class and calling 'signup_user' method
  $signup = new Signup_cntlr($username,$password,$co_password, $email);
  $signup->signup_user();
}

?>
