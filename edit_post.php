<?php
session_start();
require_once 'php/mysql_login.php';


if(isset($_SESSION['logged']) and isset($_SESSION['user']) and isset($_GET['id']))
{
  $user = $_SESSION["user"];
  $role = $_SESSION["admin"];
  $post_id = $_GET['id'];
  $conn = new mysqli($hn, $db, $pw,$un)
  or die("Connect failed: %s\n". $conn -> error);

  $query_string = "SELECT * FROM Posts WHERE post_id ='$post_id';";

  $conn1 = new mysqli($hn, $db, $pw,$un)
  or die("Connect failed: %s\n". $conn -> error);

  $query_string1 = "SELECT * FROM Profiles WHERE username ='$user';";
  $admin = false;

  if($result1 = $conn1->query($query_string1))
  
  {

  	if($result1->num_rows == 1)
  	{
		$row1=$result1->fetch_array();
		$admin_status = $row1['admin'];

		if($admin_status == "1")
		{
			$admin = true;
		}
		else
		{
			$admin = false;
		}
	}
  }
  else{
  	$admin=false;
  }


  if($result = $conn->query($query_string)) 
  {

	
  	if($result->num_rows == 1)
  	{
		$row=$result->fetch_array();
		$username = $row['username'];
  		$post_title = $row['post_title'];
  		$post_text = $row['post_text'];
   		$post_category = $row['post_category'];
		$time_posted = $row['time_posted'];
		$event_location = $row['post_physical_event_location']; 
		$date = date("m/d/y - g:i A", strtotime("$time_posted"));
 		$post_resolution = $row['post_resolution'];

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

		

if($admin == true){

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
			<title>Owlboard | Edit Post</title>
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

			<main role="main-comment-container" class="main-comment-container">
				<div class="little-comment-container">
					<div class="post-card">

						<div class="comments" id="comments-2">
							<div class="post-comment">
								<div class="edit-form-1">	
									<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Edit Post Content</h2>
									<span id="show-hide" onclick="myFunction3()">Show/Hide Edit Menu</span>
									<form method="post" id="form-1" action="php/edit.php" style="display: none;">
										<div class="edit-inputs">
											<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Post Title</h2>
											<textarea placeholder="Title: $post_title" id="edit-area" type="text" name="post_title" rows="3" cols="30">$post_title</textarea>
											<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Post content</h2>
											<textarea placeholder="Content: $post_text" type="text" id="edit-area" name="post_text" rows="15" cols="30">$post_text</textarea>
											<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Post Category</h2>
											<textarea placeholder="Category: $post_type" type="text" id="edit-area" name="post_category" rows="3" cols="30">$post_type</textarea>
											<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Post Location</h1><br><br>
											<textarea placeholder="Location: $event_location" type="text" id="edit-area" name="event_location" rows="3" cols="30">$event_location</textarea>
											<h1 style="font-size: 20px;padding-bottom: 26px;padding-top: 70px;">Post Status</h1>
											<textarea placeholder="State: $post_resolution" type="text" id="edit-area" name="post_resolution" rows="3" cols="30">$post_resolution</textarea>
											<input type="hidden" name="post_id"  value="$post_id">
											<input type="hidden" name="flag"  value="edit">
										</div>
										<input id="button" type="submit">	
									</form>
								</div>
								<div class="edit-form-2">
									<h1 style="font-size: 20px;padding-bottom: 25px;padding-top: 20px;">Delete Post</h1>
									<span id="show-hide" onclick="myFunction4()">Show/Hide Delete Menu</span>
									<form method="post" id="form-2" action="php/edit.php" style="display: none;">
										<div class="delete-input">Are you sure you want to delete this post?<input type="radio" name="moderation" value="delete"></div>
										<input type="hidden" name="post_id"  value="$post_id">
										<input type="hidden" name="flag"  value="moderate">
										<input id="button" type="submit">	
									</form>
								</div>
							</div>
						</div>
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

			function myFunction3() {
				var x = document.getElementById("form-1");
				if (x.style.display === "block") {
					x.style.display = "none";
				} else {
					x.style.display = "block";
				}
			}

			function myFunction4() {
				var x = document.getElementById("form-2");
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

	echo "<script type='text/javascript'>window.location.href = 'http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php';</script>";
}

   	}
   }
 }
else{
  header('Location: wall.php');
}

?>
