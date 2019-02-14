<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Coupon extends REST_Controller {

	function __construct() {
		parent::__construct();

        $this->load->model('coupon_model');
	}    

    public function __get_elemnt_value($element, $property)
    {
        if(str_get_html($element->innertext)->find($property, 0))
            return str_get_html($element->innertext)->find($property, 0)->innertext;
        return false;
    }

    public function __get_element_values($element, $arr_properties, $arr_sources)
    {
        $arr = [];
        for($i=0; $i<count($arr_properties); $i++){
            if(is_array($arr_properties[$i])){
                for($j=0; $j<count($arr_properties[$i]); $j++){
                    $property_value = $this->__get_elemnt_value($element, $arr_properties[$i][$j]);
                    if($property_value) break;
                }
            } else $property_value = $this->__get_elemnt_value($element, $arr_properties[$i]);
            if($property_value && (count($arr_sources) > $i)){
                $arr[$arr_sources[$i]] = $property_value;
            }
        }
        return $arr;
    }
	
	public function index_get()
	{
        $header_data = $this->__generate_header_data("Coupon & Deals");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);

        $arr_ids = [];
        $recommended = $this->coupon_model->__get_recommended_merchants(1, 6);
        foreach ($recommended as $merchant) {
            $arr_ids[] = $merchant->nMerchantID;
        }
        $recommended2 = $this->coupon_model->__get_recommended_merchants(2, 6);
        foreach ($recommended2 as $merchant) {
            if(in_array($merchant->nMerchantID, $arr_ids)) continue;
            $arr_ids[] = $merchant->nMerchantID;
            array_push($recommended, $merchant);
        }
        $recommended3 = $this->coupon_model->__get_general_merchants(12);
        foreach ($recommended3 as $merchant) {
            if(in_array($merchant->nMerchantID, $arr_ids)) continue;
            if(count($recommended) >= 12) break;
            array_push($recommended, $merchant);
        }

        $data['recommended'] = $this->coupon_model->__get_merchant_cashback($recommended);
        $data['characters'] = $this->coupon_model->__get_alpha_beta_merchants();
        $data['categories'] = $this->coupon_model->__get_parent_categories();

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/coupon/index', $data);
        $this->load->view('kpabal/common/footer',$footer_data);
	}

    public function merchants_ajax_post() {

        $store_select = (isset($_POST["store_select"])?$_POST["store_select"]:"ALL");   // 999
        $category_select = (isset($_POST["category_select"])?$_POST["category_select"]:"exe-all-stores"); // exe-holiday
        $page_number = (isset($_POST["page_number"])?$_POST["page_number"]:1);
        $offset = (isset($_POST["offset"])?$_POST["offset"]:12);

        $total_merchants = $this->coupon_model->__get_total_merchants($store_select, $category_select);

        $latest_deals = array();
        for($i=0; $i<count($total_merchants); $i++){
            if($i < ($page_number - 1) * $offset) continue;
            if($i >= $page_number * $offset) continue;
            array_push($latest_deals, $total_merchants[$i]);
        }

        $data['latest_deals'] = $this->coupon_model->__get_merchant_cashback($latest_deals);
        $results['deals'] = $this->load->view('kpabal/coupon/index_ajax', $data, true);
        $results['isMore'] = (count($total_merchants) - 1 - (count($total_merchants) - 1) % $offset) / $offset + 1;
        print_r(json_encode($results));
    }

    public function deals_get($nMerchantID = 0) {
        $merchant = $this->coupon_model->__get_merchant_info($nMerchantID);
        if(!($merchant)) exit();

        $header_data = $this->__generate_header_data($merchant->cName." Coupon & Deals");
        $footer_data = $this->__generate_footer_data($header_data);
        $data        = $this->__generate_side_data($header_data);
        $header_data['additional_css'] = [
            ROOTPATH.PROJECT_CSS_DIR."custom_deals.css",
        ];

        $recommended = $this->coupon_model->__get_recommended_merchants(3, 100);
        $data['recommended'] = $this->coupon_model->__get_merchant_cashback($recommended);
        $total_count = $this->coupon_model->__get_total_coupon_deal($nMerchantID);
        $data['total_page'] = 0;
        if($total_count) {
            $data['total_page'] = ($total_count - 1 - (($total_count - 1) % 12)) / 12;
        }
        $deal_list = $this->coupon_model->__get_deals_per_merchant($nMerchantID);
        $deal_list = array_merge($deal_list, $this->coupon_model->__get_products_per_merchant($nMerchantID));
        $merchant->deal_list = $deal_list;

        $data['merchant_info'] = $merchant;

        $this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/coupon/merchant_index', $data);
        $this->load->view('kpabal/common/footer',$footer_data);
    }

    public function merchant_deal_ajax_get($nMerchantID = 0) {
        $offset = (isset($_GET["offset"])?$_GET["offset"]:12);
        $merchant = $this->coupon_model->__get_merchant_info($nMerchantID);
        if(!($merchant)) exit();
        $deal_list = $this->coupon_model->__get_deals_per_merchant($nMerchantID);
        $deal_list = array_merge($deal_list, $this->coupon_model->__get_products_per_merchant($nMerchantID));
        $result_deal_list = [];
        for($i=$offset; $i<count($deal_list); $i++) {
            if($i < $offset + 12) {
                $result_deal_list[] = $deal_list[$i];
            }
        }
        $merchant->deal_list = $result_deal_list;
        $data['merchant_info'] = $merchant;
        $this->load->view('kpabal/coupon/merchant_ajax', $data);
    }

    public function load_deals_get($nMerchantID, $id = 0) {
        $merchant = $this->coupon_model->__get_merchant_info($nMerchantID);
        if(!($merchant)) exit();
        $data['img_logo'] = $merchant->aLogos[0]->cURL;
        $data['cashback'] = $merchant->cashback;
        $data['track_url'] = $merchant->cAffiliateURL;
        $data['merchant'] = $merchant->cName;
        $deal_info = $this->coupon_model->__get_deal_info($id);
        if($deal_info) $data['track_url'] = $deal_info->cAffiliateURL;
        if($data['track_url']) $data['track_url'] = $this->general->__gen_aff_track_url_2($data['track_url']);
        $this->load->view("kpabal/coupon/load_deals", $data);
    }

    public function load_products_get($nMerchantID, $id = 0) {
        $merchant = $this->coupon_model->__get_merchant_info($nMerchantID);
        if(!($merchant)) exit();
        $data['img_logo'] = $merchant->aLogos[0]->cURL;
        $data['cashback'] = $merchant->cashback;
        $data['track_url'] = $merchant->cAffiliateURL;
        $data['merchant'] = $merchant->cName;
        $deal_info = $this->coupon_model->__get_product_info($id);
        if($deal_info) $data['track_url'] = $deal_info->url;
        if($data['track_url']) $data['track_url'] = $this->general->__gen_aff_track_url_2($data['track_url']);
        $this->load->view("kpabal/coupon/load_deals", $data);        
    }

    public function linkshare_get()
    {
        $process_limit = 100;
        $process_count = 1;

        if(!($this->coupon_model->check_auto_process_within_a_day("LS Merchant Cron"))) {
            $html = str_get_html( $this->linkshare_link->__get_merchant_list() );
            if($html){
                foreach ($html->find('merchant') as $merchant) {
                    $merchant_id = $this->__get_elemnt_value($merchant, "mid");
                    $merchant_name = $this->__get_elemnt_value($merchant, "merchantname");
                    if($merchant_id && $merchant_name){
                        $this->coupon_model->register_merchant($merchant_id, $merchant_name);
                    }
                }
                $this->coupon_model->clear_merchant();
                exit();
            }
        }

        $merchants = $this->coupon_model->get_merchants("LS");
        for($i=0; $i<count($merchants); $i++){
            $mid = $merchants[$i]->nMerchantID;
            if(!($this->coupon_model->check_auto_process_within_a_day("LS Product Cron : ".$mid))) {
                if($process_count > $process_limit) {
                    echo ($process_count - 1);
                    exit();
                }
                $process_count++;
                $result = $this->linkshare_link->__get_product_search($mid);
                $html = str_get_html( $result );
                if($html){
                    $this->coupon_model->clear_merchant_product("LS", $mid);
                    foreach ($html->find('item') as $item) {
                        $item_obj = $this->__get_element_values($item, ["mid", "merchantname", "sku", "productname", "category primary", "price", "saleprice", ["keywords linkurl", "linkurl"], ["keywords imageurl", "imageurl"], ["description short", "description long"]], ["merchant_id", "merchant", "sku", "name", "primarycategory", "price", "finalprice", "url", "image", "description"]);
                        $item_obj["time_updated"] = date("Y-m-d H:i:s");
                        $item_obj["source"] = "LS";
                        $item_obj["price"] = $item_obj["price"] * 100;
                        $item_obj["finalprice"] = $item_obj["finalprice"] * 100;

                        if(isset($item_obj["url"]) && ($item_obj["url"])) $this->coupon_model->register_merchant_product($item_obj);
                    }                   
                }
            }
        }
        if($process_count > 1){
            echo ($process_count - 1);
            exit();
        }

        $deal_process = $this->coupon_model->get_auto_process("LS Deals Cron");
        $page_number = 1;
        if($deal_process){
            if($deal_process->TotalPages > $deal_process->PageNumberRequested) $page_number = $deal_process->PageNumberRequested + 1;
            if($deal_process->TotalPages == $deal_process->PageNumberRequested) {
                $this->coupon_model->synchronize_database();
                $deal_process->PageNumberRequested = $deal_process->PageNumberRequested + 1;
                $this->coupon_model->register_auto_process("LS Deals Cron", $deal_process);
            }
        }

        if(!($this->coupon_model->check_auto_process_within_a_day("LS Deals Cron")) || ($page_number > 1)) {
            if($page_number > 1) {
                if(time() - $deal_process->ProcessTime < 60)
                    sleep(60 + $deal_process->ProcessTime - time());
            }
            if($page_number == 1) $this->coupon_model->clear_merchant_deal("LS");
            $result = $this->linkshare_link->__get_coupon_deals($page_number);          
            
            $result = str_replace("<link ", "<item ", $result);
            $result = str_replace("</link>", "</item>", $result);
            $html = str_get_html( $result );
            if($html){
                $page_status = new \stdClass;
                $page_status->TotalPages = $this->__get_elemnt_value($html, "TotalPages");
                $page_status->PageNumberRequested = $this->__get_elemnt_value($html, "PageNumberRequested");
                $page_status->ProcessTime = time();
                echo count($html->find('item'));
                foreach ($html->find('item') as $item) {
                    if($item->type != "TEXT") continue;
                    $item_obj = $this->__get_element_values($item, ["offerdescription", "offerstartdate", "offerenddate", "clickurl", "advertiserid", "advertisername", "couponcode"], ["cLabel", "dtStartDate", "dtEndDate", "cAffiliateURL", "nMerchantID", "cMerchant", "cCode"]);
                    $item_obj["cStatus"] = "active";
                    $item_obj["cNetwork"] = "LS";

                    $categories = [];
                    foreach(str_get_html($item->innertext)->find('category') as $category){
                        $category_obj = new \stdClass;
                        $category_obj->id = $category->id;
                        $category_obj->name = $category->innertext;

                        $categories[] = $category_obj;
                    }

                    $types = [];
                    foreach(str_get_html($item->innertext)->find('promotiontype') as $type){
                        $type_obj = new \stdClass;
                        $type_obj->id = $type->id;
                        $type_obj->name = $type->innertext;

                        $types[] = $type_obj;
                    }

                    if(isset($item_obj["cAffiliateURL"]) && ($item_obj["cAffiliateURL"])){
                        $deal_id = $this->coupon_model->register_merchant_deal($item_obj);
                        if($deal_id){
                            $this->coupon_model->reigster_deal_categories("LS", $deal_id, $categories);
                            $this->coupon_model->reigster_deal_types("LS", $deal_id, $types);
                        }
                    }
                }

                $this->coupon_model->register_auto_process("LS Deals Cron", $page_status);
                $this->coupon_model->update_merchant_deal("LS");
            }
        }
    }

    public function get_safe_res_get() {
        $url = $_GET['url'];

        $path = BASEPATH."../themes/withyou/resources/hash/";

        $file = md5($url);
        $file = $path.$file;
        
        if(file_exists($file)){
                $content = file_get_contents($file);
        } else {
            $content = file_get_contents($url);
            file_put_contents($file, $content);
        }
        header('Content-Type: image/gif');
        echo $content;
        exit();
    }
}
