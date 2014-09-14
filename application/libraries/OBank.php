<?php

class OBank
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
				$q = "SELECT * FROM bank WHERE id_bank = ?";
			}
			else 
			{
				$q = "SELECT * FROM bank WHERE url_title = ?";
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
		$CI->db->insert('bank',$params);
		return $CI->db->insert_id();
	}
	
	public function edit($params, $id)
	{
		return $this->db->update('bank',$params,array('id_bank' => $id));
	}
	
	public function delete($id)
	{
		return $this->db->delete('bank',array('id_bank' => $id));		
	}	
	
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id_bank DESC")
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
		/*if(intval($active) > 0)
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}*/
		
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM bank {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM bank
                WHERE id_bank = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (name LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
	
	public static function drop_down_select($name,$selval,$optional = "")
	{
		$lists = OBank::get_list(0, 0, "id_bank DESC");
		$arr = array();
		
		foreach($lists as $r)
		{
			$arr[$r->id_bank] = $r->name;
		}		
		return dropdown($name,$arr,$selval,$optional);
	}	
}
?>