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
	<title>AROV Content Management System Splash</title>
	<link href="../css/splash.css" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="../js/splash.js"></script>
</head>

<body>
	<!-- Wrapper -->
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td>
            <div id="wrapper" class="center">
                <div class="container">
                	<div style="text-align: center; margin-bottom: 15px">
                    	<h1>Augmented Reality Otter Vision</h1>
                    	<h2>Content Management System</h2>
                    </div>
                    <div class="row">
                        <div class="image" style="margin-left: 125px">
                            <a href="campus.php"><img src="../images/splashicons_campus.png" alt="" /></a>
                            <h2><span>Campus</span><div class="triangle"></div></h2>
                        </div>
                        <div class="image">
                            <a href="events.php"><img src="../images/splashicons_events.png" alt="" /></a>
                            <h2><span>Events</span><div class="triangle"></div></h2>
                        </div>
                        <div class="image">
                            <a href="admins.php"><img src="../images/splashicons_admins.png" alt="" /></a>
                            <h2><span>Admins</span><div class="triangle"></div></h2>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="row">
                        <div class="image" style="margin-left: 125px">
                            <a href="profile.php"><img src="../images/splashicons_profile.png" alt="" /></a>
                            <h2><span>Profile</span><div class="triangle"></div></h2>
                        </div>
                        <div class="image">
                            <a href="tutorials.php"><img src="../images/splashicons_tutorials.png" alt="" /></a>
                            <h2><span>Tutorials</span><div class="triangle"></div></h2>
                        </div>
                        <div class="image">
                            <a href="../php/logout.php"><img src="../images/splashicons_logout.png" alt="" /></a>
                            <h2><span>Logout</span><div class="triangle"></div></h2>
                        </div>
                    </div>
                </div>
            </div>
            </td>
    	</tr>
    </table>
    
    
    <!-- Footer -->
    <div id="footer">
    	<div class="container">
        	<p>Copyright &copy; 2013 - <?php echo date("Y"); ?> Moises Melano, Joshua Frea, &amp; Juan Hernandez</p>
        </div>
    </div>

</body>
</html>