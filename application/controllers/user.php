<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->cu = $cu = get_logged_in_user();
		// if(!$cu) user_logout();
		// error_reporting(E_ALL);
	}
	
	public function index()
	{
		$this->home();
	}
	
	public function home()
	{
		if(!$this->cu) user_logout();
		$data['cu'] = $cu = $this->cu;
		
		if(sizeof($_POST) > 0)
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check['.$cu->id_buyer.']');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			extract($_POST);
			
			if(trim($_POST['password']) != "" || trim($_POST['retype_password']) != "") 
			{
				$this->form_validation->set_rules('password', 'Password', 'trim|required||min_length[6]|matches[retype_password]|md5');
				$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|min_length[6]');
			}
			
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
						
				if(trim($_POST['password']) != "") 
				{
					$arr['password'] = md5($_POST['password']);
				}
				
				$U = new OUser();
				$U->setup($cu);
				
				if($userfile != NULL)
				{
					$image_file = OUser::save_image($userfile);
					$arr['image'] = $image_file;
					$U->delete_current_image();
				}				
				
				$exec = $U->edit($arr, $cu->id_buyer);
				if($exec)
				{
					if($_POST['email'] != $cu->email) 
					{
						set_login_session($_POST['email'], $cu->password, $type="user");
					}
					if($_POST['password'] != "")
					{
						set_login_session($cu->email, md5($_POST['password']), $type="user");
					}
					if($_POST['email'] != $cu->email && $_POST['password'] != "") 
					{
						set_login_session($_POST['email'], md5($_POST['password']), $type="user");
					}
					
					$this->session->set_flashdata("success_profile", "Your profile has been updated.");
					redirect('user/home');
				}
				else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$data['initcss'] = array("additional_user");
		
		$this->load->view("header", $data);
		$this->load->view("user_profile", $data);
		$this->load->view("footer", $data);
	}
	
	public function donation_history()
	{
		if(!$this->cu) user_logout();
		$this->load->view("header", $data);
		$this->load->view("user_donation_history", $data);
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
					array('confirm' => 1, 'amount' => str_replace(',', '', $amount)),
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
	
	public function confirmed_detail()
	{
		$id = $this->uri->segment(3);
		
		$data['don'] = get_donation($id);
		$data['nod'] = get_confirm_donation($id, 'confirm');
		
		$this->load->view('header', $data);
		$this->load->view('user_confirmed_detail', $data);
		$this->load->view('footer', $data);
	}
	
	public function volunteer_history()
	{
		if(!$this->cu) user_logout();
		$this->load->view("header", $data);
		$this->load->view("user_volunteer_history", $data);
		$this->load->view("footer", $data);
	}
	
	public function fundpage_list()
	{
		if(!$this->cu) user_logout();
		$this->load->view("header", $data);
		$this->load->view("user_fundpage_list", $data);
		$this->load->view("footer", $data);
	}
	
	public function fundpage_edit($id)
	{
		$cu = get_logged_in_user();
		
		$data['fra'] = get_fundraise($id);
		
		$data['fcl'] = OLsmList::get_fcolor();
		
		if(sizeof($_POST) > 0)
		{
			extract($_POST);
		
			$arr1 = array(
				'name'			=>	$name,
				'end_date'		=>	$end_date,
				'id_buyer'		=>	$cu->id_buyer,
				'theme'			=>	$pcolor,
				'background'	=>	$bgc,
				'fund_target'	=>	$target,
				'description'	=>	str_replace(array('<p>', '</p>'), '', $description)
			);
			
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
			
			if($exec)
			{	
				$this->session->set_flashdata("success", "Your fundpage has been updated.");
				redirect('user/fundpage_list');
			} else {
				$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("user_fundpage_edit", $data);
		$this->load->view("footer", $data);
	}
	
	public function fundpage_delete($id)
	{
        $res = OUser::fdelete($id);
        
        if($res) $this->session->set_flashdata("success", "Your fundpage has been deleted.");
        else $this->session->set_flashdata("warning", "Your fundpage can't deleted.");
        redirect($_SERVER['HTTP_REFERER']);
        exit();
	}
	
	public function fundpage_update($id)
	{
		if(!$this->cu) user_logout();
		$data['id'] = $id;
		$this->session->set_userdata('fup', $id);
		$this->load->view("header", $data);
		$this->load->view("user_fundpage_update", $data);
		$this->load->view("footer", $data);
	}
	
	public function new_fupdate()
	{
		if(sizeof($_POST) > 0)
		{
			// $this->form_validation->set_rules('fundpage', 'Fundpage', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			extract($_POST);
			
			if ($this->form_validation->run() == TRUE)
			{
				$fup = $this->session->userdata('fup');
				$arr = array(
					'id_fundraise'	=> $fup,
					'description'	=> $description,
					'date_created'	=> date('Y-m-d')
				);
				
				$exec = OUser::add_fupdate($arr);
				if($exec)
				{	
					$this->session->set_flashdata("success", "Your new fundpage update has been saved.");
					redirect('user/fundpage_update/'.$fup);
				}
				else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("user_new_fupdate", $data);
		$this->load->view("footer", $data);
	}
	
	public function fupdate_edit($id)
    {
		if(sizeof($_POST) > 0)
		{
			// $this->form_validation->set_rules('fundpage', 'Fundpage', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_error_delimiters('', '</br>');
	
			extract($_POST);
		
			if ($this->form_validation->run() == TRUE)
			{
				$fup = $this->session->userdata('fup');
				$arr = array(
					// 'id_fundraise'	=> $fundpage,
					'description'	=> $description
				);
				
				$exec = OUser::fupdate_edit($arr, $id);
				if($exec)
				{	
					$this->session->set_flashdata("success", "Your fundpage update has been updated.");
					redirect('user/fundpage_update/'.$fup);
				}
				else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$data['fup'] = get_fupdate($id);
		
        $this->load->view('header', $data);
        $this->load->view('user_edit_fupdate', $data);
        $this->load->view('footer', $data);	
    }
	
	public function fupdate_delete($id)
	{
		$res = OUser::fupdate_delete($id);

		if($res) $this->session->set_flashdata("success", "Your fundpage update has been deleted.");
		else $this->session->set_flashdata("warning", "Your fundpage update can't deleted.");
		redirect($_SERVER['HTTP_REFERER']);
		exit();
	}
	
	public function security()
	{
		if(!$this->cu) user_logout();
		$data['cu'] = $cu = $this->cu;
		
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
				
				$exec = OUser::edit($arr, $cu->id_buyer);
				if($exec)
				{
					if($_POST['password'] != "")
					{
						set_login_session($cu->email, md5($_POST['password']), $type="user");
					}
					$this->session->set_flashdata("success", "Your password has been updated.");
					redirect('user/security');
				} else {
					$data['error_string'] = "There is an error in the system. Please contact the website administrator.";					
				}				
			}
		}
		
		$this->load->view("header", $data);
		$this->load->view("user_pass", $data);
		$this->load->view("footer", $data);
	}
	
	public function delete_video()
	{
		$id  = $this->uri->segment(3);
		$fvd = $this->uri->segment(4);
		
		$res = OUser::fvideo_delete($fvd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('user/fundpage_edit/'.$id);
		exit();
	}
	
	public function delete_photo()
	{
		$id  = $this->uri->segment(3);
		$gd  = $this->uri->segment(4);
		
		$res = OUser::fgallery_delete($gd);
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect('user/fundpage_edit/'.$id);
		exit();
	}
	
	public function email_check($email, $id_exception)
	{
		if(OUser::check_email_exists($email, $id_exception)) {
			$this->form_validation->set_message('email_check', 'Email '.$email.' has been registered, please use another email');
			return FALSE;
		}else return true;
	}
	
	public function old_password_check($str)
	{
		$email = $this->session->userdata("hapikado_uname");
		$res = $this->db->query("SELECT * FROM users WHERE password = ? AND email = ?", array(md5(md5($str)), $email));
		if (emptyres($res))
		{
			$this->form_validation->set_message('old_password_check', 'Invalid your current password!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function donate()
	{
		$id = $this->uri->segment(3);
		$this->session->set_userdata('lsmid', $id);
		
		if($this->uri->segment(4) !== FALSE) {
			$id2 = $this->uri->segment(4);
			$this->session->set_userdata('fraid', $id2);
		}
		
		redirect('user/donation');
	}
	
	public function donation()
	{
		$data['msl'] = get_lsm($this->session->userdata('lsmid'));
		$this->load->view("header", $data);
		$this->load->view("donation_page", $data);
		$this->load->view("footer", $data);
	}
	
	public function currency_list()
	{
		$data['data'] = $_POST;
		$this->load->view('currency_list',$data);
	}
	
	public function save_donation()
	{
		extract($_POST);
		
		$id = $this->session->userdata('lsmid');
		$fd = $this->session->userdata('fraid');
		
		$lang = $this->session->userdata("lang");
		
		$cu = get_logged_in_user();
		
		$anon = (!$anonym) ? "no" : "yes" ;
		$updt = (!$update) ? "no" : "yes" ;
		$amnt = ($donval == 'other') ? str_replace(',', '', $otval) : $donval ;
		// $tpay = ($lang == 'en') ? $topay : 'transfer' ;
		$tpay = 'transfer';
		
		$arr = array(
			'name'				=>	$name,
			'email'				=>	$email,
			'id_lsm'			=>	$id,
			'anonym'			=>	$anon,
			'amount'			=>	$amnt,
			'up_date'			=>	$updt,
			'to_pay'			=>	$tpay,
			'currency'			=>	$currency,
			'id_buyer'			=>	$cu->id_buyer,
			'date_contribution'	=>	date('Y-m-d')
		);
		
		if($fd) $arr = array_merge($arr, array('id_fundraise' => $fd));
		
		$new = OUser::add_contribution($arr);		
		
		if($new)
		{
			$data = array(
				'to'		=>	get_lsm($id)->name,
				'name'		=>	$name,
				'email'		=>	$email,
				'amount'	=>	currency_format($amnt, $currency),
			);
		
			//email ke user
			$to_user = $email;
			$subject_user = "Bagikasih.com - Donation Detail";
			$body_user = $this->load->view('email_user', $data, TRUE);
			noreply_mail($to_user,$subject_user,$body_user);
			
			$admin_emails = array('fransing899@gmail.com', 'bagikasih.teams@gmail.com');
			
			foreach($admin_emails as $ae)
			{
				$to = $ae;
				$subject = "Bagikasih.com - Donation Detail";
				$body = $this->load->view('email_admin', $data, TRUE);
				noreply_mail($to,$subject,$body);
			}
			
			$this->session->set_userdata('caid');
			$this->session->unset_userdata('lsmid');
			$this->session->unset_userdata('fraid');
			redirect('user/donation_success');
		} else {
			$this->session->set_flashdata("warning", "There is an error in the system. Please try again.");
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function donation_success()
	{
		$this->load->view('header');
		$this->load->view('after_donate');
		$this->load->view('footer');
	}
	
	public function donation_delete($id)
	{
		$res = OUser::contribution_delete($id);

		if($res) $this->session->set_flashdata("success", "Your selected donation has been deleted.");
		else $this->session->set_flashdata("warning", "Your selected donation can't deleted.");
		redirect($_SERVER['HTTP_REFERER']);
		exit();
	}
	
	public function resend($id)
	{
		$don = get_donation($id);
		
		if($don->id_buyer != '')
		{
			$name = ($don->name != $cu->name && $don->name != '')? $don->name : $cu->name ;
			$email = ($don->email != $cu->email && $don->email != '')? $don->email : $cu->email ;
		} else {
			$name = $don->name;
			$email = $don->email;
		}
		
		$data = array(
			'to'		=>	get_lsm($don->id_lsm)->name,
			'name'		=>	$name,
			'email'		=>	$email,
			'amount'	=>	currency_format($don->amount, $don->currency),
		);
	
		//email ke user
		$to_user = $email;
		$subject_user = "Bagikasih.com - Donation Detail";
		$body_user = $this->load->view('email_user', $data, TRUE);
		noreply_mail($to_user,$subject_user,$body_user);
		
		$this->session->set_flashdata("success", "An email has been sent to your mail, please check your inbox immediately.");
		redirect($_SERVER['HTTP_REFERER']);
		exit();
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */