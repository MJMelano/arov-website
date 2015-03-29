/*************************************************
 * Name: loginscript.js
 * Website: AROV CMS [Login Page]
 * URL: http://hosting.otterlabs.edu/classes/melanomoises/arov/index.php
 * Authors: Moises Melano, Joshua Frea, Juan Hernandez
 * Email: mmelano@csumb.edu
 *************************************************/

// JavaScript Document
//Call on Page Load
$(document).ready(function() 
{
    $("#bgshadow").click(function()
	{
		$("#loginbox").hide();
		$("#bgshadow").fadeOut("slow");
	});
});

//Function to Display Login Box
function showLoginBox() 
{
	$("#bgshadow").css({"opacity": "0.4"});
	$("#bgshadow").fadeIn("slow");
	$("#loginbox").fadeIn("fast");
	window.scroll(0,0);
}

//Hide Login Box
function hideLoginBox()
{
	$("#loginbox").hide();
	$("$bgshadow").fadeOut("slow");	
}