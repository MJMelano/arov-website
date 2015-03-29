<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require 'dbconfig.php';

$data = json_decode($_POST['json'], true);

$start = $data["path"][0]["from"];
$end = $data["path"][1]["to"];
$weight = $data["path"][2]["weight"];

echo "From: ".$start." To: ".$end." Weight: ".$weight."\n";
echo "Longitude: ".$data["coordinates"][0]["k"]." Latitude ".$data["coordinates"][0]["A"];
echo "\n";

$query = "INSERT INTO paths (start, end, weight) VALUES ('".$start."','".$end."','".$weight."')";

mysql_query($query,$dblink) or die("Query failed: $query " . mysql_error());

$query_id = "SELECT id FROM paths WHERE start = '" . $start . "' AND end = '" . $end . "'";

$get_id = mysql_query($query_id,$dblink) or die("Query failed: $query " . mysql_error());

$path_id = mysql_fetch_assoc($get_id);
$id = $path_id['id'];

$points =sizeof($data["coordinates"]);
echo  "size of coordinates array: ". $points;
for($i=0;$i<$points;$i++)
{

	$add_coordinates_query = "INSERT INTO coordinates (id, latitude, longitude) VALUES ('".$id."','".$data["coordinates"][$i]["k"]."','".$data["coordinates"][$i]["A"]."')";

	mysql_query($add_coordinates_query,$dblink) or die("Query failed: $query " . mysql_error());	
}

?>
