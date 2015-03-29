<?php

/**
* An instance of this class represents a Text element of a card. 
* This class extends the Frame class.
* 
* <code>
*
* require_once('class_Frame.php');
* require_once('class_Text.php');
* 
* //Creating a text image
* $myLabel = new Text();
* //Set text attributes...string, font (truetype font file), font size, and color
* $myLabel->setText($text,$label['font'], 32, array(255,255,255));
* //change background canvas (frame) attributes....height, width, color, opacity
* $myLabel->setColoredCanvas(48,48, array(30,30,80,100), 127);
* </code>
* 
* @author Juan A Hernandez <JuHernandez@csumb.edu>
*/

 class Text extends Frame
{

	/**
	* @ignore
	* Variable declarations 
	*/
	var $text;	
	/**
	* @ignore
	*/							
	var $font;	
	/**
	* @ignore
	*/								
	var $color;								
	/**
	* @ignore
	*/	
	var $size;
	/**
	* @ignore
	*/									
	var $angle;	
	/**
	* @ignore
	*/					
	var $textX;
	/**
	* @ignore
	*/						
	var $textY;
	//var $keys;
	
	 /**
	 * @ignore
	 * Constructor that sets the defaults at creation of object. 
	 */

	function __construct()
	{	
		parent::__construct();
		$this->setDefaults();
	}
	
	 /**
	 * @ignore
	 * Function to set the default text attributes.
	 */

	
	function setDefaults()
	{			
		$this->text = "default text";
		$this->font= "../iconframework/GraphicsEngine/fonts/arial.ttf";
		$this->size = 40;
		$this->color = array(255,255,255);

		$this->width=100;
		$this->height=100;
		$this->setColoredCanvas($this->width,$this->height, array(0,0,0, 127));
		$this->setDimensions();
		$this->createFrame();
		
		//echo "defaults have been set<br>";

	}
	
	 /**
	 * Function to set text attributes 
	 * 
	 * @param string $text Sets the text for the image
	 * @param string $font Sets the  path to a true type font. ie "arial.ttf"
	 * @param int $size Sets the font size
	 * @param array $color Sets the rgb values from 0-255 for red, green, and blue. ie array(255,255,255) for white. 
	 * @param int $angle [optional] Sets the angle of the text
	 */
	 
	function setDimensions(){
		
		//if($this->font == ""){ 	trigger_error("No font file provided. Please see documentation", E_USER_NOTICE);}
		//else {
			
		$bbox = imagettfbbox($this->size, $this->angle, $this->font, $this->text);
		
	
		$i;	
		for($i= 0;$i<8;$i++)
		{
			//echo "\$bbox[".$i."] = ".$bbox[$i]."<br>";
			
		}
		
		$this->width = $bbox[2];
		$this->height = abs($bbox[5]);
		//}
		/*
		// width - 20 adds some padding
		while($width - 20 < $bbox[2])
		{
			$this->size -= 1;
			$bbox = imagettfbbox($this->size, $this->angle, $this->font, $this->text);
		}
		
		//Add some padding
		//$width+=20;
		$this->textX = (($width-2 - $bbox[2])/2); //originally width+7
		
		$this->textY  = $height - (($height - abs($bbox[5]))/2)+$this->border_thickness;
		*/
		
	}
	
	function setText($text, $font , $size, $color , $angle=0)
	{
		$this->text = $text;
		$this->font = $font;
		$this->size = $size;
		$this->color = $color;
		$this->angle = $angle;
		//$this->setDimensions();
		
		//$this->text = $this->add_brackets($this->text, $this->keys); 

	}

	/**
	 * @ignore
	 * Function that creates a vertical text image. 
	 * Text image is rotated 90 degrees counter clockwise. 
	 */
	
	function addTextToFrame()
	{
		 //Turning back Image Alpha Blending to true
		imagesavealpha($this->frame, true);
		ImageAlphaBlending($this->frame, true); 		// As previously noted :ImageAlphaBlending must be on default setting : True.
		
		

		$this->centerHorizontalText();

		
		$textColor = imagecolorallocate($this->frame, $this->color[0], $this->color[1],$this->color[2]);
		imagettftext($this->frame, $this->size, $this->angle, $this->textX, $this->textY, $textColor, $this->font, $this->text);
	}
	
	/**
	 * @ignore
	 * Function that creates a horizontal text image. 
	 */

	function createHorizontalText()
	{	
		$this->createFrame();
		$this->addTextToFrame();
		return $this->frame;

	}
	
	/**
	 * @ignore
	 * Function that creates a vertical text image. 
	 * Text image is rotated 90 degrees counter clockwise. 
	 */
	function createVerticalText()
	{
		$this->createHorizontalText();

		$this->frame = imagerotate($this->frame, 90 ,0) ;
		
	}
	
	/**
	 * Function that rotates text counter-clockwise depending on the specified angle.
	 * 
	 * @param int $angle Set the angle for the text 
	 */
	
	function rotateText($angle)
	{
		//$this->createHorizontalText();

		$this->frame = imagerotate($this->frame,$angle ,0) ;
		
	}
	
	/**
	 * @ignore
	 * Function that creates a horizontal text image
	 */
	
	function centerHorizontalText()
	{
	
		
		$bbox = imagettfbbox($this->size, $this->angle, $this->font, $this->text);
		$width = imagesx($this->frame);
		$height = imagesy($this->frame);
		
		
		// width - 20 adds some padding
		while($width - 20 < $bbox[2])
		{
			$this->size -= 1;
			$bbox = imagettfbbox($this->size, $this->angle, $this->font, $this->text);
		}
		
		//Add some padding
		//$width+=20;
		$this->textX = (($width-2 - $bbox[2])/2); //originally width+7
		
		$this->textY  = $height - (($height - abs($bbox[5]))/2)+$this->border_thickness;

	}
	
	/**
	 * Function that returns the text image resource 
	 * 
	 * @param int $orientation Set orientation for text image. Horizontal: 0, Vertical: 1. Horizontal is the default. 
	 */
	function getText()
	{
		//$this->createFrame();
		//if($orientation == 0){	$this->createHorizontalText(); echo "horizontal image created";}
		//else if($orientation == 1){ $this->createVerticalText();}
		//else { 	trigger_error("Invalid orientation selected. Please see Text Class documentation.", E_USER_NOTICE);}
		//return $this->getFrame();
		return $this->createHorizontalText();
	}
	
	/**
	 * Function to save the created Text image
	 * 
	 * @param string $filename Sets the file with this name. 
	 * @param int $orientation Set orientation for text image. Horizontal: 0, Vertical: 1. Horizontal is the default. 
	 * 
	 * @todo Find out why the background canvas is showing up on veritcal text and not horizonatal text images
	 */
	function saveText($filename)
	{	
			imagepng($this->getText(), $filename,0);
	}
	
	
	// function add_brackets($text, $keys) //$keys is a string ie: "key1 key2"
	// {
		// //var $new_keys;
		// $keys = preg_split("/ /",$keys);	// -1, PREG_SPLIT_OFFSET_CAPTURE ); // add to get position of the start of each word
	
		// for ( $x = 0; $x < sizeof($keys) ; $x++)
		// {
			// $string = "[" . $keys[$x] . "]"; 
			// //$string = "[<font color='red'>" . $keys[$x] . "</font>]"; 
			// $new_keys[$x] = $string;
		// }

		// return str_replace($keys, $new_keys, $text);

	// }
	function getTextHeight()
	{
		return $this->height;	
	}
	
	function getTextWidth()
	{
		return $this->width;	
	}

}




