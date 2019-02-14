<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_jobs extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('job_model');
	 $this->db2 = $this->load->database('main', TRUE);

	}
	
    public function __generate_header_data($open_title = "Management")
    {
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
    	$header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

	public function index($category = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		    $this->db2->select("*");
		    $this->db2->from("jobs");
		    $this->db2->order_by("id", "desc");
		    $data['careers_occupation1']=0;
		    $data['careers_occupation2']=0;
		    $data['careers_type']=0;
		    $data['company_location']=0;
		    $data['keyword']="";
		    if($this->input->post('careers_occupation2')>0){
		        $this->db2->where("subcat",$this->input->post('careers_occupation2'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		        $data['careers_occupation2']=$this->input->post('careers_occupation2');
		    }else if($this->input->post('careers_occupation1')>0){
		        $this->db2->where("category",$this->input->post('careers_occupation1'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		    }
		    if($this->input->post('careers_type')>0){
		        $this->db2->where("careers_type",$this->input->post('careers_type'));
		        $data['careers_type']=$this->input->post('careers_type');
		    }
		    if($this->input->post('company_location')>0){
		        $this->db2->where("company_location",$this->input->post('company_location'));
		        $data['company_location']=$this->input->post('company_location');
		    }
		    if($this->input->post('keyword')!=""){
		        $this->db2->where("title like '%".$this->input->post('keyword')."%'");
		        $data['keyword']=$this->input->post('keyword');
		    }
		    $res=$this->db2->get();
		    if($this->db2->count_all_results()>0){
    		    $data['p_cats']=$this->job_model->get_cat(0);
    		    if($data['careers_occupation1']>1){
                    $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
    		    }else{
    		        $data['s_cats']=$this->job_model->get_cat(1);
    		    }
                
                $data['j_types']=$this->job_model->get_type();
                $data['locations']=$this->job_model->get_locations();
                $search=$res->result_array();
                $result=array();
                foreach($search as $sch){
                    $loc_id=$sch['company_location'];
                    $sch['company_location']=$this->job_model->get_location_name($loc_id);
                    $sch['companyinfo']=$this->job_model->get_company_by_id($sch['company_id']);
                    array_push($result,$sch);
                }
                $data['data']=$result;
		    }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/jobs/js");
	}

	public function newbanner(){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
$data['error']="";
$data['edits']==array();
		if($this->input->post('title')!=null && $this->input->get('edit')==null){
			
			$config['upload_path']          = './banners/';
                $config['allowed_types']        = 'gif|jpg|png';
               $new_name = time();
               $config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                $data['error']="File upload error";        
                }
                else
                {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                     $file_name = base_url().'banners/'.$upload_data['file_name'];
					 $in=array(
					 'url'=>$file_name,
					 'title'=>$this->input->post('title')
					 );
					 $this->job_model->insertData('banners',$in);
					 redirect(base_url().'adminpanel/jobs/banners');   
                }
				
		}
		if($this->input->get('edit')!=null){
			$data['edits']=$this->job_model->getData('banners',array('id'=>$this->input->get('edit')));
			if($this->input->post('title')!=null){
			
			$config['upload_path']          = './banners/';
                $config['allowed_types']        = 'gif|jpg|png';
               $new_name = time();
               $config['file_name'] = $new_name;

                $this->load->library('upload', $config);
if ( $_FILES AND $_FILES['userfile']['name'] ) 
{
   

                if ( ! $this->upload->do_upload('userfile'))
                {
                $data['error']="File upload error";        
                }
                else
                {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                     $file_name = base_url().'banners/'.$upload_data['file_name'];
					 $in=array(
					 'url'=>$file_name,
					 'title'=>$this->input->post('title')
					 );
					 $this->job_model->updateData('banners',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Banner Updated';   
                }
}else{
	 $in=array(
					 'url'=>$this->input->post('url'),
					 'title'=>$this->input->post('title')
					 );
					 $this->job_model->updateData('banners',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Banner Updated';   
}
				
		}
		$data['edits']=$this->job_model->getData('banners',array('id'=>$this->input->get('edit')));
		}
		
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/newbanner", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	
	
	public function newworkwith(){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
$data['error']="";
$data['edits']==array();
		if($this->input->post('title')!=null && $this->input->get('edit')==null){
			
			$config['upload_path']          = './banners/';
                $config['allowed_types']        = 'gif|jpg|png';
               $new_name = time();
               $config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                $data['error']="File upload error";        
                }
                else
                {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                     $file_name = base_url().'banners/'.$upload_data['file_name'];
					 $in=array(
					 'img'=>$file_name,
					 'name'=>$this->input->post('title')
					 );
					 $this->job_model->insertData('workwith',$in);
					 redirect(base_url().'adminpanel/jobs/workwith');   
                }
				
		}
		if($this->input->get('edit')!=null){
			$data['edits']=$this->job_model->getData('workwith',array('id'=>$this->input->get('edit')));
			if($this->input->post('title')!=null){
			
			$config['upload_path']          = './banners/';
                $config['allowed_types']        = 'gif|jpg|png';
               $new_name = time();
               $config['file_name'] = $new_name;

                $this->load->library('upload', $config);
if ( $_FILES AND $_FILES['userfile']['name'] ) 
{
   

                if ( ! $this->upload->do_upload('userfile'))
                {
                $data['error']="File upload error";        
                }
                else
                {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                     $file_name = base_url().'banners/'.$upload_data['file_name'];
					 $in=array(
					 'img'=>$file_name,
					 'name'=>$this->input->post('title')
					 );
					 $this->job_model->updateData('workwith',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Company Updated';   
                }
}else{
	 $in=array(
					 'img'=>$this->input->post('url'),
					 'name'=>$this->input->post('title')
					 );
					 $this->job_model->updateData('workwith',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Company Updated';   
}
				
		}
		$data['edits']=$this->job_model->getData('workwith',array('id'=>$this->input->get('edit')));
		}
		
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/newworkwith", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	
	
	public function workwith(){
	if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
if($this->input->get('del')!=null){
	$this->job_model->deleteData('workwith',array('id'=>$this->input->get('del')));
}
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		$data['workwith']=$this->job_model->getData('workwith',array());
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/workwith", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
	}
	
	public function banners(){
	if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
if($this->input->get('del')!=null){
	$this->job_model->deleteData('banners',array('id'=>$this->input->get('del')));
}
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		$data['banners']=$this->job_model->getData('banners',array());
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/banners", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
	}
	public function post()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/post", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
    
    public function upload_avatar($id = 0)
    {

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_PRODUCT_DIR."/product_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id."_1.jpg");
        }
    }

	public function post_insert(){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $data=$this->input->post();
	    if($_FILES["company_logo"]["name"]!=""){
            $target_dir = 'assets/company_logos/';
            $filename=basename($_FILES["company_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
	    }
        $this->job_model->edit_job($data);
		redirect(ADMIN_PUBLIC_DIR."/jobs/");
	}
	public function delete_job($id = 0){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db2->where('id', $id);
        $this->db2->delete('jobs');
	    redirect(ADMIN_PUBLIC_DIR."/jobs/");
	}
	public function edit($id=0)
	{
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
            
            
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        
		//$id=$this->input->get('id');
		if($id>0){
		    $this->db2->select("*");
		    $this->db2->from("jobs");
		    $this->db2->where("id",$id);
		    $res=$this->db2->get();
		    $data['data']=$res->result_array();
			$data['companyinfo']=$this->job_model->get_company_by_id($data['data'][0]['company_id']);
            $data['s_cats']=$this->job_model->get_cat($data['data'][0]['category']);
		}
		//$this->load->view('job_update',$data);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	
	public function post_update(){
        $data=$this->input->post();
        if($_FILES["company_logo"]["name"]!=""){
            $target_dir = 'assets/company_logos/';
            $filename=basename($_FILES["company_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->job_model->edit_job($data);
	    redirect(ADMIN_PUBLIC_DIR."/jobs/");
	}
	public function person()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/person";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	        $this->db2->select("*");
		    $this->db2->from("job_persons");
		    $this->db2->order_by("id", "desc");
		    $data['careers_occupation1']=0;
		    $data['careers_occupation2']=0;
		    $data['careers_type']=0;
		    $data['company_location']=0;
		    $data['keyword']="";
		    if($this->input->post('careers_occupation2')>0){
		        $this->db2->where("subcat",$this->input->post('careers_occupation2'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		        $data['careers_occupation2']=$this->input->post('careers_occupation2');
		    }else if($this->input->post('careers_occupation1')>0){
		        $this->db2->where("category",$this->input->post('careers_occupation1'));
		        $data['careers_occupation1']=$this->input->post('careers_occupation1');
		    }
		    if($this->input->post('careers_type')>0){
		        $this->db2->where("careers_type",$this->input->post('careers_type'));
		        $data['careers_type']=$this->input->post('careers_type');
		    }
		    if($this->input->post('company_location')>0){
		        $this->db2->where("company_location",$this->input->post('company_location'));
		        $data['company_location']=$this->input->post('company_location');
		    }
		    if($this->input->post('keyword')!=""){
		        $this->db2->where("title like '%".$this->input->post('keyword')."%'");
		        $data['keyword']=$this->input->post('keyword');
		    }
		    $res=$this->db2->get();
		    if($this->db2->count_all_results()>0){
    		    $data['p_cats']=$this->job_model->get_cat(0);
    		    if($data['careers_occupation1']>1){
                    $data['s_cats']=$this->job_model->get_cat($data['careers_occupation1']);
    		    }else{
    		        $data['s_cats']=$this->job_model->get_cat(1);
    		    }
                
                $data['j_types']=$this->job_model->get_type();
                $data['locations']=$this->job_model->get_locations();
                $search=$res->result_array();
                $result=array();
                foreach($search as $sch){
                    $loc_id=$sch['company_location'];
                    $sch['company_location']=$this->job_model->get_location_name($loc_id);
                    $cat=$this->job_model->get_cat_name($sch['category']);
                    $scat=$this->job_model->get_cat_name($sch['subcat']);
                    $sch['category']=$cat[0]['name'];
                    $sch['subcat']=$scat[0]['name'];
                    $sch['careers_type']=$this->job_model->get_type_name($sch['careers_type'])[0]['name'];
                    array_push($result,$sch);
                }
                $data['data']=$result;
		    }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/person", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/jobs/js");
	}
	public function post_person()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/person";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['s_cats']=$this->job_model->get_cat(1);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/post_person", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	
	public function person_insert(){
	    $data=$this->input->post();
        $this->job_model->edit_person($data);
		redirect(ADMIN_PUBLIC_DIR."/jobs/person");
	}
		
	public function delete_person($id = 0){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db2->where('id', $id);
        $this->db2->delete('job_persons');
	    redirect(ADMIN_PUBLIC_DIR."/jobs/person");
	}
	public function edit_person($id=0)
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/person";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        
		//$id=$this->input->get('id');
		if($id>0){
		    $this->db2->select("*");
		    $this->db2->from("job_persons");
		    $this->db2->where("id",$id);
		    $res=$this->db2->get();
		    $data['data']=$res->result_array();
            $data['s_cats']=$this->job_model->get_cat($data['data'][0]['category']);
		}
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit_person", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
    public function update_person(){

        $data=$this->input->post();
        $this->job_model->edit_person($data);
    	redirect(ADMIN_PUBLIC_DIR."/jobs/person");
    }
	public function location()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/location";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $data['locations']=$this->job_model->get_locations();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/location", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/jobs/js");
	}
	public function delete_location($id = 0){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db2->where('id', $id);
        $this->db2->delete('job_locations');
	    redirect(ADMIN_PUBLIC_DIR."/jobs/location");
	}
	public function post_location()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/person";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/post_location", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	public function location_insert(){
        $this->db2->set('name', $this->input->post('name'));
        $res = $this->db2->insert('job_locations');
		redirect(ADMIN_PUBLIC_DIR."/jobs/location");
	}	
	public function edit_location($id=0)
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/person";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	    $data['p_cats']=$this->job_model->get_cat(0);
        $data['j_types']=$this->job_model->get_type();
        $data['locations']=$this->job_model->get_locations();
        
		//$id=$this->input->get('id');
		if($id>0){
		    $this->db2->select("*");
		    $this->db2->from("job_locations");
		    $this->db2->where("id",$id);
		    $res=$this->db2->get();
		    $data['data']=$res->result_array();
		}
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit_location", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}    
	public function update_location(){
        $id=$this->input->post('id');
    	if($id>0){
            $this->db2->set('name', $this->input->post('name'));
            $this->db2->where('id',$id);
            $res = $this->db2->update('job_locations');
    	}
    	redirect(ADMIN_PUBLIC_DIR."/jobs/location");
    }
	public function category()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/category";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $data['p_cats']=$this->job_model->get_cat(0);
        foreach($data['p_cats'] as $s_cat){
            $data['s_cats'][$s_cat['id']]=$this->job_model->get_cat($s_cat['id']);
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/category", $data);
        $this->load->view("admin/common/footer", $footer_data);
        //$this->load->view("admin/jobs/js");
	}
	public function post_category()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/category";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $data['p_cats']=$this->job_model->get_cat(0);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/post_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	public function category_insert(){
        $this->db2->set('name', $this->input->post('name'));
        $this->db2->set('parent', $this->input->post('parent'));
        $res = $this->db2->insert('job_cat');
		redirect(ADMIN_PUBLIC_DIR."/jobs/category");
	}
	public function edit_category($id=0)
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs/category";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	    $data['p_cats']=$this->job_model->get_cat(0);
        
		//$id=$this->input->get('id');
		if($id>0){
		    $this->db2->select("*");
		    $this->db2->from("job_cat");
		    $this->db2->where("id",$id);
		    $res=$this->db2->get();
		    $data['data']=$res->result_array();
		}
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
	} 
	public function update_category(){
        $id=$this->input->post('id');
    	if($id>0){
            $this->db2->set('name', $this->input->post('name'));
            $this->db2->set('parent', $this->input->post('parent'));
            $this->db2->where('id',$id);
            $res = $this->db2->update('job_cat');
    	}
    	redirect(ADMIN_PUBLIC_DIR."/jobs/category");
    }  
    public function delete_category($id = 0){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db2->where('id', $id);
        $this->db2->delete('job_cat');
	    redirect(ADMIN_PUBLIC_DIR."/jobs/category");
	} 
	public function ajax_cat(){
	    $id=$this->input->post("id");
	    $html='';
	    $cats=$this->job_model->get_cat($id);
	    foreach($cats as $cat){
	        $html.='<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
	    }
	    echo $html;
	}
		
}
