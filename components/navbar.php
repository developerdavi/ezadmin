<header>
  <div class="navbar">
    <nav>
      <div class="nav-wrapper blue-grey darken-4 ">
  			<a href="#" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a>
        <a href="index.php" class="brand-logo center">EzAdmin</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li style="margin-right: 20px;">Usuário: <?php echo $user;?></li>
	        <li><a href="logout.php">Sair</a></li>
	      </ul>
      </div>
    </nav>
  </div>
</header>

<ul id="slide-out" class="sidenav">
  <li><a href="index.php">Página inicial</a></li>
  <li><a href="command-line.php">Linha de comando</a></li>
  <li><a href="create-database.php">Novo banco de dados</a></li>
  <li class="no-padding">
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header">Bancos de dados<i class="material-icons">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
            <?php $query = mysqli_query($dbconn, "SHOW DATABASES");?>
			  		<?php while($result = mysqli_fetch_array($query)) {?>
				    	<li class="collection-item"><a href="database.php?db=<?php echo $result['Database'];?>"><?php echo $result['Database'];?></a></li>
				    <?php }?>
          </ul>
        </div>
      </li>
    </ul>
  </li>
  <hr>
  <li><a href="tips.php">Dicas</a></li>
  <li><a href="about.php">Sobre</a></li>
  <li><a href="logout.php">Sair</a></li>
</ul>
