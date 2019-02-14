<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_model extends CI_Model {
	 function __construct(){
            parent::__construct();
            //load our second db and put in $db2
            $this->db2 = $this->load->database('main', TRUE);
        }
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
	$this->db2->insert($table, $data);
	return $this->db2->insert_id();
}

public function deleteData($table,$data)
{
	$this->db2->where($data);
	$this->db2->delete($table); 
}
public function updateData($table,$cond=array(),$data=array())
{
	$this->db2->where($cond);
	$this->db2->update($table, $data);
}
    public function get_cat($id){
	    $this->db2->select("*");
	    $this->db2->from("job_cat");
	    $this->db2->where_in("parent",$id);
	    $res=$this->db2->get();
	    //print_r($id);die;
        return $res->result_array();
	}
	 public function getData($table,$cond=array()){
	    $this->db2->select("*");
	    $this->db2->from($table);
	    $this->db2->where($cond);
	    $res=$this->db2->get();
	    //print_r($id);die;
        return $res->result_array();
	}
	public function get_type(){
	    $this->db2->select("*");
	    $this->db2->from("job_type");
	    $res=$this->db2->get();
        return $res->result_array();
	}
	public function get_type_name($id){
	    $this->db2->select("*");
	    $this->db2->from("job_type");
	    $this->db2->where("id",$id);
	    $res=$this->db2->get();
        return $res->result_array();
	}
	
	public function get_company_by_id($id){
	    $this->db2->select("*");
	    $this->db2->from("tbl_jobs_company");
	    $this->db2->where("id",$id);
	    $res=$this->db2->get();
        return $res->result_array();
	}
	public function get_locations(){
	    $this->db2->select("*");
	    $this->db2->from("job_locations");
	    $res=$this->db2->get();
        return $res->result_array();
	}
	public function get_location_name($id){
	    $this->db2->select("*");
	    $this->db2->from("job_locations");
	    $this->db2->where("id",$id);
	    $res=$this->db2->get();
        $result=$res->result_array();
        return $result[0]['name'];
	}
	public function get_cat_name($id){
	    $this->db2->select("*");
	    $this->db2->from("job_cat");
	    $this->db2->where("id",$id);
	    $res=$this->db2->get();
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
        $this->db2->set('title', $data['title']);
        $this->db2->set('content', $data['content']);
        $this->db2->set('category', $data['careers_occupation1']);
        $this->db2->set('subcat', $data['careers_occupation2']);
        $this->db2->set('company_name', $data['company_name']);
        $this->db2->set('company_business', $data['company_business']);
        $this->db2->set('company_location', $data['company_location']);
        $this->db2->set('company_address', $data['company_address']);
        $this->db2->set('company_Traffic', $data['company_Traffic']);
        $this->db2->set('company_homepage', $data['company_homepage']);
        $this->db2->set('email', $data['email']);
        $this->db2->set('company_phone', $data['company_phone']);
        $this->db2->set('careers_responsibilities',$data['careers_responsibilities']);
        $this->db2->set('careers_qualifications', $data['careers_qualifications']);
        $this->db2->set('careers_salary', $data['careers_salary']);
        $this->db2->set('careers_type', $data['careers_type']);
        $this->db2->set('careers_time', $data['careers_time']);
        $this->db2->set('careers_weekly', $data['careers_weekly']);
        $this->db2->set('careers_charge', $data['careers_charge']);
        $this->db2->set('careers_method', $data['careers_method']);
        $this->db2->set('careers_end', $data['careers_end']);
        $this->db2->set('careers_etc', $data['careers_etc']);
        $this->db2->set('post_date', $date);
        if($data['id']=="") {
            $this->db2->set('author', $author);
        }
        if($data['isDisplay']=="on"){
            $this->db2->set('show', "on");
        }else{
            $this->db2->set('show', "off");
        }

        if($data['pre_price']!="")$this->db2->set('pre_price', $data['pre_price']);
        if($data['pre_date']!="")$this->db2->set('pre_date', $data['pre_date']);

        if($data['logo']!="")$this->db2->set('logo', $data['logo']);
        $id=$data['id'];
        if($id>0){
            $this->db2->where('id',$id);
            $res = $this->db2->update('jobs');
        }else {
            $res = $this->db2->insert('jobs');
        }

    }
    public function edit_person($data){
	    $author=$this->get_current_user();
        $date=date('Y-m-d H:i:s');
        $this->db2->set('title', $data['title']);
        $this->db2->set('content', $data['content']);
        $this->db2->set('category', $data['careers_occupation1']);
        $this->db2->set('subcat', $data['careers_occupation2']);
        $this->db2->set('name', $data['name']);
        $this->db2->set('company_location', $data['company_location']);
        $this->db2->set('homepage', $data['homepage']);
        $this->db2->set('phone', $data['phone']);
        $this->db2->set('email', $data['email']);
        $this->db2->set('resume', $data['resume']);
        $this->db2->set('careers_type', $data['careers_type']);
        $this->db2->set('careers_salary', $data['careers_salary']);
        $this->db2->set('careers_etc', $data['careers_etc']);
        $this->db2->set('post_date', $date);
        if($data['id']=="") {
            $this->db2->set('author', $author);
        }
        if($data['isDisplay']=="on"){
            $this->db2->set('show', "on");
        }else{
            $this->db2->set('show', "off");
        }

        $this->db2->set('pre_price', $data['pre_price']);
        $this->db2->set('pre_date', $data['pre_date']);

        $id=$data['id'];
        if($id>0) {
            $this->db2->where('id',$id);
            $res = $this->db2->update('job_persons');
        }else {
            $res = $this->db2->insert('job_persons');
        }
    }
	 public function get_jobs_all(){
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($id!="")$this->db2->where("id",$id);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        if($id!="")$this->db2->where("id",$id);
       
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        $this->db2->where("id",$id);
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $table=$this->db2->dbprefix('jobs');
        $query = $this->db2->query("SELECT author, COUNT(*) FROM ".$table." GROUP BY author ORDER BY COUNT(*) DESC");
        $return=array();
        foreach ($query->result_array() as $row){
            $author=$row['author'];
            $broker=$this->get_user($author);
            array_push($return,$broker);
        }
        return $return;
    }
    public function get_user($id){
        $this->db2->select("*");
        $this->db2->from("member");
        $this->db2->where("memberIdx ",$id);
        $res=$this->db2->get();
        $result=$res->result_array();
        return $result[0];
    }

    public function get_companies(){
        $table=$this->db2->dbprefix('jobs');
        $query = $this->db2->query("SELECT id,company_name,logo, COUNT(*) FROM ".$table." GROUP BY company_name ORDER BY COUNT(*) DESC");
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($type=="p")$this->db2->where("category",$cat);
        if($type=="s")$this->db2->where("subcat",$cat);
        $this->db2->where("show","on");
        $this->db2->where("price","0");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($type=="p")$this->db2->where("category",$cat);
        if($type=="s")$this->db2->where("subcat",$cat);
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db2->where("title like '%".$post['keyword']."%'");
       if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db2->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db2->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db2->where_in("careers_type",$post['careers_type']);
        if(count($post['education'])>0 && in_array(0,$post['education'])==false)$this->db2->where_in("education",$post['education']);
        if(count($post['experience'])>0 && in_array(0,$post['experience'])==false)$this->db2->where_in("experience",$post['experience']);
        if(count($post['qualification'])>0 && in_array(0,$post['qualification'])==false)$this->db2->where_in("qualification",$post['qualification']);
		if($post['postdate']>0)$this->db2->where("post_date>",$dt);
        if($post['company_location']>0)$this->db2->where("company_location",$post['company_location']);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db2->where("title like '%".$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db2->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db2->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db2->where_in("careers_type",$post['careers_type']);
		if(count($post['education'])>0 && in_array(0,$post['education'])==false)$this->db2->where_in("education",$post['education']);
        if(count($post['experience'])>0 && in_array(0,$post['experience'])==false)$this->db2->where_in("experience",$post['experience']);
        if(count($post['qualification'])>0 && in_array(0,$post['qualification'])==false)$this->db2->where_in("qualification",$post['qualification']);
		if($post['postdate']>0)$this->db2->where("post_date>",$dt);
        if($post['company_location']>0)$this->db2->where("company_location",$post['company_location']);
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        if($type=="p")$this->db2->where("category",$cat);
        if($type=="s")$this->db2->where("subcat",$cat);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        if($type=="p")$this->db2->where("category",$cat);
        if($type=="s")$this->db2->where("subcat",$cat);
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db2->where("title like '%".$$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db2->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db2->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db2->where_in("careers_type",$post['careers_type']);
		if($post['postdate']>0)$this->db2->where("post_date>",$dt);
        if($post['company_location']>0)$this->db2->where("company_location",$post['company_location']);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("job_persons");
        $this->db2->order_by("post_date", "desc");
        if($post['keyword']!="")$this->db2->where("title like '%".$$post['keyword']."%'");
         if(count($post['careers_occupation1'])>0 && in_array(0,$post['careers_occupation1'])==false)$this->db2->where_in("category",$post['careers_occupation1']);
        if(count($post['careers_occupation2'])>0 && in_array(0,$post['careers_occupation2'])==false)$this->db2->where_in("subcat",$post['careers_occupation2']);
        if(count($post['careers_type'])>0 && in_array(0,$post['careers_type'])==false)$this->db2->where_in("careers_type",$post['careers_type']);
		if($post['postdate']>0)$this->db2->where("post_date>",$dt);
        if($post['company_location']>0)$this->db2->where("company_location",$post['company_location']);
        $this->db2->where("pre_price>","0");
        $this->db2->where("pre_date>",$today);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($id!="")$this->db2->where("id",$id);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
        $this->db2->select("*");
        $this->db2->from("jobs");
        $this->db2->order_by("post_date", "desc");
        if($company!="")$this->db2->where("company_id",$company);
        $this->db2->where("show","on");
        $res=$this->db2->get();
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
    
    
    ///////////////////////////
    //                       //
    //      Tai's work       // 
    //                       //
    ///////////////////////////

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
public function insert($table , $data , $ignore = true) {

        $insert_query = $this->db2->insert_string($table , $data);
        if ($ignore == true)
            $insert_query = str_replace('INSERT INTO' , 'INSERT IGNORE INTO' , $insert_query);
        $this->db2->query($insert_query);
        $customer_id = $this->db2->insert_id();
        return $customer_id;
}    
public function update($table,$condition,$data){

        $this->db2->where($condition);
        $this->db2->set($data);
        $response = $this->db2->update($table);
        return $response;
}
public function scraping(){
    libxml_use_internal_errors(true);
    $DOM = new DOMDocument();
    $titles = array();
    $url = 'http://www.marutv.com/drama/page/0/';
    $htmlContent = file_get_contents($url);
    $DOM->loadHTML($htmlContent);
    $xpath = new DOMXPath($DOM);
    $page = $xpath->query("//ul[@class='pagination']/li");
    $page_nmubers = $page[count($page)-2]->nodeValue;
    //echo $page_nmubers;
    //die();
    $count = 0;
    for($i = 0; $i < $page_nmubers; $i++){
        $url = 'http://www.marutv.com/drama/page/'.$i.'/';
        //echo $url.'<br>';
        $htmlContent = file_get_contents($url);
            
        
        $DOM->loadHTML($htmlContent);
        $xpath = new DOMXPath($DOM);
        $contents = $xpath->query("//div[@class='col-sm-4 col-xs-6 item responsive-height post']/h3");
        if (!is_null($contents)) 
        {
         foreach ($contents as $node) {
           //$title[$count] =  $node->nodeValue;
            array_push($titles, $node->nodeValue);
           //echo "<br>";
           // /$count++;

         }
        }
        
    }
    //print_r($titles);exit();
    foreach ($titles as $title) {
        $title_arr = explode(' ', $title);
        $date  = $title_arr[count($title_arr) - 1];
        $title_unique = $title_arr[0];
        $title_temp_unique = $title_arr[0];
        for ($j = 1 ; $j < count($title_arr)-2 ;$j++) {
            $title_unique .= " ".$title_arr[$j];
            //$title_unique = implode(' ', $title_arr[$i]);
        }
        //$title_unique = implode(' ', $title);
        //print_r($titles);
        //print_r($title_unique);
        $this->db2->select('title_id,title');
        $this->db2->from('tai_title');
        $insert_id_uni = 0;
        $query =$this->db2->get()->result_array();
        if(!empty($query)) {
            foreach ($query as $one) {
                if($one['title'] == $title_unique) {
                    $insert_id_uni = $one['title_id'];
                } 
            }
        }
        if ($insert_id_uni == 0)
            $insert_id_uni = $this->insert('tai_title' , ['title'=>$title_unique,]);
        //print_r($title_temp_unique);
    
        

        for ($i = 1 ; $i < count($title_arr)-1 ;$i++) {
            $title_temp_unique .= " ".$title_arr[$i];
            //$title_unique = implode(' ', $title_arr[$i]);
        }

        $insert_id_temp = $this->insert('tai_temp_title' , ['temp_title'=>$title_temp_unique, 'title_id' => $insert_id_uni]);
       
    }

    
    exit();
}
public function get_scraping_data() {
    //print_r("expression");exit();
    $this->db2->select('*');
    $this->db2->from('tai_temp_title');
    $query = $this->db2->get()->result_array();
    
     foreach ($query as $one_title) {

        $temp_one_title = mb_substr($one_title['temp_title'],0,mb_strlen($one_title['temp_title'])-1);
        
        if($one_title['is_status'] == 0){
            print_r($temp_one_title);
        $api_url = 'https://api.dailymotion.com/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&channel=tv&languages=KO&longer_than=20&search='.urlencode($temp_one_title).'&sort=recent&limit=50';
        $playlist = json_decode(file_get_contents($api_url),true);
            if (!empty($playlist['list'])) { 
                foreach ($playlist['list'] as $newsitem){
                    $newsid      = $newsitem['id'];
                    $title       = $newsitem['title'];
                    $image       = $newsitem['thumbnail_240_url'];
                    $duration    = $newsitem['duration'];
                    $time        = $newsitem['created_time'];
                   /* $create_date =  getdate($time)['year'].'-'.
                                    getdate($time)['mon'].'-'.
                                    getdate($time)['mday'];*/
                    $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'], getdate($time)['year']);
                    $create_date = date("Y-m-d", $day);
                    $api_type    = 'D';
                    $likes       = $newsitem['likes_total'];

                    $title_cate = $one_title['temp_title'];
                    $title_cate_arr = explode(' ' , $title_cate);
                    //var_dump($title_cate_arr);
                    $title_cate_arr_len = count($title_cate_arr);
                    //$title_cate_last_int = intval($title_cate_arr[$title_cate_arr_len - 1]);

                    $filteredNumbers = array_filter(preg_split("/\D+/", $title_cate_arr[$title_cate_arr_len - 1]));
                    $firstOccurence = reset($filteredNumbers);
                    //echo $firstOccurence;echo '<br>';
                    $title_cate_last_int = ltrim($firstOccurence, '0');

                    //echo '[last part Integer] '.$title_cate_last_int.'<br>';
                    $slice_length = $title_cate_last_int ? $title_cate_arr_len -1: $title_cate_arr_len;
                    //echo '[slice length] '.$slice_length.'<br>';
                    $title_cate_arr_sub = array_slice($title_cate_arr, 0, $slice_length);
                    $title_compare = implode(' ', $title_cate_arr_sub);
                    //print_r($title_compare);
                    $title_cate1 = $title;
                    $title_cate_arr1 = explode(' ' , $title_cate1);
                    $number = mb_substr($title, mb_strlen($title_compare));

                    $filteredNumbers = array_filter(preg_split("/\D+/", $number));
                    $firstOccurence = reset($filteredNumbers);
                    //echo $firstOccurence;echo '<br>';
                    $title_number = ltrim($firstOccurence, '0');
                    //print_r($title_cate_arr1);
                    //print_r($title_cate_last_int);
                    //echo "<br>";
                    //print_r($title_number);
                    //echo "<br>";

                    //exit();
                    $compare =  mb_stripos($title, $title_compare);
                    $compare1 =  strcmp($title_cate_last_int, $title_number);

                /*    $title = "차달래 부인의 사랑 39회";
                    //$title = "차달래 부인의 사랑.E39999.181019";
                    $title_div = $title;
                    $title_div_arr = explode(' ' , $title_div);
                    $title_div_len = count($title_div_arr);
                    $title_div_int = intval($title_div_arr[$title_div_len - 1]);
                    print_r($title_div_arr);
                    echo "<br>";
                    print_r($title_div_len);
                    echo "<br>";
                    print_r($title_div_int);
                    echo "<br>";
                    //exit();
                    if($title_div_int == 0) {
                        $title_div1 = $title;
                        $title_div_arr1 = explode('.' , $title_div1);
                        $title_div_len1 = count($title_div_arr1);
                        $title_div_int = substr($title_div_arr1[1],1);
                        print_r($title_div_arr1);
                        echo "<br>";
                        print_r($title_div_len1);
                        echo "<br>";
                        print_r($title_div_int1);
                        echo "<br>";
                        print_r($title_div_arr1[1]);
                        echo "<br>";
                        print_r(strlen($title_div_arr1[1]));
                        echo "<br>";
                    }
                        
                    print_r($title_div_int);
                    */
                /*    $title = ".E.39.23sfs";
                    echo intval($title);echo '<br>';

                    $string = "a차달래 부인의 사랑.E039999.181019";

                    $filteredNumbers = array_filter(preg_split("/\D+/", $string));
                    $firstOccurence = reset($filteredNumbers);
                    echo $firstOccurence;echo '<br>';
                    echo ltrim($firstOccurence, '0'); // 3

                    exit();
                */    
                    //var_dump($compare);echo '<br>';
                   // print_r($compare);echo '<br>';
                    if($compare == ture && $compare1 == 0 && !empty($image)) {
                        //print_r($title);echo '<br>';
                        //echo $temp_len = mb_strlen($one_title['temp_title']).'<br>';
                        //$temp_len1 = min($temp_len, mb_strlen($title));
                        //$temp_str = mb_substr($title, 0, $temp_len1);
                        //echo '---'.$temp_str.'<br>';
                        //print_r(mb_substr($one_title['temp_title'],0,mb_strlen($one_title['temp_title'])-1));echo '<br>';
                        //print_r($title_compare);echo '<br>';
                        $insert_video_data = array(
                            'title1'   => $title,     'image'      => $image, 
                            'duration'=> $duration,  'create_date'=> $create_date, 
                            'api_type'=> $api_type,  'video_id'   => $newsid, 
                            'likes'   => $likes,     'title_id'    => $one_title['title_id'],
                            'country_id' => '1',     'category_id' => '1',
                            'title'   => $one_title['temp_title'] 
                            
                        );
                        //if(!empty($image))
                        //$id = $this->insert('tai_information',$insert_video_data, true);
                        print_r($insert_video_data);
                        //exit(); 
                    }           
                }

            }
                    $update_data = array('is_status' => '1');
                    $condition = array('temp_title_id'=>$one_title['temp_title_id']);
                    $set = $update_data;
                    $result = $this->update('tai_temp_title' , $condition , $set);
                    //die();
                     
        }         
    }
  die();
}
public function youtubu_news(){
        
        //$this->db2->empty_table('tai_information');
        
        //$this->db2->query("ALTER TABLE tai_information AUTO_INCREMENT  1");
        $playlist = array();
        $data = array();
        $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';    
        ////////**********Get the news_name_list*********//////////// 
        $this->db2->select('news_id,news_name,news_channelID');
        $this->db2->from('tai_news');
        $temp1 =  $this->db2->get();
        //print_r($temp->result_array());exit();
        $temp =array();
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }
        $channelID_list = $temp;
        $playlist_item_maxcount = 3;
        $videolist_item_maxcount = 2;
        if(!empty($channelID_list)){        
            foreach ($channelID_list as $channel_ID) {
               $api_url = 'https://www.googleapis.com/youtube/v3/playlists?order=date&part=snippet%2CcontentDetails&channelId='.$channel_ID['news_channelID'].'&maxResults='.$playlist_item_maxcount.'&key='.$api_key;
                $playlist = json_decode(file_get_contents($api_url),true);
                if (!empty($playlist)) { 
                   foreach ($playlist['items'] as $listitem) {
                        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$videolist_item_maxcount.'&order=date&playlistId='.$listitem['id'].'&key='.$api_key;
                        $data['videolist'] = json_decode(file_get_contents($api_url),true);
                        if(!empty($data)) {
                            foreach ($data['videolist']['items'] as $videoitem){
                                $videoid       = $videoitem['snippet']['resourceId']['videoId'];
                                $title         = $videoitem['snippet']['title'];
                                $image         = $videoitem['snippet']['thumbnails']['medium']['url'];
                                $create_date   = substr($videoitem['snippet']['publishedAt'],0,10);
                                $api_type      = 'Y';
                                $video_url     = 'https://www.googleapis.com/youtube/v3/videos?part=statistics%2CcontentDetails&id='.$videoid.'&key='.$api_key;
                                $one_videoinfo = json_decode(file_get_contents($video_url),true);
                                foreach ($one_videoinfo['items'] as $item) {
                                   $likes         = $item['statistics']['likeCount'];
                                   $duration      = $item['contentDetails']['duration'];
                                }
                                //print_r($likes);exit();
                                $insert_data = array(
                                    'title'      =>$title,     'image'      =>$image, 
                                    'duration'   =>$duration,  'create_date'=>$create_date, 
                                    'api_type'   =>$api_type,  'video_id'   =>$videoid, 
                                    'likes'      =>$likes,     'news_id'    =>$channel_ID['news_id'] 
                                    
                                );
                                if(!empty($image))
                                $id = $this->insert('tai_information',$insert_data, true);
                                //print_r($insert_data);    
                                
                                //print_r($videoitem['snippet']['title'];
                                //print_r("////");
                            }
                        } 

                   }
                }  
            }
        }else {
            echo "not exist chnnel database";
        }   
}

public function dailymotion_news(){
    
        $limit = 5;
        $this->db2->select('news_id,news_name,daily_userID','country_name');
        $this->db2->from('tai_news');
        $temp1 =  $this->db2->get();
        //print_r($temp1->result_array());exit();
        $userIDs =array();
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['daily_userID'])){
            $userIDs[$count] = $one;
            $count++;
           }
        }

        foreach ($userIDs as $user_ID) {
            $api_url = 'https://api.dailymotion.com/user/'.$user_ID['daily_userID'].'/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,owner,title,&sort=recent&limit='.$limit;
            $playlist = json_decode(file_get_contents($api_url),true);
            // print_r($playlist);exit();
            if (!empty($playlist['list'])) { 
                foreach ($playlist['list'] as $newsitem){
                    $newsid      = $newsitem['id'];
                    $title       = $newsitem['title'];
                    $image       = $newsitem['thumbnail_240_url'];
                    $duration    = $newsitem['duration'];
                    $time        = $newsitem['created_time'];
                   /* $create_date =  getdate($time)['year'].'-'.
                                    getdate($time)['mon'].'-'.
                                    getdate($time)['mday'];*/
                    $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'], getdate($time)['year']);
                    $create_date = date("Y-m-d", $day);
                    $api_type    = 'D';
                    $likes       = $newsitem['likes_total'];
                                //print_r($likes);exit();
                    $insert_video_data = array(
                        'title'   => $title,     'image'      => $image, 
                        'duration'=> $duration,  'create_date'=> $create_date, 
                        'api_type'=> $api_type,  'video_id'   => $newsid, 
                        'likes'   => $likes,     'news_id'    => $user_ID['news_id'] 
                        
                    );
                    if(!empty($image))
                    $id = $this->insert('tai_information',$insert_video_data, true);
                    //print_r($insert_video_data);            
                }

            } 

        }            
        
}


