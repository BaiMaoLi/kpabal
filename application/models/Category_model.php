<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function get_columns($tbl_name) {

        if($tbl_name == "admin_menu") {
            return [
                [ ["name"=> "menuIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "menuName", "caption"=> "Menu Title", "description"=> "Menu Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "menuURL", "caption"=> "Link URL", "description"=> "Menu Link URL", "type"=> "text"] ],
                [ ["name"=> "menuIcon", "caption"=> "Menu Icon", "description"=> "Menu Attached Icon", "type"=> "text"] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_menu") {
            return [
                [ ["name"=> "menuIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "menuName", "caption"=> "Menu Title", "description"=> "Menu Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "menuURL", "caption"=> "Link URL", "description"=> "Menu Link URL", "type"=> "text"] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "board_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "news_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "categoryCode", "caption"=> "Cateogry Code", "description"=> "Category Code", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "business_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_help_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "shopping_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_contents_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "products_category") {
            return [
                [ ["name"=> "categoryIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "categoryName", "caption"=> "Cateogry Title", "description"=> "Category Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "address_state") {
            return [
                [ ["name"=> "stateIdx", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "stateName", "caption"=> "State Name", "description"=> "State Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "stateCode", "caption"=> "State Code", "description"=> "State Code", "type"=> "text", "required" => true],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_setting") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "setting_title", "caption"=> "Setting Info Caption", "description"=> "Setting Info Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "setting_value", "caption"=> "Setting Information", "description"=> "Setting Information", "type"=> "text", "required" => true] ],
                [ ["name"=> "setting_code", "caption"=> "State Code", "description"=> "Setting Code", "type"=> "text", "required" => true],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        }

        return [];
    }

    public function get_caption($tbl_name) {

        if($tbl_name == "admin_menu") {
            return "Admin Panel Menu";
        } else if($tbl_name == "site_menu") {
            return "Site Menu";
        } else if($tbl_name == "board_category") {
            return "Board Category";
        } else if($tbl_name == "news_category") {
            return "News Category";
        } else if($tbl_name == "business_category") {
            return "Business Category";
        } else if($tbl_name == "site_help_category") {
            return "Help Category";
        } else if($tbl_name == "shopping_category") {
            return "Shopping Category";
        } else if($tbl_name == "site_contents_category") {
            return "Contents Category";
        } else if($tbl_name == "products_category") {
            return "Products Category";
        } else if($tbl_name == "address_state") {
            return "Address States";
        } else if($tbl_name == "site_setting") {
            return "Site Global Settings";
        }

        return "";
    }

    public function get_caption_fld($tbl_name) {

        if($tbl_name == "admin_menu") {
            return "menuName";
        } else if($tbl_name == "site_menu") {
            return "menuName";
        } else if($tbl_name == "board_category") {
            return "categoryName";
        } else if($tbl_name == "news_category") {
            return "categoryName";
        } else if($tbl_name == "business_category") {
            return "categoryName";
        } else if($tbl_name == "site_help_category") {
            return "categoryName";
        } else if($tbl_name == "shopping_category") {
            return "categoryName";
        } else if($tbl_name == "site_contents_category") {
            return "categoryName";
        } else if($tbl_name == "products_category") {
            return "categoryName";
        } else if($tbl_name == "address_state") {
            return "stateName";
        }

        return "";   
    }

    public function calc_order_num($columns) {
        $order_num = 0;
        foreach ($columns as $column_arr) {
            foreach ($column_arr as $column) {
                if($column["type"] == "hidden") continue;
                if($column["name"] == "orderNum") return $order_num;
                $order_num++;
            }
        }
        return $order_num;
    }

    public function get_pri_fld($columns) {
        foreach ($columns as $column_arr) {
            foreach ($column_arr as $column) {
                return $column["name"];
            }
        }
        return "id";
    }

    public function get_rows($tbl_name, $parentIdx = "") {
        $query = $this->db->get_where($tbl_name, array('parentIdx' => $parentIdx));
        return $query->result();
    }

    public function generate_pri_value($tbl_name, $parentIdx, $pri_fld) {
        $strsql = sprintf("select $pri_fld from tbl_$tbl_name where parentIdx = '$parentIdx' order by $pri_fld desc");
        $result = $this->db->query($strsql)->result();
        if($tbl_name == "business_category") {
            if(count($result) == 0) {
                return $parentIdx."001";
            } else {
                $last_key = $result[0]->$pri_fld;
                $last_key = substr($last_key, strlen($parentIdx), 3);
                return $parentIdx.sprintf("%03d", intval($last_key) + 1);
            }
            return false;
        }
        if(count($result) == 0) {
            return $parentIdx."01";
        } else {
            $last_key = $result[0]->$pri_fld;
            $last_key = substr($last_key, strlen($parentIdx), 2);
            return $parentIdx.sprintf("%03d", intval($last_key) + 1);
        }
        return false;
    }

    public function get_item($tbl_name, $record_idx, $arr_ret) {
        $columns = $this->get_columns($tbl_name);
        $pri_fld = $this->get_pri_fld($columns);
        $query = $this->db->get_where($tbl_name, array($pri_fld => $record_idx));
        $result = $query->result();
        if($result) {
            $arr_ret = $this->get_item($tbl_name, $result[0]->parentIdx, $arr_ret);
            $arr_ret[] = $result[0];
        }
        return $arr_ret;
    }

    public function get_additional_caption($tbl_name, $parentIdx) {
        $result = $this->get_item($tbl_name, $parentIdx, array());
        return $result;
    }

    public function get_data($tbl_name, $columns, $pri_val) {
        $pri_fld = $this->get_pri_fld($columns);
        $query = $this->db->get_where($tbl_name, array($pri_fld => $pri_val));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function remove_data($tbl_name, $columns, $pri_val) {
        $pri_fld = $this->get_pri_fld($columns);
        $strsql = sprintf("delete from tbl_$tbl_name where LEFT( $pri_fld, LENGTH( '$pri_val' ) ) = '$pri_val'");
        $this->db->query($strsql);
    }

    public function save_data($tbl_name, $parentIdx, $columns, $row) {
        $pri_fld = "";
        foreach ($columns as $column_arr) {
            foreach ($column_arr as $column) {
                if(!$pri_fld) $pri_fld = $column["name"];
                $fld_name = $column["name"];
                if(isset($row[$fld_name])) {
                    if($column["type"] == "onoff") $row[$fld_name] = (($row[$fld_name] == "on")?1:0);
                } else {
                    if($fld_name == $pri_fld) continue;
                    if($column["type"] == "text")
                        $row[$fld_name] = "";
                    else
                        $row[$fld_name] = 0;
                }
            }
        }
        $row['parentIdx'] = $parentIdx;

        if(isset($row[$pri_fld]) && ($row[$pri_fld])) {
            $this->db->update($tbl_name, $row, array($pri_fld => $row[$pri_fld]));
        } else {
            $row[$pri_fld] = $this->generate_pri_value($tbl_name, $parentIdx, $pri_fld);
			echo $row[$pri_fld];
            $this->db->insert($tbl_name, $row);
        }
    }

    public function check_no_exists($parentIdx, $result, $pri_fld) {
        while (strlen($parentIdx) > 1) {
            $check_no_exists = true;
            foreach ($result as $item) {
                if($item->$pri_fld == $parentIdx) {
                    $check_no_exists = false;
                }
            }
            if($check_no_exists) return true;
            $parentIdx = substr($parentIdx, 0, strlen($parentIdx) - 2);
        }
        return false;
    }

    public function list_data($tbl_name, $isDisplay = false) {
        $pri_fld = $this->get_pri_fld($this->get_columns($tbl_name));
        $strCondition = "";
        if($isDisplay) $strCondition = " where isDisplay = 1";
        $strsql = sprintf("select * from tbl_$tbl_name $strCondition order by parentIdx, orderNum");
        $result = $this->db->query($strsql)->result();

        foreach ($result as $row) {
            $row->parentName = "";
        }

        for($i=0; $i<count($result)-1; $i++) {
            for($j=$i+1; $j<count($result); $j++) {
                if($result[$i]->$pri_fld == $result[$j]->parentIdx) {
                    $result[$j]->parentName = $result[$i]->categoryName." > ";
                }
            }
        }

        foreach ($result as $row) {
            $row->categoryName = $row->parentName.$row->categoryName;
        }

        if($isDisplay) {
            for($i=count($result)-1; $i>=0; $i--) {
                if($this->check_no_exists($result[$i]->parentIdx, $result, $pri_fld))
                    array_splice($result, $i, 1);
            }
        }

        return $result;
    }

    public function get_parent_menu($url) {
        $strsql = sprintf("select menuName from tbl_admin_menu where menuIdx in (select left(menuIdx, 2) from tbl_admin_menu where menuURL = '$url')");
        $result = $this->db->query($strsql)->result();
        if(count($result)){
            return $result[0]->menuName;
        }
        return false;
    }

    public function get_tree_rows($tbl_name, $isDisplay = false) {
        $pri_fld = $this->get_pri_fld($this->get_columns($tbl_name));
        $strCondition = "";
        if($isDisplay) $strCondition = " where isDisplay = 1";
        $strsql = sprintf("select * from tbl_$tbl_name $strCondition order by parentIdx, orderNum");
        $result = $this->db->query($strsql)->result();
        foreach ($result as $row) {
            $row->children = [];
            $row->deleted = false;
        }
        for($i=count($result)-1; $i>=0; $i--) {
            if ($result[$i]->deleted) continue;
            for($j=$i-1; $j>=0; $j--) {
                if($result[$j]->$pri_fld == $result[$i]->parentIdx) {
                    $result[$j]->children = array_merge(array($result[$i]), $result[$j]->children);
                    // array_splice($result, $i, 1);
                    $result[$i]->deleted = true;
                }
            }
        }
        if($isDisplay) {
            for($i=count($result)-1; $i>=0; $i--) {
                if($result[$i]->parentIdx != "")
                    array_splice($result, $i, 1);
            }
        }
        return $result;
    }
public function getData($table,$cond=array()){
	    $this->db->select("*");
	    $this->db->from($table);
	    $this->db->where($cond);
	    $res=$this->db->get();
	    //print_r($id);die;
        return $res->result_array();
	}
    public function get_tree_rows_with_parent($tbl_name, $parentIdx='', $isDisplay = false) {
		
		  $this->db->select("*");
	    $this->db->from("tbl_$tbl_name");
	    $this->db->where(array('isDisplay'=>1));
		$this->db->order_by('orderNum');
	    $res=$this->db->get();
	    //print_r($id);die;
        return $res->result_array();
		
		
       /* $pri_fld = $this->get_pri_fld($this->get_columns($tbl_name));
        $strCondition = " where LEFT( parentIdx, LENGTH( '".$parentIdx."' ) ) = '".$parentIdx."'";
        if($isDisplay) $strCondition .= " and isDisplay = 1";
        $strsql = sprintf("select * from tbl_$tbl_name $strCondition order by parentIdx, orderNum");
        $result = $this->db->query($strsql)->result();
        foreach ($result as $row) {
            $row->children = [];
        }
        for($i=count($result)-1; $i>=0; $i--) {
            for($j=$i-1; $j>=0; $j--) {
                if($result[$j]->$pri_fld == $result[$i]->parentIdx) {
                    $result[$j]->children = array_merge(array($result[$i]), $result[$j]->children);
                    array_splice($result, $i, 1);
                }
            }
        }
        if($isDisplay) {
            for($i=count($result)-1; $i>=0; $i--) {
                if($result[$i]->parentIdx != $parentIdx)
                    array_splice($result, $i, 1);
            }
        }
        return $result;*/
    }
	
	
	public function get_cat_name($catID){
								
			$strsql = sprintf("select categoryName from tbl_products_category where categoryIdx='$catID'");
			$result = $this->db->query($strsql)->result();
					
			return $result; 
		
	}
	
}
