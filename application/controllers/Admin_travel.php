<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_travel extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('job_model');
        $this->load->model('travel_model');
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

	public function testimonials($category = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		if($this->input->get('del')!=null){
			$this->job_model->deleteData('tbl_travel_testimonials',array('id'=>$this->input->get('del')));
		}

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/jobs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		    $data['allt']=$this->job_model->getData('tbl_travel_testimonials',array());
			
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/all", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/jobs/js");
	}
	public function hotels(){
	if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
if($this->input->get('del')!=null){
	$this->travel_model->deleteData('hotels',array('id'=>$this->input->get('del')));
}
if($this->input->get('hot')!=null){
	$this->travel_model->updateData('hotels',array('id'=>$this->input->get('hot')),array('hot'=>1));
}
if($this->input->get('nohot')!=null){
	$this->travel_model->updateData('hotels',array('id'=>$this->input->get('nohot')),array('hot'=>0));
}
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		$data['banners']=$this->travel_model->getData('hotels',array());
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/hotels", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
	}
	public function newhotel(){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
$data['error']="";
$data['edits']=array();
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
					 'image'=>$file_name,
					 'title'=>$this->input->post('title'),
					 'des'=>$this->input->post('des'),
					 'address'=>$this->input->post('address'),
					 'city'=>$this->input->post('city'),
					 'price'=>$this->input->post('state'),
					 'state'=>$this->input->post('price'),
					 'country'=>$this->input->post('country'),					 
					 'url'=>$this->input->post('hurl'),					 
					 );
					 $this->travel_model->insertData('hotels',$in);
					 redirect(base_url().'adminpanel/travel/hotels');   
                }
				
		}
		if($this->input->get('edit')!=null){
			$data['edits']=$this->travel_model->getData('hotels',array('id'=>$this->input->get('edit')));
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
					 'image'=>$file_name,
					 'title'=>$this->input->post('title'),
					 'des'=>$this->input->post('des'),
					 'address'=>$this->input->post('address'),
					 'city'=>$this->input->post('city'),
					 'price'=>$this->input->post('price'),
					 'state'=>$this->input->post('state'),
					 'country'=>$this->input->post('country'),	
					 'url'=>$this->input->post('hurl'),	
					 );
					 $this->travel_model->updateData('hotels',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Hotel Updated';   
                }
}else{
	 $in=array(
					 'image'=>$this->input->post('url'),					 
					 'title'=>$this->input->post('title'),
					 'des'=>$this->input->post('des'),
					 'address'=>$this->input->post('address'),
					 'city'=>$this->input->post('city'),
					 'price'=>$this->input->post('price'),
					 'state'=>$this->input->post('state'),
					 'country'=>$this->input->post('country'),	
					 'url'=>$this->input->post('hurl'),	
					 );
					 $this->travel_model->updateData('hotels',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Hotel Updated';   
}
				
		}
		$data['edits']=$this->travel_model->getData('hotels',array('id'=>$this->input->get('edit')));
		}
		
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/newhotel", $data);
        $this->load->view("admin/common/footer", $footer_data);
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
					 $this->job_model->insertData('banners_travel',$in);
					 redirect(base_url().'adminpanel/travel/banners');   
                }
				
		}
		if($this->input->get('edit')!=null){
			$data['edits']=$this->job_model->getData('banners_travel',array('id'=>$this->input->get('edit')));
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
					 $this->job_model->updateData('banners_travel',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Banner Updated';   
                }
}else{
	 $in=array(
					 'url'=>$this->input->post('url'),
					 'title'=>$this->input->post('title')
					 );
					 $this->job_model->updateData('banners_travel',array('id'=>$this->input->get('edit')),$in);
					 $data['error']='Banner Updated';   
}
				
		}
		$data['edits']=$this->job_model->getData('banners_travel',array('id'=>$this->input->get('edit')));
		}
		
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/newbanner", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	public function banners(){
	if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
