<?php include 'components/head.php'; ?>

<?php include 'redirect.php'; ?>

<?php include 'components/navbar.php'; ?>

<?php

	$query;

	if(!isset($_GET['db'])) {
		header("Location: index.php");
	}

	$db = $_GET['db'];

	$getdbs = mysqli_query($dbconn, "SHOW DATABASES");

	$exists = false;

	while ($result_dbs = mysqli_fetch_array($getdbs)) {
		if ($result_dbs['Database'] == $db) {
			$exists = true;
		}
	}

	if (!$exists) {
		header("Location: index.php");
	}

?>

<!-- For run a query using JS -->
<form id="form_query" action="database.php?db=<?php echo($db); ?>" method="post" style="display: none;">
	<input type="hidden" id="query" name="query" value="">
</form>

<?php

	if (isset($_GET['drop'])) {
		$drop_table = $_GET['drop'];
		?>
		<script type="text/javascript">
			var drop = confirm("Você quer excluir a tabela '<?php echo $drop_table; ?>'?");
			if (drop == true) {
				document.forms["form_query"].query.value = "DROP TABLE <?php echo $drop_table; ?>";
    		document.forms["form_query"].submit();
			}
		</script>
		<?php
	}

?>

<body>
  <main>
  	<br>
  	<div class="container" style="border: 1px solid white;">
	  	<div class="row">
		    <div class="col s12">
		      <ul class="tabs tabs-fixed-width">
		        <li class="tab col s3"><a class="active" href="#cmd">Linha de Comando</a></li>
		        <li class="tab col s3"><a href="#tables">Tabelas</a></li>
		        <li class="tab col s3"><a href="#create-table">Nova tabela</a></li>
		        <li class="tab col s3"><a href="#export">Exportar</a></li>
		      </ul>
		    </div>
	    </div>
    </div>
	  <div id="cmd" class="col s12">
		  <h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Linha de comando</h2>
		  <br>
		  <div class="container">
			  <div class="row">
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="query" value="SHOW TABLES">
							<button class="btn-flat waves-effect waves-light center tooltipped" data-tooltip="SHOW TABLES" type="submit" name="action" data-position="top">SHOW TABLES</button>
				  	</form>
			  	</div>
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="query" value="SHOW DATABASES">
							<button class="btn-flat waves-effect waves-light center tooltipped" data-tooltip="SHOW DATABASES" type="submit" name="action" data-position="top">SHOW DATABASES</button>
				  	</form>
			  	</div>
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="select">
							<button class="btn-flat modal-trigger waves-effect waves-light center tooltipped" data-tooltip="SELECT" href="#modal1" type="submit" name="action" data-position="top">SELECT</button>
				  	</form>
			  	</div>
			  </div>
			  <div class="row">
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="cmd" value="UPDATE tabela SET campo WHERE condicao">
							<button class="btn-flat waves-effect waves-light center tooltipped" data-tooltip="UPDATE tabela SET campo WHERE condicao" type="submit" name="action">UPDATE</button>
				  	</form>
			  	</div>
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="cmd" value="DELETE FROM tabela WHERE condicao">
							<button class="btn-flat waves-effect waves-light center tooltipped" data-tooltip="DELETE FROM tabela WHERE condicao" type="submit" name="action">DELETE</button>
				  	</form>
			  	</div>
			  	<div class="col s4 center">
				  	<form method="post">
				  		<input type="hidden" name="cmd" value="ALTER TABLE tabela">
							<button class="btn-flat waves-effect waves-light center tooltipped" data-tooltip="ALTER TABLE tabela" type="submit" name="action">ALTER TABLE</button>
				  	</form>
			  	</div>
			  </div>
		  </div>

		  <br>

		  <!-- Modal Structure -->
		  <div id="modal1" class="modal">
		    <div class="modal-content">
		      <h4>Selecione a tabela</h4>
		      <br>
	        <div class="input-field col s12">
	        	<form method="get">
	        		<input type="hidden" name="select">
	        		<input type="hidden" name="db" value="<?php echo($_GET['db']);?>">
					    <select name="table" required="">
					      <option value="" disabled selected>Escolha a tabela</option>
					      <?php
					      	mysqli_select_db($dbconn, $db);
			            $query = mysqli_query($dbconn, "SHOW TABLES");

						  		while($result = mysqli_fetch_array($query)) { ?>
					      		<option value="<?php echo $result['Tables_in_' . $db];?>"><?php echo $result['Tables_in_' . $db];?></option>
							    <?php
							  	}
					      ?>
					    </select>
					    <br><br>
					    <table>
					    	<tr style="border-bottom: 0">
					    		<td style="width: 10%">
						    		<div class="switch">
						    			<label>
									      <input id="checkbox" name="check_limit" value="true" type="checkbox">
									      <span class="lever"></span>
									    </label>
									  </div>
					    		</td>
					    		<td style="">
					          <div class="input-field inline">
					            <input id="limit" name="limit" min="1" value="1" type="number">
					            <label for="limit">Limite</label>
					          </div>
					    		</td>
					    	</tr>
				      </table>
			    		<p>
			    			Resultados muito extensos podem travar a página ou sobrecarregar o servidor.<br>
			    			Limite o resultado por página para garantir maior fluidez.
			    		</p>
					    <br><br>
					    <div class="modal-footer">
					      <button type="submit" class="modal-close waves-effect waves-green btn-flat">Executar</a>
					    </div>
					    <input type="hidden" name="page" value="1">
				    </form>
				  </div>
		    </div>
		  </div>

		  <div class="container">
	  		<div class="materialize-textarea z-depth-3" id="editor" name="query" style="resize: none; height: 150px;"><?php
	  			if (isset($_POST['cmd'])) {
	  				echo $_POST['cmd'];
	  			}
	  			elseif(isset($_POST['query'])) echo $_POST['query']; else echo "SHOW TABLES;"
	  		?></div>
		  	<br>
				<button onclick="exec()" class="btn waves-effect waves-light right tooltipped" data-tooltip="Executar os comandos inseridos" name="action">Executar</button>
		  </div>
		  <div class="container">
			  <br><br><br>
			  <h4>Resultado</h4>
			  <hr>
			  <?php
				  if(isset($_POST['query']) || isset($_GET['select']) || isset($_GET['query'])) {

				  	$string = array();

				  	$limit = false;

				  	if (isset($_POST['query'])) {
				  		$string = explode(';', $_POST['query']);
				  	} elseif (isset($_GET['table'])) {
				  		$string[0] = "SELECT * FROM " . $_GET['table'];
				  		if (isset($_GET['check_limit'])) {
				  			$string[0] = $string[0] . " LIMIT " . $_GET['limit'];
				  			$limit = true;
				  			if (isset($_GET['offset'])) {
				  				$string[0] = $string[0] . " OFFSET " . $_GET['offset'];
				  			}
				  		}
				  	}

				  	if (isset($_GET['query'])) {
				  		$string = explode(';', $_GET['query']);
				  	} elseif (isset($_GET['table'])) {
				  		$string[0] = "SELECT * FROM " . $_GET['table'];
				  		if (isset($_GET['check_limit'])) {
				  			$string[0] = $string[0] . " LIMIT " . $_GET['limit'];
				  			$limit = true;
				  			if (isset($_GET['offset'])) {
				  				$string[0] = $string[0] . " OFFSET " . $_GET['offset'];
				  			}
				  		}
				  	}

				  	if ($limit) {
				  		$count = mysqli_query($dbconn, "SELECT COUNT(*) as qtde FROM " . $_GET['table']);

				  		$count = mysqli_fetch_array($count)['qtde'];

				  		$max = $_GET['limit'];

				  		$qtd = $count / $max;

				  		?>
				  			<div class="container center">
			  				  <ul class="pagination">
			  				  	<?php if ($_GET['page'] == 1) { ?>
			  				  	<li class="blue-grey darken-4 active"><a href="#!">1</a></li>
			  				  	<?php } else { ?>
								    <li class="waves-effect"><a onclick="offset(0, <?php echo $max; ?>, <?php echo $count; ?>)">1</a></li>
								    <?php } ?>
								    <?php for ($i=1; $i < $qtd; $i++) { ?>
								    	<?php if ($_GET['page'] == $i + 1) { ?>
								    		<li class="blue-grey darken-4 active"><a href="#!"><?php echo $i + 1; ?></a></li>
								    	<?php } else { ?>
								    	<li class="waves-effect"><a onclick="offset(<?php echo $i; ?>, <?php echo $max; ?>, <?php echo $count; ?>)"><?php echo $i + 1; ?></a></li>
								    	<?php } ?>
								    <?php } ?>
								  </ul>
				  			</div>
				  		<?php
				  	}

				  	$i = 0;

				  	foreach ($string as $value) {
				  		if(strlen($value) > 0) {
					  		mysqli_select_db($dbconn, $db);
					  		$value = $value;

					  		if (strlen($value) > 1) {

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

						  			if(strpos((strtolower($current)), 'select') !== false || strpos((strtolower($current)), 'show') !== false || strpos((strtolower($current)), 'desc') !== false) {

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
									  						echo "<td class='cell'>";
									  						echo "<div class='cell' style='max-height: 200px;overflow: auto'>";
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
								  				echo "<h6 style='margin-left: 20px'>Nenhum resultado!</h6>";
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
				  }
			  ?>
		  </div>
  	</div>

    <div id="tables" class="col s12">
    	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Tabelas</h2>
    	<br>
	    	<div class="container">
	    		<div style='max-width: 100%;overflow: auto'>
		    		<table class='highlight' style="border-bottom: none">
			        <thead style="border-bottom: none">
			          <tr style="border-bottom: none">
		              <th>Nome da tabela</th>
		              <th>Campos</th>
			          </tr>
			        </thead>
			        <tbody style="border-bottom: none">
						    	<?php
						    		$query = mysqli_query($dbconn, "SHOW TABLES;");

						    		while ($result = mysqli_fetch_array($query)) {
						    			echo "<tr style='border-bottom: none'>";
						    			echo '<td style="border-bottom: none"><a href="database.php?db=' . $db . '&drop=' . $result[0] . '"><i class="material-icons prefix left red-text">delete</i></a><b><a href="#" id="tablename" onclick="table(\''.$result[0].'\')">'
						    			. $result[0] . '</a></b></td>';
						    			$query_fields = mysqli_query($dbconn, "DESC " . $result[0]);
						    			while ($table_fields = mysqli_fetch_array($query_fields)) {
						    				echo '<td>' . $table_fields[0] . '</td>';
						    			}
						    			echo "</tr>";
						    		}
						    	?>
			        </tbody>
			      </table>
		    	</div>
	    	</div>
	    </div>
	    <div id="create-table" class="col s12">
	    	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Nova tabela</h2>
    		<br>
    		<div class="container">
    			<?php if (!isset($_POST['table-name'])) {?>

    			<form method="post" action="#create-table">
	    			<div class="row center">
			        <div class="col s6">
			          <div class="input-field">
			            <input required="" name="table-name" id="table-name" type="text">
			            <label for="table-name">Nome da tabela</label>
			          </div>
			        </div>
			        <div class="col s4">
			          <div class="input-field">
			            <input required="" name="table-cols" id="table-cols" type="text">
			            <label for="table-cols">Número de colunas</label>
			          </div>
			        </div>
			        <div class="col s2">
			          <div class="input-field">
			            <button type="submit" class="btn">Avançar</button>
			          </div>
			        </div>
			      </div>
		      </form>

		    	<?php } else {

		    		$name = $_POST['table-name'];
		    		$cols = $_POST['table-cols'];

		    	?>

		    	<h5>Tabela "<?php echo $name; ?>"</h5>

		    	<form method="post">
	    			<div class="row">
	    				<?php for ($i=0; $i < $cols; $i++) { ?>
	    					<input type="hidden" name="name" value="<?php echo $_POST['table-name'];?>">
				        <div class="col s3">
				          <div class="input-field">
				            <input required="" name="col<?php echo($i);?>-name" id="col<?php echo($i);?>-name" type="text">
				            <label for="col<?php echo($i);?>-name">Nome do campo</label>
				          </div>
				        </div>
			          <div class="input-field col s3">
							    <select required="" name="col<?php echo($i);?>-type">
							    	<option value="" disabled selected>Tipo</option>
							    	<option value="int">INT</option>
							    	<option value="varchar">VARCHAR</option>
							    	<option value="text">TEXT</option>
							    	<option value="date">DATE</option>
							    	<optgroup label="Numérico">
							    		<option value="tinyint">TINYINT</option>
							    		<option value="smallint">SMALLINT</option>
							    		<option value="mediumnint">MEDIUMINT</option>
							    		<option value="int">INT</option>
							    		<option value="bigint">BIGINT</option>
							    		<option value="decimal">DECIMAL</option>
							    		<option value="float">FLOAT</option>
							    		<option value="double">DOUBLE</option>
							    		<option value="real">REAL</option>
							    		<option value="bit">BIT</option>
							    		<option value="boolean">BOOLEAN</option>
							    		<option value="serial">SERIAL</option>
							    	</optgroup>
							    	<optgroup label="Data e hora">
							    		<option value="date">DATE</option>
							    		<option value="datetime">DATETIME</option>
							    		<option value="timestamp">TIMESTAMP</option>
							    		<option value="time">TIME</option>
							    		<option value="year">YEAR</option>
							    	</optgroup>
							    	<optgroup label="Segmento">
							    		<option value="char">CHAR</option>
							    		<option value="varchar">VARCHAR</option>
							    		<option value="tinytext">TINYTEXT</option>
							    		<option value="text">TEXT</option>
							    		<option value="mediumtext">MEDIUMTEXT</option>
							    		<option value="longtext">LONGTEXT</option>
							    		<option value="binary">BINARY</option>
							    		<option value="varbinary">VARBINARY</option>
							    		<option value="tinyblob">TINYBLOB</option>
							    		<option value="blob">BLOB</option>
							    		<option value="mediumblob">MEDIUMBLOB</option>
							    		<option value="longblob">LONGBLOB</option>
							    		<option value="enum">ENUM</option>
							    		<option value="set">SET</option>
							    	</optgroup>
							    </select>
							  </div>
				        <div class="col s2">
				          <div class="input-field">
				            <input name="col<?php echo($i);?>-size" id="col<?php echo($i);?>-size" type="text">
				            <label for="col<?php echo($i);?>-size">Tamanho</label>
				          </div>
				        </div>
			          <div class="input-field col s3">
							    <select name="col<?php echo($i);?>-extra">
							      <option value="" selected disabled="">Extras</option>
							      <option value="NOT NULL AUTO_INCREMENT">AUTO INCREMENT</option>
							      <option value="UNIQUE">UNIQUE</option>
							      <option value="NOT NULL">NOT NULL</option>
							      <option value="NULL">PREDEFINIDO COMO NULL</option>
							    </select>
							  </div>
							  <div class="input-field col s1">
						      <label>
						        <input type="checkbox" value="PRIMARY KEY" name="col<?php echo($i);?>-pk">
						        <span><i class="material-icons">vpn_key</i></span>
						      </label>
							  </div>
	    				<?php } ?>
			      </div>
			      <button class="btn right" type="submit">Confirmar</button>
		      </form>
		      <button class="btn left red"><a class="white-text" href="database.php?db=<?php echo($db);?>">Cancelar</a></button>
		    	<?php } ?>
    		</div>
    		<br><br><br>
    		<?php

				if (isset($_POST['name'])) {

					$error_pk = false;
					$error_ai = false;

					$string = "CREATE TABLE " . $_POST['name'] . " (";

					$array = $_POST;

					$table_name = "null";

					$i=0;
					$j=0;

					$keys = array_keys($array);

					$have_pk = false;

					$type = "int";

					$pk = 0;

					foreach ($keys as $key => $value) {
						if ($j !== 0) {
							$col = explode("col", $value);
							$col = explode('-', $col[1]);
							// $col[0] = NUMERO DA COLUNA
							// $col[1] = TIPO DA VARIAVEL
							if ($i == $col[0]) {
								if ($col[1] == "pk") {
									if ($have_pk) {
										$error_pk = true;
									} else {
										$have_pk = true;
										$pk = $i;
									}
								}
							} else {
								$i++;
							}
						} else {
							$table_name = $array[$value];
							$j++;
						}
					}

					$num_colunas = $i;

					$i = 0;
					$j = 0;

					foreach ($keys as $key => $value) {
						if ($j !== 0) {
							$col = explode("col", $value);
							$col = explode('-', $col[1]);
							// $col[0] = NUMERO DA COLUNA
							// $col[1] = TIPO DA VARIAVEL
							if ($i == $col[0]) {

								if ($col[1] == "type") {
									$type = $array[$value];
								}

								if ($col[1] == "extra" && $array[$value] == "NOT NULL AUTO_INCREMENT" && !($type == "int")) {
									$error_ai = true;
								}

								if ($col[1] == "extra" && !($pk == $col[0]) && $array[$value] == "NOT NULL AUTO_INCREMENT"){
									$error_ai = true;
								}	elseif ($col[1] == "name" && $col[0] == 0) {
									$string = $string . $array[$value];
								}	elseif ($col[1] == "name") {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "type") {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "size" && !($array[$value] == "")) {
									$string = $string . "(" . $array[$value] . ")";
								} elseif ($col[1] == "extra" && !$have_pk && $col[0] !== $num_colunas) {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "extra" && $have_pk && $pk == $col[0]) {
									$string = $string . " " . $array[$value] . "";
								} elseif ($col[1] == "extra" && !$have_pk && $col[0] == $num_colunas) {
									$string = $string . " " . $array[$value];
								}	elseif ($col[1] == "extra" && $have_pk && $col[0] > $pk && $col[0] == $num_colunas) {
									$string = $string . " " . $array[$value];
								}	elseif ($col[1] == "extra" && $have_pk && $col[0] > $pk) {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "extra" && $have_pk && !($pk == $col[0]) && !($col[0] == $num_colunas)) {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "pk" && $col[0] !== $num_colunas) {
									$string = $string . " " . $array[$value];
								} elseif ($col[1] == "pk" && $col[0] == $num_colunas) {
									$string = $string . $array[$value];
								}
							} else {
								$i++;
								if ($col[1] == "name") {
									$string = $string . ", " . $array[$value] . " ";
								}
							}
						} else {
							$table_name = $array[$value];
							$j++;
						}
					}

					$string = $string . ");";

					if ($error_ai) {
						echo "<div class='container center red white-text'><br>";
						echo "ERRO: AUTO_INCREMENT SÓ PODE SER IMPLEMENTADO SE O CAMPO FOR INT E PRIMARY KEY!";
						echo "<br><br></div>";
					} elseif ($error_pk) {
						echo "<div class='container center red white-text'><br>";
						echo "ERRO: PRIMARY KEY SÓ PODE SER IMPLEMENTADO EM UM CAMPO!";
						echo "<br><br></div>";
					} else {
						$query = $string;
						?>
						<form id="form_table" action="database.php?db=<?php echo($db);?>" method="post" style="display: none;">
							<input type="hidden" id="query_table" name="query" value="">
						</form>
						<script type="text/javascript">
							function query(string) {
								document.forms["form_table"].query_table.value = string;
						    document.forms["form_table"].submit();
							}
							query("<?php echo $query;?>");
						</script>
						<?php
					}

				}

			?>
	    </div>
	    <div id="export" class="col s12">
	    	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Exportar</h2>
    		<br>
    		<div class="container">
    			<h6>Essa página faz com que você baixe um arquivo .sql do dump da sua base de dados.</h6>
    			<h5>Prosseguir?</h5>
    			<br><br><br>
    			<div class="container center">
    				<button class="btn btn-large"><a class="white-text" href="dump.php?db=<?php echo($db);?>"><i class="material-icons left">file_download
							</i>Fazer download</a></button>
					</div>
    		</div>
    		<?php
    		?>
	    </div>
	  </div>
  </main>
</body>
</html>

<form method="get" id="form_offset" action="#" style="display: none">
	<input type="hidden" id="select" name="select" value="1">
	<input type="hidden" id="db" name="db" value="<?php echo($db)?>">
	<input type="hidden" id="table" name="table" value="<?php echo($_GET['table']);?>">
	<input type="hidden" id="limit" name="limit" value="<?php echo($_GET['limit']);?>">
	<input type="hidden" id="check_limit" name="check_limit" value="<?php echo($_GET['check_limit']);?>">
	<input type="hidden" id="offset" name="offset" value="1">
	<input type="hidden" name="page" id="page">
</form>

<?php include 'components/js.php'; ?>

<script type="text/javascript">
	$('#editor').keydown(function (e) {
	  if (e.ctrlKey && e.keyCode == 13) {
	    exec();
	  }
	});
	function exec(e) {
		document.forms["form_query"].query.value = editor.getValue();
    document.forms["form_query"].submit();
	}
	function table(table) {
		document.forms["form_query"].query.value = "DESC " + table;
    document.forms["form_query"].submit();
	}
	function offset(qtd, limit, total, pag) {

		var calc = limit * qtd;

		document.forms["form_offset"].page.value = qtd + 1;
		document.forms["form_offset"].offset.value = calc;
    document.forms["form_offset"].submit();
	}
	// ?select=&db=ptquest&table=questao&check_limit=true&limit=50#!
</script>
