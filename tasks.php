<html>
	<h1>This is where you can do all your tasks Yippee!</h1>
	<form action="clear-session.php" method="POST">	
		<input type="submit" value="Clear session" />
	</form>
	<input type="text" id="addtask">
	<br></br>
</html>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$user = "";
	session_start(); //starts all the sessions  
	if($_SESSION["userlogin"] == NULL) { 
		header('Location: http://142.93.195.64/index.php'); //take user to the login page if there's no information stored in session variable 
		exit();
	}  
	$user = $_SESSION["userlogin"];
	


	$db = new mysqli("localhost", "notroot", "password", "users");

	if ($db->connect_error)
	{
		die("Connection failed: " . $db->connect_error);
		header('Location: http://142.93.195.64/index.php'); //take user to the login page if there's no information stored in session variable
		unset($_SESSION['userlogin']); 
		exit();
	} //else { echo "CONNECTED"; }

	
	// Get all the data into table
	$result = $db->query("SELECT user, task, completed FROM tasks WHERE user='{$user}'") or die($db->error);;
	echo '<table id="the_table"><tr><th>Task</th><th>Completed?</th><th>Delete this</th></tr>';
	while($row = $result->fetch_assoc()) {
		echo '<tr>
		<td><input value="'.$row["task"].'"></td>
		<td><input type="checkbox" ';
		if ($row["completed"] == '1') {echo 'checked';}
		echo '></td> <td><button>Del</button></td> </tr>'; 
	}
	echo"</table>";
?>

<script>
const table = document.getElementById("the_table");
const addtask = document.getElementById("addtask");
table.addEventListener("change", (event) => {
	if (event.target.type == "checkbox") {
		let task = event.target.parentNode.parentNode.childNodes[1].childNodes[0].value;
		let debug = event.target.parentNode.parentNode.parentNode;
		console.log(debug);
		fetch('to-do.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'json/application'
            },
            body: new URLSearchParams({
                'todo_text': todoText
            })
        })
        .then(response => response.text())
        .then(data => {
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while updating the task.');
        });		
	} else if (event.target.type == "text") {
		let task = event.target.value;
		console.log(task);
	}
});

// Deleting task button
table.addEventListener("click", (event) => {
	let obj = new Object();
	obj.task = event.target.parentNode.parentNode.childNodes[1].childNodes[0].value;
	obj.completed = event.target.parentNode.parentNode.childNodes[5].childNodes[0].checked ? "1" : "0";
	let jsonString= JSON.stringify(obj);
	if (event.target.nodeName == "BUTTON") {
		fetch('to-do.php', {
            method: 'delete',
            body: jsonString,
        }).then(() => {
			window.location.reload();
		}).catch(error => {
            console.error('Error:', error);
        });     

	}
});

// Adding task button
addtask.addEventListener("change", (event) => {
	
	let formdata = new FormData();
	formdata.append("task", event.target.value);
	fetch('to-do.php', {
            method: 'post',
            body: formdata,
        }).then(() => {
			event.target.value = "";
            window.location.reload();
		}).catch(error => {
            console.error('Error:', error);
		});     
});


</script>
