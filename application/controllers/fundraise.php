<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fundraise extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->cu = $cu = get_logged_in_user();
		//error_reporting(E_ALL);
	}
	
	public function index()
	{
		$cu = get_logged_in_user();
		
		$this->load->view('header', $data);
		$this->load->view('fundraise_list', $data);
		$this->load->view('footer', $data);
	}
	
	public function search_fundraise()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db->from('fundraise_list')->like('name',$keyword)->get(); 
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'  =>$row->name
			);
		}
		echo json_encode($arr);
	}
	
	public function fraise_list()
	{
		$data['data'] = $_POST;
		$this->load->view('fraise_list',$data);
	}
	
	public function fraise_list1()
	{
		$data['data'] = $_POST;
		$this->load->view('fraise_list1',$data);
	}
	
	public function details($id)
	{
		$data['fra'] = get_fundraise_byurl($id);
		
		$this->load->view('header', $data);
		$this->load->view('fundraise_details', $data);
		$this->load->view('footer', $data);
	}
	
	public function create()
	{
		$id = $this->uri->segment(3);
		$ls = $this->session->set_userdata('id_lsm', $id);
		
		if(!$this->session->userdata('id_lsm')) {
			$this->step_1();
		} else {
			$this->step_2();
		}
	}
	
	public function step_1()
	{
		$cu = get_logged_in_user();
		
		if(!$cu) redirect('fundraise');
		
		$this->load->view('header', $data);
		$this->load->view('fundraise_create_1', $data);
		$this->load->view('footer', $data);
	}
	
	public function step_2()
	{
		$cu = get_logged_in_user();
		
		if(!$cu) redirect('fundraise');
		
		$data['ils'] = $this->session->userdata('id_lsm');
		
		$data['fcl'] = OLsmList::get_fcolor();
		
		$this->load->view('header', $data);
		$this->load->view('fundraise_create_2', $data);
		$this->load->view('footer', $data);
	}
	
	public function save_fundraise()
	{
		extract($_POST);
		$cu = get_logged_in_user();
		$arr1 = array(
			'name'			=>	$name,
			'end_date'		=>	$end_date,
			'id_lsm'		=>	$id_lsm,
			'id_buyer'		=>	$cu->id_buyer,
			'theme'			=>	$pcolor,
			'url_title'		=>	random_string('alnum', 6),
			'background'	=>	$bgc,
			'fund_target'	=>	$target,
			'description'	=>	str_replace(array('<p>', '</p>'), '', $description)
		);
		
		$new = OLsmList::add_fund($arr1);
		
		if($bgc == 'yes') {
			$this->load->library('upload');

			$config['upload_path'] = './assets/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1024';
			$config['encrypt_name'] = TRUE;
			
			$this->upload->initialize($config);
			
			if( ! $this->upload->do_upload("fpfile")){
				echo $this->upload->display_errors();
			}

			// $file_name = $this->upload->file_name;
			
			$arr3 = array(
				'id_fundraise'	=>	$new,
				'img_name'		=>	$this->upload->file_name
			);
			$new3 = OLsmList::add_fund3($arr3);
		}
		if($new) 
		{
			$image_arr = NULL;
			if($_POST['image'] != NULL)
			{
				foreach($_POST['image'] as $image)
				{
					$image_file = OLsmList::save_fundraise_photo($image);
					$image_arr[] = array("id_fundraise" => $new, "image_name" => $image_file);
				}
				$photos = OLsmList::add_fund_photo_batch($image_arr);
			}
			
			$video_arr = NULL;
			$vd = array_filter($_POST['video'], 'strlen');
			if(!empty($vd)) {
				foreach($_POST['video'] as $video)
				{
					$video_arr[] = array("id_fundraise" => $new, "video_link" => $video);
				}
				$vid = OLsmList::add_fund_video_batch($video_arr);
			}
		
			$arr2 = array(
				'id_buyer'			=>	$cu->id_buyer,
				'id_fundraise'		=>	$new
			);
			$new2 = OLsmList::add_fund2($arr2);
			
			$files = glob('assets/images/temp/*');
			foreach($files as $file){
			  if(is_file($file))
			    unlink($file);
			}
		}
		
		if($new2) $this->session->set_flashdata("success", "Thanks for your participation.");
		else $this->session->set_flashdata("warning", "There is an error in the system. Please try again.");
		
		redirect('user/fundpage_list');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */