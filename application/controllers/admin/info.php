<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/info";
		//error_reporting(E_ALL);
		
		$this->cu = $cu = get_current_admin();
		if(!$cu) admin_logout();
	}
	
	public function index() { }
	
	public function about_us()
	{
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('content' => str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $description));
				$res = edit_info($arr, 'about_us');
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage.'/about_us');
			}
		}
	
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'about_us_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function contact_us()
	{
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('content' => str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $description));
				$res = edit_info($arr, 'contact_us');
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage.'/contact_us');
			}
		}
	
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'contact_us_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function faq()
	{
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('content' => str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $description));
				$res = edit_info($arr, 'faq');
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage.'/faq');
			}
		}
	
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'faq_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function links()
	{
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('content' => str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $description));
				$res = edit_info($arr, 'links');
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage.'/links');
			}
		}
	
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'links_form', $data);
		$this->load->view($this->ffoot, $data);
	}
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */