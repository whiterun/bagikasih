<?php

class OUser
{
	var $CI;
	var $db;
	var $row;
	var $id;
	
	public function __construct($id, $type="id")
	{
		$CI = & get_instance();
		$this->CI = $CI;
		$this->db = $CI->db;
		if(empty($id))
		{
			$this->id = false;
			$this->row = false;
		}
		else
		{
			if($type == "id")
			{
				$q = "SELECT * FROM buyer WHERE id_buyer = ?";
			}
			else 
			{
				$q = "SELECT * FROM buyer WHERE url_title = ?";
			}
			$res = $this->db->query($q,array($id));
			if(emptyres($res)) 
			{
				$this->id = false;
				$this->row = false;
			}
			else
			{
				$this->row = $res->row();
				$this->id = $this->row->id;
			}
		}		
	}
	
	public function setup($row)
	{
		if($row->id != "")
		{
			$this->row = $row;
			$this->id = $row->id;
		}
		else return false;
	}
	
	public static function add($params)
	{
		$CI =& get_instance();
		$CI->db->insert('buyer',$params);
		return $CI->db->insert_id();
	}
	
	public function edit($params, $id)
	{
		return $this->db->update('buyer',$params,array('id_buyer' => $id));
	}
	
	public function delete($id)
	{
		return $this->db->query("DELETE FROM buyer WHERE id_buyer = ?", array($id));		
	}
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id_buyer DESC")
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;		
		
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		*/
		// order by
		if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM buyer {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_fundpage_list($page=0, $limit=0, $orderby="id_fundraise DESC", $where = '')
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		//where
		if(trim($where) != "") $add_sql_stats .= " WHERE ".$where." ";
		// order by
		if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM fundraise_list {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_fundpage_update($page=0, $limit=0, $orderby="id_fupdate DESC", $where = '')
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		//where
		if(trim($where) != "") $add_sql_stats .= " WHERE ".$where." ";
		// order by
		if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM fundraise_update {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function drop_down_select($name, $selval, $optional="")
	{
		$list = OUser::get_list(0, 0, "name ASC");
		
		foreach($list as $r)
		{
			$arr[$r->id] = $r->name." (".$r->email.")";			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public static function check_email_exists($email, $id_exception=0)
	{
		$ci =& get_instance();
		$q = "SELECT * FROM buyer WHERE email = ? AND id_buyer != ? LIMIT 1";
		$res = $ci->db->query($q, array($email, $id_exception));
		if(!emptyres($res)) return $res->row();
		else return false;
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM buyer
                WHERE id_buyer = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (email LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();
    }
	
	public static function add_contribution($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('contribution',$arr);
		return $CI->db->insert_id();
	}
	
	public static function add_contribution_money($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('contribution_money',$arr);
		return $CI->db->insert_id();
	}
	
	public function konfirm($params, $id)
	{
		return $this->db->update('contribution', $params, array('id_contribution' => $id));
	}
	
	public static function add_volunteer($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('volunteer',$arr);
		return $CI->db->insert_id();
	}
	
	public static function fundpage_select($name, $selval, $optional="", $rr="")
	{
		$list = OUser::get_fundpage_list(0, 0, "id_fundraise ASC", $rr);
		
		foreach($list as $r)
		{
			$arr[$r->id_fundraise] = $r->name;
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public static function add_fupdate($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('fundraise_update',$arr);
		return $CI->db->insert_id();
	}
	
	public function fdelete($id)
	{
		$this->db->query("DELETE FROM fundraiser WHERE id_fundraise = ?", array($id));
		$this->db->query("DELETE FROM fundraise_gallery WHERE id_fundraise = ?", array($id));
		$this->db->query("DELETE FROM fundraise_image WHERE id_fundraise = ?", array($id));
		$this->db->query("DELETE FROM fundraise_update WHERE id_fundraise = ?", array($id));
		$this->db->query("DELETE FROM fundraise_video_link WHERE id_fundraise = ?", array($id));
		return $this->db->query("DELETE FROM fundraise_list WHERE id_fundraise = ?", array($id));
	}
	
	public function fupdate_delete($id)
	{
		return $this->db->query("DELETE FROM fundraise_update WHERE id_fupdate = ?", array($id));
	}
	
	public function fupdate_edit($params, $id)
	{
		return $this->db->update('fundraise_update',$params,array('id_fupdate' => $id));
	}
	
	public function fvideo_delete($id)
	{
		return $this->db->query("DELETE FROM fundraise_video_link WHERE id_flvideo = ?", array($id));
	}
	
	public function fgallery_delete($id)
	{
		$old = get_fgimg($id)->image_name;
		$del = $this->db->delete('fundraise_gallery',array('id_fgallery' => $id));		
		
		if(!$del) return false;
		else
		{
			OUser::delete_photo($old);
			return true;
		}
	}
	
	public static function delete_photo($image)
	{
		return delete_photo($image, "lsfund", array("600", "400", "200"));
	}
	
	public function edit_fund($params, $id)
	{
		return $this->db->update('fundraise_list', $params, array('id_fundraise' => $id));
	}
	
	public function edit_fundmg($params, $id)
	{
		$this->db->query("DELETE FROM fundraise_image WHERE id_fundraise = ?", array($id));
		return $this->db->insert('fundraise_image', $params);
	}
	
	public function contribution_delete($id)
	{
		return $this->db->query("DELETE FROM contribution WHERE id_contribution = ?", array($id));
	}
}
?>