<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index()
	{
		
	}
	
	function upload($a = "")
	{
		$this->load->helper(array("image","string"));
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/temp/';
		$filename = basename($_FILES['uploadfile']['name']);
		$filearr = explode(".", $filename);
		$newfile = time()."_".random_string("alnum", 20) . "." . $filearr[count($filearr)-1];
		$file = $uploaddir . $newfile;
		$size = $_FILES['uploadfile']['size'];
		$tmps = array();
		if($size>1048576)
		{
			//echo "error file size > 1 MB";
			echo 'error';
			if(file_exists($_FILES['uploadfile']['tmp_name'])) unlink($_FILES['uploadfile']['tmp_name']);
			exit;
		}
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file))
		{
			// resize the image to lower size
			$resize_newfile = "resize_".$newfile;
			resize_photo($file, $uploaddir.$resize_newfile, 300, "width");
			echo $newfile; 
		} else {
			//die('error');
			//echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
		}

	}
	
	function get_section()
	{
		extract($_POST);
		
		if($category_id == "") return FALSE;		
		
		if(intval($product_id) > 0)
		{
			$O = new OProduct($product_id);
			$brand_id = $O->row->brand_id;
			$sizes = $O->get_sizes(0,0,$category_id);
			if($sizes)
			{
				foreach($sizes as $r)
				{
					$size_id_arr[] = $r->size_id;
					$price[$r->size_id] = $r->price;
					$discount_value[$r->size_id] = $r->discount_value;
					$final_price[$r->size_id] = $r->final_price;
				}
			}
			//die(json_encode($size_id_arr));
			$subcategories = $O->get_subcategories();
			if($subcategories)
			{
				foreach($subcategories as $r)
				{
					$subcategory_id_arr[] = $r->id;
				}
			}
			
			$type_categories = $O->get_type_categories();
			if($type_categories)
			{
				foreach($type_categories as $rt)
				{
					$type_category_id_arr[] = $rt->id;
				}
			}
			
			$theme_categories = $O->get_theme_categories();
			if($theme_categories)
			{
				foreach($theme_categories as $rth)
				{
					$theme_category_id_arr[] = $rth->id;
				}
			}
						
			$price_range_categories = $O->get_price_ranges();
			if($price_range_categories)
			{
				foreach($price_range_categories as $pr)
				{
					$price_range_id_arr[] = $pr->id;
				}
			}
		}
		
		$arr['brand'] = OBrand::get_brand_ddl("brand_id", $brand_id, "", $category_id);
		$arr['size'] = OSize::checkbox_select("size_id[]", $size_id_arr, "", $separator = "<br />", $category_id, $price, $discount_value, $final_price);
		$arr['sub_categories'] = OSubCategory::checkbox_select("subcategory_id[]", $subcategory_id_arr, "", $separator = "<br />", $category_id);
		$arr['type_categories'] = OTypecategory::checkbox_select("type_category_id[]", $type_category_id_arr, "", $separator = "<br />", $category_id);
		$arr['theme_categories'] = OThemecategory::checkbox_select("theme_category_id[]", $theme_category_id_arr, "", $separator = "<br />", $category_id);
		$arr['price_range_categories'] = OPriceRange::checkbox_select("price_range_id[]", $price_range_id_arr, "", $separator = "<br />", $category_id);
		
		die(json_encode($arr));	
	}
	
	
	function get_suppliers()
	{
		extract($_POST);
		
		if($location_id == "") return FALSE;
		
		// get all existing suppliers on the product sizes
		
		if(intval($product_id) > 0)
		{
			$O = new OProduct($product_id);
			$supplier = $O->get_supplier_product_sizes(0,0);
			// var_dump($supplier);
			if($supplier)
			{
				$cursuppliers = array();
				foreach($supplier as $r)
				{
					$cursuppliers[$r->supplier_id."_".$r->size_id] = $r;
				}
				unset($os);
			}

		}
		$suppliers = OSupplier::get_list(0, 0, "name ASC", $location_id);
		$tmp = "Search by supplier: ";
		$tmp .= "<select name='supplier_search' id='supplier_search'>";
		$tmp .= "<option value='0'>All Suppliers</option>";
		foreach($suppliers as $s)
		{
			$tmp .= "<option value=\"".$s->id."\">".$s->name."</option>";
		}
		$tmp .= "</select>";
		$tmp .= "<input type='hidden' name='location_id' value='{$location_id}' />";
		
		// get all the list for the location
		$suppliers = OSupplier::get_list(0, 0, "name ASC", $location_id);
		$arr = array();	
		if(sizeof($suppliers) > 0)
		{
			$ret[] = '<table>
						<tr>
							<th width="150px" style="text-align: center">Supplier Name</th>
							<th width="150px" style="text-align: center">Size</th>
							<th width="150px" style="text-align: center">Price</th>
							<th width="150px" style="text-align: center">Primary Supplier</th>
						</tr>
					</table>';
	
		
		
			$count = 0;
			foreach($suppliers as $r)
			{   
				$sizes = OSize::get_list(0, 0, "name ASC", $category_id);
				
				$i = 1;
				foreach($sizes as $row)
				{
					$curs = $cursuppliers[$r->id."_".$row->id];
					if($curs == NULL)
					{
						$curs->price = 0;
						$curs->primary = 0;
						
					}
					$display = '<td width="150px">'.$r->name.'</td>';
									
					$additional_display = '
	
					<td width="120px">
						<input type="hidden" name="size['.$count.']" value="'.$row->id.'" readonly="readonly" />
						Size : '.$row->name.'
					</td>								
					<td><input type="text" name="price['.$count.']" value="'.$curs->price.'" class="price" size="20px" /></td>
					<td><input type="checkbox" name="primary_supplier['.$count.']" value="1" '.($curs->primary == 1 ? 'checked="checked"' : '').'> Primary Supplier</td>
									';							
					
					$ret[] = "<span supplier_id='".$r->id."'><table><tr><td><input type='checkbox' value='{$r->id}' name='supplier[".$count."]' id='{$id}_".url_title($r->id)."' ".($curs->supplier_id == $r->id ? 'checked="checked"' : '')."> $display</td>".$additional_display."</tr></table></span>";
					$i++;
					$count++;
				}
			}
				
		}
		
		$arr['supplier'] = $tmp."<br /><br />".@implode("",$ret);
		die(json_encode($arr));	
	}
	
	function get_suppliers2()
	{
		$data['atad'] = $_POST;
		$this->load->view('admin/jqview_suppliers',$data);
	}
	
	function get_account()
	{
		extract($_POST);
		
		$UBA = new OUserBankAccount($id);
		
		if($UBA->id == "") die();
		//die($UBA->row);
		else
		{
			$arr['customer_name'] = $UBA->row->customer_name;
			$arr['bank_name'] = $UBA->row->bank_name;
			$arr['account_number'] = $UBA->row->account_number;
			
			die(json_encode($arr));	
		}
	}
	
	function get_shipping_fee()
	{
		extract($_POST);
		
		$L = new OLocation($location_id);
		
		if($L->id == "") die();
		//die($UBA->row);
		else
		{
			if($location_details == "inside") $arr['shipping_fee'] = $L->row->price_inside;
			else $arr['shipping_fee'] = $L->row->price_outside;
			
			die(json_encode($arr));	
		}
	}
	
	function get_type_theme_product()
	{
		extract($_POST);
		
		if($category_id == NULL) return FALSE;
		else
		{
			$arr['type'] = OTypecategory::get_type_ddl("type_id", $type_id, "", $category_id,'Tidak ada');
			$arr['theme'] = OThemecategory::get_theme_ddl("theme_id", $theme_id, "", $category_id,'Tidak ada');
			$arr['brand'] = OBrand::get_brand_ddl("brand_id", $brand_id, $optional, $category_id,'','Tidak ada');
			die(json_encode($arr));		
		}
	}
}