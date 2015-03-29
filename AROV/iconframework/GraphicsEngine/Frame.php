<?php

//require 'Card.php';

require 'gradients.php';

class Frame
{
	/**
	* @ignore
	* Variable declarations 
	*/
	var $frame;
	/**
	* @ignore
	*/	
	var $canvas;
	/**
	* @ignore
	*/	
	var $border;

	/**
	* @ignore
	* Canvas Attributes
	*/
	var $width;
	/**
	* @ignore
	*/	
	var $height;
	
	/**
	* @ignore
	*/	
	var $canvas_color;
	/**
	* @ignore
	*/	
	var $canvas_opacity;
	
	/**
	* @ignore
	*/	
	var $cavas_image_path;
	
	/**
	* @ignore
	*/	
	var $gradient_color_1;
	/**
	* @ignore
	*/	
	var $gradient_color_2;
	/**
	* @ignore
	*/	
	var $direction;
	
	/**
	* @ignore
	* Choices
	*/
	var $ifColoredCanvas;
	/**
	* @ignore
	*/	
	var $ifGradientCanvas;
	/**
	* @ignore
	*/	
	var $ifImageCanvas;
	
	/**
	* @ignore
	*/	
	var $border_thickness;
	/**
	* @ignore
	*/	
	var $border_color;
	/**
	* @ignore
	*/	
	var $border_opacity;
	/**
	* @ignore
	*/	
	var $border_image_path;
	/**
	* @ignore
	*/	
	var $border_gradient_color_1;
	/**
	* @ignore
	*/	
	var $border_gradient_color_2;
	
	/**
	* @ignore
	*/	
	var $borderIsSet;
	/**
	* @ignore
	*/	
	var $ifColoredBorder;
	/**
	* @ignore
	*/	
	var $ifImageBorder;
	/**
	* @ignore
	*/	
	var $ifGradientBorder;

	 /**
	 * @ignore
	 * Constructor that sets the defaults at creation of object. 
	 * Type of image resource can be created based on the arguments provided.
	 */

	function __construct()
	{
	
		$args = func_num_args();
		$arg_list = func_get_args();
		
		
		if ($args == 0)
		{
			//Do nothing
		}
		else if($args <= 2)
		{
			trigger_error("Too little arguments passed for setting attributes. Frame onstructor requires either none, or least 3 arguments. Please see Frame Class documentation.", E_USER_NOTICE);
			echo "<br>";
		}
		else if($args == 3)
		{
			
			$this->setDefaults();
			
			if($args==3 && is_array($arg_list[2]) == true)
			{
				$this->setColoredCanvas($arg_list[0], $arg_list[1], $arg_list[2]);
			
			}
			else if($args==3 && is_string($arg_list[2]) == true)
			{
				$this->setImageCanvas($arg_list[0], $arg_list[1], $arg_list[2]);
			
			}

		}
		else if($args == 4)
		{
			$error = "One too little, or too many arguments in Frame constructor. Please see Frame Class documentation.";
			trigger_error($error , E_USER_NOTICE);
		}
		else if($args == 5)
		{
			$this->setDefaults();
				
			$this->setGradientCanvas($arg_list[0],$arg_list[1],$arg_list[2],$arg_list[3],$arg_list[4]);
		}
		else
		{
			$error = "Too many arguments in Frame constructor. Please see Frame Class documentation.";
			trigger_error($error , E_USER_NOTICE);
		
		}

	}
	
	 /**
	 * @ignore
	 * Sets the defaults for the Frame object.
	 */
	function setDefaults()
	{	
	
		$this->height = 242;
		$this->width = 338;
		
		$this->canvas_color = array(255,255,255);
		$this->canvas_opacity = 0;
		$this->canvas_image_path = "";
		$this->gradient_color_1 = array(0,0,0);
		$this->gradient_color_2 = array(255,255,255);
		
		$this->ifColoredCanvas = false;
		$this->ifGradientCanvas = false;
		$this->ifImageCanvas = false;
		
		$this->border_thickness = 0;
		$this->border_color = array(0,0,0);
		$this->border_opacity = 0;
		$this->border_image_path = "";
		$this->border_gradient_color_1 = '#000';	// Gradient colors are in hex format 
		$this->border_gradient_color_2 = '#fff';	
		
		$this->borderIsSet = false;
		$this->ifColoredBorder = false;
		$this->ifImageBorder = false;
		$this->ifGradientBorder= false;
		
		//echo "defaults have been set<br>";

	}
	
