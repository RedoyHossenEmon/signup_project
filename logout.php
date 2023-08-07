<?php  
session_start();
session_unset();
session_destroy();
header('location:index.php');
setcookie('erroralert', 'You have successfully logged out..', time() + 2, '/signup_project');


?>