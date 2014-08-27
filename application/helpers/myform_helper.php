<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

function gen_ddl_set_array($name, $nameid, $arr = array(), $selected_val = "", $extra = "", $multi = false)
{
	if($multi) $multiple = "multiple";
	$ret .= "<select name='$name' id='$nameid' $multiple $extra>";
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

function warning($a, $b="success")
{
	$CI =& get_instance();
	switch ($a)
	{
		case "add":
			$str = "added";
			break;
		case "edit":
			$str = "updated";
			break;
		case "delete":
			$str = "deleted";
			break;
		case "cancel":
			$str = "canceled";
			break;
		case "active":
			$str = "activated";
			break;
		case "inactive":
			$str = "inactivated";
			break;
		case "checkout":
			$str = "sent";
			break;
		case "sign":
			$str = "signed";
			break;
		case "found":
			$str = "found";
			break;
		case "complete":
			$str = "completed";
			break;		
		default:
			$str = "";
			break;
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
	return ($error != "" ? "<p class='error'>".$error."</p>" : "");
}

function print_success($success)
{
	return ($success != "" ? "<p class='success'>".$success."</p>" : "");
}

function dt_ddl($prefix,$date_value = "") // $date_value in YYYY-MM-DD
{
	if($date_value == "") $date_value = date("Y-m-d");
	$year = date("Y",strtotime($date_value));
	$month = date("n",strtotime($date_value));
	$day = date("d",strtotime($date_value));
	$start_dt = date("Y",strtotime("-2 year"));
	
	return month_ddl("{$prefix}_month",$month).date_ddl("{$prefix}_date",$day).year_ddl("{$prefix}_year",$year,$start_dt);
}


function year_ddl($name,$val = "", $start = "", $end = "", $option = "")
{
	if($start == "") $start = date("Y");
	if($end == "") $end = date("Y",strtotime("+5 year"));
	$ret = "<select name='$name' id='$name' $option>";
	for($i = $start; $i <= $end; $i++)
	{
		if($i == $val) $selected = 'selected="selected"'; else $selected = '';
		$ret .= "<option value='$i' $selected>$i</option>";
	}
	$ret .= "</select>";
	return $ret;
}

function month_ddl($name,$val = "", $option = "")
{ 
	$start = 1;
	$end = 12;
	$ret = "<select name='$name' id='$name' $option>";
	for($i = $start; $i <= $end; $i++)
	{
		if($i < 10) $month = "0$i"; else $month = $i;
		if($month == $val) $selected = 'selected="selected"'; else $selected = '';
		
		$disp = date("M",strtotime("2008-$month-01"));
		$ret .= "<option value='$month' $selected>$disp</option>";
	}
	$ret .= "</select>";
	return $ret;
}

function date_ddl($name,$val = "", $option = "")
{
	$start = 1;
	$end = 31;
	$ret = "<select name='$name' id='$name' $option>";
	for($i = $start; $i <= $end; $i++)
	{
		if($i == $val) $selected = 'selected="selected"'; else $selected = '';
		$ret .= "<option value='$i' $selected>$i</option>";
	}
	$ret .= "</select>";
	return $ret;
}


function get_date_from_ddl($prefix, $array_type = "POST")
{
	if($array_type == "POST") $array = $_POST;
	else $array = $_GET;
	$month = $array["{$prefix}_month"];
	$date = $array["{$prefix}_date"];
	$year = $array["{$prefix}_year"];
	return "{$year}-{$month}-{$date}";
}

function qty_unit_ddl($name,$selval = "")
{
	$types = array("bks", "box", "kg", "klg", "lbr", "ltr", "pc","psg","tbg");
	$ret = "<select name='{$name}' id='{$name}'>";
	foreach($types as $type)
	{
		if($selval == $type) $sel = 'selected="selected"'; else $sel = '';
		$ret .= "<option value='{$type}' $sel>{$type}</option>";
	}
	$ret .= "</select>";
	return $ret;
}

function gen_ddl_set($name, $arr = array(), $selected_val = "", $extra = "", $multi = false)
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

function gen_checkbox_with_br($name, $arr = array(), $selected_val = array())
{
	$i = 0;
	foreach($arr as $disp => $val)
	{
		if(@in_array($disp,$selected_val)) $selected = 'checked="checked"'; else $selected = "";
		$nameid = str_replace(array('[',']'),'',$name);
		$ret .= "<label for='{$nameid}_{$i}'><input type='checkbox' id='{$nameid}_{$i}' name='$name' value='$disp' $selected /> $val</label><br />";
		$i++;
	}
	return $ret;
}

function gen_ddl_set_with_empty($name, $arr = array(), $selected_val = "", $emptytext = "", $extra = "", $multi = false)
{
	if($multi) $multiple = "multiple";
	$ret .= "<select name='$name' id='$name' $multiple $extra>";
	if($selected_val == "") $selected = 'selected="selected"'; else $selected = '';
	if(trim($emptytext) == "") $emptytext = "--- select ---";
	$ret .= "<option value='' $selected>$emptytext</option>";
	foreach($arr as $key => $val)
	{
		if($multi) { if(@in_array($val,$selected_val)) $selected = 'selected="selected"'; else $selected = ""; }
		else { if($key == $selected_val) $selected = 'selected="selected"'; else $selected = ""; }
		$ret .= "<option value='$key' $selected>$val</option>";
	}
	$ret .= "</select>";
	return $ret;
}

function gen_ddl_set_array_with_empty($name, $nameid, $arr = array(), $emptytext = "", $selected_val = "", $extra = "", $multi = false)
{
	if($multi) $multiple = "multiple";
	if($nameid != "") $name_id = "id='$nameid'";
	$ret .= "<select name='$name' $name_id $multiple $extra>";
	if($selected_val == "") $selected = 'selected="selected"'; else $selected = '';
	if(trim($emptytext) == "") $emptytext = "--- select ---";
	if($emptytext != "empty")
	{
		$ret .= "<option value='' $selected>$emptytext</option>";
	}
	foreach($arr as $key => $val)
	{
		if($multi) { if(@in_array($val,$selected_val)) $selected = 'selected="selected"'; else $selected = ""; }
		else { if($key == $selected_val) $selected = 'selected="selected"'; else $selected = ""; }
		$ret .= "<option value='$key' $selected>$val</option>";
	}
	$ret .= "</select>";
	return $ret;
}

?>