	 /**
	 * Function to set the attributes of a colored image
	 * @param int $width Sets width of the canvas
	 * @param int $height Sets height of the canvas
	 * @param array $color Sets the rgb values from 0-255 for red, green, and blue. ie array(255,255,255) for white. 
	 * 
	 * <code>
	 * //This will create a Frame image resource that is 100x100 and is green.
	 * 
	 * $myframe = new Frame();
	 * $myframe->setColoredCanvas(100,100, array(0,255,0));
	 * 
	 * //Shorthand
	 * 
	 * $myframe = new Frame(100,100, array(0,255,0));
	 * 
	 * </code>
	 * 
	 */
	
	function setColoredCanvas($width, $height, $color)
	{	
		
		$this->width = $width;
		$this->height = $height;
		$this->canvas_color = $color;
		$this->canvas_opacity = (isset($color[3]) ? $color[3] : 0);
		$this->ifColoredCanvas = true;
		$this->ifImageCanvas = false;
		$this->ifGradientCanvas = false;
		
    }
    
   	 /**
	 * Function to set the attributes of a colored image
	 * @param int $width Sets width of the canvas
	 * @param int $height Sets height of the canvas
	 * @param string $image_path Creates an image from provided image file path. Accepted Formats: PNG, JPEG, and GIF.
	 * 
	 * <code>
	 * //This will create a Frame image resource from an image path specified
	 * 
	 * $myframe = new Frame();
	 * $myframe->setImageCanvas(100,100, 'myimage.png');
	 * 
	 * //Shorthand
	 * 
	 * $myframe = new Frame(100,100, 'myimage.png');
	 * 
	 * </code>
	 * 
	 */
	
	function setImageCanvas($width, $height, $image_path)
	{	
		
		$this->width = $width;
		$this->height = $height;
		$this->canvas_image_path= $image_path;
		$this->ifColoredCanvas = false;
		$this->ifImageCanvas = true;
		$this->ifGradientCanvas = false;
	}
	
   	 /**
	 * Function to set the attributes of a colored image
	 * @param int $width Sets width of the canvas
	 * @param int $height Sets height of the canvas
	 * @param string $direction Set the direction of the gradient. Can be : vertical, horizontal, rectangle (or square), ellipse, ellipse2, circle, circle2, diamond.
	 * @param string $color Sets the startcolor in 3 or 6 digits hexadecimal. ie '#ffffff' for white.
	 * @param string $color Sets the endcolor 3 or 6 digits hexadecimal. ie '#ff000' for red. 
	 * 
	 * <code>
	 * //This will create a Frame image resource with a gradient
	 * 
	 * $myframe = new Frame();
	 * $myframe->setGradientCanvas(100,100, 'horizontal', '#000000','#ffffff');
	 * 
	 * //Shorthand
	 * 
	 * $myframe = new Frame(100,100, 'horizontal', '#000000','#ffffff');
	 * 
	 * </code>
	 * 
	 */
	 
	function setGradientCanvas($width, $height, $direction, $first_color, $second_color)
	{
		$this->width = $width;
		$this->height = $height;
		$this->direction = $direction;
		$this->gradient_color_1 = $first_color;
		$this->gradient_color_2 = $second_color;
		$this->ifImageCanvas = false;
		$this->ifColoredCanvas = false;
		$this->ifGradientCanvas = true;
	}
	 /**
	 * @ignore
	 * Function to set the border attributes of an image
	 */
	
	function setBorder()
	{
	
		$args = func_num_args();
		$arg_list = func_get_args();
		
		if($args <= 1)
		{
			trigger_error("Too little arguments passed. setBorder function requires at least 3 arguments. Please see Frame Class documentation.", E_USER_NOTICE);
			echo "<br>";
		}
		else if($args > 3)
		{

			$error = "Too many arguments in setBorder function. Please see Frame Class documentation.";
			trigger_error($error , E_USER_NOTICE);
		}
		else
		{
			
			if($args==2 && is_array($arg_list[1]) == true)
			{
				$this->setColoredBorder($arg_list[0], $arg_list[1]);
			
			}
			else if($args==2 && is_string($arg_list[1]) == true)
			{
				$this->setImageBorder($arg_list[0],$arg_list[1]);
			
			}
			// elseif($args == 4)
			// {
				// $this->createGradientCanvas($arg_list);
				
			// }
		}

	}
	
