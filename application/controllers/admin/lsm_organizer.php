<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lsm_Organizer extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->fhead 	= "admin/header";
        $this->ffoot 	= "admin/footer";
        $this->fpath 	= "admin/";
        $this->curpage 	= "admin/lsm_organizer";
        
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
        if($_GET['keyword'] != "") $data['list'] = OLsmOrganizer::search($_GET['keyword']);
        else $data['list'] = OLsmOrganizer::get_list($start, $perpage, "id_organizer DESC");
        $data['uri'] 		= intval($start);
        $total 				= get_db_total_rows();
        $url 				= $this->curpage."/listing?";
        
        $data['pagination'] = getPagination($total, $perpage, $url, 5);
        
        $data['cu'] = $this->cu;
        $this->load->view($this->fhead, $data);
        $this->load->view($this->fpath.'lsm_organizer_list', $data);
        $this->load->view($this->ffoot, $data);
    }
    
    public function add()
    {
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check[""]');
		$this->form_validation->set_error_delimiters('<br /><span class="red">', '</span>');
	
		if($this->form_validation->run() == TRUE)
		// setup validations
        //if(sizeof($_POST) > 0)
        {
			extract($_POST);
            
            $arr = NULL;
            $exclude_arr = array("submit","url_title","password");
            
            foreach($_POST as $key => $val)
            {
				if(trim($val) != "") $arr[$key] = trim($val);	
            }
            
            $new = OLsmOrganizer::add($arr);
            if($new) warning("add", "success");
            else warning("add", "fail");
			// update photo
			$O = new OLsmOrganizer($new);
			foreach($_POST['image'] as $image)
			{
				$O->update_photo($image);
			}
			if($_POST['password'] != "")
			{
				$O->edit(array('password' => md5(md5($_POST['password']))));
			}
			unset($O);
            redirect($this->curpage);
            exit();
        }
        $data['cu'] = $this->cu;
        $this->load->view($this->fhead, $data);
        $this->load->view($this->fpath.'lsm_organizer_form', $data);
        $this->load->view($this->ffoot, $data);	
    }
    
    public function edit($id)
    {
        $O = new OLsmOrganizer($id);
        
        if(!empty($id))
        {			
            if($O->row == FALSE)
            {
                $this->session->set_flashdata('warning', 'ID does not exist.');
                redirect($this->curpage);
                exit();
            }
        }
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check['.$id.']');
		$this->form_validation->set_error_delimiters('<br /><span class="red">', '</span>');
	
		if($this->form_validation->run() == TRUE)
      	//if(sizeof($_POST) > 0)
        {
			extract($_POST);
            
            $arr = NULL;
            
            foreach($_POST as $key => $val)
            {
                $arr[$key] = trim($val);
            }
            
            $res = $O->edit($arr, $id);
            // update photo
            foreach($_POST['image'] as $image)
            {
                $O->update_photo($image);
            }
			if($_POST['password'] != "")
			{
				$O->edit(array('password' => md5(md5($_POST['password']))), $id);
			}
            if($res) warning("edit", "success");
            else warning("edit", "fail");
			unset($O);
            redirect($this->curpage);
            exit();
        }
        $data['cu'] = $this->cu;
        $data['row'] = $O->row;
        $this->load->view($this->fhead, $data);
        $this->load->view($this->fpath.'lsm_organizer_form', $data);
        $this->load->view($this->ffoot, $data);	
    }
	
	public function email_check($email, $id_exception)
	{
		if(OLsmOrganizer::check_email_exists($email, $id_exception)) {
			$this->form_validation->set_message('email_check', 'This email has been taken, please use another email');
			return FALSE;
		}else return true;
	}
    
    public function delete($id)
    {
        $O = new OLsmOrganizer($id);
        
        $res = $O->delete($id);
        if($res) warning("delete", "success");
        else warning("delete", "fail");
		unset($O);
        redirect($this->curpage);
        exit();
    }
	
	public function delete_photo($id)
	{
		$O = new OLsmOrganizer($id);
        
		$arr['photo'] = '';
        $res = $O->edit($arr);
        if($res) warning("delete", "success");
        else warning("delete", "fail");
		unset($O);
        redirect($this->curpage."/edit/".$id);
        exit();
	}
}

/* End of file lsm_organizer.php */
/* Location: ./application/controllers/admin/lsm_organizer.php */