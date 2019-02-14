<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Savings_model extends CI_Model {
    public function update_gmapi($api){
        $this->db->set("value",$api);
        $this->db->where("key","gmapi");
        $res=$this->db->update('savings_settings');
        return $res;
    }
    public function update_distance($distance){
        $this->db->set("value",$distance);
        $this->db->where("key","distance");
        $res=$this->db->update('savings_settings');
        return $res;
    }
    public function get_gmapi(){
        $this->db->select("*");
        $this->db->from("savings_settings");
        $this->db->where("key","gmapi");
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['value'];
    }
    public function get_distance(){
    $this->db->select("*");
    $this->db->from("savings_settings");
    $this->db->where("key","distance");
    $res=$this->db->get();
    $result=$res->result_array();
    return $result[0]['value'];
}

    public function get_stores($id=""){
        $this->db->select("*");
        $this->db->from("savings_stores");
        if($id!=""){
            $this->db->where("id",$id);
        }
        $res=$this->db->get();
        $result=$res->result_array();
        return $result;
    }
    public function get_categories($id=""){
        $this->db->select("*");
        $this->db->from("savings_categories");
        if($id!=""){
            $this->db->where("id",$id);
        }
        $res=$this->db->get();
        $result=$res->result_array();
        return $result;
    }
    public function get_products($id=""){
        $this->db->select("*");
        $this->db->from("savings_products");
        if($id!=""){
            $this->db->where("id",$id);
        }
        $res=$this->db->get();
        $results=$res->result_array();
        $return=array();
        foreach ($results as $result){
            $store=$this->get_stores($result['store']);
            $result['store_title']=$store[0]['title'];
            $category=$this->get_categories($result['category']);
            $result['category_title']=$category[0]['title'];
            array_push($return,$result);
        }
        return $return;
    }
    public function get_productsByCat($cat=""){
        $return = array();
        $selectedStore=$this->session->userdata("selectedStore");
        if($cat==""){
            $category = $this->get_categories();
            foreach ($category as $cat){
                $cat_id=$cat['id'];
                $this->db->select("*");
                $this->db->from("savings_products");
                $this->db->where("store", $selectedStore);
                $this->db->where("category", $cat_id);
                $res = $this->db->get();
                $results = $res->result_array();
                $tmp=array();
                foreach ($results as $result) {
                    $store = $this->get_stores($result['store']);
                    $result['store_title'] = $store[0]['title'];
                    $category = $this->get_categories($result['category']);
                    $result['category_title'] = $category[0]['title'];
                    array_push($tmp, $result);
                }
                $return[$cat_id]=$tmp;
            }
        }else {
            $this->db->select("*");
            $this->db->from("savings_products");
            $this->db->where("id", $cat);
            $this->db->where("store", $selectedStore);
            $res = $this->db->get();
            $results = $res->result_array();
            foreach ($results as $result) {
                $store = $this->get_stores($result['store']);
                $result['store_title'] = $store[0]['title'];
                $category = $this->get_categories($result['category']);
                $result['category_title'] = $category[0]['title'];
                array_push($return, $result);
            }
        }
        return $return;
    }
    public function getLnt($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false&key=".$this->get_gmapi();
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        $result1[]=$result['results'][0];
        $result2[]=$result1[0]['geometry'];
        $result3[]=$result2[0]['location'];
        echo $zip."<br>";
        print_r($result);
        return $result3[0];
    }

    public function getDistance($zip1, $zip2, $unit="M"){
        $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$zip1."&destinations=".$zip2."&key=".$this->get_gmapi());
        $data = json_decode($api);
        if($data->rows[0]->elements[0]->status=="OK") {
            return (float)str_replace(",", "", $data->rows[0]->elements[0]->distance->text);
        }else{
            return 99999999999999999999999999999999999999;
        }
        /*$first_lat = $this->getLnt($zip1);
        $next_lat = $this->getLnt($zip2);
        $lat1 = $first_lat['lat'];
        $lon1 = $first_lat['lng'];
        $lat2 = $next_lat['lat'];
        $lon2 = $next_lat['lng'];
        $theta=$lon1-$lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *  cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K"){
            return $miles* 1.609344;//($miles * 1.609344)." ".$unit;
        }
        else if ($unit =="N"){
            return $miles*0.8684;//($miles * 0.8684)." ".$unit;
        }
        else{
            return $miles;//." ".$unit;
        }*/

    }
}
?>