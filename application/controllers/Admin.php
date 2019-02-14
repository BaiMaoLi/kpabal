<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
	}
	
	public function index()
	{

	}

	public function login()
	{
		if ($this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR . '/dashboard');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            
            $this->form_validation->set_rules($this->login_model->validate_rules_login);

            if ($this->form_validation->run() == TRUE) {
                $user = $this->login_model->check_login();
                if ($user) {
                    if ($user->member_status == 1) {
                        $this->login_model->store_login($user);
                        redirect(ADMIN_PUBLIC_DIR . '/dashboard');
                        exit;
                    } else {
                        $this->session->set_flashdata('login_message', 'Login is Disabled, Please contact System Admin');
                    }
                } else {
                    $this->session->set_flashdata('login_message', 'Invalid Username or Password');
                }
            } else {
            	$this->session->set_flashdata('login_message', 'Invalid Username or Password');
            }
        }
        $data['message'] = $this->session->flashdata('login_message');

        $this->load->view("admin/login", $data);
	}

    public function logout() {
        $this->session->unset_userdata('admin_captcha');
        $this->session->unset_userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $this->session->unset_userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username');
        $this->session->unset_userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $this->session->unset_userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $this->session->unset_userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'regdate');

        $this->session->set_flashdata('login_message', '');
        $this->_clean_cookie_();
        redirect(ADMIN_PUBLIC_DIR, 'refresh');
        exit;
    }

    public function _clean_cookie_() {
        $this->load->helper('cookie');
        delete_cookie(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        delete_cookie(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'email');
    }

    public function __generate_header_data($open_title = "Dashboard")
    {
        $header_data['memberIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
    	$header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

	public function dashboard()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/index");
        $this->load->view("admin/common/footer");
	}

	public function basis($tbl_name = "business_option", $categoryIdx = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data("Basis");
        $header_data['additional_css'] = [
        		"assets/vendors/custom/datatables/datatables.bundle.css",
        	];

        $header_data['menuURL'] = "/basis/".$tbl_name;

        $footer_data['additional_js'] = [
        		"assets/vendors/custom/datatables/datatables.bundle.js",
        		"assets/demo/default/custom/crud/forms/widgets/summernote.js",
        	];

        $data['columns'] = $this->basis_model->get_columns($tbl_name);
        $data['dispCaption'] = $this->basis_model->get_caption($tbl_name);
        $data['rows'] = $this->basis_model->get_rows($tbl_name, $categoryIdx);
        $data['pri_fld'] = $this->basis_model->get_pri_fld( $data['columns'] );
        $data['categoryIdx'] = $categoryIdx;
        $data['tbl_name'] = $tbl_name;

        if($tbl_name == "business_option") $category_tbl_name = "business_category";
        if($tbl_name == "site_help") $category_tbl_name = "site_help_category";
        if($tbl_name == "site_contents") $category_tbl_name = "site_contents_category";
        if($tbl_name == "news") $category_tbl_name = "news_category";
        if($category_tbl_name) {
	        $data['categories_data'] = $this->basis_model->get_tree_rows($category_tbl_name, $tbl_name);
	        $data['root_count'] = $this->basis_model->get_root_count($tbl_name);
	        $data['order_num'] = $this->basis_model->calc_order_num( $data['columns'] );
	    } else {
	    	$data['is_wide'] = true;
	    }

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/basis/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/basis/index_js", $data);
	}

	public function basis_get($tbl_name = "business_option")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			echo json_encode($this->basis_model->get_data($tbl_name, $this->input->post('record_idx')));
		}        
    }

    public function upload_attach($tbl_name = "site_contents", $id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_MEDIA_DIR."/".$tbl_name."_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id.".jpg");
        }        
    }

	public function basis_save($tbl_name = "business_option", $categoryIdx = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$columns = $this->basis_model->get_columns($tbl_name);
			$this->basis_model->save_data($tbl_name, $categoryIdx, $columns, $_POST);
		}        
    }

	public function basis_remove($tbl_name = "business_option")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$this->basis_model->remove_data($tbl_name, $this->input->post('record_idx'));
		}        
    }


	public function category($tbl_name = "admin_menu", $parentIdx = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		$header_data = $this->__generate_header_data("Category");
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
        	];

        if(($tbl_name == "address_state") || ($tbl_name == "site_setting")) $header_data['open'] = "Basis";
        $header_data['menuURL'] = "/category/".$tbl_name;

        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
        	];

        $data['columns'] = $this->category_model->get_columns($tbl_name);
        $data['dispCaption'] = $this->category_model->get_caption($tbl_name);
        $data['dispCaption_fld'] = $this->category_model->get_caption_fld($tbl_name);
        $data['additional_caption'] = $this->category_model->get_additional_caption($tbl_name, $parentIdx);
        $data['rows'] = $this->category_model->get_rows($tbl_name, $parentIdx);
        $data['parentIdx'] = $parentIdx;
        $data['treeCheck'] = true;
        if(($tbl_name == "address_state") || ($tbl_name == "site_setting")) $data['treeCheck'] = false;
        $data['tbl_name'] = $tbl_name;
        $data['pri_fld'] = $this->category_model->get_pri_fld( $data['columns'] );
        $data['order_num'] = $this->category_model->calc_order_num( $data['columns'] );

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/category/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/category/index_js", $data);
	}

	public function category_get($tbl_name = "admin_menu", $parentIdx = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$columns = $this->category_model->get_columns($tbl_name);
			echo json_encode($this->category_model->get_data($tbl_name, $columns, $this->input->post('record_idx')));
		}        
    }

	public function category_save($tbl_name = "admin_menu", $parentIdx = "")
	{
		
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			$columns = $this->category_model->get_columns($tbl_name);
			
			$this->category_model->save_data($tbl_name, $parentIdx, $columns, $_POST);
		}        
    }

	public function category_remove($tbl_name = "admin_menu", $parentIdx = "")
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$columns = $this->category_model->get_columns($tbl_name);
			$this->category_model->remove_data($tbl_name, $columns, $this->input->post('record_idx'));
		}        
    }
}
