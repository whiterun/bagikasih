<?php

class OSetting
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
				$q = "SELECT * FROM settings WHERE id = ?";
			}
			else 
			{
				$q = "SELECT * FROM settings WHERE url_title = ?";
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
		$CI->db->insert('settings',$params);
		return $CI->db->insert_id();
	}
	
	public function edit($params)
	{
		return $this->db->update('settings',$params,array('id' => $this->id));		
	}
	
	public function delete()
	{
		return $this->db->query("DELETE FROM settings WHERE id = ?", array($this->id));
	}
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id DESC"/*, $active=""*/)
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM settings {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function refresh()
    {
        $res = $this->db->get_where('settings',array("id" => $this->id));
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
	
	public function update_key()
    {
    	$new_key = url_title($this->row->name, '-', TRUE);
    	$q = "SELECT SQL_CALC_FOUND_ROWS * FROM settings WHERE 'key' = ? AND id <> ?";
        $res = $this->db->query($q,array($new_key,$this->id));
        if(!emptyres($res))
        {
        	$new_key .= "-".$this->id;
        }
        $this->db->update('settings',array('key' => $new_key),array('id' => $this->id));
    }
}
?>