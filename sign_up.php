<?php

  session_start();

  //check that the session is valid (if yes show content)
if(!(isset($_SESSION['']))){
  echo <<<EOL
    <!doctype html>
      <html lang="en">
      <head>

      <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-153768096-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-153768096-1');
</script>

        <meta charset="utf-8">
        <link rel="stylesheet" href="/css/master.css">
        <title>Owlboard | Create Account</title>
        <link rel="stylesheet" href="styles.css">
      </head>

        <body>
          <div class="page-container">
              <div class="project-info">
                <h1>Owlboard</h1>
                <h2>Welcome to Owlboard</h2>
                <p>Use the form to the right to login or create an account.</p>
              </div>
              <div class="form-container">
                <form class="form-signin" action="php/sign.php" method="post">
                  <div class="header">
                    <span>Create Account</span>                  
                  </div>
                  <div class="input-1">
                    <input type="text" name="username" placeholder="Username" value="">
                  </div>
                  <div class="input-2">
                    <input type="password" name="password" placeholder="Password" value="">
                  </div>
                  <div class="input-3">
                    <input type="input" placeholder="ID Number" name="ID" value="">
                  </div>
                  <!--<div>
                    <input type="file" name="pic" accept="image/*">
                  </div>--> 
                  <div class="account-type-selection">
                    <div class="input-options">
                      <span class="account-type" id="at-1">
                        <label class="account-type" for="admin-input">Admin</label>
                        <input type="radio" class="radio-input" name="type" value="1" id="admin-input">
                      </span>
                      <span class="account-type" id="at-2">
                        <label class="account-type" for="student-input">Student</label>
                        <input type="radio" class="radio-input" value="0" name="type" id="student-input">
                      </span>
                    </div>
                  </div>  
                  <button type="submit" name="s_btn" style="margin-top:20px;">Sign Up</button>
                  <hr>       
                  <a class="btn-2" href="http://lamp.cse.fau.edu/~cen4010fal19_g08/" type="button">Return to Login</button>
                </form>
              </div>

              <footer>
                <div class="links">
                  <a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/sign_up.php">Sign Up</a>
                  <a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/">Log In</a>
                </div>
                <hr>
                <p>Owlboard © 2019</p>
                <div class="product-info">
                  <p><b>A <span>Linkversity Labs</span> Product</b> by William Donahue, Raul Tiza, Evander Mendonca, and Edgar Herrera</p>
                </div>
              </footer>
          </div>
        </body>
      </html>
EOL;
}


  //if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: login.php');
}

?>