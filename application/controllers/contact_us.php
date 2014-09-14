<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL);	
	}
	
	public function index()
	{
		$data['initcss'] = array("additional_other");
		
		$this->load->view("header", $data);
		$this->load->view("contact_us", $data);
		$this->load->view("footer", $data);
	}
}

/* End of file contact_us.php */
/* Location: ./application/controllers/contact_us.php */