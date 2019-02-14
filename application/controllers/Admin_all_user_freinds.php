<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_all_user_freinds extends My_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->header_data                   = $this->__generate_header_data('Profile Management');
        $this->header_data['menuURL']        = "/all_user_freinds";
        $this->header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $this->footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
    }

    public function friend_list($id)
    {

        // if (!$this->session->userdata('is_admin_login')) {
        //     redirect(base_url() . 'admin');
        //     exit;
        // }

        $userRealName = $this->dating_member_model->get_member_name_by_id($id);
        $friend_row   = $this->friend_model->get_all_approved_friends($id);

        $data['title']      = SITE_NAME . ': User Friends';
        $data['msg']        = '';
        $data['friend_row'] = $friend_row;
        $data['real_name']  = $userRealName;
        $this->load->view("admin/common/header", $this->header_data);
        $this->load->view('admin/user_freinds_view', $data);
        $this->load->view("admin/common/footer", $this->footer_data);
        return;

    }

}
