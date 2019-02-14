<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use Goutte\Client;
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
		$this->load->model('scrap_model');
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

    public function daily_news(){
    	echo @file_get_contents(PROJECT_MEDIA_DIR."/daily_news.html");
    }
	
		public function usstock(){
	   // echo "Hello";exit;
	
	$categoryIdx='05';
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
				
				
        $json=file_get_contents('https://www.kpabal.com/stocknewsfeed.php');
        
        $jsond = json_decode($json, TRUE);
        
        $refinelist=$jsond['data'];
        $data['newslist']=$refinelist;
        
        $json1=file_get_contents('https://www.kpabal.com/ideasfeed.php');
        
        $jsond1 = json_decode($json1, TRUE);
        
        $idealist=$jsond1['data'];
        $data['idealist']=$idealist;

		 $json2=file_get_contents('https://www.kpabal.com/tvnews.php');
        
        $jsond2 = json_decode($json2, TRUE);
        
        $nlist=$jsond2['data'];
        $data['nlist']=$nlist;
		
		 $json3=file_get_contents('https://www.kpabal.com/reuters.php');
        
        $jsond3 = json_decode($json3, TRUE);
        
        $rlist=$jsond3['data'];
        $data['rlist']=$rlist;
		
		
		$header_data = $this->__generate_header_data("US Stock");
		$footer_data = $this->__generate_footer_data($header_data);

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
        // var_dump($searchdata);exit;
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/usstock', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
        $this->load->view('kpabal/index_js');
	}
	
	public function index(){
	   // echo "Hello";exit;
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
        
        //---Video work---//
        $searchdata = array();
        $searchdata['drama'] = $this->scrap_model->get_drama_data(8);
        $news = $this->scrap_model->get_newsfromdb(8);
        $searchdata['news'] = $news['news'];
        $data['total_video'] = $searchdata;
        // var_dump($searchdata);exit;
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
        $this->load->view('kpabal/index_js');
	}
	
    public function kpabaltv(){
        $limit = 10;
        $data = array();
        $kpabal_data = array();
        $news = $this->scrap_model->get_newsfromdb(10);
        $list = $this->scrap_model->get_fromdb(5);
        $intro_drama  = $this->scrap_model->intro_drama(10);//echo 'Intro Drama<br>';var_dump($intro_drama);exit;
        // $total  = $this->scrap_model->get_drama_data();

        $main_news_othervideo = $this->scrap_model->main_list(10);
        $main_drama = $this->scrap_model->drama_list();
        $sidevideo['news'] = $main_news_othervideo['news'];
        $sidevideo['sport'] = $main_news_othervideo['sport'];
        $sidevideo['music'] = $main_news_othervideo['music'];
        $sidevideo['drama'] = $main_drama;
        $data['sidevideo'] = $sidevideo;
        // var_dump($data['sidevideo']);exit;
        $date = array();
        $today = date(' M d');
        $week = array();
        array_push($date, $today);
        //array_push($week, date('D'));

        $ym = date('M', strtotime("-1 days"));
        $day= date('d',strtotime("-1 days"));
        for($i = $day; $i > $day-6; $i--) {
            array_push($date,  $ym.' '.$i);
        }

        $date_arr = [];
        $today_t = date('Y-m-d H:i:s');
        for ($i = 0 ; $i < 7 ; $i++){
            $temp_time = strtotime($today_t) - 86400 * $i; 
            $temp_date = date('Y-m-d H:i:s', $temp_time);
            $temp_date_arr [] = $temp_date;
            $one_day = [];
            $one_day['weekday'] = date('D', strtotime($temp_date));
            $one_day['date'] = date('m.d', strtotime($temp_date));
            $date_arr[] = $one_day;
        }
        $data['date'] =$date_arr;

        $kpabal_data['news'] = $news['main'];
        $kpabal_data['drama'] = $intro_drama;
        $kpabal_data['music'] = $list['main']['music'];
        $kpabal_data['sport'] = $list['main']['sport'];
        $kpabal_data['trending'] = $list['main']['trending'];
        $kpabal_data['popular'] =array_merge($news['popular'], $list['popular']);
        $data['kpabal'] =$kpabal_data;
        $additional_css = [
            'https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700',
            ROOTPATH.'assets/css/bootstrapTheme.css',
            ROOTPATH.'assets/css/custom.css',
            ROOTPATH.'owl/css/owl.carousel.min.css',
            ROOTPATH.'owl/css/animate.css',
            ROOTPATH.'owl/css/owl.theme.default.min.css',
            'https://www.jqueryscript.net/css/jquerysctipttop.css',
            ROOTPATH.'assets/css/motypager.css',
            ROOTPATH.'assets/css/pages/kpabal.css',
            ROOTPATH.'assets/css/pages/landing-main-right.css',
            ROOTPATH.'assets/plugins/rs-plugin/css/settings.css',
            ROOTPATH.'assets/plugins/rs-plugin/css/layers.css',
            ROOTPATH.'assets/plugins/rs-plugin/css/navigation.css'
            ];

        $additional_js = array(
            // base_url()."assets/js/bootstrap-collapse.js",
            // base_url()."assets/js/bootstrap-transition.js",
            // base_url()."assets/js/bootstrap-tab.js",
            // base_url()."assets/js/motypager-2.0.js",
            // base_url()."assets/js/motypager-2.0.min.js",
            // base_url()."assets/js/google-code-prettify/prettify.js",
            // base_url()."assets/js/application.js",
            base_url()."assets/plugins/rs-plugin/js/jquery.themepunch.tools.min.js",
            base_url()."assets/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js",
            base_url()."assets/plugins/rs-plugin/js/extensions/revolution.extension.slideanims.min.js",
            base_url()."assets/plugins/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js",
            base_url()."assets/plugins/rs-plugin/js/extensions/revolution.extension.navigation.min.js",
            base_url()."assets/plugins/rs-plugin/js/extensions/revolution.extension.video.min.js"
        );
        $data['additional_js'] = $additional_js;
        if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
        $header_data = $this->__generate_header_data("Landing Page");
        $header_data['additional_css'] = $additional_css;
        $footer_data = $this->__generate_footer_data($header_data);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/kpabaltv/index',$data);
        $this->load->view('kpabal/common/footer', $footer_data);
        $this->load->view('kpabal/kpabaltv/index_js',$data);
    }
    
    public function viewdetail($catigori){
        $data = array();
        $news = $this->scrap_model->get_newsfromdb();
        $list = $this->scrap_model->get_fromdb();
        $kpabal_data['news'] = $news['main'];
        $kpabal_data['drama'] = $list['main']['drama'];
        $kpabal_data['music'] = $list['main']['music'];
        $kpabal_data['sport'] = $list['main']['sport'];
        $kpabal_data['trending'] = $list['main']['trending'];
        $data['videodata'] = $kpabal_data[$catigori];
        if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
        $header_data = $this->__generate_header_data("Landing Page");
        
        $footer_data = $this->__generate_footer_data($header_data);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/viewdetail/index',$data);
        $this->load->view('kpabal/kpabaltv/index_js',$data);
    }
    
    public function getdata(){
        $data = array();
        $searchdata = array();
        $video_id = $this->input->post('video_id');
        $api_type = $this->input->post('api_type');
        $videoinfo = array();
        $videoinfo['video_id'] = $video_id;
        $videoinfo['api_type'] = $api_type;
        if(!empty($api_type)){
            switch ($api_type) {
            case 'Y':
                //print_r('Y');
                //$videoinfo = $this->job_model->getyoutubuvideoinfo($videoinfo);
                $searchdata= $this->scrap_model->getplaylist($video_id);
                //$searchdata['relatedlist'] = $this->job_model->getrelatedlist($video_id);
                break;
            case 'D':
                //print_r('D');

                //$videoinfo = $this->job_model->getdailyvideoinfo($videoinfo);
                $searchdata = $this->scrap_model->getdailymotion_playlist($video_id);
                //$searchdata['relatedlist'] = $this->job_model->getdailymotion_relatedlist($video_id);
                break;
            case 'K':
            
                break;
            }
        }
        //$data['videolist'] = ;
        echo(json_encode($searchdata));

    }
    
    public function pagination() {
        $page_number = $this->input->post('page_number');
        $data_limit = $this->input->post('limit_count');
        $cate_name = $this->input->post('cate_name');
        if(strtolower($cate_name) == 'drama') {
            $page_data = $this->scrap_model->pagedata_scrap($page_number, $data_limit);
        }else{
            $sub_name = $this->input->post('sub_name');
            $data_limit = $this->input->post('limit_count');
            $catename = strtolower($cate_name);
            $page_data = $this->scrap_model->pagedata($page_number, $catename,$sub_name,$data_limit);
        }
        //print_r($page_number);
        //$page_number = 2 ;
        //$cate_name = 'news';
        //$sub_name = 'KO';
        
        echo json_encode($page_data);
    }
    
    public function drama_pagination() {
        $page_number = $this->input->post('page_number');
        $data_limit = $this->input->post('limit_count');
        //print_r($page_number);
        //$page_number = 2 ;
        //$cate_name = 'news';
        //$sub_name = 'KO';
        $page_data = $this->scrap_model->pagedata($page_number, $data_limit);
        echo json_encode($page_data);
    }
    
    public function commentsave() {
        $video_id = $this->input->post('video_id');
        //$api_type = $this->input->post('api_type');
        $comment_data = $this->input->post('comment_data');
        $user = $this->input->post('user');
        $email = $this->input->post('email');
        $this->scrap_model->comment_save($video_id, $comment_data, $user, $email);
        echo json_encode("succes");
    }

    public function commentcall() {
        $video_id = $this->input->post('video_id');
        //$api_type = $this->input->post('api_type');
        //$comment_data = $this->input->post('comment_data');
        //$user = $this->input->post('user');
        //$email = $this->input->post('email');
        $comment = $this->scrap_model->comment_call($video_id);
        echo json_encode($comment);
    }
    
    public function getdatar(){
        $data = array();
        $searchdata = array();
        $video_id = $this->input->post('video_id');
        $api_type = $this->input->post('api_type');
        $videoinfo = array();
        $videoinfo['video_id'] = $video_id;
        $videoinfo['api_type'] = $api_type;
        if(!empty($api_type)){
            switch ($api_type) {
            case 'Y':
            
                //print_r('Y');
                //$videoinfo = $this->job_model->getyoutubuvideoinfo($videoinfo);
                //$searchdata= $this->job_model->getplaylist($video_id);
                $searchdata = $this->scrap_model->getrelatedlist($video_id);
                break;
            case 'D':
                //print_r('D');

                //$videoinfo = $this->job_model->getdailyvideoinfo($videoinfo);
                //$searchdata = $this->job_model->getdailymotion_playlist($video_id);
                $searchdata= $this->scrap_model->getdailymotion_relatedlist($video_id);
                break;
            case 'K':
            
                break;
            }
        }
        //$data['videolist'] = ;
        echo(json_encode($searchdata));

    }
    
	public function viewvideo($video_id, $api_type){
		$data = array();
		$searchdata = array();
        //print_r($videoinfo);exit();
      	
        $videoinfo = array();
            $videoinfo['video_id'] = $video_id;
            $videoinfo['api_type'] = $api_type;
            $data['video'] = $videoinfo;

		if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
		}
		$header_data = $this->__generate_header_data("Landing Page");
		
		$footer_data = $this->__generate_footer_data($header_data);

		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/viewvideo/index',$data);
        $this->load->view('kpabal/viewvideo/index_js',$data);
		$this->load->view('kpabal/common/footer', $footer_data);
    }
    
    public function dramaview($video_id) {
        $data = array();
        $searchdata = array();
        $temp_seores = array();
        //$temp1 = "sdfsd";
        //print_r($video_id);exit();
        $temp  = $this->scrap_model->playlist($video_id);
        //print_r($temp);exit();
        // print_r($temp);exit();
        foreach ($temp as $one) {
            if($temp1 != $one['scrap_title']){
                $temp1 = $one['scrap_title'];
                array_push($temp_seores, $one);
            }
            
        }
        //print_r($temp_seores);exit();
        $searchdata['seores']  = $temp_seores;
        $searchdata['sames'] = $this->scrap_model->video_same($video_id);
        $searchdata['sel_video'] = $this->scrap_model->video_info($video_id);
        
        //$searchdata['sel_video'] = $video_url;
        $data['video'] = $searchdata;
        //print_r($data['video']);exit();

        if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
        $header_data = $this->__generate_header_data("Landing Page");
        
        $footer_data = $this->__generate_footer_data($header_data);

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/dramaview/index',$data);
        //$this->load->view('kpabal/dramaview/index_js');
        $this->load->view('kpabal/common/footer', $footer_data);
    }
    
    public function array_multi_subsort($array, $subkey){
        //print_r("enter");
        $b = array(); $c = array();

        foreach ($array as $k => $v)
        {
            $b[$k] = strtolower($v[$subkey]);
        }

        arsort($b);
        foreach ($b as $key => $val)
        {
            $c[] = $array[$key];
        }

        return $c;
    }
    
	public function login(){
		if ($this->general->frontend_controlpanel_logged_in()) {
		    if($this->session->flashdata('redirect') == 'lotto'){
		        redirect('/lottery/');
		    }else{
                redirect('/');
		    }
		}
		$header_data = $this->__generate_header_data("Landing Page");
		
		$footer_data = $this->__generate_footer_data($header_data);
		
        if(isset($_GET['re'])){
            if($_GET['re']=="lotto"){
                $this->session->set_flashdata('redirect', 'lotto');
                $footer_data["redirect"]="lottery";
            }
        }
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
	    $this->session->set_flashdata('redirect', '');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate');

        $this->session->set_flashdata('login_message', '');
        $this->_clean_cookie_();
		
        echo "<script>window.location.href='".base_url()."';</script>";
      
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
		$data['points'] = $this->member_model->get_point_history($memberIdx);
		$data['states'] = $this->category_model->get_tree_rows("address_state");
		$data['lotto_order'] = $this->member_model->get_lotto_order_history($memberIdx);
		$data['lotto_payment'] = $this->member_model->get_lotto_payment_history($memberIdx);
		
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
	
// 	public function cron_tai_video(){
//         $email_content='<h3>Hello, this is the message from cron job.<br>
//                 Cron batch strting...<br>'.$date('M d Y H:i:s').'</h3>';
//         $this->load->library('email');
//         $config['mailtype'] = 'html';
//         $this->email->initialize($config);
//         $this->email->from('admin@kpabal.com', 'Kpabal.com');
//         $this->email->reply_to('admin@kpabal.com', 'KpabalTV');
//         $this->email->to("alerk.star@gmail.com");
//         $this->email->subject('Cron Test');
//         $this->email->message("$email_content");
//         $this->email->send();
	   
// 	    $this->scrap_model->redspot_scraping();
// 	    $this->scrap_model->youtube_image_url();
// 	    $this->scrap_model->time_define();
	    
// 	    $this->job_model->youtubu();
// 	    $this->job_model->youtubu_news();
// 	    $this->job_model->dailymotion();
// 	    $this->job_model->dailymotion_news();
// 	    $this->job_model->get_trending();
	    

//         $email_content='<h3>Hello, this is the message from cron job.<br>
//                 Cron batch finished.<br>'.$data('M d Y H:i:s').'</h3>';
//         $config['mailtype'] = 'html';
//         $this->email->initialize($config);
//         $this->email->from('admin@kpabal.com', 'Kpabal.com');
//         $this->email->reply_to('admin@kpabal.com', 'KpabalTV');
//         $this->email->to("alerk.star@gmail.com");
//         $this->email->subject('Cron Test');
//         $this->email->message("$email_content");
//         $this->email->send();
// 	}
	

}
