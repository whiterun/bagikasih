<?php

class OArea
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
				$q = "SELECT * FROM kota_area WHERE id_area = ?";
			}
			else 
			{
				$q = "SELECT * FROM kota_area WHERE name = ?";
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
		$CI->db->insert('kota_area',$params);
		$new_id = $CI->db->insert_id();
		return $new_id;
	}
	
	public function edit($params, $id)
	{
		return $this->db->update('kota_area',$params,array('id_area' => $id));		
	}
	
	public function delete($id)
	{
		return $this->db->delete('kota_area',array('id_area' => $id));		
	}	
	
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id_area DESC", $where = '')
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
		/*
		if($active != "")
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM kota_area {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}

	public static function drop_down_select($name,$selval,$optional = "",$default_val="",$id_exception="",$parent_id="")
	{
		$lists = OLocation::get_list(0, 0, "name ASC");
		$arr = array();
		
		if($default_val != "") $arr[''] = $default_val;
		foreach($lists as $r)
		{
			$arr[$r->id_area] = $r->name;
			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM kota_area
                WHERE id_area = ?";
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