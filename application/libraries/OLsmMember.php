<?php

class OLsmMember
{
	var $CI;
	var $db;
	var $row;
	var $id;
	
	public function __construct($id)
	{
		$CI = & get_instance();
		$this->CI = $CI;
		$this->db = $CI->db;
		if(intval($id) == 0)
		{
			$this->id = false;
			$this->row = false;
		}
		else
		{
			$q = "SELECT * FROM lsm_member WHERE id_member = ?";
			$res = $this->db->query($q,array($id));
			if(emptyres($res)) 
			{
				$this->id = false;
				$this->row = false;
			}
			else
			{
				$this->id = $id;
				$this->row = $res->row();
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
	
	public static function add($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('lsm_member',$arr);
		return $CI->db->insert_id();
	}
	
	public function edit($arr)
	{
		return $this->db->update('lsm_member',$arr,array('id_member' => $this->id));		
	}
	
	public function delete()
	{
		return $this->db->query("DELETE FROM lsm_member WHERE id_member = ?", array($this->id));
	}	
	
	public static function get_list($page=0, $limit=0, $orderby="id_member DESC", $where = "")
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lsm_member {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function drop_down_select($name, $selval, $optional="")
	{
		$list = OLsmMember::get_list(0, 0, "name ASC");
		
		foreach($list as $r)
		{
			$arr[$r->id_member] = $r->name;			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM lsm_member
                WHERE id_member = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (name LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
}
?>