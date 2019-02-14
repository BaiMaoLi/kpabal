<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_merchants extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('coupon_model');
    }
    
    public function __generate_header_data($open_title = "Management")
    {
        $header_data['memberIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

    public function index($category = "1")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/merchants";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = ["1" => "Main Page 1st Row", "2" => "Main Page 2nd Row", "3" => "Category Page"];
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/merchants/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/merchants/index_js", $data);
    }

    public function list_data($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "is_selection";
        $order_dir = "desc";
        $limit = 10;
        $offset = 0;
        $search = "";
        $draw = 1;

        if(isset($_POST["order_id"])) $order_id = $_POST["order_id"];
        if(isset($_POST["order_dir"])) $order_dir = $_POST["order_dir"];
        if(isset($_POST["limit"])) $limit = $_POST["limit"];
        if(isset($_POST["offset"])) $offset = $_POST["offset"];
        if(isset($_POST["search"])) $search = $_POST["search"];
        if(isset($_POST["draw"])) $draw = $_POST["draw"];

        switch ($order_id) {
            case 0:
                $order_id = "cName";
                break;         
            case 1:
                $order_id = "a.nMerchantID";
                break;
            case 3:
                $order_id = "cashback";
                break;
            default:
                $order_id = "is_selection";
                break;
        }

        $merchants = $this->coupon_model->search_merchants($category, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($merchants); $i++) {
            $merchant = $merchants[$i];
            if($merchant->is_selection) $merchants[$i]->is_selection = 1;
            else $merchants[$i]->is_selection = 0;
            if(!($merchant->cashback)) $merchants[$i]->cashback = 0;
            if(!($merchant->orderNum)) $merchants[$i]->orderNum = 0;
            $merchants[$i]->image_path = ROOTPATH.PROJECT_COMPANY_DIR."/noimg.png";
            $merchant_logo = json_decode($merchant->aLogos);
            foreach ($merchant_logo as $unique_key) {
                if($unique_key->cSize=="120x60"){
                    $merchants[$i]->image_path = site_url('coupon/get_safe_res').'?url='.$unique_key->cURL;
                }
            }
        }
        $total_count = $this->coupon_model->search_merchants_count($search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->merchants = $merchants;

        echo json_encode($response);
    }

    public function cashback_update($nMerchantID = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->coupon_model->save_cashback($nMerchantID, $_POST['cashback']);
        }
    }

    public function selection_update($selectionType = 1, $nMerchantID = 0) {     
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->coupon_model->save_selection($selectionType, $nMerchantID, $_POST['is_display'], $_POST['orderNum']);
        }   
    }
}
