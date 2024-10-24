<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	 $conn = new mysqli("localhost", "notroot", "password", "users");

	if ($conn->connect_error)
	{	
	    die("Connection failed: " . $conn->connect_error);
	
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    
	$sql = "SELECT username, password FROM table1 WHERE username='$username'";
    $result = $conn->query($sql);
    if (!($result->num_rows > 0))
    {
		$sql = "INSERT into table1(user, password) VALUES ('$user', '$password')";
        session_start();
        $_SESSION["userlogin"] = $username;
        // redirect
        header("Location: http://142.93.195.64/tasks.php");
        $conn->close();
        exit();
    }
} else { echo "no."; header("index.php"); }
?>