	 /**
	 * Function to set attributes for a colored border
	 * @param int $thickness Set thickness of border
	 * @param array $color Sets the rgb values from 0-255 for red, green, and blue. ie array(255,255,255) for white. 
	 */
	
	function setColoredBorder($thickness, $color)
	{
	
		$this->border_thickness = $thickness;
		$this->border_color = $color;
		$this->border_opacity = (isset($color[3]) ? $color[3] : 0);
		$this->borderIsSet = true;
		$this->ifColoredBorder = true;
		$this->ifImageBorder = false;
		$this->ifGradientBorder= false;

	}
	
	 /**
	 * Function to set attributes for a frame border based off an image
	 * @param int $thickness Set thickness of border
	 * @param string $path Set the path of an image to be used as a frame border
	 */
	
	function setImageBorder($thickness, $path)
	{
	
		$this->border_thickness = $thickness;
		$this->border_image_path = $path;
		$this->borderIsSet = true;
		$this->ifImageBorder = true;
		$this->ifColoredBorder = false;
		$this->ifGradientBorder= false;

	}
	
	/**
	 * @ignore
	 * Function to set the attributes of a colored image
	 * @param int $width Sets width of the canvas
	 * @param int $height Sets height of the canvas
	 * @param string $direction Set the direction of the gradient. Can be : vertical, horizontal, rectangle (or square), ellipse, ellipse2, circle, circle2, diamond.
	 * @param string $color Sets the startcolor in 3 or 6 digits hexadecimal. ie '#ffffff' for white.
	 * @param string $color Sets the endcolor 3 or 6 digits hexadecimal. ie '#ff000' for red. 
	 */
	
	function createColoredImage($image, $width, $height, $color, $opacity = 0)
	{	

			//echo "created colored canvas";
			
			$image = imagecreatetruecolor($width, $height);	
			
			imageSaveAlpha($image, true);
			ImageAlphaBlending($image, false);

			
			$background_color = imagecolorallocatealpha($image, $color[0],$color[1],$color[2], $opacity);
			imagefill($image, 0,0, $background_color);
			
			return $image;
    }
    
	 /**
	 * @ignore
	 * Function to create a Frame image resource from an image path.
	 */
	
	function createImageFromPath($image, $width, $height, $path)
	{	




		//echo "created image canvas<br>";
		//echo $width."<br>";
		//echo $height." - height<br>";
		//echo $path." - path<br>";
		
		$image = imagecreatetruecolor($width, $height);	
		
		//echo "path: ";
		//echo $path ;
		//echo "\n";
		
		//$imageFromPath = imagecreatefrompng($path);

		$image_info = getimagesize($path);
		$image_type = $image_info[2];
		
		//print "image type: ";
		//print $image_type;

		if( $image_type == IMAGETYPE_JPEG ) {

			//echo "image is a JPEG";
		 $imageFromPath = imagecreatefromjpeg($path);
		 
		} elseif( $image_type == IMAGETYPE_GIF ) {
			//echo "image is a GIF";

		$imageFromPath = imagecreatefromgif($path);
		
		}
		
		/* //GD doesn't support bitmaps so still looking for a 'createimagefrombmp' function on the net
		elseif( $image_type == IMAGETYPE_BMP ) {
		  echo "image is a BMP";

		$imageFromPath = $imagecreatefromwbmp($path);

		}*/ 
		
		elseif( $image_type == IMAGETYPE_PNG ) {

			$imageFromPath = imagecreatefrompng($path);
		
			imageSaveAlpha($image, false);			// Allows png to keep transparency
			ImageAlphaBlending($image, false);		//
		}
	
		
		 
		$image_width = imagesx($imageFromPath);
		$image_height = imagesy($imageFromPath);
		

		
		$this->background = imagecreatetruecolor($width, $height);
		imagecopyresampled($image, $imageFromPath, 0, 0, 0, 0,$width, $height, $image_width, $image_height );
		
		//imagecopyresampled($new_image, $this->getFrame(), 0, 0, 0, 0, $width, $height, $this->width, $this->height);
		
		return $image;
			
    }
    
