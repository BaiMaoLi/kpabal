<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class linkshare_link {

  var $user_id = "kcougar71";
  var $user_pwd = "1213ohsung";
  var $user_sid = "3173924";
  var $user_token = "Basic cjdoekdWRDdERFRuZVl5bnRWbEQ4WlphdDcwYTpDbmM0eVQwMmlBVVBWM053OTBiQkVHMkdZcE1h";

  public function __construct() {

  }

  public function __get_coupon_deals($pagenumber = 1) {
    $token = $this->__get_access_token();

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rakutenmarketing.com/coupon/1.0?pagenumber=".$pagenumber,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$token->access_token,
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;
  }
  
  public function __get_product_search($mid = 0) {
    $token = $this->__get_access_token();

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rakutenmarketing.com/productsearch/1.0".(($mid)?"?mid=".$mid:""),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$token->access_token,
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;
  }

  public function __get_merchant_lists() {
    $result = $this->__get_merchant_list();
    $html = str_get_html($result);

    $arr_result = [];
    foreach ($html->find('midlist merchant') as $merchant){
      if((str_get_html($merchant->innertext)->find("mid", 0)) && (str_get_html($merchant->innertext)->find("merchantname", 0))){
        $merchant_obj = new \stdClass;
        $merchant_obj->id = str_get_html($merchant->innertext)->find("mid", 0)->innertext;
        $merchant_obj->name = str_get_html($merchant->innertext)->find("merchantname", 0)->innertext;
        $arr_result[] = $merchant_obj;
      }
    }
    return $arr_result;
  }

  public function __get_merchant_list() {
    $file_path = APPPATH."logs/merchants_linkshare";
    if(file_exists($file_path)) {
        if(date("Y-m-d", filemtime($file_path)) == date("Y-m-d")){              
            return @file_get_contents($file_path);
        }
    }

    $token = $this->__get_access_token();
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rakutenmarketing.com/advertisersearch/1.0",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$token->access_token,
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    file_put_contents($file_path, $response);
    return $response;
  }

  public function __get_access_token() {
    $file_path = APPPATH."logs/token_linkshare";
    if(file_exists($file_path)) {
        $token_info = json_decode(@file_get_contents($file_path));
        if($token_info) {
          $token_info->expires_in = $token_info->expires_in + filemtime($file_path) - time();
          if($token_info->expires_in > 5)
            return $token_info;
        }
        sleep(6);
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rakutenmarketing.com/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "grant_type=password&username=".$this->user_id."&password=".$this->user_pwd."&scope=".$this->user_sid,
      CURLOPT_HTTPHEADER => array(
        "Authorization: ".$this->user_token,
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
      ),
    ));

    $response = curl_exec($curl);
    if(strpos($response, "error") === false) file_put_contents($file_path, $response);
    return json_decode($response);
  }

}