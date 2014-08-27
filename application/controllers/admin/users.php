<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->fhead 	= "admin/header";
        $this->ffoot 	= "admin/footer";
        $this->fpath 	= "admin/";
        $this->curpage 	= "admin/users";
        
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
        if($_GET['keyword'] != "") $data['list'] = OUser::search($_GET['keyword']);
        else $data['list'] = OUser::get_list($start, $perpage, "id_buyer DESC");
        $data['uri'] 		= intval($start);
        $total 				= get_db_total_rows();
        $url 				= $this->curpage."/listing?";
        
        $data['pagination'] = getPagination($total, $perpage, $url, 5);
        
        $data['cu'] = $this->cu;
        $this->load->view($this->fhead, $data);
        $this->load->view($this->fpath.'users_list', $data);
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
                if(!in_array($key, $exclude_arr))
                {	
                    if(trim($val) != "") $arr[$key] = trim($val);	
                }
            }
            
            $new = OUser::add($arr);
            if($new) warning("add", "success");
            else warning("add", "fail");
			// update photo
			$O = new OUser($new);
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
        $this->load->view($this->fpath.'users_form', $data);
        $this->load->view($this->ffoot, $data);	
    }
    
    public function edit($id)
    {
        $O = new OUser($id);
        
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
            $exclude_arr = array("submit","url_title","password","image");
            
            foreach($_POST as $key => $val)
            {
                if(!in_array($key, $exclude_arr))
                {	
                    $arr[$key] = trim($val);	
                }
            }
            
            $res = $O->edit($arr, $id);
            // update photo
            foreach($_POST['image'] as $image)
            {
                $O->update_photo($image);
            }
			if($_POST['password'] != "")
			{
				$O->edit(array('password' => md5(md5($_POST['password']))));
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
        $this->load->view($this->fpath.'users_form', $data);
        $this->load->view($this->ffoot, $data);	
    }
	
	public function email_check($email, $id_exception)
	{
		if(OUser::check_email_exists($email, $id_exception)) {
			$this->form_validation->set_message('email_check', 'This email has been taken, please use another email');
			return FALSE;
		}else return true;
	}
    
    public function delete($id)
    {
        $O = new OUser($id);
        
        $res = $O->delete($id);
        if($res) warning("delete", "success");
        else warning("delete", "fail");
		unset($O);
        redirect($this->curpage);
        exit();
    }	
    
    // this is an ajax call from the view list for sorting purposes.
    public function sorting()
    {
		$sorts = explode(",",$this->input->post('sorts'));
		$this->db->update('users',array('ordering' => 0));
		$count = 1;
		foreach($sorts as $id)
		{
			$this->db->update('users',array('ordering' => $count),array('id' => intval($id)));
			$count++;
		}
		die("DONE");
    }
    
    /*public function set_active($active=0, $id)
    {	
        $O = new OUser($id);
        
        $arr['active'] = $active;
        $res = $O->edit($arr);
        
        if($res) warning("edit", "success");
        else warning("edit", "fail");
		unset($O);
        redirect($this->curpage);
        exit();
    }*/
	
	public function delete_photo($id)
	{
		$O = new OUser($id);
        
		$arr['photo'] = '';
        $res = $O->edit($arr);
        if($res) warning("delete", "success");
        else warning("delete", "fail");
		unset($O);
        redirect($this->curpage."/edit/".$id);
        exit();
	}
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */