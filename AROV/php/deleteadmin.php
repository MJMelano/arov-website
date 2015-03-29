<?php
require 'dbconfig.php';
session_start();

//Delete Query
$deleteqry = 'DELETE FROM arov_admins
	WHERE adm_id = "' . $_GET['id'] . '"';

echo $deleteqry;

mysql_query($deleteqry);

header("Location: ../site/admins.php");
exit();