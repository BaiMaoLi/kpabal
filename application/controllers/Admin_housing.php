<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_housing extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('housing_model');
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

    public function index($page = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $this->db->select("*");
        $this->db->from("housing");
        $this->db->order_by("createDate", "desc");
        $data['careers_occupation1']=0;
        $data['careers_occupation2']=0;
        $data['careers_type']=0;
        $data['company_location']=0;
        $data['keyword']="";
        if($this->input->post('careers_occupation2')>0){
            $this->db->where("subcat",$this->input->post('careers_occupation2'));
            $data['careers_occupation1']=$this->input->post('careers_occupation1');
            $data['careers_occupation2']=$this->input->post('careers_occupation2');
        }else if($this->input->post('careers_occupation1')>0){
            $this->db->where("category",$this->input->post('careers_occupation1'));
            $data['careers_occupation1']=$this->input->post('careers_occupation1');
        }
        if($this->input->post('company_location')>0){
            $this->db->where("location",$this->input->post('company_location'));
            $data['company_location']=$this->input->post('company_location');
        }
        if($this->input->post('keyword')!=""){
            $this->db->where("title like '%".$this->input->post('keyword')."%'");
            $data['keyword']=$this->input->post('keyword');
        }
        $res=$this->db->get();
        if($this->db->count_all_results()>0){
            $data['p_cats']=$this->housing_model->get_cat(0);
            if($data['careers_occupation1']>1){
                $data['s_cats']=$this->housing_model->get_cat($data['careers_occupation1']);
            }else{
                $data['s_cats']=$this->housing_model->get_cat(3);
            }

            //$data['j_types']=$this->housing_model->get_type();
            $data['s_cats']=$this->housing_model->get_cat(3);
            $data['locations']=$this->housing_model->get_locations();
            $search=$res->result_array();
            $result=array();
            if($page<1)$page=1;
            $idx=0;
            foreach($search as $sch){
                $idx++;
                if($idx>($page-1)*300 && $idx<=$page*300) {
                    $sch['category'] = $this->housing_model->get_cat_name($sch['subcat']);
                    $sch['author'] = $this->housing_model->get_user_name($sch['author']);
                    array_push($result, $sch);
                }
            }
            $data['data']=$result;
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/housing/js");
    }

    public function post()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['key']=$this->housing_model->get_gmapi();
        $data['p_cats']=$this->housing_model->get_cat(0);
        $data['s_cats']=$this->housing_model->get_cat(3);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/post", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }

    public function upload_avatar($id = 0)
    {

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_PRODUCT_DIR."/product_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id."_1.jpg");
        }
    }

    public function post_insert(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_rent($data);
        redirect(ADMIN_PUBLIC_DIR."/housing/");
    }
    public function delete_housing($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->housing_model->delete_rent($id);
        redirect(ADMIN_PUBLIC_DIR."/housing/");
    }
    public function edit($id=0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['key']=$this->housing_model->get_gmapi();

        $data['p_cats']=$this->housing_model->get_cat(0);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
            $data['s_cats']=$this->housing_model->get_cat(3);
        }
        //$this->load->view('housing_update',$data);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/edit", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }

    public function post_update(){

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_rent($data);
        redirect(ADMIN_PUBLIC_DIR."/housing/");
    }

    public function location()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/location";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['locations']=$this->housing_model->get_locations();
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/location", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/housing/js");
    }
    public function delete_location($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db->where('id', $id);
        $this->db->delete('housing_locations');
        redirect(ADMIN_PUBLIC_DIR."/housing/location");
    }
    public function post_location()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/housing";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/post_location", "");
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function location_insert(){
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('zip', $this->input->post('zip'));
        $res = $this->db->insert('housing_locations');
        redirect(ADMIN_PUBLIC_DIR."/housing/location");
    }
    public function edit_location($id=0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/housing";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->housing_model->get_cat(0);
        $data['locations']=$this->housing_model->get_locations();

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing_locations");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/edit_location", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_location(){
        $id=$this->input->post('id');
        if($id>0){
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('zip', $this->input->post('zip'));
            $this->db->where('id',$id);
            $res = $this->db->update('housing_locations');
        }
        redirect(ADMIN_PUBLIC_DIR."/housing/location");
    }
    public function category()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->housing_model->get_cat(0);
        foreach($data['p_cats'] as $s_cat){
            $data['s_cats'][$s_cat['id']]=$this->housing_model->get_cat($s_cat['id']);
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/category", $data);
        $this->load->view("admin/common/footer", $footer_data);
        //$this->load->view("admin/housing/js");
    }
    public function post_category()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->housing_model->get_cat(0);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/post_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function category_insert(){
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('parent', $this->input->post('parent'));
        $res = $this->db->insert('housing_cat');
        redirect(ADMIN_PUBLIC_DIR."/housing/category");
    }
    public function edit_category($id=0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/category";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $data['p_cats']=$this->housing_model->get_cat(0);

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing_cat");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/edit_category", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function update_category(){
        $id=$this->input->post('id');
        if($id>0){
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('parent', $this->input->post('parent'));
            $this->db->where('id',$id);
            $res = $this->db->update('housing_cat');
        }
        redirect(ADMIN_PUBLIC_DIR."/housing/category");
    }
    public function delete_category($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->db->where('id', $id);
        $this->db->delete('housing_cat');
        redirect(ADMIN_PUBLIC_DIR."/housing/category");
    }
    public function ajax_cat(){
        $id=$this->input->post("id");
        $html='';
        $cats=$this->housing_model->get_cat($id);
        foreach($cats as $cat){
            $html.='<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
        }
        echo $html;
    }
    public function sale()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/sale";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->db->select("*");
        $this->db->from("housing_sale");
        $this->db->order_by("id", "desc");
        $data['careers_occupation1']=0;
        $data['careers_occupation2']=0;
        $data['careers_type']=0;
        $data['company_location']=0;
        $data['keyword']="";
        if($this->input->post('careers_occupation2')>0){
            $this->db->where("subcat",$this->input->post('careers_occupation2'));
            $data['careers_occupation1']=$this->input->post('careers_occupation1');
            $data['careers_occupation2']=$this->input->post('careers_occupation2');
        }else if($this->input->post('careers_occupation1')>0){
            $this->db->where("category",$this->input->post('careers_occupation1'));
            $data['careers_occupation1']=$this->input->post('careers_occupation1');
        }
        if($this->input->post('company_location')>0){
            $this->db->where("location",$this->input->post('company_location'));
            $data['company_location']=$this->input->post('company_location');
        }
        if($this->input->post('keyword')!=""){
            $this->db->where("title like '%".$this->input->post('keyword')."%'");
            $data['keyword']=$this->input->post('keyword');
        }
        $res=$this->db->get();
        if($this->db->count_all_results()>0){
            $data['p_cats']=$this->housing_model->get_cat(0);
            if($data['careers_occupation1']>1){
                $data['s_cats']=$this->housing_model->get_cat($data['careers_occupation1']);
            }else{
                $data['s_cats']=$this->housing_model->get_cat(3);
            }

            //$data['j_types']=$this->housing_model->get_type();
            $data['s_cats']=$this->housing_model->get_cat(9);
            $data['locations']=$this->housing_model->get_locations();
            $search=$res->result_array();
            $result=array();
            foreach($search as $sch){
                $sch['category']=$this->housing_model->get_cat_name($sch['subcat']);
                $sch['author']=$this->housing_model->get_user_name($sch['author']);
                array_push($result,$sch);
            }
            $data['data']=$result;
        }
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/sale", $data);
        $this->load->view("admin/common/footer", $footer_data);
        //$this->load->view("admin/housing/js");
    }
    public function post_sale()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/sale";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['key']=$this->housing_model->get_gmapi();
        $data['p_cats']=$this->housing_model->get_cat(0);
        $data['s_cats']=$this->housing_model->get_cat(9);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/post_sale", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function post_sale_insert(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_sale($data);
        redirect(ADMIN_PUBLIC_DIR."/housing/sale/");
    }
    public function delete_housing_sale($id = 0){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $this->housing_model->delete_sale($id);
        redirect(ADMIN_PUBLIC_DIR."/housing/sale");
    }
    public function edit_sale($id=0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/housing/sale";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        $data['key']=$this->housing_model->get_gmapi();
        $data['s_cats']=$this->housing_model->get_cat(0);
        //$data['j_types']=$this->housing_model->get_type();
        $data['locations']=$this->housing_model->get_locations();

        //$id=$this->input->get('id');
        if($id>0){
            $this->db->select("*");
            $this->db->from("housing_sale");
            $this->db->where("id",$id);
            $res=$this->db->get();
            $data['data']=$res->result_array();
            $data['s_cats']=$this->housing_model->get_cat(9);
        }
        //$this->load->view('housing_update',$data);
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/housing/edit_sale", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    public function post_sale_update(){

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $data=$this->input->post();
        if($_FILES["logo"]["name"]!=""){
            $target_dir = 'assets/housing_logos/';
            $filename=basename($_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $new_filename=strtotime(date("Y-m-d H:i:s"));
            $target_file = $target_dir . $new_filename.".".$imageFileType;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            $data['logo']=$target_file;
        }
        $this->housing_model->edit_sale($data);
        redirect(ADMIN_PUBLIC_DIR."/housing/sale/");
    }
}
