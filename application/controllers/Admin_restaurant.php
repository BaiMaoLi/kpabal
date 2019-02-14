<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_restaurant extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('restaurant_model');
	}
	
    public function __generate_header_data($open_title = "Restaurant")
    {
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
    	$header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

	public function index()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		$data['list_restaurant'] = $this->restaurant_model->get_restaurant();
		  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/index", $data);
		$this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/restaurant/js");
	}

	

	public function add(){
		
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		

		
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
		$data['get_food_type'] = $this->restaurant_model->get_food_types(); 
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/add", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
		
		
	}	
	

	public function edit(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
		$record_id = $this->uri->segment(4);
				
		$data['get_record'] = $this->restaurant_model->get_restaurant_block_record($record_id);
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/edit_restaurant_block.php", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	
	
	public function edit_slide(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
		$record_id = $this->uri->segment(4);
				
		$data['get_slide'] = $this->restaurant_model->get_ranking_slide_record($record_id);
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/edit_ranking_slider.php", $data);
        $this->load->view("admin/common/footer", $footer_data);
	}
	

	
	
	public function update_restro_block(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }						
				
		if (isset($_POST['update_restro'])) {
			
			$update_data = $this->input->post();	
						
			unset($update_data['update_restro']);
							
			$res = $this->restaurant_model->update_restaurant_block($update_data);
		
			if($res){
						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_list_block");
			
			}
				
		
		}
				
	}	
	

	
	public function post_insert(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
				
		
				
		if (isset($_POST['submit_rest'])) {

		$data=$this->input->post();	
		
		if(isset($data['is_favorite'])){
				$data['is_favorite'] = 1;
		}else{
			$data['is_favorite'] = 0;
		}
	
		$j = 0;     
		$target_path = FCPATH."assets/restaurant_image/";     
		$save_path = "assets/restaurant_image/";

		$image_name = array();
		for ($i = 0; $i < count($_FILES['restaurant_images']['name']); $i++) {
		
		$ext = explode('.', basename($_FILES['restaurant_images']['name'][$i]));   
		
		$file_extension = end($ext); 
		
		$str = str_shuffle("ms25uri");
		
		$target_path = $target_path .$str.'.'.$file_extension;    
		$j = $j + 1;      		
				
				
			if (move_uploaded_file($_FILES['restaurant_images']['tmp_name'][$i], $target_path)) {
				
				$dol = ltrim($target_path,"/home1/kpabalco/public_html/CI");
				
				$image_name[] = 'a'.$dol;
			} 
		
	}

		
	
		$data['restaurant_images'] = implode(',',$image_name);
	
		
	
		unset($data['submit_rest']);
	
		$res = $this->restaurant_model->save_restaurant($data);
		
		if($res){
						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/");
		}
	
	
}		
	}
	
	
	
	public function restaurant_add_block(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/add_block",$data);
        $this->load->view("admin/common/footer", $footer_data);
		
						
	}
	
	
	public function restaurant_list_block(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant/restaurant_add_block";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		$data['list_block_restaurant'] = $this->restaurant_model->get_restaurant_block_add();
		  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/restaurant_block_list", $data);
		$this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/restaurant/ad_block_list_js");
		
		
	}
	
	
	
	
	public function add_block_insert(){
		
			if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}
		
			$data=$this->input->post();
			
		
		
			$target_dir = FCPATH."assets/restaurant_add_block/";
			$target_file = $target_dir . basename($_FILES["add_block_res_image"]["name"]);
			$save_path = "assets/restaurant_add_block/";
			$final_path = $save_path . basename($_FILES["add_block_res_image"]["name"]);
				
			if (move_uploaded_file($_FILES["add_block_res_image"]["tmp_name"], $target_file)){
			
				$data['image'] = $final_path;
			}	
				
			// print_r($data);
			// exit;	
				
		
			$res = $this->restaurant_model->save_add_block($data);
		
			if($res){
						
				redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_list_block");
			}
		
		
	}
 
	  
	  
	  
	public function restaurant_ranking_slider_add(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}
		
			$data=$this->input->post();
				
				
		
			$target_dir = FCPATH."assets/restaurant_slide/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$save_path = "assets/restaurant_slide/";
			$final_path = $save_path . basename($_FILES["image"]["name"]);
				
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
			
				$data['image'] = $final_path;
			}	
				
			
		
			$res = $this->restaurant_model->save_slide($data);
		
			if($res){
						
				redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_ranking");
			}
		
		
	}  
	  
	  
	
	  
	  
	  
	public function restaurant_ranking(){
		
			
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant/restaurant_ranking";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		$data['list_slide_restaurant'] = $this->restaurant_model->get_restaurant_slide();
		  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/raking_slider",$data);
		$this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/restaurant/ranking_slider_js");		
		
	}  
	
	public function restaurant_slide_add(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant/restaurant_slide_add";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		

		$data['states'] = $this->category_model->get_tree_rows("address_state");  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/add_slide",$data);
        $this->load->view("admin/common/footer", $footer_data);
		
						
	}
	
	public function restaurant_reviews(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant/restaurant_slide_add";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
		
		$data['list_reviews'] = $this->restaurant_model->getReviews();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/review_list",$data);
        $this->load->view("admin/common/footer", $footer_data);
		
						
	}
	
	
	
	
	public function delete_restaurant(){ 
	
	
	$rest_id = $this->uri->segment(4);
	
	$res = $this->restaurant_model->delete_restro($rest_id);
	
	
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/restaurant/");
	}
	
	}
	
	
	public function review_delete(){ 	
	
	$review_id = $this->uri->segment(4);
	
	$res = $this->restaurant_model->delete_review($review_id);
	
	
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_reviews");
		exit;
	}
	
	}
	
	
	
	public function approved_review_status(){ 	
	
	$review_id = $this->uri->segment(4);
	
	$res = $this->restaurant_model->set_review_status($review_id);
	
	if($res){
		
		 redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_reviews");
	 }
		
	
	}
	
	
	
	
	public function edit_restaurant(){  
				
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
		
		$rest_id = $this->uri->segment(4);
				
		$data['get_restaurant'] = $this->restaurant_model->get_restaurantby_id($rest_id);
		$data['states'] = $this->category_model->get_tree_rows("address_state");  
		$data['get_food_type'] = $this->restaurant_model->get_food_types(); 
		
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/edit_restaurant.php", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
	
	}
	
	
	public function sidebar_banner(){			
	
		if (!$this->general->admin_controlpanel_logged_in()) {
			redirect(ADMIN_PUBLIC_DIR);
		}				
		
		$header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
		$data['get_banner'] = $this->restaurant_model->fetch_banner_info();  
		
		$this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/sidebar_banner", $data);
        $this->load->view("admin/common/footer", $footer_data);
		
		
	}
	
	
	
	
	
	
	
	
	public function delete_restro_block(){ 
	
	
	$rest_id = $this->uri->segment(4);
	
	$res = $this->restaurant_model->delete_restro_block($rest_id);
	
	
	if($res){
		
		 redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_list_block");
	 }
	
	}
	  
	 
	public function update_review(){ 
	
		if (!$this->general->admin_controlpanel_logged_in()) {
			redirect(ADMIN_PUBLIC_DIR);
		}
		
		$data=$this->input->post();
				
		$res = $this->restaurant_model->update_review($data);
		
		if($res){						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_reviews");
		}
	
		
	
	}
	 
	public function ranking_slider_delete(){  
	  
	$rank_slide_id = $this->uri->segment(4);
	
	$res = $this->restaurant_model->delete_ranking_slide($rank_slide_id);
	
	
	if($res){
		
		 redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_ranking");
	}
	  
	  
	} 


	public function update_restro_slide(){
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }						
				
		if (isset($_POST['update_slide'])) {
			
			$update_data = $this->input->post();	
						
			unset($update_data['update_slide']);
							
			$res = $this->restaurant_model->update_restaurant_slide($update_data);
		
			if($res){
						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_ranking");
			
			}
				
		
		}
				
	}

	
	
		public function update_resaurant(){
		
			if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}						
			
			if (isset($_POST['submit_rest'])) {
			
			
			$target_dir_gallary = FCPATH."assets/restaurant_image/";			
			$save_path_gallary = "assets/restaurant_image/";
			
			
			$update_data = $this->input->post();	
						
			
			if(isset($update_data['is_favorite'])){
				$update_data['is_favorite'] = 1;
			}else{
				$update_data['is_favorite'] = 0;
			}
						
					
			unset($update_data['submit_rest']);
			
				$count = $_FILES['userfile']['size'][0];
				
				if($count > 0){				
				
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
					$update_data['restaurant_images'] = $names;				
					
				}
			// echo "<pre>";
			// print_r($update_data);
			
			// exit;
			
			
							
			$res = $this->restaurant_model->update_restaurant($update_data);
		
			if($res){
						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/");
			
			}
				
		
		}
		
		}
	
 
		public function restaurant_foodtype() {
			
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/restaurant";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
								 
		$data['get_food_type'] = $this->restaurant_model->get_food_types(); 
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/restaurant/add_foodtype.php", $data);
        $this->load->view("admin/common/footer", $footer_data);

		}
		
		
		public function update_foodtype() { 
		
		
			if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}						
			
		
			
			$update_data = $this->input->post();										
			
					
			$res = $this->restaurant_model->update_restaurant_foodtype($update_data);
		
			if($res){
						
			redirect(ADMIN_PUBLIC_DIR."/restaurant/restaurant_foodtype");
			
			}
				
		
		
		
		
		}
		
		public function remove_food_type(){
			
			if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}		
			
			$food_type_id = $_POST['id'];
			
			$res = $this->restaurant_model->remove_restaurant_foodtype($food_type_id);
		
			if($res){
						
			echo "true";
			
			}
			
		}
		
		
		public function save_sidebarbanner(){
			
			if (!$this->general->admin_controlpanel_logged_in()) {
				redirect(ADMIN_PUBLIC_DIR);
			}			
			
			$target_dir = FCPATH."assets/restaurant_image/banner/";
			$target_file = $target_dir . basename($_FILES["banner_image"]["name"]);
			$save_path = "assets/restaurant_image/banner/";
			$final_path = $save_path . basename($_FILES["banner_image"]["name"]);
				
			if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)){
			
				$_POST['banner_image'] = $final_path;
				
			}


			if($this->restaurant_model->save_banner($_POST)){						
					
				redirect(ADMIN_PUBLIC_DIR."/restaurant/sidebar_banner/");
										
			}

			
		
		}
		
		
		
		


		
		
		
		
		
			
}
