<?php

if (!isset($_REQUEST['id']))
{
	die("No ID");
}
else 
{
	require_once('dbconfig.php');
	$query = 'SELECT bld_sicon FROM arov_buildings WHERE bld_id = ' . intval($_REQUEST['id']);
	$result = mysql_query($query);

	if(!$result) 
	{
		die("Query $query failed. " . mysql_error());
 	}
 	if(mysql_num_rows($result) == 0) 
	{
 		die("No records found.");
 	}
 	$line = mysql_fetch_assoc($result);
 	if (!$line) 
	{
 		die("Couldn't retrieve row");
 	}

	header('Content-type: image/png');
 	header('Content-Disposition: inline;');
 	echo $line['bld_sicon'];
}
?>