public function youtubu() {

    $data = array();
    $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
    $maxcount = 10;
    //$movie = array();
    $this->db2->select('youtubu_id,cate_id');
    $this->db2->from('tai_category');
    $category_id =  $this->db2->get();

    $this->db2->select('RegionCode, country_id');
    $this->db2->from('tai_country');
    $regioncode =  $this->db2->get();

    //print_r($category_id->result_array());exit();
    foreach ($category_id->result_array() as $one_id) {
        if(!empty($one_id['youtubu_id'])) {
            foreach ($regioncode->result_array() as $one_code) {
                $api_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults='
                           .$maxcount.'&order=date&regionCode='.$one_code['RegionCode']
                           .'&type=video&videoCategoryId='.$one_id['youtubu_id'].'&key='.$api_key;
                $playlist = json_decode(file_get_contents($api_url),true);
                //print_r($playlist);exit();
                if(!empty($playlist)) {
                    foreach ($playlist['items'] as $videoitem) {
                        $videoid       = $videoitem['id']['videoId'];
                        $title         = $videoitem['snippet']['title'];
                        $image         = $videoitem['snippet']['thumbnails']['medium']['url'];
                        $create_date   = substr($videoitem['snippet']['publishedAt'],0,10);
                        $api_type      = 'Y';
                        $video_url     = 'https://www.googleapis.com/youtube/v3/videos?part=statistics%2CcontentDetails&id='.$videoid.'&key='.$api_key;
                        $one_videoinfo = json_decode(file_get_contents($video_url),true);
                        //print_r($one_videoinfo);exit();
                        foreach ($one_videoinfo['items'] as $item) {
                            $likes = $item['statistics']['likeCount'];
                            $duration      = $item['contentDetails']['duration'];
                        }
                        $insert_data = array(
                            'title'      =>$title,     'image'      =>$image, 
                            'duration'   =>$duration,  'create_date'=>$create_date, 
                            'api_type'   =>$api_type,  'video_id'   =>$videoid,
                            'likes'      =>$likes,     'category_id'=>$one_id['cate_id'],
                            'country_id' =>$one_code['country_id']
                            
                        );
                        if(!empty($image))
                        $id = $this->insert('tai_information',$insert_data, true);
                        //print_r($insert_data);
                    }
                }
            }
        }     
    }
}

