<?php

session_start();
if ($_SESSION["userlogin"] == NULL) { exit(); }
$user = $_SESSION["userlogin"];

// Create new task 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$conn = new mysqli("localhost", "notroot", "password", "users");
	if ($conn->connect_error) {
		die($conn->error);
	}
	$task = $_POST["task"];
	$query = "INSERT into tasks(user, task, completed) VALUES ('$user', '$task', '0')";
	$conn->query($query) or die($conn->error);
	$conn->close();
}

// Delete task
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
	$conn = new mysqli("localhost", "notroot", "password", "users");
	if ($conn->connect_error) {
		die($conn->error);
	}
	$data = json_decode(file_get_contents("php://input"), true);
	
	$task = $data["task"];
	$completed = $data["completed"];
	$query = "DELETE from tasks WHERE user='$user' AND task='$task' AND completed='$completed' LIMIT 1";
	$conn->query($query) or die($conn->error);
	echo $conn->affected_rows;
	echo $user;
	echo $task;
	$conn->close();
}

// Update task
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
	$conn = new mysqli("localhost", "notroot", "password", "users");
	if ($conn->connect_error) {
		die($conn->error);
	}
	
	$decoded_data = json_decode(file_get_contents("php://input"), true);
	$post_vars = var_dump($decoded_data);
		
	$old_task = $decoded_data["old_task"];
	$new_task = $decoded_data["new_task"];
	$completion = $decoded_data["completion"];
	$user = $decoded_data["user"];
	$query = "update tasks set task='$new_task', completed='$completion' where user='$user' and task='$old_task' LIMIT 1";
	$conn->query($query) or die($conn->error);
	echo $conn->affected_rows;
	$conn->close();

}




