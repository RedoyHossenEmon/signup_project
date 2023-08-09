<?php 

include "classes/dbConnection.php";


function erroFunc($alertmsg) {  

  header("Location:  ../index.php");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  exit();
}


class resetRequestClass extends dbClass{

  private $getSelector;
  private $getToken;

  public function __construct($getSelector, $getToken){
    $this->getSelector = $getSelector;
    $this->getToken = $getToken;
  }

  public function resetReqFunc(){


  if(!empty($this->getSelector)|| !empty($this->getToken)){

  }
  
  $stmt = $this->connect()->prepare('SELECT * FROM pwdreset WHERE resetSelector = ? ');
  $excuted = $stmt->execute(array( $this->getSelector));
  $usergoted = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $date = date('U');
 
  if (! $excuted) {
      $stmt = null;
      erroFunc('Unexpected Error!! Please try again..');  
  }
      
  if ($stmt->rowCount() == 0) {
      $stmt = null;
      erroFunc('Unexpected Error!! Please try again..');
  }
      

  if($this->getSelector == $usergoted[0]['resetSelector'] && $date < $usergoted[0]['resetExpires'] ){

    $hashed = password_hash($this->getToken, PASSWORD_DEFAULT);
    if(password_verify($this->getToken, $hashed)){
        include 'pwd-reset-request.php';
    }else{
      erroFunc('Unexpected Error!! Please try again..');
    }

  }else{
    erroFunc('Could not validate your request...');
  }

 }
 

}


 if(isset($_GET['selector']) && isset($_GET['token'])){

  $getSelector = $_GET['selector'];
  $getToken = $_GET['token'];


  $resetclass = new resetRequestClass($getSelector,$getToken);
  $resetclass->resetReqFunc();
  
}




?>
