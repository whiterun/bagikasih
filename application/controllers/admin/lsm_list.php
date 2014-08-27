<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lsm_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/lsm_list";
		//error_reporting(E_ALL);
		
		$this->cu = $cu = get_current_admin();
		if(!$cu) admin_logout();
	}
	
	public function index()
	{
		$this->listing(0);
	}
	
	public function listing($start=0)
	{
		$start 				= intval($_GET['page']);
		$perpage 			= 10;
		
		if($_GET['keyword'] != '' || $_GET['location_id'] != '')
		{
			$wher1 = array();
			$blink = array();
			if($_GET['keyword'] != '')
			{
				$wher1[] = " name like '%".$_GET['keyword']."%'";
				$blink	 = array_merge($blink, array('keyword' => $_GET['keyword']));
			}
			if($_GET['location_id'] != '')
			{
				$wher1[] = " id_kota = ".$_GET['location_id'];
				$blink	 = array_merge($blink, array('location_id' => $_GET['location_id']));
			}
			$wher2 = implode(" AND ",$wher1);
		} else $wher2 = '';
		
		$lw = http_build_query($blink);
		
		if($_GET['keyword'] != "" || $_GET['location_id'] != '') $data['list'] = OLsmList::get_list($start, $perpage, "id_lsm DESC", $wher2);
		else $data['list'] 		= OLsmList::get_list($start, $perpage);
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?".$lw;
		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'lsm_list', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function add()
	{
		extract($_POST); 
		
		if(count($_POST) > 0)
		{
			$arr1 = array(
				'approved'			=>	1,
				'id_bank'			=>	$bank,
				'id_kota'			=>	$kota,
				'name'				=>	$lname,
				'fund_target'		=>	$target,
				'address'			=>	$address,
				'acc_holder'		=>	$aholder,
				'acc_number'		=>	$anumber,
				'url_title'			=>	$urlname,
				'id_lsm_category'	=>	$category,
				'deskripsi'			=>	str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $deskripsi)
			);
			
			if(!empty($_FILES['userfile']['name']))
			{
				$this->load->library('upload');
				
				$config['upload_path'] = './assets/images';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1024';
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				
				if( ! $this->upload->do_upload("userfile")){
					echo $this->upload->display_errors();
				}
				
				$file_name = $this->upload->file_name;
				
				$arr1 = array_merge($arr1, array('image' => $file_name));
			}
			
			if($area) $arr1 = array_merge($arr1, array('id_area' => $area));
			if($volunteer) $arr1 = array_merge($arr1, array('volunteer' => $volunteer));
			
			$new = OLsmList::add($arr1);
			
			if($new)
			{			
				$image_arr = NULL;
				if($_POST['image'] != NULL) {
					foreach($_POST['image'] as $image) {
						$image_file = OLsmList::save_lsm_photo($image);
						$image_arr[] = array("id_lsm" => $new, "image_name" => $image_file);
					}
					$photos = OLsmList::add_lsm_photo_batch($image_arr);
				}
				
				$video_arr = NULL;
				$vd = array_filter($_POST['video'], 'strlen');
				if(!empty($vd)) {
					foreach($_POST['video'] as $video) {
						$video_arr[] = array("id_lsm" => $new, "video_link" => $video);
					}
					$vids = OLsmList::add_lsm_video_batch($video_arr);
				}
				
				$arr2 = array(
					'id_lsm'	=>	$new,
					'email'		=>	$mail,
					'name'		=>	$name,
					'id_city'	=>	$kota,
					'phone'		=>	$phone,
					'address'	=>	$alamat,
					'password'	=>	md5(md5($pass))
				);
				
				$new2 = OLsmOrganizer::add($arr2);
				
				$files = glob('assets/images/temp/*');
				foreach($files as $file){
					if(is_file($file))
						unlink($file);
				}
			}
			
			if($new2) warning("add", "success");
			else warning("add", "fail");			
			redirect($this->curpage);
			exit();
		}
		$data['cu'] = $this->cu;
		$data['act'] = "add";
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'lsm_form', $data);
		$this->load->view($this->ffoot, $data);	
	}	
	
	
	public function edit($id)
	{
		$dlsproduct = new OLsmList($id);
		
		if(!empty($id))
		{			
			if($dlsproduct->row == FALSE)
			{
				$this->session->set_flashdata('warning', 'ID does not exist.');
				redirect($this->curpage);
			}
		}
		
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$arr1 = array(
				'approved'			=>	1,
				'id_bank'			=>	$bank,
				'id_kota'			=>	$kota,
				'name'				=>	$lname,
				'fund_target'		=>	$target,
				'address'			=>	$address,
				'acc_holder'		=>	$aholder,
				'acc_number'		=>	$anumber,
				'url_title'			=>	$urlname,
				'id_lsm_category'	=>	$category,
				'deskripsi'			=>	str_replace(array('<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;">', '</div>', '<p>', '<p style="text-align:justify;">', '</p>'), '', $deskripsi)
			);
			
			if(!empty($_FILES['userfile']['name'])) {
			
				$this->load->library('upload');
				
				$config['upload_path'] = './assets/images';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1024';
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				
				if( ! $this->upload->do_upload("userfile")){
					echo $this->upload->display_errors();
				}
				
				$file_name = $this->upload->file_name;
				
				$arr1 = array_merge($arr1, array('image' => $file_name));
			}
			
			if($area) $arr1 = array_merge($arr1, array('id_area' => $area));
			if($volunteer) $arr1 = array_merge($arr1, array('volunteer' => $volunteer));
			
			// $new = OLsmList::add($arr1);
					
			$image_arr = NULL;
			if($_POST['image'] != NULL) {
				foreach($_POST['image'] as $image) {
					$image_file = OLsmList::save_lsm_photo($image);
					$image_arr[] = array("id_lsm" => $id, "image_name" => $image_file);
				}
				$photos = OLsmList::add_lsm_photo_batch($image_arr);
			}
			
			$video_arr = NULL;
			$vd = array_filter($_POST['video'], 'strlen');
			if(!empty($vd)) {
				foreach($_POST['video'] as $video) {
					$video_arr[] = array("id_lsm" => $id, "video_link" => $video);
				}
				$vids = OLsmList::add_lsm_video_batch($video_arr);
			}
			
			$files = glob('assets/images/temp/*');
			foreach($files as $file){
				if(is_file($file))
					unlink($file);
			}
			
			$new = $dlsproduct->edit($arr1);
			
			if($new) warning("edit", "success");
			else warning("edit", "fail");				
			redirect($this->curpage);
			exit();
		}
		$data['cu'] = $this->cu;
		$data['row'] = $dlsproduct->row;
		$data['act'] = "edit";
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'lsm_form', $data);
		$this->load->view($this->ffoot, $data);	
	}
	
	public function delete($id)
	{
		$dlsproduct = new OLsmList($id);		
		
		$res = $dlsproduct->delete();
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
	
	public function approve()
	{
		$id = $this->uri->segment(4);
		$arr['approved'] = 1;
		
		$res = OLsmList::approve($arr, $id);
		
		if($res) $this->session->set_flashdata("success", "Your selected lsm has been approved.");
		else $this->session->set_flashdata("warning", "Your selected lsm can't approved.");
		redirect($this->curpage);
		exit();
	}
	
	public function delete_video()
	{
		$id  = $this->uri->segment(4);
		$lvd = $this->uri->segment(5);
		
		$res = OLsmList::lvideo_delete($lvd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage.'/edit/'.$id);
		exit();
	}
	
	public function delete_photo()
	{
		$id  = $this->uri->segment(4);
		$gd  = $this->uri->segment(5);
		
		$res = OLsmList::lgallery_delete($gd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage.'/edit/'.$id);
		exit();
	}
	
	public function featured()
	{
		$id = $this->uri->segment(4);
		$fr = $this->uri->segment(5);
		
		$res = $this->db->update('lsm_list', array('featured' => $fr), array('id_lsm' => $id));
		
		if($res) $this->session->set_flashdata("success", "Your selected lsm has been set featured.");
		else $this->session->set_flashdata("warning", "Your selected lsm can't be set featured.");
		redirect($this->curpage);
		exit();
	}
	
	public function disable()
	{
		$id = $this->uri->segment(4);
		
		$res = $this->db->update('lsm_list', array('approved' => 0), array('id_lsm' => $id));
		
		if($res) $this->session->set_flashdata("success", "Your selected lsm has been disabled.");
		else $this->session->set_flashdata("warning", "Your selected lsm can't be disabled.");
		redirect($this->curpage);
		exit();
	}
	
	public function lget_area()
	{
		$data['data'] = $_POST;
		$this->load->view('get_area',$data);
	}
}

/* End of file lsm_list.php */
/* Location: ./application/controllers/admin/lsm_list.php */
