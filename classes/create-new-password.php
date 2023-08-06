<?php

function erroFunc($alertmsg) {  
  header("location:../index.php");
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  // setformback();
}


if(isset($_POST['resetting-pwd-submit'])){

  $nPwd = $_POST['n-pwd'];
  $cnPwd = $_POST['nc-pwd'];
  $token = $_POST['token'];
  $selector = $_POST['selector'];

  echo $token; 
  echo $selector; 
  






}else{erroFunc("Somthing went Wrong Please try again...");}









?>
