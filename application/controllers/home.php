<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
		$this->load->view('home', $data);
		$this->load->view('footer', $data);
	}
	
	public function register()
	{
		if(!$this->session->userdata("after_login_url"))
		{
			$this->session->set_userdata("after_login_url", $_SERVER['HTTP_REFERER']);
		}
		
		if(sizeof($_POST) > 0)
		{			
			extract($_POST);
			
			$this->form_validation->set_rules('name', 'Nama', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[confirm_password]|md5');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if ($this->form_validation->run() == TRUE)
			{
				$inc_arr = array("name", "address", "id_city", "phone", "fax", "email", "password", "zip_code", "state");
				$arr = NULL;
				foreach($_POST as $key => $val)
				{
					if(in_array($key, $inc_arr))
					{
						if($key == "password") $val = md5($val);								
						$arr[$key] = $val;
					}
				}
				
				$exec = OUser::add($arr);
				
				if($exec)
				{			
					set_login_session($email, md5(md5($password)), $type="user");
					
					$referal = $this->session->userdata("after_login_url");
					$this->session->unset_userdata("after_login_url");
					redirect($referal);
				}
			}
		}
		
		$this->load->view('header',$data);
		$this->load->view('user_register', $data);
		$this->load->view('footer', $data);
	}
	
	public function user_login()
	{
		$referal = $_SERVER['HTTP_REFERER'];
		
		if(sizeof($_POST) > 0)
		{
			extract($_POST);
			
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			if ($this->form_validation->run() == TRUE)
			{
				$user = get_user($email,md5(md5($password)));
				
				if(!$user) 
				{
					$this->session->set_flashdata('err_login', "Invalid Email and Password Combination.");
					redirect($referal);
				}
				else 
				{
					set_login_session($email, md5(md5($password)), $type="user");
					redirect($referal);
				}
			} else {
				$this->session->set_flashdata('login_err', validation_errors());
				redirect($referal);
			}
		}
	}
	
	public function login_facebook()
	{
		$referal = $_SERVER['HTTP_REFERER'];
		
		if(!empty($referal) && !stristr($referal, '/home'))
		{
			$this->session->set_userdata("after_login_url", $referal);
		}
		
		if(!isset($_GET['code']))
		{
			redirect($referal); 
			exit();
		}
		else if(sizeof($_POST) == 0)
		{
			$this->load->library("curl");
			
			$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->config->item('appId').'&redirect_uri='.base_url("home/login_facebook").'&client_secret='.$this->config->item('secret').'&code='.$_GET['code'];
			
			$token_data = file_get_contents($token_url);
			
			preg_match("/access_token=([^&]+)/",$token_data,$token);
            
			$access_token = $token[1];

			$url = 'https://graph.facebook.com/me?access_token='.$access_token;
			$data = file_get_contents($url);
			
			$this->session->set_userdata("fb_data", $data);
			$this->session->set_userdata("fb_access_token", $access_token);
			
            $data_b['my_data']  =json_decode(file_get_contents($url),true);
		} else {
			if($this->session->userdata("fb_data") == "") { redirect($this->session->userdata("after_login_url")); exit(); }
			$data_b['my_data'] = json_decode($this->session->userdata("fb_data"));
		}
		
		$dataku = json_decode($this->session->userdata("fb_data"));
		$cek = $this->db->query("SELECT * FROM buyer WHERE fb_id = ? LIMIT 1", array($dataku->id));
				
		if(!emptyres($cek)) 
		{	
			$r = $cek->row();
			extract(get_object_vars($r));
			$U = new OUser();
			$U->setup($r);
			$U->edit(
					array(
						'fb_id' 			=> $dataku->id,
						'fb_access_token' 	=> $access_token
					)
				);
			set_login_session($r->email, $r->password, $type="user");
			
			$referal = $this->session->userdata("after_login_url");
			redirect($referal);
		}
		else
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]|md5|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('no_handphone', 'No. Handphone', 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			if ($this->form_validation->run() == TRUE)
			{
				if(isset($_GET['code'])) 
				{
					$FB = json_decode($this->session->userdata("fb_data"));
					$this->session->unset_userdata("fb_data");					
					
					$access_token_b = $this->session->userdata("fb_access_token");
					$this->session->unset_userdata("fb_access_token");
					
					$password = $_POST['password'];
									
					$location = $FB->location->name;
					if($location == NULL)
					{
						$location = "-";
					}
					
					$mail = ($_POST['email'] != '') ? $_POST['email'] : $FB->email ;
					
					$arr = array(
						'name' 				=> $FB->name,
						'email'				=> $mail,
						'password'			=> md5($password),
						'address'			=> $location,
						'fb_id' 			=> $FB->id,
						'fb_access_token' 	=> $access_token_b,
						'phone'				=> $_POST['no_handphone']
					);
					$exec = OUser::add($arr);
					
					set_login_session($mail, md5($password), $type="user");
					
					$referal = $this->session->userdata("after_login_url");
					redirect($referal);
				}
				elseif(isset($_GET['error_reason'])) {
					redirect("");
				}
			}
			$this->load->view('header',$data_b);
			$this->load->view('fb_login_form', $data_b);
			$this->load->view('footer', $data_b);
		}
	}
	
	public function organizer_login()
	{
		$referal = $_SERVER['HTTP_REFERER'];
		
		if(sizeof($_POST) > 0)
		{
			extract($_POST);
			
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			$this->form_validation->set_error_delimiters('', '<br />');
			
			if ($this->form_validation->run() == TRUE)
			{
				$user = get_sorganizer($email,md5(md5($password)));
				
				if(!$user) 
				{
					$this->session->set_flashdata('err_login', "Invalid Email and Password Combination.");
					redirect($referal);
				}
				else 
				{
					set_login_session($email, md5(md5($password)), $type="organizer");
					redirect($referal);
				}
			} else {
				$this->session->set_flashdata('login_err', validation_errors());
				redirect($referal);
			}
		}
	}
	
	public function logout()
	{
		session_start();
		session_destroy();
		unset_login_session($type="user");
		unset_login_session($type="organizer");
		$this->session->sess_destroy();
		redirect("");
	}
	
	public function set_lang()
	{
		$this->input->set_cookie('lang', $this->uri->segment(3), 0);
		// $this->session->set_userdata('lang', $this->uri->segment(3));
		redirect($_SERVER['HTTP_REFERER']);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */