<?php

	include 'sql.php';

	$db = $_GET['db'];

	include 'Mysqldump/Mysqldump.php';
  $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname=' . $db, $user, $password);
  
  $dump->start('output/ezadmin-' . $db . '-dump.sql');

  $file = 'output/ezadmin-' . $db . '-dump.sql';

	if (file_exists($file)) {
	  header('Content-Description: File Transfer');
	  header('Content-Type: application/octet-stream');
	  header('Content-Disposition: attachment; filename="'.basename($file).'"');
	  header('Expires: 0');
	  header('Cache-Control: must-revalidate');
	  header('Pragma: public');
	  header('Content-Length: ' . filesize($file));
	  readfile($file);
	  exit;
	}

	header('Location: database.php?db=' . $db);

?>