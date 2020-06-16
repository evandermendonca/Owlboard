<?php
session_start();
require_once 'php/mysql_login.php';


function echo_entry($entries)
{
while($result=$entries->fetch_array())
{
    //variable declarations
    $post_title = $result['post_title'];
    $time_posted =$result['time_posted'];
    $post_text = $result['post_text'];
    $username = $result['username'];
    $date = date("m/d/y - g:i A", strtotime("$time_posted"));
    $event_location = $result['post_physical_event_location']; 
    $post_status = $result['post_resolution'];

    if($post_status == "Completed")
    {
        $post_status= "<span style='color: green; weight: bold;'>Completed</span>";
    }
    if($post_status == "Not processed")
    {
        $post_status= "<span style='color: #0081B0; weight:bold;'>Not processed</span>";
    }
    else
    {
        $post_status="<span style='color: #AF3000; weight:bold;'>";
        $post_status.=$result['post_resolution'];
        $post_status.="</span>";

    }


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
    if($result['post_category']=="Complaint") {
    $post_img = "img/c_default.png";
    $post_type = "Complaint";
    } else if ($result['post_category']=="Complain") {
        $post_img = "img/c_default.png";
        $post_type = "Complaint";
    } else {
        $post_img = "img/e_default.png";
        $post_type = "Event";
    }

    echo <<<EOL
    <div class="compaint-item">
    <div class="items-container">
        <div class="item-element" id="title">
            <span>$post_title</span> 
        </div>
        <div class="item-element" id="date">
            <span>$date</span>
        </div>
        <div class="item-element" id="description">
            <span>$post_text</span>
        </div>
        <div class="item-element" id="location">
            <span>$event_location</span>
        </div>
        <div class="item-element" id="status">
            <span>$post_status</span>
        </div>
    </div>
    </div>
EOL;
  };

}

function echo_entry2($entries)
{
while($result=$entries->fetch_array())
{
    //variable declarations
    $report_title = $result['report_text'];
    $time_posted =$result['time_posted'];
    $report_owner = $result['report_owner'];
    $date = date("m/d/y - g:i A", strtotime("$time_posted"));
    $post_id = $result['post_id']; 


    echo <<<EOL
    <div class="compaint-item">
    <div class="items-container" id="report-item">
        <div class="item-element" id="title">
            <span>$report_title</span> 
        </div>
        <div class="item-element" id="date">
            <span>$date</span>
        </div>
        <div class="item-element" id="link">
            <span><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id">View</a></span>
        </div>
    </div>
    </div>
EOL;
  };

}

//check that the session is valid (if yes show content)

if(isset($_SESSION['logged']) and isset($_SESSION['user']))
{

  $user = $_SESSION["user"];
  $conn = new mysqli($hn, $db, $pw,$un)
  or die("Connect failed: %s\n". $conn -> error);

  $conn2 = new mysqli($hn, $db, $pw,$un)
  or die("Connect failed: %s\n". $conn2 -> error);

  $query_string = "SELECT * FROM Posts WHERE (post_resolution !='Completed' AND username = '$user' AND (post_category ='Complain' or post_category = 'Complaint') ) ORDER BY time_posted DESC";
  $query_string2 = "SELECT * FROM Reports WHERE report_owner = '$user' ORDER BY time_posted DESC";



  if($result = $conn->query($query_string))
        {
 

            $special_link ="";
  $user = $_SESSION["user"];
  $admin = $_SESSION["admin"];

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
        <title>Owlboard | Account</title>
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
            <div class="complaints-container">
                <div class="header-container">
                    <h1>Your Complaints</h1>
                </div>
                <div class="main-container">
                    <div class="compaint-item">
                        <div class="items-container">
                            <div class="title-element" id="title">
                                <span class="title">Complaint Title</span> 
                            </div>
                            <div class="title-element" id="date">
                                <span class="title">Date Filed</span>
                            </div>
                            <div class="title-element" id="description">
                                <span class="title">Description</span>
                            </div>
                            <div class="title-element" id="location">
                                <span class="title">Location</span>
                            </div>
                            <div class="title-element" id="status">
                                
                            </div>
                        </div>
                    </div>
EOL;

    echo_entry($result);

echo <<<EOL
                </div>
            </div>

            <div class="complaints-container">
                <div class="header-container">
                    <h1>Your Reported Posts</h1>
                </div>
                <div class="main-container">
                    <div class="compaint-item">
                        <div class="items-container" id="report-item">
                            <div class="title-element" id="title">
                                <span class="title">Report Description</span> 
                            </div>
                            <div class="title-element" id="date">
                                <span class="title">Date Reported</span>
                            </div>
                            <div class="title-element" id="link">
                                <span class="title">View Post</span>
                            </div>
                           
                        </div>
                    </div>
EOL;

    if ($result2 = $conn2->query($query_string2)) {
    echo_entry2($result2);
    }

echo <<<EOL
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
       </script>
    </html>
EOL;


}

}
//if the session is not valid send the user to the page that will allow them to create a valid session
else{
  header('Location: login.php');
}


?>