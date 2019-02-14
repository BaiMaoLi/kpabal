<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Business extends REST_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index_get($id = 0)
	{
        $business = $this->business_model->get_item($id);
        if($business) {
            $member = $this->general->user_logged_in();
            $memberIdx = $member->memberIdx;

            $options = $this->basis_model->get_categories("business_option", $business->categoryIdx, true);
            $business->comments = $this->business_model->get_comments($id);
            $options_detail = $this->business_model->get_options($id);
            foreach ($options as $key => $option) {
                $option_id = $option->id;
                if(isset($options_detail[$option_id]))
                    $options[$key]->option_value = $options_detail[$option_id];
                else
                    unset($options[$key]);
            }
            $business->favorite = $this->business_model->is_favorite($id, $memberIdx);
            $business->options = $options;

            $header_data = $this->__generate_header_data($business->business_name_ko);
            $footer_data = $this->__generate_footer_data($header_data);
            $data        = $this->__generate_side_data($header_data);

            $data['business_categories'] = $this->category_model->get_tree_rows("business_category", true);
            $business->categoryName = "";
            foreach ($data['business_categories'] as $category) {
                if(strpos($business->categoryIdx, $category->categoryIdx) === 0)
                    $business->categoryName = $category->categoryName;
            }
            $states = $this->category_model->get_tree_rows("address_state");
            $business->stateCode = "";
            foreach ($states as $state) {
                if($state->stateIdx == $business->stateIdx)
                    $business->stateCode = $state->stateCode;
            }
            $data['business'] = $business;            

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/business/detail', $data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/business/detail_js', $data);
        } else {
            $header_data = $this->__generate_header_data("업소록");
    		$footer_data = $this->__generate_footer_data($header_data);
            $data        = $this->__generate_side_data($header_data);

            $data['home_sliders'] = $this->basis_model->get_categories("site_contents", "03", true);
            $data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "04", true);
            
            $data['business_categories'] = $this->category_model->get_tree_rows("business_category", true);
            $data['states'] = $this->category_model->get_tree_rows("address_state");
            $data['categoryIdx'] = "";
            if(isset($_GET['categoryIdx'])) $data['categoryIdx'] = $_GET['categoryIdx'];

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/business/index',$data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/business/index_js', $data);
        }
    }

    public function search_post()
    {
        $categoryIdx = $this->post("category");
        $stateIdx = $this->post("state");
        $search_key = $this->post("keyword");
        $page_number = $this->post("page");
        $sort = $this->post("sort");

        if($sort == "home-tab") $sort = "register_date desc";
        else if($sort == "rating-tab") $sort = "rating desc";
        else if($sort == "review-tab") $sort = "reviews desc";

        $offset = 25;

        $arr_categories = $this->category_model->list_data("business_category", true);
        $total_count = $this->business_model->search_business_count($arr_categories, $categoryIdx, $stateIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $businesses = $this->business_model->search_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $categoryIdx, $stateIdx, $search_key, $page_number, $offset, $sort);

        $data = [
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $businesses,
        ];

        $this->load->view('kpabal/business/search_list', $data);
    }
}