<?php
$ctime = 300;
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] = TRUE)
{
	setcookie(session_name(),session_id(),time()+$ctime);
}
else
{
	header("Location: ../index.php");	
}
require '../php/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AROV Content Management</title>
	<link href="../css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<!-- Wrapper -->
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td> 
            	<div id="wrapper">   
                    <!-- Banner Starts -->
                    <div id="banner">
                        <div class="container">
                            <h1>AROV - Tutorials</h1>
                        </div>
                    </div>
                    
                    <!-- Nav Starts -->
                    <div id="nav">
                        <div class="container">
                            <ul>
                                <li><a href="campus.php">Campus</a></li>
                                <li><a href="events.php">Events</a></li>
                                <li><a href="directions/directions.html">Directions</a></li>
                                <li><a href="admins.php">Admins</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="#" class="current">Tutorials</a></li>
                                <li><a href="../php/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Main Starts -->
                    <div id="main">
                        <div class="container">
                                    
                        </div>
                    </div>
                </div>
            </td>
    	</tr>
    </table>
    
    <!-- Footer Starts -->
    <div id="footer">
    	<div class="container">
        	<p>Copyright &copy; 2013 - <?php echo date("Y"); ?> Moises Melano, Joshua Frea, &amp; Juan Hernandez</p>
        </div>
    </div>

</body>
</html>