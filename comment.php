<?php
session_start();
require_once 'mysql_login.php';


if(isset($_SESSION['logged']) and isset($_SESSION['user']) and isset($_POST['comment_text']) and isset($_POST['origin']))
{

	$user = $_SESSION["user"];
	$conn = new mysqli($hn, $db, $pw, $un) or die("Connect failed: %s\n" . $conn->error);
	$comment_owner = $user;
	$post_id = $_POST['origin'];
	$comment_text = $_POST['comment_text'];
	$comment_id = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$query_string = "INSERT INTO  Comments (post_id, comment_text,comment_owner) VALUES ('$post_id', '$comment_text', '$comment_owner')";

	 if ($result = $conn->query($query_string)) 
				        {
				        	echo"<script type='text/javascript'>window.location.href = 'http://lamp.cse.fau.edu/~cen4010fal19_g08/view_post.php?id=$post_id';</script>";
				        }
	else
	{

	}


}


else
{
  header('Location: ../wall.php');
}

?>
