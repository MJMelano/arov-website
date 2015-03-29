<?php

/**
* An instance of this class represents a Description Box element of a card. 
* This class extends the Text class.
* 
* <code>
* 
* </code>
* 
* @author Juan A Hernandez <JuHernandez@csumb.edu>
*/

 class DescriptionBox extends Text
{
	/**
	* @ignore
	* Function to set the default description text attributes.
	*/
	var $rightMarginPadding;
	/**
	* @ignore
	*/
	var $leftMarginPadding;
	/**
	* @ignore
	*/
	var $topMarginPadding;
	/**
	* @ignore
	*/
	var $highlight_color;
	/**
	* @ignore
	*/
	var $keys; 
	
	 /**
	 * @ignore
	 * Constructor that sets the defaults at creation of object. 
	 */	
					
	function __construct()
	{
		parent::__construct();
		

		$this->leftMarginPadding = 12;
		$this->rightMarginPadding = $this->leftMarginPadding +20;
		$this->topMarginPadding= 23;
		$this->keys = "compromise exchange give move ";
	}
	
	/**
	* @ignore
	* Function to word wrap text within set width
	*/
	
	function word_wrap()
	{
		$newtext = $this->text_wordwrap($this->text,$this->width, $this->size, $this->angle, $this->font);
		unset($this->text);
		$this->text = $newtext;
		//return $this->text;
	}
	
	/**
	* @ignore
	* Function that sets the margins of the decription box
	*/
	function setMargins($left, $right, $top)
	{
		$this->leftMarginPadding = $left;
		$this->rightMarginPadding = $right + $this->leftMarginPadding+10;
		$this->topMarginPadding= $top +13;
	
	
	}
	
	
	/**
	 * @ignore
	* Function that merges the frame and image sources to create a description box image.
	*/
	 function createDescriptionBox()
	{
		//$this->setColoredCanvas(200,100, array(255,255,255,127));
		//$this->createFrame();
		$this->word_wrap();
		
		//$this->frame = imagecreatefrompng($this->layer.'.png');
		imagesavealpha($this->frame, true);
		ImageAlphaBlending($this->frame, true); 		// As previously noted :ImageAlphaBlending must be on default setting : True.
		$this->textX = $this->leftMarginPadding; 
		$this->textY = $this->topMarginPadding;
		
		$textColor = imagecolorallocate($this->frame, $this->color[0], $this->color[1],$this->color[2]);
		imagettftext($this->frame, $this->size, $this->angle, $this->textX, $this->textY, $textColor, $this->font, $this->text);
		
		//imagepng($this->frame, $this->layer.'.png', 0);
		//unlink('background.png');
		//unlink('border.png');
	}
	
	function getDescriptionBox()
	{
			$this->createFrame();
			$this->createDescriptionBox();
			return $this->frame;
	}
	
	/**
	* Word wrap function for description box.
	*
	* @param string $input_text string to add word wrap to
	* @param int $width the width in pixels of how wide the string should be
	* @param int $text_size font size of text
	* @param int $text_angle  font angle
	* @param string $text_font desired font
	*/
	
	/**
	* @ignore
	* Function to word wrap text within set width
	*/
	function text_wordwrap($input_text, $width, $text_size, $text_angle, $text_font)
	{
		
		//$this->text = $this->add_brackets($this->text, $this->keys); 
		
		$text = $input_text;
		$width_bbox = $width;
		$size = $text_size;
		$angle = $text_angle;
		$font = $text_font;
		
		$placeholder = 0;
		
		for($index = 0; $index < (strlen($text)); $index++)
		{
			$length = $index-$placeholder;
			$line = substr($text, $placeholder, $length);
			$bbox = imagettfbbox($size, $angle, $font, $line);
			if($bbox[2] > $width_bbox-$this->rightMarginPadding)
			{
			
				$pos = 0;
				for($i =0; $i < strlen($line); $i++)
				{
					if($line[$i] == " ")
					{ 
						$pos = $i; 
					}
				}
			
				if ($pos == 0) 
				{ // note: three equal signs. Not found...
					$line = substr($text, $placeholder, $length);
					$string = $line."\n";
					$newText= $newText.$string;
					$placeholder = $index;	
				}
				else
				{
					$short = substr($line, 0, $pos+1);
					$string = $short."\n";
					$newText= $newText.$string;
					$placeholder = $placeholder + $pos+1;
					$index = $placeholder + $pos+1;
				}
			}
		}


		
		$string = substr($text, $placeholder, $length+1);
		$newText = $newText.$string;
		
		return $newText;
	}
	
