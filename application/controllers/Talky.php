<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Talky extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->model('basis_model');
        $this->load->model('board_model');
        $this->load->model('category_model');
        $this->load->model('business_model');
        $this->load->model('talky_model');
        $this->load->model('job_model');
    }
    public function __generate_header_data($caption = "") {
        $header_data = [];

        $header_data['loggedinuser'] = __get_user_session();
        $header_data['caption'] = $caption;
        $header_data['categories'] = $this->category_model->get_tree_rows_with_parent("site_menu", "01", true);
        $header_data['news_categories'] = $this->category_model->get_tree_rows("news_category", true);
        $header_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
        $header_data['notices'] = $this->basis_model->get_rows_total("site_notice", "", "page_date desc", 0, 5);

        return $header_data;
    }

    public function __generate_footer_data() {
        $footer_data = [];
        $footer_data['blog_categories'] = $this->category_model->get_rows("board_category");
        $footer_data['recent_business'] = $this->business_model->recent_business();
        $footer_data['total_business'] = $this->business_model->total_count();
        $footer_data['total_client'] = $footer_data['total_business'] + $this->member_model->total_count();

        return $footer_data;
    }
    public function index($tag = "")
    {
        $data['selected'] = 'talky';
        $header_data = $this->__generate_header_data("talky");
        $footer_data = $this->__generate_footer_data();

        $cat=$this->input->post('sort');
        $keyword=$this->input->post('keyword');
        $data['results']=$this->talky_model->get_search_talky("",$cat,$keyword,$tag);
        $data['cats']=$this->talky_model->get_cat(0);
        $data['tags_name']=$this->talky_model->get_tags();
        $data['active_tags']=$this->talky_model->get_active_tags();
        $data['current_user']=$this->job_model->get_current_user();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/talky/index',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/talky/index_js');
    }
    public function detail($id = "")
    {
        $data['selected'] = 'talky';
        $header_data = $this->__generate_header_data("talky");
        $footer_data = $this->__generate_footer_data();
        $data['id']=$id;
        $data['cats']=$this->talky_model->get_cat(0);
        $cat=$this->input->post('sort');
        $keyword=$this->input->post('keyword');
        $data['results']=$this->talky_model->get_search_talky($id,$cat,$keyword);
        $data['results1']=$this->talky_model->get_search_talky_by_category($data['results'][0]['category']);
        $data['tags_name']=$this->talky_model->get_tags();
        $data['current_user']=$this->job_model->get_current_user();

        $this->db->set("views","views+1", FALSE);
        $this->db->where("id",$id);
        $this->db->update("talky");
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/talky/detail',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/talky/index_js');
    }
    public function update_like($id=""){
        $this->db->set("likes","likes+1", FALSE);
        $this->db->where("id",$id);
        $this->db->update("talky");

        $this->db->select("likes");
        $this->db->where("id",$id);
        $this->db->from("talky");
        $res=$this->db->get();
        $return=$res->result_array();
        echo $return[0]['likes'];
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
            redirect("talky/");
        //}
    }

    public function load(){

    }
    public function view_list($id=""){
        echo $this->talky_model->view_list($id);
    }
    public function insert_comment(){
        $post=$this->input->post();
        $post['author'] = $this->job_model->get_current_user();
        $this->talky_model->insert_comment($post);
        redirect("talky/detail/".$post['id']);
    }
}