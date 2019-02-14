<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Favorites extends REST_Controller {

	function __construct() {
		parent::__construct();

        $this->load->model('shopping_model');
	}
    
    public function mall_get($id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        if($id === "new") {
            $header_data = $this->__generate_header_data("New Shopping Mall");
            $footer_data = $this->__generate_footer_data($header_data);
            $data        = $this->__generate_side_data($header_data);

            $data['mall_categories'] = $this->category_model->get_tree_rows("shopping_category", true);
            $data['mall'] = false;
            $data['memberIdx'] = $memberIdx;

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/favorite/mall_detail', $data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/favorite/mall_detail_js', $data);
        } else {
            $mall = $this->shopping_model->get_item($id);
            if($mall) {
                if($mall->memberIdx != $memberIdx) exit();

                $header_data = $this->__generate_header_data($mall->mall_title);
                $footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);
                
                $data['mall_categories'] = $this->category_model->get_tree_rows("shopping_category", true);

                $mall->categoryName = "";
                foreach ($data['mall_categories'] as $category) {
                    if(strpos($mall->categoryIdx, $category->categoryIdx) === 0)
                        $mall->categoryName = $category->categoryName;
                }
                $data['mall'] = $mall;
                $data['memberIdx'] = $memberIdx;

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/favorite/mall_detail', $data);
                $this->load->view('kpabal/common/footer',$footer_data);
                $this->load->view('kpabal/favorite/mall_detail_js', $data);
            } else {
                $header_data = $this->__generate_header_data("Shopping Mall");
                $footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/favorite/mall_index',$data);
                $this->load->view('kpabal/common/footer',$footer_data);
                $this->load->view('kpabal/favorite/mall_index_js', $data);
            }
        }
    }

    public function my_order_get()
    {
        $header_data = $this->__generate_header_data("Shopping Mall");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/favorite/my_order_index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('kpabal/favorite/my_order_index_js', $data);
    }

    public function mall_product_get($id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        if($id === "new") {
            $header_data = $this->__generate_header_data("New Product");
            $footer_data = $this->__generate_footer_data($header_data);
            $data        = $this->__generate_side_data($header_data);

            $data['malles'] = $this->shopping_model->search_my_malles($memberIdx, 0, 10, "created_at desc");
            $data['product'] = false;
            $data['memberIdx'] = $memberIdx;

            $footer_data['additional_js'] = [
                "assets/demo/default/custom/crud/forms/widgets/summernote.js",
            ];

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/favorite/mall_product_detail', $data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/favorite/mall_product_detail_js', $data);
        } else {
            $product = $this->shopping_model->get_product_item($id);
            if($product) {
                $header_data = $this->__generate_header_data($product->product_title);
                $footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);
                
                $data['malles'] = $this->shopping_model->search_my_malles($memberIdx, 0, 10, "created_at desc");

                $product->mall_title = "";
                foreach ($data['malles'] as $mall) {
                    if($mall->mallIdx == $product->mallIdx)
                        $product->mall_title = $mall->mall_title;
                }
                if($product->mall_title == "") exit();

                $data['product'] = $product;
                $data['memberIdx'] = $memberIdx;

                $header_data['additional_css'] = [
                    
                ];

                $footer_data['additional_js'] = [
                    
                ];

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/favorite/mall_product_detail', $data);
                $this->load->view('kpabal/common/footer',$footer_data);
                $this->load->view('kpabal/favorite/mall_product_detail_js', $data);
            }
        }
    }
	
	public function business_get($id = 0)
	{
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $target_file = FCPATH.PROJECT_COMPANY_DIR."/user_";
        if(file_exists($target_file.$memberIdx.".jpg")) unlink($target_file.$memberIdx.".jpg");

        if($id === "new") {
            $header_data = $this->__generate_header_data("New Business");
            $footer_data = $this->__generate_footer_data($header_data);
            $data        = $this->__generate_side_data($header_data);

            $data['business_categories'] = $this->category_model->get_tree_rows("business_category", true);
            $data['states'] = $this->category_model->get_tree_rows("address_state");            
            $data['business'] = false;
            $data['memberIdx'] = $memberIdx;

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/favorite/business_detail', $data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/favorite/business_detail_js', $data);
        } else {
            $business = $this->business_model->get_item($id);
            if($business) {
                if($business->memberIdx != $memberIdx) exit();

                $options = $this->basis_model->get_categories("business_option", $business->categoryIdx, true);
                $options_detail = $this->business_model->get_options($id);
                foreach ($options as $key => $option) {
                    $option_id = $option->id;
                    if(isset($options_detail[$option_id]))
                        $options[$key]->option_value = $options_detail[$option_id];
                }            
                $business->options = $options;

                $header_data = $this->__generate_header_data($business->business_name_ko);
                $footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);
                
                $data['business_categories'] = $this->category_model->get_tree_rows("business_category", true);
                $data['states'] = $this->category_model->get_tree_rows("address_state");
                $business->categoryName = "";
                foreach ($data['business_categories'] as $category) {
                    if(strpos($business->categoryIdx, $category->categoryIdx) === 0)
                        $business->categoryName = $category->categoryName;
                }
                $data['business'] = $business;
                $data['memberIdx'] = $memberIdx;

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/favorite/business_detail', $data);
                $this->load->view('kpabal/common/footer',$footer_data);
                $this->load->view('kpabal/favorite/business_detail_js', $data);
            } else {
                $header_data = $this->__generate_header_data("업소록");
        		$footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/favorite/index',$data);
                $this->load->view('kpabal/common/footer',$footer_data);
                $this->load->view('kpabal/favorite/index_js', $data);
            }
        }
    }
    
    public function business_post($id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $business = $this->business_model->get_item($id);
        if($business) {
            if($business->memberIdx != $memberIdx) exit();
        } else {
            $id = 0;
        }

        $arr_main = [];
        $arr_detail = [];
        foreach ($_POST as $key => $value) {
            if(substr($key, 0, 7) == "option_") {
                $arr_detail[$key] = $value;
            } else {
                $arr_main[$key] = $value;
            }
        }

        $id = $this->business_model->register_business($memberIdx, $id, $arr_main);

        $target_file = FCPATH.PROJECT_COMPANY_DIR."/user_";
        if(file_exists($target_file.$memberIdx.".jpg")) {
            $old_files = glob(FCPATH.PROJECT_COMPANY_DIR."/business_".$id."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
            rename(FCPATH.PROJECT_COMPANY_DIR."/user_".$memberIdx.".jpg", FCPATH.PROJECT_COMPANY_DIR."/business_".$id.".jpg");
            $old_files = glob(FCPATH.PROJECT_COMPANY_DIR."/user_".$memberIdx."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
        }

        $this->business_model->save_option_datas($memberIdx, $id, $arr_detail);

        header('Location: '.ROOTPATH.'favorites/business');
    }
    
    public function mall_post($id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $mall = $this->shopping_model->get_item($id);
        if($mall) {
            if($mall->memberIdx != $memberIdx) exit();
        } else {
            $id = 0;
        }
        $_POST['mallIdx'] = $id;

        $id = $this->shopping_model->save_data($_POST, $memberIdx);

        $target_file = FCPATH.PROJECT_MALL_DIR."/user_";
        if(file_exists($target_file.$memberIdx.".jpg")) {
            $old_files = glob(FCPATH.PROJECT_MALL_DIR."/mall_".$id."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
            rename(FCPATH.PROJECT_MALL_DIR."/user_".$memberIdx.".jpg", FCPATH.PROJECT_MALL_DIR."/mall_".$id.".jpg");
            $old_files = glob(FCPATH.PROJECT_MALL_DIR."/user_".$memberIdx."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
        }

        header('Location: '.ROOTPATH.'favorites/mall');
    }
    
    public function mall_product_post($id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $product = $this->shopping_model->get_product_item($id);
        $mall = $this->shopping_model->get_item($product->mallIdx);
        if($mall) {
            if($mall->memberIdx != $memberIdx) exit();
        } else {
            $id = 0;
        }
        $_POST['productIdx'] = $id;

        $id = $this->shopping_model->save_product_data($_POST);

        $target_file = FCPATH.PROJECT_MALL_DIR."/user_p_";
        if(file_exists($target_file.$memberIdx.".jpg")) {
            $old_files = glob(FCPATH.PROJECT_MALL_DIR."/product_".$id."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
            rename(FCPATH.PROJECT_MALL_DIR."/user_p_".$memberIdx.".jpg", FCPATH.PROJECT_MALL_DIR."/product_".$id.".jpg");
            $old_files = glob(FCPATH.PROJECT_MALL_DIR."/user_p_".$memberIdx."*.jpg");
            foreach ($old_files as $old_file) {
                unlink($old_file);
            }
        }

        header('Location: '.ROOTPATH.'favorites/mall');
    }

    public function search_post()
    {
        $page_number = $this->post("page");
        $where = $this->post("where");
        $offset = 5;

        $user_info = __get_user_session();
        $memberIdx = $user_info['memberIdx'];

        $categoryIdx = "";
        $search_key = "";

        if($where == "home-tab") {
            $arr_categories = $this->category_model->list_data("business_category", true);
            $total_count = $this->business_model->search_my_business_count($memberIdx, $arr_categories, $categoryIdx, $search_key);
            $businesses = $this->business_model->search_my_business($memberIdx, $arr_categories, $this->category_model->get_tree_rows("address_state"), $categoryIdx, $search_key, $page_number, $offset, "register_date desc");            
        } else if($where == "rating-tab") {
            $arr_categories = $this->category_model->list_data("business_category", true);
            $total_count = $this->business_model->search_favorite_business_count($arr_categories, $memberIdx, $search_key);
            $businesses = $this->business_model->search_favorite_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $memberIdx, $search_key, $page_number, $offset); 
        } else if($where == "review-tab") {
            $total_count = $this->business_model->search_review_business_count($memberIdx);
            $businesses = $this->business_model->search_review_business($memberIdx, $page_number, $offset); 
        }

        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;

        $data = [
            "status" => true,
            "where" => $where,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $businesses,
        ];

        $this->load->view('kpabal/favorite/search_list', $data);
    }

    public function search_mall_post()
    {   
        $page_number = $this->post("page");
        $where = $this->post("where");
        $offset = 10;

        $user_info = __get_user_session();
        $memberIdx = $user_info['memberIdx'];

        $search_key = "";

        if($where == "home-tab") {
            $total_count = $this->shopping_model->search_my_malles_count($memberIdx);
            $result = $this->shopping_model->search_my_malles($memberIdx, $page_number, $offset, "created_at desc");
        } else if($where == "product-tab") {
            $total_count = $this->shopping_model->search_my_mall_product_count($memberIdx, $search_key);
            $result = $this->shopping_model->search_my_mall_product($memberIdx, $search_key, $page_number, $offset); 
        } else if($where == "order-tab") {
            $total_count = $this->shopping_model->search_mall_order_count($memberIdx);
            $result = $this->shopping_model->search_mall_order($memberIdx, $page_number, $offset); 
        } else if($where == "payment-tab") {
            $total_count = $this->shopping_model->search_mall_payment_count($memberIdx);
            $result = $this->shopping_model->search_mall_payment($memberIdx, $page_number, $offset); 
        }

        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;

        $data = [
            "status" => true,
            "where" => $where,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $result,
        ];

        $this->load->view('kpabal/favorite/search_mall_list', $data);
    }

    public function search_my_orders_post()
    {
        $page_number = $this->post("page");
        $where = $this->post("where");
        $offset = 10;

        $user_info = __get_user_session();
        $memberIdx = $user_info['memberIdx'];

        $search_key = "";

        if($where == "order-tab") {
            $total_count = $this->shopping_model->search_my_order_count($memberIdx);
            $result = $this->shopping_model->search_my_order($memberIdx, $page_number, $offset); 
        } else if($where == "payment-tab") {
            $total_count = $this->shopping_model->search_my_payment_count($memberIdx);
            $result = $this->shopping_model->search_my_payment($memberIdx, $page_number, $offset); 
        }

        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;

        $data = [
            "status" => true,
            "where" => $where,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $result,
        ];

        $this->load->view('kpabal/favorite/search_mall_list', $data);
    }
}