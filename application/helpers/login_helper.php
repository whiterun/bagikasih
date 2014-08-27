<?php
function get_current_admin() 
{ 
	$CI =& get_instance();
	if($CI->session->userdata('hapikado_aname') == false || $CI->session->userdata('hapikado_apass') == false) return false;
	return get_admin($CI->session->userdata('hapikado_aname'),$CI->session->userdata('hapikado_apass')); 
}

function get_admin($aname,$apass)
{
	$CI =& get_instance();
	$q = "SELECT * FROM admins
			WHERE email = ?
				AND password = ?				
			";
	$res = $CI->db->query($q,array($aname,$apass)); 
	if(emptyres($res)) return false;
	else
	{
		return $res->row();
	}
}

function set_login_admin_session($aname,$apass)
{
	$CI =& get_instance();
	//$CI->db->query("UPDATE users SET dt_last_login = NOW(), login_count = login_count+1 WHERE email = ?",array($uname));
	$CI->session->set_userdata("hapikado_aname",$aname);
	$CI->session->set_userdata("hapikado_apass",md5($apass));
	return TRUE;
}

function unset_login_admin_session()
{
	$CI =& get_instance();
	//*
	$uname = $CI->session->userdata("hapikado_aname");
	$upass = $CI->session->userdata("hapikado_apass");
	//$CI->db->query("UPDATE users SET dt_last_logout = NOW() WHERE email = ?",array($uname));
	//*/
	$CI->session->unset_userdata("hapikado_aname");
	$CI->session->unset_userdata("hapikado_apass");
	return TRUE;
}

function get_logged_in_user() 
{ 
	$CI =& get_instance();
	if($CI->session->userdata('hapikado_uname') == false || $CI->session->userdata('hapikado_upass') == false) return false;
	return get_user($CI->session->userdata('hapikado_uname'),$CI->session->userdata('hapikado_upass')); 
}

function get_user($uname,$upass)
{
	$CI =& get_instance();
	$q = "SELECT * FROM users
			WHERE email = ?
				AND password = ?
			";
	$res = $CI->db->query($q, array($uname, $upass)); 
	if(emptyres($res)) return false;
	else
	{
		return $res->row();
	}
}

function set_login_session($uname,$upass)
{
	$CI =& get_instance();
	//$CI->db->query("UPDATE users SET dt_last_login = NOW(), login_count = login_count+1 WHERE email = ?",array($uname));
	$CI->session->set_userdata("hapikado_uname",$uname);
	$CI->session->set_userdata("hapikado_upass",$upass);
	return TRUE;
}

function unset_login_session()
{
	$CI =& get_instance();
	
	$uname = $CI->session->userdata("hapikado_uname");
	$upass = $CI->session->userdata("hapikado_upass");
	//$CI->db->query("UPDATE users SET dt_last_logout = NOW() WHERE email = ?", array($uname));
	
	$CI->session->unset_userdata("hapikado_uname");
	$CI->session->unset_userdata("hapikado_upass");
	$CI->session->sess_destroy();
	session_start();
	session_destroy();
	return TRUE;
}