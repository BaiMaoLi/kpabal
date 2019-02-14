<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dating_model extends CI_Model {
    public function get_gmapi(){
        $this->db->select("*");
        $this->db->from("savings_settings");
        $this->db->where("key","gmapi");
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['value'];
    }
    public function get_current_user(){
        $author=$this->session->userdata("withyou-comadmin_login");
        if($author=="")$author=$this->session->userdata("withyou-comuser_login");
        return $author;
    }
    public function get_cat($id){
        $this->db->select("*");
        $this->db->from("dating_cat");
        $this->db->where("parent",$id);
        $res=$this->db->get();
        //print_r($id);die;
        return $res->result_array();
    }
    public function get_type(){
        $this->db->select("*");
        $this->db->from("dating_type");
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_type_name($id){
        $this->db->select("*");
        $this->db->from("dating_type");
        $this->db->where("id",$id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_locations($id=""){
        $this->db->select("*");
        $this->db->from("dating_locations");
        if($id!="")$this->db->where("id",$id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_location_name($id){
        $this->db->select("*");
        $this->db->from("dating_locations");
        $this->db->where("id",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['name'];
    }	public function getData($table,$data,$sort=null){	$this->db->select();	$this->db->from($table);	$this->db->where($data);	if($sort!=null)	{	$this->db->order_by($sort,'DESC');	}	$query = $this->db->get();	return $query->result_array();}public function updateData($table,$cond=array(),$data=array()){	$this->db->where($cond);	$this->db->update($table, $data);}public function deleteData($table,$data){	$this->db->where($data);	$this->db->delete($table); }public function insertData($table,$data){	$this->db->insert($table, $data);	return $this->db->insert_id();}
    public function get_cat_name($id){
        $this->db->select("*");
        $this->db->from("dating_cat");
        $this->db->where("id",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['name'];
    }
    public function get_user_name($id){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("memberIdx ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['user_id'];
    }
    public function get_user_email($id){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("memberIdx ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['user_email'];
    }
    public function get_user($id){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("memberIdx ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0];
    }
    public function redirect($url){
        $this->load->helper('url');
        redirect($this->base_url.$url);
    }
    public function get_recent_rent($id=""){
        $this->db->select("*");
        $this->db->from("dating");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("id",$id);
        $this->db->where("show","on");
        if($id=="")$this->db->where("type",1);
        $res=$this->db->get();
       
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['location'];
            $sch['location']=$this->getData('tbl_dating_locations',array('id'=>$loc_id))[0];
            $sch['cat']=$this->getData('tbl_dating_cat',array('id'=>$sch['category']))[0];
            $sch['subcat']=$this->getData('tbl_dating_cat',array('id'=>$sch['subcat']))[0];
            $sch['author_data']=$this->getData('tbl_member',array('memberIdx'=>$sch['author']))[0];
           $pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
		
    }
    public function get_recent_sale($id=""){
        $this->db->select("*");
        $this->db->from("dating");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("id",$id);
        $this->db->where("show","on");
		$this->db->where("type",2);
        $res=$this->db->get();
         $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['location'];
            $sch['location']=$this->getData('tbl_dating_locations',array('id'=>$loc_id))[0];
            $sch['cat']=$this->getData('tbl_dating_cat',array('id'=>$sch['category']))[0];
            $sch['subcat']=$this->getData('tbl_dating_cat',array('id'=>$sch['subcat']))[0];
            $sch['author_data']=$this->getData('tbl_member',array('memberIdx'=>$sch['author']))[0];
           $pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_premium_rent($id=""){
        $this->db->select("*");
        $this->db->from("dating");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("id",$id);
        $now=date("Y-m-d");
        $this->db->where("pre_date >=",$now);
        $this->db->where("show","on");
		$this->db->where("type",1);
        $res=$this->db->get();
         $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['location'];
            $sch['location']=$this->getData('tbl_dating_locations',array('id'=>$loc_id))[0];
            $sch['cat']=$this->getData('tbl_dating_cat',array('id'=>$sch['category']))[0];
            $sch['subcat']=$this->getData('tbl_dating_cat',array('id'=>$sch['subcat']))[0];
            $sch['author_data']=$this->getData('tbl_member',array('memberIdx'=>$sch['author']))[0];
           $pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_premium_sale($id=""){
        $this->db->select("*");
        $this->db->from("dating");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("id",$id);
		$this->db->where("type",2);
        $now=date("Y-m-d");
        $this->db->where("pre_date >=",$now);
        $this->db->where("show","on");
        $res=$this->db->get();
       $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['location'];
            $sch['location']=$this->getData('tbl_dating_locations',array('id'=>$loc_id))[0];
            $sch['cat']=$this->getData('tbl_dating_cat',array('id'=>$sch['category']))[0];
            $sch['subcat']=$this->getData('tbl_dating_cat',array('id'=>$sch['subcat']))[0];
            $sch['author_data']=$this->getData('tbl_member',array('memberIdx'=>$sch['author']))[0];
           $pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }

    public function get_search_data($data="",$page){
        //print_r($data);
        $this->db->select("*");
            $this->db->from("dating");
            if($data['gender']!="" && $data['gender']!="Both")$this->db->where("gender",$data['gender']);
            if($data['util']!="")$this->db->where("util",$data['util']);
            if($data['deposit']!="")$this->db->where("deposit>",0);
            if($data['dog']!="")$this->db->where("con_dog",$data['dog']);
            if($data['cat']!="")$this->db->where("con_cat",$data['cat']);
            if($data['smoking']!="")$this->db->where("con_smoke",$data['smoking']);
            if($data['cookable']!="")$this->db->where("con_cook",$data['cookable']);
            if($data['tv']!="")$this->db->where("con_tv",$data['tv']);
            if($data['internet']!="")$this->db->where("con_int",$data['internet']);
            if($data['tel']!="")$this->db->where("con_phone",$data['tel']);
            if($data['parking']!="")$this->db->where("con_car",$data['parking']);
            if($data['photo']!="")$this->db->where("con_photo",$data['photo']);            if($data['type']!="")$this->db->where("type",$data['type']);
            if($data['explanation']!="")$this->db->where("con_note",$data['explanation']);
        $this->db->order_by("id", "desc");
        $this->db->where("show","on");
        if($data['keyword']!="")$this->db->like("title",$data['keyword']);
        if($data['location']!="")$this->db->where("location",$data['location']);

        $year="0000";$month="00";$day="00";
        if($data['year']!="")$year=$data['year'];
        if($data['month']!=""){
            $month=$data['month'];
        }else{
            if($data['year']!="")$month="12";
        }
        if($data['day']!=""){
            $day=$data['day'];
        }else{
            if($data['year']!="" && $data['month']!="")$day="31";
        }
        $moving_date=$year."-".$month."-".$day;
        if(strtotime($moving_date)>0)$this->db->where("moving_date<=",$moving_date);

        if($data['category']!=""){
            //$this->db->where("category",$data['category']);
            $this->db->or_where("subcat",$data['category']);
        }

        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        $idx=0;

        foreach($search as $sch){
            $idx++;
            if($idx>($page-1)*8 && $idx<=$page*8) {
                $sch['author_name'] = $this->get_user_name($sch['author']);    
				$pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
                array_push($result, $sch);
            }
        }
       return $result;
    }
    public function edit_rent($data){
      					//$res = $this->db->insert('dating');
       /* if($data['id']!="") {
            $this->db->where("id",$data['id']);
            $res = $this->db->update('dating');
        }else{
            
        }*/
    }
    public function get_all_properties($uid=''){
		        $this->db->select("*");
        $this->db->from("tbl_dating");
        $this->db->order_by("id", "desc");
        $this->db->where("show","on");
        $this->db->where("author",$uid);
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['location'];
            $sch['location']=$this->getData('tbl_dating_locations',array('id'=>$loc_id))[0];
            $sch['cat']=$this->getData('tbl_dating_cat',array('id'=>$sch['category']))[0];
            $sch['subcat']=$this->getData('tbl_dating_cat',array('id'=>$sch['subcat']))[0];
            $sch['author_data']=$this->getData('tbl_member',array('memberIdx'=>$sch['author']))[0];
           $pics= json_decode($sch['images']);		
				$allpic=array();		
				foreach($pics->images as $im){		
				$allpic[]=$this->getData('tbl_dating_images',array('id'=>$im))[0]['src'];		
				}			
				$sch['images']=$allpic;
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
		
	}
    public function edit_sale($data){
        $author=$this->get_current_user();
        $date=date('Y-m-d');
        $this->db->set('title', $data['title']);
        $this->db->set('pre_price', $data['pre_price']);
        $this->db->set('pre_date', $data['pre_date']);
        //$this->db->set('category', $data['careers_occupation1']);
        $this->db->set('subcat', $data['careers_occupation2']);
        $this->db->set('location', $data['location']);
        $this->db->set('address', $data['address']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        //$this->db->set('gender', $data['gender']);
        $this->db->set('price', $data['price']);
        $this->db->set('etc', $data['etc']);
        $this->db->set('createDate', $date);
        if($data['logo']!="") {
            $this->db->set('logo', $data['logo']);
        }
        if($data['id']=="") {
            $this->db->set('author', $author);
        }
        $this->db->set('content', $data['content']);
        if($data['isDisplay']!=""){
            $this->db->set('show', $data['isDisplay']);
        }else{
            $this->db->set('show', "off");
        }
        if($data['id']!="") {
            $this->db->where("id",$data['id']);
            $res = $this->db->update('dating_sale');
        }else{
            $res = $this->db->insert('dating_sale');
            //print_r($data);
        }
    }
    public function delete_rent($id){
        $this->db->where('id', $id);
        $this->db->delete('dating');
    }
    public function delete_sale($id){
        $this->db->where('id', $id);
        $this->db->delete('dating_sale');
    }
    public function get_bocker(){
        $table=$this->db->dbprefix('dating');
        $query = $this->db->query("SELECT author, COUNT(*) FROM ".$table." GROUP BY author ORDER BY COUNT(*) DESC");
        $return=array();
        foreach ($query->result_array() as $row){
            $author=$row['author'];
            $broker=$this->get_user($author);
            array_push($return,$broker);
        }
        return $return;
    }
    public function get_rentByAuthor($id=""){
        $this->db->select("*");
        $this->db->from("dating");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("author",$id);
        $this->db->where("show","on");
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_saleByAuthor($id=""){
        $this->db->select("*");
        $this->db->from("dating_sale");
        $this->db->order_by("id", "desc");
        if($id!="")$this->db->where("author",$id);
        $this->db->where("show","on");
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get1_user_id($username,$email){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("user_id ",$username);
        $this->db->where("user_email ",$email);
        $res=$this->db->get();
        if($res->num_rows()>0){
            $result=$res->result_array();
            $id=$result[0]['memberIdx'];
        }else{
            $id=0;
            $this->db->set("user_id ",$username);
            $this->db->set("user_email ",$email);
            $this->db->insert('member');
        }
        return $id;
    }
    public function get1_cat($name){
        $this->db->select("*");
        $this->db->from("dating_cat");
        $this->db->where("name ",$name);
        $res=$this->db->get();
        if($res->num_rows()>0){
            $result=$res->result_array();
            $id=$result[0]['id'];
        }else{
            $id=0;
            $this->db->set("name ",$name);
            $this->db->set("parent","3");
            $this->db->insert('dating_cat');
        }
        return $id;
    }
    public function get1_location($name,$zip){
        $this->db->select("*");
        $this->db->from("dating_locations");
        $this->db->where("name ",$name);
        $res=$this->db->get();
        if($res->num_rows()>0){
            $result=$res->result_array();
            $id=$result[0]['id'];
        }else{
            $id=0;
            $this->db->set("name ",$name);
            $this->db->set("zip",$zip);
            $this->db->insert('dating_locations');
        }
        return $id;
    }
}
?>