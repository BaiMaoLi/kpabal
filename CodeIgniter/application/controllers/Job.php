<?php
	class job extends CI_Controller
	{
	    private $base_url="http://kpabal.com/CodeIgniter/job/";
	    public function index()
		{
		    $this->load->database();
		    $this->db->select("*");
		    $this->db->from("kpabalco_jobs");
		    $data['careers_occupation1']=0;
		    $data['careers_occupation2']=0;
		    $data['careers_type']=0;
		    $data['company_location']=0;
		    $data['keyword']="";
		    if($this->input->post('careers_occupation2')>0){
		        $this->db->where("subcat",$this->input->post('careers_occupation2'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		        $data['careers_occupation2']=$this->input->post('careers_occupation2');
		    }else if($this->input->post('careers_occupation1')>0){
		        $this->db->where("category",$this->input->post('careers_occupation1'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		    }
		    if($this->input->post('careers_type')>0){
		        $this->db->where("careers_type",$this->input->post('careers_type'));
		        $data['careers_type']=$this->input->post('careers_type');
		    }
		    if($this->input->post('company_location')>0){
		        $this->db->where("company_location",$this->input->post('company_location'));
		        $data['company_location']=$this->input->post('company_location');
		    }
		    if($this->input->post('keyword')!=""){
		        $this->db->where("title like '%".$this->input->post('keyword')."%'");
		        $data['keyword']=$this->input->post('keyword');
		    }
		    $res=$this->db->get();
		    if($this->db->count_all_results()>0){
    		    $data['p_cats']=$this->get_cat(0);
    		    if($data['careers_occupation1']>1){
                    $data['s_cats']=$this->get_cat($data['careers_occupation1']);
    		    }else{
    		        $data['s_cats']=$this->get_cat(1);
    		    }
                
                $data['j_types']=$this->get_type();
                $data['locations']=$this->get_locations();
                $search=$res->result_array();
                $result=array();
                foreach($search as $sch){
                    $loc_id=$sch['company_location'];
                    $sch['company_location']=$this->get_location_name($loc_id);
                    array_push($result,$sch);
                }
                $data['data']=$result;
                //$data['data']=$res->result_array();
    			$this->load->view('jobs',$data);
		    }
		}
		public function details()
		{
		    if($this->input->get('id')>0){
    		    $this->load->database();
    		    $id=$this->input->get('id');
    		    $this->db->select("*");
    		    $this->db->from("kpabalco_jobs");
    		    $this->db->where("id",$id);
    		    $res=$this->db->get();
    		    if($this->db->count_all_results()>0){
                    $search=$res->result_array();
                    $result=array();
                    foreach($search as $sch){
                        $loc_id=$sch['company_location'];
                        $sch['company_location']=$this->get_location_name($loc_id);
                        $sch['careers_type']=$this->get_type_name($sch['careers_type'])[0]['name'];
                        if($sch['category']>0){
                            $cat=$this->get_cat_name($sch['category']);
                            $sch['category']=$cat[0]['name'];
                        }
                        if($sch['subcat']>0){
                            $cat=$this->get_cat_name($sch['subcat']);
                            $sch['category'].=" -> ".$cat[0]['name'];
                        }
                        
                        array_push($result,$sch);
                    }
                    $data['data']=$result;
                    $this->db->set("lookup",$data['data'][0]["lookup"]+1);
    		        $this->db->where("id",$id);
    		        $this->db->update("kpabalco_jobs");
    		        
        			$this->load->view('job_details',$data);
    		    }
		    }
		}
		public function post()
		{
		    $this->load->database();
		    $data['p_cats']=$this->get_cat(0);
            $data['s_cats']=$this->get_cat(1);
            $data['j_types']=$this->get_type();
            $data['locations']=$this->get_locations();
			$this->load->view('job_post',$data);
		}
		public function update()
		{
		    $this->load->database();
		    $data['p_cats']=$this->get_cat(0);
            $data['j_types']=$this->get_type();
            $data['locations']=$this->get_locations();
            
    		$id=$this->input->get('id');
    		if($id>0){
    		    $this->db->select("*");
    		    $this->db->from("kpabalco_jobs");
    		    $this->db->where("id",$id);
    		    $res=$this->db->get();
    		    $data['data']=$res->result_array();
                $data['s_cats']=$this->get_cat($data['data'][0]['category']);
    		}
			$this->load->view('job_update',$data);
		}
		public function post_insert(){
		    $this->load->database();
		    
		    $date=date('Y-m-d H:i:s');
            $this->db->set('title', $this->input->post('title'));
            $this->db->set('content', $this->input->post('content'));
            $this->db->set('category', $this->input->post('careers_occupation1'));
            $this->db->set('subcat', $this->input->post('careers_occupation2'));
            $this->db->set('company_name', $this->input->post('company_name'));
            $this->db->set('company_business', $this->input->post('company_business'));
            $this->db->set('company_location', $this->input->post('company_location'));
            $this->db->set('company_address', $this->input->post('company_address'));
            $this->db->set('company_Traffic', $this->input->post('company_Traffic'));
            $this->db->set('company_homepage', $this->input->post('company_homepage'));
            $this->db->set('company_phone', $this->input->post('company_phone'));
            $this->db->set('careers_responsibilities', $this->input->post('careers_responsibilities'));
            $this->db->set('careers_qualifications', $this->input->post('careers_qualifications'));
            $this->db->set('careers_salary', $this->input->post('careers_salary'));
            $this->db->set('careers_type', $this->input->post('careers_type'));
            $this->db->set('careers_time', $this->input->post('careers_time'));
            $this->db->set('careers_weekly', $this->input->post('careers_weekly'));
            $this->db->set('careers_charge', $this->input->post('careers_charge'));
            $this->db->set('careers_method', $this->input->post('careers_method'));
            $this->db->set('careers_end', $this->input->post('careers_end'));
            $this->db->set('careers_etc', $this->input->post('careers_etc'));
            $this->db->set('post_date', $date);
            $this->db->set('author', "0");
    
            $res = $this->db->insert('kpabalco_jobs');
    		$this->redirect("");
		}
		public function post_update(){
		    $this->load->database();
		    $id=$this->input->post('id');
    		if($id>0){
    		    $date=date('Y-m-d H:i:s');
                $this->db->set('title', $this->input->post('title'));
                $this->db->set('content', $this->input->post('content'));
                $this->db->set('category', $this->input->post('careers_occupation1'));
                $this->db->set('subcat', $this->input->post('careers_occupation2'));
                $this->db->set('company_name', $this->input->post('company_name'));
                $this->db->set('company_business', $this->input->post('company_business'));
                $this->db->set('company_location', $this->input->post('company_location'));
                $this->db->set('company_address', $this->input->post('company_address'));
                $this->db->set('company_Traffic', $this->input->post('company_Traffic'));
                $this->db->set('company_homepage', $this->input->post('company_homepage'));
                $this->db->set('company_phone', $this->input->post('company_phone'));
                $this->db->set('careers_responsibilities', $this->input->post('careers_responsibilities'));
                $this->db->set('careers_qualifications', $this->input->post('careers_qualifications'));
                $this->db->set('careers_salary', $this->input->post('careers_salary'));
                $this->db->set('careers_type', $this->input->post('careers_type'));
                $this->db->set('careers_time', $this->input->post('careers_time'));
                $this->db->set('careers_weekly', $this->input->post('careers_weekly'));
                $this->db->set('careers_charge', $this->input->post('careers_charge'));
                $this->db->set('careers_method', $this->input->post('careers_method'));
                $this->db->set('careers_end', $this->input->post('careers_end'));
                $this->db->set('careers_etc', $this->input->post('careers_etc'));
                $this->db->set('post_date', $date);
                $this->db->set('author', "0");
                $this->db->where('id',$id);
                $res = $this->db->update('kpabalco_jobs');
    		}
    		$this->redirect("update?id=".$id);
		}
		public function ajax_cat(){
		    $id=$this->input->post("id");
		    $html='';
		    $cats=$this->get_cat($id);
		    foreach($cats as $cat){
		        $html.='<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
		    }
		    echo $html;
		}
		function get_cat($id){
		    $this->load->database();
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_cat");
		    $this->db->where("parent",$id);
		    $res=$this->db->get();
            return $res->result_array();
		}
		function get_type(){
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_type");
		    $res=$this->db->get();
            return $res->result_array();
		}
		function get_type_name($id){
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_type");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
            return $res->result_array();
		}
		function get_locations(){
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_locations");
		    $res=$this->db->get();
            return $res->result_array();
		}
		function get_location_name($id){
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_locations");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
            $result=$res->result_array();
            return $result[0]['name'];
		}
		function get_cat_name($id){
		    $this->load->database();
		    $this->db->select("*");
		    $this->db->from("kpabalco_job_cat");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
            return $res->result_array();
		}
		function redirect($url){
            $this->load->helper('url'); 
            redirect($this->base_url.$url);
		}
	}
?>