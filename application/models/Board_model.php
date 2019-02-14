<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Board_model extends CI_Model {
    var $tbl_name = "board";
    var $tbl_category_name = "board_category";
    var $tbl_upload_name = "board_file";
    var $tbl_reply_name = "board_reply";
    var $tbl_favorite_name = "board_favorite";
    var $tbl_estimate_name = "board_estimate";
    var $tbl_member = "member";
    var $tbl_point_value = "point_value";
    var $tbl_point_history = "point_history";

    public function get_attachment_name($id) {
        $query = $this->db->get_where($this->tbl_upload_name, array("id" => $id));
        $result = $query->result();
        if(count($result) > 0) return $result[0]->file_name;
        return false;
    }

    public function get_attachment($articleIdx) {
        $query = $this->db->get_where($this->tbl_upload_name, array("articleIdx" => $articleIdx));
        return $query->result();
    }

    public function register_upload_file($file_name) {
        $this->db->insert($this->tbl_upload_name, array("file_name" => $file_name));
        return $this->db->insert_id();
    }

    public function update_upload_file($articleIdx, $id) {
        $this->db->update($this->tbl_upload_name, array("articleIdx" => $articleIdx), array("id" => $id));
    }

    public function get_category_info($categoryIdx) {
        $query = $this->db->get_where($this->tbl_category_name, array("categoryIdx" => $categoryIdx));
        $result = $query->result();
        if($result) return $result[0];
        return false;        
    }

    public function get_item($id) {
        $query = $this->db->get_where($this->tbl_name, array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function generate_id($articleIdx, $parentIdx) {
        $strsql = sprintf("select id from tbl_%s where articleIdx='$articleIdx' and parent_id = '$parentIdx' order by id desc", $this->tbl_reply_name);
        $result = $this->db->query($strsql)->result();
        if(count($result) == 0) {
            return $parentIdx."01";
        } else {
            $last_key = $result[0]->id;
            $last_key = substr($last_key, strlen($parentIdx), 2);
            return $parentIdx.sprintf("%02d", intval($last_key) + 1);
        }
        return false;
    }

    public function remove_article_comment_guest($articleIdx, $id, $memberIdx) {
        
        $point_value=$this->get_point_value();
        
        
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and id = '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete comment";
        $add=$point_value[0]->comment;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and parent_id = '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete reply";
        $add=$point_value[0]->reply;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        //////////////
        $strsql = "delete from tbl_".$this->tbl_reply_name." where articleIdx='$articleIdx' and id LIKE '".$id."%'";
        $this->db->query($strsql);
        $strsql = sprintf("select count(*) cn from tbl_%s where articleIdx='$articleIdx'", $this->tbl_reply_name);
        $result = $this->db->query($strsql)->result();
        $cn = 0;
        if(count($result)) $cn = $result[0]->cn;
        $this->db->update($this->tbl_name, array("reply_count" => $cn), array("id" => $articleIdx));
    }

    public function remove_article_guest($articleIdx, $memberIdx) {
        
        $point_value=$this->get_point_value();
        
        $write=$point_value[0]->write;
        
        $row = [
            "date" => date("Y-m-d H:i:s"),
            "type" => 'Delete write',
            "amount" => "-".$write,
            "author" => $memberIdx,
        ];
        $this->db->insert($this->tbl_point_history, $row);
        
        $this->db->set('member_point', 'member_point-'.$write, FALSE);
        $this->db->where('memberIdx', $memberIdx);
        $this->db->update($this->tbl_member);
        
        
        $id="";
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and parent_id = '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete comment";
        $add=$point_value[0]->comment;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and parent_id != '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete reply";
        $add=$point_value[0]->reply;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        $this->db->delete($this->tbl_name, array("id" => $articleIdx, "memberIdx" => $memberIdx));
        $this->db->delete($this->tbl_reply_name, array("articleIdx" => $articleIdx));
    }

    public function remove_article($articleIdx) {
        $this->db->delete($this->tbl_name, array("id" => $articleIdx));
        $this->db->delete($this->tbl_reply_name, array("articleIdx" => $articleIdx));
    }

    public function remove_reply($articleIdx, $id) {
        
        $point_value=$this->get_point_value();
        
        
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and id = '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete comment";
        $add=$point_value[0]->comment;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        
        $strsql = sprintf("select * from tbl_%s where articleIdx='$articleIdx' and parent_id = '$id'", $this->tbl_reply_name);
        $vals = $this->db->query($strsql)->result();
        $type="Delete reply";
        $add=$point_value[0]->reply;
        foreach($vals as $val){
            $member=$val->memberIdx;
            $row = [
                "date" => date("Y-m-d H:i:s"),
                "type" => $type,
                "amount" => "-".$add,
                "author" => $member,
            ];
            $this->db->insert($this->tbl_point_history, $row);
            $this->db->set('member_point', 'member_point-'.$add, FALSE);
            $this->db->where('memberIdx', $member);
            $this->db->update($this->tbl_member);
        }
        
        $strsql = "delete from tbl_".$this->tbl_reply_name." where articleIdx='$articleIdx' and id LIKE '".$id."%'";
        $this->db->query($strsql);
        $strsql = sprintf("select count(*) cn from tbl_%s where articleIdx='$articleIdx'", $this->tbl_reply_name);
        $result = $this->db->query($strsql)->result();
        $cn = 0;
        if(count($result)) $cn = $result[0]->cn;
        $this->db->update($this->tbl_name, array("reply_count" => $cn), array("id" => $articleIdx));
    }

    public function save_reply_reply($row, $memberIdx) {
        $parent_id = $row["parent_id"];    
        $row["id"] = $this->generate_id($row["articleIdx"], $parent_id);
        $row["reply_date"] = date("Y-m-d H:i:s");
        $row["memberIdx"] = $memberIdx;
        $this->db->insert($this->tbl_reply_name, $row);

        $strsql = sprintf("update tbl_%s set reply_count = reply_count + 1 where id = '%s'", $this->tbl_name, $row["articleIdx"]);
        $this->db->query($strsql);

        return 0;
    }

    public function get_reply_content($row) {
        $id = $row["id"];
        $articleIdx = $row["articleIdx"];

        $query = $this->db->get_where($this->tbl_reply_name, array("id"=>$id, "articleIdx"=>$articleIdx));
        $result = $query->result();
        if(count($result)) return $result[0]->reply_content;
        return false;
    }

    public function update_reply($row) {
        $id = $row["id"];
        $articleIdx = $row["articleIdx"];
        $reply_content = $row["reply_content"];

        $this->db->update($this->tbl_reply_name, array("reply_content" => $reply_content), array("id"=>$id, "articleIdx"=>$articleIdx));
    }

    public function save_reply($row, $memberIdx) {
    
        $row["id"] = $this->generate_id($row["articleIdx"], "");
        $row["reply_date"] = date("Y-m-d H:i:s");
        $row["memberIdx"] = $memberIdx;
        $this->db->insert($this->tbl_reply_name, $row);

        $strsql = sprintf("update tbl_%s set reply_count = reply_count + 1 where id = '%s'", $this->tbl_name, $row["articleIdx"]);
        $this->db->query($strsql);

        return 0;
    }

    public function save_data($row, $memberIdx) {
        $board_info = [];

        $board_info["admin_pre_order_chk"] = 0;

        foreach ($row as $key => $value) {
            if($key != "id") {
                if($key == "admin_pre_order_chk")
                    $board_info[$key] = (($value == "on")?1:0);
                else
                    $board_info[$key] = $value;
            }
        }

        if($row['id']) {
            $this->db->update($this->tbl_name, $board_info, array("id" => $row["id"]));
        } else {
            
        $point_value=$this->get_point_value();
        $write=$point_value[0]->write;
        
        $row = [
            "date" => date("Y-m-d H:i:s"),
            "type" => 'write',
            "amount" => $write,
            "author" => $memberIdx,
        ];
        $this->db->insert($this->tbl_point_history, $row);
        
        $this->db->set('member_point', 'member_point+'.$write, FALSE);
        $this->db->where('memberIdx', $memberIdx);
        $this->db->update($this->tbl_member);
        
            $board_info["article_date"] = date("Y-m-d H:i:s");
            $board_info["memberIdx"] = $memberIdx;
            $this->db->insert($this->tbl_name, $board_info);
            return $this->db->insert_id();
        }

        
        return 0;
    }

    public function get_member_name($arr_members, $memberIdx) {
        foreach ($arr_members as $key => $member) {
            if($member->memberIdx == $memberIdx) {
                $member_name = $member->last_name.' '.$member->first_name;
                if(trim($member_name)) return $member_name;
                return $member->user_id;
            }
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

    public function get_items($arr_categories, $arr_members, $category = "") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%'";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->article_date));
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function get_article_comments($arr_members, $articleIdx, $page_num = 0, $offset = 5) {
        
        $strsql = "select * from tbl_".($this->tbl_reply_name)." where articleIdx = '".$articleIdx."' order by left(id,2) desc, left(id,4), left(id,6), left(id,8) limit ".($page_num * $offset).",".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->reply_date));
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function get_article_comments_count($articleIdx) {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_reply_name)." where articleIdx = '".$articleIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_replies($arr_members, $articleIdx) {
        
        $strsql = "select * from tbl_".($this->tbl_reply_name)." where articleIdx = '".$articleIdx."' order by id";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->reply_date));
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

    public function get_prior_articles($order_fld, $offset = 0, $limit = 5) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." order by $order_fld limit $offset, $limit";
        return $this->db->query($strsql)->result();
    }

    public function get_prior_replies($order_fld, $offset = 0, $limit = 5) {
        
        $strsql = "select * from tbl_".($this->tbl_reply_name)." order by $order_fld limit $offset, $limit";
        return $this->db->query($strsql)->result();
    }

    public function get_suggest_articles($arr_categories, $arr_members, $category = "") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories))." and admin_pre_order_chk = 1 order by admin_pre_order desc";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->article_date));
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function search_articles_count($arr_categories, $category = "", $keyword = "", $field = "article_title") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories));
        if($field == "member_name")
            $strsql .= " and memberIdx in (select memberIdx from tbl_member where concat(first_name, ' ', last_name) LIKE '%".$keyword."%')";
        else
            $strsql .= " and (".$field." LIKE '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_articles($arr_categories, $arr_members, $category = "", $keyword = "", $page_number = 0, $offset = 10, $field = "article_title") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%' ".($this->create_category_condition($arr_categories));
        if($field == "member_name")
            $strsql .= " and memberIdx in (select memberIdx from tbl_member where concat(first_name, ' ', last_name) LIKE '%".$keyword."%')";
        else
            $strsql .= " and (".$field." LIKE '%".$keyword."%')";
        $strsql .= " order by article_date desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->article_date));
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function search_my_articles_count($arr_categories, $memberIdx = 0, $keyword = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where (memberIdx = '".$memberIdx."' or id IN (select distinct articleIdx from tbl_".$this->tbl_reply_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (article_title LIKE '%".$keyword."%' or article_content LIKE '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_my_articles($arr_categories, $arr_members, $memberIdx = 0, $keyword = "", $page_number = 0, $offset = 10) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where (memberIdx = '".$memberIdx."' or id IN (select distinct articleIdx from tbl_".$this->tbl_reply_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (article_title LIKE '%".$keyword."%' or article_content LIKE '%".$keyword."%') order by article_date desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->article_date));
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function search_favorite_articles_count($arr_categories, $memberIdx = 0, $keyword = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where (id IN (select articleIdx from tbl_".$this->tbl_favorite_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (article_title LIKE '%".$keyword."%' or article_content LIKE '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_favorite_articles($arr_categories, $arr_members, $memberIdx = 0, $keyword = "", $page_number = 0, $offset = 10) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where (id IN (select articleIdx from tbl_".$this->tbl_favorite_name." where memberIdx = '".$memberIdx."')) ".($this->create_category_condition($arr_categories))." and (article_title LIKE '%".$keyword."%' or article_content LIKE '%".$keyword."%') order by article_date desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d H:i:s", strtotime($result[$i]->article_date));
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->categoryIdx);
            $result[$i]->memberName = $this->get_member_name($arr_members, $result[$i]->memberIdx);
        }

        return $result;
    }

    public function is_favorite($articleIdx, $memberIdx) {
        $favorite = $this->db->get_where($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx])->result();
        return (count($favorite) > 0);
    }

    public function register_favorite($articleIdx, $memberIdx, $on_off) {
        $before_on_off = $this->is_favorite($articleIdx, $memberIdx);

        if(($before_on_off) == ($on_off)) return false;
        if($on_off) $this->db->insert($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx]);
        else $this->db->delete($this->tbl_favorite_name, ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx]);
        return true;
    }

    public function register_review($articleIdx, $memberIdx, $good_bad) {
        $article = $this->get_item($articleIdx);

        $before_review = $this->is_good_bad($articleIdx, $memberIdx);
        if($before_review == -1) {            
            $this->db->update($this->tbl_name, ["good_count" => $article->good_count + (($good_bad)?1:0), "bad_count" => $article->bad_count + (($good_bad)?0:1) ], ["id" => $articleIdx]);
            $this->db->insert($this->tbl_estimate_name, ["good_bad" => $good_bad, "memberIdx" => $memberIdx, "articleIdx" => $articleIdx]);
        } else {
            if($good_bad == $before_review) return false;
            $this->db->update($this->tbl_name, ["good_count" => $article->good_count + (($good_bad)?1:-1), "bad_count" => $article->bad_count + (($good_bad)?-1:1) ], ["id" => $articleIdx]);
            $this->db->update($this->tbl_estimate_name, ["good_bad" => $good_bad], ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx]);
        }
        return true;
    }

    public function is_good_bad($articleIdx, $memberIdx) {
        $favorite = $this->db->get_where($this->tbl_estimate_name, ["memberIdx" => $memberIdx, "articleIdx" => $articleIdx])->result();
        if(count($favorite) > 0) {
            return $favorite[0]->good_bad;
        }
        return -1;
    }

    public function get_prev_article($categoryIdx, $articleIdx) {
        $strsql = sprintf("select id from tbl_%s where categoryIdx = '$categoryIdx' and id < '$articleIdx' order by id desc limit 1", $this->tbl_name);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->id;
        return false;
    }

    public function get_next_article($categoryIdx, $articleIdx) {
        $strsql = sprintf("select id from tbl_%s where categoryIdx = '$categoryIdx' and id > '$articleIdx' order by id limit 1", $this->tbl_name);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->id;
        return false;
    }

    public function get_article_info($arr_categories, $arr_members, $memberIdx, $id = 0) {
        $article = $this->get_item($id);
        
        if(!($article)) return false;
        $article->categoryName = $this->get_category_name($arr_categories, $article->categoryIdx);
        $article->memberName = $this->get_member_name($arr_members, $article->memberIdx);
        $article->favorite = $this->is_favorite($id, $memberIdx);
        $good_bad = $this->is_good_bad($id, $memberIdx);
        $article->good = ($good_bad == 1);
        $article->bad = ($good_bad == 0);
        $article->view_count = $article->view_count + 1;

        $this->db->update($this->tbl_name, ["view_count" => $article->view_count], ["id" => $id]);

        return $article;
    }

    public function register_article($memberIdx, $articleIdx, $categoryIdx, $article_title, $article_content) {
        $article_date = date("Y-m-d H:i:s");
        $row = [
            "memberIdx" => $memberIdx,
            "categoryIdx" => $categoryIdx,
            "article_title" => $article_title,
            "article_content" => $article_content,
            "article_date" => $article_date,
        ];
        if($articleIdx) $this->db->update($this->tbl_name, $row, ["id" => $articleIdx, "memberIdx" => $memberIdx]);
        else $this->db->insert($this->tbl_name, $row);
        
        $point_value=$this->get_point_value();
        $write=$point_value[0]->write;
        
        $row = [
            "date" => $article_date,
            "type" => 'write',
            "amount" => $write,
            "author" => $memberIdx,
        ];
        $this->db->insert($this->tbl_point_history, $row);
        
        $this->db->set('member_point', 'member_point+'.$write, FALSE);
        $this->db->where('memberIdx', $memberIdx);
        $this->db->update($this->tbl_member);
    }

    public function register_reply($memberIdx, $articleIdx, $parent_id, $reply_content) {
    
        $id = $this->generate_id($articleIdx, $parent_id);
        $reply_date = date("Y-m-d H:i:s");
        $row = [
            "id" => $id,
            "memberIdx" => $memberIdx,
            "articleIdx" => $articleIdx,
            "parent_id" => $parent_id,
            "reply_content" => $reply_content,
            "reply_date" => $reply_date,
        ];
        $this->db->insert($this->tbl_reply_name, $row);

        $strsql = sprintf("update tbl_%s set reply_count = reply_count + 1 where id = '%s'", $this->tbl_name, $articleIdx);
        $this->db->query($strsql);
        
        $point_value=$this->get_point_value();
        if($parent_id==""){
            $add=$point_value[0]->comment;
            $type="comment";
        }else{
            $add=$point_value[0]->reply;
            $type="reply";
        }
        
        $row = [
            "date" => $reply_date,
            "type" => $type,
            "amount" => $add,
            "author" => $memberIdx,
        ];
        $this->db->insert($this->tbl_point_history, $row);
        
        $this->db->set('member_point', 'member_point+'.$add, FALSE);
        $this->db->where('memberIdx', $memberIdx);
        $this->db->update($this->tbl_member);
    }

    public function get_point_value() {
        $point = $this->db->get_where($this->tbl_point_value, array("id" => 1))->result();
        return $point;
    }
    public function save_point_value($data) {
        $this->db->set('write', $data['write']);
        $this->db->set('comment', $data['comment']);
        $this->db->set('reply', $data['reply']);
        $this->db->where('id', 1);
        $this->db->update($this->tbl_point_value);
    }
}
