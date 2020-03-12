<?php include 'components/head.php'; ?>

<?php include 'redirect.php'; ?>

<?php include 'components/navbar.php'; ?>

<body>
  <main>
	  	<h2 class="brand-logo center black-text" style="font-size: 40px; font-weight: bolder;">Página inicial</h2>
	  <div class="container center">
	  	<h5>Bancos de dados no sistema:</h5>
		</div>
		<br>
	  <div class="container">
	  	<ul class="collection">
	  		<?php $query = mysqli_query($dbconn, "SHOW DATABASES");?>
	  		<?php while($result = mysqli_fetch_array($query)) {?>
		    <a href="database.php?db=<?php echo $result['Database'];?>" class="collection-item"><?php echo $result['Database'];?></a>
		    <?php } ?>
		  </ul>
	  </div>
  </main>
</body>
</html>

<?php include 'components/js.php'; ?>