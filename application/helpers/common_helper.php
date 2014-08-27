<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function user_home()		{ redirect("user"); }
function admin_home()		{ redirect("admin/home"); }
function user_logout()		{ redirect("home/logout"); }
function admin_email()		{ return "admin@".DOMAIN_NAME; }
function admin_login()		{ redirect("admin/home/login"); }
function admin_logout()		{ redirect("admin/home/logout"); }
function contact_email()	{ return "contact@".DOMAIN_NAME; }

function get_setting($key)
{
	$CI =& get_instance();
	$res = $CI->db->query("SELECT * FROM settings WHERE `key` = ?",array($key));
	if(emptyres($res)) return FALSE;
	else
	{
		$r = $res->row();
		return $r->content;
	}
}
function set_location($id)
{
	$CI =& get_instance();
	$res = $CI->db->query("SELECT * FROM locations WHERE id = ?",array($id));
	if(emptyres($res)) return FALSE;
	else
	{
		$CI->session->set_userdata('location',$id);
		return TRUE;
	}
}
function clear_location()
{
	$CI =& get_instance();
	$CI->session->unset_userdata('location',$id);
	return TRUE;
}
function get_location($default = TRUE)
{
	$CI =& get_instance();
	$locationid = $CI->session->userdata('location',$id);
	if(intval($locationid) == 0) 
	{
		$q = "SELECT * FROM locations WHERE `default` = 1 LIMIT 1";
		$res = $CI->db->query($q);
		if(emptyres($res)) return FALSE;
		else
		{
			if($default)
			{
				$r = $res->row();
				return $r->id;
			}
			else
			{
				return FALSE;
			}
		}
	}
	else
	{
		return intval($locationid);
	}
}

function emptyres($res)
{
	if(!is_object($res) || $res->num_rows() == 0) return true;
	else return false;
}
function get_db_total_rows($db = false)
{
	if($db == false)
	{
		$CI =& get_instance();
		$res = $CI->db->query("SELECT FOUND_ROWS() AS total;"); 
	}
	else
	{
		$res = $db->query("SELECT FOUND_ROWS() AS total;");
	}
	if(emptyres($res)) return 0;
	$tmp = $res->row();
	return $tmp->total;	
}

function noreply_mail($to,$subject,$content)
{
	$CI =& get_instance();
	$CI->load->library('email');
	$CI->email->from('cs@'.DOMAIN_NAME, DOMAIN_NAME);
	$CI->email->to($to);
	$CI->email->subject($subject);
	$CI->email->message($content); 
	$CI->email->mailtype ='html';
	$CI->email->send();
}

function send_mail($from_name, $from_mail, $to_mail, $subject, $content)
{
	$CI =& get_instance();
	$CI->load->library('email');
	$CI->email->from($from_mail, $from_name);
	$CI->email->to($to_mail);
	$CI->email->subject($subject);
	$CI->email->message($content); 
	$CI->email->mailtype ='html';
	$CI->email->send();
}

function format_number($num, $dec=0, $prefix="", $suffix="")
{
	return $prefix.number_format($num, $dec, ',', '.').$suffix;
}

function dollar_format($num)
{
	return "USD ".number_format($num, 2, ',', '.');
}

function rupiah_format($total)
{
	return "Rp. ".number_format($total, 0, ',', '.');
}

function currency_format($total,$currency = "USD")
{
	if($currency == "USD") return dollar_format($total);
	else return rupiah_format($total).",-";
}

function get_tax_percentage()
{
	return 0.1;
}

function get_tax($total)
{
	return $total*get_tax_percentage();
}

function get_shipping_fee()
{
	return 10000;
}

function array_merge_special($arr1,$arr2)
{
	if(empty($arr1)) return $arr2;
	if(empty($arr2)) return $arr1;
	$arr = array();
	foreach($arr1 as $key => $value)
	{
		$arr[$key] = $value;
	}
	foreach($arr2 as $key => $value)
	{
		$arr[$key] = $value;
	}
	return $arr;
}

function trimmer($str,$maxchar = 15)
{
	$str = strip_tags($str);
	if(strlen($str) <= $maxchar) return $str;
	else return substr($str,0,$maxchar-3)." ..";
}

function csv_from_array($array, $delim = ",", $newline = "\n", $enclosure = '"')
{
	if ( ! is_array($array) && count($array) < 1) return FALSE;

	$out = '';

	foreach ($array as $row)
	{
		foreach ($row as $item)
		{
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
		}
		$out = rtrim($out);
		$out .= $newline;
	}

	return $out;
}

