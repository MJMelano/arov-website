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
                            <h1>AROV - Admin Management</h1>
                        </div>
                    </div>
                    
                    <!-- Nav Starts -->
                    <div id="nav">
                        <div class="container">
                            <ul>
                                <li><a href="campus.php">Campus</a></li>
                                <li><a href="events.php">Events</a></li>
                                <li><a href="directions/directions.html">Directions</a></li>
                                <li><a href="#" class="current">Admins</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="tutorials.php">Tutorials</a></li>
                                <li><a href="../php/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Main Starts -->
                    <div id="main">
                        <div class="container">
                        	<?php
								//Select Query
								ob_start();
								$qry = "SELECT * FROM arov_admins WHERE 1";
                            	$results = mysql_query($qry);
								$data = mysql_fetch_assoc($results);
								
								//Table Head
								echo '<table style="margin-left: 5px;" cellspacing="5px">
									<!-- Order By -->
									<thead>
										<tr>
											<th style="width: 90px; text-align: left;">First Name</th>
											<th style="width: 50px; text-align: left;">Initial</th>
											<th style="width: 90px; text-align: left;">Last Name</th>
											<th style="width: 70px; text-align: left;">Phone</th>
											<th style="width: 120px; text-align: left;">Email</th>
											<th style="width: 90px; text-align: left;"></th>											
										</tr>
									</thead>';
								
								//Table Body
								echo '<!-- Admin Population -->
									<tbody>
									<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
								
								//Populate Admin Records	
								do
								{
									echo '<tr>
											<td>'. $data['adm_first_name'] . '</td>
											<td>'. $data['adm_middle_initial'] . '</td>
											<td>'. $data['adm_last_name'] . '</td>
											<td>'. $data['adm_phone'] . '</td>
											<td>'. $data['adm_user_name'] . '</td>
											<td style="text-align: center;">';
											
											if(($_SESSION['permissions']) == 0)
											{
												echo '
												<a href="../php/deleteadmin.php?id=' . $data['adm_id'] . '">
													<p>Delete</p>
												</a>';
											}
												
											echo '</td>
										</tr>';
								} while($data = mysql_fetch_assoc($results));
								
								//Add Admin Row
								if(($_SESSION['permissions']) == 0)
								{
									echo '<tr>
										<td><input type="text" class="textbox" name="fname" placeholder="First Name" /></td>
										<td><input type="text" class="textbox" name="mname" placeholder="Middle Initial" /></td>
										<td><input type="text" class="textbox" name="lname" placeholder="Last Name" /></td>
										<td><input type="text" class="textbox" name="phone" placeholder="Phone" /></td>
										<td><input type="text" class="textbox" name="email" placeholder="Email" /></td>
										<td style="text-align: center;"><input style="width: 90px;" type="submit" name="submit" value="Add Admin" /></td>
										<td style="text-align: center;"><input style="width: 90px;" type="submit" name="submit" value="Add Member" /></td>
									</tr>';			
								}
								
								echo '</form></tbody></table>';
								
								if(isset($_POST['submit']))
								{
									if(!$_POST['fname'] | !$_POST['email'])
									{
										exit;	
									}
									
									if($_POST['submit'] == 'Add Admin')
									{
										$perm = 0;
									}
									else
									{
										$perm = 1;	
									}
									
									$addqry = 'INSERT INTO arov_admins (adm_first_name, adm_middle_initial, adm_last_name, 
										adm_phone, adm_user_name, adm_permissions, adm_password)
										VALUES ("' . $_POST['fname'] .'", "' 
										. $_POST['mname'] . '", "' 
										. $_POST['lname'] . '", "' 
										. $_POST['phone'] . '", "' 
										. $_POST['email'] . '", "' 
										. $perm . '", "' 
										. sha1("ChangeMe") .  '")';
									
									//Email Notification
									$message = 'Hello ' . $_POST['fname'] . ' ' . $_POST['lname'] . ', if you are viewing this email, welcome to the Augmented Reality Otter Vision Team!';
									
									if($perm == 0)
									{
										$message .= ' You have been added as an admin for the application.';	
									}
									else
									{
										$message .= ' You have been added as an even coordinator for the application.';
									}
									
									$message .= 'You can log in at arovmb.com and your user name is this email address and your password is "ChangeMe" when you first log in, so please visit the profile page and change that at your earliest convinience. For more information, feel free to contact me at mmelano@csumb.edu';
															
									if(mysql_query($addqry))
									{
										mail($_POST['email'], 'Augmented Reality Otter Vision Application', $message);
										header("Location: admins.php");
										exit();	
									}
								} ob_flush();
							?>   
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