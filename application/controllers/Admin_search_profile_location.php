<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_search_profile_location extends My_controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->header_data                   = $this->__generate_header_data('Profile Management');
        $this->header_data['menuURL']        = "/search_profile_location";
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

		/*$profiles_view = $this->dating_member_model->get_all_profiles();
		$data['profiles_view']= $profiles_view;*/
		$data['title'] = SITE_NAME.': Search By location';
		$this->load->view("admin/common/header", $this->header_data);
		$this->load->view('admin/profile_searchlocation_view', $data);
		$this->load->view("admin/common/footer", $this->footer_data);
		return;
	}
	
	public function result_location(){
		
		// if(!$this->session->userdata('is_admin_login')){
		// 	redirect(base_url().'admin');
		// 	exit;
		// }
		
		$search = $this->input->post('search');
		
		$profiles_view = $this->dating_member_model->search_member_location($search);
		$data['profiles_view']= $profiles_view;
		$data['title'] = SITE_NAME.': Search Result';
		$data['heading'] = 'Location';
		$this->load->view("admin/common/header", $this->header_data);
		$this->load->view('admin/profile_search_view', $data);
		$this->load->view("admin/common/footer", $this->footer_data);
		return;
	}
		
}
