<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require 'dbconfig.php';

$data = json_decode($_POST['json'], true);

$query = "DELETE FROM paths WHERE id = ".$data['id'];

mysql_query($query,$dblink) or die("Query failed: $query " . mysql_error());

$resp = array("id" => $data['id']);
echo json_encode($resp);

?>
