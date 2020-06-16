<?php

require_once 'php/mysql_login.php';
session_start();

//check that the session is valid (if yes show content)

if(isset($_SESSION['logged']))
{

	//make sure that both post_title and category are set
	if(isset($_POST['post_title']) and isset($_POST['category']) and $_POST['post_title'] !="")
	{
		if($_POST['category'] =="Event")
		{
			//Split post_title into an array of individual words.
			$search = $_POST['post_title'];
			$search = str_replace("'s", '', $search);
			$search = str_replace("'", '', $search);
			$search = explode(" ",$search);

		    $conn = new mysqli($hn, $db, $pw,$un)
		    or die("Connect failed: %s\n". $conn -> error);

		    $query_string = "SELECT * FROM Posts WHERE (`post_title` LIKE '%".$search[0]."%')";
		    if(sizeof($search) > 1)
		    {
		    	for($x = 1; $x < sizeof($search); $x++)
		    	{
		    		$query_string .=" OR (`post_title` LIKE '%".$search[$x]."%')";
		    	}
		    }
 			$query_string .= " AND post_category = 'Event' ORDER BY time_posted DESC";

		    if($result = $conn->query($query_string))
		    {

	$user = $_SESSION["user"];		
	$special_link ="standard";
	$admin = $_SESSION["admin"];

	      if($admin =="1")
	      {
	      $special_link = "<li class='menuitem' id='mi-3'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/admin_page.php'>Admin Page</a></li>";
	      }

echo <<<EOL
	<!doctype html>
	<html lang="en">
		<head>
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
					<li class="menuitem" id="mi-2"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php">Account</a></li>
					$special_link
					<li class="menuitem" id="mi-3"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php">Log Out</a></li>
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
			   if($result -> num_rows > 0)
		        {
		          
		          while($row=$result->fetch_array())
		          {
					$post_title = $row['post_title'];
					$username = $row['username'];  
					$time_posted = $row['time_posted'];
					$post_text = $row['post_text'];
					$post_id = $row['post_id'];
					$date = date("m/d/y - g:i A", strtotime("$time_posted"));
					$event_location = $row['post_physical_event_location']; 

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
					if($row['post_category']=="Complaint") {
						$post_img = "img/c_default.png";
						$post_type = "Complaint";
					} else if ($row['post_category']=="Complain") {
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
					
							}
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
            
         <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="$post_main_image" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
         </img>
            
         <div class="card-body">
            <p class="card-text">
               <span class="title"><b>$post_title</b></span>
               <br>
               $post_text
            </p>
            <div class="closing-information">
               <span id="view-post"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id">View Post</a></span>
               <hr>
               <span id="hashtags">#$post_type</span>
               <span id="location">Building: $event_location</span>
            </div>
         </div>
      </div>
   </div>
EOL;
				  }
echo<<<EOL
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
		        else{
					echo "<div class='no-result'>
							<span>No Results found</span>
						</div>
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
			</script>
		</html>";
		        }

		    }

		}
		else if ($_POST['category'] =="Complaint")
		{
			//Split post_title into an array of individual words.
			$search = $_POST['post_title'];
			$search = str_replace("'s", '', $search);
			$search = str_replace("'", '', $search);
			$search = explode(" ",$search);

		    $conn = new mysqli($hn, $db, $pw,$un)
		    or die("Connect failed: %s\n". $conn -> error);

		    $query_string = "SELECT * FROM Posts WHERE (`post_title` LIKE '%".$search[0]."%')";
		    if(sizeof($search) > 1)
		    {
		    	for($x = 1; $x < sizeof($search); $x++)
		    	{
		    		$query_string .=" OR (`post_title` LIKE '%".$search[$x]."%')";
		    	}
		    }
 			$query_string .= " AND post_category = 'Complaint' ORDER BY time_posted DESC ";

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
					<li class="menuitem" id="mi-2"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php">Account</a></li>
					$special_link
					<li class="menuitem" id="mi-3"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php">Log Out</a></li>
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
			   if($result -> num_rows > 0)
		        {
		          
		          while($row=$result->fetch_array())
		          {
					$post_title = $row['post_title'];
					$username = $row['username'];  
					$time_posted = $row['time_posted'];
					$post_text = $row['post_text'];
					$post_id = $row['post_id'];
					$date = date("m/d/y - g:i A", strtotime("$time_posted"));
					$event_location = $row['post_physical_event_location']; 

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
					if($row['post_category']=="Complaint") {
						$post_img = "img/c_default.png";
						$post_type = "Complaint";
					} else if ($row['post_category']=="Complain") {
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
					
							}
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
            
         <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="$post_main_image" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
         </img>
            
         <div class="card-body">
            <p class="card-text">
               <span class="title"><b>$post_title</b></span>
               <br>
               $post_text
            </p>
            <div class="closing-information">
               <span id="view-post"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id">View Post</a></span>
               <hr>
               <span id="hashtags">#$post_type</span>
               <span id="location">Building: $event_location</span>
            </div>
         </div>
      </div>
   </div>
EOL;
				  }
echo<<<EOL
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
		        else{
					echo "<div class='no-result'>
							<span>No Results found</span>
						</div>
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
			</script>
		</html>";
		        }

		    }

		}
		else
		{
			//Split post_title into an array of individual words.
			$search = $_POST['post_title'];
			$search = str_replace("'s", '', $search);
			$search = str_replace("'", '', $search);
			$search = explode(" ",$search);

		    $conn = new mysqli($hn, $db, $pw,$un)
		    or die("Connect failed: %s\n". $conn -> error);

		    $query_string = "SELECT * FROM Posts WHERE (`post_title` LIKE '%".$search[0]."%')";
		    if(sizeof($search) > 1)
		    {
		    	for($x = 1; $x < sizeof($search); $x++)
		    	{
		    		$query_string .=" OR (`post_title` LIKE '%".$search[$x]."%')";
		    	}
		    }
 			$query_string .= " ORDER BY time_posted DESC";

		    if($result = $conn->query($query_string))
		    {
$user = $_SESSION["user"];
$user = $_SESSION["user"];
$admin = $_SESSION["admin"];

	$special_link ="";

	if($admin =="1")
	{
	$special_link = "<li class='menuitem' id='mi-4'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/admin_page.php'>Admin Page</a></li>";
	}
echo "<!doctype html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<title>Owlboard | Wall</title>
			<link rel='stylesheet' type='text/css' href='wall.css' media='screen'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' crossorigin='anonymous'></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' integrity='sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb' crossorigin='anonymous'></script>
			<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js' integrity='sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn' crossorigin='anonymous'></script>
		</head>

		<body>
			<header>
				<div class='logo'>
				<h1>Owlboard</h1>
				<h3 class='text-center'>Hello,<span> $user</span></h3>
				</div>
				<div class='navigation'>
				<ul>
					<li class='menuitem' id='mi-1'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Home</a></li>
					<li class='menuitem' id='mi-2'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php'>Post</a></li>
					<li class='menuitem' id='mi-3'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php'>Account</a></li>
					$special_link
					<li class='menuitem' id='mi-4'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php'>Log Out</a></li>
				</ul>
				<div class='search'>
					<div class='container-1'>
							<form action='search_results.php' method ='post'>
							<input onclick='myFunction()' autocomplete='off' type='text' name='post_title' id='search' placeholder='Search'/>
							<button id='search-button' type='submit'><span class='icon'><i class='fa fa-search'></i></span></button>
							<div class='search-radios' id='search-radios'>
								<ul class='radios-content'>
									<li><input type='radio' name='category' value='All'>All</li>
									<li><input type='radio' name='category' value='Complaint'>Complaints</li>
									<li><input type='radio' name='category' value='Event'>Events</li>
								</ul>
							</div>
							</form>
					</div>
				</div>
				</div>
			</header>
			
			<main role='main'>
				<div class='container'>";
			   if($result -> num_rows > 0)
		        {
		          
		          while($row=$result->fetch_array())
		          {
					$post_title = $row['post_title'];
					$username = $row['username'];  
					$time_posted = $row['time_posted'];
					$post_text = $row['post_text'];
					$post_id = $row['post_id'];
					$date = date("m/d/y - g:i A", strtotime("$time_posted"));
					$event_location = $row['post_physical_event_location']; 

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
					if($row['post_category']=="Complaint") {
						$post_img = "img/c_default.png";
						$post_type = "Complaint";
					} else if ($row['post_category']=="Complain") {
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
					
							}
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
            
         <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="$post_main_image" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
         </img>
            
         <div class="card-body">
            <p class="card-text">
               <span class="title"><b>$post_title</b></span>
               <br>
               $post_text
            </p>
            <div class="closing-information">
               <span id="view-post"><a href="http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id">View Post</a></span>
               <hr>
               <span id="hashtags">#$post_type</span>
               <span id="location">Building: $event_location</span>
            </div>
         </div>
      </div>
   </div>
EOL;
				  }

echo<<<EOL
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
		        else{
					echo "<div class='no-result'>
							<span>No Results found</span>
						</div>
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
			</script>
		</html>";
		        }

		    }

		}


	}
	else
	{
		$user = $_SESSION["user"];
		$admin = $_SESSION["admin"];
	  
			$special_link ="";
	  
			if($admin =="1")
			{
			$special_link = "<li class='menuitem' id='mi-4'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/admin_page.php'>Admin Page</a></li>";
			}				
		echo "<!doctype html>
			<html lang='en'>
				<head>
					<meta charset='utf-8'>
					<title>Owlboard | Wall</title>
					<link rel='stylesheet' type='text/css' href='wall.css' media='screen'>
					<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
					<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' crossorigin='anonymous'></script>
					<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' integrity='sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb' crossorigin='anonymous'></script>
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js' integrity='sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn' crossorigin='anonymous'></script>
				</head>
		
				<body>
					<header>
						<div class='logo'>
						<h1>Owlboard</h1>
						<h3 class='text-center'>Hello,<span> $user</span></h3>
						</div>
						<div class='navigation'>
						<ul>
							<li class='menuitem' id='mi-1'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Home</a></li>
							<li class='menuitem' id='mi-2'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php'>Post</a></li>
							<li class='menuitem' id='mi-3'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/account.php'>Account</a></li>
							$special_link
							<li class='menuitem' id='mi-4'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/logout.php'>Log Out</a></li>
						</ul>
						<div class='search'>
							<div class='container-1'>
									<form action='search_results.php' method ='post'>
									<input onclick='myFunction()' autocomplete='off' type='text' name='post_title' id='search' placeholder='Search'/>
									<button id='search-button' type='submit'><span class='icon'><i class='fa fa-search'></i></span></button>
									<div class='search-radios' id='search-radios'>
										<ul class='radios-content'>
											<li><input type='radio' name='category' value='All'>All</li>
											<li><input type='radio' name='category' value='Complaint'>Complaints</li>
											<li><input type='radio' name='category' value='Event'>Events</li>
										</ul>
									</div>
									</form>
							</div>
						</div>
						</div>
					</header>
					
					<main role='main'>
						<div class='container'>
							<div class='no-result'>
								<span>Error! All fields must be complete.</span>
							</div>
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
				</script>
			<html>";
	}
}

else{
  header('Location: login.php');
}


?>