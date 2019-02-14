<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saving extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
		$this->load->model('login_model');
		$this->load->model('member_model');
		$this->load->model('basis_model');
		$this->load->model('board_model');
		$this->load->model('category_model');
		$this->load->model('business_model');
		$this->load->model('product_model');
		$this->load->model('savings_model');
    }
    
	public function __generate_header_data($caption = "") {
		$header_data = [];

		$header_data['loggedinuser'] = __get_user_session();
		$header_data['caption'] = $caption;
		$header_data['categories'] = $this->category_model->get_tree_rows("site_menu", true);
		$header_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
		$header_data['cart'] = new \stdClass();
		$header_data['cart']->items = [];

		return $header_data;
	}

	public function __generate_footer_data() {
		$footer_data = [];
		$footer_data['blog_categories'] = $this->category_model->get_rows("board_category");
		$footer_data['recent_business'] = $this->business_model->recent_business();
		$footer_data['total_business'] = $this->business_model->total_count();
		$footer_data['total_client'] = $footer_data['total_business'] + $this->member_model->total_count();

		return $footer_data;
	}
    public function index()
	{
		$header_data = $this->__generate_header_data("Saving");
		$footer_data = $this->__generate_footer_data();
		$data['sliders'] = $this->basis_model->get_categories("site_contents", "01", true);

		$data['products'] = $this->product_model->get_recent_items($this->category_model->list_data("products_category"));
        $arr_categories = $this->category_model->list_data("board_category", true);
        $data['articles'] = $this->board_model->get_suggest_articles($arr_categories, $this->member_model->list_data(), "");

        $jobs = [];
        $job = new \stdClass();
        $job->title = "Parallax Support";
        $job->description = "Display your Content attractively using Parallax Sections that have unlimited customizable areas.";
        for($i=0; $i<9; $i++)
        	$jobs[] = $job;

        $data['jobs'] = $jobs;
		

        $footer_data['additional_js'] = [
                "https://code.jquery.com/ui/1.12.1/jquery-ui.js",
        	];
        	
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/saving/index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
	}	
}