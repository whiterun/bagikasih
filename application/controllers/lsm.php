<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lsm extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->cu = $cu = get_logged_in_user();
		//error_reporting(E_ALL);	
		$this->config->load('facebook');
	}
	
	public function index()
	{
		$cu = get_logged_in_user();		
		
		$this->load->view('header', $data);
		$this->load->view('lsm_list', $data);
		$this->load->view('footer', $data);
	}

	public function search_kota()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db->from('kota')->like('name',$keyword)->get(); 
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'  =>$row->name,
				'data'   =>$row->id_kota
			);
		}
		echo json_encode($arr);
	}
	
	public function search_type_lsm()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db->from('lsm_category')->like('category',$keyword)->get(); 
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'  =>$row->category,
				'data'   =>$row->id_lsm_category
			);
		}
		echo json_encode($arr);
	}
	
	public function splash_list()
	{
		$data['data'] = $_POST;
		$this->load->view('splash_list',$data);
	}
	
	public function details($id)
	{
		$data['lsm'] = get_lsm($id);
		
		$this->load->view('header', $data);
		$this->load->view('lsm_details', $data);
		$this->load->view('footer', $data);
	}
	
	public function donate()
	{
		extract($_POST);
		
		$cu = get_logged_in_user();
		
		$arr1 = array(
			'type'				=>	'money',
			'id_lsm'			=>	$id_lsm,
			'id_buyer'			=>	$cu->id_buyer,
			'date_contribution'	=>	date('Y-m-d')
		);
		
		$new = OUser::add_contribution($arr1);		
		
		if($new)
		{
			$anon = (!$anonym) ? "no" : "yes" ;
			$arr2 = array(
				'id_contribution'	=>	$new,
				'anonym'			=>	$anon,
				'amount'			=>	$amount
			);
			OUser::add_contribution_money($arr2);
		}
		$this->load->view('header');
		$this->load->view('after_donate');
		$this->load->view('footer');
	}
	
	public function volunteer()
	{
		extract($_POST);
		
		$cu = get_logged_in_user();
		
		$arr = array(
			'id_lsm'			=>	$id_lsm,
			'activity'			=>	$activity,
			'on_behalf'			=>	$on_behalf,
			'participant'		=>	$participant,
			'id_buyer'			=>	$cu->id_buyer,
			'date_activity'		=>	$date_activity
		);
		$new = OUser::add_volunteer($arr);
		if($new) $this->session->set_flashdata("success", "Thanks for your participation.");
		else $this->session->set_flashdata("warning", "There is an error in the system. Please try again.");
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function cancel_volunteer()
	{
		extract($_POST);
		
		$val = array(
			'cancel_stat'	=>	1,
			'cancel_date'	=>	date('Y-m-d'),
			'reason'		=>	$reason
		);
		
		$res = $this->db->update('volunteer', $val, array('id_volunteer' => $id_volunteer));
		
		if($res)
		{
			$admin_emails = array(
				0 => array('user' => 'Frans Yuwono', 'email' => 'fransing899@gmail.com'),
				1 => array('user' => 'Bagikasih Teams', 'email' => 'bagikasih.teams@gmail.com')
			);
			
			$admin_emails = array_merge($admin_emails, array(
				2 => array(
					'user' => get_organizer(get_volunteer($id_volunteer)->id_lsm)->name,
					'email' => get_organizer(get_volunteer($id_volunteer)->id_lsm)->email
					)
				)
			);
			
			// email admin
			foreach($admin_emails as $ae)
			{
				$data = array(
					'lsm'		=>	get_lsm(get_volunteer($id_volunteer)->id_lsm)->name,
					'user'		=>	get_buyer(get_volunteer($id_volunteer)->id_lsm)->name,
					'date'		=>	get_volunteer($id_volunteer)->date_activity,
					'admin'		=>	$ae[user],
					'reason'	=>	$reason
				);
				
				$to = $ae[email];
				$subject = "Bagikasih.com - Volunteer Cancelled";
				$body = $this->load->view('email_cancel_volunteer', $data, TRUE);
				noreply_mail($to,$subject,$body);
			}
			
			$this->session->set_flashdata("success", "Your selected volunteer schedule has been canceled");
		} else {
			$this->session->set_flashdata("warning", "Your selected volunteer schedule can't be canceled");
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function report_volunteer()
	{
		extract($_POST);
		
		$val = array(
			'report_as'		=>	$rep,
			'report_date'	=>	date('Y-m-d'),
			'id_volunteer'	=>	$id_volunteer
		);
		
		if($other != '') $val = array_merge($val, array('other' => $other));
		
		$res = $this->db->insert('volunteer_report', $val);
		
		if($res) $this->session->set_flashdata("success", "Thanks for your participation. We will process your report later");
		else $this->session->set_flashdata("warning", "There is an error in the system. Please try again.");
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function register_project()
	{
		$this->load->view('header', $data);
		$this->load->view('register_project', $data);
		$this->load->view('footer', $data);
	}
	
	public function save_project()
	{
		extract($_POST);
		
		$cu = get_logged_in_user();		
		
		$arr1 = array(
			'id_bank'			=>	$bank,
			'id_kota'			=>	$kota,
			'name'				=>	$lname,
			'fund_target'		=>	str_replace(',', '', $target),
			'address'			=>	$address,
			'acc_holder'		=>	$aholder,
			'acc_number'		=>	$anumber,
			'url_title'			=>	$urlname,
			'id_lsm_category'	=>	$category,
			'deskripsi'			=>	str_replace(array('<p>', '</p>'), '', $deskripsi)
		);
		
		if(!empty($_FILES['userfile']['name']))
		{
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
		if($new2) {
			$this->session->set_flashdata("success", "Thanks for your participation.");
			redirect('lsm/register_success');
		} else {
			$this->session->set_flashdata("warning", "There is an error in the system. Please try again.");
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function check_lname()
	{
		$res = $this->db->query("SELECT * FROM lsm_list WHERE name = ?", array($_POST['lname']));
		if (emptyres($res)) echo 0;
		else echo 1;
	}
	
	public function register_success()
	{
		$this->load->view('header');
		$this->load->view('after_register_project');
		$this->load->view('footer');
	}
	
	public function l_area()
	{
		$data['data'] = $_POST;
		$this->load->view('l_area',$data);
	}
	
	public function lget_area()
	{
		$data['data'] = $_POST;
		$this->load->view('get_area',$data);
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */