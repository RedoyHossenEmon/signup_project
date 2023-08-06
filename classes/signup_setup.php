<?php


include "dbConnection.php";


function checksession() { 
  if(isset($_SESSION['username'])){header("location:../index.php");}
}
checksession();

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




  class signup extends dbClass{
    
  // checking have any problem database connection or sql and tabe if have any error exit from this block  

  public function setUser($username, $password, $email) {
    $stmt = $this->connect()->prepare("INSERT INTO users (username, user_pwd, user_email) VALUES (?, ?, ?)");
  
    if ($stmt->execute(array($username, $password, $email))) {
      
    setcookie('erroralert', 'Login successfull...', time() + 2, '/signup_project');
    $userId =  $username;
    $_SESSION['username'] = $username;
    checksession();
      exit();

     }else{ 
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
      exit();
    }
  
    $stmt = null;
  }

  public function checkuser($promtuser, $dbcollum){
    
    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE $dbcollum =  ? ");
    $stmtStatus = $stmt->execute(array($promtuser));
    if (!$stmtStatus) {
      $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
    $stmt = null;
       exit();
    }
    $checkresult = ($stmt->rowCount() == 0) ? true : false;
    return $checkresult;

  }


}






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
  


//  checking have any error if not just simply save data in database

  public function signup_user(){


    if (empty($this->username) || empty($this->password) || empty($this->co_password) || empty($this->email)) {
      erroFunc("Please Insert all input filed!");
      exit();
    }
    elseif(!preg_match("/^[1-9a-zA-Z]*$/", $this->username)){
        erroFunc("Please insert A valied username! You can not use any symbol or space","name");
        exit();
    }
    elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
        $result = true;
        erroFunc("Please insert A valied email!","email");
        exit();
     }
     elseif($this->password !== $this->co_password){
      erroFunc("password did not match!","confirm-password");
      exit();
    }
    elseif($this->checkuser($this->username,'username') == false){
      erroFunc( "This username already used! Please use a uniqe name, You can use letters and numbers also.","name");
      exit();
    }
    elseif($this->checkuser($this->email, 'user_email') == false){
      erroFunc( "This Email already used! Please login by this email", "email");
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
  
  $signup = new Signup_cntlr($username,$password,$co_password, $email);
  $signup->signup_user();
 


  // }else{
  //   header('location:../index.php');
  }
  






?>