<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crontai extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
		$this->load->model('job_model');
		$this->load->model('scrap_model');
	}

    public function cron_test(){
        $message = "Hello";
        $start_time = date('Y-m-d H:i:s');
        $mail_to = "alerk.star@gmail.com";
        $result = $this->send_email($message , $mail_to);
        $end_time = date('Y-m-d H:i:s');
        $result = "Start : ".$start_time."<br> End : ".$end_time;
        echo json_encode($result);
    }

    /**
     * send Email
     * @param: array[message, mail_to]
     * @return : boolean
     */
    public function send_email($message, $mail_to){
        $this->load->library('email');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('admin@kpabal.com', 'Kpabal.com');
        $this->email->reply_to('admin@kpabal.com', 'KpabalTV');
        $this->email->to($mail_to);
        $this->email->subject('Cron Test');
        $this->email->message("$message");
        return $this->email->send();
    }
    
    public function scrap_redspot(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->redspot_scraping();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }    
    
    public function update_yutube_img(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->youtube_image_url();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

    public function update_time_info(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->time_define();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

    public function update_youtube_api(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->youtubu();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

    public function youtube_news(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->youtubu_news();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

    public function dailymotion(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->dailymotion();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

    public function dailymotion_news(){
        $start_time = date('Y-m-d H:i:s');
        $this->scrap_model->dailymotion_news();
        $end_time = date('Y-m-d H:i:s');
        $message = $start_time.'---'.$end_time;
        echo $message;
    }

// 	public function cron_tai_video(){

// 	    $this->scrap_model->redspot_scraping();
// 	    $this->scrap_model->youtube_image_url();
// 	    $this->scrap_model->time_define();
	    
// 	    $this->job_model->youtubu();
// 	    $this->job_model->youtubu_news();
// 	    $this->job_model->dailymotion();
// 	    $this->job_model->dailymotion_news();
// 	    $this->job_model->get_trending();
// 	}

}