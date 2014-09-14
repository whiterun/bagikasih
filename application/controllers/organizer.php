<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->co = $co = get_logged_in_organizer();
		// if(!$co) user_logout();
		// error_reporting(E_ALL);
	}
	
	public function index()
	{
		$this->home();
	}
	
	public function home()
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
		
		if(sizeof($_POST) > 0)
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			extract($_POST);
			
			if ($this->form_validation->run() == TRUE)
			{
				$inc_arr = array("name", "fax", "email", "phone", "address", "id_city", "state", "zip_code");
				$arr = NULL;
				foreach($_POST as $key => $val)
				{
					if(in_array($key, $inc_arr))
					{
						$arr[$key] = $val;
					}
				}
				
				$exec = $this->db->update('lsm_organizer', $arr, array('id_organizer' => $co->id_organizer));
				if($exec)
				{
					if($email != $co->email) 
					{
						set_login_session($_POST['email'], $co->password, $type="organizer");
					}
					if($password != "")
					{
						set_login_session($co->email, md5($password), $type="organizer");
					}
					if($email != $co->email && $password != "") 
					{
						set_login_session($email, md5($password), $type="organizer");
					}
					
					$this->session->set_flashdata("success_profile", "Your profile has been updated.");
					redirect('organizer/home');
				}
				else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("organizer_profile", $data);
		$this->load->view("footer", $data);
	}
	
	public function donation_history()
	{
		if(!$this->co) user_logout();
		$this->load->view("header", $data);
		$this->load->view("organizer_donation_history", $data);
		$this->load->view("footer", $data);
	}
	
	public function confirm_donation()
	{
		extract($_POST);
		
		$id = $this->uri->segment(3);
		
		if(count($_POST) > 0)
		{
			$res = $this->db->update(
					'contribution',
					array('confirm' => 1),
					array('id_contribution' => $id));
			
			if($res)
			{
				$arr = array(
					'id_bank'			=> $bank,
					'description'		=> $description,
					'transfer_date'		=> $transfer_date,
					'account_number'	=> $account,
					'id_contribution'	=> $id
				);
				
				$res2 = $this->db->insert('contribution_confirm', $arr);
			}
			
			if($res2) $this->session->set_flashdata("success", "Your donation has been confirmed.");
			else $this->session->set_flashdata("warning", "Your donation can't confirmed.");
			redirect('user/donation_history');
		}

		$data['don'] = get_donation($id);
		
		$this->load->view('header', $data);
		$this->load->view('user_confirm_donation', $data);
		$this->load->view('footer', $data);
	}
	
	public function donation_detail()
	{
		$id = $this->uri->segment(3);
		
		$data['don'] = get_donation($id);
		$data['nod'] = get_confirm_donation($id, 'confirm');
		
		$this->load->view('header', $data);
		$this->load->view('organizer_donation_detail', $data);
		$this->load->view('footer', $data);
	}
	
	public function donation_delete($id)
	{
		$this->db->delete('contribution_confirm', array('id_contribution' => $id));
		$res = $this->db->delete('contribution', array('id_contribution' => $id));
		
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/donation_history');
		exit();
	}
	
	public function volunteer_history()
	{
		if(!$this->co) user_logout();
		$this->load->view("header", $data);
		$this->load->view("organizer_volunteer_history", $data);
		$this->load->view("footer", $data);
	}
	
	public function volunteer_detail($id)
	{
		$data['vol'] = get_volunteer($id);
		$this->load->view('organizer_volunteer_detail', $data);
	}
	
	public function volunteer_delete($id)
	{
		$this->db->delete('volunteer_report', array('id_volunteer' => $id));
		$res = $this->db->delete('volunteer', array('id_volunteer' => $id));
		
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/volunteer_history');
		exit();
	}
	
	public function fundpage_list()
	{
		if(!$this->co) user_logout();
		$this->load->view("header", $data);
		$this->load->view("organizer_fundpage_list", $data);
		$this->load->view("footer", $data);
	}
	
	public function fundpage_edit($id)
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
		
		$data['fra'] = get_fundraise($id);
		
		$data['fcl'] = OLsmList::get_fcolor();
		
		if(sizeof($_POST) > 0)
		{
			extract($_POST);
		
			$arr1 = array(
				'name'			=>	$name,
				'end_date'		=>	$end_date,
				'id_fcolor'		=>	$pcolor,
				'url_title'		=>	random_string('alnum', 6),
				'background'	=>	$bgc,
				'fund_target'	=>	str_replace(',', '', $target),
				'description'	=>	str_replace(array('<p>', '</p>'), '', $description)
			);
			
			$exec = OUser::edit_fund($arr1, $id);
		
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

				$arr3 = array(
					'id_fundraise'	=>	$id,
					'img_name'		=>	$this->upload->file_name
				);
				$new3 = OUser::edit_fimage($arr3, $id);
			}
			
			if($exec) 
			{
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
			}
			
			if($exec)
			{	
				$this->session->set_flashdata("success", "Your selected fundpage has been updated.");
				redirect('organizer/fundpage_list');
			} else {
				$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("organizer_fundpage_edit", $data);
		$this->load->view("footer", $data);
	}
	
	public function fundpage_delete($id)
	{
        $res = OUser::fdelete($id);
        
        if($res) $this->session->set_flashdata("success", "Your selected fundpage has been deleted.");
        else $this->session->set_flashdata("warning", "Your fundpage can't deleted.");
        redirect($_SERVER['HTTP_REFERER']);
        exit();
	}
	
	public function lsm_update()
	{
		if(!$this->co) user_logout();
		$this->load->view("header", $data);
		$this->load->view("organizer_lsm_update", $data);
		$this->load->view("footer", $data);
	}
	
	public function lsm_update_new()
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
		
		extract($_POST); 
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == TRUE)
		{
			$arr = NULL;
			foreach($_POST as $key => $val)
			{
				if(trim($val) != "") $arr[$key] = trim($val);
			}
			
			$arr['id_organizer'] = $co->id_organizer;
			
			$new_id = OLsmUpdate::add($arr);
			
			if($new_id) warning("add", "success");
			else warning("add", "fail");			
			redirect('organizer/lsm_update');
			exit();
		}
		
		$data['co'] = $this->co;
		$data['act'] = "add";
		$this->load->view('header', $data);
		$this->load->view('organizer_lsm_update_form', $data);
		$this->load->view('footer', $data);	
	}
	
	public function lsm_update_edit($id)
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
	
		$qr = new OLsmUpdate($id);
		
		if(!empty($id))
		{			
			if($qr->row == FALSE)
			{
				$this->session->set_flashdata('warning', 'ID does not exist.');
				redirect($this->curpage);
			}
		}
		
		extract($_POST);
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == TRUE)
		{	
			$arr = NULL;
			foreach($_POST as $key => $val)
			{
				if(trim($val) != "") $arr[$key] = trim($val);
			}
			
			$arr['id_organizer'] = $co->id_organizer;
			
			$res = $qr->edit($arr);
			if($res) warning("edit", "success");
			else warning("edit", "fail");				
			redirect('organizer/lsm_update');
			exit();
		}
		$data['co'] = $this->co;
		$data['row'] = $qr->row;
		$data['act'] = "edit";
		$this->load->view('header', $data);
		$this->load->view('organizer_lsm_update_form', $data);
		$this->load->view('footer', $data);	
	}
	
	public function lsm_update_delete($id)
	{
		$qr = new OLsmUpdate($id);		
		
		$res = $qr->delete();
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/lsm_update');
		exit();
	}
	
	public function edit_lsm()
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
	
		$qr = new OLsmList($co->id_lsm);
		
		if(!empty($co->id_lsm))
		{			
			if($qr->row == FALSE)
			{
				$this->session->set_flashdata('warning', 'ID does not exist.');
				redirect($this->curpage);
			}
		}
		
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$arr1 = array(
				'id_kota'			=>	$kota,
				'name'				=>	$lname,
				'fund_target'		=>	str_replace(',', '', $target),
				'address'			=>	$address,
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
			
			$image_arr = NULL;
			if($_POST['image'] != NULL) {
				foreach($_POST['image'] as $image) {
					$image_file = OLsmList::save_lsm_photo($image);
					$image_arr[] = array("id_lsm" => $co->id_lsm, "image_name" => $image_file);
				}
				$photos = OLsmList::add_lsm_photo_batch($image_arr);
			}
			
			$video_arr = NULL;
			$vd = array_filter($_POST['video'], 'strlen');
			if(!empty($vd)) {
				foreach($_POST['video'] as $video) {
					$video_arr[] = array("id_lsm" => $co->id_lsm, "video_link" => $video);
				}
				$vids = OLsmList::add_lsm_video_batch($video_arr);
			}
			
			$files = glob('assets/images/temp/*');
			foreach($files as $file){
				if(is_file($file))
					unlink($file);
			}
			
			$new = $qr->edit($arr1);
			
			if($new) warning("edit", "success");
			else warning("edit", "fail");				
			redirect('organizer/edit_lsm');
			exit();
		}
		$data['co'] = $this->co;
		$data['row'] = $qr->row;
		$data['act'] = "edit";
		$this->load->view('header', $data);
		$this->load->view('organizer_lsm_form_edit', $data);
		$this->load->view('footer', $data);	
	}
	
	public function edit_bank_account()
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
	
		$qr = new OLsmList($co->id_lsm);
		
		if(!empty($co->id_lsm))
		{			
			if($qr->row == FALSE)
			{
				$this->session->set_flashdata('warning', 'ID does not exist.');
				redirect($this->curpage);
			}
		}
		
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$arr1 = array(
				'id_bank'			=>	$bank,
				'acc_holder'		=>	$aholder,
				'acc_number'		=>	$anumber
			);
			
			$new = $qr->edit($arr1);
			
			if($new) warning("edit", "success");
			else warning("edit", "fail");				
			redirect('organizer/edit_bank_account');
			exit();
		}
		$data['co'] = $this->co;
		$data['row'] = $qr->row;
		$data['act'] = "edit";
		$this->load->view('header', $data);
		$this->load->view('organizer_lsm_bank_edit', $data);
		$this->load->view('footer', $data);	
	}
	
	public function security()
	{
		if(!$this->co) user_logout();
		$data['co'] = $co = $this->co;
		
		if(sizeof($_POST) > 0)
		{	
			extract($_POST);
			
			$this->form_validation->set_rules('password', 'Password', 'trim|required||min_length[6]|matches[retype_password]|md5');
			$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|min_length[6]');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			if ($this->form_validation->run() == TRUE)
			{
				$arr = NULL;
				$arr['password'] = md5($_POST['password']);
				
				$exec = $this->db->update('lsm_organizer', $arr, array('id_organizer' => $co->id_organizer));
				if($exec)
				{
					if($password != "")
					{
						set_login_session($co->email, md5($_POST['password']), $type="organizer");
					}
					$this->session->set_flashdata("success", "Your password has been updated.");
					redirect('organizer/security');
				} else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("organizer_pass", $data);
		$this->load->view("footer", $data);
	}
	
	public function delete_video()
	{
		$fvd = $this->uri->segment(3);
		
		$res = OLsmList::lvideo_delete($fvd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/edit_lsm');
		exit();
	}
	
	public function delete_photo()
	{
		$gd  = $this->uri->segment(3);
		
		$res = OLsmList::lgallery_delete($gd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/edit_lsm');
		exit();
	}
	
	public function delete_fvideo()
	{
		$id = $this->uri->segment(3);
		$fvd = $this->uri->segment(4);
		
		$res = OUser::fvideo_delete($fvd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/fundpage_edit/'.$id);
		exit();
	}
	
	public function delete_fphoto()
	{
		$id  = $this->uri->segment(3);
		$gd  = $this->uri->segment(4);
		
		$res = OUser::fgallery_delete($gd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('organizer/fundpage_edit/'.$id);
		exit();
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */