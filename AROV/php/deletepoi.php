<?php
require 'dbconfig.php';
session_start();

//Delete Query
$deleteqry = 'DELETE FROM arov_people_of_interest
	WHERE poi_id = "' . $_GET['id'] . '"';

echo $deleteqry;

mysql_query($deleteqry);

header("Location: ../site/poi.php");
exit();