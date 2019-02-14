<?php

use Restserver\Libraries\REST_Controller;
require_once(APPPATH . 'libraries/stripe/lib/Stripe.php');

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Lottery extends CI_Controller {

    function __construct() {
        parent::__construct();

		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        if($memberIdx=="" || $memberIdx==0){
            redirect("login?re=lotto");        
        }
        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->model('basis_model');
        $this->load->model('board_model');
        $this->load->model('category_model');
        $this->load->model('business_model');
        $this->load->model('lottery_model');
        $this->load->model('shopping_model');
    }
    
    private $table_prefix="tbl_";
    
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
    
    function index() {        
        redirect("lottery/megamilions/");        
    }
    
    public function megamilions($tag = "")
    {
        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        $data = $this->lottery_model->getLotteryData(1);

        $data1["lotteryImage"]=$data[0]['game_logo'];
        $data1["lotteryTitle"]="Mega Millions";
        $data1["lotteryAllPrice"]=$data[0]['next_jackpot_amt'];
        $data1["lotteryNextDate"]=$data[0]['next_jackpot_date'];
        $data1["maxPadNumber"]= 75;
        $data1["maxBall"]= 15;
        $data1["gameType"]= "MegaMilions";
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/game',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function CashforLife() {

        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        $data = $this->lottery_model->getLotteryData(5);
        
        $data1["lotteryImage"]=$data[0]['game_logo'];
        $data1["lotteryTitle"]="Mega Millions";
        $data1["lotteryAllPrice"]=$data[0]['next_jackpot_amt'];
        $data1["lotteryNextDate"]=$data[0]['next_jackpot_date'];
        $data1["maxPadNumber"]= 60;
        $data1["maxBall"]= 5;
        $data1["gameType"]= "CashforLife";
        
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/game',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    	
    public function LuckyforLife() {

        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        $data = $this->lottery_model->getLotteryData(5);
        
        $data1["lotteryImage"]=$data[0]['game_logo'];
        $data1["lotteryTitle"]="Mega Millions";
        $data1["lotteryAllPrice"]=$data[0]['next_jackpot_amt'];
        $data1["lotteryNextDate"]=$data[0]['next_jackpot_date'];
        $data1["maxPadNumber"]= 48;
        $data1["maxBall"]= 18;
        $data1["gameType"]= "LuckyforLife";
        
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/game',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function HotLotto() {

        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        $data = $this->lottery_model->getLotteryData(5);
        
        $data1["lotteryImage"]=$data[0]['game_logo'];
        $data1["lotteryTitle"]="Mega Millions";
        $data1["lotteryAllPrice"]=$data[0]['next_jackpot_amt'];
        $data1["lotteryNextDate"]=$data[0]['next_jackpot_date'];
        $data1["maxPadNumber"]= 47;
        $data1["maxBall"]= 19;
        $data1["gameType"]= "HotLotto";
        
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/game',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    public function powerball() {

        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        $data = $this->lottery_model->getLotteryData(5);
        
        $data1["lotteryImage"]=$data[0]['game_logo'];
        $data1["lotteryTitle"]="Mega Millions";
        $data1["lotteryAllPrice"]=$data[0]['next_jackpot_amt'];
        $data1["lotteryNextDate"]=$data[0]['next_jackpot_date'];
        $data1["maxPadNumber"]= 69;
        $data1["maxBall"]= 26;
        $data1["gameType"]= "PowerBall";
        
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/game',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
    
    public function success() {

        $data['selected'] = 'success';
        $header_data = $this->__generate_header_data("success");
        $footer_data = $this->__generate_footer_data();

        if(isset($_GET['game_name'])) {
            $data1["lotteryTitle"]=$_GET['game_name'];
            $data1["lotteryPrice"]=$_GET['game_price'];
        }
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/success',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
        
    public function ticket_result() {
        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();
			
		$member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
		$member = $this->member_model->get_item($memberIdx);
		//print_r($this->shopping_model->get_order_detail(4));
		if(isset($_POST['lotteryTitle'])) {
		    
            $user_name=$member->user_id;
            
			$table = $this->table_prefix . "lottery_logs";
            //$user_name = $this->validation_model->idToUserName($memberIdx);
            $query = "INSERT INTO `$table` (`user_id`, `user_name`, `lotteryTitle`, `lotteryPrice`, `lotteryImage`, `lotteryDate`, `lotteryData`, `lotteryAllPrice`) VALUES ('{$memberIdx}','{$user_name}', '{$this->input->post('lotteryTitle')}', '{$this->input->post('lotteryPrice')}', '{$this->input->post('lotteryImage')}', '{$this->input->post('lotteryDate')}', '{$this->input->post('lotteryData')}', '{$this->input->post('lotteryAllPrice')}');";           
            $this->db->query($query);
			
            $data1["lotteryTitle"]=$_POST['lotteryTitle'];
            $data1["lotteryPrice"]=$_POST['lotteryPrice'];
            $data1["lotteryImage"]=$_POST['lotteryImage'];
            $data1["lotteryDate"]=$_POST['lotteryDate'];
            $data1["lotteryData"]= $_POST['lotteryData'];
            $data1["lotteryAllPrice"]= $_POST['lotteryAllPrice'];
            $data1["gameType"]= $_POST['gameType'];
        } else {
            redirect("lottery/megamilions/");        
        }

        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/ticket_result',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
        $this->load->view('kpabal/lottery/ticket_result_js',$footer_data);
        
    }
    
    public function stripe_process($pay_amount = 0){
              if($pay_amount == 0) exit();

        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        $memberName = $member->first_name.' '.$member->last_name;

        $stripe_pri_key = STRIPE_PRI_KEY;

        try {
            
            if(STRIPE_PRI_KEY) {
                Stripe::setApiKey($stripe_pri_key);
                $charge = Stripe_Charge::create(array(
                            "amount" => 100 * $pay_amount,
                            "currency" => "usd",
                            "card" => $this->input->post('access_token'),
                            "description" => "Stripe Payment Test"
                ));
            }

            if($this->lottery_model->place_order($_POST, $memberIdx, $pay_amount)){
                echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.'));
            }
            exit();
        } catch (Stripe_CardError $e) {
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            echo json_encode(array('status' => 500, 'error' => $e->getMessage()));
            exit();
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));
            exit();
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));
            exit();
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        }
    }
    public function order_placed(){
        
        
    }
    public function sample() {

        $data['selected'] = 'lottery';
        $header_data = $this->__generate_header_data("lottery");
        $footer_data = $this->__generate_footer_data();

        if(isset($_GET['game_name'])) {
            $data1["lotteryTitle"]=$_GET['game_name'];
            $data1["lotteryPrice"]=$_GET['game_price'];
        }
        
        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/lottery/success',$data1);
        $this->load->view('kpabal/common/footer',$footer_data);
    }
}