<?php

/**
* An instance of this class represents a card. 
* 
* <code>
*
* require_once('class_Frame.php');
* require_once('class_Text.php');
* require_once('class_DescriptionBox.php');
* 
* </code>
* 
* @author Juan A Hernandez <JuHernandez@csumb.edu>
*/

class Card
{
	/**
	* @ignore
	*/
	var $baseLayer;
	/**
	* @ignore
	*/
	var $width;
	/**
	* @ignore
	*/
	var $height;

	function __construct($image)
	{
	
		$this->baseLayer = $image; 
		imageSaveAlpha($this->baseLayer, true);
		imageAlphaBlending($this->baseLayer, false);
		//$this->width = imagesx($baseLayer);
		//$this->height = imagesy($baseLayer);
	
	}
	
	/*function made for testing purposes: probably useless now.
	function display()
	{
		imagepng($this->baseLayer, 'card.png',0);
		$card = "http://test.d0x3d.com/new/graphics_engine/card.png";
		header('Location: '.$card);
	}*/
	
	/**
	* Function that saves the image to the specified filename path
	* @param string $filename file name path
	*/
	function saveCard($filename)
	{
		imagepng($this->baseLayer, $filename,0);
	
	}
	
	/**
	* Function attempts to change image to a 300x300 dpi image for better print quality.
	* @param string $input input image path/filename
	* @param string #output output image path/filename
	*/
	
	function createForPrint($input, $output)
	{
	
		$input_file = $input;
		$output_file = $output;

		$input = imagecreatefrompng($input_file);
		list($width, $height) = getimagesize($input_file);
		$output = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($output,  255, 255, 255);
		imagefilledrectangle($output, 0, 0, $width, $height, $white);
		imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
		imagejpeg($output, $output_file);
		
		$this->changeDPI($output_file);
	
	}
	
	/**
	 * @ignore
	* Function attempts to change image to a 300x300 dpi image for better print quality.
	* @param string $output_file saves the image with new dpi to specified output path/filename
	*/
	function changeDPI($output_file)
	{
	
		$path = $output_file;


		$image = file_get_contents($path);

		$image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

		header("Content-type: image/jpeg");
		header('Content-Disposition: attachment; filename="'.basename($path).'"');

		//imagejpeg($output, $path);
	
	}
	
	/**
	* Function that adds an element to a card instance
	* @param resource $image image resource created from the Frame, Text, or Description Text.
	* @param int $x x-coordinate for where to place image
	* @param int $y y-coordinate for where to place image
	* @param int $transparency sets transparency level. 0-100. Default is 0, or no transparency.
	* @param $target_alpha [Optional] Default: true. Set the target image's flag  to save full alpha channel information
	* @param $target_blending [Optional] Default: true. Set the flag to save blending for target image. If true, GD blends the existing color at that point with the drawing color, and stores the result in the image.
	* @param $alpha [Optional] Default: true. Set the alpha flag for source image.
	* @param $blending [Optional] Default: true. Set the blending flag for source image.
	* 
	*/
	
	function addElement($image, $x, $y, $transparency = 0, $target_alpha = true, $target_blending = true, $alpha = true, $blending = true )
	{
		
		$width = imagesx($image);
		$height = imagesy($image);
		
		
		imageSaveAlpha($image, $alpha);								//true
		imageAlphaBlending($image, $blending);						//true
		
		imagealphablending($this->baseLayer, $target_alpha);		//true
		imagealphablending($this->baseLayer, $target_blending);		//true
		
		
		imagecopy($this->baseLayer, $image, $x, $y, 0, 0, $width, $height);
		//imagecopymerge($this->baseLayer, $image, 0, 0, 0,0, $width,$height, $transparency);
		//imagecopymerge($this->border, $this->canvas, $this->border_thickness+0, $this->border_thickness+0, 0,0, $this->width-$this->border_thickness*2, $this->height-$this->border_thickness*2, 70);
	
	}
	
	/**
	 * @ignore
	* Function add round corners to card image.
	* @param int $radius set the radius for the corners
	*/
	 function roundCorners($radius)
	{
		imagesavealpha($this->baseLayer, false);

		$cardX = imagesx($this->baseLayer);
		$cardY = imagesy($this->baseLayer);

		$frame = imagecreatetruecolor($cardX, $cardY);
		//imagesavealpha($frame, true);
		//imagealphablending($frame, true);
		//colors
		$magentabackground = imagecolorallocate($frame, 255,0,255);
		$blackbackground = imagecolorallocate($frame, 0,0,0);
		imagefill($frame,0,0, $magentabackground);
		
		//***************************************************************************/
		//Creates a sillhouetted image with round corners from the original image
		/****************************************************************************/
		$x = $radius;
		$y = $x;
		$w = ($x*2+1); 
		$h = $w;
		imagefilledarc($frame, $x, $y, $w, $h,  0, 360, $blackbackground, IMG_ARC_PIE);
		imagefilledarc($frame, $cardX-($x+1), $y, $w, $h,  0, 360, $blackbackground, IMG_ARC_PIE);
		imagefilledarc($frame, $cardX-($x+1), $cardY-($y+1), $w, $h,  0, 360, $blackbackground, IMG_ARC_PIE);
		imagefilledarc($frame, $x, $cardY-($y+1), $w, $h,  0, 360, $blackbackground, IMG_ARC_PIE);
		$layer1 = imagecreatetruecolor($cardX -$w, $cardY);
		imagefill($layer1,0,0, $blackbackground);
		$layer2 = imagecreatetruecolor($cardX, $cardY-$h);
		imagefill($layer2,0,0, $blackbackground);
		
		imagecopy($frame, $layer1,$x,0,0,0, imagesx($layer1),imagesy($layer1));
		imagecopy($frame, $layer2,0,$y,0,0, imagesx($layer2),imagesy($layer2));
		
		$index = imagecolorexact($frame, 0,0,0);
		imagecolortransparent($frame,$index);
		/*******************************************************************************/
		
		//Merges the sillhouette frame with the original image 
		imagecopymerge($this->baseLayer, $frame, 0,0,0,0,$cardX,$cardY,100);
		
		//Apply transparency
		$trans = imagecolorexact($this->baseLayer, 255,0,255);
		imagecolortransparent($this->baseLayer,$trans);

		//Saves the altered image with added corners
		//imagepng($this->baseLayer, $path.'.png', 0);
		//imagedestroy($this->baseLayer);
		//imagesavealpha($this->baseLayer, true);
		//imagepng($frame, 'round.png');
		imagedestroy($frame);
		
	}
	
	//Adds round corners to an image


}


/*testing code

$new_image = imagecreatetruecolor(160,230);
imagesavealpha( $new_image, true );
$rgb = imagecolorallocatealpha( $new_image, 250,150,250, 0);
imagefill( $new_image, 0, 0, $rgb );

$myCard = new Card($new_image);
$myCard->roundCorners(12);
$myCard->saveCard('rounderCorners.png');*/


