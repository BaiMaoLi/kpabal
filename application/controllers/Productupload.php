<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productupload extends CI_Controller {
	
	
	function __construct() {

		parent::__construct();

		$this->load->helper(array('form', 'url', 'userfunc'));

        $this->load->library('form_validation');
		
		$this->load->library('session');

		$this->load->model('login_model');

		$this->load->model('member_model');

		$this->load->model('basis_model');

		$this->load->model('board_model');

		$this->load->model('category_model');

		$this->load->model('business_model');

		$this->load->model('product_model');

		// $this->load->model('savings_model');
		
		
		

    }
	
	
	public function index($id = 0){
				
		
		$data['id'] = $id;
        $data['product'] = $this->product_model->get_item($id);
        $data['categories'] = $this->category_model->get_tree_rows("products_category");
		$header_data = $this->__generate_header_data("Product Upload");
		$footer_data = $this->__generate_footer_data();
				
		$this->load->view('kpabal/common/header',$header_data);
      	$this->load->view('kpabal/productupload/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
		
	}
	
	
	
	public function get_data(){
				
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			$target_dir = FCPATH."assets/uploadedproduct/";
			$target_file = $target_dir . basename($_FILES["product_image_url"]["name"]);
			$save_path = "assets/uploadedproduct/";
			$final_path = $save_path . basename($_FILES["product_image_url"]["name"]);
				
			if (move_uploaded_file($_FILES["product_image_url"]["tmp_name"], $target_file)){
			
				$_POST['product_image_url'] = $final_path;
			}	
			
				
				if($this->product_model->save_data_product($_POST)){
						
					$this->session->set_flashdata('response',"Product Upload Successfully");
					redirect('Productupload');
										
				}else{
					
					$this->session->set_flashdata('response',"Product Upload Failed");
					redirect('Productupload');
				}
			}  
		
	}
	
	
	
	
	
	
	
		public function product_details(){
			
			$product_id = $this->uri->segment(3);
					
			$data['product_details'] = $this->product_model->get_item_uploaded($product_id);
			$this->load->view('kpabal/common/header',$header_data);
			$this->load->view('kpabal/productupload/product_details',$data);
			$this->load->view('kpabal/common/footer',$footer_data);
			
			
			
		}	
	
	
	
	
	
	 public function __generate_header_data($caption = "") {
		$header_data = [];

		$header_data['loggedinuser'] = __get_user_session();
		$header_data['caption'] = $caption;
		$header_data['categories'] = $this->category_model->get_tree_rows_with_parent("site_menu", "01", true);
		$header_data['news_categories'] = $this->category_model->get_tree_rows("news_category", true);
		$header_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
		$header_data['notices'] = $this->basis_model->get_rows_total("site_notice", "", "page_date desc", 0, 5);

		$header_data['keywords'] = ["KPABAL", "Business Listing", "Market"];

		return $header_data;
	}

	public function __generate_footer_data() {
		$footer_data = [];
		$footer_data['categories'] = $this->category_model->get_tree_rows_with_parent("site_menu", "01", true);
		$footer_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
		$footer_data['recent_business'] = $this->business_model->recent_business();
		$footer_data['total_business'] = $this->business_model->total_count();
		$footer_data['total_client'] = $footer_data['total_business'] + $this->member_model->total_count();
		$footer_data['footers'] = $this->category_model->get_tree_rows_with_parent("site_menu", "02", true);

		return $footer_data;
	}
	
	
	
	
	}