	 /**
	  * @ignore
	 * Function to create a Frame image resource with a gradient 
	 */
	
	function createGradientCanvas($width, $height, $direction, $first_color, $second_color)
	{	
		$image = new gd_gradient_fill($width, $height, $direction, $first_color, $second_color);
		return $image->getImage();
	}
	
	 /**
	 * Function to create a Frame image resource depending on the image type created at object creation
	 * Tyes: colored canvas, from image path, or gradient. 
	 * 
	 * Can be called again to refresh any changes made by set methods.
	 */

	function createFrame()
	{
		
		if($this->ifColoredCanvas)
		{

			$this->canvas =  $this->createColoredImage($this->canvas, $this->width, $this->height, $this->canvas_color, $this->canvas_opacity);
			
			if($this->borderIsSet)
			{
			
				if($this->ifColoredBorder)
				{
				
					$this->border = $this->createColoredImage($this->border, $this->width, $this->height, $this->border_color, $this->border_opacity);
				}
				
				$this->frame = $this->mergeImages();
				return;
			
			}
			$this->frame = $this->canvas;
			return;

		}
		else if($this->ifImageCanvas)
		{
			$this->canvas = $this->createImageFromPath($this->canvas, $this->width, $this->height, $this->canvas_image_path);
			
			if($this->borderIsSet)
			{
			
				if($this->ifColoredBorder)
				{
				
					$this->border = $this->createColoredImage($this->border, $this->width, $this->height, $this->border_color, $this->border_opacity);
				}
				else if(ifImageBorder)
				{
					$this->border = $this->createImageFromPath($this->border, $this->width, $this->height, $this->border_image_path);
				
				}
				
				$this->frame = $this->mergeImages();
				return;
			
			}
			$this->frame = $this->canvas;
			return;

		}
		else if($this->ifGradientCanvas)
		{
			$this->canvas = $this->createGradientCanvas($this->width, $this->height, $this->direction, $this->gradient_color_1, $this->gradient_color_2);
			
			if($this->borderIsSet)
			{
			
				if($this->ifColoredBorder)
				{
				
					$this->border = $this->createColoredImage($this->border, $this->width, $this->height, $this->border_color, $this->border_opacity);
				}
				else if(ifImageBorder)
				{
					$this->border = $this->createImageFromPath($this->border, $this->width, $this->height, $this->border_image_path);
				
				}
				
				$this->frame = $this->mergeImages();
				return;
			
			}
			$this->frame = $this->canvas;
			return;

		}
		
		
		
		
		
	}
	
	 /**
	 * Function to resize an image resource to specified width and height
	 * @param int $width Sets new width
	 * @param int $height Sets new height
	 */

	function resize($width,$height) 
	{

		$new_image = imagecreatetruecolor($width, $height);
		imageSaveAlpha($new_image, false);			// Allows png to keep transparency
		ImageAlphaBlending($new_image, false);
		imagecopyresampled($new_image, $this->getFrame(), 0, 0, 0, 0, $width, $height, $this->width, $this->height);

		$this->width = $width;
		$this->height = $height;


		$this->frame = $new_image;
	} 
	
	 /**
	 * Function to scale an image
	 * @param int $scale Set the percentage to scale the image by. 100 is 100%, or original size. 
	 */
	function scale($scale) {
	  $width = $this->width * $scale/100;
	  $height = $this->height * $scale/100;
	  $this->resize($width,$height);
	}
	
	//with imagecopyresampled
	/*
	function crop($width, $height, $dst_x, $dst_y, $src_x, $src_y) {
		
		//imagepng($this->getFrame(), 'test_picture.png');
		
		$new_image = imagecreatetruecolor($width, $height);
		imagesavealpha( $new_image, true );
		$rgb = imagecolorallocatealpha( $new_image, 255, 0, 255, 127);
		imagefill( $new_image, 0, 0, $rgb );
	  
		imagecopyresampled($new_image, $this->getFrame(), $dst_x, $dst_y, $src_x, $src_y, $width, $height, $width-$src_x, $height-$src_y);
		
		
		
		$this->frame = $new_image;
	}*/
	
