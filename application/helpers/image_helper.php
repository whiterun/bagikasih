<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function resize_photo($src, $dst, $length, $length_type = "auto")
{
	$CI =& get_instance();
	$CI->load->library('image_lib');
	$image_lib_config['quality'] = "80%";
	$image_lib_config['image_library'] = 'gd2';
	$image_lib_config['create_thumb'] = FALSE;
	$image_lib_config['maintain_ratio'] = TRUE;
	
	list($width, $height, $type, $attr) = getimagesize($src);
	if($length_type == "auto")
	{
		if($width > $height) $length_type = "width";
		else $length_type = "height";
	}
	if($width > $height)
	{
		// width is bigger than height
		$hr = 1;
		$wr = $width / $height;
	}
	else
	{
		// height is bigger than width
		$wr = 1;
		$hr = $height / $width;
	}
	
	
	if($length_type == "width")
	{
		$image_lib_config['width'] = $length;
		$image_lib_config['height'] = $length * ($hr/$wr);
	}
	if($length_type == "height")
	{
		$image_lib_config['height'] = $length;
		$image_lib_config['width'] = $length * ($wr/$hr);
	}
	/*echo "x_axis: {$image_lib_config['x_axis']} y_axis: {$image_lib_config['y_axis']} w: {$image_lib_config['width']} h: {$image_lib_config['height']}<br />";*/
	$image_lib_config['source_image'] = $src;
	$image_lib_config['new_image'] = $dst;
	
	$CI->image_lib->initialize($image_lib_config);
	$CI->image_lib->watermark();
	$CI->image_lib->resize();
	echo $CI->image_lib->display_errors();
	$CI->image_lib->clear();
}

function crop_photo($src,$dst,$tw,$th)
{
	$CI =& get_instance();
	$CI->load->library('image_lib');
	$image_lib_config['quality'] = "80%";
	$image_lib_config['image_library'] = 'gd2';
	$image_lib_config['create_thumb'] = FALSE;
	$image_lib_config['maintain_ratio'] = FALSE;
	list($width, $height, $type, $attr) = $sizes = getimagesize($src);
	if($tw >= $width && $th >= $height) { copy($src,$dst); return; }
	$x = $y = 0;
	if($width >= $tw)
	{
		$x = ($width - $tw) / 2;
	}
	if($height >= $th)
	{
		$y = ($height - $th) / 2;
	}
	if($tw > $width) $tw = $width;
	if($th > $height) $th = $height;
	$image_lib_config['x_axis'] = $x;
	$image_lib_config['y_axis'] = $y;
	$image_lib_config['width'] = $tw;
	$image_lib_config['height'] = $th;
	$image_lib_config['source_image'] = $src;
	$image_lib_config['new_image'] = $dst;

	$CI->image_lib->initialize($image_lib_config);
	if ( ! $CI->image_lib->crop())
	{
		echo $CI->image_lib->display_errors();
	}
	$CI->image_lib->clear();
	
}
?>