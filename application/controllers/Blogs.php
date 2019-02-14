<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Blogs extends REST_Controller {

        function __construct() {
                parent::__construct();
        }

        public function index_get()
        {
                $header_data = $this->__generate_header_data("Landing Page");
                $footer_data = $this->__generate_footer_data($header_data);
                $data 		 = $this->__generate_side_data($header_data);

                $data['home_sliders'] = $this->basis_model->get_categories("site_contents", "01", true);
                $data['best_articles'] = $this->board_model->get_prior_articles("view_count desc");
                $data['best_articles2'] = $this->board_model->get_prior_articles("reply_count desc");

                $blog_categories = $header_data['blog_categories'];
                $arr_members = $this->member_model->list_data();
                $arr_categories = $this->category_model->list_data("board_category", true);

                foreach ($blog_categories as $category) {
                        $category->articles = $this->board_model->search_articles($arr_categories, $arr_members, $category->categoryIdx, "", 0, 5);
                }

                $data['blog_categories'] = $blog_categories;

                $header_data['additional_css'] = [

                ];

                $footer_data['additional_js'] = [

                ];

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/boards/index', $data);
                $this->load->view('kpabal/common/footer', $footer_data);
        }

        public function category_get($categoryIdx = 0)
        {
                $header_data = $this->__generate_header_data("Landing Page");
                $footer_data = $this->__generate_footer_data($header_data);
                $data 		 = $this->__generate_side_data($header_data);

                $arr_categories = $this->category_model->list_data("board_category", true);        

                $data['categoryInfo'] = $this->board_model->get_category_info($categoryIdx);
                $data['categoryIdx'] = $categoryIdx;

                $arr_members = $this->member_model->list_data();
                $offset = 10;

                $data['articles'] = $this->board_model->search_articles($arr_categories, $arr_members, $categoryIdx, "", 0, $offset);
                $articleCount = $this->board_model->search_articles_count($arr_categories, $categoryIdx, "");
                $data['totalPages'] = ($articleCount - 1 - (($articleCount - 1) % $offset)) / $offset + 1;
                $member = $this->general->user_logged_in();
                $memberIdx = $member->memberIdx;
                $data['memberIdx'] = $memberIdx;

                $header_data['additional_css'] = [

                ];

                $footer_data['additional_js'] = [

                ];

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/boards/category', $data);
                $this->load->view('kpabal/common/footer', $footer_data);
                $this->load->view('kpabal/boards/category_js', $data);
        }

        public function search_post($categoryIdx = 0)
        {
                $field = $this->post("field");
                $keyword = $this->post("keyword");
                $page_number = $this->post("page_number");

                $offset = 10;

                $arr_categories = $this->category_model->list_data("board_category", true);
                $data['articles'] = $this->board_model->search_articles($arr_categories, $this->member_model->list_data(), $categoryIdx, $keyword, $page_number, $offset, $field);
                $articleCount = $this->board_model->search_articles_count($arr_categories, $categoryIdx, $keyword, $field);
                $data['totalPages'] = ($articleCount - 1 - (($articleCount - 1) % $offset)) / $offset + 1;

                $this->load->view("kpabal/boards/search", $data);
        }

        public function article_get($articleIdx = 0)
        {
                $header_data = $this->__generate_header_data("Landing Page");
                $footer_data = $this->__generate_footer_data($header_data);
                $data 		 = $this->__generate_side_data($header_data);

                $header_data['additional_css'] = [

                ];

                $footer_data['additional_js'] = [

                ];
                $member = $this->general->user_logged_in();
                $memberIdx = $member->memberIdx;

                $arr_members = $this->member_model->list_data();
                $arr_categories = $this->category_model->list_data("board_category", true);
                $article = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $articleIdx);
                $data['memberIdx'] = $memberIdx;
                $data['article'] = $article;
                $data['attachment'] = $this->board_model->get_attachment($articleIdx);
                $prev_articleIdx = $this->board_model->get_prev_article($article->categoryIdx, $articleIdx);
                $next_articleIdx = $this->board_model->get_next_article($article->categoryIdx, $articleIdx);
                if($prev_articleIdx !== false) $data['prev_article'] = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $prev_articleIdx);
                if($next_articleIdx !== false) $data['next_article'] = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $next_articleIdx);

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/boards/article', $data);
                $this->load->view('kpabal/common/footer', $footer_data);
                $this->load->view('kpabal/boards/article_js', $data);
        }

        public function article_new_get($categoryIdx = 0)
        {
                $header_data = $this->__generate_header_data("Landing Page");
                $footer_data = $this->__generate_footer_data($header_data);
                $data 		 = $this->__generate_side_data($header_data);

                $header_data['additional_css'] = [

                ];

                $footer_data['additional_js'] = [

                ];

                $member = $this->general->user_logged_in();
                if(!$member) exit();
                $data["categoryIdx"] = $categoryIdx;

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/boards/register', $data);
                $this->load->view('kpabal/common/footer', $footer_data);
                $this->load->view('kpabal/boards/register_js', $data);
        }

        public function article_edit_get($articleIdx = 0)
        {
                $header_data = $this->__generate_header_data("Landing Page");
                $footer_data = $this->__generate_footer_data($header_data);
                $data        = $this->__generate_side_data($header_data);

                $header_data['additional_css'] = [
                ];

                $footer_data['additional_js'] = [
                ];

                $member = $this->general->user_logged_in();
                $memberIdx = $member->memberIdx;

                $arr_members = $this->member_model->list_data();
                $arr_categories = $this->category_model->list_data("board_category", true);
                $article = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $articleIdx);
                if($memberIdx != $article->memberIdx) exit();
                $data['article'] = $article;

                $this->load->view('kpabal/common/header',$header_data);
                $this->load->view('kpabal/boards/edit', $data);
                $this->load->view('kpabal/common/footer', $footer_data);
                $this->load->view('kpabal/boards/edit_js', $data);
        }

        public function article_comments_post($articleIdx=0, $page_num=0)
        {
                $member = $this->general->user_logged_in();
                $data['memberIdx'] = $member->memberIdx;

                $offset = 5;
                $comments = $this->board_model->get_article_comments($this->member_model->list_data(), $articleIdx, $page_num, $offset);
                $total_count = $this->board_model->get_article_comments_count($articleIdx);
                $totalPages = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
                $data['is_more'] = ($totalPages > $page_num + 1);
                $data['comments'] = $comments;

                $this->load->view("kpabal/boards/comments", $data);
        }

        public function article_save_post($articleIdx = 0)
        {
                $member = $this->general->user_logged_in();
                $memberIdx = $member->memberIdx;

                $arr_members = $this->member_model->list_data();
                $arr_categories = $this->category_model->list_data("board_category", true);
                $article = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $articleIdx);
                if($memberIdx != $article->memberIdx) exit();

                $row["id"] = $articleIdx;
                $row["article_title"] = $this->input->post("article_title");
                $row["article_content"] = $this->input->post("article_content");

                $this->board_model->save_data($row, $memberIdx);
        }

        public function article_register_post($categoryIdx = 0)
        {
                $member = $this->general->user_logged_in();
                if(!$member) exit();
                $memberIdx = $member->memberIdx;

                $arr_members = $this->member_model->list_data();
                $arr_categories = $this->category_model->list_data("board_category", true);
                $article = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $articleIdx);                

                $row["categoryIdx"] = $categoryIdx;
                $row["article_title"] = $this->input->post("article_title");
                $row["article_content"] = $this->input->post("article_content");

                $articleIdx = $this->board_model->save_data($row, $memberIdx);
                echo $articleIdx;
                if($articleIdx) {
                       $id = $this->input->post("upload_id_1");
                       if($id) $this->board_model->update_upload_file($articleIdx, $id);
                       echo $id;
                       $id = $this->input->post("upload_id_2");
                       if($id) $this->board_model->update_upload_file($articleIdx, $id);
                       echo $id;
                }
        }


        public function upload_attach_post()
        {
                $id = $this->board_model->register_upload_file($_FILES["uploadedFile"]["name"]);
                $target_file = FCPATH.PROJECT_BOARD_DIR."/article_attach_";
                move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id);
                echo $id;
        }
}
