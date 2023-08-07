<?php if(isset($_SESSION['username'])){
?>
  <div class="container">
  
  <div id="autoText" ></div>
  
  
  </div>

  <?php  }else{ ?>


  <div class="container">
    
  <div class="formWraper homewelcome">
    <h2 class="welcoming">Welcome! <br>Please Sign Up here to unlock of exciting features and enjoy a personalized experience. By logging in...</h2>
   
       <div class="form-group">
        <a class="" href="index.php?signup">
         <input type="submit" name="submit" value="Sign Up"></br></br>
        </a>
         <span> already have an account </span>
        <a class="loginerebtn hereBtn" href="index.php?login"> login here</a>
       </div>

    
  </div>  
  
  <div id="autoText" ></div>


</div>

<?php } ?>