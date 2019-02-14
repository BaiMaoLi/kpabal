<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_ads extends My_controller {
	public $header_data, $footer_data;

	function __construct() {
		parent::__construct();

		$this->header_data = $this->__generate_header_data();
        $this->header_data['menuURL'] = "/ads";
        $this->header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $this->footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];
	}

	public function index(){
		
		// if(!$this->session->userdata('is_admin_login')){
		// 	redirect(base_url().'admin');
		// 	exit;
		// }
		$content = $this->ads_model->get_content();
		$data['title'] = SITE_NAME.': Ads Management';
		$data['msg'] = '';
		$data['content'] = $content->content;

		$this->load->view("admin/common/header", $this->header_data);
		$this->load->view('admin/edit_ads_view', $data);
        $this->load->view("admin/common/footer", $this->footer_data);

		return;
		
	}	
	
	public function update_data() {
		
		
		$contact_array = array('content' => $this->input->post('content'),
		);
		
		$this->ads_model->update_records($contact_array);
		$this->session->set_flashdata('msg', 'Updated Successfully.');
		redirect(base_url()."".ADMIN_PUBLIC_DIR."/ads");
	}
	
}
