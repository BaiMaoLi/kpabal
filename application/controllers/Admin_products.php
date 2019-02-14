<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_products extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('product_model');
	}
	
    public function __generate_header_data($open_title = "Management")
    {
        $header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
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
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("products_category");
        $data['products'] = $this->product_model->product_get_items_admin();
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/product/index_js");
	}

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['product'] = $this->product_model->get_item($id);
        $data['categories'] = $this->category_model->get_tree_rows("products_category");
	
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/product/edit_index_js", $data);
    }
	
	public function update_product(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			$target_dir_gallary = FCPATH."assets/uploadedproduct/product_gallary/";
			$target_dir = FCPATH."assets/uploadedproduct/";
			$target_file = $target_dir . basename($_FILES["product_image_url"]["name"]);
			$save_path = "assets/uploadedproduct/";
			$final_path = $save_path . basename($_FILES["product_image_url"]["name"]);
			$save_path_gallary = "assets/uploadedproduct/product_gallary/";
			
			if (move_uploaded_file($_FILES["product_image_url"]["tmp_name"], $target_file)){
			
				$_POST['product_image_url'] = $final_path;
			}
			
			
			$have = $_FILES['userfile']['size'][0];
				if($have > 0){				
				
				$name_array = array();
				$count = count($_FILES['userfile']['size']);
				
				
				foreach($_FILES as $key=>$value)
					for($s=0; $s<=$count-1; $s++) {
						$_FILES['userfile']['name']= $value['name'][$s];
						$_FILES['userfile']['type']    = $value['type'][$s];
						$_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
						$_FILES['userfile']['error']       = $value['error'][$s];
						$_FILES['userfile']['size']    = $value['size'][$s];   
							$config['upload_path'] = $target_dir_gallary;
							$config['allowed_types'] = 'gif|jpg|png';
							$config['max_size']	= '100000';
							$config['max_width']  = '4050';
							$config['max_height']  = '4050';
						$this->load->library('upload', $config);
						$this->upload->do_upload();
						$data = $this->upload->data();						
						
						if(!empty($data['file_name'])){
							$name_array[] = $save_path_gallary.$data['file_name'];
						}
						
					}															
					$names= implode(',', $name_array);
					$_POST['product_gallary_image'] = $names;				
					
				}
			
			
			
			
            $true = $this->product_model->update_product($_POST);
			
			if($true){
				redirect(ADMIN_PUBLIC_DIR."/products");
			}
        }
		
		
	}
	

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->product_model->save_data($_POST);
        }        
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
	
	public function approved_prod(){
		
		$product_id = $this->uri->segment(4);
		$true = $this->product_model->approved_product($product_id);
		if($true){
			redirect(ADMIN_PUBLIC_DIR."/products");
		}
	}
	
	public function disapproved_prod(){
		
		$product_id = $this->uri->segment(4);
		$true = $this->product_model->disapproved_product($product_id);
		if($true){
			redirect(ADMIN_PUBLIC_DIR."/products");
		}
	}
	
	public function delete_prod(){
		
		$product_id = $this->uri->segment(4);
		$true = $this->product_model->delte_product($product_id);
		if($true){
			redirect(ADMIN_PUBLIC_DIR."/products");
		}
	}
	
	
	public function edit_product(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

		$product_id = $this->uri->segment(4);	
					       
        $data['edit_product'] = $this->product_model->get_item_front($product_id);        
		$data['categories'] = $this->category_model->get_tree_rows("products_category");
		$data['get_product_city'] = $this->product_model->get_product_city();     	
		$data['get_product_country'] = $this->product_model->get_product_country();  
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/product/edit_index_js", $data);
	}
	
	
		public function add_city_country(){
			
						
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];		
			
			
		$data['get_product_city'] = $this->product_model->get_product_city();     	
		$data['get_product_country'] = $this->product_model->get_product_country();     	
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/add_city_country",$data);
        $this->load->view("admin/common/footer", $footer_data);
       
	}
	
	public function add_product_city(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
				
			$result  = $this->product_model->add_product_city($_POST);    
											
			if($result){
				redirect(ADMIN_PUBLIC_DIR."/products/add_city_country");
			}
			
		}
				
	}
	
	
	public function add_product_country(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
				
			$result  = $this->product_model->add_product_country($_POST);    
											
			if($result){
				redirect(ADMIN_PUBLIC_DIR."/products/add_city_country");
			}
			
		}
				
	}
	
	
	
	
	
	public function delete_prod_city(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
	
	$city_id = $this->uri->segment(4);
	$true = $this->product_model->delte_product_city($city_id);
		if($true){
			redirect(ADMIN_PUBLIC_DIR."/products/add_city_country");
		}
	
	}
	
	
	public function delete_prod_country(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
	
	$country_id = $this->uri->segment(4);
	$true = $this->product_model->delte_product_country($country_id);
		if($true){
			redirect(ADMIN_PUBLIC_DIR."/products/add_city_country");
		}
	
	}
	
	public function admin_upload_product(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		$header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];		
	   	$data['categories'] = $this->category_model->get_tree_rows("products_category");
		$data['get_product_city'] = $this->product_model->get_product_city();     	
		$data['get_product_country'] = $this->product_model->get_product_country();  
		$data['states'] = $this->category_model->get_tree_rows("address_state"); 
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/add_admin_product",$data);
        $this->load->view("admin/common/footer", $footer_data);
	
	
	}
	
	public function add_new_admin_product(){
					
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			$target_dir_gallary = FCPATH."assets/uploadedproduct/product_gallary/";
			$target_dir = FCPATH."assets/uploadedproduct/";
			$target_file = $target_dir . basename($_FILES["product_image_url"]["name"]);
			$save_path = "assets/uploadedproduct/";
			$final_path = $save_path . basename($_FILES["product_image_url"]["name"]);
			$save_path_gallary = "assets/uploadedproduct/product_gallary/";
			
			if (move_uploaded_file($_FILES["product_image_url"]["tmp_name"], $target_file)){
			
				$_POST['product_image_url'] = $final_path;
			}
			
			
				$have = $_FILES['userfile']['size'][0];
				if($have > 0){				
				
				$name_array = array();
				$count = count($_FILES['userfile']['size']);
				
				
				foreach($_FILES as $key=>$value)
					for($s=0; $s<=$count-1; $s++) {
						$_FILES['userfile']['name']= $value['name'][$s];
						$_FILES['userfile']['type']    = $value['type'][$s];
						$_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
						$_FILES['userfile']['error']       = $value['error'][$s];
						$_FILES['userfile']['size']    = $value['size'][$s];   
							$config['upload_path'] = $target_dir_gallary;
							$config['allowed_types'] = 'gif|jpg|png';
							$config['max_size']	= '100000';
							$config['max_width']  = '4050';
							$config['max_height']  = '4050';
						$this->load->library('upload', $config);
						$this->upload->do_upload();
						$data = $this->upload->data();						
						
						if(!empty($data['file_name'])){
							$name_array[] = $save_path_gallary.$data['file_name'];
						}
						
					}															
					$names= implode(',', $name_array);
					$_POST['product_gallary_image'] = $names;				
					
				}
			
			
            $true = $this->product_model->save_data_product($_POST);
			
			if($true){
				redirect(ADMIN_PUBLIC_DIR."/products");
			}
        }
		
		
		
		
		
		
		
	}
	
	

}
