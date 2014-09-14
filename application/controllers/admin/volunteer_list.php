<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/volunteer_list";
		// error_reporting(E_ALL);
		
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
		
		if($_GET['keyword'] != "") $data['list'] = OLsmList::search($_GET['keyword']);
		else $data['list'] 		= OLsmList::get_volunteer_list($start, $perpage);
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'volunteer_list', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function detail($id)
	{
		$data['vol'] = get_volunteer($id);
		
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'volunteer_detail', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		
		extract($_POST);
		
		if(count($_POST) > 0)
		{	
			$arr = array(
				'activity'			=>	$activity,
				'on_behalf'			=>	$on_behalf,
				'participant'		=>	$participant,
				'date_activity'		=>	$date_activity
			);
			
			$res = $this->db->update('volunteer', $arr, array('id_volunteer' => $id));
			
			if($res) warning("edit", "success");
			else warning("edit", "fail");
			redirect($this->curpage);
			exit();
		}
		
		$data['vol'] = get_volunteer($id);
		
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'volunteer_edit', $data);
		$this->load->view($this->ffoot, $data);	
	}
	
	public function delete($id)
	{
		$res = $this->db->delete('volunteer', array('id_volunteer' => $id));
		
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
	
	public function suspend()
	{
		$id = $this->uri->segment(4);
		
		$res = $this->db->update('volunteer', array('suspend' => 1), array('id_volunteer' => $id));
		
		if($res) $this->session->set_flashdata("success", "Your selected volunteer has been suspended.");
		else $this->session->set_flashdata("warning", "Your selected volunteer can't be suspended.");
		redirect($_SERVER['HTTP_REFERER']);
	}
}

/* End of file lsm_list.php */
/* Location: ./application/controllers/admin/lsm_list.php */