	/**
	* @ignore
	* Function to key words that will be high lighted in red
	*/
	
	function add_keys($keys)
	{
		$this->keys = $keys;
	}
	
	/**
	* @ignore
	* Function to replace a description box and high light text red based on the key words stored
	*/
	
	function createDescriptionBox_withRedText()
	{
		$this->text = $this->add_brackets($this->text, $this->keys);
	
		$this->frame = $this->redText($this->frame, $this->keys, $this->text, 100, $this->size, $this->angle, $this->font);
	
	
	
	}
	
	/**
	* @ignore
	* Function to add brackets around key words -> [key word]
	*/
	
	function add_brackets($text, $keys) //$keys is a string ie: "key1 key2"
	{
		
		$keys = preg_split("/ /",$keys);	// -1, PREG_SPLIT_OFFSET_CAPTURE ); // add to get position of the start of each word
		
		$keys = array_unique($keys,SORT_STRING); //Get rid of multiple keyterms entered by the user to get rid of multiple brackets.
	
		for ( $x = 0; $x < sizeof($keys) ; $x++)
		{
			$string = "[" . $keys[$x] . "]"; 
			//$string = "[<font color='red'>" . $keys[$x] . "</font>]"; 
			$new_keys[$x] = $string;
		}

		return str_replace($keys, $new_keys, $text);

	}
	
	/**
	* @ignore
	* Function that adds the red text to the image. Red text is basically overlayed over black text. 
	*/
	

