<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_talky extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('talky_model');
    }

    public function __generate_header_data($open_title = "Management")
    {
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }
    public function category()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->talky_model->get_cat(0);
        foreach($data['p_cats'] as $s_cat){
            $data['s_cats'][$s_cat['id']]=$this->talky_model->get_cat($s_cat['id']);
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/category", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/js");
    }
    public function post_category()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->talky_model->get_cat(0);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/post_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function category_insert(){
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('parent', $this->input->post('parent'));
        $res = $this->db->insert('talky_category');
        redirect(ADMIN_PUBLIC_DIR."/talky/category");
    }
    public function edit_category($id=0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->talky_model->get_cat(0);

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("talky_category");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/edit_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_category(){
        $id=$this->input->post('id');
        if($id>0){
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('parent', $this->input->post('parent'));
            $this->db->where('id',$id);
            $res = $this->db->update('talky_category');
        }
        redirect(ADMIN_PUBLIC_DIR."/talky/category");
    }
    public function delete_category($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db->where('id', $id);
        $this->db->delete('talky_category');
        redirect(ADMIN_PUBLIC_DIR."/talky/category");
    }
    public function tags()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/tags";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['tags']=$this->talky_model->get_tags();

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/tags", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/js");
    }
    public function post_tag()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data=array();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/post_tag", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function insert_tag(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/talky_data/tags';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->talky_model->edit_tag($data);
        redirect(ADMIN_PUBLIC_DIR."/talky/tags/");
    }

    public function edit_tag($id="")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['tags']=$this->talky_model->get_tags($id);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/edit_tag", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }

    public function delete_tag($id){
        $this->db->where('id', $id);
        $this->db->delete('talky_tags');
        redirect(ADMIN_PUBLIC_DIR."/talky/tags/");
    }
    public function index($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['results']=$this->talky_model->get_search_talky();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/js");
    }
    public function new_talky()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/edit";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['cats']=$this->talky_model->get_cat(0);
        $data['tags_name']=$this->talky_model->get_tags();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/new", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/tagjs", $data);
    }
    public function edit($id="")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky/edit";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['cats']=$this->talky_model->get_cat(0);
        $data['tags_name']=$this->talky_model->get_tags();
        $data['talky']=$this->talky_model->get_search_talky($id);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/edit", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/tagjs", $data);
    }
    public function insert_talky(){
        $data=$this->input->post();
        //if($this->job_model->get_current_user()<1){
        //redirect("login/");
        //}else {
        if ($_FILES["talky_photo"]["name"] != "") {
            $target_dir = 'assets/talky_data/';
            $filename = basename($_FILES["talky_photo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $new_filename = strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename . "." . $imageFileType;
            move_uploaded_file($_FILES["talky_photo"]["tmp_name"], $target_file);
            $data['talky_photo'] = $target_file;
        }
        if ($_FILES["talky_video"]["name"] != "") {
            $target_dir = 'assets/talky_data/';
            $filename = basename($_FILES["talky_video"]["name"]);
            $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $new_filename = strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename . "." . $imageFileType;
            move_uploaded_file($_FILES["talky_video"]["tmp_name"], $target_file);
            $data['talky_video'] = $target_file;
        }
        $data['author'] = $this->job_model->get_current_user();
        $this->talky_model->edit_talky($data);
        redirect(ADMIN_PUBLIC_DIR."/talky/");
        //}
    }
    public function comments($id = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['results']=$this->talky_model->get_comments($id);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/comments", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/js");
    }
    public function edit_comment($id = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/talky";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['data']=$this->talky_model->get_comment($id);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/talky/edit_comment", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/talky/js");
    }
    public function delete_comment($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $talky=$this->talky_model->get_comment($id);
        $this->db->where('id', $id);
        $this->db->delete('talky_comment');
        redirect(ADMIN_PUBLIC_DIR."/talky/comments/".$talky[0]['talky_id']);
    }
    public function update_comment(){
        $id=$this->input->post('id');
        if($id>0){
            $this->db->set('comment_title', $this->input->post('comment_title'));
            $this->db->where('id',$id);
            $res = $this->db->update('talky_comment');
        }
        redirect(ADMIN_PUBLIC_DIR."/talky/comments/".$this->input->post('talky_id'));
    }
}
?>