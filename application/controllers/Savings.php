<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Savings extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->model('basis_model');
        $this->load->model('board_model');
        $this->load->model('category_model');
        $this->load->model('business_model');
        $this->load->model('savings_model');
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
    public function index($store = "")
    {
        $data['selected'] = 'savings';
        $header_data = $this->__generate_header_data("Savings");
        $footer_data = $this->__generate_footer_data();
        $land=$this->input->post("land");
        if($land=="land")$this->session->unset_userdata('selectedStore');
        $selectedStore=$this->session->userdata("selectedStore");
        if($selectedStore!=""){
            $this->db->select("*");
            $this->db->from("savings_stores");
            $this->db->where("id",$selectedStore);
            $res=$this->db->get();
            $data['selectedStoreData']=$res->result_array();
        }

        $postal_code=$this->input->post("postal_code");
        $data['searchStore']=0;
        if($postal_code!=""){
            $data['searchStore']=1;
        }else if($selectedStore!=""){
            $postal_code=$data['selectedStoreData'][0]['zipcode'];
        }
        $modal=array();
        $this->db->select("*");
        $this->db->from("savings_stores");
        $res=$this->db->get();
        $temp=array();
        $results=$res->result_array();
        if($postal_code!="") {
            foreach ($results as $result) {
                $temp['id'] = $result['id'];
                $temp['title'] = $result['title'];
                $temp['address'] = $result['address'];
                $dis = $this->savings_model->getDistance($postal_code, $result['zipcode'], "M");
                $max = $this->savings_model->get_distance();
                if ($dis <= $max) {
                    $temp['distance'] = number_format($dis, 2);
                    array_push($modal, $temp);
                }
            }
            $form_type=$this->input->post("form_type");
            if($form_type!="") $data['form_type']="modal";
        }
        $data['selectedStore']=$selectedStore;
        $data['modal']=$modal;
        $data['categories']=$this->savings_model->get_categories();
        $data['categoryData']=$this->savings_model->get_productsByCat();
        $data['stores']=$this->savings_model->get_stores();
        if($selectedStore>0)$data['storeData']=$this->savings_model->get_stores($selectedStore);
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/savings/index',$data);

        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/savings/index_js');
    }
    public function pdf($store = "")
    {
        $data['selected'] = 'savings';
        $header_data = $this->__generate_header_data("Savings");
        //$footer_data = $this->__generate_footer_data();


        $data['categories']=$this->savings_model->get_categories();
        $data['categoryData']=$this->savings_model->get_productsByCat();
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/savings/pdf',$data);
        //$this->load->view('kpabal/common/footer',$footer_data);
        //$this->load->view('frontend/savings/pdf_js');
    }
    public function page($cat = "")
    {
        $data['selected'] = 'savings';
        $header_data = $this->__generate_header_data("Savings");
        $footer_data = $this->__generate_footer_data();

        $selectedStore=$this->session->userdata("selectedStore");

        $this->db->select("*");
        $this->db->from("savings_products");
        $this->db->where("store",$selectedStore);
        if($cat!="")$this->db->where("category",$cat);
        $res=$this->db->get();
        $data['products']=$res->result_array();
        $data['categories']=$this->savings_model->get_categories();
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('frontend/savings/page',$data);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('frontend/savings/page_js');
    }
    public function selectedStore($id){
        $this->session->set_userdata("selectedStore",$id);
        redirect("savings/");
    }
}