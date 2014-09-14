<?php

class OLsmList
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
			$q = "SELECT * FROM lsm_list WHERE id_lsm = ?";
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
		$CI->db->insert('lsm_list',$arr);
		return $CI->db->insert_id();
	}
	
	public function edit($arr)
	{
		return $this->db->update('lsm_list',$arr,array('id_lsm' => $this->id));		
	}
	
	public function delete()
	{
		return $this->db->query("DELETE FROM lsm_list WHERE id_lsm = ?", array($this->id));
	}	
	
	public static function get_list($page=0, $limit=0, $orderby="id_lsm DESC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lsm_list {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function drop_down_select($name, $selval, $optional="")
	{
		$list = OLsmList::get_list(0, 0, "name ASC");
		
		foreach($list as $r)
		{
			$arr[$r->id_lsm] = $r->name;			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public function get_filtered_list($location_id,$brand_id = 0,$category_id = 0, $subcat_id = 0, $size_id = 0, $topic_id = 0,$orderby = "p.name ASC",$start = 0, $limit = 20, $featured = 0, $type_id = 0, $theme_id = 0, $price_range_id = 0)
	{
		// get all suppliers
		$q = "SELECT * FROM suppliers WHERE id_city = ?";
		$res = $this->db->query($q,array($location_id));
		if(emptyres($res)) return FALSE;
		$suppliers = array();
		foreach($res->result() as $row) $suppliers[] = $row->id;
		$q = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(p.id) 
				FROM lsm_list p
				INNER JOIN supplier_product_sizes sps ON sps.product_id = p.id
				AND sps.supplier_id IN (".@implode(",",$suppliers).")";
		
		if(intval($brand_id) != 0)
		{
			$where[] = "p.brand_id = ?";
			$val[] = intval($brand_id);
		}
		if(intval($category_id != 0))
		{
			$where[] = "p.category_id = ?";
			$val[] = intval($category_id);
		}
		if(intval($subcat_id != 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_subcategories WHERE subcategory_id = ?)";
			$val[] = intval($subcat_id);
		}
		if(intval($size_id != 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_sizes WHERE size_id = ?)";
			$val[] = intval($size_id);
		}
		if(intval($topic_id != 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_topics WHERE topic_id = ?)";
			$val[] = intval($topic_id);
		}
		if(intval($featured) != 0)
		{
			$where[] = "p.featured = ?";
			$val[] = intval($featured);
		}
		/*tambah*/
		if(intval($type_id) != 0)
		{
			$where[] = "p.id IN (SELECT product_id FROM product_type_categories WHERE type_category_id = ?)";
			$val[] = intval($type_id);
		}
		if(intval($theme_id) != 0)
		{
			$where[] = "p.id IN (SELECT product_id FROM product_theme_categories WHERE theme_category_id = ?)";
			$val[] = intval($theme_id);
		}
		if(intval($price_range_id) != 0)
		{
			$where[] = "p.id IN (SELECT product_id FROM product_price_ranges WHERE price_range_id = ?)";
			$val[] = intval($price_range_id);
		}
		/*end*/
		if(sizeof($where) > 0)
		{
			$q .= " AND ".@implode($where," AND ");
		}
		$q .= " ORDER BY ".$orderby;
		if(intval($limit) > 0)
		{
			$q .= " LIMIT ?,?";
			$val[] = intval($start);
			$val[] = intval($limit);
		}
		$res = $this->db->query($q,$val);
		$GLOBALS['total'] = get_db_total_rows();
		if(emptyres($res)) return FALSE;
		else
		{
			$lsm_list = array();
			foreach($res->result() as $row)
			{
				
				$op = new OLsmList($row->id);
				$lsm_list[] = $op->row;
				unset($op);
			}
			
			return $lsm_list;
		}	
	}
	
	public static function get_donation_list($page=0, $limit=0, $orderby="date_contribution DESC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM contribution {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_volunteer_list($page=0, $limit=0, $orderby="id_volunteer DESC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM volunteer {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_fundraise_list($page=0, $limit=0, $orderby="id_fundraise DESC", $where = '')
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
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM lsm_list
                WHERE id_lsm = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (name LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
	
	public static function add_fund($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('fundraise_list',$arr);
		return $CI->db->insert_id();
	}
	
	public static function add_fund2($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('fundraiser',$arr);
		return $CI->db->insert_id();
	}
	
	public static function add_fund3($arr)
	{
		$CI =& get_instance();
		$CI->db->insert('fundraise_image',$arr);
		return $CI->db->insert_id();
	}
	
	public static function get_fcolor($page=0, $limit=0, $orderby="id_fcolor ASC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM fundraise_color {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function fsearch($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM fundraise_list
                WHERE id_fundraise = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (name LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
	
	public static function get_lupdate($page=0, $limit=0, $orderby="a.id_update DESC", $where = '')
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		// where
		if(trim($where) != "") $add_sql_stats .= " AND ".$where." ";
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS a.id_update, a.title, a.content, a.dt, b.name FROM lsm_update a, lsm_organizer b, lsm_list c WHERE a.id_organizer = b.id_organizer AND b.id_lsm = c.id_lsm {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function add_fund_video_batch($arr)
	{
		$CI =& get_instance();
		$CI->db->insert_batch('fundraise_video_link',$arr);
		return TRUE;
	}
	
	public static function save_fundraise_photo($filename)
	{
		return save_photo($filename,"lsfund",array("600", "400", "200"));
	}
	
	public static function add_fund_photo_batch($arr)
	{
		$CI =& get_instance();
		$CI->db->insert_batch('fundraise_gallery',$arr);
		return TRUE;
	}
	
	public static function get_fvideo($page=0, $limit=0, $orderby="id_flvideo ASC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM fundraise_video_link {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_fgallery($page=0, $limit=0, $orderby="id_fgallery ASC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM fundraise_gallery {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function add_lsm_video_batch($arr)
	{
		$CI =& get_instance();
		$CI->db->insert_batch('lsm_video_link',$arr);
		return TRUE;
	}
	
	public static function save_lsm_photo($filename)
	{
		return save_photo($filename,"lsfund",array("600", "400", "200"));
	}
	
	public static function add_lsm_photo_batch($arr)
	{
		$CI =& get_instance();
		$CI->db->insert_batch('lsm_gallery',$arr);
		return TRUE;
	}
	
	public static function get_lvideo($page=0, $limit=0, $orderby="id_lvideo ASC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lsm_video_link {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function get_lgallery($page=0, $limit=0, $orderby="id_lgallery ASC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lsm_gallery {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function approve($params, $id)
	{
		return $this->db->update('lsm_list', $params, array('id_lsm' => $id));
	}
	
	public function lvideo_delete($id)
	{
		return $this->db->query("DELETE FROM lsm_video_link WHERE id_lvideo = ?", array($id));
	}
	
	public function lgallery_delete($id)
	{
		$old = get_lgimg($id)->image_name;
		$del = $this->db->delete('lsm_gallery',array('id_lgallery' => $id));		
		
		if(!$del) return false;
		else
		{
			OLsmList::delete_photo($old);
			return true;
		}
	}
	
	public static function delete_photo($image)
	{
		return delete_photo($image, "lsfund", array("600", "400", "200"));
	}
	
	public static function get_volunteer_report_list($page=0, $limit=0, $orderby="id_vreport DESC", $where = '')
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM volunteer_report {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
}
?>