if($this->input->get('del')!=null){
	$this->job_model->deleteData('banners_travel',array('id'=>$this->input->get('del')));
}
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		$data['banners']=$this->job_model->getData('banners_travel',array());
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/banners", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
	}
	public function newtestimonials()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		$data['msg']='';
		$data['users']=array();
		if($this->input->get('edit')!=null){
			if($this->input->post('uname')!=null){
	$new_name = time().$_FILES["userfile"]['name'];
           $config['file_name'] = $new_name;
	 $config['upload_path']          = './files/test/';
                $config['allowed_types']        = 'jpg|png';
               

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                  $in=array(
						'name'=>$this->input->post('uname'),
						'city'=>$this->input->post('city'),
						'date_test'=>$this->input->post('date'),
						'text'=>$this->input->post('text')
						);
						$this->job_model->updateData('tbl_travel_testimonials',array('id'=>$this->input->get('edit')),$in);
						$data['msg']='Testimonial Updated';      
                }
                else
                {
                        $d = array('upload_data' => $this->upload->data());
						$in=array(
						'name'=>$this->input->post('uname'),
						'city'=>$this->input->post('city'),
						'date_test'=>$this->input->post('date'),
						'text'=>$this->input->post('text'),
						'photo'=>'files/test/'.$new_name
						);
						$this->job_model->updateData('tbl_travel_testimonials',array('id'=>$this->input->get('edit')),$in);
						$data['msg']='Testimonial Updated';

                        
                }
				
}

			$data['users']=$this->job_model->getData('tbl_travel_testimonials',array('id'=>$this->input->get('edit')));
		}
if($this->input->post('uname')!=null && $this->input->get('edit')==null){
	$new_name = time().$_FILES["userfile"]['name'];
           $config['file_name'] = $new_name;
	 $config['upload_path']          = './files/test/';
                $config['allowed_types']        = 'jpg|png';
               

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                  $data['msg']='Failed';      
                }
                else
                {
                        $d = array('upload_data' => $this->upload->data());
						$in=array(
						'name'=>$this->input->post('uname'),
						'city'=>$this->input->post('city'),
						'date_test'=>$this->input->post('date'),
						'text'=>$this->input->post('text'),
						'photo'=>'files/test/'.$new_name
						);
						$this->job_model->insertData('tbl_travel_testimonials',$in);
						$data['msg']='Testimonial Added';

                        
                }
				
}
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/travel/new", $data);
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
        $this->db->where('id', $id);
        $this->db->delete('jobs');
	    redirect(ADMIN_PUBLIC_DIR."/jobs/");
	}
	public function edit($id=0)
	{
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/travel";
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
		    $this->db->select("*");
		    $this->db->from("jobs");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
		    $data['data']=$res->result_array();
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
	        $this->db->select("*");
		    $this->db->from("job_persons");
		    $this->db->order_by("id", "desc");
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
        $this->db->where('id', $id);
        $this->db->delete('job_persons');
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
		    $this->db->select("*");
		    $this->db->from("job_persons");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
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
        $this->db->where('id', $id);
        $this->db->delete('job_locations');
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
        $this->db->set('name', $this->input->post('name'));
        $res = $this->db->insert('job_locations');
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
		    $this->db->select("*");
		    $this->db->from("job_locations");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
		    $data['data']=$res->result_array();
		}
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit_location", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}    
	public function update_location(){
        $id=$this->input->post('id');
    	if($id>0){
            $this->db->set('name', $this->input->post('name'));
            $this->db->where('id',$id);
            $res = $this->db->update('job_locations');
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
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('parent', $this->input->post('parent'));
        $res = $this->db->insert('job_cat');
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
		    $this->db->select("*");
		    $this->db->from("job_cat");
		    $this->db->where("id",$id);
		    $res=$this->db->get();
		    $data['data']=$res->result_array();
		}
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/jobs/edit_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
	} 
	public function update_category(){
        $id=$this->input->post('id');
    	if($id>0){
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('parent', $this->input->post('parent'));
            $this->db->where('id',$id);
            $res = $this->db->update('job_cat');
    	}
    	redirect(ADMIN_PUBLIC_DIR."/jobs/category");
    }  
    public function delete_category($id = 0){
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db->where('id', $id);
        $this->db->delete('job_cat');
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
