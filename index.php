<?php  
// Starting a session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title> Make your life more easy </title>
  <!-- Including Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Including custom CSS -->
  <style> <?php include "customFiles/style.css"; ?> </style>
 </head>
<body>

  <!-- Including the navigation menu -->
  <?php include 'includes/menu.php'; ?>

  <?php 
  // Function to check if a session is already active
  function isSession() {
    if(isset($_SESSION['username'])){
      // Redirecting to index.php if session is active
      echo "<script>  window.location ='index.php' </script> ";
    }
  }

  // Handling different cases based on URL parameters
  if(isset($_GET['login'])) {
    // Including the login form
    include "includes/login.php";
    // Checking if a session is already active
    isSession();
  } elseif (isset($_GET['signup'])) {
    // Including the signup form
    include "includes/signup.php"; 
    // Checking if a session is already active
    isSession();
  } elseif(isset($_GET['forgot-password'])){
    // Including the password reset request form
    include 'forgotten_pass/pwd-reset-request.php';
  } else {
    // Including the default home page
    include 'includes/defult_home.php';
  }
  ?>

  <script>
    // Setting up automatic text generator in homepage using PHP and JavaScript mixed

    <?php
    // Including the script.php file
    include "customFiles/script.php";
    // Default text description
    $textdescrip = 'Hi, I am Redoy Hossen, a PHP developer with expertise in creating dynamic web applications. With strong skills in front-end technologies like HTML, CSS, and JavaScript, I ensure seamless user experiences.';
    // Using erroralert cookie value if it's set, otherwise using default text description
    if(isset($_COOKIE['erroralert'])) {
      $text = $_COOKIE['erroralert'];
    } else {
      $text = $textdescrip;
    }
    // Creating an instance of the Script class
    $Script = new Script($text);

    // Function to repeat the text change after a certain interval
    function reapetCall($textdescrip){
      echo " setTimeout(function(){ document.getElementById('autoText').innerHTML = '' ";
      $Script = new Script($textdescrip);
      echo " }, 6000)";
    }  
         
    // Calling the reapetCall function if erroralert cookie is set
    if(isset($_COOKIE['erroralert'])) {
      reapetCall($textdescrip);
    }
    ?>

  </script>
</body>
</html>
