<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
		$this->load->model('login_model');
		$this->load->model('member_model');
		$this->load->model('basis_model');
		$this->load->model('board_model');
		$this->load->model('category_model');
		$this->load->model('business_model');
		$this->load->model('product_model');
		$this->load->model('news_model');
		$this->load->model('job_model');
		$this->load->model('housing_model');
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

    public function __generate_footer_data($header) {
        $footer_data = [];
        $footer_data['categories'] = $header['categories'];
        $footer_data['footers'] = $this->category_model->get_tree_rows_with_parent("site_menu", "02", true);

        return $footer_data;
    }

    public function daily_news()
    {
    	echo @file_get_contents(PROJECT_MEDIA_DIR."/daily_news.html");
    }
    public function viewvideo(){
        $this->view->load(('kpabal/viewvideo/index'););
    }
	public function index()
	{
		$header_data = $this->__generate_header_data("Landing Page");
		$footer_data = $this->__generate_footer_data($header_data);

		$data['notices'] = $header_data['notices'];
		$data['ranking_members'] = $this->member_model->get_ranking_members();
		$data['home_sliders'] = $this->basis_model->get_categories("site_contents", "01", true);
		$data['sidebar_sliders'] = $this->basis_model->get_categories("site_contents", "02", true);
		$data['products'] = $this->product_model->get_recent_items($this->category_model->list_data("products_category"));
        $arr_categories = $this->category_model->list_data("board_category", true);
        //$data['articles'] = $this->board_model->get_suggest_articles($arr_categories, $this->member_model->list_data(), "");
        $data['best_articles'] = $this->board_model->get_prior_articles("view_count desc");
        $data['best_articles2'] = $this->board_model->get_prior_articles("reply_count desc");
        $data['side_articles1'] = $this->board_model->get_prior_articles("(good_count - bad_count) desc");
        $data['side_articles2'] = $this->board_model->get_prior_articles("article_date desc");
        $data['side_articles3'] = $this->board_model->get_prior_replies("reply_date desc");
        $data['video_news'] = $this->news_model->get_news_for_category("11", 8);
        $data['daily_news_html'] = @file_get_contents(PROJECT_MEDIA_DIR."/daily_news.html");

        $news_categories = $header_data['news_categories'];
        foreach ($news_categories as $category) {
        	$category->news = $this->basis_model->get_rows_total("news", $category->categoryIdx, "article_date desc", 0, 5);
        }

        $data['news_categories'] = $news_categories;

        $blog_categories = $header_data['blog_categories'];
        $arr_members = $this->member_model->list_data();
        $arr_categories = $this->category_model->list_data("board_category", true);

        foreach ($blog_categories as $category) {
                $category->articles = $this->board_model->search_articles($arr_categories, $arr_members, $category->categoryIdx, "", 0, 5);
        }

        $data['blog_categories'] = $blog_categories;

		$header_data['loggedinuser'] = $data['loggedinuser'] = __get_user_session();
        $header_data['additional_css'] = [
                
        	];

        $footer_data['additional_js'] = [
                
        	];
        $data['jobs'] = $this->job_model->get_pre_jobs();
        if(count($data['jobs'])==0){
            $data['jobs'] = $this->job_model->get_jobs();
        }
        $data['persons'] = $this->job_model->get_pre_persons();

        if(count($data['persons'])==0){
            $data['persons'] = $this->job_model->get_persons();
        }
        $data['rents']=$this->housing_model->get_recent_rent();
        $data['sales']=$this->housing_model->get_recent_sale();
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
        $this->load->view('kpabal/index_js');
	}

	public function login(){
		if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
		}
		$header_data = $this->__generate_header_data("Landing Page");
		
		$footer_data = $this->__generate_footer_data($header_data);

		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/user/login',$data);
		$this->load->view('kpabal/common/footer', $footer_data);
	}

	public function register(){
		if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
		// if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
		// 	$rlt = $this->member_model->save_cdata($_POST);
			
		// 	if($rlt == -1){
		// 		$this->session->set_flashdata('register_message', 'User already exist');
		// 		$data['result'] = 0;
		// 	}
		// 	else{
		// 		$this->session->set_flashdata('register_message', 'You successfully registered!');
		// 		$data['result'] = 1;
		// 	}
		// }
		$header_data = $this->__generate_header_data("Landing Page");
		
		$footer_data = $this->__generate_footer_data($header_data);
		// $header_data = array('selected' => 'register');
		//$data['message'] = $this->session->flashdata('register_message');
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/user/register',$data);
		$this->load->view('kpabal/common/footer');
		$this->load->view("kpabal/user/register_js", $data);
	}
	
	public function logout() {
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate');

        $this->session->set_flashdata('login_message', '');
        $this->_clean_cookie_();
        redirect('/');
        exit;
	}

	public function _clean_cookie_() {
        $this->load->helper('cookie');
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION);
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION . 'email');
	}
	
	public function profile(){
		if (!$this->general->frontend_controlpanel_logged_in()) {
            redirect(FRONTEND_LOGIN_PUBLIC_DIR);
		}
		
		$header_data = $this->__generate_header_data("Landing Page");
		$header_data['loggedinuser'] = __get_user_session();
		$memberIdx = $header_data['loggedinuser']['memberIdx'];
		$data['member'] = $this->member_model->get_item($memberIdx);
		$data['states'] = $this->category_model->get_tree_rows("address_state");
		$footer_data = $this->__generate_footer_data($header_data);
		$footer_data['additional_js'] = [
		];
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/user/profile',$data);
		$this->load->view('kpabal/common/footer',$footer_data);
		$this->load->view("kpabal/user/profile_js", $data);
	}

	public function forgot_password(){
		
		$header_data = $this->__generate_header_data("Landing Page");
		$footer_data = $this->__generate_footer_data($header_data);
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/user/forgotpassword',$data);
		$this->load->view('kpabal/common/footer',$footer_data);
		$this->load->view("kpabal/user/forgotpassword_js", $data);
	}

}