/* PAGINATION HELPER */

function getPagination($total, $perpage, $url, $num_links = 5)
{
	$CI =& get_instance();
	$CI->load->library('pagination');
	
	$config['base_url'] 	= site_url($url);
	$config['total_rows'] 	= $total;
	$config['per_page'] 	= $perpage; 
	//$config['uri_segment'] 	= $uri_segment;
	$config['num_links'] 	= $num_links;
	$config['page_query_string'] = TRUE;
	$config['query_string_segment'] = 'page';
	$config['full_tag_open'] = "<ul>";
	$config['full_tag_close'] = "</ul>";
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	$config['next_link'] = 'Next';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = 'Prev';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	
	$CI->pagination->initialize($config);
	return $CI->pagination->create_links();
}

function genPagination($total, $perpage, $url, $uri_segment, $num_links = 5)
{
	$CI =& get_instance();
	$CI->load->library('pagination');
	
	$config['base_url'] 	= site_url($url);
	$config['total_rows'] 	= $total;
	$config['per_page'] 	= $perpage; 
	$config['uri_segment'] 	= $uri_segment;
	$config['num_links'] 	= $num_links;
	$config['full_tag_open'] = "<ul>";
	$config['full_tag_close'] = "</ul>";
	$config['next_link'] = 'Next';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = 'Prev';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$CI->pagination->initialize($config);
	/*<ul>
              <li><a href="#"><span class="arr-prev">Prev</span></a></li>
              <li><a href="#" class="current">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><span class="ellip">&#8230;</span></li>
              <li><a href="#">15</a></li>
              <li><a href="#"><span class="arr-next">Next</span></a></li>
            </ul>*/
	return $CI->pagination->create_links();
}

/* TIME HELPER */

function datediff($d1, $d2)
{  
	$d1 = (is_string($d1) ? strtotime($d1) : $d1);  
	$d2 = (is_string($d2) ? strtotime($d2) : $d2);  
	$diff_secs = abs($d1 - $d2);  
	$base_year = min(date("Y", $d1), date("Y", $d2));  
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);  
	return array(
		"days"			=> date("j", $diff) - 1,
		"years"			=> date("Y", $diff) - $base_year,
		"hours"			=> date("G", $diff),
		"months"		=> date("n", $diff) - 1,
		"minutes"		=> (int) date("i", $diff),
		"seconds"		=> (int) date("s", $diff),
		"days_total"	=> floor($diff_secs / (3600 * 24)),
		"hours_total"	=> floor($diff_secs / 3600),
		"seconds_total"	=> $diff_secs,
		"minutes_total"	=> floor($diff_secs / 60),
		"months_total"	=> (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1
	);
} 

function parse_date($dt)
{
	if($dt == "0000-00-00") return "";
	else return date("M d, Y",strtotime($dt));
}
function parse_date2($dt)
{
	if($dt == "0000-00-00") return "";
	else return date("d F Y",strtotime($dt));
}
function parse_date_time($dt)
{
	if($dt == "0000-00-00 00:00:00") return "";
	else return date("M d, Y g:ia",strtotime($dt));
}
function getrelativetime($ts)
{
	$curyear = date("Y");
	$today = date("Y-m-d");
	$yesterday = date("Y-m-d",strtotime("-1 day"));
	$lastweek = date("Y-m-d",strtotime("-1 week"));
	$todayts = date("Y-m-d",strtotime($ts));
	$yearts = date("Y",strtotime($ts));
	$CI =& get_instance();
	$CI->load->helper('date');
	if($today == $todayts)
	{
		return str_replace(array(" hours"," hour"," minutes"," minute",","	),array("h","h","m","m",""),strtolower(timespan(strtotime($ts),time())." ago"));
	}
	if($todayts == $yesterday)
	{
		return "Yesterday at ".date("g:ia",strtotime($ts));
	}
	if($todayts > $lastweek)
	{
		return date("D \a\\t g:ia",strtotime($ts));
	}
	if($yearts == $curyear)
	{
		return date("M d \a\\t g:ia",strtotime($ts));
	}
	return date("M d, Y \a\\t g:ia",strtotime($ts));
}

/* FORM HELPER SECTION */

