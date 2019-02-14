<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markets extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('category_model');
        $this->load->model('product_model');
        $this->load->model('login_model');
		$this->load->model('member_model');
		$this->load->model('basis_model');
		$this->load->model('board_model');
		$this->load->model('business_model');
	}
	
	public function index()
	{
        $data['selected'] = 'market';
        $header_data = $this->__generate_header_data("Landing Page");
		$footer_data = $this->__generate_footer_data();
        //get category
		
		if(isset($_POST['search_product'])){
				$keyword = $this->input->post('keyword');
				$category = $this->input->post('category');
				$user_city = $this->input->post('user_city');
				$user_state = $this->input->post('user_state');
				$user_country = $this->input->post('user_country');
				
				$data['fetch_products'] = $this->product_model->fetch_items($category, $keyword, $user_city,$user_state,$user_country);
				
				
				// if(!empty($keyword)){
					// $data['fetch_products'] = $this->product_model->fetch_items($category, $keyword);
				// }elseif(!empty($category)){
					// $data['fetch_products'] = $this->product_model->fetch_items($category, $keyword);
					
				// }
								
				//$data['fetch_products'] = $this->product_model->fetch_items($category, $keyword);				
				//echo $this->product_model->fetch_items($category, $keyword);				
				
				//die();
				
										

								
		}
		
		
		
		
        //$category = $this->input->post('category');
       
	
        $data['loggedinuser'] = $header_data['loggedinuser'] = __get_user_session();
        $data['selected_cat'] = $category;
        $data['selected_key'] = $keyword;
        $data['categories'] = $this->category_model->get_tree_rows("products_category");
        $data['products'] = $this->product_model->get_items($this->category_model->list_data("products_category"), $category, $keyword);
        $data['uploadedproducts'] = $this->product_model->product_get_items();
		
		
        $data['notices'] = $header_data['notices'];
		$data['ranking_members'] = $this->member_model->get_ranking_members();
		$data['home_sliders'] = $this->basis_model->get_categories("site_contents", "01", true);
		$data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "02", true);
        $arr_categories = $this->category_model->list_data("board_category", true);
        //$data['articles'] = $this->board_model->get_suggest_articles($arr_categories, $this->member_model->list_data(), "");
        $data['best_articles'] = $this->board_model->get_prior_articles("view_count desc");
        $data['best_articles2'] = $this->board_model->get_prior_articles("reply_count desc");
        $data['side_articles1'] = $this->board_model->get_prior_articles("(good_count - bad_count) desc");
        $data['side_articles2'] = $this->board_model->get_prior_articles("article_date desc");
        $data['side_articles3'] = $this->board_model->get_prior_replies("reply_date desc");

        $news_categories = $header_data['news_categories'];
        foreach ($news_categories as $category) {
        	$category->news = $this->basis_model->get_rows_total("news", $category->categoryIdx, "article_date desc", 0, 5);
        }

        $data['news_categories'] = $news_categories;

        $business_categories = $this->category_model->get_tree_rows("business_category", true);
        foreach ($business_categories as $category) {
        	$category->news = $this->basis_model->get_rows_total("business", $category->categoryIdx, "register_date desc", 0, 2);
        }
        
        $data['business_categories'] = $business_categories;

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/markets/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('kpabal/markets/index_js');
    }

	
	// public function fetch_product(){
		
		// $category = $this->input->post('category');
        // $keyword = $this->input->post('keyword');
		
		// $data['fetch_products'] = $this->product_model->fetch_items($category, $keyword);
		
		// $this->load->view('kpabal/common/header',$header_data);
        // $this->load->view('kpabal/markets/index',$data);
        // $this->load->view('kpabal/common/footer',$footer_data);
        // $this->load->view('kpabal/markets/index_js');
		
		
	// }
	
	
	
	
	
	
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