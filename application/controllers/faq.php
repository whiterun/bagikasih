<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL);	
	}
	
	public function index()
	{
		$data['initcss'] = array("additional_other");
		
		$this->load->view("header", $data);
		$this->load->view("faq", $data);
		$this->load->view("footer", $data);
	}
}

/* End of file faq.php */
/* Location: ./application/controllers/faq.php */