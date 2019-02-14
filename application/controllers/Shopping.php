<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Shopping extends REST_Controller {

	function __construct() {
		parent::__construct();

        $this->load->model('shopping_model');
	}
	
	public function index_get()
	{
        $header_data = $this->__generate_header_data("Shopping Mall");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $data['home_sliders'] = $this->basis_model->get_categories("site_contents", "05", true);
        $data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "06", true);
        $data['malles'] = $this->shopping_model->get_malles("", false);
        $shopping_categories = $this->category_model->get_tree_rows("shopping_category");
        foreach ($shopping_categories as $key => $category) {
            if($shopping_categories[$key]->isDisplay)
                $shopping_categories[$key]->products = $this->shopping_model->get_product_for_category($category->categoryIdx, 12);
            else
                $shopping_categories[$key]->products = [];
        }
        $data['shopping_categories'] = $shopping_categories;

        $this->load->view('kpabal/common/header', $header_data);
        $this->load->view('kpabal/shopping/index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
	}
    
    public function category_get($categoryIdx = "")
    {
        $header_data = $this->__generate_header_data("Shopping Mall");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $data['home_sliders'] = $this->basis_model->get_categories("site_contents", "08", true);
        $data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "09", true);
        $malles = $this->shopping_model->get_malles($categoryIdx, false);
        foreach ($malles as $key => $mall) {
            if($malles[$key]->is_display)
                $malles[$key]->products = $this->shopping_model->get_product_for_mall($mall->mallIdx, 12);
            else
                $malles[$key]->products = [];
        }
        $data['malles'] = $malles;

        $this->load->view('kpabal/common/header', $header_data);
        $this->load->view('kpabal/shopping/category_index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
    }
    
    public function mall_get($mallIdx = "")
    {
        $header_data = $this->__generate_header_data("Shopping Mall");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $data['category'] = $this->shopping_model->get_category_for_mall($mallIdx);
        $data['home_sliders'] = $this->basis_model->get_categories("site_contents", "10", true);
        $data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "11", true);
        $recommended_product = $this->shopping_model->get_recommended_products($mallIdx, 0);
        $data['recommended_product'] = $recommended_product;
        $recent_product2 = $this->shopping_model->get_recent_products($mallIdx, 0);
        $recent_product = [];
        foreach ($recent_product2 as $product_obj) {
            if(($this->check_exist($recommended_product, $product_obj->productIdx)) && (count($recent_product) < 5))
                $recent_product[] = $product_obj;
        }
        $data['recent_product'] = $recent_product;
        $data['products'] = $this->shopping_model->get_product_for_mall($mallIdx, 100);

        $this->load->view('kpabal/common/header', $header_data);
        $this->load->view('kpabal/shopping/mall_index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
    }

    public function check_exist($arrProduct, $productIdx)
    {
        foreach ($arrProduct as $productObj) {
            if($productObj->productIdx == $productIdx)
                return false;
        }
        return true;
    }

    public function product_get($productIdx = 0)
    {
        $header_data = $this->__generate_header_data("Shopping Mall");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $product = $this->shopping_model->get_product_item($productIdx);
        $mallIdx = $product->mallIdx;
        $product->category = $this->shopping_model->get_category_for_mall($mallIdx);
        $data['product'] = $product;
        $data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "07", true);
        $recommended_product = $this->shopping_model->get_recommended_products($mallIdx, $productIdx);
        $data['recommended_product'] = $recommended_product;
        $recent_product2 = $this->shopping_model->get_recent_products($mallIdx, $productIdx);
        $recent_product = [];
        foreach ($recent_product2 as $product_obj) {
            if(($this->check_exist($recommended_product, $product_obj->productIdx)) && (count($recent_product) < 5))
                $recent_product[] = $product_obj;
        }
        $data['recent_product'] = $recent_product;

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/shopping/product', $data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('kpabal/shopping/product_js', $data);
    }

    public function add_cart_post($productIdx = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $this->shopping_model->add_cart($memberIdx, $productIdx);
    }

    public function set_cart_post($productIdx = 0, $productAmount = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $this->shopping_model->set_cart_amount($memberIdx, $productIdx, $productAmount);
    }

    public function cart_get()
    {
        $header_data = $this->__generate_header_data("Shopping Cart");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $data['carts'] = $this->shopping_model->get_user_carts($memberIdx);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/shopping/cart', $data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('kpabal/shopping/cart_js', $data);
    }

    public function cart_post()
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $this->shopping_model->place_order($_POST, $memberIdx);

        header('Location: '.ROOTPATH.'shopping/order_placed');
    }

    public function order_placed_get()
    {
        $header_data = $this->__generate_header_data("Order Placed");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/shopping/order_placed', $data);
        $this->load->view('kpabal/common/footer',$footer_data);
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^0-9.\-]/', '', $string); // Removes special chars.
    }

    public function import_mall_post($mallIdx = 0)
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        if(isset($_POST['d'])) $data = $_POST['d']; else exit();
        $data = json_decode($data, true);
        $data['mallIdx'] = $mallIdx;
        $data['is_display'] = 1;
        $data['product_price'] = $this->clean($data['product_price']);
        $data['product_price_old'] = $this->clean($data['product_price_old']);

        $this->db->insert("shopping_product", $data);

        $product_id = $this->db->insert_id();
        $filename = PROJECT_MALL_DIR."/product_".$product_id.".jpg";
        @file_put_contents($filename, @file_get_contents($data["product_image"]));
        
        exit();
    }

}
