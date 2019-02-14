<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {
    var $tbl_name = "products";
    var $tbl_name1 = "frontproduct";

    public function get_item($id) {
        $query = $this->db->get_where($this->tbl_name, array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }
	
	 public function get_item_front($id) {
        $query = $this->db->get_where($this->tbl_name1, array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

	public function get_item_uploaded($id) {
        $query = $this->db->get_where($this->tbl_name1, array("id" => $id,'status' => '1'));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }
	
    public function save_data($row) {
        $product_info = [];
        foreach ($row as $key => $value) {
            if($key != "id") {
                $product_info[$key] = $value;
            }
        }
        $product_info['posted_date'] = date("Y-m-d H:i:s");
				
        if($row['id']) {
            $this->db->update($this->tbl_name, $product_info, array("id" => $row["id"]));
        } else {
            $this->db->insert($this->tbl_name, $product_info);
            $row['id'] = $this->db->insert_id();
        }

        if(file_exists(FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id']."_1.jpg")) {
            rename(FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id']."_1.jpg", FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id'].".jpg");
        }

        return 0;
    }

	
	public function update_product($update_data) { 
		$this->db->where('id', $update_data['id']);
		unset($update_data['id']);	
	
		$true = $this->db->update('tbl_frontproduct', $update_data);
		
		return $true;
	
	}
	
	public function save_data_product($row) {
		
        $product_info = [];
	
        foreach ($row as $key => $value) {
            if($key != "id") {
                $product_info[$key] = $value;
            }
        }
		
		
		
        $product_info['posted_date'] = date("Y-m-d H:i:s");
		// echo "<pre>";
		// print_r($product_info);
		
		// exit;
						
        if($row['id']) {
            $this->db->update($this->tbl_name1, $product_info, array("id" => $row["id"]));
        } else {
			$this->db->insert($this->tbl_name1, $product_info);
            return $row['id'] = $this->db->insert_id();
        }
				
        return 0;
    }
	
	
	
	
    public function get_category_name($arr_categories, $categoryIdx) {
        foreach ($arr_categories as $key => $category) {
            if($category->categoryIdx == $categoryIdx)
                return $category->categoryName;
        }
        return false;
    }

    public function get_items($arr_categories, $category = "", $keyword="" ) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where category LIKE '".$category."%' and (product_name like '%".$keyword."%' or descriptions like '%".$keyword."%' or title like '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->category);
        }

        return $result;
    }
	
	
	public function fetch_items($category = "", $keyword="",$user_city="",$user_state="",$user_country="") {
		
		//$strsql = "select * from tbl_".($this->tbl_name1)." where product_name LIKE '".$keyword."%'";
		
		
		
		//$strsql = "select * from tbl_".($this->tbl_name1)." where product_categorys = '$category'";
		
		
		$query = "SELECT * FROM tbl_".($this->tbl_name1)."";
		$conditions = array();

		if(! empty($category)) {
			$conditions[] = "product_categorys='$category'";
		}
		
		if(! empty($keyword)) {
			$conditions[] = "product_name='$keyword'";
		}
  		
		
		if(! empty($user_city)) {
			$conditions[] = "user_city='$user_city'";
		}
		
		if(! empty($user_state)) {
			$conditions[] = "user_state='$user_state'";
		}
		
		if(! empty($user_country)) {
			$conditions[] = "user_country='$user_country'";
		}
		

		$sql = $query;
		
		if (count($conditions) > 0) {
			$sql .= " WHERE " . implode(' OR ', $conditions);
		}

		//$result = mysql_query($sql);
		//echo $sql;
		
		$result = $this->db->query($sql)->result();
		
		return $result;;

	}
	
	 public function product_get_items($arr_categories, $category = "", $keyword="" ) {
        
        $strsql = "select * from tbl_".($this->tbl_name1)." where status=1";
        $result = $this->db->query($strsql)->result();
  
        return $result;
    }
	
	
	public function product_get_items_admin() {
        
        $strsql = "select * from tbl_frontproduct order by id desc";
        $result = $this->db->query($strsql)->result();
  
        return $result;
    }
	
	
	public function approved_product($id) {
               
		$this->db->set('status',1); //value that used to update column  
		$this->db->where('id', $id); //which row want to upgrade  
		$result = $this->db->update('tbl_frontproduct'); 
        return $result;
    }
	
	public function disapproved_product($id) {
        
        $this->db->set('status',0); //value that used to update column  
		$this->db->where('id', $id); //which row want to upgrade  
		$result = $this->db->update('tbl_frontproduct'); 
        return $result;
    }
	
	public function delte_product($id) {
        
        $this->db->where('id', $id);
		$result = $this->db->delete('tbl_frontproduct');
        return $result;
    }
		

    public function get_recent_items($arr_categories, $limit = 8) {

        $strsql = "select * from tbl_".($this->tbl_name1)." where status=1 order by posted_date desc limit ".$limit;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->category);
        }

        return $result;
    }
	
	
	
	public function add_product_city($save_city) {
		
		$this->db->insert('tbl_product_city', $save_city);
        return $this->db->insert_id();
		

	}
	
	public function add_product_country($save_country) {
		
		$this->db->insert('tbl_product_country', $save_country);
        return $this->db->insert_id();
		

	}
	
	
	

	public function get_product_city() {
		
		$strsql = "select * from tbl_product_city";
        $result = $this->db->query($strsql)->result();
        return $result;		
		
	}
	
	public function get_product_country() {
		
		$strsql = "select * from tbl_product_country";
        $result = $this->db->query($strsql)->result();
        return $result;		
		
	}
	
	
	public function delte_product_city($city_id) {				
		
		$this->db->where('id', $city_id);
		$result = $this->db->delete('tbl_product_city');
        return $result;
		
	}
	
	public function delte_product_country($country_id) {				
		
		$this->db->where('id', $country_id);
		$result = $this->db->delete('tbl_product_country');
        return $result;
		
	}
	
	
	
	
}

	