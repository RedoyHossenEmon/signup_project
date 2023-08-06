<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html>
 <head>  <title> Make your life more easy </title>
  <style> <?php include "customFiles/style.css"; ?>  </style>
 </head>
<body>


  <?php include 'includes/menu.php'; ?>

  <?php 
    if(isset($_GET['login'])) {
      include "includes/login.php";

    }elseif (isset($_GET['signup'])) {
      include "includes/signup.php";

    }elseif(isset($_SESSION['username'])){
      include 'includes/defult_home.php';
      
    }elseif(isset($_GET['pwd-reset-request'])){
      include 'includes/pwd-reset-request.php';
      
    }elseif(isset($_GET['pwd-reset-done'])){
       include 'includes/home.php';
      
    }elseif(isset($_GET['resetting-pwd'])){
       include 'includes/resetting-pwd.php';
      
    }elseif(isset($_GET['selector']) && isset($_GET['token'])){
       include 'includes/resetting-pwd.php';
      
    
    }else{
      include 'includes/home.php';
    }
  ?>




  <script>
    //  setting up automatic text genarator in homepage using php and javascript mixed

   <?php  include "customFiles/script.php"; 
      $textdescrip = 'Hi, I am Redoy Hossen, a PHP developer with expertise in creating dynamic web applications. With strong skills in front-end technologies like HTML, CSS, and JavaScript, I ensure seamless user experiences.';
      if(isset($_COOKIE['erroralert'])){ $text= $_COOKIE['erroralert'];}else{$text= $textdescrip;} ;

    $Script = new Script($text);

      function reapetCall($textdescrip){
        echo " setTimeout(function(){ document.getElementById('autoText').innerHTML = '' ";
      $Script = new Script($textdescrip);
        echo " }, 6000)";
      }  
         
    if(isset($_COOKIE['erroralert'])) { reapetCall($textdescrip) ; };

    
    ?>
  </script>





</body>
</html>
