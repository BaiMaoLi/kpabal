<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {
	
	
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
		
		$this->load->model('restaurant_model');

		// $this->load->model('savings_model');
		
		
		

    }
	
	
	public function index($id = 0){
						
		
		$header_data = $this->__generate_header_data("Restaurant");
		$footer_data = $this->__generate_footer_data();
		

		$data['list_restaurant'] = $this->restaurant_model->get_restaurant();
		$data['list_ourblog'] = $this->restaurant_model->get_blogs();
		$data['list_addblock'] = $this->restaurant_model->get_restaurant_block_add();
		$data['slide_ranking'] = $this->restaurant_model->get_restaurant_slide();
		$data['get_relative_state'] = $this->restaurant_model->get_relative_state();

		
		$this->load->view('kpabal/common/header',$header_data);
      	$this->load->view('kpabal/restaurant/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
		
	}
						
	public function restaurant_details(){
		
		$restaurant_id = $this->uri->segment(3);
		$header_data = $this->__generate_header_data("Restaurant Details");
		$footer_data = $this->__generate_footer_data();
		$data['restaurant_details'] = $this->restaurant_model->get_restaurant_details($restaurant_id);
		$data['restaurant_reviews'] = $this->restaurant_model->get_restaurant_reviews($restaurant_id);
		$this->load->view('kpabal/common/header',$header_data);
		$this->load->view('kpabal/restaurant/restaurant_details',$data);
		$this->load->view('kpabal/common/footer',$footer_data);
		
	}	
	
	public function blogs_details(){
		
		$blog_id = $this->uri->segment(3);
		$header_data = $this->__generate_header_data("Blog Details");
		$footer_data = $this->__generate_footer_data();
		$data['blog_details'] = $this->restaurant_model->get_blog_details($blog_id);
		
		$this->load->view('kpabal/common/header',$header_data);
		$this->load->view('kpabal/ourblog/blog_details',$data);
		$this->load->view('kpabal/common/footer',$footer_data);
		
	}
	
	
	
	
	
	public function submit_review(){
				
		$result = $this->restaurant_model->save_reviews($_POST);
				
		if($result){
			
			redirect('Restaurant');
		
		}
		
	}	
	
	
	public function list_addblock(){
		
		$block_id = $this->uri->segment(3);
			
		$header_data = $this->__generate_header_data("Restaurant Details");
		$footer_data = $this->__generate_footer_data();
		$data['block_details'] = $this->restaurant_model->fetch_restro_by_state($block_id);
		
		$this->load->view('kpabal/common/header',$header_data);
		$this->load->view('kpabal/restaurant/restaurant_listing',$data);
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
	
	
	public function get_restro_by_state(){ 
	
		
				$result = $this->restaurant_model->fetch_restro_by_state($_POST['state_id']);
						
				//print_r($result);
			//exit();
			
						$CI =& get_instance();
						foreach($result as $list){
							$segments = array('Restaurant', 'restaurant_details',$list->id);
							?>
						
							<div class="ranking_block_2">
							<div class="ranking_block_2_img">
                              <a href="<?=site_url($segments); ?>"><img src="<?php echo site_url();
								$img_url = explode(',',$list->restaurant_images);
								echo $img_url[0];?>"/></a>
							</div>
							<div class="ranking_block_2_right">
                              <a href="<?=site_url($segments); ?>"><h5><?php echo $list->title;?></h5></a>
                              <p><i class="fa fa-map-marker"></i><?php echo $list->address;?></p>
                              <p><i class="fa fa-phone"></i><?php echo $list->restaurant_number;?></p>
							  
							  <?php 
							  
								$rating = $CI->restaurant_model->get_restaurant_rating($list->id);
							  
								foreach($rating as $rate){
								 
									$rate = round($rate->AverageRating);
								}
							  
								for($i=1; $i<=$rate;$i++){ 
								?>
							  
								<img src="<?php echo site_url();?>/assets/star/singlestart.jpg"/>
								<?php } ?>
								Reviews (<?php 
							 
								$review = $CI->restaurant_model->get_restaurant_reviews($list->id);
								echo count($review); ?>)
							  
							</div>
							</div>
							
							<?php }
	
	
	}
	
	
	public function get_ranking_restro_by_state(){ 
	
	
		$result = $this->restaurant_model->fetch_ranking_restro_by_state($_POST['state_id']);
						
		foreach ($result as $slide){ ?>
						   
                              <div class="item">
							  <div class="slider_img">
                                <a target="_blank" href="<?php echo $slide->url;?>"><img src="<?php echo site_url();?><?php echo $slide->image;?>"/></a>
							  </div> 
                                 <div class="slider_text">
                                    <span><?php echo $slide->title;?></span>
                                 </div>
                              </div>
							  
						   <?php } 
	
	
	}
	
	
	
	
	}