public function dailymotion(){
    
    $limit = 5;
    $data = array();
    $this->db2->select('daily_id,cate_id');
    $this->db2->from('tai_category');
    $category_id =  $this->db2->get();

    $this->db2->select('country_name, country_id');
    $this->db2->from('tai_country');
    $country_list =  $this->db2->get();
    foreach ($category_id->result_array() as $one_id) {
        if(!empty($one_id['daily_id'])) {
            foreach ($country_list->result_array() as $one) {
                $api_url = 'https://api.dailymotion.com/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&channel='.$one_id['daily_id'].'&languages='.$one['country_name'].'&longer_than=5&sort=recent&limit='.$limit;
                $playlist = json_decode(file_get_contents($api_url),true);
                // print_r($playlist);exit();
                if (!empty($playlist)) { 
                    foreach ($playlist['list'] as $newsitem){
                        $vid      = $newsitem['id'];
                        $title       = $newsitem['title'];
                        $image       = $newsitem['thumbnail_240_url'];
                        $duration    = $newsitem['duration'];
                        $time        = $newsitem['created_time'];
                       /* $create_date =  getdate($time)['year'].'-'.
                                        getdate($time)['mon'].'-'.
                                        getdate($time)['mday'];*/
                        $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'], getdate($time)['year']);
                        $create_date = date("Y-m-d", $day);
                        $api_type    = 'D';
                        $likes       = $newsitem['likes_total'];
                                    //print_r($likes);exit();
                        $data = array(
                            'title'      => $title,       'image'      => $image, 
                            'duration'   => $duration,    'create_date'=> $create_date, 
                            'api_type'   => $api_type,    'video_id'   => $vid, 
                            'likes'      => $likes,       'category_id'    => $one_id['cate_id'],
                            'country_id' => $one['country_id']
                        );
                        $id = $this->insert('tbl_tai_information', $data, true);
                        //print_r($data);     
                    }

                } 
            }
        }            
    }    
}