	 /**
	  * @ignore
	 * Function to crop an image
	 * @param int $dst_width Define the width of the destination image 
	 * @param int $dst_height Define the height of the destination image 
	 * @param int $src_width Define the width of the source image 
	 * @param int $src_height Define the height of the course image 
	 * @param int $dst_x X coordinate for the destination
	 * @param int $dst_x X coordinate for the destination
	 * @param int $src_x X coordinate for the source
	 * @param int $src_x X coordinate for the source
	 * 
	 * @todo Re-design function to have less parameters
	 * 
	 */

	function crop($dst_width, $dst_height, $src_width, $src_height, $dst_x, $dst_y, $src_x, $src_y) {
	
		//imagepng($this->getFrame(), 'test_picture.png');
		
		$new_image = imagecreatetruecolor($dst_width, $dst_height);
		imagesavealpha( $new_image, true );
		$rgb = imagecolorallocatealpha( $new_image, 255, 0, 255, 127);
		imagefill( $new_image, 0, 0, $rgb );
		
		
		if($src_y<0)
		{
			$dst_y -= $src_y;
			$src_y -= $src_y;
			$new_src_height = $src_height + $new_src_y; 
		}
		else
		{
			$new_src_y = $src_y;
			$new_src_height = $src_height - $new_src_y; 
		}
		
		
	  
		imagecopy($new_image, $this->getFrame(), $dst_x, $dst_y, $src_x, $src_y, $src_width-$src_x, $new_src_height);
		
		
		
		$this->frame = $new_image;
	}
	
	 /**
	  * @ignore
	 * Function to merge border and canvas images. 
	 */
	
	function mergeImages()
	{
		imageSaveAlpha($this->canvas, true);
		
		//imageSaveAlpha($this->border, true);
		imagealphablending($this->border, true);
		imagecopy($this->border, $this->canvas, $this->border_thickness+0, $this->border_thickness+0, 0, 0, $this->width-$this->border_thickness*2, $this->height-$this->border_thickness*2);
		//imagecopymerge($this->border, $this->canvas, $this->border_thickness+0, $this->border_thickness+0, 0,0, $this->width-$this->border_thickness*2, $this->height-$this->border_thickness*2, 70);
		return $this->border;
	
	}
	
	 /**
	 * Function that returns a frame image resource 
	 */
	function getFrame()
	{
		$this->createFrame();
		return $this->frame;
	}
	
/*
	function imagecreatefrombmp( $filename ) {
		$file = fopen( $filename, "rb" );
		$read = fread( $file, 10 );
		while( !feof( $file ) && $read != "" )
		{
		$read .= fread( $file, 1024 );
		}
		$temp = unpack( "H*", $read );
		$hex = $temp[1];
		$header = substr( $hex, 0, 104 );
		$body = str_split( substr( $hex, 108 ), 6 );
		if( substr( $header, 0, 4 ) == "424d" )
		{
		$header = substr( $header, 4 );
		// Remove some stuff?
		$header = substr( $header, 32 );
		// Get the width
		$width = hexdec( substr( $header, 0, 2 ) );
		// Remove some stuff?
		$header = substr( $header, 8 );
		// Get the height
		$height = hexdec( substr( $header, 0, 2 ) );
		unset( $header );
		}
		$x = 0;
		$y = 1;
		$image = imagecreatetruecolor( $width, $height );
		foreach( $body as $rgb )
		{
		$r = hexdec( substr( $rgb, 4, 2 ) );
		$g = hexdec( substr( $rgb, 2, 2 ) );
		$b = hexdec( substr( $rgb, 0, 2 ) );
		$color = imagecolorallocate( $image, $r, $g, $b );
		imagesetpixel( $image, $x, $height-$y, $color );
		$x++;
		if( $x >= $width )
		{
		$x = 0;
		$y++;
		}
		}
		return $image;
	}*/
	
	function getW()
	{
		$this->createFrame();
		return $this->witdh;	
	}
	
	function getH()
	{
		$this->createFrame();
		return $this->height;	
	}


}


/*
$test2 = new Frame(242, 338, 'template_images/penguin-rf.png'); 
$test2->createFrame();


$myCard = new Card($test2->getFrame());
$myCard->saveCard('TYPE.png');
*/


