<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_lottery extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('lottery_model');
    }

    public function __generate_header_data($open_title = "Lottery")
    {
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
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
        $header_data['menuURL'] = "/Lottery";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $member=$this->general->admin_controlpanel_logged_in();
        //$data['results']=$this->talky_model->get_search_talky();
        $mylogs = $this->lottery_model->getLogsByUserId($member->memberIdx);
        
        $user_name = $member->user_id;

        $data1["log_title"]= "Lottery Logs";
        $data1["user_name"]= $user_name;
        $data1["myLogs"]= $mylogs;
        
        
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("kpabal/lottery/log", $data1);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("kpabal/lottery/index_js", $footer_data);
    }
    
    public function lotteryresult() {
		
		//$this->lottery_model->insertGameDataTable();
		
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/Lottery";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        
        $mylogs = $this->lottery_model->getLatestLotteryRuesults();

        $data1["log_title"] = "Latest Lottery Results";

        $data1["myLogs"] = $mylogs;
        
        
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("kpabal/lottery/lotteryresult", $data1);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("kpabal/lottery/index_js", $footer_data);
    }
    public function payment() {
		
		//$this->lottery_model->insertGameDataTable();
		
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/Lottery";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        
        $mylogs = $this->lottery_model->getLatestLotteryRuesults();

        $data1["log_title"] = "Latest Lottery Results";

        $data1["myLogs"] = $mylogs;
        
        
        $this->load->view("admin/common/header", $header_data);
        //$this->load->view("kpabal/lottery/lotteryresult", $data1);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("kpabal/lottery/index_js", $footer_data);
    }
    public function order() {
		
		//$this->lottery_model->insertGameDataTable();
		
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/Lottery";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        
        $mylogs = $this->lottery_model->getLatestLotteryRuesults();

        $data1["log_title"] = "Latest Lottery Results";

        $data1["myLogs"] = $mylogs;
        
        
        $this->load->view("admin/common/header", $header_data);
        //$this->load->view("kpabal/lottery/lotteryresult", $data1);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("kpabal/lottery/index_js", $footer_data);
    }
}
?>