public function get_trending() {
    $name = 'trending';
    $this->db2->select('cate_id');
    $this->db2->where('cate_name', $name);
    $this->db2->from('tai_category');
    $id =  $this->db2->get()->result_array();
    $trending_id = $id[0]['cate_id'];
    //print_r($trending_id);exit();
    $data = array();
    $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
    $maxcount = 10;

    $this->db2->select('RegionCode, country_id');
    $this->db2->from('tai_country');
    $regioncode =  $this->db2->get();

    //print_r($category_id->result_array());exit();
    foreach ($regioncode->result_array() as $one_code) {
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&chart=mostPopular&maxResults='.$maxcount.'&regionCode='.$one_code['RegionCode'].'&key='.$api_key;
        $playlist = json_decode(file_get_contents($api_url),true);
        //print_r($playlist);exit();
        if(!empty($playlist)) {
            foreach ($playlist['items'] as $videoitem) {
                $videoid       = $videoitem['id'];
                $title         = $videoitem['snippet']['title'];
                $image         = $videoitem['snippet']['thumbnails']['medium']['url'];
                $create_date   = substr($videoitem['snippet']['publishedAt'],0,10);
                $api_type      = 'Y';
                $likes         = $videoitem['statistics']['likeCount'];
                $duration      = $videoitem['contentDetails']['duration'];
                $insert_data = array(
                    'title'      =>$title,     'image'      =>$image, 
                    'duration'   =>$duration,  'create_date'=>$create_date, 
                    'api_type'   =>$api_type,  'video_id'   =>$videoid,
                    'likes'      =>$likes,     'category_id'=>$trending_id,
                    'country_id' =>$one_code['country_id']
                    
                );
                if(!empty($image))
                $id = $this->insert('tai_information',$insert_data, true);
                //print_r($insert_data);
            }
        }
    }

    $limit = 20;
    $count = 0;
    $result = array();
    $this->db2->select('country_name, country_id');
    $this->db2->from('tai_country');
    $country_name =  $this->db2->get();
    foreach ($country_name->result_array() as $one) {
        $api_url = 'https://api.dailymotion.com/videos?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&languages='.$one['country_name'].'&sort=trending&limit='.$limit;
        $list = json_decode(file_get_contents($api_url),true);
        if (!empty($list['list'])) { 
            foreach ($list['list'] as $oneitem){
                $newsid      = $oneitem['id'];
                $title       = $oneitem['title'];
                $image       = $oneitem['thumbnail_240_url'];
                $duration    = $oneitem['duration'];
                $time        = $oneitem['created_time'];
                $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'],            getdate($time)['year']);
                $create_date = date("Y-m-d", $day);
                $api_type    = 'D';
                $likes       = $oneitem['likes_total'];
                            //print_r($likes);exit();
                $related_data = array(
                    'title'      =>$title,     'image'      =>$image, 
                    'duration'   =>$duration,  'create_date'=>$create_date, 
                    'api_type'   =>$api_type,  'video_id'   =>$videoid,
                    'likes'      =>$likes,     'category_id'=>$trending_id,
                    'country_id' =>$one['country_id']
                );
                
                if(!empty($image))
                $id = $this->insert('tai_information',$related_data, true);
                //print_r($related_data);
            }

        } 
    }
}
public function get_newsfromdb() {
    $this->db2->select('news_id,news_name,news_channelID');
    $this->db2->from('tai_news');
    $temp1 =  $this->db2->get();
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
            $this->db2->select('*');
            $this->db2->where('news_id', $one['news_id']);
            $this->db2->from('tai_information');
            $query =  $this->db2->get();
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
    $results['main'] = $main_news;
    //print_r($results);exit();
    return $results;
}