	function redText($im, $keys, $input_text, $width, $text_size, $text_angle, $text_font)
	{
		$red = imagecolorallocate($im, 255, 0, 0);
		
		//$text = add_brackets($text, $keys); 
		$keys = preg_split("/ /",$keys);
		
		$text = $input_text;
		$width_bbox = $width;
		$size = $text_size;
		$angle = $text_angle;
		$font = $text_font;
		
		$placeholder = 0;
		$index2 = 0;
		$X = 12;
		$Y = 28;
		
		for($index = 0; $index < (strlen($text)); $index++)
		{
			$length = $index-$placeholder;
			$line = substr($text, $placeholder, $length);
			$bbox = imagettfbbox($size, $angle, $font, $line);
			if($bbox[2] > $width_bbox-$rightMarginPadding)
			{
			
				$pos = 0;
				for($i =0; $i < strlen($line); $i++)
				{
					if($line[$i] == " ")
					{ 
						$pos = $i; 
					}
				}
			
				if ($pos == 0) 
				{ // note: three equal signs. Not found...
					$line = substr($text, $placeholder, $length);
					$string = $line."\n";
					$newText= $newText.$string;
					$placeholder = $index;	
					$array[$index2] = $string;
					//echo $newText;
					
				}
				else
				{
				    //echo $pos; echo "<br>";
					$short = substr($line, 0, $pos+1);
					$string = $short."\n";
					$newText= $newText.$string;
					$placeholder = $placeholder + $pos+1;
					$index = $placeholder + $pos+1;
					$array[$index2] = $string;
					//echo $short; echo "<br>";
					//echo $string; echo "<br>";
					//echo $newText; echo "<br>";
					//echo $placeholder; echo "<br>";
					//echo $index; echo "<br>";
					
				
				}
				
				imagefttext($im, 12, 0, $X, $Y, $black, $font, $array[$index2] );
				
				for ( $x = 0; $x < sizeof($keys) ; $x++)
				{
					if (strpos($array[$index2],$keys[$x]) !== false) {
						$pos = strpos($array[$index2],$keys[$x]);
						$newString = substr($array[$index2], 0 , $pos);
						$bbox = imagettfbbox(12, 0, $font, $newString);
						
						if($pos > 6)
						{	$r = 2;}
						elseif($pos > 5)
						{	$r = 1.8; }
						else{ $r = 2;}
						
						imagefttext($im, 12, 0, $X+$bbox[4]+$r, $Y, $red, $font, $keys[$x]);
						//imagefttext($im, 12, 0, 200, $Y, $red, $font, $pos);
					}
				}

				$Y+=23;
				$index2++; 
			}
		
		}
		
		$array[$index2] = substr($text, $placeholder, $index-$placeholder);
		imagefttext($im, 12, 0, $X, $Y, $black, $font, $array[$index2] );
		/*
		for ( $x = 0; $x < sizeof($keys) ; $x++)
		{
			if (strpos($array[$index2],$keys[$x]) !== false) {
				$pos = strpos($array[$index2],$keys[$x]);
				

				$len = strlen($keys[$x]);
				
				if( substr($array[$index2] , $pos,1) == "[" && substr($array[$index2] , ($pos+1)+$len,1) == "]")
				{ 
					$newString = substr($array[$index2], 0 , $pos);
					$bbox = imagettfbbox(12, 0, $font, $newString);
					
					if($pos > 7)
					{	$r = 1.8;}				
					elseif($pos > 6)
					{	$r = 2;}
					elseif($pos > 5)
					{	$r = 1.8; }
					else{ $r = 2;}
					
					imagefttext($im, 12, 0, $X+$bbox[4]+$r, $Y, $red, $font, $keys[$x]);
					//imagefttext($im, 12, 0, 200, $Y, $red, $font, $pos);
				}
			}
		}*/
		$pos = 0;
		$start = 0;
		
		for ( $x = 0; $x < sizeof($keys) ; $x++)
		{
			if (strpos($array[$index2],$keys[$x]) !== false) {
				$pos = strpos($array[$index2],$keys[$x]);
				$newString = substr($array[$index2], 0 , $pos);
				$bbox = imagettfbbox(12, 0, $font, $newString);
				
				if($pos > 6)
				{	$r = 2;}
				elseif($pos > 5)
				{	$r = 1.8; }
				else{ $r = 2;}
				
				imagefttext($im, 12, 0, $X+$bbox[4]+$r, $Y, $red, $font, $keys[$x]);
				//imagefttext($im, 12, 0, 200, $Y, $red, $font, $pos);
			}
		}

		
		
		

		$string = substr($text, $placeholder, $length+1);
		$newText = $newText.$string;
		
		//print_r($array);
		//print_r($input_text);
		return $im;
	}
	
}

/* CHECK FOR SPACES 

$text=" hello worlds";

$pos = 7;

//echo substr($text, 0, $pos);

echo strlen("worlds");

$str= substr($text, $pos-1,1);

echo $str;

if( substr($text, $pos-1,1) !== " " && substr($text, $pos-1,1) !== " ")
{ echo  " not a space ";}
else
{
  echo " there's a space ";}

$str= substr($text, ($pos-1)+6,1);

echo $str;
  
 if( substr($text, ($pos-1)+6,1) !== " ")
{ echo  " not a space ";}
else
{
  echo " there's a space ";}
  




*/

// $myDBox = new DescriptionBox();
// $myDBox->setText($dBox['text'],$dBox['font'], $dBox['size'], $dBox['textColor']);
// $myDBox->setColoredCanvas($dBox['width'],$dBox['height'], $dBox['canvasColor']);
// $myDBox->createFrame();
// //$myDBox->createDescriptionBox();
// $myDBox->createDescriptionBox_withRedText();


// $myCard = new Card($myDBox->getFrame());
// $myCard->saveCard('description.png');
