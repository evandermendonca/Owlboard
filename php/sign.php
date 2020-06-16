<?php

require_once 'mysql_login.php';

	function valid_chars($a) 
	{
		if(strpos($a, ' ') !== false)
		{
			return False;
		}
		if(strpos($a, '!') !== false)
		{
			return False;
		}
		if(strpos($a, '@') !== false)
		{
			return False;
		}
		if(strpos($a, '%') !== false)
		{
			return False;
		}
		if(strpos($a, '*') !== false)
		{
			return False;
		}
		return True;
	}
	// This nested loop works as follows:
	// check if username and student/fau id contain valid characters (no spaces, exclamations or the @ symbol)

	//if the tests pass, check if the password, username and fau id have the appropriate length
	//lastly all data passes the length test, create a mysql connection and check the data against the database

	if(valid_chars($_POST["username"])  == False)
	{
		echo "Invalid characters in username";
	}
	else
	{
		if(valid_chars($_POST["ID"])== False)
		{
			echo "Invalid characters FAU ID";
		}
		else
		{
			if(strlen($_POST["ID"]) > 4 and strlen($_POST["username"]) > 4
				and strlen($_POST["password"]) > 4 and strlen($_POST["ID"]) <= 10 and strlen($_POST["username"]) <= 20
				and strlen($_POST["password"]) <= 20 )
			{
				//next we create a mysql connection and check the user/pass/id 
				//against our records in the database (to make sure no duplicates exist)
					$fau_id = $_POST["ID"];
					$user = $_POST["username"];
					$pass = $_POST["password"];
					$account_type = $_POST["type"];

	      $conn = new mysqli($hn, $db, $pw,$un)
	      or die("Connect failed: %s\n". $conn -> error);

	      $con_pwd = hash("md5","$regex+$user+$pass");
	      $query_string = "SELECT * FROM Profiles WHERE username = '$user' OR fau_id = '$fau_id'";

	      if($result = $conn->query($query_string))
	      {

	        if($result -> num_rows > 0)
	        {
	          
	          echo"username or FAU ID associated with another account!";

	        }
	        else
	        {
	            $insert_q = "INSERT INTO Profiles (username, password, fau_id, admin) VALUES('$user','$con_pwd','$fau_id','$account_type')";
			      if($response = $conn->query($insert_q))
			      {
			      	echo "Sucess! You have been registered!";
			      }
			      else
			      {
			      	echo "error registration failed! Try Again";
			      }
	        }
	      }
	      else
	      {
	        echo "error!";
	      }
	      $conn -> close();

			}

			else
			{
				echo"Invalid Username/password/ID length! Minimum length is 4 characters";
			}
		}
	}


?>