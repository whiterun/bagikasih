<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL);	
	}
	
	public function index()
	{
		$data['initcss'] = array("additional_other");
		
		$this->load->view("header", $data);
		$this->load->view("about_us", $data);
		$this->load->view("footer", $data);
	}
}

/* End of file about_us.php */
/* Location: ./application/controllers/about_us.php */