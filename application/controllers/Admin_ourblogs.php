<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ourblogs extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));

        $this->load->library('form_validation');
		
		$this->load->library('session');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('restaurant_model');
        $this->load->model('ourblog_model');
	}
	
    public function __generate_header_data($open_title = "Our Blogs")
    {
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
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
        $header_data['menuURL'] = "/ourblogs";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

		$data['list_blogs'] = $this->ourblog_model->get_blogs();
		  
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/ourblog/index", $data);
		$this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/ourblog/js");
	}
 
 
	public function delete_blog(){ 
	
	$blog_id = $this->uri->segment(4);
	
		
	$res = $this->ourblog_model->delte_blog($blog_id);
	
			
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/ourblogs/");
	}
	
		
	}
	
	
	public function approved_blog(){ 
	
	$blog_id = $this->uri->segment(4);
	
	
	$res = $this->ourblog_model->approved_blog($blog_id);
	
			
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/ourblogs/");
	}
	
		
	}
	
	public function disapproved_blog(){ 
	
	$blog_id = $this->uri->segment(4);
	
	
	$res = $this->ourblog_model->disapproved_blog($blog_id);
	
			
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/ourblogs/");
	}
	
	}
	
	public function update_blog(){ 
	
	if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
		
		
	$getBlogInfo = $this->input->post(); 
	unset($getBlogInfo['update_blog']);
	//$blog_id = $this->input->post('blog_id');		
			
	$res = $this->ourblog_model->update_blog($getBlogInfo);
	
			
	if($res){
		
		redirect(ADMIN_PUBLIC_DIR."/ourblogs/");
	}
		
		
	
	}
	
 
		
}
