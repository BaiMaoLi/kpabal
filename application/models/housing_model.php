<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Housing_model extends CI_Model {
    public function get_cat($id){
        $this->db->select("*");
        $this->db->from("housing_cat");
        $this->db->where("parent",$id);
        $res=$this->db->get();
        //print_r($id);die;
        return $res->result_array();
    }
    public function get_type(){
        $this->db->select("*");
        $this->db->from("housing_type");
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_type_name($id){
        $this->db->select("*");
        $this->db->from("housing_type");
        $this->db->where("id",$id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_locations(){
        $this->db->select("*");
        $this->db->from("housing_locations");
        $res=$this->db->get();die;
        return $res->result_array();
    }
    public function get_location_name($id){
        $this->db->select("*");
        $this->db->from("housing_locations");
        $this->db->where("id",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['name'];
    }
    public function get_cat_name($id){
        $this->db->select("*");
        $this->db->from("housing_cat");
        $this->db->where("id",$id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function redirect($url){
        $this->load->helper('url');
        redirect($this->base_url.$url);
    }
}
?>