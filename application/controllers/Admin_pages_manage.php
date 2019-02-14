<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_pages_manage extends My_controller
{

    public function __construct()
    {
        parent::__construct();

        $this->header_data                   = $this->__generate_header_data();
        $this->header_data['menuURL']        = "/pages_manage";
        $this->header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $this->footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
    }

    public function index()
    {

        $result = $this->contact_model->getAllPageContent();

        $data['title']  = SITE_NAME . ': CMS';
        $data['msg']    = '';
        $data['result'] = $result;

        $this->load->view("admin/common/header", $this->header_data);
        $this->load->view('admin/manage_cms', $data);
        $this->load->view("admin/common/footer", $this->footer_data);
        return;

    }

    public function edit($id)
    {

        if (!$id) {
            redirect(base_url()."".ADMIN_PUBLIC_DIR.'/pages_manage');
            exit;
        }

        $content = $this->contact_model->getPageContent($id);
        $data['title']              = SITE_NAME . ': CMS';
        $data['msg']                = '';
        $data['cms_id']             = $id;
        $data['page_meta_title']    = $content->page_meta_title;
        $data['page_meta_keywords'] = $content->page_meta_keywords;
        $data['page_meta_desc']     = $content->page_meta_desc;

        $data['content'] = $content->content;

        $this->load->view("admin/common/header", $this->header_data);
        $this->load->view('admin/edit_cms_view', $data);
        $this->load->view('admin/edit_cms_view_js');
        $this->load->view("admin/common/footer", $this->footer_data);
        return;

    }

    public function update_cms($id)
    {

        if (!$id) {
            redirect(base_url()."".ADMIN_PUBLIC_DIR.'/pages_manage');
            exit;
        }

        $contact_array = array(
            'content'            => addslashes($this->input->post('editor1')),
            'page_meta_title'    => addslashes($this->input->post('page_meta_title')),
            'page_meta_keywords' => addslashes($this->input->post('page_meta_keywords')),
            'page_meta_desc'     => addslashes($this->input->post('page_meta_desc')),
        );

        $this->contact_model->update_content($id, $contact_array);
        $this->session->set_flashdata('msg', 'Content Updated Successfully.');
        redirect(base_url()."".ADMIN_PUBLIC_DIR."/pages_manage/edit/". $id);
    }

}
