<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_model extends CI_Model {
    public function get_gmapi(){
        $this->db->select("*");
        $this->db->from("savings_settings");
        $this->db->where("key","gmapi");
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['value'];
    }
	public function insertData($table,$data)
{ 
	$this->db->insert($table, $data);
	return $this->db->insert_id();
}

public function deleteData($table,$data)
{
	$this->db->where($data);
	$this->db->delete($table); 
}
public function updateData($table,$cond=array(),$data=array())
{
	$this->db->where($cond);
	$this->db->update($table, $data);
}
    public function get_cat($id){
	    $this->db->select("*");
	    $this->db->from("job_cat");
	    $this->db->where_in("parent",$id);
	    $res=$this->db->get();
	    //print_r($id);die;
        return $res->result_array();
	}
	 public function getData($table,$cond=array()){
	    $this->db->select("*");
	    $this->db->from($table);
	    $this->db->where($cond);
	    $res=$this->db->get();
	    //print_r($id);die;
        return $res->result_array();
	}
	public function get_type(){
	    $this->db->select("*");
	    $this->db->from("job_type");
	    $res=$this->db->get();
        return $res->result_array();
	}
	public function get_type_name($id){
	    $this->db->select("*");
	    $this->db->from("job_type");
	    $this->db->where("id",$id);
	    $res=$this->db->get();
        return $res->result_array();
	}
	
	public function get_company_by_id($id){
	    $this->db->select("*");
	    $this->db->from("tbl_jobs_company");
	    $this->db->where("id",$id);
	    $res=$this->db->get();
        return $res->result_array();
	}
	public function get_locations(){
	    $this->db->select("*");
	    $this->db->from("job_locations");
	    $res=$this->db->get();
        return $res->result_array();
	}
	public function get_location_name($id){
	    $this->db->select("*");
	    $this->db->from("job_locations");
	    $this->db->where("id",$id);
	    $res=$this->db->get();
        $result=$res->result_array();
        return $result[0]['name'];
	}
	public function get_cat_name($id){
	    $this->db->select("*");
	    $this->db->from("job_cat");
	    $this->db->where("id",$id);
	    $res=$this->db->get();
        return $res->result_array();
	}
	public function redirect($url){
        $this->load->helper('url'); 
        redirect($this->base_url.$url);
	}

    public function get_current_user(){
        $author=$this->session->userdata("withyou-comadmin_login");
        if($author=="")$author=$this->session->userdata("withyou-comuser_login");
        return $author;
    }
	public function edit_job($data){
        $author=$this->get_current_user();
        $date=date('Y-m-d H:i:s');
        $this->db->set('title', $data['title']);
        $this->db->set('content', $data['content']);
        $this->db->set('category', $data['careers_occupation1']);
        $this->db->set('subcat', $data['careers_occupation2']);
        $this->db->set('company_name', $data['company_name']);
        $this->db->set('company_business', $data['company_business']);
        $this->db->set('company_location', $data['company_location']);
        $this->db->set('company_address', $data['company_address']);
        $this->db->set('company_Traffic', $data['company_Traffic']);
        $this->db->set('company_homepage', $data['company_homepage']);
        $this->db->set('email', $data['email']);
        $this->db->set('company_phone', $data['company_phone']);
        $this->db->set('careers_responsibilities',$data['careers_responsibilities']);
        $this->db->set('careers_qualifications', $data['careers_qualifications']);
        $this->db->set('careers_salary', $data['careers_salary']);
        $this->db->set('careers_type', $data['careers_type']);
        $this->db->set('careers_time', $data['careers_time']);
        $this->db->set('careers_weekly', $data['careers_weekly']);
        $this->db->set('careers_charge', $data['careers_charge']);
        $this->db->set('careers_method', $data['careers_method']);
        $this->db->set('careers_end', $data['careers_end']);
        $this->db->set('careers_etc', $data['careers_etc']);
        $this->db->set('post_date', $date);
        if($data['id']=="") {
            $this->db->set('author', $author);
        }
        if($data['isDisplay']=="on"){
            $this->db->set('show', "on");
        }else{
            $this->db->set('show', "off");
        }

        if($data['pre_price']!="")$this->db->set('pre_price', $data['pre_price']);
        if($data['pre_date']!="")$this->db->set('pre_date', $data['pre_date']);

        if($data['logo']!="")$this->db->set('logo', $data['logo']);
        $id=$data['id'];
        if($id>0){
            $this->db->where('id',$id);
            $res = $this->db->update('jobs');
        }else {
            $res = $this->db->insert('jobs');
        }

    }
    public function edit_person($data){
	    $author=$this->get_current_user();
        $date=date('Y-m-d H:i:s');
        $this->db->set('title', $data['title']);
        $this->db->set('content', $data['content']);
        $this->db->set('category', $data['careers_occupation1']);
        $this->db->set('subcat', $data['careers_occupation2']);
        $this->db->set('name', $data['name']);
        $this->db->set('company_location', $data['company_location']);
        $this->db->set('homepage', $data['homepage']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        $this->db->set('resume', $data['resume']);
        $this->db->set('careers_type', $data['careers_type']);
        $this->db->set('careers_salary', $data['careers_salary']);
        $this->db->set('careers_etc', $data['careers_etc']);
        $this->db->set('post_date', $date);
        if($data['id']=="") {
            $this->db->set('author', $author);
        }
        if($data['isDisplay']=="on"){
            $this->db->set('show', "on");
        }else{
            $this->db->set('show', "off");
        }

        $this->db->set('pre_price', $data['pre_price']);
        $this->db->set('pre_date', $data['pre_date']);

        $id=$data['id'];
        if($id>0) {
            $this->db->where('id',$id);
            $res = $this->db->update('job_persons');
        }else {
            $res = $this->db->insert('job_persons');
        }
    }
	 public function get_jobs_all(){
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
			$sch['company']=$this->get_company_by_id($sch['company_id']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
	
    public function get_jobs($id=""){
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($id!="")$this->db->where("id",$id);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
			$sch['company']=$this->get_company_by_id($sch['company_id']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_persons($id=""){
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        if($id!="")$this->db->where("id",$id);
       
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
	 public function get_persons_by_id($id){
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        $this->db->where("id",$id);
        $res=$this->db->get();
        $search=$res->result_array();
		$result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
	
	 public function get_all_persons(){
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }

    public function get_pre_jobs(){
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_pre_persons(){
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function contact($message_data){
            $from=$message_data['email'];
            $to=$message_data['author_email'];
            $name=$message_data['contact_name'];
            $phone=$message_data['phone'];
            $subject=$message_data['message_content']. "\r\n";
            $subject.="My Phone: ".$phone;
            $headers = "From: ". $from . "\r\n" ."CC: somebodyelse@example.com";

            if(mail($to,$name,$subject, $headers)) {
                return true;
            }else{
                return false;
            }
    }
    public function get_broker(){
        $table=$this->db->dbprefix('jobs');
        $query = $this->db->query("SELECT author, COUNT(*) FROM ".$table." GROUP BY author ORDER BY COUNT(*) DESC");
        $return=array();
        foreach ($query->result_array() as $row){
            $author=$row['author'];
            $broker=$this->get_user($author);
            array_push($return,$broker);
        }
        return $return;
    }
    public function get_user($id){
        $this->db->select("*");
        $this->db->from("member");
        $this->db->where("memberIdx ",$id);
        $res=$this->db->get();
        $result=$res->result_array();
        return $result[0];
    }

    public function get_companies(){
        $table=$this->db->dbprefix('jobs');
        $query = $this->db->query("SELECT id,company_name,logo, COUNT(*) FROM ".$table." GROUP BY company_name ORDER BY COUNT(*) DESC");
        $return=$query->result_array();//array();
        //foreach ($query->result_array() as $row){
            //$author=$row['author'];
            //$broker=$this->get_user($author);
            //array_push($return,$broker);
        //}
        return $return;
    }
    public function get_category_tree(){
        $parents=$this->get_cat(0);
        $return=array();
        foreach ($parents as $parent){
            $parent['child']=$this->get_cat($parent['id']);
            array_push($return,$parent);
        }
        return $return;
    }
    public function get_jobs_by_cat($type="",$cat=""){
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($type=="p")$this->db->where("category",$cat);
        if($type=="s")$this->db->where("subcat",$cat);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_pre_jobs_by_cat($type="",$cat=""){
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($type=="p")$this->db->where("category",$cat);
        if($type=="s")$this->db->where("subcat",$cat);
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function search_jobs($post=""){
		$dt='';
		if($post['postdate']>0){
		if($post['postdate']==1){
			$dt=date('Y-m-d',strtotime('-1 day' , time()));
		}
		if($post['postdate']==2){
			$dt=date('Y-m-d',strtotime('-7 day' , time()));
		}
		if($post['postdate']==3){
			$dt=date('Y-m-d',strtotime('-14 day' , time()));
		}
		if($post['postdate']==4){
			$dt=date('Y-m-d',strtotime('-30 day' , time()));
		}
		}
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db->where("title like '%".$post['keyword']."%'");
       if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db->where_in("careers_type",$post['careers_type']);
        if(count($post['education'])>0 && in_array(0,$post['education'])==false)$this->db->where_in("education",$post['education']);
        if(count($post['experience'])>0 && in_array(0,$post['experience'])==false)$this->db->where_in("experience",$post['experience']);
        if(count($post['qualification'])>0 && in_array(0,$post['qualification'])==false)$this->db->where_in("qualification",$post['qualification']);
		if($post['postdate']>0)$this->db->where("post_date>",$dt);
        if($post['company_location']>0)$this->db->where("company_location",$post['company_location']);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            $sch['company']=$this->get_company_by_id($sch['company_id']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function search_pre_jobs($post=""){
		$dt='';
		if($post['postdate']>0){
		if($post['postdate']==1){
			$dt=date('Y-m-d',strtotime('-1 day' , time()));
		}
		if($post['postdate']==2){
			$dt=date('Y-m-d',strtotime('-7 day' , time()));
		}
		if($post['postdate']==3){
			$dt=date('Y-m-d',strtotime('-14 day' , time()));
		}
		if($post['postdate']==4){
			$dt=date('Y-m-d',strtotime('-30 day' , time()));
		}
		}
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db->where("title like '%".$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db->where_in("careers_type",$post['careers_type']);
		if(count($post['education'])>0 && in_array(0,$post['education'])==false)$this->db->where_in("education",$post['education']);
        if(count($post['experience'])>0 && in_array(0,$post['experience'])==false)$this->db->where_in("experience",$post['experience']);
        if(count($post['qualification'])>0 && in_array(0,$post['qualification'])==false)$this->db->where_in("qualification",$post['qualification']);
		if($post['postdate']>0)$this->db->where("post_date>",$dt);
        if($post['company_location']>0)$this->db->where("company_location",$post['company_location']);
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
			$sch['company']=$this->get_company_by_id($sch['company_id']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_persons_by_cat($type="",$cat=""){
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        if($type=="p")$this->db->where("category",$cat);
        if($type=="s")$this->db->where("subcat",$cat);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function get_pre_persons_by_cat($type="",$cat=""){
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        if($type=="p")$this->db->where("category",$cat);
        if($type=="s")$this->db->where("subcat",$cat);
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function search_persons($post=""){
			$dt='';
		if($post['postdate']>0){
		if($post['postdate']==1){
			$dt=date('Y-m-d',strtotime('-1 day' , time()));
		}
		if($post['postdate']==2){
			$dt=date('Y-m-d',strtotime('-7 day' , time()));
		}
		if($post['postdate']==3){
			$dt=date('Y-m-d',strtotime('-14 day' , time()));
		}
		if($post['postdate']==4){
			$dt=date('Y-m-d',strtotime('-30 day' , time()));
		}
		}
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db->where("title like '%".$$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db->where_in("careers_type",$post['careers_type']);
		if($post['postdate']>0)$this->db->where("post_date>",$dt);
        if($post['company_location']>0)$this->db->where("company_location",$post['company_location']);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function search_pre_persons($post=""){
			$dt='';
		if($post['postdate']>0){
		if($post['postdate']==1){
			$dt=date('Y-m-d',strtotime('-1 day' , time()));
		}
		if($post['postdate']==2){
			$dt=date('Y-m-d',strtotime('-7 day' , time()));
		}
		if($post['postdate']==3){
			$dt=date('Y-m-d',strtotime('-14 day' , time()));
		}
		if($post['postdate']==4){
			$dt=date('Y-m-d',strtotime('-30 day' , time()));
		}
		}
        $today=date("Y-m-d");
        $this->db->select("*");
        $this->db->from("job_persons");
        $this->db->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db->where("title like '%".$$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db->where_in("careers_type",$post['careers_type']);
		if($post['postdate']>0)$this->db->where("post_date>",$dt);
        if($post['company_location']>0)$this->db->where("company_location",$post['company_location']);
        $this->db->where("pre_price>","0");
        $this->db->where("pre_date>",$today);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        return $result;
    }
    public function get_jobs_company($id=""){
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($id!="")$this->db->where("id",$id);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            $sch['tables']=$this->get_jobs_for_company($sch['company_name']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
    public function get_jobs_for_company($company=0){
        $this->db->select("*");
        $this->db->from("jobs");
        $this->db->order_by("post_date", "desc");
        if($company!="")$this->db->where("company_id",$company);
        $this->db->where("show","on");
        $res=$this->db->get();
        $search=$res->result_array();
        $result=array();
        foreach($search as $sch){
            $loc_id=$sch['company_location'];
            $sch['company_location']=$this->get_location_name($loc_id);
            $cat=$this->get_cat_name($sch['category']);
            $scat=$this->get_cat_name($sch['subcat']);
            $sch['category']=$cat[0]['name'];
            $sch['subcat']=$scat[0]['name'];
            $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
            $sch['author_data']=$this->get_user($sch['author']);
            array_push($result,$sch);
        }
        $data['data']=$result;
        return $result;
    }
}
?>