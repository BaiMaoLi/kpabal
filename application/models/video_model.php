<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Video_model extends CI_Model {
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
        // print_r($result[0]['value']);
        // print_r("/////");
        return $result[0]['value'];
    }
    public function get_distance(){
    $this->db->select("*");
    $this->db->from("savings_settings");
    $this->db->where("key","distance");
    $res=$this->db->get();
    $result=$res->result_array();
    // print_r($result[0]['value']);
    //     print_r("/////");exit();
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
        //print_r($result);exit();
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
    public function get_category($id=""){
        $this->db->select("news_name");
        $this->db->from("tai_news");
        $res=$this->db->get();
        $result['news']=$res->result_array();

        $this->db->select("country_name");
        $this->db->from("tai_country");
        $res=$this->db->get();
        $result['country']=$res->result_array();

        $this->db->select("cate_name");
        $this->db->from("tai_category");
        $res=$this->db->get();
        $result['category']=$res->result_array();
        return $result;
    }
    public function get_videoinfo($id=""){
        $this->db->select("*");
        $this->db->where("vc_id", $id);
        $this->db->from("tai_information");
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0];
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
    public function get_newsfromdb() {
    $this->db->select('news_id,news_name,news_channelID');
    $this->db->from('tai_news');
    $temp1 =  $this->db->get();
    $temp =array();
    $popular = array();
    $main_news = array();
    $count = 0;
    foreach ($temp1->result_array() as $one) {
       if (!empty($one['news_channelID'])){
        $temp[$count] = $one;
        $count++;
       }
    }
    //print_r($temp);exit();
    $result = array();
    $count = 0;
    if(!empty($temp)) {
        foreach ($temp as $one) {
            //print_r($one['news_id']);exit();
            $this->db->select('*');
            $this->db->where('news_id', $one['news_id']);
            $this->db->where('status', '0');
            
            $this->db->from('tai_information');
            $query =  $this->db->get();
            $temp_result = $query->result_array();
            foreach ($temp_result as $two) {
                array_push($main_news, $two);
            }
            $result[$one['news_name']] = $this->array_multi_subsort($temp_result, 'create_date');
            $temp_popular =  $this->array_multi_subsort($temp_result, 'likes');
            array_push($popular, $temp_popular[0]);
            //print_r($temp_popular[0]);exit();
            //array_push($result['trending'],$temp_trending[0]);
        }

    }else {
        echo "no exist data";
    }
    //print_r($popular);exit();
    $results['news'] = $result;
    $results['popular'] = $popular;
    $results['main'] = $this->array_multi_subsort($main_news, 'create_date');
    //print_r($results);exit();
    return $results;
}
public function get_fromdb() {

    $this->db->select('cate_id,cate_name');
    $this->db->from('tai_category');
    $category_id =  $this->db->get();
    
    $this->db->select('country_id,country_name');
    $this->db->from('tai_country');
    $country =  $this->db->get();
    
    $temp = array();
    $temp_trending = array();
    $popular = array();
    $results = array();
    $main_data = array();
    //print_r($country);exit();
    if(!empty($category_id->result_array()) && !empty($country->result_array())) {
        foreach ($category_id->result_array() as $one) {
            foreach ($country->result_array() as $one_country) {
                // print_r($category_id->result_array());exit();
                $this->db->select('*');
                $this->db->where('category_id', $one['cate_id']);
                $this->db->where('country_id', $one_country['country_id']);
                $this->db->where('status', '0');
                $this->db->from('tai_information');
                $query =  $this->db->get();
                $temp = $query->result_array();
                foreach ($temp as $two) {
                   array_push($main_data, $two);
                }
                
                if(!empty($temp)){
                    $result[$one['cate_name']][$one_country['country_name']] = $this->array_multi_subsort($temp, 'create_date');
                    //$temp_trending[$one['cate_name']] =  $this->array_multi_subsort($temp, 'likes');
                    
                    $temp_popular =  $this->array_multi_subsort($temp, 'likes');
                    array_push($popular, $temp_popular[0]);
                }
            }
            $result['main'][$one['cate_name']] = $main_data;
            $main_data = array();
           
        }
    }
    
    //print_r($temp_trending);exit();
    /*$count = 0;
    foreach ($temp_trending as $one_trending) {
        
        for($i = 0; $i < 4 ; $i++){
            if (!empty($one_trending[$i]))
            $trending[$count] = $one_trending[$i];
            $count++;
        }
    }*/
    //$results['news'] =$result;
    $result['popular'] = $popular;
    //print_r($result['main']);exit();
    return $result;
}


public function insert($table , $data , $ignore = true) {

        $insert_query = $this->db->insert_string($table , $data);
        if ($ignore == true)
            $insert_query = str_replace('INSERT INTO' , 'INSERT IGNORE INTO' , $insert_query);
        $this->db->query($insert_query);
        $customer_id = $this->db->insert_id();
        return $customer_id;
}
public function array_multi_subsort($array, $subkey)
    {
        //print_r("enter");
        $b = array(); $c = array();

        foreach ($array as $k => $v)
        {
            $b[$k] = strtolower($v[$subkey]);
        }

        arsort($b);
        foreach ($b as $key => $val)
        {
            $c[] = $array[$key];
        }

        return $c;
    }
}
?>
