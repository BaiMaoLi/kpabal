<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_model extends CI_Model {
    var $tbl_name = "business";
    var $tbl_comments_name = "business_comments";
    var $tbl_option_name = "business_detail";
    var $tbl_favorite_name = "business_favorite";

    public function get_item($id) {
        $query = $this->db->get_where($this->tbl_name, array("id" => $id));
        $result = $query->result();
        if($result) {
            $this->db->update($this->tbl_name, array("views_count" => $result[0]->views_count + 1), array("id" => $id));
            return $result[0];
        }
        return false;
    }

    public function get_comments($business_id) {
        $query = sprintf("select a.*, b.user_id from tbl_%s a inner join tbl_member b on a.memberIdx = b.memberIdx where business_id='$business_id' order by comment_date desc", $this->tbl_comments_name);
        return $this->db->query($query)->result();
    }

    public function get_options($business_id) {
        $query = $this->db->get_where($this->tbl_option_name, array("business_id" => $business_id));
        $result = $query->result();
        $options = [];
        foreach ($result as $detail) {
            $options[$detail->option_id] = $detail->option_value;
        }
        return $options;
    }

    public function register_business($memberIdx, $business_id, $row) {
        $business_info = [];
        $business_info["memberIdx"] = $memberIdx;
        $business_info["is_display"] = 1;
        $business_info["admin_pre_order_chk"] = 0;
        $business_info["admin_pre_order"] = 0;

        foreach ($row as $key => $value) {
            if(in_array($key, ["categoryIdx", "business_name_en", "business_name_ko", "address", "street", "city", "stateIdx", "zip", "phone1", "phone2", "fax", "website", "email", "work_time", "business_description", "business_keyword", "longitude", "latitude"]))
                $business_info[$key] = $value;
        }
        if($business_info["admin_pre_order_chk"] == 0) $business_info["admin_pre_order"] = 0;

        if($business_id) {
            $this->db->update($this->tbl_name, $business_info, array("id" => $business_id, "memberIdx" => $memberIdx));
        } else {
            $business_info["register_date"] = date("Y-m-d H:i:s");
            $business_info["is_owner"] = 1;
            $business_info["memberIdx"] = $memberIdx;
            $this->db->insert($this->tbl_name, $business_info);
            $business_id = $this->db->insert_id();
        }

        return $business_id;
    }

    public function save_data($row, $memberIdx) {

        $business_info = [];
        $business_info["is_display"] = 0;
        $business_info["admin_pre_order_chk"] = 0;

        foreach ($row as $key => $value) {
            if($key != "id") {
                if($key == "is_display" || $key == "admin_pre_order_chk")
                    $business_info[$key] = (($value == "on")?1:0);
                else
                    $business_info[$key] = $value;
            }
        }

        if($row['id']) {
            $this->db->update($this->tbl_name, $business_info, array("id" => $row["id"]));
        } else {
            $business_info["register_date"] = date("Y-m-d H:i:s");
            $business_info["memberIdx"] = $memberIdx;
            $this->db->insert($this->tbl_name, $business_info);
        }

        return 0;
    }

    public function save_option_datas($memberIdx, $business_id, $row) {
        $business = $this->db->get_where($this->tbl_name, ["memberIdx" => $memberIdx, "id" => $business_id])->result();
        if(count($business) == 0) return false;
        
        $this->db->delete($this->tbl_option_name, array("business_id" => $business_id));
        foreach ($row as $key => $value) {
            $option_id = substr($key, 7);
            $this->db->insert($this->tbl_option_name, array("business_id" => $business_id, "option_id" => $option_id, "option_value" => $value));
        }
        return true;
    }

    public function save_option_data($row) {
        $business_id = $row["id"];

        $this->db->delete($this->tbl_option_name, array("business_id" => $business_id));
        foreach ($row as $key => $value) {
            if($key == "id") continue;
            $option_id = substr($key, 7);
            $this->db->insert($this->tbl_option_name, array("business_id" => $business_id, "option_id" => $option_id, "option_value" => $value));
        }
    }

    public function get_member_name($arr_members, $memberIdx) {
        foreach ($arr_members as $key => $member) {
            if($member->memberIdx == $memberIdx)
                return $member->last_name.' '.$member->first_name;
        }
        return false;
    }

    public function get_category_name($arr_categories, $categoryIdx) {
        foreach ($arr_categories as $key => $category) {
            if($category->categoryIdx == $categoryIdx)
                return $category->categoryName;
        }
        return false;
    }

    public function get_state_code($arr_states, $stateIdx) {
        foreach ($arr_states as $key => $state) {
            if($state->stateIdx == $stateIdx)
                return $state->stateCode;
        }
        return "";
    }

    public function get_items_count($category = "", $search="") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%'";
        if($search) $strsql .= " and (business_name_ko LIKE '%".$search."%' or business_name_en LIKE '%".$search."%' or address LIKE '%".$search."%' or zip LIKE '%".$search."%' or email LIKE '%".$search."%' or phone1 LIKE '%".$search."%' or phone2 LIKE '%".$search."%')";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_items($arr_categories, $arr_states, $arr_members, $category = "", $order_id="register_date", $order_dir="desc", $offset=0, $limit=10, $search="") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%'";
        if($search) $strsql .= " and (business_name_ko LIKE '%".$search."%' or business_name_en LIKE '%".$search."%' or address LIKE '%".$search."%' or zip LIKE '%".$search."%' or email LIKE '%".$search."%' or phone1 LIKE '%".$search."%' or phone2 LIKE '%".$search."%')";
        $strsql .= " order by ".$order_id." ".$order_dir." limit ".$offset.", ".$limit;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function create_category_condition($arr_categories) {
        $categoryIds = "''";
        foreach ($arr_categories as $category) {
            $categoryIds .= ", '".$category->categoryIdx."'";
        }
        return " and categoryIdx IN (".$categoryIds.")";
    }

    public function get_suggest_businesses($arr_categories, $arr_states, $arr_members, $category = "") {

        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and admin_pre_order_chk = 1 and is_display = 1 order by admin_pre_order desc";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function total_count() {
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where is_display = 1";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function recent_business($limit = 3) {
        $strsql = sprintf("select * from tbl_%s where is_display = 1 order by register_date desc limit $limit", $this->tbl_name);
        return $this->db->query($strsql)->result();
    }

    public function search_my_business_count($memberIdx = 0, $arr_categories, $category = "", $keyword = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where memberIdx = '$memberIdx' and categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_my_business($memberIdx = 0, $arr_categories, $arr_states, $category = "", $keyword = "", $page_number = 0, $offset = 10, $sort = "register_date desc") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where memberIdx='$memberIdx' and categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%') order by ".$sort." limit ".($page_number * $offset).", ".$offset;

        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
        }

        return $result;
    }

    public function search_business_count($arr_categories, $category = "", $stateIdx = "", $keyword = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where stateIdx LIKE '".$stateIdx."%' and categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%') and is_display = 1";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_business($arr_categories, $arr_states, $arr_members, $category = "", $stateIdx = "", $keyword = "", $page_number = 0, $offset = 10, $sort = "register_date desc") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where stateIdx LIKE '".$stateIdx."%' and categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%') and is_display = 1 order by admin_pre_order_chk desc, admin_pre_order desc, ".$sort." limit ".($page_number * $offset).", ".$offset;

        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function is_favorite($business_id, $memberIdx) {
        $favorite = $this->db->get_where($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "business_id" => $business_id])->result();
        return (count($favorite) > 0);
    }

    public function register_review($business_id, $memberIdx, $content, $rating_1, $rating_2, $rating_3, $rating_4) {
        $this->db->insert($this->tbl_comments_name, ["memberIdx" => $memberIdx, "business_id" => $business_id, "comment_content" => $content, "rating_1" => $rating_1, "rating_2" => $rating_2, "rating_3" => $rating_3, "rating_4" => $rating_4]);
        $query = sprintf("select count(*) cn, AVG((rating_1 + rating_2 + rating_3 + rating_4) / 4) score from tbl_%s where business_id='$business_id'", $this->tbl_comments_name);
        $result = $this->db->query($query)->result();
        $reviews = $result[0]->cn;
        $rating = $result[0]->score;
        $this->db->update($this->tbl_name, array("reviews" => $reviews, "rating" => $rating), array("id" => $business_id));

        return true;
    }

    public function remove_review($id, $memberIdx) {
        $this->db->delete($this->tbl_comments_name, array("memberIdx" => $memberIdx, "id" => $id));
        return true;
    }

    public function search_review_business_count($memberIdx = 0) {        
        $strsql = "select count(*) cn from tbl_".($this->tbl_comments_name)." where memberIdx = '".$memberIdx."'";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_review_business($memberIdx, $page_number = 0, $offset = 10) {
        $strsql = "select a.*, b.business_name_ko from tbl_".($this->tbl_comments_name)." a inner join tbl_".($this->tbl_name)." b on a.business_id = b.id where a.memberIdx = '".$memberIdx."' order by comment_date desc limit ".($page_number * $offset).", ".$offset;
        return $this->db->query($strsql)->result();        
    }

    public function register_favorite($business_id, $memberIdx, $on_off) {
        $before_on_off = $this->is_favorite($business_id, $memberIdx);

        if(($before_on_off) == ($on_off)) return false;
        if($on_off) $this->db->insert($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "business_id" => $business_id]);
        else $this->db->delete($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "business_id" => $business_id]);
        return true;
    }

    public function search_favorite_business_count($arr_categories, $memberIdx = 0, $keyword = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where (id IN (select business_id from tbl_".$this->tbl_favorite_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%') and is_display = 1";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_favorite_business($arr_categories, $arr_states, $memberIdx = 0, $keyword = "", $page_number = 0, $offset = 10) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where (id IN (select business_id from tbl_".$this->tbl_favorite_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (business_name_ko LIKE '%".$keyword."%' or business_description LIKE '%".$keyword."%') and is_display = 1 order by register_date desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
        }

        return $result;
    }

}
