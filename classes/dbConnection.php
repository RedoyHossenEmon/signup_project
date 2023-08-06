<?php 
 if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

class dbClass{

  protected function connect() {
    try {
      $username = 'root';
      $dbpwd = '';
      $dbh = new PDO('mysql:host=localhost;dbname=ooplogin', $username, $dbpwd);
  
      return $dbh;
    } catch (PDOException $th) {
      echo "!Error " . $th->getMessage() . "<br>";
      return null; // Or handle the error appropriately in your application
    }
  }





}






















?>