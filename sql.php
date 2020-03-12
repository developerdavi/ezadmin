<?php

  session_start();

  $host       = "localhost";
  $user       = $_SESSION['user'];
  $password   = $_SESSION['password'];

  $dbconn   = mysqli_connect($host, $user, $password);
  
?>