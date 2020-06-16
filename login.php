<?php
session_start();

//check that the session is valid (if yes show content)
if(!isset($_SESSION['logged']))
{
    echo <<<EOL
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Owlboard | Login</title>
        <link rel="stylesheet" type="text/css" href="wall.css" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        
      <meta charset="utf-8">
    
      <title>Owlboard | Login</title>
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
            <form class="form-signin" action="php/log.php" method="post">
              <div class="header">
                  <span>Login</span>                  
                </div>
              <div class="input-1">
                <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
              </div>
              <div class="input-2">
                  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
              </div>
              <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
              <hr>
              <a class="btn-2" href="http://lamp.cse.fau.edu/~cen4010fal19_g08/sign_up.php" type="button">Create New Account</button>
            </form>
          </div>
    
          <footer>
            <div class="links">
              <a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/sign_up.php">Sign Up</a>
              <a href="#">Log In</a>
            </div>
            <hr>
            <p>Owlboard © 2019</p>
            <div class="product-info">
              <p><b>A <span>Linkversity Labs</span> Product</b> by William Donahue, Raul Tiza, Evander Mendonca, and Edgar Herrera</p>
            </div>
          </footer>
        </div>
    
      </body>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153768096-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-153768096-1');
      </script>
    </html>
EOL;
}

//if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: wall.php');
}

?>
