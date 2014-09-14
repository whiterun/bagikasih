<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/bank";
		//error_reporting(E_ALL);
		
		$this->cu = $cu = get_current_admin();
		if(!$cu) admin_logout();
	}
	
	public function index()
	{
		$this->listing(0);
	}
	
	public function listing($id, $start=0)
	{
		extract($_POST);
		
		if(!empty($id))
		{
			$OBank = new OBank($id);
			
			if(!empty($id))
			{			
				if($OBank->row == FALSE)
				{
					$this->session->set_flashdata('warning', 'ID does not exist.');
					redirect($this->curpage);
				}
			}
			
			$this->form_validation->set_rules('name', 'Bank Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('name' => $name);
				$res = $OBank->edit($arr, $id);
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage);
				
			}
			$data['row'] = $OBank->row;
		}
		else 
		{
			$this->form_validation->set_rules('name', 'Bank Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('name'	=> $name);
				$new = OBank::add($arr);
				
				if($new) warning("add", "success");
				else warning("add", "fail");
				redirect($this->curpage);
				exit();										
			}			
		}
		
		$start 				= $_GET['page'];
		$perpage 			= $_GET['perpage'];
		if(empty($start))	$start = 0;
		if(empty($perpage))	$perpage = 10;
		
		if($_GET['keyword'] != "") $data['list'] = OBank::search($_GET['keyword']);
		else $data['list'] = OBank::get_list($start, $perpage, "name ASC", '0');
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?perpage=$perpage";
 		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'bank_list_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function delete($id)
	{
		$dlsoption = new OBank($id);
		
		$res = $dlsoption->delete($id);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
}

/* End of file bank_accounts.php */
/* Location: ./application/controllers/admin/bank_accounts.php */