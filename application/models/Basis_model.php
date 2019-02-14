<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basis_model extends CI_Model {

    public function get_columns($tbl_name) {

        if($tbl_name == "business_option") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "option_code", "caption"=> "Option Title", "description"=> "Option Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_help") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "help_title", "caption"=> "Help Title", "description"=> "Help Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "help_content", "caption"=> "Help Content", "description"=> "Help Content Description", "type"=> "textarea", "required" => true] ],
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "news") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "article_title", "caption"=> "News Title", "description"=> "News Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "article_content", "caption"=> "News Content", "description"=> "News Content Description", "type"=> "textarea", "required" => true] ],
                [ ["name"=> "article_source", "caption"=> "News Source", "description"=> "News Source", "type"=> "text", "required" => true] ],
                [ ["name"=> "article_link", "caption"=> "News Link", "description"=> "News Link", "type"=> "text", "required" => true] ],
                [ ["name"=> "admin_pre_order_chk", "caption"=> "Admin Suggest", "description"=> "Admin Suggest", "type"=> "onoff"],
                  ["name"=> "admin_pre_order", "caption"=> "Admin Suggest Priority #", "description"=> "Admin Suggest Priority", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_contents") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "title", "caption"=> "Title", "description"=> "Title Caption", "type"=> "text"] ],
                [ ["name"=> "content", "caption"=> "Content", "description"=> "Content Description", "type"=> "textarea"] ],
                [ ["name"=> "additional_css", "caption"=> "Style", "description"=> "Content Style", "type"=> "text"] ],                
                [ ["name"=> "isDisplay", "caption"=> "Show / Hide", "description"=> "Toggle Show / Hide", "type"=> "onoff"],
                  ["name"=> "orderNum", "caption"=> "Sort #", "description"=> "Sort Order Number", "type"=> "text"] ],
            ];
        } else if($tbl_name == "site_cms") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "page_title", "caption"=> "CMS Title", "description"=> "CMS Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "page_content", "caption"=> "Content", "description"=> "Content", "type"=> "contents", "required" => true] ],
                [ ["name"=> "meta_key", "caption"=> "Meta Keyword", "description"=> "Meta Keyword", "type"=> "text", "required" => true] ],
                [ ["name"=> "meta_description", "caption"=> "Data Description", "description"=> "Data Description", "type"=> "text", "required" => true] ],
                [ ["name"=> "page_code", "caption"=> "CMS Code", "description"=> "CMS Code", "type"=> "text", "required" => true] ],
            ];
        } else if($tbl_name == "site_notice") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "page_title", "caption"=> "Notice Title", "description"=> "Notice Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "page_content", "caption"=> "Content", "description"=> "Content", "type"=> "contents", "required" => true] ],
            ];
        } else if($tbl_name == "site_email_template") {
            return [
                [ ["name"=> "id", "caption"=> "", "description"=> "", "type"=> "hidden"] ],
                [ ["name"=> "mail_title", "caption"=> "Email Title", "description"=> "Email Title Caption", "type"=> "text", "required" => true] ],
                [ ["name"=> "mail_content", "caption"=> "Email Body Content", "description"=> "Email Body Content", "type"=> "contents", "required" => true] ],
                [ ["name"=> "sms_content", "caption"=> "SMS Body Content", "description"=> "SMS Body Content", "type"=> "textarea", "required" => true] ],
                [ ["name"=> "mail_code", "caption"=> "CMS Code", "description"=> "CMS Code", "type"=> "text", "required" => true] ],
            ];
        }

        return [];
    }

    public function get_caption($tbl_name) {

        if($tbl_name == "business_option") {
            return "Business Option";
        } else if($tbl_name == "site_help") {
            return "Help Content";
        } else if($tbl_name == "news") {
            return "News";
        } else if($tbl_name == "site_contents") {
            return "Media Content";
        } else if($tbl_name == "site_cms") {
            return "Content Management System";
        } else if($tbl_name == "site_notice") {
            return "Notice Management System";
        } else if($tbl_name == "site_email_template") {
            return "Email Template";
        }

        return "";
    }

    public function get_pri_fld($columns) {
        foreach ($columns as $column_arr) {
            foreach ($column_arr as $column) {
                return $column["name"];
            }
        }
        return "id";
    }

    public function calc_order_num($columns) {
        $order_num = 0;
        foreach ($columns as $column_arr) {
            foreach ($column_arr as $column) {
                if($column["type"] == "hidden") continue;
                if($column["type"] == "textarea") continue;
                if($column["type"] == "contents") continue;
                if($column["name"] == "orderNum") return $order_num;
                $order_num++;
            }
        }
        return 0;
    }

    public function get_rows($tbl_name, $categoryIdx = "") {
        if(($tbl_name == "business_option") || ($tbl_name == "site_help") || ($tbl_name == "site_contents") || ($tbl_name == "news"))
            $query = $this->db->get_where($tbl_name, array('categoryIdx' => $categoryIdx));
        else
            $query = $this->db->get($tbl_name);
        return $query->result();
    }

    public function get_rows_total($tbl_name, $categoryIdx = "", $order_fld, $offset=0, $limit=4) {
        if(($tbl_name == "business_option") || ($tbl_name == "site_help") || ($tbl_name == "site_contents") || ($tbl_name == "news") || ($tbl_name == "business"))
            $strsql = "select * from tbl_".$tbl_name." where categoryIdx = '".$categoryIdx."' order by ".$order_fld." limit ".$offset.",".$limit;
        else
            $strsql = "select * from tbl_".$tbl_name." order by ".$order_fld." limit ".$offset.",".$limit;
        return $this->db->query($strsql)->result();
    }

    public function get_rows_total_include_child($tbl_name, $categoryIdx = "", $order_fld, $offset=0, $limit=4) {
        if(($tbl_name == "business_option") || ($tbl_name == "site_help") || ($tbl_name == "site_contents") || ($tbl_name == "news") || ($tbl_name == "business"))
            $strsql = "select * from tbl_".$tbl_name." where categoryIdx LIKE '".$categoryIdx."%' order by ".$order_fld." limit ".$offset.",".$limit;
        else
            $strsql = "select * from tbl_".$tbl_name." order by ".$order_fld." limit ".$offset.",".$limit;
        return $this->db->query($strsql)->result();
    }

    public function get_data($tbl_name, $record_idx) {
        $query = $this->db->get_where($tbl_name, array("id" => $record_idx));
        $result = $query->result();
        if($result) {
            return $result[0];
        }
        return false;
    }

    public function remove_data($tbl_name, $record_idx) {
        $strsql = sprintf("delete from tbl_$tbl_name where id = '$record_idx'");
        $this->db->query($strsql);
    }

    public function save_data($tbl_name, $categoryIdx, $columns, $row) {
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
        if(($tbl_name == "business_option") || ($tbl_name == "site_help") || ($tbl_name == "site_contents") || ($tbl_name == "news"))
            $row['categoryIdx'] = $categoryIdx;

        if(isset($row[$pri_fld]) && ($row[$pri_fld])) {
            $this->db->update($tbl_name, $row, array($pri_fld => $row[$pri_fld]));
        } else {
            $this->db->insert($tbl_name, $row);
        }
    }

    public function get_root_count($tbl_name) {
        $strsql = sprintf("select count(*) cn from tbl_$tbl_name where categoryIdx=''");
        $result = $this->db->query($strsql)->result();
        if($result) return $result[0]->cn;
        return 0;
    }

    public function get_categories($tbl_name, $categoryIdx="", $isDisplay = false) {
        $strCondition = " where left('".$categoryIdx."', length(categoryIdx)) = categoryIdx";
        if($isDisplay) {
            if($strCondition)
                $strCondition .= " and isDisplay = 1";
            else
                $strCondition = " where isDisplay = 1";
        }

        $strsql = "select * from tbl_".$tbl_name." ".$strCondition." order by categoryIdx, orderNum";
        $result = $this->db->query($strsql)->result();

        return $result;
    }

    public function get_tree_rows($category_tbl_name, $tbl_name, $isDisplay = false) {
        $strCondition = "";
        if($isDisplay) $strCondition = " where isDisplay = 1";

        $strsql = sprintf("select * from tbl_$category_tbl_name $strCondition order by parentIdx, orderNum");
        $result = $this->db->query($strsql)->result();
        foreach ($result as $row) {
            $row->children = [];
        }

        $strCondition = "";
        if($isDisplay) $strCondition = " where b.isDisplay = 1";

        $strsql = sprintf("select a.categoryIdx, count(*) cn from tbl_$category_tbl_name a INNER JOIN tbl_$tbl_name b ON a.categoryIdx = b.categoryIdx $strCondition group by a.parentIdx, a.orderNum");
        $result_2 = $this->db->query($strsql)->result();
        foreach ($result_2 as $row_2) {
            foreach ($result as $row) {
                if($row->categoryIdx == $row_2->categoryIdx) {
                    $row->categoryName .= " (".$row_2->cn.")";
                    break;
                }                
            }
        }

        for($i=count($result)-1; $i>=0; $i--) {
            for($j=$i-1; $j>=0; $j--) {
                if($result[$j]->categoryIdx == $result[$i]->parentIdx) {
                    $result[$j]->children = array_merge(array($result[$i]), $result[$j]->children);
                    array_splice($result, $i, 1);
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

    public function get_integrated_list($category_tbl_name, $tbl_name, $isDisplay = false) {
        $strCondition = "";
        if($isDisplay) $strCondition = " where isDisplay = 1";

        $strsql = sprintf("select * from tbl_$category_tbl_name $strCondition order by parentIdx, orderNum");
        $result = $this->db->query($strsql)->result();
        foreach ($result as $row) {
            $row->children = [];
            $row->data = [];
        }

        $strCondition = "";
        if($isDisplay) $strCondition = " where b.isDisplay = 1";

        $strsql = sprintf("select b.* from tbl_$category_tbl_name a INNER JOIN tbl_$tbl_name b ON a.categoryIdx = b.categoryIdx $strCondition order by a.parentIdx, a.orderNum, b.orderNum");
        $result_2 = $this->db->query($strsql)->result();
        foreach ($result_2 as $row_2) {
            foreach ($result as $row) {
                if($row->categoryIdx == $row_2->categoryIdx) {
                    array_push($row->data, $row_2);
                    break;
                }                
            }
        }

        for($i=count($result)-1; $i>=0; $i--) {
            for($j=$i-1; $j>=0; $j--) {
                if($result[$j]->categoryIdx == $result[$i]->parentIdx) {
                    $result[$j]->children = array_merge(array($result[$i]), $result[$j]->children);
                    array_splice($result, $i, 1);
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

    public function get_record($tbl_name, $arr_cond) {
        $query = $this->db->get_where($tbl_name, $arr_cond);
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }
}
