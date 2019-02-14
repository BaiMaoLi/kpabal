<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_members extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
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

	public function index()
	{
		if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/members";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['members'] = $this->member_model->get_items($this->category_model->get_tree_rows("address_state"));

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/member/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/member/index_js");
	}

    public function edit($memberIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/members";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['memberIdx'] = $memberIdx;
        $data['member'] = $this->member_model->get_item($memberIdx);
        $data['states'] = $this->category_model->get_tree_rows("address_state");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/member/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/member/edit_index_js", $data);
    }

    public function list()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $members = $this->member_model->get_items($this->category_model->get_tree_rows("address_state"));
        $data = [];
        foreach ($members as $key => $member) {
            $data[] = array(0 => $member->user_id, 1 => $member->user_email, 2 => $member->first_name, 3 => $member->last_name, 4 => $member->stateCode, 5 => $member->phone, 6 => $member->regDate, 7 => $member->member_status, 8 => $member->is_admin, 9 => $member->memberIdx );
        }
        echo json_encode($data);
    }

    public function save()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if($this->input->post('memberIdx') == null) {
                exit();
            }
            if($this->input->post('user_password') == null) {
                $this->member_model->update_status($this->input->post('memberIdx'), $this->input->post('member_status'));
            } else {
                $this->member_model->reset_password($this->input->post('memberIdx'), $this->input->post('user_password'));
            }
        }
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->member_model->save_data($_POST);
        }        
    }

    public function upload_avatar($memberIdx = 0)
    {

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_AVATAR_DIR."/user_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$memberIdx."_1.jpg");
        }
    }

}
