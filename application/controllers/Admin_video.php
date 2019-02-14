<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_video extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('savings_model');
        $this->load->model('kpabal_model');
    }

    public function __generate_header_data($open_title = "Management") {
   
        //$header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }
    
    public function news(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/news";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/table");
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/common/news_js");
        
    }

    public function sport(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/sport";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/table");
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/common/sports_js");
    }
    
    public function music(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/music";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/table");
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/common/music_js");
    }
    
    public function trending(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/trending";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/table");
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/common/trending_js");
    }
    
    public function drama(){
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/drama";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/table_drama");
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/common/drama_js");
    }
    
    public function news_pageData() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //print_r($length);
        if($start != 0){
            $start_offset = ($start-1) * $length;
        }       
        $totalCount = $this->kpabal_model->get_news_totalCount();
        $news_pageData = $this->kpabal_model->get_news_pageData($start_offset,$length);

        foreach ($news_pageData as $one) {
            $data[] = array(
                '<img src="'.$one["image"].'" style="width:100%;" />',
                $one['title'],
                $one['likes'],
                $one['api_type'],
                $one['video_id'],
                $one['duration'],
                $one['create_date'],
                '<a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_product/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_done/news/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done"><i class="far fa-check-circle"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/delete_product/news/'.$one["vc_id"].'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove Record"></i></a>'
            );
        }
        $output = array('draw' => $draw, 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalCount, 'data' => $data);
          echo json_encode($output);
          exit(); 
    }
    
    public function sport_pageData() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //print_r($length);
        if($start != 0){
            $start_offset = ($start-1) * $length;
        }       
        
        $news_pageData = $this->kpabal_model->get_sports_pageData($start_offset,$length);
        $totalCount = $this->kpabal_model->get_sports_totalCount();
        foreach ($news_pageData as $one) {
            $data[] = array(
                '<img src="'.$one["image"].'" style="width:100%;" />',
                $one['title'],
                $one['likes'],
                $one['api_type'],
                $one['video_id'],
                $one['duration'],
                $one['create_date'],
                '<a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_product/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_done/news/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done"><i class="far fa-check-circle"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/delete_product/news/'.$one["vc_id"].'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove Record"></i></a>'
            );
        }
        $output = array('draw' => $draw, 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalCount, 'data' => $data);
          echo json_encode($output);
          exit(); 
    }
    
    public function music_pageData() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //print_r($length);
        if($start != 0){
            $start_offset = ($start-1) * $length;
        }       
        
        $news_pageData = $this->kpabal_model->get_music_pageData($start_offset,$length);
        $totalCount = $this->kpabal_model->get_music_totalCount();
        foreach ($news_pageData as $one) {
            $data[] = array(
                '<img src="'.$one["image"].'" style="width:100%;" />',
                $one['title'],
                $one['likes'],
                $one['api_type'],
                $one['video_id'],
                $one['duration'],
                $one['create_date'],
                '<a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_product/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_done/news/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done"><i class="far fa-check-circle"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/delete_product/news/'.$one["vc_id"].'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove Record"></i></a>'
            );
        }
        $output = array('draw' => $draw, 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalCount, 'data' => $data);
          echo json_encode($output);
          exit(); 
    }
    
    public function trending_pageData() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //print_r($length);
        if($start != 0){
            $start_offset = ($start-1) * $length;
        }       
        
        $news_pageData = $this->kpabal_model->get_trending_pageData($start_offset,$length);
        $totalCount = $this->kpabal_model->get_trending_totalCount();
        foreach ($news_pageData as $one) {
            $data[] = array(
                '<img src="'.$one["image"].'" style="width:100%;" />',
                $one['title'],
                $one['likes'],
                $one['api_type'],
                $one['video_id'],
                $one['duration'],
                $one['create_date'],
                '<a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_product/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_done/news/'.$one["vc_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done"><i class="far fa-check-circle"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/delete_product/news/'.$one["vc_id"].'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove Record"></i></a>'
            );
        }
        $output = array('draw' => $draw, 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalCount, 'data' => $data);
          echo json_encode($output);
          exit(); 
    }
    
    public function drama_pageData() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        //print_r($length);
        if($start != 0){
            $start_offset = ($start-1) * $length;
        }       
        
        $news_pageData = $this->kpabal_model->get_drama_pageData($start_offset,$length);
        $totalCount = $this->kpabal_model->get_drama_totalCount();
        foreach ($news_pageData as $one) {
            $data[] = array(
                '<img src="'.$one["image_url"].'" style="width:100%;" />',
                $one['scrap_title'],
                $one['scrap_sub_link'],
                $one['scrap_date'],
                '<a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_drama/'.$one["scrap_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update Detail">
                                    <i class="la la-edit"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/edit_drama_done/'.$one["scrap_id"].'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Modify Done"><i class="far fa-check-circle"></i> </a><a href="'.ROOTPATH.ADMIN_PUBLIC_DIR.'/video/delete_drama/'.$one["scrap_id"].'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove" title="Remove Record"></i></a>'
            );
        }
        $output = array('draw' => $draw, 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalCount, 'data' => $data);
          echo json_encode($output);
          exit(); 
    }
    
    public function edit_product($id = ""){
       if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/products";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        //$data['stores']=$this->video_model->get_stores();
        $temp = array();
        $data['categories']=$this->kpabal_model->get_category();
        $data['video_info']=$this->kpabal_model->get_videoinfo($id);
        //print_r($data['video_info']);exit();
        //$data['main_cate'] = array_keys($data['categories']['category']);
        foreach ($data['categories']['category'] as $one) {
            array_push($temp, $one['cate_name']);
        }
        $data['main_cate'] = $temp;
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/edit_video", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    
    public function edit_drama($id = ""){
       if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/video/products";
        $header_data['additional_css'] = [
            "assets/vendors/custom/datatables/datatables.bundle.css",
        ];
        $footer_data['additional_js'] = [
            "assets/vendors/custom/datatables/datatables.bundle.js",
        ];

        //$data['stores']=$this->video_model->get_stores();
        $temp = array();
        $data['sub_links']=$this->kpabal_model->get_drama_sublinks($id);
        $data['video_info']=$this->kpabal_model->get_drama_info($id);
        //print_r($data);exit();
        //$data['main_cate'] = array_keys($data['categories']['category']);
        foreach ($data['categories']['category'] as $one) {
            array_push($temp, $one['cate_name']);
        }
        $data['main_cate'] = $temp;
        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/video/edit_drama", $data);
        $this->load->view("admin/common/footer", $footer_data);
    }
    
    public function update_drama(){
        //print_r("expression");exit();
        //print_r(base_url(ADMIN_PUBLIC_DIR.'/video/drama'));exit;
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $sub_link=$this->input->post("sublink");
        $title=$this->input->post("title");
        $video_id=$this->input->post("video_id");
        
        $tv_db->set("scrap_sub_link",$sub_link);
        $tv_db->set("title",$title);
        $tv_db->where("scrap_id",$video_id);
        $temp = $tv_db->update("tai_information");
        // redirect(base_url(ADMIN_PUBLIC_DIR.'/video/drama'));
        $this->drama();
 
    }
    
    public function update_product(){
        //print_r("expression");exit();
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $category=$this->input->post("category");
        $subcategory=$this->input->post("subcategory");
        $title=$this->input->post("title");
        $video_id=$this->input->post("video_id");
        //print_r($title);exit();
        if($category == "news") {
            //print_r($subcategory);exit();
            $tv_db->select("news_id");
            $tv_db->from("tai_news");
            $tv_db->where("news_name",$subcategory);
            $query = $tv_db->get()->result_array();
            $news_id = $query[0]['news_id'];
            //print_r($video_id);exit();
            $tv_db->set("news_id",$news_id);
            $tv_db->set("country_id",'0');
            $tv_db->set("category_id",'0');
            $tv_db->set("title",$title);
            $tv_db->where("video_id",$video_id);
            $temp = $tv_db->update("tai_information");
            //print_r($temp);exit();
            //redirect(ADMIN_PUBLIC_DIR."/video/news");
            $this->news();

        }else 
        {
            //print_r($subcategory);exit();
            $tv_db->select("country_id");
            $tv_db->from("tai_country");
            $tv_db->where("country_name",$subcategory);
            $query = $tv_db->get()->result_array();
            $country_id = $query[0]['country_id'];
            //print_r($country_id);exit();
            $tv_db->select("cate_id,cate_name");
            $tv_db->from("tai_category");
            $tv_db->where("cate_name",$category);
            $query = $tv_db->get()->result_array();
            $cate_id = $query[0]['cate_id'];
            $cate_name =$query[0]['cate_name'];
            //print_r(site_url("video/sport"));
            //print_r($country_id);
            //print_r($cate_id);
            //exit();
            $tv_db->set("news_id",'0');
            $tv_db->set("country_id",$country_id);
            $tv_db->set("category_id",$cate_id);
            $tv_db->set("title",$title);
            $tv_db->where("video_id",$video_id);
            $temp = $tv_db->update("tai_information");
            //print_r($temp);
            redirect(ADMIN_PUBLIC_DIR."/video/sport");
            
        }
        //print_r($temp);exit();
        
    }
    

}
