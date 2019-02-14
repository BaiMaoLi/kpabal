<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_business extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
        $this->load->model('business_model');
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

    public function index($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("business_category");        
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/index_js", $data);
    }

    public function list_data($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $order_id = "register_date";
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
                $order_id = "business_name_ko";
                break;         
            case 2:
                $order_id = "email";
                break;
            case 3:
                $order_id = "phone1";
                break;
            case 4:
                $order_id = "fax";
                break;
            case 5:
                $order_id = "stateIdx";
                break;
            case 6:
                $order_id = "categoryIdx";
                break;
            case 7:
                $order_id = "is_display";
                break;
            case 8:
                $order_id = "memberIdx";
                break;
            case 9:
                $order_id = "register_date";
                break;
            default:
                $order_id = "register_date";
                break;
        }

        $businesses = $this->business_model->get_items($this->category_model->list_data("business_category"), $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $category, $order_id, $order_dir, $offset, $limit, $search);
        for($i=0; $i<count($businesses); $i++) {
            $business = $businesses[$i];
            $businesses[$i]->image_path = ROOTPATH.PROJECT_COMPANY_DIR."/noimg.png";
            if(file_exists(PROJECT_COMPANY_DIR."/business_".$business->id.".jpg"))
                $businesses[$i]->image_path = ROOTPATH.PROJECT_COMPANY_DIR."/business_".$business->id.".jpg";
        }
        $total_count = $this->business_model->get_items_count($category, $search);

        $response = new \stdClass();
        $response->draw = $draw;
        $response->total = $total_count;
        $response->businesses = $businesses;

        echo json_encode($response);
    }

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['business'] = $this->business_model->get_item($id);
        $data['states'] = $this->category_model->get_tree_rows("address_state");
        $data['categories'] = $this->category_model->get_tree_rows("business_category");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/edit_index_js", $data);
    }

    public function edit_option($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $business = $this->business_model->get_item($id);
        $data['business'] = $business;
        $categoryIdx = $business->categoryIdx;
        $options = $this->basis_model->get_categories("business_option", $categoryIdx);
        $options_detail = $this->business_model->get_options($id);
        foreach ($options as $key => $option) {
            $option_id = $option->id;
            if(isset($options_detail[$option_id]))
                $options[$key]->option_value = $options_detail[$option_id];
        }
        $data['options'] = $options;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/edit_option_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/edit_option_index_js", $data);
    }

    public function option_update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->business_model->save_option_data($_POST);
        }
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->business_model->save_data($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }        
    }

    public function upload_attach($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_COMPANY_DIR."/business_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id.".jpg");
        } 
    }
}
