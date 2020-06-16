<?php
session_start();

//check that the session is valid (if yes show content)

if(isset($_SESSION['logged']) and isset($_SESSION['user']) )
{
  $user = $_SESSION['user'];

 $admin = $_SESSION["admin"];

      $special_link ="";

      if($admin =="1")
      {
      $special_link = "<li class='menuitem' id='mi-3'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/admin_page.php'>Admin Page</a></li>";
      }
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
          <title>Owlboard | New Post</title>
          <link rel="stylesheet" type="text/css" href="wall.css" media="screen">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
      </head>
  
    <body>
      <header>
          <div class="logo">
             <h1>Owlboard</h1>
             <h3 class="text-center">Hello,<span> $user</span></h3>
          </div>
          <div class="navigation">
             <ul>
                <li class="menuitem" id="mi-1"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php">Home</a></li>
                <li class="menuitem" id="mi-2"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php">Post</a></li>
                <li class="menuitem" id="mi-2"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php">Account</a></li>
                $special_link
                <li class="menuitem" id="mi-3"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php">Log Out</a></li>
             </ul>
             <div class="search">
                <div class="container-1">
                      <form action="search_results.php">
                         <input onclick="myFunction()" autocomplete="off" type="text" name="post_title" id="search" placeholder="Search"/>
                         <button id="search-button" type="submit"><span class="icon"><i class="fa fa-search"></i></span></button>
                         <div class="search-radios" id="search-radios">
                            <ul class="radios-content">
                               <li><input type="radio" name="category" value="All">All</li>
                               <li><input type="radio" name="category" value="Complaint">Complaints</li>
                               <li><input type="radio" name="category" value="Event">Events</li>
                            </ul>
                         </div>
                      </form>
                </div>
             </div>
          </div>
      </header>
      
      <main role="main">

        <div class="new-post-container">
          <div class="form-container-2">
              <div class="title-container">
                <span>Create Post</span>
              </div>
              
              <form class="" action="php/post.php" method="post">
                <div class="post-content">
                  <input type="text" placeholder="Post Title" id="title" name="title" maxlength="100" value="">
                  <textarea id="description" placeholder="What's your event or complaint?" rows = "10" cols = "60" name = "post_text"></textarea>
                </div>

                <div class="input-container">
                  <div class="selection-inputs">
                    <select name="category">
                      <option value="">Select Category</option>                  
                      <option value="Complaint">Complaint</option>
                      <option value="Event">Event</option>
                    </select>

                    <select name="location">
                      <option value="">Select Location</option> 
                      <option value="bldg1">EE-96</option>
                      <option value="bldg2">PS-55</option>
                      <option value="bldg3">SE-43</option>
                      <option value="bldg4">ED-47</option>
                    </select>
                  </div>
                </div>

                  <div id="image-button" onclick="myFunction2()">Click to Add Images</span></div>
                  <div id="image-container" style="display: none;">
                    <span>Use the inputs below to add up to four images (formats allowed: .gif, .jpeg, .png)</span>
                    <input type="url" name="url1" placeholder="enter image url"><br>
                    <input type="url" name="url2" placeholder="enter image url"><br>
                    <input type="url" name="url3" placeholder="enter image url"><br>
                    <input type="url" name="url4" placeholder="enter image url"><br>
                  </div>

                <div class="button-container">
                  <button type="submit" class="post-button" name="button">Submit Post</button>
                </div>
            </form>
          </div>
          

        </div>

     </main>


  </body>
  <script>
  function myFunction() {
     var x = document.getElementById("search-radios");
     if (x.style.display === "block") {
     x.style.display = "none";
     } else {
     x.style.display = "block";
     }
  }

  function myFunction2() {
    var x = document.getElementById("image-container");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
     x.style.display = "block";
    }
 }
</script>
</html>
EOL;
}

//if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: login.php');
}


?>
