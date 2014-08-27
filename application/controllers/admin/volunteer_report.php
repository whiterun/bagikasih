<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/volunteer_report";
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
		else $data['list'] 		= OLsmList::get_volunteer_report_list($start, $perpage);
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'volunteer_report_list', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function delete($id)
	{
		$res = $this->db->delete('volunteer_report', array('id_vreport' => $id));
		
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
}

/* End of file lsm_list.php */
/* Location: ./application/controllers/admin/lsm_list.php */