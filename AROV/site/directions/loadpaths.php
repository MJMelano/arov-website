<?php

require 'dbconfig.php';

$path_query = "SELECT id, start, end, weight FROM paths";

$results = mysql_query($path_query,$dblink) or die("Query failed: $query " . mysql_error());

$paths_array = array();

$i=0;
while ($row = mysql_fetch_assoc($results)) {
	
	$paths_array[$i]['id'] = $row['id'];
	$paths_array[$i]['start'] = $row['start'];
	$paths_array[$i]['end'] = $row['end'];
	$paths_array[$i]['weight'] = $row['weight'];

	$coordinates_query = "SELECT latitude, longitude FROM coordinates WHERE id = '" . $paths_array[$i]['id'] . "'";

	$coordinates = mysql_query($coordinates_query,$dblink) or die("Query failed: $query " . mysql_error());

	$a=0;
	$coordinates_array = array();
	while ($latlong = mysql_fetch_assoc($coordinates) ) {

		$coordinates_array[$a] = array("lat" => $latlong['latitude'], "long" => $latlong['longitude']);
		$a++; 
		//print_r($coordinates_array);
	}

	$paths_array[$i]['path'] = $coordinates_array;

	$i++;
}

$jsonData = json_encode($paths_array);

//$fp = fopen('paths.json', 'w');
//fwrite($fp, $jsonData);
//fclose($fp);

echo $jsonData;



?>