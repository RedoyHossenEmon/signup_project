<?php

include "dbConnection.php";


function checksession() { 

  if(isset($_SESSION['username'])){header("location:../index.php");}
}
checksession();


function erroFunc($alertmsg) {  
  header("location:../index.php?login");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  // setcookie('inputemail', 'email', time() + 100, '/signup_project');
  // setformback();
}


class signup extends dbClass{
   

 
  public function checkuser($email,$password){
    
      $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? OR username =? ');
    
    if (!$stmt->execute(array( $email, $email))) {
         $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
       exit();
    }


    if ($stmt->rowCount() == 0) {
        $stmt = null;
      erroFunc('User not found, please try again...');
       exit();
    }

    $userpassword = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($password == $userpassword[0]['user_pwd']){
   
      setcookie('erroralert', 'Signup successfull...', time() + 2, '/signup_project');
    $username =  $userpassword[0]['username'];
    $_SESSION['username'] = $username;
    checksession();
      exit();

    }else{
      return false;
      $stmt = null;
      exit();
    }

  }


}






class login_cntlr extends signup{

  private $password;
  private $email;

  public function __construct($password,$email){
    $this->password = $password;
    $this->email = $email;
    setcookie('inputemail', $email, time() + 2, '/signup_project');
   
  }


  public function login_user(){

    if (empty($this->password) || empty($this->email)) {
      erroFunc("Please Insert all input filed!");
      exit();
    // }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    //   erroFunc("Please insert A valied email!");
    //   exit();
     }elseif($this->checkuser( $this->email, $this->password) == false){
      erroFunc('Wrong password, please try again...');
      exit();
    }
  }



}


//  checking submited or not and then run classes and functions

if (isset($_POST['submit'])) {
  $email = $_POST['email'] ;
  $password = $_POST['password'] ;

  $signup = new login_cntlr($password, $email);
 $signup->login_user();

 
 
  // }else{
  //   header('location:../index.php');
  //   exit();
  }
  






?>