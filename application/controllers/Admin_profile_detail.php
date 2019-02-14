<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_profile_detail extends My_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->header_data                   = $this->__generate_header_data('Profile Management');
        $this->header_data['menuURL']        = "/profile_detail";
        $this->header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $this->footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
    }

    public function profile($username)
    {

        // if(!$this->session->userdata('is_admin_login')){
        //     redirect(base_url().'admin');
        //     exit;
        // }

        $profile_row = $this->dating_member_model->get_member_by_username($username);

        if ($profile_row) {
            $comment_row          = $this->comments_model->get_all_comments($profile_row->id);
            $is_already_friend    = $this->friend_model->friendship_validations($profile_row->id);
            $is_already_favourite = $this->friend_model->friendship_favourite($profile_row->id);
            $profile_views        = $return        = $this->profile_views_model->count_profile_views($profile_row->id);

            $data['title']         = SITE_NAME . ': ' . $profile_row->name;
            $data['msg']           = '';
            $data['profile_views'] = $profile_views;
            $data['row']           = $profile_row;
            $data['comment_row']   = $comment_row;

            $this->load->view("admin/common/header", $this->header_data);
            $this->load->view('admin/profile_detail_view', $data);
            $this->load->view("admin/common/footer", $this->footer_data);
        } else {
            redirect(base_url() . ADMIN_PUBLIC_DIR .'/profiles_lists');
            exit;
        }

    }

    public function profile_delete($id)
    {

        $rs = $this->dating_member_model->delete_member($id);
        $this->session->set_flashdata('msg', 'Profile Deleted successfully.');
        redirect(base_url() . ADMIN_PUBLIC_DIR . "/profiles_lists");

    }

    public function profile_sts($id, $sts)
    {

        $member_array = array(
            'sts' => $sts,
        );

        $this->dating_member_model->update_member($id, $member_array);
        $this->session->set_flashdata('msg', 'Profile Updated Successfully.');
        redirect(base_url() . ADMIN_PUBLIC_DIR . "/profiles_lists");
    }

    public function user_comment_delete($username, $id)
    {

        $rs = $this->comments_model->delete_comment($id);
        $this->session->set_flashdata('msg', 'Comment Deleted successfully.');
        redirect(base_url() . ADMIN_PUBLIC_DIR . "/profile_detail/profile/" . $username, '');
        return;
    }

}
