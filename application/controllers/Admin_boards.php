<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_boards extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
        $this->load->model('board_model');
    }
    
    public function __generate_header_data($open_title = "Management")
    {
        $header_data['memberIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

    public function index($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/boards";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("board_category");
        $data['boards'] = $this->board_model->get_items($this->category_model->list_data("board_category"), $this->member_model->list_data(), $category);
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/board/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/board/index_js");
    }

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/boards";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['board'] = $this->board_model->get_item($id);
        $data['categories'] = $this->category_model->get_tree_rows("board_category");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/board/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/board/edit_index_js", $data);
    }

    public function reply_list($articleIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/boards";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['boards'] = $this->board_model->get_replies($this->member_model->list_data(), $articleIdx);
        $data['articleIdx'] = $articleIdx;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/board/reply_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/board/reply_index_js");
    }

    public function upload_attach($articleIdx = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_BOARD_DIR."/article_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$articleIdx.".jpg");
        } 
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->board_model->save_data($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }
    }

    public function get_reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->board_model->get_reply_content($_POST);
        }        
    }

    public function update_reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->board_model->update_reply($_POST);
        }
    }

    public function reply_reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->board_model->save_reply_reply($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }
    }

    public function remove_article()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $articleIdx = $this->input->post("articleIdx");
            $this->board_model->remove_article($articleIdx);
        }        
    }

    public function remove_reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $articleIdx = $this->input->post("articleIdx");
            $id = $this->input->post("id");
            $this->board_model->remove_reply($articleIdx, $id);
        }        
    }

    public function list_article()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $category = $this->input->post("category");
            $articles = $this->board_model->get_items($this->category_model->list_data("board_category"), $this->member_model->list_data(), $category);
            $boards = [];
            foreach ($articles as $article) {
                $boards[] = array( $article->article_title, $article->categoryName, $article->memberName, $article->regDate, $article->id );
            }
            echo json_encode($boards);
        }
    }

    public function list_reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $articleIdx = $this->input->post("articleIdx");
            $replies = $this->board_model->get_replies($this->member_model->list_data(), $articleIdx);
            $boards = [];
            foreach ($replies as $reply) {
                $boards[] = array( $reply->reply_content, $reply->memberName, $reply->regDate, $reply->id );
            }
            echo json_encode($boards);
        }
    }

    public function reply()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->board_model->save_reply($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }
    }

}
