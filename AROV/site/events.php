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
require '../php/json.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AROV Content Management</title>
	<link href="../css/main.css" rel="stylesheet" type="text/css" />
    <link href="../css/map.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
</script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
      var myLatlng = new google.maps.LatLng(36.654041, -121.799844);
	  var map;
	  var marker;
	  
	  function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(36.654041, -121.799844),
          zoom: 17
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
			
		google.maps.event.addListener(map, 'click', function(event){
			placeMarker(event.latLng);
			document.getElementById('clicklat').value = event.latLng.lat();
			document.getElementById('clicklng').value = event.latLng.lng();
		});
      }
	  
	  function placeMarker(location) {
            if(!marker){
				marker = new google.maps.Marker({
                	position: location, 
                	map: map
            	});
			}
			else {
				marker.setPosition(location);
			}	
        }

	google.maps.event.addDomListener(window, 'load', initialize);
    
    </script>
</head>

<body onload="initialize()">
	<!-- Wrapper -->
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td> 
            	<div id="wrapper">   
                    <!-- Banner Starts -->
                    <div id="banner">
                        <div class="container">
                            <h1>AROV - Event Management</h1>
                        </div>
                    </div>
                    
                    <!-- Nav Starts -->
                    <div id="nav">
                        <div class="container">
                            <ul>
                                <li><a href="campus.php">Campus</a></li>
                                <li><a href="#" class="current">Events</a></li>
                                <li><a href="directions/directions.html">Directions</a></li>
                                <li><a href="admins.php">Admins</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="tutorials.php">Tutorials</a></li>
                                <li><a href="../php/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Main Starts -->
                    <div id="main">
                        <div class="container">
                        <div id="map-canvas"></div>
                            <div class="clear"></div>
                            <div id="map-form">
								
                                <table style="margin-left:5px;"><tbody>
                                	<?php
									if($_SESSION['permissions'] == 0)
									{
										echo '
									<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
										<tr>
                                            <td><input type="text" class="textbox" name="number" placeholder="Event Number" /></td>
                                            <td colspan="2"><input style="width: 240px;" type="text" class="textbox" name="name" placeholder="Event Name" /></td>
											<td><input type="text" class="textbox" name="lat" id="clicklat" placeholder="Latitude" /></td>
											<td><input type="text" class="textbox" name="long" id="clicklng" placeholder="Longitude" /></td>
											<td><input id="datepicker" type="text" class="textbox" name="date" placeholder="Event Date" /></td>
										</tr>
                                        	<td colspan="6"><textarea name="bdesc" class="desbox" rows="3" cols="60" placeholder="Event Summary"></textarea></td>
                                        <tr>
                                        </tr>
										<tr>
											<td colspan="3">
												<input style="margin-right: 5px;" type="submit" name="submit" value="Add" />
												<input style="margin-right: 5px;" type="submit" name="submit" value="Update" />
												<input type="submit" name="submit" value="Delete" />
											</td>
										</tr>';
								}
										?>
                                     <?php
									 	if(isset($_POST['submit']) && $_POST['submit'] == 'Add')
										{
											if(!$_POST['name'] | !$_POST['lat'] | !$_POST['long'] | !$_POST['bdesc'] | !$_POST['date']) 
											{
												exit;
											}
											else
											{
												$addquery = 'INSERT INTO arov_events (evt_name, evt_latitude, evt_longitude, evt_summary, evt_date)
													VALUES ("' 
														. $_POST['name'] . '", '
														. $_POST['lat'] . ', '
														. $_POST['long'] . ', "'
														. mysql_real_escape_string($_POST['bdesc']) . '", "'
														. $_POST['date'] . '")';
														
														//echo $addquery;

												if(mysql_query($addquery))
												{
													//$qry = 'SELECT bld_id FROM arov_buildings WHERE bld_num = ' . $_POST['number'];
													//$results = mysql_query($qry);
													//$data = mysql_fetch_assoc($results);
														
													//createArovIcons($_POST['number'], $_POST['name']);
													updateEventsJSON();
													header("Location: events.php"); exit();
												}
												updateEventsJSON();
													header("Location: events.php"); exit();
											}				
										}
										elseif(isset($_POST['submit']) && $_POST['submit'] == 'Update')
										{
											if(!$_POST['number']) 
											{
												exit;
											}
											else
											{
												$updateqry = 'UPDATE arov_events SET ';
												if(isset($_POST['name']))
												{
													$updateqry .= 'evt_name = "' . $_POST['name'] . '" ';
												}
												//if(isset($_POST['lat']) && isset($_POST['long']))
												//{
													//$updateqry .= 'bld_latitude=' . $_POST['lat'] . ' ';
													//$updateqry .= 'bld_longitude=' . $_POST['long'] . ' ';
												//}
												if(isset($_POST['bdesc']))
												{
													$updateqry .= ', evt_summary = "' . $_POST['desc'] . '" ';
												}
												if(isset($_POST['date']))
												{
													$updateqry .= ', evt_date = "' . $_POST['date'] . '"';	
												}
												$updateqry .= 'WHERE evt_id = ' . $_POST['number'];
												$updateresults = mysql_query($updateqry);
												updateEventsJSON();
												header("Location: events.php"); exit();
											}
										}
										elseif(isset($_POST['submit']) && $_POST['submit'] == 'Delete')
										{
											if(!$_POST['number']) 
											{
												exit;
											}
											else
											{
												$deleteqry = 'DELETE FROM arov_events WHERE evt_id =' . $_POST['number'];
												$deleteresults = mysql_query($deleteqry);

												updateEventsJSON();
												header("Location: events.php"); exit();	
											}
										}
										
										ob_flush();
									 ?>
                                     </form>							
								</tbody></table>
                                  </div>
                            <div style="margin-top:95px;margin-bottom: 50px;">
                                <!-- Nodes -->
                                <?php
									$bldqry = "SELECT * FROM arov_events WHERE 1";
									$results = mysql_query($bldqry);
									
									while ($data = mysql_fetch_assoc($results))
									{
										echo '<div class="node">';
										echo '<table><tbody>';
										echo '<tr>
												<td>Event ' . $data['evt_id'] . ' - ' . $data['evt_name'] . ':' . $data['evt_date'] . '</td>
											  </tr>
											  <tr>
											  	<td>' . $data['evt_summary'] . '</td>
											  </tr>';
										echo '</tbody></table>';
										echo '</div>';
									} ;
									
								?>
                            </div>   
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