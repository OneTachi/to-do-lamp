<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();

	session_destroy();
	header('Location: index.php');
	exit();
} else {
	header('Location: index.php');
	exit();
}
