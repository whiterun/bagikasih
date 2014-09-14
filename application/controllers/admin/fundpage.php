<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fundpage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/fundpage";
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
		
		if($_GET['keyword'] != "") $data['list'] = OLsmList::fsearch($_GET['keyword']);
		else $data['list'] 		= OLsmList::get_fundraise_list($start, $perpage);
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'fundpage_list', $data);
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
	
	public function featured()
	{
		$id = $this->uri->segment(4);
		$fr = $this->uri->segment(5);
		
		$res = $this->db->update('fundraise_list', array('featured' => $fr), array('id_fundraise' => $id));
		
		if($res) $this->session->set_flashdata("success", "Your selected fundpage has been set featured.");
		else $this->session->set_flashdata("warning", "Your selected fundpage can't be set featured.");
		redirect($this->curpage);
		exit();
	}

	public function edit($id)
	{		
		$data['fra'] = get_fundraise($id);
		
		$data['fcl'] = OLsmList::get_fcolor();
		
		if(sizeof($_POST) > 0)
		{
			extract($_POST);
		
			$arr1 = array(
				'name'			=>	$name,
				'end_date'		=>	$end_date,
				//'id_buyer'		=>	$cu->id_buyer,
				'theme'			=>	$pcolor,
				'background'	=>	$bgc,
				'fund_target'	=>	$target,
				'description'	=>	str_replace(array('<p>', '</p>'), '', $description)
			);
			
			// $exec = OUser::edit_fund($arr1, $id);
		
			if($bgc == 'yes') {
				if(!empty($_FILES['fpfile']['name']))
				{
					$this->load->library('upload');

					$config['upload_path'] = './assets/images';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '1024';
					$config['encrypt_name'] = TRUE;
					
					$this->upload->initialize($config);
					
					if( ! $this->upload->do_upload("fpfile")){
						echo $this->upload->display_errors();
					}

					$arr3 = array(
						'active'		=>	1,
						'id_fundraise'	=>	$id,
						'img_name'		=>	$this->upload->file_name
					);
					$new3 = OUser::edit_fundmg($arr3, $id);
				}
			}
			
			$image_arr = NULL;
			if($_POST['image'] != NULL)
			{
				foreach($_POST['image'] as $image)
				{
					$image_file = OLsmList::save_fundraise_photo($image);
					$image_arr[] = array("id_fundraise" => $id, "image_name" => $image_file);
				}
				$photos = OLsmList::add_fund_photo_batch($image_arr);
			}
			
			$video_arr = NULL;
			$vd = array_filter($_POST['video'], 'strlen');
			if(!empty($vd)) {
				foreach($_POST['video'] as $video)
				{
					$video_arr[] = array("id_fundraise" => $id, "video_link" => $video);
				}
				$vids = OLsmList::add_fund_video_batch($video_arr);
			}
			
			$files = glob('assets/images/temp/*');
			foreach($files as $file){
			  if(is_file($file))
				unlink($file);
			}

			$exec = OUser::edit_fund($arr1, $id);
			
			if($exec) warning("edit", "success");
			else warning("edit", "fail");				
			redirect($this->curpage);
			exit();
		}
		
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'fundpage_form', $data);
		$this->load->view($this->ffoot, $data);	
	}

	public function delete_photo()
	{
		$id  = $this->uri->segment(4);
		$gd  = $this->uri->segment(5);
		
		$res = OUser::fgallery_delete($gd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage.'/edit/'.$id);
		exit();
	}

	public function delete_video()
	{
		$id  = $this->uri->segment(4);
		$fvd = $this->uri->segment(5);
		
		$res = OUser::fvideo_delete($fvd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage.'/edit/'.$id);
		exit();
	}
}

/* End of file lsm_list.php */
/* Location: ./application/controllers/admin/lsm_list.php */
