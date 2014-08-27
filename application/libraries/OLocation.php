<?php

class OLocation
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
				$q = "SELECT * FROM kota WHERE id_kota = ?";
			}
			else 
			{
				$q = "SELECT * FROM kota WHERE url_title = ?";
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
		$CI->db->insert('kota',$params);
		$new_id = $CI->db->insert_id();
		if($new_id)
		{
			if(trim($params['name']) != "")
			{
				$url_title = url_title($params['name'], 'dash', TRUE);
				$check_duplicate = $CI->db->query("SELECT id_kota FROM kota WHERE url_title = ?", array($url_title));
				if(!emptyres($check_duplicate))
				{
					$url_title = $url_title."_".$new_id;
				}
				$lvcategory = new OLocation($new_id);
				$lvcategory->edit(array("url_title" => $url_title));
			}
		}
		return $new_id;
	}
	
	public function edit($params, $id)
	{
		if(trim($params['name']) != "")
		{
			$url_title =  url_title($params['name'], 'underscore', TRUE);
			$check_duplicate = $this->db->query("SELECT id_kota FROM kota WHERE url_title = ? AND id_kota <> ?", array($url_title, $id));
			if(!emptyres($check_duplicate))
			{
				$url_title = $url_title."_".$id;
			}
			$params['url_title'] = $url_title;
		}
		return $this->db->update('kota',$params,array('id_kota' => $id));		
	}
	
	public function delete($id)
	{
		return $this->db->delete('kota',array('id_kota' => $id));		
	}	
	
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id_kota DESC")
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM kota {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_tree_list_array($parent_id = 0, $prefix = "")
	{
		$CI =& get_instance();
		$arr = array();
		// see if there are children
		$q = "SELECT * FROM locations WHERE parent_id = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($parent_id));
		if(emptyres($res))
		{
			// if there is no children, then return the current node
			$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
			$res = $CI->db->query($q,array($parent_id));
			if(emptyres($res)) return FALSE;
			$r = $res->row();
			if($prefix == "") return array($r->id => $r->name);
			else return array($r->id => $prefix." > ".$r->name);
		}
		else
		{
			// if there are children
			// get the current node
			$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
			$tmpres = $CI->db->query($q,array($parent_id));
			$r = $tmpres->row();
			if($r->name != "") 
			{
				if($prefix == "") $arr[$r->id] = $r->name;
				else $arr[$r->id] = $prefix." > ".$r->name;
				$nextprefix = $arr[$r->id];
			}
			
			foreach($res->result() as $row)
			{						
				$arr = array_merge_special($arr,OLocation::get_tree_list_array($row->id,$nextprefix));
			}
			return $arr;
		}
	}
	
	public static function get_parents($children_id = 0, $prefix = "")
	{
		if(empty($children_id)) return FALSE;
		
		$CI =& get_instance();
		$arr = array();
		// see if there are parent
		$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($children_id));
		if(!emptyres($res))
		{
			// if there are parent
			// get the current node
			$row = $res->row();
			
			$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
			$tmpres = $CI->db->query($q,array($row->parent_id));
			$r = $tmpres->row();
			if(emptyres($tmpres)) return FALSE;
			if($r->name != "") 
			{
				$arr = array($r->id => $r->name);
				//if($prefix == "") $arr = array($r->id => $r->name);
				//else $arr = array($r->id => $prefix." > ".$r->name);
				$nextprefix = $arr[$r->id];
				$arr = array_merge_special($arr,OLocation::get_parents($r->id,$nextprefix));
			}
			return $arr;
		} 
		else return FALSE;
	}

	public static function get_childrens($id = 0, $prefix = "")
	{
		if(empty($id)) return FALSE;
		
		$CI =& get_instance();
		$arr = array();
		// see if there are parent
		//*
		$q = "SELECT * FROM locations WHERE parent_id = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($id));
		if(emptyres($res))
		{
			// if there is no children, then return the current node
			$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
			$res = $CI->db->query($q,array($id));
			if(emptyres($res)) return FALSE;
			$r = $res->row();
			return array($r->id => $r->name);
			//if($prefix == "") return array($r->id => $r->name);
			//else return array($r->id => $prefix." > ".$r->name);
		}
		else
		{
			// if there are parent
			// get the current node
			//*/
			$q = "SELECT * FROM locations WHERE id = ? ORDER BY name ASC";
			$tmpres = $CI->db->query($q,array($id));
			$r = $tmpres->row();
			if(emptyres($tmpres)) return FALSE;
			if($r->name != "") 
			{
				$arr = array($r->id => $r->name);
				//if($prefix == "") $arr = array($r->id => $r->name);
				//else $arr = array($r->id => $prefix." > ".$r->name);
				$nextprefix = $arr[$r->id];
			}
			
			foreach($res->result() as $row)
			{						
				$arr = array_merge_special($arr,OLocation::get_childrens($row->id,$nextprefix));
			}
			
			return $arr;
		//*
		}
		//*/
	}

	public static function drop_down_select($name,$selval,$optional = "",$default_val="",$id_exception="",$parent_id="")
	{
		$lists = OLocation::get_list(0, 0, "name ASC");
		$arr = array();
		
		if($default_val != "") $arr[''] = $default_val;
		foreach($lists as $r)
		{
			$arr[$r->id_kota] = $r->name;
			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public function get_link()
	{
		//return "shop/v/{$this->row->url_title}";
		if($this->id == "") return "";
		return "locations/details/".$this->row->url_title;
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM kota
                WHERE id_kota = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (name LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
	
	public function get_default($page=0, $limit=0, $orderby="id DESC")
	{
		$sql_stats = $sql_arrs = NULL;
		
		$sql_stats[] = " `default` = ? ";
		$sql_arrs[] = 1;
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
		$res = $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM locations {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->row();
	}
	
	public static function get_prolist($page=0, $limit=0, $orderby="id_provinsi ASC")
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM provinsi {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function drop_prov_select($name,$selval,$optional = "",$default_val="",$id_exception="",$parent_id="")
	{
		$lists = OLocation::get_prolist(0, 0, "name ASC");
		$arr = array();
		
		if($default_val != "") $arr[''] = $default_val;
		foreach($lists as $r)
		{
			$arr[$r->id_provinsi] = $r->name;
			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
}
?>