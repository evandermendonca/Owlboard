<?php
session_start();
require_once 'mysql_login.php';


if(isset($_SESSION['logged']) and isset($_SESSION['user']) and isset($_POST['report_text']) and isset($_POST['origin']))
{

	$user = $_SESSION["user"];
	$conn = new mysqli($hn, $db, $pw, $un) or die("Connect failed: %s\n" . $conn->error);
	$report_owner = $user;
	$post_id = $_POST['origin'];
	$report_text = $_POST['report_text'];
	$report_id = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$query_string = "INSERT INTO  Reports (post_id, report_text,report_owner) VALUES ('$post_id', '$report_text', '$report_owner')";

	 if ($result = $conn->query($query_string)) {
		$role = $_SESSION["admin"];
		$special_action = "";
		if($role =="1") {
		    $special_action = "<span id='edit-post'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/edit_post.php?id=$post_id'>Edit Post</a></span>";
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
								<div class='post-message' styles='height: 60px;'>
									<span style='display: block; margin-top: 15px;'>Post successfully reported.</span>
									<div class='links' styles='display:block;'>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Go to Wall</a>
										<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/report_post.php?id=$post_id'>Return to Post</a>
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
		$role = $_SESSION["admin"];
		$special_action = "";

      if($role =="1")
      {
      $special_action = "<span id='edit-post'><a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/edit_post.php?id=$post_id'>Edit Post</a></span>";
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
						<div class='post-message' styles='height: 60px;'>
							<span style='display: block; margin-top: 15px;'>Report failed.</span>
							<div class='links' styles='display:block;'>
								<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php'>Go to Wall</a>
								<a href='http://lamp.cse.fau.edu/~cen4010fal19_g08/report_post.php?id=$post_id'>Return to Post</a>
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

?>
