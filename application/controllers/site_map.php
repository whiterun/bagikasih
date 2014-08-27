<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_map extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL);	
	}
	
	public function index()
	{
		$data['initcss'] = array("additional_other");
		
		$this->load->view("header", $data);
		$this->load->view("site_map", $data);
		$this->load->view("footer", $data);
	}
}

/* End of file site_map.php */
/* Location: ./application/controllers/site_map.php */