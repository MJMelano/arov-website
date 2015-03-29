<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

require("GraphicsEngine/Frame.php");
require("GraphicsEngine/Text.php");
//require("GraphicsEngine/DescriptionBox.php");
require("GraphicsEngine/Card.php");

function createArovIcons($num, $name)
{
	$save = "../images/" . $num . ".png";
	
	//Get Building Number
	$text = $num;
	$myText = new Text();
	$myText->setText($text, "../iconframework/arial.ttf", 40, array(255,255,255));
	
	//Get Background Image
	$myBG = new Frame(100, 100, "../iconframework/base.png");
	
	//Get Text Dimensions
	$myWidth = ($myText->getTextWidth())/2;
	$myHeight = ($myText->getTextHeight())/2;
	
	//Make Image
	$myCard = new Card($myBG->getFrame());
	$myCard->addElement($myText->getText(), (50 - $myWidth), (50 - $myHeight));
	$myCard->saveCard($save);
	
}