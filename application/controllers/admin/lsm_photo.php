<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lsm_photo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/lsm_photo";
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
		$start 				= intval($_GET['page']);
		$perpage 			= 10;
		$data['list']		= OLsmList::get_list($start, $perpage, "name ASC", '0');
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
 		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'lsm_photo', $data);
		$this->load->view($this->ffoot, $data);
	}

	public function add()
	{
		extract($_POST); 
		
		$this->form_validation->set_rules('caption', 'Caption', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('id_lsm', 'LSM', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == TRUE)
		{
			$arr = NULL;
			foreach($_POST as $key => $val)
			{
				if(trim($val) != "") $arr[$key] = trim($val);
			}
			
			$this->load->library('upload');

			$config['upload_path'] = './assets/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1024';
			$config['encrypt_name'] = TRUE;
			
			$this->upload->initialize($config);
			
			if( ! $this->upload->do_upload("userfile")){
				echo $this->upload->display_errors();
			}

			$file_name = $this->upload->file_name;
			$arr = array_merge($arr, array('foto' => $file_name));
				
			$new_id = OProduct::add($arr);
			
			if($new_id) warning("add", "success");
			else warning("add", "fail");
			redirect($this->curpage);
			exit();
		}
		$data['cu'] = $this->cu;
		$data['act'] = "add";
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'product_form', $data);
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