function radios($name,$arr=array(),$selected_value="",$extraparam="",$separator="<br />")
{
	foreach($arr as $val => $display)
	{
		if($val == $selected_value) $selected = 'checked="checked"'; else $selected = "";
		$ret .= "<label for='{$name}_{$val}'><input type='radio' id='{$name}_{$val}' name='$name' value='$val' $selected $extraparam /> ".$display."</label>".$separator;
	}
	return $ret;
}

function checkboxes($name,$arr,$selected_values = array(), $optional = "", $separator = "<br />")
{
	$id = str_replace("[]","",$name);
	foreach($arr as $val => $display)
	{
		if(in_array($val,$selected_values)) { $checked = 'checked="checked"'; } else $checked = '';
		$ret .= "<label for='{$id}_".url_title($val)."'><input type='checkbox' value='{$val}' name='{$name}' id='{$id}_".url_title($val)."' $checked> $display</label>".$separator;
	}
	return $ret;
}

function dropdown($name,$arr,$selected_value = "", $optional = "", $default_value="")
{
	$ret = "<select name='{$name}' id='{$name}' $optional>";
	if(trim($default_value) != "") $ret .= "<option value=''>$default_value</option>";
	foreach($arr as $val => $display)
	{
		if($val == $selected_value) { $selected = 'selected="selected"'; } else $selected = '';
		$ret .= "<option value='{$val}' $selected>$display</option>";
	}
	$ret .= "</select>";
	return $ret;
}


/* NOTIFICATION HELPER SECTION */

function warning($a, $b="success")
{
	$CI =& get_instance();
	switch ($a)
	{
		case "add":			$str = "added";			break;
		case "edit":		$str = "updated";		break;
		case "delete":		$str = "deleted";		break;
		case "cancel":		$str = "canceled";		break;
		case "active":		$str = "activated";		break;
		case "inactive":	$str = "inactivated";	break;
		default:			$str = "";				break;
	}
	if($str != "")
	{
		if($b == "success") $warning_string = "The data has been $str";
		else if($b == "fail") $warning_string = "The data can not be $str";
		else $warning_string = "";
	}
	if($warning_string == "") return "";
	else {
		if($b == "fail") return $CI->session->set_flashdata('warning', $warning_string);
		if($b == "success") return $CI->session->set_flashdata('success', $warning_string);
	}
}

function print_error($error)
{
	return ($error != "" ? "<div class=\"alert alert-error\">".$error."</div>" : "");
}

function print_success($success)
{
	return ($success != "" ? "<div class=\"alert alert-success\">".$success."</div>" : "");
}

function password_strength_check($pwd)
{
	$error = NULL;
	if( strlen($pwd) < 8 ) {
		$error[] = "Password too short!";
	}
	
	if( strlen($pwd) > 20 ) {
		$error[] = "Password too long!";
	}
	
	if( !preg_match("#[0-9]+#", $pwd) ) {
		$error[] = "Password must include at least one number!";
	}
	
	if( !preg_match("#[a-z]+#", $pwd) ) {
		$error[] = "Password must include at least one letter!";
	}
	
	if( !preg_match("#[A-Z]+#", $pwd) ) {
		$error[] = "Password must include at least one CAPS!";
	}
	
	if( !preg_match("#\W+#", $pwd) ) {
		$error[] = "Password must include at least one symbol!";
	}
	
	if(count($error) > 0){
		return $error;
	} else {
		return TRUE;
	}	
}

function password_check($pwd)
{
	$error = NULL;
	if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pwd)){
		return TRUE;
	} else {
		return FALSE;
	}
}

/* PICTURE HELPER */

function save_photo($photo_name,$dir="",$sizes=array("600", "400", "200", "100", "200xcrops"),$fixed_crop_sizes=NULL)
{
	$CI =& get_instance();
	
	if(trim($photo_name) == "" || trim($dir) == "") return FALSE;
	$photo_root_path = $_SERVER['DOCUMENT_ROOT']."/assets/images/";
	$tmp_photo_root_path = $photo_root_path."temp/";
	$copy_photo_root_path = $photo_root_path.$dir."/";
	
	$tmp_file = $tmp_photo_root_path.$photo_name;
	$tmp_resize_file = $tmp_photo_root_path."resize_".$photo_name;
	if(!is_file($tmp_file)) return FALSE;
	else
	{
		// var_dump("FOUND");
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
		
		foreach($sizes as $size)
		{
			if($size == "200xcrops")
			{
				if($w > $h) $length_type = "height";
				if($h > $w) $length_type = "width";
				if($w >= 200) resize_photo($tmp_file, $fpath.$size."/".$newfile, 200, $length_type);
				else copy($tmp_file, $fpath.$size."/".$newfile);
				
				crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,200,200);
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
				$dim_x = intval($size_dim_arr[0]);
				$dim_y = intval($size_dim_arr[1]);
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
							} else {
								$length_type = "height";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_y, $length_type);
							}
						} else {
							if(doubleval($w/$hx) >= $dim_x)
							{
								$length_type = "height";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_y, $length_type);
							} else {
								$length_type = "width";
								resize_photo($tmp_file, $fpath.$size."/".$newfile, $dim_x, $length_type);
							}
						}
					} 
					else copy($tmp_file, $fpath.$size."/".$newfile);
					crop_photo($fpath.$size."/".$newfile, $fpath.$size."/".$newfile,$dim_x,$dim_y);
				}
			}
		}
		
		copy($tmp_file, $fpath."originals/".$newfile);
		// if(is_file($tmp_file)) unlink($tmp_file);
		if(is_file($tmp_resize_file))
		{
			//copy($tmp_resize_file, $copy_photo_root_path."resize_".$photo_name);
			// unlink($tmp_resize_file);
		}
		return $newfile;
	}
}

function get_photo_url($image,$dir="",$dim="200xcrops",$no_default_img=FALSE)
{
	$targetPath = base_url() . 'assets/images/' .$dir. '/';
	$targetFile =  $targetPath . $dim . '/' . $image;
	if(!is_file($targetFile) || trim($image) == "" || trim($dir) == "")
	{
		$newTarget = str_replace(base_url(),'',$targetFile);
		if (file_exists($newTarget)) {
			return $newTarget;
		} else {
			return $targetPath . 'none.png';
		}
	}
}

function delete_photo($photo_name,$dir="",$sizes = array("originals", "600", "400", "200", "100", "200xcrops"),$fixed_crop_sizes=NULL)
{
	if(trim($photo_name) == "" || trim($dir) == "") return FALSE;
	$photo_root_path = $_SERVER['DOCUMENT_ROOT']."/assets/images/";
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


/* LOGIN SECTION */

function get_current_admin()
{ 
	$CI =& get_instance();
	if($CI->session->userdata('aname') == false || $CI->session->userdata('apass') == false) return false;
	return get_admin($CI->session->userdata('aname'),$CI->session->userdata('apass')); 
}
function get_admin($aname,$apass)
{
	$CI =& get_instance();
	$q = "SELECT * FROM admins WHERE username = ? AND password = ?";
	$res = $CI->db->query($q,array($aname,$apass)); 
	if(emptyres($res)) return false;
	else return $res->row();
}
function get_logged_in_user()
{ 
	$CI =& get_instance();
	if($CI->session->userdata('uname') == false || $CI->session->userdata('upass') == false) return false;
	return get_user($CI->session->userdata('uname'),$CI->session->userdata('upass')); 
}
function get_user($umail,$upass)
{
	$CI =& get_instance();
	$q = "SELECT * FROM buyer WHERE email = ? AND password = ?";
	$res = $CI->db->query($q,array($umail,$upass)); 
	if(emptyres($res)) return false;
	else return $res->row();
}

function set_login_session($umail,$upass,$type="admin")
{
	$CI =& get_instance();
	if($type=="admin") $CI->session->set_userdata(array("aname"=>$umail, "apass"=>$upass));
	if($type=="user") $CI->session->set_userdata(array("uname"=>$umail, "upass"=>$upass));
	if($type=="organizer") $CI->session->set_userdata(array("oname"=>$umail, "opass"=>$upass));
	//else $CI->session->set_userdata(array("uname"=>$umail, "upass"=>$upass));
}
function unset_login_session($type="admin")
{
	$CI =& get_instance();
	if($type=="user")	$CI->session->unset_userdata(array("uname"=>"", "upass"=>""));
	if($type=="admin")	$CI->session->unset_userdata(array("aname"=>"", "apass"=>""));
	if($type=="organizer") $CI->session->unset_userdata(array("oname"=>"", "opass"=>""));
	$CI->session->sess_destroy();
	session_start();
	session_destroy();
	//else $CI->session->unset_userdata(array("uname"=>"", "upass"=>""));
}

//TAMBAH SESSION ORGANIZER
function get_logged_in_organizer()
{ 
	$CI =& get_instance();
	if($CI->session->userdata('oname') == false || $CI->session->userdata('opass') == false) return false;
	return get_sorganizer($CI->session->userdata('oname'),$CI->session->userdata('opass')); 
}
function get_sorganizer($omail,$opass)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_organizer WHERE email = ? AND password = ?";
	$res = $CI->db->query($q,array($omail,$opass)); 
	if(emptyres($res)) return false;
	else return $res->row();
}

