<html>
	<h1>Please login below.</h1>
	<p>Note: Do not use any real usernames or passwords. None of this is secure lol</p>
	<div id="login">
		<form method="post" action="index.php">
			Username: <input type="text" name="username"><br>
			Password:  <input type="password" name="password"><br>
			<input type="submit">
		</form>
		<button class="switch">Want to sign up?</button>
	</div>
    <div id="signup" class="hidden">
        <form method="post" action="signup.php">
            Username: <input type="text" name="username"><br>
            Password:  <input type="password" name="password"><br>
			<input type="submit">
        </form>
        <button class="switch">Need to login?</button>
    </div>

</html>
<style>
.hidden {
	display:none
}
</style>

<?php
	$conn = new mysqli("localhost", "notroot", "password", "users");

	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
		
	}

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
					$conn->close();
					exit();
				}
				else { echo "account credentials denied."; }
			}
		} else { echo "Sorry, no matching account."; }
	}	
?>

<script>
const btns = document.getElementsByClassName("switch");
const loginBtn = document.getElementById("login");
const signupBtn = document.getElementById("signup");
for (var btn = 0 ; btn < btns.length; btn++) {
	btns[btn].addEventListener("click", () => {
		if (loginBtn.classList.contains("hidden")) {loginBtn.classList.remove("hidden"); signupBtn.classList.add("hidden"); }
		else { loginBtn.classList.add("hidden"); signupBtn.classList.remove("hidden");} 
	});
}
</script>
