<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <link rel="stylesheet" href="./css/sign.css"> 
</head> 
<body>
  <section> 
    <div class="signin"> 
      <div class="content"> 
        <h2>Sign In</h2> 
        <div class="form">
          <form action="includes/login.inc.php" method="post">
            <div class="inputBox"> 
              <input type="text" name="username" placeholder="Username">
            </div>
            <div class="inputBox"> 
              <input type="password" name="pwd" placeholder="Password">
            </div>
            <div class="links"> 
              <a href="signup.php">Sign up</a> 
            </div> 
            <div class="inputBox"> 
              <button>Login</button>
            </div> 
          </form>
          <?php
          session_start();
          include 'includes/login_view.inc.php';
          check_login_errors();
          ?>
        </div> 
      </div> 
    </div> 
  </section> 
</body>
</html>
