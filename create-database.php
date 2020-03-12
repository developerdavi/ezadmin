<?php include 'components/head.php'; ?>

<?php include 'redirect.php'; ?>

<?php include 'components/navbar.php'; ?>

<body>
  <main>
	  	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Criar banco de dados</h2>
	  <br><br><br>
	  <br><br><br>
	  <div class="container">
			<form method="post">
				<div class="row">
					<div class="col s4 offset-s4">
						<div class="row">
							<div class="col s10 input-field inline">
			          <input id="db" name="db" type="text" class="validate">
			          <label for="db">Nome do banco de dados</label>
							</div>	
							<div class="col s2">
								<br>
	        			<button class="btn" type="submit">Criar</button>
							</div>
						</div>
	        </div>
        </div>
			</form>
	  </div>
  </main>
</body>
</html>

<?php

	if (isset($_POST['db'])) {
		$query = "CREATE DATABASE " . $_POST['db'];
 
		$query = mysqli_query($dbconn, $query);

		if (!$query) { ?>
			<script type="text/javascript">
				alert("Erro: <?php echo mysqli_error($dbconn); ?>");
			</script>
		<?php } else { ?>
			<script type="text/javascript">
				alert("Banco de dados criado com sucesso, redirecionando à página do novo banco.");
				window.location.href = "database.php?db=<?php echo $_POST['db']; ?>";
			</script>
		<?php }
	}

?>

<?php include 'components/js.php'; ?>