<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_all_messages extends My_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->header_data                   = $this->__generate_header_data('email_templates');
        $this->header_data['menuURL']        = "/all_messages";
        $this->header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $this->footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
    }

    public function index()
    {
        // if (!$this->session->userdata('is_admin_login')) {
        //     redirect(base_url() . 'admin');
        //     exit;
        // }

        $message_row = $this->message_model->get_all_profiles_messages();
        $data['title'] = SITE_NAME . ': User Messages';
        $data['msg']   = '';
        $c             = 0;
        if ($message_row) {

            foreach ($message_row as $messagesDetail) {
                $messageRow[$c]['date_send']   = $messagesDetail->date_send;
                $messageRow[$c]['sender']      = $this->dating_member_model->get_member_name_by_id($messagesDetail->sender_id);
                $messageRow[$c]['reciever']    = $this->dating_member_model->get_member_name_by_id($messagesDetail->reciever_id);
                $messageRow[$c]['message']     = $messagesDetail->message;
                $messageRow[$c]['messages_id'] = $messagesDetail->messages_id;
                $c++;
            }
        } else {

            $messageRow = 0;
        }
        $data['message_row'] = $messageRow;
        $this->load->view("admin/common/header", $this->header_data);
        $this->load->view('admin/messages_view', $data);
        $this->load->view("admin/common/footer", $this->footer_data);
        return;

    }

    public function message_delete($id)
    {

        $rs = $this->message_model->delete_message($id);
        $this->session->set_flashdata('msg', 'Message Deleted successfully.');
        redirect(base_url() . ADMIN_PUBLIC_DIR."/all_messages");

    }

}
