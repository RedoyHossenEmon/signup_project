<?php

include "dbConnection.php";


function erroFunc($alertmsg) {  
  header("location:../index.php?login");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  exit();
}


class signup extends dbClass{
   

 
  public function checkuser($email,$password){
    
      $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? OR username =? ');
    
    if (!$stmt->execute(array( $email, $password))) {
         $stmt = null;
      erroFunc('Unexpected Error! Please try again...');
  
    }


    if ($stmt->rowCount() == 0) {
        $stmt = null;
      erroFunc('User not found, please try again...');
    setcookie('inputemail', $email, time() + 2, '/signup_project');


    }

    $usergoted = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($password == $usergoted[0]['user_pwd']){

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






class login_cntlr extends signup{

  private $password;
  private $email;

  public function __construct($password,$email){
    $this->password = $password;
    $this->email = $email;
   
  }


  public function login_user(){

    if (empty($this->password) || empty($this->email)) {
      erroFunc("Please Insert all input filed!");

    //  }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    //   erroFunc("Please insert A valied email!");

     }elseif($this->checkuser( $this->email, $this->password) == false){
      erroFunc('Wrong password, please try again...');
    setcookie('inputemail', $email, time() + 2, '/signup_project');


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