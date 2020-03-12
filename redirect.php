<?php

  session_start();

  $host;
  $user;
  $password;
  $dbconn;

  if (isset($_SESSION['user'])) {

	  $host       = "localhost";
	  $user       = $_SESSION['user'];
	  $password   = $_SESSION['password'];

	  $dbconn   = mysqli_connect($host, $user, $password);

	} else {
		header("Location: login.php");
	}

?>
