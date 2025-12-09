<?php
require_once 'includes/security/config_session.inc.php';
require_once 'includes/signup/signup_view.inc.php';
?>

<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <link rel="stylesheet" href="./css/signup.css"> 
</head> 
<body>
  <section> 
    <span></span> <span></span> <!-- ...other span elements... --> 
    <div class="signin"> 
      <div class="content"> 
        <h2>Sign up</h2> 
        <div class="form">
          <form action="includes/signup/signup.inc.php" method="post">
            <div class="inputBox"> 
              <input type="text" name="username" placeholder="Username">
            </div>
            <div class="inputBox"> 
              <input type="password" name="pwd" placeholder="Password">
            </div> 
            <div class="inputBox"> 
              <input type="text" name="email" placeholder="E-mail">
            </div> 
            <div class="radio-group radio-group-custom">
              <label><input type="radio" name="roles" value="tutor"> Tutor</label>
              <label><input type="radio" name="roles" value="learner"> Learner</label>
            </div>
            <div class="inputBox"> 
              <button>Signup</button>
            </div> 
          </form>
          <?php

          check_signup_errors();
          
          ?>
        </div> 
      </div> 
    </div> 
  </section> 
</body>
</html>

