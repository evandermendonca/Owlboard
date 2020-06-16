<?php
session_start();
require_once 'mysql_login.php';


if(isset($_SESSION['logged']) and isset($_SESSION['user']) and $_SESSION['admin'] =="1" )
{

	$post_id = $_POST['post_id'];
	$flag = $_POST['flag'];

	if($flag =="edit")
	{
		$post_title = $_POST['post_title'];
		$event_location = $_POST['event_location'];
		$post_category = $_POST['post_category'];
		$post_text = $_POST['post_text'];
		$post_resolution = $_POST['post_resolution'];

		$query_string = "UPDATE Posts 
						SET post_title = '$post_title', post_text = '$post_text', post_category = '$post_category',
						post_physical_event_location = '$event_location',
						post_resolution = '$post_resolution'
						WHERE post_id = '$post_id';";
        $query_string .= "DELETE FROM Reports WHERE post_id = '$post_id';";


		 $conn = new mysqli($hn, $db, $pw,$un)
		  or die("Connect failed: %s\n". $conn -> error);

		if ($result = $conn->multi_query($query_string)) 
			{
				echo "<script type='text/javascript'>window.location.href = 'http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php';</script>";
			}
		else
		{
			echo"error editing!";
		}
	}
	else if($flag =="moderate" and isset($_POST['moderation']))
	{
		 $conn = new mysqli($hn, $db, $pw,$un)
		  or die("Connect failed: %s\n". $conn -> error);

		  $query_string = "DELETE FROM Posts WHERE post_id = '$post_id';";
   	      $query_string .= "DELETE FROM Reports WHERE post_id = '$post_id';";
   	      $query_string .= "DELETE FROM Post_images WHERE post_id = '$post_id'";



		if ($result = $conn->multi_query($query_string)) 
			{
				echo "<script type='text/javascript'>window.location.href = 'http://lamp.cse.fau.edu/~cen4010fal19_g08/wall.php';</script>";
			}		
	}
	else{
		echo"error! all fields must be filled";
	}

}



else
{
  header('Location: login.php');
}


?>