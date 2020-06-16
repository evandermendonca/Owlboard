<?php
session_start();
require_once 'php/mysql_login.php';


function echo_entry($entries,$role)
{

   //slideshow ids
   $slide_id = 0; 
   $dot_id = 0;
  while($result=$entries->fetch_array())
  {
     //variable declarations
      $post_id = $result['post_id'];
      $post_title = $result['post_title'];
      $time_posted =$result['time_posted'];
      $post_text = $result['post_text'];
      $username = $result['username'];
      $date = date("m/d/y - g:i A", strtotime("$time_posted"));
      $event_location = $result['post_physical_event_location']; 

      //determine event location 
      if ($event_location == "blgd1" || $event_location == "bldg1") {
         $event_location = "EE-96";
      } else if ($event_location == "bldg2" || $event_location == "blgd2") {
         $event_location = "PS-55";
      } else if ($event_location == "bldg3") {
         $event_location = "SE-43";
      } else if ($event_location == "bldg4") {
         $event_location = "ED-43";
      }

      //category information 
      if($result['post_category']=="Complaint") 
      {
        $post_img = "img/c_default.png";
        $post_type = "Complaint";
      } else if ($result['post_category']=="Complain") {
         $post_img = "img/c_default.png";
         $post_type = "Complaint";
      } else {
          $post_img = "img/e_default.png";
          $post_type = "Event";
      }

      //image
      $image_query = "SELECT p.source_1, p.source_2, p.source_3, p.source_4 FROM Post_images as p WHERE p.post_id = '$post_id'";
      global $hn; global $db; global $pw; global $un;
      $sql_connection = new mysqli($hn, $db, $pw,$un)
      or die("Connect failed: %s\n". $conn -> error);

      if($result2 = $sql_connection->query($image_query))
      {
        if($result2->num_rows != 0)
        {
          $row = $result2->fetch_array();
          $url1 = $row['source_1'];
          $url2 = $row['source_2'];
          $url3 = $row['source_3'];
          $url4 = $row['source_4'];
          $post_main_image = "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages2.minutemediacdn.com%2Fimage%2Fupload%2Fc_crop%2Ch_3377%2Cw_6016%2Cx_0%2Cy_938%2Ff_auto%2Cq_auto%2Cw_1100%2Fv1554922136%2Fshape%2Fmentalfloss%2F524149-istock-855103576_primary.jpg&f=1&nofb=1";

          if($url1 !="")
          {
            $post_main_image = $url1;
          }
          elseif($url2 !="")
          {
            $post_main_image = $url2;
          }
          elseif($url3 !="")
          {
            $post_main_image = $url3;
          }
          elseif($url4 !="")
          {
            $post_main_image = $url4;
          } 
          
          if ($url1 == "") {
            $url1 = 'https://g1-addtext.ft-uc.com/MjAxOTEyMDQ/addtext_com_MDQ0MjUwNTY4MA.jpg';
          } 
          if ($url2 == "") {
            $url2 = 'https://g1-addtext.ft-uc.com/MjAxOTEyMDQ/addtext_com_MDQ0MjUwNTY4MA.jpg';
          } 
          if ($url3 == "") {
            $url3 = 'https://g1-addtext.ft-uc.com/MjAxOTEyMDQ/addtext_com_MDQ0MjUwNTY4MA.jpg';
          }
          if ($url4 == "") {
            $url4 = 'https://g1-addtext.ft-uc.com/MjAxOTEyMDQ/addtext_com_MDQ0MjUwNTY4MA.jpg';
          } 
                
        }
      }

      $special_action = "";

      if($role =="1")
      {
      $special_action = "<span id='edit-post'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/edit_post.php?id=$post_id'>Edit Post</a></span>";
      }

      echo <<<EOL
      <div class="post-card">
      <div class="post-information">
         <div class="header">
            <div class="author">
               <h2>$username</h2>
            </div>
            <div class="time-stamp">
               <span>$date</span>
            </div>
         </div>
          
         <div class="slideshow-container">
            <div class="mySlides-$slide_id fade">
               <img src="$post_main_image" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
            </div>
            <div class="mySlides-$slide_id fade" style="display:none;">
               <img width="100%" height="225" src="$url2" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
            </div>
            <div class="mySlides-$slide_id fade" style="display:none;">
               <img width="100%" height="225" src="$url3" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
            </div>
            <div class="mySlides-$slide_id fade" style="display:none;">
               <img width="100%" height="225" src="$url4" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
            </div>
            <a class="prev" onclick="plusSlides(-1, $slide_id)">&#10094;</a>
            <a class="next" onclick="plusSlides(1, $slide_id)">&#10095;</a>
         </div>
     
         <div class="card-body">
            <p class="card-text">
               <span class="title"><b>$post_title</b></span>
               <br>
               $post_text
            </p>
            <div class="closing-information">
               <span id="view-post"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id">View Post</a></span>
               <span id="report-post"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/report_post.php?id=$post_id">Report Post</a></span>
               $special_action
               <hr>
               <span id="hashtags">#$post_type</span>
               <span id="location">Building: $event_location</span>
            </div>
         </div>
      </div>
   </div>
EOL;
   $slide_id = $slide_id + 1;
   $dot_id = $dot_id + 1;
  };

}

//check that the session is valid (if yes show content)

if(isset($_SESSION['logged']) and isset($_SESSION['user']))
{

  $conn = new mysqli($hn, $db, $pw,$un)
  or die("Connect failed: %s\n". $conn -> error);
  $query_string = "SELECT * FROM Posts WHERE post_resolution !='Completed' ORDER BY time_posted DESC";
  
  if($result = $conn->query($query_string))
        {
  $user = $_SESSION["user"];
  $admin = $_SESSION["admin"];

      $special_link ="";

      if($admin =="1")
      {
      $special_link = "<li class='menuitem' id='mi-4'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/admin_page.php'>Admin Page</a></li>";
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
        <title>Owlboard | Wall</title>
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
                  <li class="menuitem" id="mi-3"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php">Account</a></li>
                  $special_link
                  <li class="menuitem" id="mi-5"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php">Log Out</a></li>
               </ul>
               <div class="search">
                  <div class="container-1">
                        <form action="search_results.php" method ="post">
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
            <div class="container">
EOL;

echo_entry($result,$admin);

echo "
             </div>
          </main>
       </body>
       <script>
         function myFunction() {
            var x = document.getElementById('search-radios');
            if (x.style.display === 'block') {
            x.style.display = 'none';
            } else {
            x.style.display = 'block';
            }
         }

         var slideIndex = 1;
         showSlides(slideIndex, num);

         function plusSlides(n, num) {
         showSlides(slideIndex += n, num);
         }

         function currentSlide(n, num) {
         showSlides(slideIndex = n, num);
      }

         
         function showSlides(n, num) {
         var i;
         var slides = document.getElementsByClassName('mySlides-' + num);
         if (n > slides.length) {slideIndex = 1}    
         if (n < 1) {slideIndex = slides.length}
         for (i = 0; i < slides.length; i++) {
               slides[i].style.display = 'none';  
         }
         
         slides[slideIndex-1].style.display = 'block'; 
         }
       </script>
    </html>";
}

}
//if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: login.php');
}


?>
