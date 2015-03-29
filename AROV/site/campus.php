<?php
$ctime = 300;
session_start();
ob_start();
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
require '../iconframework/arovicons.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AROV Content Management</title>
	<link href="../css/main.css" rel="stylesheet" type="text/css" />
    <link href="../css/map.css" rel="stylesheet" type="text/css" />
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
                            <h1>AROV - Campus Mapping</h1>
                        </div>
                    </div>
                    
                    <!-- Nav Starts -->
                    <div id="nav">
                        <div class="container">
                            <ul>
                                <li><a href="#" class="current">Campus</a></li>
                                <li><a href="events.php">Events</a></li>
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
                                            <td><input type="text" class="textbox" name="number" placeholder="Building Number" /></td>
                                            <td colspan="2"><input style="width: 240px;" type="text" class="textbox" name="name" placeholder="Building Name" /></td>
											<td><input type="text" class="textbox" name="lat" id="clicklat" placeholder="Latitude" /></td>
											<td><input type="text" class="textbox" name="long" id="clicklng" placeholder="Longitude" /></td>
                                            <td rowspan="3">
                                            	<div id="checkbox">
 													<?php ob_start(); ?>
                                                    <p>Category</p>
                                                    <input type="radio" name="category" value="Academic" /><span> Academic</span><br>
                                                    <input type="radio" name="category" value="Dining" /><span> Dining</span><br>
                                                    <input type="radio" name="category" value="Residential" /><span> Residential</span><br>
                                                    <input type="radio" name="category" value="Services" /><span> Services</span>
                                                </div>
                                            </td>
										</tr>
                                        	<td colspan="6"><textarea name="bdesc" class="desbox" rows="3" cols="60" placeholder="Building Description"></textarea></td>
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
											if(!$_POST['name'] | !$_POST['number'] | !$_POST['lat'] | !$_POST['long'] | !$_POST['bdesc']) 
											{
												exit;
											}
											else
											{
												$addquery = 'INSERT INTO arov_buildings (bld_num, bld_name, bld_latitude, bld_longitude, bld_description, bld_category)
													VALUES (' . $_POST['number'] . ', "' 
														. $_POST['name'] . '", '
														. $_POST['lat'] . ', '
														. $_POST['long'] . ', "'
														. mysql_real_escape_string($_POST['bdesc']) . '",';
														if($_POST['category'] == 'Academic')
														{
															$addquery .= '1)';
														}
														elseif($_POST['category'] == 'Dining')
														{
															$addquery .= '2)';
														}
														elseif($_POST['category'] == 'Residential')
														{
															$addquery .= '3)';
														}
														elseif($_POST['category'] == 'Services')
														{
															$addquery .= '4)';
														}

												if(mysql_query($addquery))
												{
													$qry = 'SELECT bld_id FROM arov_buildings WHERE bld_num = ' . $_POST['number'];
													$results = mysql_query($qry);
													$data = mysql_fetch_assoc($results);
														
													createArovIcons($_POST['number'], $_POST['name']);
													updateJSON();
													header("Location: campus.php"); exit();
												}
												
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
												$updateqry = 'UPDATE arov_buildings SET ';
												if(!empty($_POST['name']))
												{
													$updateqry = 'UPDATE arov_buildings SET ';
													$updateqry .= 'bld_name = "' . $_POST['name'] . '" ';
													$updateqry .= 'WHERE bld_num = ' . $_POST['number'];
													$updateresults = mysql_query($updateqry);
												}
												//if(isset($_POST['lat']) && isset($_POST['long']))
												//{
													//$updateqry .= 'bld_latitude=' . $_POST['lat'] . ' ';
													//$updateqry .= 'bld_longitude=' . $_POST['long'] . ' ';
												//}
												if(!empty($_POST['bdesc']))
												{
													$updateqry = 'UPDATE arov_buildings SET ';
													$updateqry .= 'bld_description = "' . $_POST['bdesc'] . '" ';
													$updateqry .= 'WHERE bld_num = ' . $_POST['number'];
													$updateresults = mysql_query($updateqry);
												}
												
												updateJSON();
												header("Location: campus.php"); exit();
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
												$deleteqry = 'DELETE FROM arov_buildings WHERE bld_num =' . $_POST['number'];
												$deleteresults = mysql_query($deleteqry);

												updateJSON();
												header("Location: campus.php"); exit();	
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
									$bldqry = "SELECT * FROM arov_buildings WHERE 1";
									$results = mysql_query($bldqry);
									
									while ($data = mysql_fetch_assoc($results))
									{
										echo '<div class="node">';
										echo '<table><tbody>';
										echo '<tr>
												<td>Building ' . $data['bld_num'] . ' - ' . $data['bld_name'] . '</td>
											  </tr>
											  <tr>
											  	<td>' . $data['bld_description'] . '</td>
											  </tr>';
										echo '</tbody></table>';
										echo '</div>';
									} ;
									ob_flush();
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