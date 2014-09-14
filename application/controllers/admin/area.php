<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/area";
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
			$OArea = new OArea($id);
			
			if(!empty($id))
			{			
				if($OArea->row == FALSE)
				{
					$this->session->set_flashdata('warning', 'ID does not exist.');
					redirect($this->curpage);
				}
			}
			
			$this->form_validation->set_rules('name', 'Area Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('name' => $name, 'id_kota' => $id_kota);
				$res = $OArea->edit($arr, $id);
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage);
				
			}
			$data['row'] = $OArea->row;
		}
		else 
		{
			$this->form_validation->set_rules('name', 'Area Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('name'	=> $name, 'id_kota' => $id_kota);
				$new = OArea::add($arr);				
				
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
		
		if($_GET['keyword'] != "") $data['list'] = OArea::search($_GET['keyword']);
		else $data['list'] = OArea::get_list($start, $perpage, "name ASC");
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?perpage=$perpage";
 		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'area_list_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function delete($id)
	{
		$OArea = new OArea($id);
		
		$res = $OArea->delete($id);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
}

/* End of file area.php */
/* Location: ./application/controllers/admin/area.php */