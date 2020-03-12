<?php include 'components/head.php'; ?>

<?php include 'redirect.php'; ?>

<?php include 'components/navbar.php'; ?>

<body>
  <main>
	  	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Linha de comando</h2>
	  <br>
	  <div class="container">
			<div class="materialize-textarea z-depth-3" id="editor" name="query" style="resize: none; height: 150px;"><?php if(isset($_POST['query'])) echo $_POST['query']; else echo "SHOW DATABASES;"?></div>
	  	<br>
			<button onclick="exec()" class="btn waves-effect waves-light right tooltipped" data-tooltip="Executar os comandos inseridos" name="action">Executar</button>
	  </div>
	  <div class="container">
		  <br><br><br>
		  <h4>Resultado</h4>
		  <hr>
		  <?php
			  if(isset($_POST['query']) || isset($_GET['select'])) {

			  	$string = array();

			  	if (isset($_POST['query'])) {
			  		$string = explode(';', $_POST['query']);
			  	} else {
			  		$string[0] = "SELECT * FROM " . $_GET['table'];
			  	}

			  	$i = 0;

			  	foreach ($string as $value) {
			  		if(strlen($value) > 1) {
				  		// mysqli_select_db($dbconn, $db);
				  		$value = $value;
				  		$query = mysqli_query($dbconn, $value);
				  		if ($query) {
				  			?>
				  			<div class='container-fluid blue-grey darken-4 z-depth-4 white-text'>
					  			<div class='container-fluid white-text green center'>
						  			<br>
						  			<h6>
				  					<?php echo $value; ?>
						  			</h6>
						  			<br>
						  		</div>
				  				<br>
				  				<?php echo "<h6 style='margin-left: 20px'>Query ok!</h6>"; ?>
				  				<br>

				  			<?php

				  			//$query = mysqli_query($dbconn, $value);

				  			$current = $value;

				  			if(strpos((strtolower($current)), 'use') !== false) {
				  				$array = explode("use ", strtolower($current));
				  				mysqli_select_db($dbconn, $array[1]);
				  			} elseif(strpos((strtolower($current)), 'select') !== false || strpos((strtolower($current)), 'show') !== false || strpos((strtolower($current)), 'desc') !== false) {

					  				$result = mysqli_fetch_array($query);

					  				echo "<div class='container-fluid' style='overflow: auto'>";
					  				echo "<table class='centered'>";
					  				echo "<thead>";
					  				echo "<tr>";

					  				$res = mysqli_fetch_array($query);

					  				if (is_array($result) || isset($result[0])) {

					  					$array = array_keys($result);

						  				$fields = array();

						  				foreach ($array as $key => $X) {
						  					if (gettype($array[$key]) != "integer") {
							  					echo "<th class='center'>";
							  					echo $array[$key];
							  					array_push($fields, $array[$key]);
							  					echo "</th>";
						  					}
						  				}

						  				echo "</tr>";
						  				echo "</thead>";

						  				echo "<tbody>";

						  					$query = mysqli_query($dbconn, $string[$i]);

							  				while ($res = mysqli_fetch_array($query)) {
						  						echo "<tr>";

							  					foreach ($fields as $key => $X) {
							  						echo "<td>";
							  						echo "<div style='max-height: 200px;overflow: auto'>";
							  						if (strlen($res[$X]) > 0) {
							  							echo $res[$X];
							  						} else {
							  							echo "NULL (vazio)";
							  						}

							  						echo "</div>";
							  						echo "</td>";
							  					}

						  						echo "</tr>";
							  				}

						  				echo "</tbody>";
						  				echo "</table>";
						  				echo "</div>";
						  			} else {
						  				echo "<h6 style='margin-left: 20px'>Nenhum resultado! (ou apenas uma tabela, consulte no 'SELECT')</h6>";
						  				echo "<br>";
						  				echo "</tr>";
						  				echo "</thead>";
						  				echo "<tbody>";
						  				echo "</tbody>";
						  				echo "</table>";
						  				echo "</div>";
						  			}
			  					}

				  			?></div><br><br><?php
				  		} else {
				  			echo "<div class='container-fluid blue-grey darken-4 z-depth-4'>
				  			<div class='container-fluid white-text red center'>
				  			<br>
				  			<h6>
				  			"
				  			. $value .
				  			"
				  			</h6>
				  			<br>
				  			</div>
				  			<br>
				  			<h6 class='white-text' style='padding-left: 10px'>Erro:
				  			"
				  			. mysqli_error($dbconn) .
				  			"</h6>
				  			<br>
				  			</div>
				  			<br><br>
				  			";
				  		}
			  		}
			  		$i = $i + 1;
			  	}
			  }
		  ?>
	  </div>
  </main>
</body>
</html>

<form id="form_query" action="#" method="post" style="display: none;">
	<input type="hidden" id="query" name="query" value="">
</form>

<?php include 'components/js.php'; ?>

<script type="text/javascript">
	$('#editor').keydown(function (e) {
	  if (e.ctrlKey && e.keyCode == 13) {
	    exec();
	  }
	});
	function exec() {
		document.forms["form_query"].query.value = editor.getValue();
    document.forms["form_query"].submit();
	}
</script>
