<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_email_templates extends My_controller
{

    private $module_array = '';
    private $page_name    = 'email_templates';
    private $module_name  = 'Email Templates';

    public function __construct()
    {
        parent::__construct();
        $this->header_data                   = $this->__generate_header_data('email_templates');
        $this->header_data['menuURL']        = "/email_templates";
        $this->header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $this->footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
    }

    //List all Email Templates
    public function index()
    {
        $data                = array();
        $data['title']       = SITE_NAME . ' | ' . $this->module_name;
        $data['module_name'] = $this->module_name;
        $data['page_name']   = $this->page_name;
        $obj_result          = $this->email_templates_model->all_records(50, 0);
        $data['result']      = $obj_result;
        
        $this->load->view("admin/common/header", $this->header_data);
        $this->load->view('admin/' . $this->page_name . '/list_' . $this->page_name . '_view', $data);
        $this->load->view("admin/common/footer", $this->footer_data);
    }

    //Update
    public function update($id = '')
    {

        if ($id == '') {

            redirect(base_url(ADMIN_PUBLIC_DIR.'/' . $this->page_name . '/'));
        }

        $data                = array();
        $data['title']       = SITE_NAME . ' | Edit ' . $this->module_name;
        $data['page_name']   = $this->page_name;
        $data['module_name'] = $this->module_name;
        //Getting details
        $data['row'] = $this->email_templates_model->get_record_by_id($id);

        $this->form_validation->set_rules('email_name', 'email name', 'trim|required');
        $this->form_validation->set_rules('from_name', 'from name', 'trim|required');
        $this->form_validation->set_rules('from_email', 'from email', 'trim|required');
        $this->form_validation->set_rules('email_subject', 'email subject', 'trim|required');
        $this->form_validation->set_rules('editor1', 'email content', 'trim|required');
        $this->form_validation->set_error_delimiters('- ', '<br />');

        if ($this->form_validation->run() === false) {
        	$this->load->view("admin/common/header", $this->header_data);
            $this->load->view('admin/' . $this->page_name . '/edit_' . $this->page_name . '_view', $data);
            $this->load->view('admin/' . $this->page_name . '/edit_' . $this->page_name . '_view_js', $data);
        	$this->load->view("admin/common/footer", $this->footer_data);
            return;
        } else {
            $data_array = array(
                'email_name'    => $this->input->post('email_name'),
                'from_name'     => $this->input->post('from_name'),
                'from_email'    => $this->input->post('from_email'),
                'email_subject' => $this->input->post('email_subject'),
                'email_content' => $this->input->post('editor1'),
            );

            $this->email_templates_model->update($id, $data_array);
            $this->session->set_flashdata('msg', 'Updated Successfully.');
            redirect(base_url(ADMIN_PUBLIC_DIR.'/' . $this->page_name));
        }
    }

    //Preview
    public function preview($id)
    {
        $data                = array();
        $data['title']       = SITE_NAME . ' | ' . $this->module_name;
        $data['module_name'] = $this->module_name;
        $data['page_name']   = $this->page_name;
        $row                 = $this->email_templates_model->get_record_by_id($id);
        echo $row->email_content;
    }
}
