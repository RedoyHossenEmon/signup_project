<nav class="menubar">
  <div class="left-side">
    <a href="index.php" class="logo">Logo</a>
    <ul class="menu-items">
      <li><a href="#" class="">Friends</a></li>
      <li><a href="#" class="">Active</a></li>
      <li><a href="#" class=""> <b>A</b>LL</a></li>
      </ul>
  </div>
  <div class="right-side">
    <ul class="menu-items">
      <li class="notf"><a href="#">Notifications</a></li>
      <li><a href="#">Inbox</a></li>
      <li class="submenu">
        <ul class="submenu-items">
          <li><a href="#">letest</a></li>
          <li><a href="#">best-topic</a></li>
          <li><a href="#">relative</a></li>
        </ul>
      </li>
<!--  setting logout or login button by checking session  -->
      <?php if (isset($_SESSION['username'])) {  ?>

      <li class="submenu">
        <a href="#">Profile</a>
        <ul class="submenu-items">
          <li><a href="#">Settings</a></li>
          <li><a href="#">Help</a></li>
          <li><a href="includes/logout.php">Logout</a></li>
        </ul>
      <li class="profile-pic">
        <img src="images/esther-jiao-ADv0GiMBlmI-unsplash.jpg" alt="Profile Picture">
      </li>

      <?php    }else{    ?>

      <li>
        <a  href="index.php?login" class="active">login</a>
        <a  href="index.php?signup" style="text-decoration:underline; color:blue">signup</a>
      </li>
    </ul>

    <?php   }   ?>

  </div>
</nav>