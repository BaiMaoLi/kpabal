<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subscriber_model extends CI_Model {
    var $tbl_name = "site_subscriber";

    public function save_record($arr_data) {
        $this->db->insert($this->tbl_name, $arr_data);
    }

    public function get_record($arr_cond) {
        $query = $this->db->get_where($this->tbl_name, $arr_cond);
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function remove_record($arr_cond) {
        $this->db->delete($this->tbl_name, $arr_cond);
    }

    public function valid_user_email() {
        $email = $this->input->post("email");
        $ret = $this->get_record(["email" => $email]);
        return !( $ret );
    }

}
