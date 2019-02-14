<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_model extends CI_Model {
    var $tbl_name = "member";
    var $tbl_point_history = "point_history";
    var $tbl_lotto_order = "lotto_order";
    var $tbl_payment_history = "lotto_payment_history";

    public function get_item($memberIdx) {
        $query = $this->db->get_where($this->tbl_name, array("memberIdx" => $memberIdx));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function save_data($row) {
        $member_info = [];
        foreach ($row as $key => $value) {
            if($key != "memberIdx" && $key != "user_password" && $key != "user_password2") {
                if($key == "dob")
                    $member_info[$key] = date("Y-m-d", strtotime($value));
                else
                    $member_info[$key] = $value;
            }
        }

        $strsql = sprintf("select count(*) cn from tbl_%s where memberIdx <> '%s' and user_id='%s'", $this->tbl_name, $row['memberIdx'], $member_info['user_id']);
        $result = $this->db->query($strsql)->result();
        if($result[0]->cn) return -1;

        $strsql = sprintf("select count(*) cn from tbl_%s where memberIdx <> '%s' and user_email='%s'", $this->tbl_name, $row['memberIdx'], $member_info['user_email']);
        $result = $this->db->query($strsql)->result();
        if($result[0]->cn) return -2;

        if($row['memberIdx']) {
            $this->db->update($this->tbl_name, $member_info, array("memberIdx" => $row["memberIdx"]));
        } else {
            $member_info["register_date"] = date("Y-m-d H:i:s");
            $member_info["is_admin"] = 0;
            $this->db->insert($this->tbl_name, $member_info);
            $row['memberIdx'] = $this->db->insert_id();
        }

        if(file_exists(FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx']."_1.jpg")) {
            rename(FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx']."_1.jpg", FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx'].".jpg");
        }

        if(($row['user_password']) && ($row['user_password'] == $row['user_password2'])) {
            $this->reset_password($row['memberIdx'], $row['user_password']);
        }

        return 0;
    }

    public function update_data($arr_data, $arr_cond) {
        $this->db->update($this->tbl_name, $arr_data, $arr_cond);
	}

    public function save_cdata($row){
        $member_info = [];
        
        $strsql = sprintf("select count(*) cn from tbl_%s where user_id='%s' or user_email = '%s'", $this->tbl_name,  $row['userid'], $row['email']);
        $result = $this->db->query($strsql)->result();
        if($result[0]->cn) return -1;

        $member_info['user_id'] = $row['userid'];
        $member_info['user_email'] = $row['email'];
        $member_info['member_status'] = 1;
        $member_info["register_date"] = date("Y-m-d H:i:s");
        $member_info["is_admin"] = 0;
        $this->db->insert($this->tbl_name, $member_info);
        $row['memberIdx'] = $this->db->insert_id();
        if(file_exists(FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx']."_1.jpg")) {
            rename(FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx']."_1.jpg", FCPATH.PROJECT_AVATAR_DIR."/user_".$row['memberIdx'].".jpg");
        }
        $this->reset_password($row['memberIdx'], $row['pass']);
        return 0;
    }

    public function reset_password($memberIdx, $user_password) {
        $member = $this->get_record(["memberIdx" => $memberIdx]);

        $user_salt = md5(time());
        if($member->is_admin) $secure_code = ADMIN_LOGIN_SECURE_CODE;
        else $secure_code = USER_LOGIN_SECURE_CODE;
        $user_password = hash('sha512', $user_password . $secure_code . $user_salt);

        $this->db->update($this->tbl_name, array("user_salt" => $user_salt, "user_password" => $user_password), array("memberIdx" => $memberIdx));
    }

    public function update_status($memberIdx, $member_status) {
        $this->db->update($this->tbl_name, array("member_status" => $member_status), array("memberIdx" => $memberIdx));
    }

    public function get_state_code($arr_states, $stateIdx) {
        foreach ($arr_states as $key => $state) {
            if($state->stateIdx == $stateIdx)
                return $state->stateCode;
        }
        return false;
    }

    public function list_data() {
        $query = $this->db->get($this->tbl_name);
        return $query->result();
    }

    public function get_items($arr_states) {
        
        $query = $this->db->get($this->tbl_name);
        $result = $query->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->regDate = date("Y/m/d", strtotime($result[$i]->register_date));
            $result[$i]->stateCode = $this->get_state_code($arr_states, $result[$i]->stateIdx);
        }

        return $result;
    }

    public function get_record($arr_cond) {
        $query = $this->db->get_where($this->tbl_name, $arr_cond);
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function valid_user_id() {
        $user_id = $this->input->post("user_id");
        $ret = $this->get_record(["user_id" => $user_id]);
        return !( $ret );
    }

    public function valid_user_email() {
        $user_email = $this->input->post("user_email");
        $ret = $this->get_record(["user_email" => $user_email]);
        return !( $ret );
    }

    public function invalid_user_email() {
        return !($this->valid_user_email());
    }

    public function update_record($arr_data, $arr_cond) {
        $this->db->update($this->tbl_name, $arr_data, $arr_cond);
    }

    public function save_record($arr_data) {
        $arr_data["register_date"] = date("Y-m-d H:i:s");
        $arr_data["is_admin"] = 0;        
        $user_salt = md5(time());
        $user_password = $arr_data['user_password'];
        $secure_code = USER_LOGIN_SECURE_CODE;
        $user_password = hash('sha512', $user_password . $secure_code . $user_salt);
        $arr_data['user_password'] = $user_password;
        $arr_data['user_salt'] = $user_salt;

        $this->db->insert($this->tbl_name, $arr_data);
    }

    public function total_count() {
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where member_status = 1";
        $result = $this->db->query($strsql)->result();

        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_ranking_members($order_fld = "member_point desc", $offset = 0, $limit = 10) {
        $strsql = "select * from tbl_".($this->tbl_name)." where member_status = 1 order by $order_fld limit $offset, $limit";
        return $this->db->query($strsql)->result();
    }
    
    public function get_customers(){
        $query = $this->db->get_where($this->tbl_name, array("is_admin" => '0', "member_status" => "1"));
        $result = $query->result_array();

        return $result;
    }
    public function get_point_history($memberIdx){
        $query = $this->db->get_where($this->tbl_point_history, array("author" => $memberIdx));
        $result = $query->result_array();

        return $result;
    }
    public function get_lotto_order_history($memberIdx){
        $query = $this->db->get_where($this->tbl_lotto_order, array("memberIdx" => $memberIdx));
        $result = $query->result_array();

        return $result;
    }
    public function get_lotto_payment_history($memberIdx){
        $query = $this->db->get_where($this->tbl_payment_history, array("memberIdx" => $memberIdx));
        $result = $query->result_array();

        return $result;
    }
}
