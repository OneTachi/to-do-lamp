
<?php
	$conn = new mysqli("localhost", "notroot", "password", "users");

	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
		
	} else { echo "CONNECTED"; }

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		// Check if in database
		$sql = "SELECT username, password FROM table1 WHERE username='$username'";
		$result = $conn->query($sql);
		if ($result->num_rows == 1)
		{
			while ($row = $result->fetch_assoc())
			{
				$dbusername = $row['username'];
				$dbpassword = $row['password'];
				if ($dbusername == $username && $dbpassword == $password) {
					session_start();
					$_SESSION["userlogin"] = $dbusername;
					// redirect
					header("Location: http://142.93.195.64/tasks.php");
					exit();
				}
				else { 
					$data = ["message"=> "account credentials denied" ]; 
					json_encode($data);
					header('Content-Type: application/json; charset=utf-8'); 
					header("Location: http://142.93.195.64/index.php");
					exit();
				}
			}
		} else { echo "Sorry, no matching account."; }
	}	
?>
