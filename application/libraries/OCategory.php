<?php

class OCategory
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
				$q = "SELECT * FROM products_category WHERE id_category = ?";
			}
			else 
			{
				$q = "SELECT * FROM products_category WHERE url_title = ?";
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
		$CI->db->insert('products_category',$params);
		$new_id = $CI->db->insert_id();
		return $new_id;
	}
	
	public function edit($params, $id)
	{
		if(trim($params['name']) != "")
		{
			$url_title =  url_title($params['name'], 'underscore', TRUE);
			$check_duplicate = $this->db->query("SELECT id_category FROM products_category WHERE url_title = ? AND id_category <> ?", array($url_title, $id));
			if(!emptyres($check_duplicate))
			{
				$url_title = $url_title."_".$id;
			}
			$params['url_title'] = $url_title;
		}
		return $this->db->update('products_category',$params,array('id_category' => $id));		
	}
	
	public function delete($id)
	{
		return $this->db->delete('products_category',array('id_category' => $id));		
	}	
	
	/*
	 * EXTERNAL FUNCTIONS
	 */

	public static function get_list($page=0, $limit=0, $orderby="id_category DESC", $not="")
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
		
		// not in
		if(trim($not) != "") $add_sql_stats .= " WHERE id_category NOT IN (' ".$not." ')";
		
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM products_category {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_tree_list_array($parent_id = 0, $prefix = "")
	{
		$CI =& get_instance();
		$arr = array();
		// see if there are children
		$q = "SELECT * FROM products_category WHERE parent_id = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($parent_id));
		if(emptyres($res))
		{
			// if there is no children, then return the current node
			$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
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
			$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
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
				$arr = array_merge_special($arr,OCategory::get_tree_list_array($row->id,$nextprefix));
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
		$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($children_id));
		if(!emptyres($res))
		{
			// if there are parent
			// get the current node
			$row = $res->row();
			
			$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
			$tmpres = $CI->db->query($q,array($row->parent_id));
			$r = $tmpres->row();
			if(emptyres($tmpres)) return FALSE;
			if($r->name != "") 
			{
				$arr = array($r->id => $r->name);
				//if($prefix == "") $arr = array($r->id => $r->name);
				//else $arr = array($r->id => $prefix." > ".$r->name);
				$nextprefix = $arr[$r->id];
				$arr = array_merge_special($arr,OCategory::get_parents($r->id,$nextprefix));
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
		$q = "SELECT * FROM products_category WHERE parent_id = ? ORDER BY name ASC";
		$res = $CI->db->query($q,array($id));
		if(emptyres($res))
		{
			// if there is no children, then return the current node
			$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
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
			$q = "SELECT * FROM products_category WHERE id_category = ? ORDER BY name ASC";
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
				$arr = array_merge_special($arr,OCategory::get_childrens($row->id,$nextprefix));
			}
			
			return $arr;
		//*
		}
		//*/
	}

	public static function drop_down_select($name,$selval,$optional = "",$default_val="",$id_exception="",$parent_id="")
	{
		$lists = OCategory::get_list(0, 0, "id_category ASC", "0");
		$arr = array();
		
		if($default_val != "") $arr[''] = $default_val;
		foreach($lists as $r)
		{
			$arr[$r->id_category] = $r->category;
			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public function get_name()
	{
		$lang = $this->CI->session->userdata("lang");
		switch($lang)
		{
			case "id":
				$name = $this->row->name;
			break;
			case "en":
				$name = $this->row->name_en;
			break;
			default:
				$name = $this->row->name;
			break;
		}
		return $name;
	}
	
	public function get_link()
	{
		//return "shop/v/{$this->row->url_title}";
		if($this->id == "") return "";
		return "categories/details/".$this->row->url_title;
	}
}
?>