<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/categories";
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
			$OCategory = new OCategory($id);
			
			if(!empty($id))
			{			
				if($OCategory->row == FALSE)
				{
					$this->session->set_flashdata('warning', 'ID does not exist.');
					redirect($this->curpage);
				}
			}
			
			$this->form_validation->set_rules('category', 'Category Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('category' => $category);
				$res = $OCategory->edit($arr, $id);
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage);
				
			}
			$data['row'] = $OCategory->row;
		}
		else 
		{
			$this->form_validation->set_rules('category', 'Category Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('category'	=> $category);
				$new = OCategory::add($arr);				
				
				if($new) warning("add", "success");
				else warning("add", "fail");
				redirect($this->curpage);
				exit();										
			}			
		}
		
		$start 				= intval($_GET['page']);
		$perpage 			= 10;
		$data['list']		= OCategory::get_list($start, $perpage, "category ASC", '0');
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
 		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'category_list_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function delete($id)
	{
		$OCategory = new OCategory($id);
		
		$res = $OCategory->delete($id);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
	
	public function sorting()
	{
		$sorts = explode(",",$this->input->post('sorts'));
		$this->db->update('categories',array('ordering' => 0));
		$count = 1;
		foreach($sorts as $id)
		{
			$this->db->update('categories',array('ordering' => $count),array('id' => intval($id)));
			$count++;
		}
		die("DONE");
	}
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */