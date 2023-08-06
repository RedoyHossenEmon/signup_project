<?php

include 'classes/dbConnection.php';

function erroFunc($alertmsg) {  
  header("location:../index.php");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  // setformback();
}




if (isset($_GET['selector']) && isset($_GET['token'])) {
  
$get_token = $_GET['token'];
$get_selector = $_GET['selector'];


if(empty($get_token) || empty($get_selector)){
  erroFunc('Your requeset could not validate!!');
  exit();
}

if(ctype_xdigit($get_selector) !== false && ctype_xdigit($get_token) !== false){
  header('location:../index.php?selector='.$get_selector.'&token='.$get_token);
 ?>

  <div class="container">
      
      <div id="autoText" style="float:left"></div>
    
      <div class="formWraper" style="float:rightt">
        <h2>Reset your password</h2>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">

          <div class="form-group">
            <label for="pwd">New Password:</label>
            <input type="text" id="pwd" placeholder="" name="n-pwd" >
          </div>
          <div class="form-group">
            <label for="pwd">Confirm Password:</label>
            <input type="text" id="pwd" placeholder="" name="nc-pwd" >
          </div>
      
          <div class="form-group">
            <input type="submit" name="resetting-pwd-submit" value="Submit" >
          </div>
          
        </form>
        
      </div>  
    
    </div>
      


<?php

}else {
  erroFunc('Your requeset could not validate!!');
exit();
}

}

class pwdResetSetup extends dbClass{

private $selector;
private $token;


  public function __construct($selector,$token){
    $this->selector = $selector;
    $this->token = $token;
  
   
  }
  public function resetFunc(){


    



  $stmt = $this->connect()->prepare("SELECT * FROM pwdreset WHERE resetSelector = ?");
  $stmt->execute([$this->selector]);
  
  // Fetch all matching rows as an associative array
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
print_r($results);
}
}




if(isset($_POST['resetting-pwd-submit'])){

  $nPwd = $_POST['n-pwd'];
  $cnPwd = $_POST['nc-pwd'];
  $token = $_POST['token'];
  $selector = $_POST['selector'];

$resetClass = new pwdResetSetup($selector,$token );
$resetClass->resetFunc();




}else{erroFunc("Somthing went Wrong Please try again...");}



























?>