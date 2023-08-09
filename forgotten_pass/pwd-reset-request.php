<?php
if (isset($_GET['forgot-password'])) {
  $forgotpassword = $_GET['forgot-password'];
  if($forgotpassword =='reset-mail-request'){
 ?>
<div class="container subcontainer">
    
    <div id="autoText" style="float:left"></div>
  
    <div class="formWraper" style="float:rightt">
      <h2>Search your account</h2>
      <form action="forgotten_pass/mail-sending.php" method="POST">
  
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" id="email" placeholder="Enter email" name="email" >
        </div>
    
        <div class="form-group">
          <div class="row">
    <div class="col-md-6">
    <input type="submit"  name="cancesRequest" class="cancelBtn" value="Cancel" >
    </div>
    <div class="col-md-6">
    <input type="submit" name="pwd-reset-request" value="Search">
    </div>
  </div>
        </div>
        
      </form>
      
    </div>  
  </div>
  
  <?php }

  if ($forgotpassword == 'create-new-password') {
  ?>
  
  <div class="container subcontainer">
    
    <div id="autoText" style="float:left"></div>
  
          <div class="formWraper" style="float:right">
              <h2>Reset your password</h2>
              <form action="forgotten_pass/reset-pwd-setup.php" method="POST">
          
                <div class="form-group">
                  <label for="password">New Password:</label>
                  <input type="password" id="password" placeholder="" name="password" >
                </div>
                <div class="form-group">
                  <label for="password">Confirm Password:</label>
                  <input type="password" id="password" placeholder="" name="confirm-password" >
                </div>
            
                <div class="form-group">
                  <input type="submit" name="pwd-reset-submit" value="Submit">
                </div>
          
                
              </form>
              
            </div>  

  <?php }} ?>