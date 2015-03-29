<?php

//Database Variables
$dbHostname = 'localhost';
$dbUsername = 'arovmbco_mmelano';
$dbPassword = 'MMel1991';
$dbDatabase = 'arovmbco_arov';

//Database Connection
$dbLink = mysql_connect($dbHostname, $dbUsername, $dbPassword)
	or die("Could not connect to database at $dbHostname: " . mysql_errno() . ": " . mysql_error());

//Database Selection
mysql_select_db($dbDatabase, $dbLink)
	or die("Coudl not connect to database $dbDatabase: " . mysql_errno() . ": " . mysql_error());
