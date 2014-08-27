<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lsm_Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/lsm_category";
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
			$OLsmCategory = new OLsmCategory($id);
			
			if(!empty($id))
			{			
				if($OLsmCategory->row == FALSE)
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
				$res = $OLsmCategory->edit($arr, $id);
				
				if($res) warning("edit", "success");
				else warning("edit", "fail");				
				redirect($this->curpage);
				
			}
			$data['row'] = $OLsmCategory->row;
		}
		else 
		{
			$this->form_validation->set_rules('category', 'Category Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == TRUE)
			{
				$arr = array('category'	=> $category);
				$new = OLsmCategory::add($arr);				
				
				if($new) warning("add", "success");
				else warning("add", "fail");
				redirect($this->curpage);
				exit();
			}			
		}
		
		$start 				= intval($_GET['page']);
		$perpage 			= 10;
		$data['list']		= OLsmCategory::get_list($start, $perpage, "category ASC", '0');
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
 		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'lsm_category_list_form', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function delete($id)
	{
		$OLsmCategory = new OLsmCategory($id);
		
		$res = $OLsmCategory->delete($id);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */