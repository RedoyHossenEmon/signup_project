<?php


function erroFunc($alertmsg) {  
  header('location: ../index.php');
  setcookie('erroralert', $alertmsg, time() + 2, '/signup_project');
  exit();
}

  
if(isset($_GET['selector']) && isset($_GET['token'])){
  
    $getSelector = $_GET['selector'];
    $getToken = $_GET['token'];
    if(empty($getSelector)|| !empty($getToken)){
  
      if(ctype_xdigit($getSelector) && ctype_xdigit($getToken)){

        header('location:../index.php?forgot-password=create-new-password');
      
          if (session_status() === PHP_SESSION_NONE) {
            session_start(); } 
            
        $_SESSION['selector'] = $getSelector;
        $_SESSION['token'] = $getToken;
        exit();
      }else{
        erroFunc('Your request Could not validate!');
      }
  
    }else{
      erroFunc('Your request Could not validate!');
    }
    
    } 









?>