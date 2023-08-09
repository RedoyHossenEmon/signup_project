<?php
include '../classes/dbConnection.php';

function erroFunc($alertmsg) {  
  header("Location:../index.php?resetting-password");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  exit();
}


class resetPwdSetup extends dbClass{
  private $password;
  private $confirmPwd;

  public function __construct($password, $confirmPwd ){
    $this->password = $password;
    $this->confirmPwd = $confirmPwd;
  }

  public function resetPwdFunc(){

    if(empty($this->password) || empty($this->confirmPwd)){
      erroFunc('Please insert all input filed.');
    }
    
    if($this->password !== $this->confirmPwd){
      erroFunc('Password did not match!');
    }
    
    
    
  }


}



if(isset($_POST['pwd-reset-submit'])){
  $password = $_POST['password'];
  $confirmPwd = $_POST['confirm-password'];

  $resetPwdSetup = new resetPwdSetup($password, $confirmPwd);
  $resetPwdSetup->resetPwdFunc();

}









?>