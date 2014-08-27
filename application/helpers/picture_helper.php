<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function save_photo($photo_name,$dir="",$sizes=array("600", "400", "200", "100", "200xcrops", "140xcrops", "65xcrops", "36xcrops", "144xcrops", "150xcrops", "300xcrops", "590x200"/*, "550xcrops"*/),$fixed_crop_sizes=NULL)
{
	$CI =& get_instance();
	
	if(trim($photo_name) == "" || trim($dir) == "") return FALSE;
	$photo_root_path = $_SERVER['DOCUMENT_ROOT']."/_assets/images/";
	$tmp_photo_root_path = $photo_root_path."temp/";
	$copy_photo_root_path = $photo_root_path.$dir."/";
	
	$tmp_file = $tmp_photo_root_path.$photo_name;
	$tmp_resize_file = $tmp_photo_root_path."resize_".$photo_name;
	
	if(!is_file($tmp_file)) return FALSE;
	else
	{
		$CI->load->helper("image");
		$fpath = $copy_photo_root_path;
		list($w, $h, $type, $attr) = getimagesize($tmp_file);
		
		/*
		$file_arr = explode(".",$photo_name,2);
		$ext = $file_arr[count($file_arr)-1];
		$random = random_string('alnum', 16);
		$newfile = time()."_".$random.".".$ext;
		//*/
		$newfile = $photo_name;
		
		//$sizes = array("600", "400", "200", "crops");
		//$sizes = array("600", "400", "200", "100", "200xcrops"/*, "cropped_80x65"*/);
		foreach($sizes as $size)
		{
			/*
			if($size == "cropped_80x65")
			{
				if($w >= 80 && $h >= 65)
				{
					$wx = doubleval($w/80); $hx = doubleval($h/65);
					if($h >= $w)
					{
						if(doubleval($h/$wx) >= 65)
						{
							$length_type = "width";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 80, $length_type);
						}
						else {
							$length_type = "height";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 65, $length_type);
						}
					}
					else {
						if(doubleval($w/$hx) >= 80)
						{
							$length_type = "height";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 65, $length_type);
						}
						else {
							$length_type = "width";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 80, $length_type);
						}
					}
				} 
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,80,65);
			}
			else //*/
			if($size == "200xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 200) resize_photo($tmp_file, $fpath.$size."/".$newfile, 200, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,200,200);
			}
			else if($size == "140xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 140) resize_photo($tmp_file, $fpath.$size."/".$newfile, 140, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,140,140);
			}
			else if($size == "65xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 65) resize_photo($tmp_file, $fpath.$size."/".$newfile, 65, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,65,65);
			}
			else if($size == "36xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 36) resize_photo($tmp_file, $fpath.$size."/".$newfile, 36, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,36,36);
			}
			else if($size == "144xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 144) resize_photo($tmp_file, $fpath.$size."/".$newfile, 144, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,144,144);
			}
			else if($size == "150xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 150) resize_photo($tmp_file, $fpath.$size."/".$newfile, 150, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,150,150);
			}
			else if($size == "300xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 300) resize_photo($tmp_file, $fpath.$size."/".$newfile, 300, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,300,300);
			}
			/*else if($size == "550xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 550) resize_photo($tmp_file, $fpath.$size."/".$newfile, 550, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,550,550);
			}*/
			else if($size == "590x200")
			{
				if($w >= 590 && $h >= 200)
				{
					$wx = doubleval($w/590); 
					$hx = doubleval($h/200);
					
					if($w >= $h)
					{
						if(doubleval($h/$wx) >= 200)
						{
							$length_type = "height";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 200, $length_type);
							
							crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,300,300);							
						}
						else 
						{
							$length_type = "width";
							resize_photo($tmp_file, $fpath.$size."/".$newfile, 590, $length_type);
						}
					}
				} 
				else copy($tmp_file, $fpath.$size."/".$newfile);
			}			
			else
			{
				if($w >= intval($size)) resize_photo($tmp_file, $fpath.$size."/".$newfile, $size, "auto");
				else copy($tmp_file, $fpath.$size."/".$newfile);
			}
		}
		
		//$size == "cropped_80x65"
		if($fixed_crop_sizes != NULL)
		{
			foreach($fixed_crop_sizes as $size)
			{
				$size_arr = explode("_",$size);
				$size_dim_arr = explode("x",$size_arr[1]);
				$dim_x = $size_dim_arr[0];
				$dim_y = $size_dim_arr[1];
				if(intval($size_dim_arr[0]) > 0 && intval($size_dim_arr[1]) > 0)
				{
					if($w >= $dim_x && $h >= $dim_y)
					{
						$wx = doubleval($w/$dim_x);
						$hx = doubleval($h/$dim_y);
						if($h >= $w)
						{
							if(doubleval($h/$wx) >= $dim_y)
							{
								$length_type = "width";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_x, $length_type);
							}
							else {
								$length_type = "height";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_y, $length_type);
							}
						}
						else {
							if(doubleval($w/$hx) >= $dim_x)
							{
								$length_type = "height";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_y, $length_type);
							}
							else {
								$length_type = "width";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_x, $length_type);
							}
						}
					} 
					else copy($tmp_file, $fpath.$size."/".$newfile);
					
					//crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,$dim_x,$dim_y);
				}
			}
		}
		
		copy($tmp_file, $fpath."originals/".$newfile);
		//copy($tmp_file, $copy_photo_root_path.$photo_name);
		if(is_file($tmp_file)) unlink($tmp_file);
		
		if(is_file($tmp_resize_file))
		{
			//copy($tmp_resize_file, $copy_photo_root_path."resize_".$photo_name);
			unlink($tmp_resize_file);
		}
		return $newfile;
	}
}

