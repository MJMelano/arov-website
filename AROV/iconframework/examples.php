<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

require("GraphicsEngine/Frame.php");
require("GraphicsEngine/Text.php");
//require("GraphicsEngine/DescriptionBox.php");
require("GraphicsEngine/Card.php");

$text = $_GET['text'];

//Paths for example images
$example_1 = "examples/myFrame.png";
$example_2 = "examples/myText.png";
$example_4 = "examples/myText2.png";
$example_3 = "examples/myDB.png";
$example_5 = "examples/myBlimp.png";

/*
//Frame with a border
$myFrame = new Frame(100,100, array(0,200,200));
$myFrame->setColoredBorder(10, array(200,150,150,100));
$myFrame = new Card($myFrame->getFrame());
$myFrame->saveCard($example_1);

*/

//text with transparent background
$myText = new Text();
$myText->setText($text,"GraphicsEngine/fonts/arial.ttf", 32, array(0,150,120));
//$myText->setDimensions();

$myText = new Card($myText->getText());
$myText->saveCard($example_2);


//Text with background and round corners

//$myText = new Text();
//$myText->setText($text,"GraphicsEngine/fonts/helvetica1.ttf", 32, array(255,255,255));
//$myText->setColoredCanvas(48,48, array(30,30,80,100), 127);

//$myText = new Card($myText->getText());
//$myText->roundCorners(22);
//$myText->saveCard($example_3);

//Description box with a background
//$DBtext = "this demonstrates the creation of a description box image.";
//$myDB = new DescriptionBox();
//$myDB->setText($DBtext, "GraphicsEngine/fonts/arial.ttf", 12, array(255,255,255));
//myDB->setColoredCanvas(200,100, array(100,100,200)); 

//$myDB = new Card($myDB->getDescriptionBox());
//$myDB->saveCard($example_4);


/**************** MOST USEFUL EXAMPLE*********
 * Example 5
 * Combining elements.
 * 
* */

$elem1 = new Frame(140,70, "examples/blimp.png");
$elem2 = new Text();
$elem2->setText($text,"GraphicsEngine/fonts/helvetica1.ttf", 55, array(255,255,255));
$elem2->setColoredCanvas(64,60, array(0,0,0,100));
$elem3 = new Text();
$elem3->setText("MLC","GraphicsEngine/fonts/arial.ttf", 40, array(0,0,0));
$elem3->setColoredCanvas(60,60, array(0,0,0,127));

$myBlimp = new Card($elem1->getFrame()); 
$myBlimp->addElement($elem2->getText(),4,5);	
$myBlimp->addElement($elem3->getText(),65,5);
$myBlimp->roundCorners(20);
$myBlimp->saveCard($example_5);

/*****************************************/


/* PLAY AROUND WITH THIS CODE BELOW TO AUTOMATICALLY RETRIEVE THE SERVER URL
 * SO YOU DON'T HAVE TO HARD CODE IT THE IMAGES
 
print $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['SCRIPT_FILENAME'];
echo "<br>";
echo $_SERVER['REQUEST_URI'];
echo "<br>";

function chopExtension($filename) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
}

$server_path = chopExtension($_SERVER['SCRIPT_FILENAME']);// string(3) "bob"
echo $server_path;
echo "<br>"; */

?>