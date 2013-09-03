<?php if(!defined('BASEPATH')) exit('no direct scripting allowed');

class Images{

	public function __construct(){
		$this->CI = & get_instance();
		$this->CI->load->library('image_lib');
	}

	public function cropToSquare($source,$base_width,$base_height,$dest = FALSE){
		// $config['image_library'] = 'gd2';
		$config['source_image'] = $source;
		$config['maintain_ratio'] = FALSE;
		if($dest):
			$config['new_image'] = $dest;
		endif;
		list($width,$height,$type) = getimagesize($source);
		$config['x_axis'] = 0; $config['y_axis'] = 0;
		if($width > $base_width):
			$this->resizeImage($source,$base_width,$base_height);
		elseif($height > $base_height):
			$this->resizeImage($source,$base_width,$base_height,'height');
		endif;
		list($width,$height,$type) = getimagesize($source);
		if($width > $height):
			$config['x_axis'] = ($width/2)-($height/2);
			$config['width'] = $config['height'] = $height;
		elseif($width < $height):
			$config['y_axis'] = ($height/2)-($width/2);
			$config['width'] = $config['height'] = $width;
		endif;
		$this->CI->image_lib->initialize($config);
		if(!$this->CI->image_lib->crop()):
			$this->CI->image_lib->clear();
			return FALSE;
		else:
			$this->CI->image_lib->clear();
			return TRUE;
		endif;
	}
	
	function crop_to_ratio($source, $width, $height, $x = 4, $y = 3, $dest = FALSE){
	// $config['image_library'] = 'gd2'; 
	$config['source_image'] = $source;
	$config['maintain_ratio'] = FALSE;
	if($dest):
		$config['new_image'] = $dest;
	endif;
	$result = array();
	if($width < $height):
		$long = $height;
		$short = $width;
		$xa = 'y';
		$ya = 'x';
		$long_side = 'height';
		$short_side = 'width';
	else:
		$long = $width;
		$short = $height;
		$xa = 'x';
		$ya = 'y';
		$long_side = 'width';
		$short_side = 'height';
	endif;
	if($long != (($short * $x) / $y)):
		if(($long / $short) > ($x / $y)):
			$new_long = ($short * $x) / $y;
			$dif = $long - $new_long;
			$config[$xa.'_axis'] = $dif / 2;
			$config[$ya.'_axis'] = 0;
			$config[$long_side] = $new_long + ($dif / 2);
			$config[$short_side] = $short;
			$result[$long_side] = $new_long;
			$result[$short_side] = $short;
		else:
			$new_short = ($long * $y) / $x;
			$dif = $short - $new_short;
			$config[$ya.'_axis'] = $dif / 2;
			$config[$xa.'_axis'] = 0;
			$config[$long_side] = $long;
			$config[$short_side] = $new_short + ($dif / 2);
			$result[$long_side] = $long;
			$result[$short_side] = $new_short;
		endif;
	else:
		$result['width'] = $width;
		$result['height'] = $height;
		return $result;
	endif;
	$this->ci->image_lib->initialize($config);
	if( ! $this->ci->image_lib->crop()):
		$this->ci->image_lib->clear();
		return FALSE;
	else:
		$this->ci->image_lib->clear();
		return $result;
	endif;
}
	
	public function resizeImage($source,$width,$height,$dim = 'width',$dest = FALSE){
		
		$config['source_image'] = $source;
		if($dest):
			$config['new_image'] = $dest;
		endif;
		$config['master_dim'] = $dim;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->CI->image_lib->initialize($config);
		if(!$this->CI->image_lib->resize()):
			$this->CI->image_lib->clear();
			return FALSE;
		else:
			$this->CI->image_lib->clear();
			return TRUE;
		endif;
	}
}
?>