function langtext($str,$type = 0)
{
	$CI =& get_instance();
	$lang = $CI->input->cookie('lang');
	if($lang == "") $lang = "indonesia";
	else if($lang == "id") $lang = "indonesia";
	else $lang = 'english';
	
	$CI->load->language('main',$lang);
	$CI->load->helper('language');
	$ret= lang($str);
	if($ret == "") $ret = $str;
	if($type == 0) return $ret;
	if($type == 1) return ucfirst($ret);
	if($type == 2) return strtoupper($ret);
}


function gen_ddl_set($name, $arr = array(), $selected_val = "", $extra = "class='span10'", $multi = false)
{
	if($multi) $multiple = "multiple";
	$ret .= "<select name='$name' id='$name' $multiple $extra>";
	if($selected_val == "") $selected = 'selected="selected"'; else $selected = '';
	/*$ret .= "<option value='' $selected>--- select one ---</option>";*/
	foreach($arr as $key => $val)
	{
		if($multi) { if(@in_array($val,$selected_val)) $selected = 'selected="selected"'; else $selected = ""; }
		else { if($key == $selected_val) $selected = 'selected="selected"'; else $selected = ""; }
		$ret .= "<option value='$key' $selected>$val</option>";
	}
	$ret .= "</select>";
	return $ret;
}

function fb_date($date)
{
	$arr = explode('/',$date);
	
	switch($arr[0])
	{
		case 1;		$m = "January";		break;
		case 2;		$m = "February";	break;
		case 3;		$m = "March";		break;
		case 4;		$m = "April";		break;
		case 5;		$m = "May";			break;
		case 6;		$m = "June";		break;
		case 7;		$m = "July";		break;
		case 8;		$m = "August";		break;
		case 9;		$m = "September";	break;
		case 10;	$m = "October";		break;
		case 11;	$m = "November";	break;
		case 12;	$m = "December";	break;
	}
	
	return $arr[1].' '.$m.' '.$arr[2];
}

function get_user_bymail($umail)
{
	$CI =& get_instance();
	$q = "SELECT * FROM buyer WHERE email = ?";
	$res = $CI->db->query($q,array($umail,$upass)); 
	return $res->row();
}

function get_coupdisc($code, $date, $used = 0)
{
	$CI =& get_instance();
	$q = "SELECT * FROM coupon_code WHERE code = ? && expired_date >= ? && used = ?";
	$res = $CI->db->query($q, array($code, $date, $used)); 
	return $res->row();
}

function get_city($city)
{
	$CI =& get_instance();
	$q = "SELECT * FROM kota WHERE id_kota = ?";
	$res = $CI->db->query($q, array($city)); 
	return $res->row();
}

function get_lsm_category($lsmc)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_category WHERE id_lsm_category = ?";
	$res = $CI->db->query($q, array($lsmc)); 
	return $res->row();
}

function get_organizer($organizer)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_organizer WHERE id_organizer = ?";
	$res = $CI->db->query($q, array($organizer)); 
	return $res->row();
}

function get_lsm($lsmid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_list WHERE id_lsm = ?";
	$res = $CI->db->query($q, array($lsmid)); 
	return $res->row();
}

function get_lsm_byurl($url)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_list WHERE url_title = ?";
	$res = $CI->db->query($q, array($url)); 
	return $res->row();
}

function get_province($provid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM provinsi WHERE id_provinsi = ?";
	$res = $CI->db->query($q, array($provid)); 
	return $res->row();
}

function count_member($lsmid)
{
	$CI =& get_instance();
	$q = "SELECT COUNT(*) as member FROM lsm_member WHERE id_lsm = ?";
	$res = $CI->db->query($q, array($lsmid)); 
	return $res->row();
}

function count_funder($lsmid)
{
	$CI =& get_instance();
	$q = "SELECT COUNT(*) as funder FROM fundraise_list WHERE id_lsm = ?";
	$res = $CI->db->query($q, array($lsmid)); 
	return $res->row();
}