public function get_fromdb() {

    $this->db2->select('cate_id,cate_name');
    $this->db2->from('tai_category');
    $category_id =  $this->db2->get();
    
    $this->db2->select('country_id,country_name');
    $this->db2->from('tai_country');
    $country =  $this->db2->get();
    
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
                $this->db2->select('*');
                $this->db2->where('category_id', $one['cate_id']);
                $this->db2->where('country_id', $one_country['country_id']);
                $this->db2->from('tai_information');
                $query =  $this->db2->get();
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


public function getdailymotion_relatedlist($video_id) {

    $limit = 10;
    $count = 0;
    $result = array();
    $api_url = 'https://api.dailymotion.com/video/'.$video_id.'/related?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&limit='.$limit;
    $relatedlist = json_decode(file_get_contents($api_url),true);
            if (!empty($relatedlist['list'])) { 
                foreach ($relatedlist['list'] as $oneitem){
                    $newsid      = $oneitem['id'];
                    $title       = $oneitem['title'];
                    $image       = $oneitem['thumbnail_240_url'];
                    $duration    = $oneitem['duration'];
                    $time        = $oneitem['created_time'];
                    $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'],           getdate($time)['year']);
                    $create_date = date("Y-m-d", $day);
                    $api_type    = 'D';
                    $likes       = $oneitem['likes_total'];
                                //print_r($likes);exit();
                    $related_data = array(
                        'title'   => $title,    'image'      => $image, 
                        'duration'=> $duration, 'create_date'=> $create_date, 
                        'api_type'=> $api_type, 'video_id'   => $newsid, 
                        'likes'   => $likes
                    );
                    $result[$count] = $related_data;
                    $count++;
                               
                }

            } else {
                 echo "empty data";
            }
            //print_r($result);
            $results =  $this->array_multi_subsort($result, 'create_date'); 
            return $results;
}

public function getdailymotion_playlist($video_id) {
//print_r($videoinfo['video_id']);exit();
    $limit = 10;
    $count = 0;
    $result = array();
    $api_url = 'https://api.dailymotion.com/video/'.$video_id.'/related?fields=created_time,duration,id,likes_total,thumbnail_240_url,title,&limit='.$limit;
    $relatedlist = json_decode(file_get_contents($api_url),true);
            if (!empty($relatedlist['list'])) { 
                foreach ($relatedlist['list'] as $oneitem){
                    $newsid      = $oneitem['id'];
                    $title       = $oneitem['title'];
                    $image       = $oneitem['thumbnail_240_url'];
                    $duration    = $oneitem['duration'];
                    $time        = $oneitem['created_time'];
                    $day         = mktime(0,0,0,getdate($time)['mon'], getdate($time)['mday'],           getdate($time)['year']);
                    $create_date = date("Y-m-d", $day);
                    $api_type    = 'D';
                    $likes       = $oneitem['likes_total'];
                                //print_r($likes);exit();
                    $related_data = array(
                        'title'   => $title,    'image'      => $image, 
                        'duration'=> $duration, 'create_date'=> $create_date, 
                        'api_type'=> $api_type, 'video_id'   => $newsid, 
                        'likes'=>$likes
                    );
                    $result[$count] = $related_data;
                    $count++;
                               
                }

            } else {
                 echo "empty data";
            }
            //print_r($result);
            $results =  $this->array_multi_subsort($result, 'create_date'); 
            return $results; 

}

public function getplaylist($video_id) {
//       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
       //print_r($video_id);exit();
       $playlist = array();
       $result = array();
       $videolist_item_maxcount = 2;
       $playlist_item_maxcount = 3;
       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
       $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$video_id.'&key='.$api_key;
       $data['channelid'] = json_decode(file_get_contents($api_url),true);
       //print_r($data['channelid']);exit();
       $channelid = $data['channelid']['items'][0]['snippet']['channelId'];
       $api_url = 'https://www.googleapis.com/youtube/v3/playlists?part=snippet&maxResults='.$playlist_item_maxcount.'&channelId='.$channelid.'&key='.$api_key;
       $data['playlists'] = json_decode(file_get_contents($api_url),true);
       $count = 0;
       foreach ($data['playlists']['items'] as $oneplaylistid) {
          $playlistid = $oneplaylistid['id'];
          $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$videolist_item_maxcount.'&playlistId='.$playlistid.'&key='.$api_key;
          $data['videos'] = json_decode(file_get_contents($api_url),true);
       
            //print_r($data['videos']);exit();
       //$data['videolist'] = json_decode(file_get_contents($api_url),true);
            if(!empty($data['videos'])) {
                
                foreach ($data['videos']['items'] as $videoitem){

                    $videoid     = $videoitem['snippet']['resourceId']['videoId'];
                    $title       = $videoitem['snippet']['title'];
                    $image       = $videoitem['snippet']['thumbnails']['medium']['url'];
                    //$duration    = "45:06";
                                //print_r(expression)
                    $create_date = $videoitem['snippet']['publishedAt'];
                    $api_type    = 'Y';
                    $video_url   = 'https://www.googleapis.com/youtube/v3/videos?part=statistics%2CcontentDetails&id='.$videoid.'&key='.$api_key;
                                    $one_videoinfo = json_decode(file_get_contents($video_url),true);
                                    foreach ($one_videoinfo['items'] as $item) {
                                        $likes      = $item['statistics']['likeCount'];
                                        $duration   = $item['contentDetails']['duration'];
                                    }
                                //print_r($likes);exit();
                    $video_data = array(
                        'title'    => $title,    'image'       => $image, 
                        'duration' => $duration, 'create_date' => $create_date, 
                        'api_type' => $api_type, 'video_id'    => $videoid,
                        'likes'    => $likes
                    );
                    $result[$count] = $video_data;
                    $count++;
                    //print_r($videoitem['snippet']['title'];
                    //print_r("////");
                }
                $playlist = $result;
            }
        }     //print_r($playlist);exit(); 
        $result =  $this->array_multi_subsort($playlist, 'create_date'); 
        return $result; 


}

public function getrelatedlist($video_id){

       $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
       $playlist = array();
       $result = array();
       $videolist_item_maxcount = 10;
       $api_url = 'https://www.googleapis.com/youtube/v3/search/?type=video&relatedToVideoId='.$video_id.'&part=snippet&key='.$api_key;
       $data['videolist'] = json_decode(file_get_contents($api_url),true);
       //print_r($data['videolist']);exit();
       if(!empty($data)) {
                $count = 0;
                foreach ($data['videolist']['items'] as $videoitem){
                    $videoid     = $videoitem['id']['videoId'];
                    $title       = $videoitem['snippet']['title'];
                    $image       = $videoitem['snippet']['thumbnails']['medium']['url'];
                    //$duration    = "45:06";
                                //print_r(expression)
                    $create_date = $videoitem['snippet']['publishedAt'];
                    $api_type    = 'Y';
                    $video_url   = 'https://www.googleapis.com/youtube/v3/videos?part=statistics%2CcontentDetails&id='.$videoid.'&key='.$api_key;
                                    $one_videoinfo = json_decode(file_get_contents($video_url),true);
                                    foreach ($one_videoinfo['items'] as $item) {
                                        $likes      = $item['statistics']['likeCount'];
                                        $duration   = $item['contentDetails']['duration'];
                                    }
                                //print_r($likes);exit();
                    $video_data = array(
                        'title'    => $title,    'image'       => $image, 
                        'duration' => $duration, 'create_date' => $create_date, 
                        'api_type' => $api_type, 'video_id'    => $videoid,
                        'likes'    => $likes
                    );
                    $result[$count] = $video_data;
                    $count++;
                                //print_r($videoitem['snippet']['title'];
                                //print_r("////");
                }
                $playlist = $result;
             }
             //print_r($playlist);exit(); 
        $result =  $this->array_multi_subsort($playlist, 'create_date'); 
        return $result;

}

public function getyoutubuvideoinfo($videoid) {

    $api_key = 'AIzaSyD0lAsKmOHyamA410bIZRcsRa6qDjUJATw';
    $api_url = 'https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&part=snippet%2CcontentDetails%2Cstatistics&key='.$api_key;
    $videoitem = json_decode(file_get_contents($api_url),true);
    //print_r($videoitem);exit();
                    $videoid     = $videoitem['items'][0]['id'];
                    $title       = $videoitem['items'][0]['snippet']['title'];
                    $image       = $videoitem['items'][0]['snippet']['thumbnails']['medium']['url'];
                    $duration    = $videoitem['items'][0]['contentDetails']['duration'];
                                //print_r(expression)
                    $create_date = $videoitem['items'][0]['snippet']['publishedAt'];
                    $api_type    = 'Y';
                    $likes       = $videoitem['items'][0]['statistics']['likeCount'];
                    //print_r($likes);exit();
                    $video_data  = array(
                        'title'    => $title,    'image'       => $image, 
                        'duration' => $duration, 'create_date' => $create_date, 
                        'api_type' => $api_type, 'video_id'    => $videoid,
                        'likes'    => $likes
                    );
                    return $video_data;
}

public function getdailyvideoinfo($videoid) {

    //$result = array();
    $api_url = 'https://api.dailymotion.com/video/'.$videoid.'?fields=created_time,duration,id,likes_total,thumbnail_240_url,title';
    $videoinfo = json_decode(file_get_contents($api_url),true);
    //print_r($videoinfo);exit();
            if (!empty($videoinfo)) { 
                    $newsid      = $videoinfo['id'];
                    $title       = $videoinfo['title'];
                    $image       = $videoinfo['thumbnail_240_url'];
                    $duration    = $videoinfo['duration'];
                    $create_date = $videoinfo['created_time'];
                    $api_type    = 'D';
                    $likes       = $videoinfo['likes_total'];
                                //print_r($likes);exit();
                    $video_data = array(
                        'title'   => $title,    'image'      => $image, 
                        'duration'=> $duration, 'create_date'=> $create_date, 
                        'api_type'=> $api_type, 'video_id'   => $newsid, 
                        'likes'   => $likes
                    );
                    //$result[$count] = $video_data;

            } else {
                 echo "empty data";
            }
            //print_r($result); 
            return $video_data;
}
public function getyoutubu_newsfromdb() {

        $this->db2->select('news_id,news_name,news_channelID');
        $this->db2->from('tai_news');
        $temp1 =  $this->db2->get();
        $temp =array();
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }
        //print_r($temp);exit();
        $result = array();
        if(!empty($temp)) {
            foreach ($temp as $one) {
                //print_r($one['news_id']);exit();
                $this->db2->select('*');
                $this->db2->where('news_id', $one['news_id']);
                $this->db2->where('api_type', 'Y');
                $this->db2->from('tai_information');
                $query =  $this->db2->get();
                $result[$one['news_name']] = $query->result_array(); 
            }

        }else {
            echo "no exist data";
        }
        //print_r($result);exit();
        return $result;
}
public function getdailymotion_newsfromdb(){
        $this->db2->select('news_id,news_name,news_channelID');
        $this->db2->from('tai_news');
        $temp1 =  $this->db2->get();
        //print_r($temp->result_array());exit();
        $temp =array();
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }
        $result = array();
        if(!empty($temp)) {
            foreach ($temp as $one) {
                $this->db2->select('*');
                $this->db2->where('news_id', $one['news_id']);
                $this->db2->where('api_type', 'D');
                $this->db2->from('tai_information');
                $query =  $this->db2->get();
                $result[$one['news_name']] = $query->result_array(); 
            }

        }else {
            echo "no exist data";
        }
        //print_r($result);exit();
        return $result;
}
public function comment_save($video_id, $comment_data, $user, $email) {
    //$insert_dbdata  = array()
    $date = date("Y-m-d h:i:sa");
    $insert_data = array('video_id'      => $video_id, 'comment_data' => $comment_data, 
                         'create_date'   => $date,     'comment_user' => $user,
                         'comment_email' => $email);
    $id = $this->insert('tai_comment',$insert_data, true);
}
public function comment_call($video_id) {
    $this->db2->select('*');
    $this->db2->where('video_id', $video_id);
    $this->db2->from('tai_comment');
    $query = $this->db2->get();
    $result = $query->result_array();
    return $result; 
}
public function pagedata($page_number,$cate_name,$sub_name,$data_limit) {
    //print_r($sub_name);
    //empty($sub_name)? print_r("empty") : print_r("exsit");exit();
    $limit = $data_limit;
    $page = $page_number - 1;
    $start = $page*$limit;

    //print_r($start);exit();
    if(!empty($sub_name)){
        //print_r("exsit");exit();
        if($cate_name == 'news') {
            $this->db2->select('news_id,news_name');
            $this->db2->from('tai_news');
            $this->db2->where('news_name', $sub_name);
            $cate_id = $this->db2->get()->result_array();
            //print_r($cate_id[0]['news_id']);exit();
            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('news_id', $cate_id[0]['news_id']);
            $query = $this->db2->get();

            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('news_id', $cate_id[0]['news_id']);
            $this->db2->order_by('create_date', 'desc');
            $this->db2->limit($limit, $start);
            $result['video'] = $this->db2->get()->result_array();
            $result['total_count'] = $query->num_rows();
            //print_r($cate_id[0]);exit();
        }
        else {
            $this->db2->select('cate_id');
            $this->db2->from('tai_category');
            $this->db2->where('cate_name', $cate_name);
            $cate_id = $this->db2->get()->result_array();
            //print_r($cate_id[0]['cate_id']);

            $this->db2->select('country_id');
            $this->db2->from('tai_country');
            $this->db2->where('country_name', $sub_name);
            $country_id = $this->db2->get()->result_array();
            //print_r($sub_name);exit();
            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('category_id', $cate_id[0]['cate_id']);
            $this->db2->where('country_id', $country_id[0]['country_id']);
            $query = $this->db2->get();

            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('category_id', $cate_id[0]['cate_id']);
            $this->db2->where('country_id', $country_id[0]['country_id']);
            $this->db2->order_by('create_date', 'desc');
            $this->db2->limit($limit, $start);
            $result['video'] = $this->db2->get()->result_array();
            $result['total_count'] = $query->num_rows();
        }
    }
    else {
        if($cate_name == 'news') {
            //print_r("expression");exit();
            //$this->db2->select('news_id');
            //$this->db2->select_sum('news_id');
            //$this->db2->from('tai_news');
            $cate_id = array();
            $cate_name = array();
            $this->db2->select('news_id,news_name');
            $query = $this->db2->get('tai_news');
            foreach ($query->result_array() as $one) {
                array_push($cate_id, $one['news_id']);
                array_push($cate_name, $one['news_name']);
            }
            
            //$cate_id = $this->db2->get()->result_array();
            //print_r($cate_id);exit();s

            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where_in('news_id', $cate_id );
            $this->db2->order_by('create_date', 'desc');
            $query = $this->db2->get();

            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where_in('news_id', $cate_id );
            $this->db2->order_by('create_date', 'desc');
            $this->db2->limit($limit, $start);
            $result['video'] = $this->db2->get()->result_array();
            $result['category'] = $cate_name;
            $result['total_count'] = $query->num_rows();
            //print_r($result['category']);exit();
        }
        else 
        {    
            //print_r("expression");exit();s
            $catename = array();
            $this->db2->select('cate_id');
            $this->db2->from('tai_category');
            $this->db2->where('cate_name', $cate_name);
            $cate_id = $this->db2->get()->result_array();
            //print_r($cate_id[0]['cate_id']);
            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('category_id', $cate_id[0]['cate_id']);
            $this->db2->order_by('create_date', 'desc');
            $query = $this->db2->get();

            $this->db2->select('*');
            $this->db2->from('tai_information');
            $this->db2->where('category_id', $cate_id[0]['cate_id']);
            $this->db2->order_by('create_date', 'desc');
            $this->db2->limit($limit, $start);
            $result['video'] = $this->db2->get()->result_array();
            $result['total_count'] = $query->num_rows();
            $this->db2->select('country_name');
            $this->db2->from('tai_country');
            $query = $this->db2->get()->result_array();
            foreach ($query as $one) {
                array_push($catename, $one['country_name']);
            }
            $result['category'] = $catename;
        }
    }
    return $result;
}
public function main_list(){

    $date = array();
    $today = date('Y-m-d');
    array_push($date, $today);

    $ym = date('Y-m', strtotime("-1 days"));
    $day= date('d',strtotime("-1 days"));
    for($i = $day; $i > $day-6; $i--) {
        array_push($date,  $ym.'-'.$i);
    }
    //print_r($date);exit();
    $this->db2->select('cate_id,cate_name');
    $this->db2->from('tai_category');
    $query = $this->db2->get()->result_array();
    //print_r($query);exit();
    foreach ($query as $one) {
        $this->db2->select('*');
        $this->db2->from('tai_information');
        $this->db2->where('create_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
        $this->db2->where('category_id', $one['cate_id']);
        $this->db2->order_by('create_date','desc');
        $this->db2->where('country_id', '1');
        $query1 = $this->db2->get()->result_array();
        //print_r($query1);
        if(!empty($query1)){
            //print_r($query1);
            for($i = 0 ; $i < 7 ; $i++){
                //print_r($data[$i])
                $temp = array();
                foreach ($query1 as $video) {
                    if($video['create_date'] == $date[$i] )
                        array_push($temp ,$video);
                }
                $result[$one['cate_name']][$i] = $temp;
            }


        }

    }
    $cate_id = array();
    $this->db2->select('news_id');
    $cate = $this->db2->get('tai_news');
    foreach ($cate->result_array() as $one) {
        array_push($cate_id, $one['news_id']);
    }
    
    //$cate_id = $this->db2->get()->result_array();
    //print_r($cate_id);exit();

    $this->db2->select('*');
    $this->db2->from('tai_information');
    $this->db2->where_in('news_id', $cate_id );
    $this->db2->where('create_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
    $this->db2->order_by('create_date', 'desc');
    $news = $this->db2->get()->result_array();
    //$sidevideo = array_merge($result['sport'], $result['music'];
    //print_r($news);exit();
    if(!empty($news)){
            //print_r($query1);
            for($i = 0 ; $i < 7 ; $i++){
                //print_r($data[$i])
                $temp = array();
                foreach ($news as $video) {
                    if($video['create_date'] == $date[$i] )
                        array_push($temp ,$video);
                }
                $result['news'][$i] = $temp;
            }


        }
     //print_r($result);exit(); 
    // exit();
    return $result;
}
    
}
?>