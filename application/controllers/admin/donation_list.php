<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fhead 	= "admin/header";
		$this->ffoot 	= "admin/footer";
		$this->fpath 	= "admin/";
		$this->curpage 	= "admin/donation_list";
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
		
		if($_GET['keyword'] != "") $data['list'] = OLsmList::search($_GET['keyword']);
		else $data['list'] 		= OLsmList::get_donation_list($start, $perpage);
		
		$data['uri'] 		= intval($start);
		$total 				= get_db_total_rows();
		$url 				= $this->curpage."/listing?";
		
		$data['pagination'] = getPagination($total, $perpage, $url, 5);
		
		$data['cu'] = $this->cu;
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'donation_list', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function detail($id)
	{
		$data['don'] = get_donation($id);
		$data['nod'] = get_confirm_donation($id, 'confirm');
		
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'donation_detail', $data);
		$this->load->view($this->ffoot, $data);
	}
	
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		
		extract($_POST);
		
		if(count($_POST) > 0)
		{
			$this->db->update('contribution',
					array('amount' => str_replace(',', '', $amount)),
					array('id_contribution' => $id));
			
			$arr = array(
				'id_bank'			=> $bank,
				'description'		=> $description,
				'transfer_date'		=> $transfer_date,
				'account_number'	=> $account,
				'id_contribution'	=> $id
			);
			
			$res = $this->db->update('contribution_confirm', $arr, array('id_contribution' => $id));
			
			if($res) warning("edit", "success");
			else warning("edit", "fail");				
			redirect($this->curpage);
			exit();
		}
		
		$data['don'] = get_donation($id);
		$data['nod'] = get_confirm_donation($id, 'confirm');
		
		$this->load->view($this->fhead, $data);
		$this->load->view($this->fpath.'donation_edit', $data);
		$this->load->view($this->ffoot, $data);	
	}
	
	public function delete($id)
	{
		$this->db->delete('contribution_confirm', array('id_contribution' => $id));
		$res = $this->db->delete('contribution', array('id_contribution' => $id));
		
		if($res) warning("delete", "success");
		else warning("delete", "fail");
		redirect($this->curpage);
		exit();
	}
	
	public function approve()
	{
		$id = $this->uri->segment(4);
		
		$res = $this->db->update('contribution', array('confirm' => 2), array('id_contribution' => $id));
		
		if($res)
		{
			$data['don'] = get_donation($id);
			$data['nod'] = get_confirm_donation($id, 'confirm');
			
			$admin_emails = array(
				0 => array('user' => 'Frans Yuwono', 'email' => 'fransing899@gmail.com'),
				1 => array('user' => 'Bagikasih Teams', 'email' => 'bagikasih.teams@gmail.com')
			);
			
			$admin_emails = array_merge($admin_emails, array(
				2 => array(
					'user' => get_organizer(get_donation($id)->id_lsm)->name,
					'email' => get_organizer(get_donation($id)->id_lsm)->email
					)
				)
			);
			
			if(get_donation($id)->id_fundraise != '')
			{
				$sr = get_buyer(get_fundraise(get_donation($id)->id_fundraise)->id_buyer)->name;
				$em = get_buyer(get_fundraise(get_donation($id)->id_fundraise)->id_buyer)->email;
				$admin_emails = array_merge($admin_emails, array(3 => array('user' => $sr, 'email' => $em)));
			}
			
			// echo '<pre>';
			// print_r($admin_emails);
			// echo '</pre>';
			
			//email ke user
			$to_user = get_buyer(get_donation($id)->id_buyer)->email;
			$subject_user = "Bagikasih.com - Donation Approved";
			$body_user = $this->load->view('admin/donation_email_user', $data, TRUE);
			noreply_mail($to_user,$subject_user,$body_user);
			
			// email admin
			foreach($admin_emails as $ae)
			{
				$data['user'] = $ae[user];
				$to = $ae[email];
				$subject = "Bagikasih.com - Donation Approved";
				$body = $this->load->view('admin/donation_email_admin', $data, TRUE);
				noreply_mail($to,$subject,$body);
			}
			
			$this->session->set_flashdata("success", "Your selected donation has been approved.");
		} else {
			$this->session->set_flashdata("warning", "Your selected donation can't be approved.");
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}

/* End of file lsm_list.php */
/* Location: ./application/controllers/admin/lsm_list.php */