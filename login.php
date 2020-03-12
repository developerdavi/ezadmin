<?php

	if (isset($_POST['username'])) {
		$host = "localhost";
		$user = $_POST['username'];
		$password = $_POST['password'];

		$dbconn = mysqli_connect($host, $user, $password);

		if ($dbconn) {
			session_start();
			$_SESSION['user'] = $user;
			$_SESSION['password'] = $password;
			header("Location: index.php");
		} else {
			echo '<script> alert("Dados incorretos!"); </script>';
			session_destroy();
			header("Location: login.php");
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ez SQL Admin</title>
	<link rel="stylesheet" type="text/css" href="css/materialize.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style type="text/css">
  .input-field > label {
	    color: black;
	    position: absolute;
	    top: 0;
	    left: 0;
	    font-size: 1rem;
	    cursor: text;
	    -webkit-transition: color .2s ease-out, -webkit-transform .2s ease-out;
	    transition: color .2s ease-out, -webkit-transform .2s ease-out;
	    transition: transform .2s ease-out, color .2s ease-out;
	    transition: transform .2s ease-out, color .2s ease-out, -webkit-transform .2s ease-out;
	    -webkit-transform-origin: 0% 100%;
	    transform-origin: 0% 100%;
	    text-align: initial;
	    -webkit-transform: translateY(12px);
	    transform: translateY(12px);
	}
	input {
		color: black;
	}
	.full {
		height: 100vh;
	}
	#login-div {
		max-width: 600px;
	}
	#dev-davi {
		position: absolute;
		bottom: 20px;
		right: 20px;
		opacity: 0.4;
	}
  </style>
</head>
<body class="full blue-grey darken-4">

  <main class="full blue-grey darken-4">
	  <div class="container center">
	  	<br>
	  	<!--<img src="img/logo.png" class="center" style="height: 100px;">-->
	  	<h2 class="white-text bold">EzAdmin</h2>
	  </div>
	  <br>
	  <div class="container grey lighten-5 z-depth-4" id="login-div">
	  	<br><br><br><br>
	  	<form method="post">
	  		<div class="row">
					<input type="hidden" name="login">
					<div class="input-field col s6 center offset-s3">
						<input value="" name="username" id="username" type="text" required="">
						<label class="active" for="username">Usuário</label>
					</div>
					<br><br><br><br>
					<div class="input-field col s6 center offset-s3">
						<input value="" name="password" id="password" type="password">
						<label class="active" for="password">Senha</label>
						<br><br>
						<button class="btn black waves-effect waves-light right" type="submit" name="action">Login</button>
					</div>
				</div>
			</form>
			<br><br>
		</div>
		<div class="container center">
			<img id="dev-davi" src="img/devdavi.png" class="devdavi-logo">		
		</div>
  </main>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/materialize.js" type="text/javascript"></script>
	<script type="text/javascript">
		  $(document).ready(function(){
			  M.updateTextFields();
			});
	</script>
</body>
</html>