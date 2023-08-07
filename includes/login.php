
<div class="container">
    
  <div id="autoText" style="float:left"></div>

  <div class="formWraper" style="float:rightt">
    <h2>login Form</h2>
    <form action="classes/login_setup.php" method="POST">

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" id="email" placeholder="username or email" name="email" >
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="password" name="password" >
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="LogIn">
      </div>
       <div class="form-group">
        <span> don't have account</span>
         <a class="hereBtn" href="index.php?signup"> signup here</a>
       </div>
       <div class="form-group">
        <span> Forgot Password?</span>
         <a class="hereBtn" href="index.php?pwd-reset-request"> reset here</a>
       </div>
    </form>
    
  </div>  

</div>



