<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_savings extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('savings_model');
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
    public function settings($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $api=$this->input->post("gmapi");
        if($api!=""){
            $this->savings_model->update_gmapi($api);
        }
        $distance=$this->input->post("distance");
        if($distance!=""){
            $this->savings_model->update_distance($distance);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/settings";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['gmapi']=$this->savings_model->get_gmapi();
        $data['distance']=$this->savings_model->get_distance();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/settings", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function stores($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/stores";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/stores", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/savings/table", "");
    }
    public function new_store($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/stores";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/new_stores", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function insert_store(){
        if($_FILES["store_logo"]["name"]!=""){
            $target_dir = 'assets/saving_store/';
            $filename=basename($_FILES["store_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["store_logo"]["tmp_name"], $target_file);
            $this->db->set('logo', $target_file);
        }
        if($_FILES["store_img"]["name"]!=""){
            $target_dir = 'assets/saving_store/';
            $filename=basename($_FILES["store_img"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["store_img"]["tmp_name"], $target_file);
            $this->db->set('img', $target_file);
        }
        $title=$this->input->post("title");
        $address=$this->input->post("address");
        $zipcode=$this->input->post("zipcode");
        $this->db->set("title",$title);
        $this->db->set("address",$address);
        $this->db->set("zipcode",$zipcode);
        $this->db->insert("savings_stores");
        redirect(ADMIN_PUBLIC_DIR."/savings/stores");
    }
    public function edit_store($id = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/stores";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores($id);
        $data['id']=$id;
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/edit_store", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_store(){
        if($_FILES["store_logo"]["name"]!=""){
            $target_dir = 'assets/saving_store/';
            $filename=basename($_FILES["store_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["store_logo"]["tmp_name"], $target_file);
            $this->db->set('logo', $target_file);
        }
        if($_FILES["store_img"]["name"]!=""){
            $target_dir = 'assets/saving_store/';
            $filename=basename($_FILES["store_img"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["store_img"]["tmp_name"], $target_file);
            $this->db->set('img', $target_file);
        }
        $id=$this->input->post("id");
        $title=$this->input->post("title");
        $address=$this->input->post("address");
        $zipcode=$this->input->post("zipcode");
        $this->db->set("title",$title);
        $this->db->set("address",$address);
        $this->db->set("zipcode",$zipcode);
        $this->db->where("id",$id);
        $this->db->update("savings_stores");
        redirect(ADMIN_PUBLIC_DIR."/savings/stores");
    }
    public function delete_store($id=""){
        $this->db->where("id",$id);
        $this->db->delete("savings_stores");
        redirect(ADMIN_PUBLIC_DIR."/savings/stores");
    }

    public function categories($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/categories";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_categories();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/categories", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/savings/table", "");
    }

    public function new_category($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_categories();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/new_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function insert_category(){
        $title=$this->input->post("title");
        $this->db->set("title",$title);
        $this->db->insert("savings_categories");
        redirect(ADMIN_PUBLIC_DIR."/savings/categories");
    }
    public function edit_category($id = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/stores";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_categories($id);
        $data['id']=$id;
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/edit_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_category(){
        $id=$this->input->post("id");
        $title=$this->input->post("title");
        $this->db->set("title",$title);
        $this->db->where("id",$id);
        $this->db->update("savings_categories");
        redirect(ADMIN_PUBLIC_DIR."/savings/categories");
    }
    public function delete_category($id=""){
        $this->db->where("id",$id);
        $this->db->delete("savings_categories");
        redirect(ADMIN_PUBLIC_DIR."/savings/categories");
    }
    public function products($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/products";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores();
        $data['categories']=$this->savings_model->get_categories();
        $data['products']=$this->savings_model->get_products();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/products", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/savings/table", "");
    }
    public function new_product($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/products";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores();
        $data['categories']=$this->savings_model->get_categories();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/new_product", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function insert_product(){
        if($_FILES["product_logo"]["name"]!=""){
            $target_dir = 'assets/saving_product_logos/';
            $filename=basename($_FILES["product_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["product_logo"]["tmp_name"], $target_file);
            $this->db->set('logo', $target_file);
        }
        $store=$this->input->post("store");
        $category=$this->input->post("category");
        $title=$this->input->post("title");
        $price=$this->input->post("price");
        $description=$this->input->post("description");
        $this->db->set("store",$store);
        $this->db->set("category",$category);
        $this->db->set("title",$title);
        $this->db->set("price",$price);
        $this->db->set("description",$description);
        $this->db->insert("savings_products");
        redirect(ADMIN_PUBLIC_DIR."/savings/products");
    }
    public function edit_product($id = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/savings/products";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['stores']=$this->savings_model->get_stores();
        $data['categories']=$this->savings_model->get_categories();
        $data['products']=$this->savings_model->get_products($id);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/savings/edit_product", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_product(){
        if($_FILES["product_logo"]["name"]!=""){
            $target_dir = 'assets/saving_product_logos/';
            $filename=basename($_FILES["product_logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["product_logo"]["tmp_name"], $target_file);
            $this->db->set('logo', $target_file);
        }
        $store=$this->input->post("store");
        $category=$this->input->post("category");
        $title=$this->input->post("title");
        $price=$this->input->post("price");
        $description=$this->input->post("description");
        $this->db->set("store",$store);
        $this->db->set("category",$category);
        $this->db->set("title",$title);
        $this->db->set("price",$price);
        $this->db->set("description",$description);
        $id=$this->input->post("id");
        $this->db->where("id",$id);
        $this->db->update("savings_products");
        redirect(ADMIN_PUBLIC_DIR."/savings/products");
    }
    public function delete_product($id=""){
        $this->db->where("id",$id);
        $this->db->delete("savings_products");
        redirect(ADMIN_PUBLIC_DIR."/savings/products");
    }
}
