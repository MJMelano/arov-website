<?php
$ctime = 300;
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] = TRUE)
{
	header("Location: site/splash.php");
}
require 'php/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AROV Content Management System Login</title>
	<link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/loginscript.js"></script>
</head>

<body>
	<div id="bgshadow"></div>
	<!-- Content -->
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td>
            	<div class="center">
                	<h1>Augmented Reality Otter Vision</h1>
                    <h2>Content Management System</h2>
                    <a href="javascript:void(0);" class="loginbutton" onClick="showLoginBox();">Login</a>
                    
                    <!-- Login Box -->
                    <div id="loginbox">
                    	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        	<table style="margin: auto;">
                            	<tr>
                                	<td><p>Email: </p></td><td><input type="text" name="user" maxlength="60" class="textbox"/></td>
                                </tr>
                                <tr>
                                	<td><p>Password: </p></td><td><input type="password" name="pass" class="textbox" /></td>
                                </tr>
                                <tr>
                                	<td colspan="2" align="right"><a href="#"><p style="float:right">Can't log in?</p></a>
                                </tr>
                                <tr>
                                	<td colspan="2" align="right"><input type="submit" name="submit" value="Login" /></td>
                                </tr>
                            </table>   
                        </form>
                        <?php					
							if(isset($_POST['submit']) && $_POST['submit'] == 'Login')
							{
								if(!$_POST['user'] | !$_POST['pass'])
								{
										echo 'Please complete both fields.';
										exit;
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
									$_SESSION['id'] = $row['adm_id'];
									$_SESSION['fname'] = $row['adm_first_name'];
									$_SESSION['mname'] = $row['adm_middle_initial'];
									$_SESSION['lname'] = $row['adm_last_name'];
									$_SESSION['phone'] = $row['adm_phone'];
									$_SESSION['email'] = $row['adm_user_name'];
									$_SESSION['permissions'] = $row['adm_permissions'];
									$_SESSION['logged'] = TRUE;
									
									//Redirect to Main
									header("Location: site/splash.php");
									exit;	
								}
								//Query Unseccessfull
								else
								{
									echo 'Username and Password do not match our records.';
									exit;
								}
							}
						?>                    
                    </div>                    
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Footer -->
    <div id="footer">
    	<div class="container">
        	<p>Copyright &copy; 2013 - <?php echo date("Y") ?> Moises Melano, Joshua Frea, &amp; Juan Hernandez</p>
        </div>  	
    </div>   
</body>
</html>