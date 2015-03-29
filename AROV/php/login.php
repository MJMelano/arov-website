<?php
require 'dbconfig.php';
if(isset($_POST['submit']) && $_POST['submit'] == 'Login')
{
	if(!$_POST['user'] | !$_POST['pass'])
	{
			echo 'Please complete both fields.';
	}
		
	//Retrieve Verification Information
	$user = mysql_real_escape_string($_POST['user']);
	$pass = sha1(mysql_real_escape_string($_POST['pass']));
	
	//Retrieve MySQL Search Query
	$sql = mysql_query("SELECT * FROM arov_admins
		WHERE adm_user_name='" . $user . "' AND 
		adm_password='" . $pass . "' LIMIT 1");
	
	//Query Successfull
	if(mysql_num_rows($sql) == 1)
	{
		$row = mysql_fetch_array($sql);
		//Session Variables Set
		session_start();
		$_SESSION['fname'] = $row['adm_first_name'];
		$_SESSION['mname'] = $row['adm_middle_initial'];
		$_SESSION['lname'] = $row['adm_last_name'];
		$_SESSION['phone'] = $row['adm_phone'];
		$_SESSION['email'] = $row['adm_email'];
		$_SESSION['logged'] = TRUE;
		//Redirect to Profile
		header("Location: site/profile.php");
		exit;	
	}
	//Query Unseccessfull
	else
	{
		//Redirect to Login
		header("Location: http://www.google.com");
		exit;
	}
}
else
{
	//Redirect to Login
	header("Location: http://www.csumb.edu");
	exit;	
}