<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	var $head = "admin/header";
	var $foot = "admin/footer";
	var $curpage = "admin/home";
	var $admin;
	
	public function __construct()
	{
		parent::__construct();
		$this->admin = get_current_admin();
	}
	
	public function index()
	{
		if(!$this->admin) $this->login();
		else $this->main();
	}
	
	public function main()
	{
		if(!$this->admin) admin_login();
		$data['home_nav'] = "active";
		
		$this->load->view($this->head, $data);
		$this->load->view('admin/home');
		$this->load->view($this->foot);
	}
	
	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
		if ($this->form_validation->run() == TRUE)
		{
			extract($_POST);
			$admin_res = get_admin($username, md5($password));
			//var_dump($_POST, $username, md5($password)); die();
			if($admin_res == FALSE) $this->session->set_flashdata("warning", "Invalid account.");
			else set_login_session($username, md5($password));
			redirect($this->curpage); 
			exit();
		}
		$this->load->view('admin/login_form');
	}
	
	public function logout()
	{
		unset_login_session("admin");
		redirect($this->curpage); 
		exit();
	}
}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */