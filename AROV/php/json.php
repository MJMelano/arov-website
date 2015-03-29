<?php

function updateJSON()
{
	$file = "../php/csumb.json";
	
	require_once('dbconfig.php');
	$query = "SELECT * FROM arov_buildings";
	$result = mysql_query($query);
	$url = 'http://arovmb.com/images/';
	
	$json["csumb"] = array();
	
	while($line = mysql_fetch_assoc($result))
	{
		array_push($json["csumb"], 
			array("name" => $line['bld_name'],
				"number" => $line['bld_num'], 
				"geometry" => array(
					"location" => array(
						"lng" => $line['bld_longitude'], 
						"lat" => $line['bld_latitude'])
					), 
				"icon" => $url . $line['bld_num'] . ".png",
				"description" => $line['bld_description'],
				"category" => $line['bld_category']
				)
			);
	}
	
	file_put_contents($file, json_encode($json, JSON_UNESCAPED_SLASHES));
}

function updateEventsJSON()
{
		$file = "../php/events.json";
	
	require_once('dbconfig.php');
	$query = "SELECT * FROM arov_events";
	$result = mysql_query($query);
	$url = 'http://arovmb.com/images/events.png';
	
	$json["events"] = array();
	
	while($line = mysql_fetch_assoc($result))
	{
		array_push($json["events"], 
			array("name" => $line['evt_name'],
				"geometry" => array(
					"location" => array(
						"lng" => $line['evt_longitude'], 
						"lat" => $line['evt_latitude'])
					), 
				"icon" => $url,
				"description" => $line['evt_summary'],
				"date" => $line['evt_date']
				)
			);
	}
	
	file_put_contents($file, json_encode($json, JSON_UNESCAPED_SLASHES));
}


?>