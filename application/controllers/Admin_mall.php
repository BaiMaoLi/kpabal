<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_mall extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
        $this->load->model('shopping_model');
    }
    
    public function __generate_header_data($open_title = "Shopping Mall")
    {
        $header_data['memberIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
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
        $header_data['menuURL'] = "/mall";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("shopping_category");        
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/index_js", $data);
    }

    public function list_data($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "mall_title";
        $order_dir = "asc";
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
                $order_id = "mall_title";
                break;         
            case 2:
                $order_id = "mall_site_url";
                break;
            case 3:
                $order_id = "mall_address";
                break;
            case 4:
                $order_id = "mall_level";
                break;
            case 5:
                $order_id = "is_display";
                break;
        }

        $malles = $this->shopping_model->get_items($category, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($malles); $i++) {
            $mall = $malles[$i];
            $malles[$i]->image_path = ROOTPATH.PROJECT_MALL_DIR."/noimg.png";
            if(file_exists(PROJECT_MALL_DIR."/mall_".$mall->mallIdx.".jpg"))
                $malles[$i]->image_path = ROOTPATH.PROJECT_MALL_DIR."/mall_".$mall->mallIdx.".jpg";
        }
        $total_count = $this->shopping_model->get_items_count($category, $search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->malles = $malles;

        echo json_encode($response);
    }

    public function upload_attach($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_MALL_DIR."/mall_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id.".jpg");
        } 
    }

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['mall'] = $this->shopping_model->get_item($id);
        $data['categories'] = $this->category_model->get_tree_rows("shopping_category");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/edit_index_js", $data);
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->shopping_model->save_data($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }
    }

    public function remove($mallIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->shopping_model->remove_data($mallIdx);
        }
    }

    public function product($mallIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall/product";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['malles'] = $this->shopping_model->get_malles();
        $data['mallIdx'] = $mallIdx;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/product_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/product_index_js", $data);
    }

    public function product_list_data($mallIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "product_title";
        $order_dir = "asc";
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
                $order_id = "product_title";
                break;         
            case 2:
                $order_id = "product_price";
                break;
            case 3:
                $order_id = "product_level";
                break;
            case 4:
                $order_id = "is_display";
                break;
        }

        $products = $this->shopping_model->get_product_items($mallIdx, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($products); $i++) {
            $product = $products[$i];
            $products[$i]->image_path = ROOTPATH.PROJECT_MALL_DIR."/noimg.png";
            if(file_exists(PROJECT_MALL_DIR."/product_".$product->productIdx.".jpg"))
                $products[$i]->image_path = ROOTPATH.PROJECT_MALL_DIR."/product_".$product->productIdx.".jpg";
        }
        $total_count = $this->shopping_model->get_product_items_count($mallIdx, $search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->products = $products;

        echo json_encode($response);
    }

    public function product_edit($productIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall/product";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
                "assets/demo/default/custom/crud/forms/widgets/summernote.js",
            ];

        $data['productIdx'] = $productIdx;
        $data['product'] = $this->shopping_model->get_product_item($productIdx);
        $data['malles'] = $this->shopping_model->get_malles();

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/product_edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/product_edit_index_js", $data);
    }

    public function product_update() 
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->shopping_model->save_product_data($_POST);
        }
    }

    public function product_remove($productIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->shopping_model->product_remove_data($productIdx);
        }
    }

    public function product_upload_attach($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_MALL_DIR."/product_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id.".jpg");
        } 
    }

    public function order_detail($mallIdx = 0, $statusIdx = 0, $orderIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall/orders";
        $header_data['additional_css'] = [

            ];
        $footer_data['additional_js'] = [

            ];

        $data['mallIdx'] = $mallIdx;
        $data['statusIdx'] = $statusIdx;
        $data['order'] = $this->shopping_model->get_order_detail($orderIdx);

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/order_detail_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/order_detail_index_js", $data);
    }

    public function orders($mallIdx = 0, $statusIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall/orders";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['malles'] = $this->shopping_model->get_malles();
        $data['statuses'] = $this->shopping_model->get_statuses();

        $data['mallIdx'] = $mallIdx;
        $data['statusIdx'] = $statusIdx;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/orders_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/orders_index_js", $data);
    }

    public function order_list_data($mallIdx = 0, $statusIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "mall_title";
        $order_dir = "asc";
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
                $order_id = "mall_title";
                break;
            case 1:
                $order_id = "orderDate";
                break;
            case 2:
                $order_id = "orderIdx";
                break;
            case 3:
                $order_id = "orderer_name";
                break;
            case 4:
                $order_id = "phoneNumber";
                break;
            case 5:
                $order_id = "totalAmount";
                break;
            case 6:
                $order_id = "statusName";
                break;
        }

        $orders = $this->shopping_model->get_order_items($mallIdx, $statusIdx, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($orders); $i++) {
            $order = $orders[$i];
            $orders[$i]->orderDate = date("Y-m-d H:i", strtotime($order->orderDate));
        }
        $total_count = $this->shopping_model->get_order_items_count($mallIdx, $statusIdx, $search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->orders = $orders;

        echo json_encode($response);
    }

    public function payment($mallIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/mall/payment";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['malles'] = $this->shopping_model->get_malles();

        $data['mallIdx'] = $mallIdx;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/mall/payment_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/mall/payment_index_js", $data);
    }

    public function payment_list_data($mallIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "mall_title";
        $order_dir = "asc";
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
                $order_id = "mall_title";
                break;
            case 1:
                $order_id = "paymentDate";
                break;
            case 2:
                $order_id = "d.orderIdx";
                break;
            case 3:
                $order_id = "orderer_name";
                break;
            case 4:
                $order_id = "paymentKind";
                break;
            case 5:
                $order_id = "paymentAmount";
                break;
            case 6:
                $order_id = "paymentNote";
                break;
        }

        $payments = $this->shopping_model->get_payment_items($mallIdx, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($payments); $i++) {
            $payment = $payments[$i];
            $payments[$i]->orderDate = date("Y-m-d H:i", strtotime($payment->paymentDate));
        }
        $total_count = $this->shopping_model->get_payment_items_count($mallIdx, $search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->payments = $payments;

        echo json_encode($response);
    }

}
