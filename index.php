<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html>
 <head>  <title> Make your life more easy </title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style> <?php include "customFiles/style.css"; ?>  </style>

 </head>
<body>


  <?php include 'includes/menu.php'; ?>

  <?php 

  function isSession() {
    
    if(isset($_SESSION['username'])){ echo "<script>  window.location ='index.php' </script> ";}
  }


    if(isset($_GET['login'])) {
    include "includes/login.php";
    isSession();
    }elseif (isset($_GET['signup'])) {
      include "includes/signup.php"; 
      isSession();
    }elseif(isset($_GET['forgot-password'])){
    
      include 'forgotten_pass/pwd-reset-request.php';
      
      
    }else{
      include 'includes/defult_home.php';
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
