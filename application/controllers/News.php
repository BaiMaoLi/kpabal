<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class News extends REST_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index_get($id = 0)
	{
        $header_data = $this->__generate_header_data("News");
        $header_data['additional_css'] = [
            ROOTPATH.PROJECT_CSS_DIR."news.css",
        ];
		$footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        if($id == 0) {
            $news = $this->news_model->get_news_for_landing();
            $data['news'] = $news;

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/news/index',$data);
            $this->load->view('kpabal/common/footer',$footer_data);
        } else {
            $offset = 12;
            $total_count = $this->news_model->get_total_news_for_category($id);
            $total_page = 0;
            if($total_count > 1) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
            $data['news'] = $this->news_model->get_news_for_category($id, $offset);
            $data['categoryIdx'] = $id;
            $data['total_page'] = $total_page;

            $this->load->view('kpabal/common/header',$header_data);
            $this->load->view('kpabal/news/category',$data);
            $this->load->view('kpabal/common/footer',$footer_data);
            $this->load->view('kpabal/news/category_js', $data);
        }
    }

    public function search_post($categoryIdx=0, $page_number=1)
    {
        $offset = 12;
        $total_count = $this->news_model->get_total_news_for_category($categoryIdx);
        $total_page = 0;
        if($total_count > 1) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $result = $this->news_model->get_page_news_for_category($categoryIdx, $page_number, $offset);

        $data = [
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $result,
        ];

        $this->load->view('kpabal/news/search_list', $data);
    }
}