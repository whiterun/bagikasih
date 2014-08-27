<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends CI_Controller {

	public function index()
	{
	
	}
	
	public function clear()
	{
		clear_location();
		header("location: {$_SERVER['HTTP_REFERER']}");
		exit;
	}
	public function details($location)
	{
		// print_r($_SERVER);
		$q = "SELECT * FROM locations WHERE url_title = ?";
		$res = $this->db->query($q,array($this->uri->segment(3)));
		if(!emptyres($res))
		{
			$r = $res->row();
			set_location($r->id);
		}
		
		header("location: {$_SERVER['HTTP_REFERER']}");
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */