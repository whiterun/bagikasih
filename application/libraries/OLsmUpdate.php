<?php

class OLsmUpdate
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
			$q = "SELECT * FROM lsm_update WHERE id_update = ?";
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
		$CI->db->insert('lsm_update',$arr);
		return $CI->db->insert_id();
	}
	
	public function edit($arr)
	{
		return $this->db->update('lsm_update',$arr,array('id_update' => $this->id));		
	}
	
	public function delete()
	{
		return $this->db->query("DELETE FROM lsm_update WHERE id_update = ?", array($this->id));
	}	
	
	public static function get_list($page=0, $limit=0, $orderby="id_update DESC")
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
		
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
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lsm_update {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function drop_down_select($name, $selval, $optional="")
	{
		$list = OLsmUpdate::get_list(0, 0, "title ASC");
		
		foreach($list as $r)
		{
			$arr[$r->id_update] = $r->name;			
		}
		return dropdown($name,$arr,$selval,$optional);
	}
	
	public function get_filtered_list($location_id,$brand_id = 0,$category_id = 0, $subcat_id = 0, $size_id = 0, $topic_id = 0,$orderby = "p.title ASC",$start = 0, $limit = 20, $featured = 0, $type_id = 0, $theme_id = 0, $price_range_id = 0)
	{
		// get all suppliers
		$q = "SELECT * FROM suppliers WHERE id_city = ?";
		$res = $this->db->query($q,array($location_id));
		if(emptyres($res)) return FALSE;
		$suppliers = array();
		foreach($res->result() as $row) $suppliers[] = $row->id;
		$q = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(p.id) 
				FROM lsm_update p
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
			$lsm_update = array();
			foreach($res->result() as $row)
			{
				
				$op = new OLsmUpdate($row->id);
				$lsm_update[] = $op->row;
				unset($op);
			}
			
			return $lsm_update;
		}	
	}
	
	public function get_filtered_list_keyword($keyword,$location_id,$brand_id = 0,$category_id = 0, $subcat_id = 0, $size_id = 0, $topic_id = 0,$orderby = "p.title ASC",$start = 0, $limit = 20, $featured = 0)
	{
		// get all suppliers
		$q = "SELECT * FROM suppliers WHERE id_city = ?";
		$res = $this->db->query($q,array($location_id));
		if(emptyres($res)) return FALSE;
		$suppliers = array();
		foreach($res->result() as $row) $suppliers[] = $row->id;
		$q = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(p.id) 
				FROM lsm_update p
				INNER JOIN supplier_product_sizes sps ON sps.product_id = p.id
				AND sps.supplier_id IN (".@implode(",",$suppliers).")
				AND p.title LIKE ?";
		$val[] = $keyword."%";
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
		if(sizeof($where) > 0)
		{
			$q .= " AND ".@implode($where," AND ");
		}
		
		if($order_by != "")
		{
			$q .= " ORDER BY ".$orderby;
		}
		
		if(intval($limit) > 0)
		{
			$q .= " LIMIT ?,?";
			$val[] = intval($start);
			$val[] = intval($limit);
		}
		$res = $this->db->query($q,$val);
		if(emptyres($res)) return FALSE;
		else
		{
			$lsm_update = array();
			foreach($res->result() as $row)
			{
				$op = new OLsmUpdate($row->id);
				$lsm_update[] = $op->row;
				unset($op);
			}
			
			return $lsm_update;
		}	
	}
	
	public function get_filtered_list_for_gift($brand_id = 0,$category_id = 0, $subcat_id = 0, $size_id = 0, $topic_id = 0,$orderby = "p.title ASC",$start = 0, $limit = 20, $featured = 0, $type_id = 0, $theme_id = 0, $price_range_id = 0)
	{
		
		$q = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(p.id) 
				FROM lsm_update p
				INNER JOIN supplier_product_sizes sps ON sps.product_id = p.id
				";
		
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
			$lsm_update = array();
			foreach($res->result() as $row)
			{
				
				$op = new OLsmUpdate($row->id);
				$lsm_update[] = $op->row;
				unset($op);
			}
			
			return $lsm_update;
		}	
	}
	
	
	
	
	
	
	
	//SUB CATEGORIES
	public function get_subcategories($page=0, $limit=0/*, $orderby="id DESC", $active=""*/)
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
				
		$sql_stats[] = " psc.product_id = ? ";
		$sql_arrs[] = $this->id;
				
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		*/
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " AND ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
		// order by
		//if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS sc.*, psc.* FROM product_subcategories psc, subcategories sc WHERE psc.subcategory_id = sc.id {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function delete_subcategories()
	{
		$this->db->delete('product_subcategories', array("product_id" => $this->id));
		return true;
	}
	
	public function set_subcategories($arr)
	{
		$this->delete_subcategories();
		$this->db->insert_batch('product_subcategories',$arr);
		return true;
	}
	
	public function get_category()
	{
		$q = "SELECT * FROM categories WHERE id = ?";
		$res = $this->db->query($q,array($this->row->category_id));
		if(emptyres($res)) return FALSE;
		else return $res->row();
	}
	
	public function get_lowest_price()
	{
		$q = "SELECT * FROM product_sizes WHERE product_id = ? ORDER BY final_price ASC LIMIT 1";
		$res = $this->db->query($q,array($this->id));
		if(emptyres($res)) return 0;
		else
		{
			$r = $res->row();
			return $r->final_price;
		}
	}
	public function get_lowest_size_name()
	{
		$q = "SELECT * FROM product_sizes WHERE product_id = ? ORDER BY final_price ASC LIMIT 1";
		$res = $this->db->query($q,array($this->id));
		if(emptyres($res)) return "";
		else
		{
			$r = $res->row();
			$q = "SELECT * FROM sizes WHERE id = ?";
			$res = $this->db->query($q,array($r->size_id));
			if(emptyres($res)) return "";
			else
			{
				$r = $res->row();
				return $r->name;
			}
		}
	}
	public function get_highest_price()
	{
		$q = "SELECT * FROM product_sizes WHERE product_id = ? ORDER BY price ASC LIMIT 1";
		$res = $this->db->query($q,array($this->id));
		if(emptyres($res)) return 0;
		else
		{
			$r = $res->row();
			return $r->price;
		}
	}
	
	//SIZES
	public function get_sizes($page=0, $limit=0/*, $orderby="id DESC", $active=""*/)
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
				
		$sql_stats[] = " ps.product_id = ? ";
		$sql_arrs[] = $this->id;
				
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		*/
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " AND ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
		// order by
		//if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS s.*, ps.* FROM product_sizes ps, sizes s WHERE ps.size_id = s.id {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function delete_sizes()
	{
		$this->db->delete('product_sizes', array("product_id" => $this->id));
		return true;
	}
	
	public function set_sizes($arr)
	{
		$this->delete_sizes();
		$this->db->insert_batch('product_sizes',$arr);
		return true;
	}
	
	
	public function get_supplier_product_sizes($page=0, $limit=0/*, $orderby="id DESC", $active=""*/)
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
				
		$sql_stats[] = " sps.product_id = ? ";
		$sql_arrs[] = $this->id;
				
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		*/
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " AND ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
		// order by
		//if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS p.*, sps.* FROM supplier_product_sizes sps, lsm_update p WHERE sps.product_id = p.id {$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function delete_supplier_product_sizes()
	{
		$this->db->delete('supplier_product_sizes', array("product_id" => $this->id));
		return true;
	}
	
	public function set_supplier_product_sizes($arr)
	{
		$this->delete_supplier_product_sizes();
		$this->db->insert_batch('supplier_product_sizes',$arr);
		return true;
	}
	
	public function get_photo($limit="1", $size="200xcrops")
	{
		$photo = OLsmUpdatePhoto::get_list(0, intval($limit), "id DESC", $this->id);
					
		$img_url = NULL;
		foreach($photo as $row)
		{
			$PP = new OLsmUpdatePhoto();
			$PP->setup($row);
			
			$img_url = $PP->get_photo($row->image, "lsm_update", $size);
			//$img = '<img src="'.$img_url.'" alt="" />';
			unset($PP);
		}
		//return "";
		return $img_url;
	}
	
	
	
	public function get_product_by_category($page=0, $limit=0, $orderby="p.id DESC", $category_id="")
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
				
		$sql_stats[] = " p.category_id = ? ";
		$sql_arrs[] = $category_id;
				
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		*/
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " AND ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
		// order by
		//if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS p.*, p.title as product_name, c.*, b.*, b.title as brand_name, ps.*, s.*, s.title as size_name
							  	FROM lsm_update p, categories c, brands b, product_sizes ps, sizes s 
								WHERE c.id = p.category_id
									AND b.id = p.brand_id
									AND p.id = ps.product_id
									AND s.id = ps.size_id
								{$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public function get_link()
	{
		//return "shop/v/{$this->row->url_title}";
		if($this->id == "") return "";
		return "lsm_update/details/".$this->id;		
	}
	
	
	
	
	public function get_filtered_list_by_price($location_id,$brand_id = 0,$category_id = 0, $subcat_id = 0, $size_id = 0, $topic_id = 0,$orderby = "p.title ASC",$start = 0, $limit = 20, $featured = 0, $start_price = 0, $end_price = 0)
	{
		// get all suppliers
		$q = "SELECT * FROM suppliers WHERE id_city = ?";
		$res = $this->db->query($q,array($location_id));
		if(emptyres($res)) return FALSE;
		$suppliers = array();
		foreach($res->result() as $row) $suppliers[] = $row->id;
		$q = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(p.id) 
				FROM lsm_update p
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
		if(intval($end_price != 0) && intval($start_price == 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_sizes WHERE final_price <= ?)";
			$val[] = intval($end_price);
		}
		if(intval($start_price != 0) && intval($end_price == 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_sizes WHERE final_price >= ?)";
			$val[] = intval($start_price);
		}
		if(intval($start_price != 0) && intval($end_price != 0))
		{
			$where[] = "p.id IN (SELECT product_id FROM product_sizes WHERE final_price BETWEEN ? AND ?)";
			$val[] = intval($end_price);
			$val[] = intval($start_price);			
		}		
		
		if(sizeof($where) > 0)
		{
			$q .= " AND ".@implode($where," AND ");
		}
		$q .= " ORDER BY ".$orderby." LIMIT ?,?";
		$val[] = intval($start);
		$val[] = intval($limit);
		$res = $this->db->query($q,$val);
		if(emptyres($res)) return FALSE;
		else
		{
			$lsm_update = array();
			foreach($res->result() as $row)
			{
				$op = new OLsmUpdate($row->id);
				$lsm_update[] = $op->row;
				unset($op);
			}
			
			return $lsm_update;
		}
	}
	
	public function get_supplier_product_size_details($location_id="", $page=0, $limit=0, $orderby="p.id DESC")
	{
		$q = "SELECT * FROM suppliers WHERE id_city = ?";
		$res = $this->db->query($q,array($location_id));
		if(emptyres($res)) return FALSE;
		$suppliers = array();
		foreach($res->result() as $row) $suppliers[] = $row->id;
		$q = "SELECT SQL_CALC_FOUND_ROWS sps.* 
				FROM lsm_update p
				INNER JOIN supplier_product_sizes sps ON sps.product_id = p.id
				AND sps.supplier_id IN (".@implode(",",$suppliers).")";
		
		
		$where[] = "p.id = ?";
		$val[] = intval($this->id);				
		
		if(sizeof($where) > 0)
		{
			$q .= " AND ".@implode($where," AND ");
		}
		$q .= " ORDER BY ".$orderby." LIMIT ?,?";
		$val[] = intval($start);
		$val[] = intval($limit);
		$res = $this->db->query($q,$val);
		if(emptyres($res)) return FALSE;
		else
		{
			$supplier_product_sizes = array();
			foreach($res->result() as $row)
			{
				$osps = new OSupplierlsm_updateize($row->id);
				$supplier_product_sizes[] = $osps->row;
				unset($op);
			}
			
			return $supplier_product_sizes;
		};
	}
	
	public static function get_product_reviews_ddl($name, $selval, $optional, $user_id)
	{
		$list = OOrder::get_product_list_by_userid(0, 0, "od.id DESC", $user_id);
		
		foreach($list as $r)
		{	
			$P = new OLsmUpdate($r->product_id);
			$arr[$r->product_id] = $P->row->name;
			unset($P);
		}
		return dropdown($name,$arr,$selval,$optional, $default_value);
	}
	
	public function get_top_view_product_by_category($page=0, $limit=0, $orderby="views ASC", $category_id="")
	{
		$CI =& get_instance();
		$sql_stats = $sql_arrs = NULL;
				
		$sql_stats[] = " category_id = ? ";
		$sql_arrs[] = $category_id;
				
		/*
		if($active != "")
		{
			$sql_stats[] = " active = ? ";
			$sql_arrs[] = $active;
		}
		*/
		$add_sql_stats = "";
		if(count($sql_stats) > 0)
		{
			$add_sql_stats .= " WHERE ";
			$add_sql_stats .= implode(" AND ", $sql_stats);
		}
		
		// order by
		//if(trim($orderby) != "") $add_sql_stats .= " ORDER BY ".$orderby." ";
		// limit
		if(intval($limit) > 0)
		{
			$add_sql_stats .= " LIMIT ?, ? ";
			$sql_arrs[] = intval($page);
			$sql_arrs[] = intval($limit);
		}
		// setup
		$res = $CI->db->query("SELECT SQL_CALC_FOUND_ROWS *
							  	FROM lsm_update
								{$add_sql_stats} ", $sql_arrs);
		if(emptyres($res)) return array();
		else return $res->result();
	}
	
	public static function search($keyword)
    {
    	$CI =& get_instance();
        $q = "SELECT * 
        		FROM lsm_update
                WHERE id_update = ?";
        $arr = array();
        $arr[] = intval($keyword);
                        $arr[] = "{$keyword}%";
                            $q .= " OR (title LIKE ?)";
                    $res = $CI->db->query($q,$arr); 
        
        if(emptyres($res)) return FALSE;
        else return $res->result();                
    }
}
?>