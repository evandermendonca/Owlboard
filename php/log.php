<?php

require_once "mysql_login.php";
session_start();

if (isset($_POST['username']) and isset($_POST['password'])) 
{
    if (strlen($_POST['username']) != 0 and strlen($_POST['password']) != 0) 
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $conn = new mysqli($hn, $db, $pw, $un) or die("Connect failed: %s\n" . $conn->error);
        
        $con_pwd = hash("md5", "$regex+$user+$pass");
        $query_string = "SELECT * FROM Profiles WHERE username = '$user' AND password = '$con_pwd'";
        
        if ($result = $conn->query($query_string)) 
        { 
            if ($result->num_rows != 0) 
            {
                if($result->num_rows == 1)
                {
                    $row =$result-> fetch_assoc();
                    $_SESSION["admin"] = $row["admin"];
					$_SESSION["logged"] = "yes";
					$_SESSION["user"] = "$user";
					header('Location: ../login.php');					
            	}
            	else
            	{
            		echo"Error. Contact Administrator";
            	}
                
            } 
            else 
            {
            	echo "Invalid Username/Password";
                }
            }
        }
    else {
        
        echo "Username/Password is empty!";    
		    }
}
    
 else {
    header('Location: ../wall.php');
}

?>