function count_volunteer($volid)
{
	$CI =& get_instance();
	$q = "SELECT COUNT(*) as volunteer FROM volunteer WHERE id_lsm = ? AND cancel_stat = '0' AND suspend = '0'";
	$res = $CI->db->query($q, array($volid)); 
	return $res->row();
}

function get_funded($id1 = '', $id2 = '')
{
	if($id1 != '') $w = "id_lsm = '".$id1."'";
	else if($id2 != '') $w = "id_fundraise = '".$id2."'";
	$CI =& get_instance();
	$res = $CI->db->query("SELECT sum(amount) as amt FROM contribution WHERE ".$w." AND currency = 'IDR'");
	return $res->row();
}

function get_buyer($buyid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM buyer WHERE id_buyer = ?";
	$res = $CI->db->query($q, array($buyid)); 
	return $res->row();
}

function get_fundraise($fraid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_list WHERE id_fundraise = ?";
	$res = $CI->db->query($q, array($fraid)); 
	return $res->row();
}

function get_fundraise_byurl($url)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_list WHERE url_title = ?";
	$res = $CI->db->query($q, array($url));
	return $res->row();
}

function get_color($cid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_color WHERE id_fcolor = ?";
	$res = $CI->db->query($q, array($cid)); 
	return $res->row();
}

function get_bgimg($fid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_image WHERE id_fundraise = ? && active = '1'";
	$res = $CI->db->query($q, array($fid)); 
	return $res->row();
}

function auto_tidy($text)
{
	$paragraphs = explode("\n", $text);
	for ($i = 0; $i < count ($paragraphs); $i++){
		$paragraphs[$i] = '<p style="text-align:justify;">' . $paragraphs[$i] . '</p>';
	}
	$paragraphs = implode ('', $paragraphs);
	return $paragraphs;
}

function ddiff($date)
{
	$exp 	= explode("-", $date);
	$date	= $exp[2];
	$month	= $exp[1];
	$year	=  $exp[0];

	$jd1 = GregorianToJD(date('m'), date('d'), date('Y'));
	$jd2 = GregorianToJD($month, $date, $year);

	$diff = $jd2 - $jd1;

	return $diff;
}

function get_fupdate($fud)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_update WHERE id_fupdate = ?";
	$res = $CI->db->query($q, array($fud)); 
	return $res->row();
}

function get_fgimg($fld)
{
	$CI =& get_instance();
	$q = "SELECT * FROM fundraise_gallery WHERE id_fgallery = ?";
	$res = $CI->db->query($q, array($fld)); 
	return $res->row();
}

function get_lgimg($lld)
{
	$CI =& get_instance();
	$q = "SELECT * FROM lsm_gallery WHERE id_lgallery = ?";
	$res = $CI->db->query($q, array($lld)); 
	return $res->row();
}

function get_info($title)
{
	$CI =& get_instance();
	$q = "SELECT * FROM information WHERE title = ?";
	$res = $CI->db->query($q, array($title)); 
	return $res->row();
}

function edit_info($arr, $title)
{
	$CI =& get_instance(); 
	return $CI->db->update('information', $arr, array('title' => $title));
}

function look_addr()
{
	$res = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}"));
	return $res->city;
}

function get_loc($nm)
{
	$CI =& get_instance();
	$q = "SELECT * FROM kota WHERE name = ?";
	$res = $CI->db->query($q, array($nm)); 
	return $res->row();
}

function get_donation($di)
{
	$CI =& get_instance();
	$q = "SELECT * FROM contribution WHERE id_contribution = ?";
	$res = $CI->db->query($q, array($di));
	return $res->row();
}

function get_confirm_donation($cdi, $t = NULL)
{
	$ty = ($t == 'confirm') ? 'id_contribution' : 'id_cconfirm' ;
	$CI =& get_instance();
	$q = "SELECT * FROM contribution_confirm WHERE ".$ty." = ?";
	$res = $CI->db->query($q, array($cdi));
	return $res->row();
}

function get_bank($id)
{
	$CI =& get_instance();
	$q = "SELECT * FROM bank WHERE id_bank = ?";
	$res = $CI->db->query($q, array($id));
	return $res->row();
}

function get_volunteer($vid)
{
	$CI =& get_instance();
	$q = "SELECT * FROM volunteer WHERE id_volunteer = ?";
	$res = $CI->db->query($q, array($vid)); 
	return $res->row();
}

?>