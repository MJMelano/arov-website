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
                    <!-- Banner -->
                    <div id="banner">
                        <div class="container">
                            <h1>AROV - <?php  echo $_SESSION['fname']; ?>'s Profile</h1>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <div id="nav">
                        <div class="container">
                            <ul>
                                <li><a href="campus.php">Campus</a></li>
                                <li><a href="events.php">Events</a></li>
                                <li><a href="directions/directions.html">Directions</a></li>
                                <li><a href="admins.php">Admins</a></li>
                                <li><a href="#" class="current">Profile</a></li>
                                <li><a href="tutorials.php">Tutorials</a></li>
                                <li><a href="../php/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Main Content -->
                    <div id="main">
                        <div class="container">
                        	<!-- Profile Update PHP -->
                            <?php
								//Submit Button Check
								if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
								{
									//Update Query String 
									$queryString = "UPDATE arov_admins SET " 
										. (!empty($_POST['fname']) ? 'adm_first_name = "' . $_POST['fname'] . '", ' : '')
										. (!empty($_POST['mname']) ? 'adm_middle_initial = "' . $_POST['mname'] . '", ' : '')
										. (!empty($_POST['lname']) ? 'adm_last_name = "' . $_POST['lname'] . '", ' : '')
										. (!empty($_POST['phone']) ? 'adm_phone = "' . $_POST['phone'] . '", ' : '')
										. (!empty($_POST['email']) ? 'adm_user_name = "' . $_POST['email'] . '", ' : '');
									
									//Remove Trailing Comma
									$queryString = rtrim($queryString, ", ");
									
									//Concatenate Where Clause
									$queryString .= " WHERE adm_id = " . $_SESSION['id'];
									$result = mysql_query($queryString);
									
									//Update Password
									if(!empty($_POST['cpass']) && !empty($_POST['npass']) && !empty($_POST['mpass']))
									{
										if($_POST['npass'] == $_POST['mpass'])
										{
											$temp = sha1(mysql_real_escape_string($_POST['npass']));
											$passqry = 'UPDATE arov_admins SET adm_password = "' . $temp
												. '" WHERE adm_id = ' . $_SESSION['id'];
											$result = mysql_query($passqry);
										}
									}
									
									//User Update Feedback
									if($result)
									{
										header("Location: profile.php");	
									}
									
									//Update Session Variables
									(!empty($_POST['fname']) ? $_SESSION['fname'] = $_POST['fname'] : $_SESSION['fname'] = $_SESSION['fname']);
									(!empty($_POST['mname']) ? $_SESSION['mname'] = $_POST['mname'] : $_SESSION['mname'] = $_SESSION['mname']);
									(!empty($_POST['lname']) ? $_SESSION['lname'] = $_POST['lname'] : $_SESSION['lname'] = $_SESSION['lname']);
									(!empty($_POST['phone']) ? $_SESSION['phone'] = $_POST['phone'] : $_SESSION['phone'] = $_SESSION['phone']);
									(!empty($_POST['email']) ? $_SESSION['email'] = $_POST['email'] : $_SESSION['email'] = $_SESSION['email']);	
								}
		
							?>
                        
                        	<!-- Profile Form -->
                        	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        	<table>
                            	<tbody>
                                	<tr>
                                    	<td class="label">First Name: </td>
                                        <td><input type="text" name="fname" class="textbox" placeholder="<?php echo $_SESSION['fname']; ?>"/></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Middle Initial: </td>
                                        <td><input type="text" name="mname" class="textbox" placeholder="<?php echo $_SESSION['mname']; ?>"/></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Last Name: </td>
                                        <td><input type="text" name="lname" class="textbox" placeholder="<?php echo $_SESSION['lname']; ?>"/></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Phone: </td>
                                        <td><input type="text" name="phone" class="textbox" placeholder="<?php echo $_SESSION['phone']; ?>"/></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Email: </td>
                                        <td><input type="text" name="email" class="textbox" placeholder="<?php echo $_SESSION['email']; ?>"/></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Current Password: </td>
                                        <td><input type="password" name="cpass" class="textbox" /></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">New Password: </td>
                                        <td><input type="password" name="npass" class="textbox" /></td>
                                  	</tr>
                                    <tr>
                                    	<td class="label">Confirm Password: </td>
                                        <td><input type="password" name="mpass" class="textbox" /></td>
                                  	</tr>
                                    <tr>
                                    	<td colspan="2" align="right"><input type="submit" name="submit" value="Update" /></td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
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