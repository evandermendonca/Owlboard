<?php
session_start();
require_once 'mysql_login.php';
if(isset($_SESSION['logged']) and isset($_SESSION['user']))
{
	if(isset($_POST['title']) and isset($_POST['category']) and isset($_POST['location']))
	{
		$username = $_SESSION['user'];
		$post_title = $_POST['title'];
		$event_location = $_POST['location'];
		$post_category = $_POST['category'];
		$post_text = $_POST['post_text'];
		if($post_category !="" and $event_location !="" and $post_text !="")
		{

			
	        $conn = new mysqli($hn, $db, $pw, $un) or die("Connect failed: %s\n" . $conn->error);
			$post_id = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	        $query_string = "INSERT INTO  Posts (username, post_id, post_title, post_text,post_category, post_physical_event_location)
			VALUES ('$username', '$post_id', '$post_title', '$post_text', '$post_category', '$event_location');";

			$url1 = $_POST['url1'];
			$url2 = $_POST['url2'];
			$url3 = $_POST['url3'];
			$url4 = $_POST['url4'];





			if(strpos($url1, '.jpg') !== false AND strpos($url1, '.gif') !== false  AND strpos($url1, '.png') !== false){ $url1 = "empty";}
			if(strpos($url2, '.jpg') !== false AND strpos($url2, '.gif') !== false  AND strpos($url2, '.png') !== false){ $url2 = "empty";}
			if(strpos($url3, '.jpg') !== false AND strpos($url3, '.gif') !== false  AND strpos($url3, '.png') !== false){ $url3 = "empty";}
			if(strpos($url4, '.jpg') !== false AND strpos($url4, '.gif') !== false  AND strpos($url4, '.png') !== false){ $url4 = "empty";}

			$query_string .= "INSERT INTO  Post_images (post_id, source_1, source_2, source_3, source_4)
					VALUES ('$post_id', '$url1', '$url2', '$url3', '$url4')";


			if ($result = $conn->multi_query($query_string)) 
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
						<link rel='stylesheet' type='text/css' href='../wall.css' media='screen'>
						<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
						<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' crossorigin='anonymous'></script>
						<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' integrity='sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb' crossorigin='anonymous'></script>
						<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js' integrity='sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn' crossorigin='anonymous'></script>
					</head>
		
					<body>
						<header>
							<div class='logo'>
							<h1>Owlboard</h1>
							<h3 class='text-center'>Hello,<span> $username</span></h3>
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
								<div class='post-message' styles='height: 60px;'>
									<span style='display: block; margin-top: 15px;'>Post successful.</span>
									<div class='links' styles='display:block;'>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Go to Wall</a>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php'>Make Another Post</a>
									</div>
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
						<link rel='stylesheet' type='text/css' href='../wall.css' media='screen'>
						<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
						<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' crossorigin='anonymous'></script>
						<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' integrity='sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb' crossorigin='anonymous'></script>
						<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js' integrity='sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn' crossorigin='anonymous'></script>
					</head>
		
					<body>
						<header>
							<div class='logo'>
							<h1>Owlboard</h1>
							<h3 class='text-center'>Hello,<span> $username</span></h3>
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
								<div class='post-message' styles='height: 60px;'>
									<span style='display: block; margin-top: 15px;'>Error! Make sure all fields are filled and image is of the correct type.</span>
									<div class='links' styles='display:block;'>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Go to Wall</a>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php'>Make Another Post</a>
									</div>
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
					<link rel='stylesheet' type='text/css' href='../wall.css' media='screen'>
					<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
					<script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' crossorigin='anonymous'></script>
					<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js' integrity='sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb' crossorigin='anonymous'></script>
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js' integrity='sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn' crossorigin='anonymous'></script>
				</head>
	
				<body>
					<header>
						<div class='logo'>
						<h1>Owlboard</h1>
						<h3 class='text-center'>Hello,<span> $username</span></h3>
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
							<div class='post-message' styles='height: 60px;'>
								<span style='display: block; margin-top: 15px;'>Error! Make sure all fields are filled and image is of the correct type.</span>
								<div class='links' styles='display:block;'>
									<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Go to Wall</a>
									<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/new_post.php'>Make Another Post</a>
								</div>
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
	else
	{
		header('Location: ../wall.php');
	}
}
else
{
 	header('Location: ../wall.php');
}
?>