function get_photo_url($photo_name,$dir="",$dim="200xcrops",$no_default_img=FALSE)
{
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/_assets/images/' .$dir. '/';
	$targetFile =  str_replace('//','/',$targetPath) . $dim . '/' . $photo_name;
	if(!is_file($targetFile) || trim($photo_name) == "" || trim($dir) == "")
	{
		if($no_default_img) return;
		else {
			 $targetFile = $targetPath."none.png";
		}
	}
	
	$newTargetFile = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	return $newTargetFile;
}

function delete_photo($photo_name,$dir="",$sizes = array("originals", "600", "400", "200", "100", "200xcrops"),$fixed_crop_sizes=NULL)
{
	if(trim($photo_name) == "" || trim($dir) == "") return FALSE;
	$photo_root_path = $_SERVER['DOCUMENT_ROOT']."/_assets/images/";
	$file_photo_root_path = $photo_root_path.$dir."/";
	
	$file_path = $file_photo_root_path.$photo_name;
	$file_resize_path = $file_photo_root_path."resize_".$photo_name;
	
	//$sizes = array("600", "400", "200", "crops");
	//$sizes = array("originals", "600", "400", "200", "100", "200xcrops"/*, "cropped_80x65"*/);
	foreach($sizes as $size)
	{
		$file_res_path = $file_photo_root_path.$size."/".$photo_name;
		if(is_file($file_res_path)) unlink($file_res_path);
	}
	if(!is_null($fixed_crop_sizes))
	{
		foreach($fixed_crop_sizes as $size)
		{
			$file_res_path = $file_photo_root_path.$size."/".$photo_name;
			if(is_file($file_res_path)) unlink($file_res_path);
		}
	}
	return TRUE;
}

function save_logo($photo_name,$dir="")
{
	$sizes = array("200", "100", "200xcrops");
	return save_photo($photo_name,$dir,$sizes);
}

function delete_logo($photo_name,$dir="")
{
	$sizes = array("originals", "200", "100", "200xcrops");
	return delete_photo($photo_name,$dir,$sizes);
}

?>