<?php

session_start();

//check that the session is valid (if yes show content)

if(isset($_SESSION['logged']))
{
  echo <<<EOL
  <html>
  <head>
    <link rel="stylesheet" href="/css/master.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  </head>
  </html>




  <body>

  <h3>Post Title</h3>

  <form action="search_results.php" method="post">

  <input type="text" name="post_title"><br><br>

  <h3>Select Post Category Below</h3><br>

  <input type = "radio" name = "category" value = "All"> All 
  <input type = "radio" name = "category" value = "Complain"> Complain 
  <input type = "radio" name = "category" value = "Event"> Event<br>
  <button  type="submit">Search</button>
  </form>


  </body>
EOL;
}

//if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: login.php');
}


?>