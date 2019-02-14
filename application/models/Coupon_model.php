<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon_model extends CI_Model {
    var $tbl_process                = "tbl_system_auto_process";

    var $tbl_selection              = "tbl_system_merchant_selection";
    var $tbl_cashback               = "tbl_system_merchant_cashback";

    var $tbl_merchant               = "tbl_system_cron_merchants";
    var $tbl_merchant_real          = "tbl_system_real_merchants";

    var $tbl_merchant_product       = "tbl_system_cron_products";
    var $tbl_merchant_product_real  = "tbl_system_real_products";

    var $tbl_merchant_deal          = "tbl_system_cron_deals";
    var $tbl_merchant_deal_real     = "tbl_system_real_deals";

    var $tbl_category               = "tbl_system_cron_categories";
    var $tbl_category_real          = "tbl_system_real_categories";

    var $tbl_deal_category          = "tbl_system_cron_deals_categories";
    var $tbl_deal_category_real     = "tbl_system_real_deals_categories";

    var $tbl_type                   = "tbl_system_cron_types";
    var $tbl_type_real              = "tbl_system_real_types";

    var $tbl_deal_type              = "tbl_system_cron_deals_types";
    var $tbl_deal_type_real         = "tbl_system_real_deals_types";

    public function __get_deal_info($id) {
        $strsql = sprintf("select * from %s where id = '$id'", $this->tbl_merchant_deal_real);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0];
        return false;
    }

    public function __get_product_info($id) {
        $strsql = sprintf("select * from %s where id = '$id'", $this->tbl_merchant_product_real);
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0];
        return false;        
    }

    public function __get_deals_per_merchant($nMerchantID) {
        $strsql = sprintf("select *, 1 as is_deal from %s where nMerchantID = '$nMerchantID'", $this->tbl_merchant_deal_real);
        return $this->db->query($strsql)->result();
    }

    public function __get_products_per_merchant($merchant_id) {
        $strsql = sprintf("select *, 0 as is_deal from %s where merchant_id = '$merchant_id'", $this->tbl_merchant_product_real);
        return $this->db->query($strsql)->result();
    }

    public function __get_total_coupon_deal($nMerchantID) {
        $total_count = 0;
        $strsql = sprintf("select count(*) cn from %s where nMerchantID = '$nMerchantID'", $this->tbl_merchant_deal_real);
        $result = $this->db->query($strsql)->result();
        if(count($result)) $total_count += $result[0]->cn;
        $strsql = sprintf("select count(*) cn from %s where merchant_id = '$nMerchantID'", $this->tbl_merchant_product_real);
        $result = $this->db->query($strsql)->result();
        if(count($result)) $total_count += $result[0]->cn;
        return $total_count;
    }

    public function __get_merchant_info($nMerchantID) {
        $strsql = sprintf("select a.*, b.cashback from %s a left join %s b on a.nMerchantID=b.nMerchantID where a.nMerchantID = '$nMerchantID'", $this->tbl_merchant_real, $this->tbl_cashback);
        $result = $this->db->query($strsql)->result();
        if(count($result)) {
            $merchant = $result[0];
            if(!($merchant->cashback)) $merchant->cashback = 1;
            $merchant->aLogos = json_decode($merchant->aLogos);
            return $merchant;
        }
        return false;
    }

    public function __get_merchant_cashback($merchants) {
        $strsql = sprintf("select * from %s", $this->tbl_cashback);
        $result = $this->db->query($strsql)->result();
        $arr_cashback = [];
        foreach ($result as $cashback) {
            $arr_cashback[$cashback->nMerchantID] = $cashback->cashback;
        }
        foreach ($merchants as $key => $merchant) {
            $merchants[$key]->cashback = 1;
            if(isset($arr_cashback[$merchant->nMerchantID]))
                $merchants[$key]->cashback = $arr_cashback[$merchant->nMerchantID];
        }
        return $merchants;
    }

    public function __get_recommended_merchants($selectionType, $limit) {
        $strsql = sprintf("select a.* from %s a inner join %s b on a.nMerchantID=b.nMerchantID and selectionType='$selectionType' order by b.orderNum desc limit $limit", $this->tbl_merchant_real, $this->tbl_selection);
        return $this->db->query($strsql)->result();
    }

    public function __get_general_merchants($limit) {
        $strsql = sprintf("select * from %s order by nMerchantID limit $limit", $this->tbl_merchant_real);
        return $this->db->query($strsql)->result();
    }

    public function save_selection($selectionType, $nMerchantID, $is_display, $orderNum) {
        $strsql = sprintf("delete from %s where nMerchantID='$nMerchantID' and selectionType='$selectionType'", $this->tbl_selection);
        $this->db->query($strsql);
        if($is_display == "true") {
            $strsql = sprintf("insert into %s (nMerchantID, selectionType, orderNum) values ('$nMerchantID', '$selectionType', '$orderNum')", $this->tbl_selection);
            $this->db->query($strsql);
        }
    }

    public function save_cashback($nMerchantID, $cashback) {
        $strsql = sprintf("delete from %s where nMerchantID='$nMerchantID'", $this->tbl_cashback);
        $this->db->query($strsql);
        $strsql = sprintf("insert into %s (nMerchantID, cashback) values ('$nMerchantID', '$cashback')", $this->tbl_cashback);
        $this->db->query($strsql);
    }

    public function search_merchants($category, $order_id, $order_dir, $offset, $limit, $search) {
        $strsql = "select a.*, (b.selectionType = '".$category."') is_selection, c.cashback, b.orderNum from ".$this->tbl_merchant_real." a left join ".$this->tbl_selection." b on a.nMerchantID = b.nMerchantID and b.selectionType = '".$category."' left join ".$this->tbl_cashback." c on a.nMerchantID = c.nMerchantID where cName LIKE '%".$search."%' order by ".$order_id." ".$order_dir.", b.orderNum desc limit ".$offset.", ".$limit;
        return $this->db->query($strsql)->result();
    }

    public function search_merchants_count($search) {
        $strsql = "select count(*) cn from ".$this->tbl_merchant_real." where cName LIKE '%".$search."%'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function register_auto_process($process_name, $process_param = "")
    {
        if(!($process_param)) $process_param = new \stdClass;
        $process_param = json_encode($process_param);

        $strsql = sprintf("select count(*) cn from %s where process_name='$process_name'", $this->tbl_process);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
            $strsql = sprintf("update %s set process_time = NOW(), process_param='$process_param' where process_name = '$process_name'", $this->tbl_process);
            $this->db->query($strsql);
        } else {
            $strsql = sprintf("insert into %s (process_name, process_time, process_param) values ('$process_name', NOW(), '$process_param')", $this->tbl_process);
            $this->db->query($strsql);
        }
    }

    public function check_auto_process_within_a_day($process_name)
    {
        $process_time = $this->get_auto_process($process_name, "time", "");
        if($process_time){
            $diff = time() + $this->get_mysql_php_time_diff() - strtotime($process_time);
            if($diff < 86400) return true;
        }
        return false;
    }

    public function get_mysql_php_time_diff()
    {
        $strsql = sprintf("select NOW() as cur_time");
        $result = $this->db->query($strsql)->result();
        $diff = strtotime($result[0]->cur_time) - time();
        return $diff;
    }

    public function get_auto_process($process_name, $param_name = "param", $return_type = "json")
    {
        $fld_name = "process_".$param_name;

        $strsql = sprintf("select * from %s where process_name='$process_name'", $this->tbl_process);
        $result = $this->db->query($strsql)->result();
        if(count($result) > 0){
            if($return_type == "json")
                return json_decode($result[0]->$fld_name);
            else
                return $result[0]->$fld_name;
        }
        return false;
    }
    public function __get_merchant_logo_from_basis($cName) {
        $arr_result = [];

        $file_path = APPPATH."logs/logos.json";
        $json = @file_get_contents($file_path);
        if($json) {
            $arr2 = json_decode($json);
            
            for($j=0; $j<count($arr2); $j++){
                $cName2 = $arr2[$j]->name;
                $cName = strtolower(preg_replace("/[^a-zA-Z0-9\+]/", "", $cName));
                $cName2 = strtolower(preg_replace("/[^a-zA-Z0-9\+]/", "", $cName2));            
                if((strpos($cName2, $cName) !== false) || (strpos($cName, $cName2) !== false)) {
                    if($arr2[$j]->image != "")
                        $arr_result[] = $arr2[$j];
                }
            }
        }
        return $arr_result;
    }

    public function update_merchant_logo($nMerchantID, $cNetwork = "LS", $cName = "")
    {        
        if($cNetwork == "LS"){

            $aLogos = "";
            $img_logo = new \stdClass;
            //$img_logo->cSize = "125x40";
            $img_logo->cSize = "120x60";
            $img_logo->cURL = "http://merchant.linksynergy.com/fs/logo/link_".$nMerchantID.".png";
            
            if($cName != ""){
                $logo_arr = $this->__get_merchant_logo_from_basis($cName);  
                if(count($logo_arr) > 0) 
                    $img_logo->cURL = $logo_arr[0]->image;
            } 
            
            $check_log = false;
            $img_logo->cURL = str_replace("https:", "http:", $img_logo->cURL);
            if($img_logo->cURL) $check_log = @file_get_contents($img_logo->cURL);
            if(!($check_log)){
                $img_logo->cURL = "http://merchant.linksynergy.com/fs/logo/lg_".$nMerchantID.".jpg";
                $check_log = @file_get_contents($img_logo->cURL);
                if(!($check_log)){
                    $img_logo->cURL = "http://merchant.linksynergy.com/fs/logo/link_".$nMerchantID.".gif";
                    $check_log = @file_get_contents($img_logo->cURL);
                    if(!($check_log)){
                        $img_logo->cURL = "http://merchant.linksynergy.com/fs/logo/link_".$nMerchantID.".png";
                        $check_log = @file_get_contents($img_logo->cURL);
                        if(!($check_log)){
                            $img_logo->cURL = site_url(PROJECT_IMG_DIR . FMTC_DEFAULT_LOGOS);
                        }
                    }
                }
            }
            
            $aLogos = json_encode([ $img_logo ]);
            
            $strsql = sprintf("update %s set aLogos = '$aLogos' where cNetwork='$cNetwork' and nMerchantID='$nMerchantID'", $this->tbl_merchant_real);
            $this->db->query($strsql);
            
            $strsql = sprintf("update %s set aLogos = '$aLogos' where cNetwork='$cNetwork' and nMerchantID='$nMerchantID'", $this->tbl_merchant);
            $this->db->query($strsql);
        }
    }

    public function register_merchant($nMerchantID, $cName, $cNetwork = "LS")
    {
        $strsql = sprintf("select count(*) cn from %s where cNetwork='$cNetwork' and nMerchantID='$nMerchantID'", $this->tbl_merchant);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
            $strsql = sprintf("update %s set updated_at = NOW() where cNetwork='$cNetwork' and nMerchantID='$nMerchantID'", $this->tbl_merchant);
            $this->db->query($strsql);
        } else {
            $strsql = 'insert into '.$this->tbl_merchant.' (nMerchantID, cName, cNetwork) values ("'.$nMerchantID.'", "'.$cName.'", "'.$cNetwork.'")';
            $this->db->query($strsql);
            $this->update_merchant_logo($nMerchantID, $cNetwork, $cName);
        }        
    }

    public function get_merchants($cNetwork = "LS")
    {
        return $this->db->query(sprintf("select * from %s where cNetwork='$cNetwork'", $this->tbl_merchant))->result();
    }

    public function get_cSlug($input_param)
    {
        $input_param = str_replace("&amp;", "and", $input_param);
        $input_param = str_replace("%", "", $input_param);
        $input_param = str_replace("'", "", $input_param);
        $input_param = str_replace('"', "", $input_param);
        $input_param = str_replace("’", "", $input_param);        
        $input_param = str_replace(" - ", "-", $input_param);
        $input_param = str_replace("/", "or", $input_param);
        $input_param = str_replace("   ", " ", $input_param);
        $input_param = str_replace("  ", " ", $input_param);
        $input_param = str_replace("_", "-", $input_param);
        $input_param = str_replace(" ", "-", $input_param);
        $input_param = str_replace("---", "-", $input_param);
        $input_param = str_replace("--", "-", $input_param);
        return strtolower($input_param);
    }

    public function clear_merchant($cNetwork = "LS")
    {
        $this->db->query(sprintf("delete from %s where cNetwork='$cNetwork' and date(date_add(updated_at, interval 1 day)) < date(NOW())", $this->tbl_merchant));
        $this->register_auto_process("LS Merchant Cron");
    }

    public function clear_merchant_product($source = "LS", $merchant_id = 0)
    {
        $this->db->query(sprintf("delete from %s where source='$source' and merchant_id='$merchant_id'", $this->tbl_merchant_product));
        $this->register_auto_process("LS Product Cron : ".$merchant_id);
    }    

    public function register_merchant_product($product_obj)
    {
        $this->db->insert(substr($this->tbl_merchant_product, 4), $product_obj);
    }

    public function clear_merchant_deal($cNetwork = "LS")
    {
        $this->db->query(sprintf("delete from %s where nCouponID in (select nCouponID from %s where cNetwork = '$cNetwork' and dtEndDate < CURRENT_DATE)", $this->tbl_deal_category, $this->tbl_merchant_deal));
        $this->db->query(sprintf("delete from %s where nCouponID in (select nCouponID from %s where cNetwork = '$cNetwork' and dtEndDate < CURRENT_DATE)", $this->tbl_deal_type, $this->tbl_merchant_deal));
        $this->db->query(sprintf("delete from %s where cNetwork='$cNetwork' and dtEndDate < CURRENT_DATE", $this->tbl_merchant_deal));
    }

    public function update_merchant_deal($cNetwork = "LS")
    {
        $this->db->query(sprintf("update %s set nCouponID = id where cNetwork='$cNetwork'", $this->tbl_merchant_deal));
    }

    public function register_merchant_deal($deal_obj)
    {
        $strsql = sprintf("select count(*) cn from %s where cNetwork='%s' and nMerchantID='%s' and dtStartDate='%s' and dtEndDate='%s' and cAffiliateURL='%s'", $this->tbl_merchant_deal, $deal_obj["cNetwork"], $deal_obj["nMerchantID"], $deal_obj["dtStartDate"], $deal_obj["dtEndDate"], $deal_obj["cAffiliateURL"]);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
        } else{
            $this->db->insert(substr($this->tbl_merchant_deal, 4), $deal_obj);
            return $this->db->insert_id();
        }
        return false;
    }

    public function register_deal_category_info($cNetwork, $nCouponID, $cateogry_name)
    {
        $cCategorySlug = $this->get_cSlug($cateogry_name);
        $strsql = sprintf("select count(*) cn from %s where cNetwork='$cNetwork' and nCouponID='$nCouponID' and cCategorySlug='$cCategorySlug'", $this->tbl_deal_category);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
        } else {
            $this->db->insert(substr($this->tbl_deal_category, 4), array("cNetwork" => $cNetwork, "nCouponID" => $nCouponID, "cCategorySlug" => $cCategorySlug));
        }
    }

    public function register_deal_category($cNetwork, $id, $cName)
    {
        $cSlug = $this->get_cSlug($cName);
        $strsql = sprintf("select count(*) cn from %s where cNetwork='$cNetwork' and cSlug='$cSlug'", $this->tbl_category);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
        } else {
            $this->db->insert(substr($this->tbl_category, 4), array("cNetwork" => $cNetwork, "id" => $id, "cName" => $cName, "cSlug" => $cSlug));
        }
    }

    public function reigster_deal_categories($cNetwork, $deal_id, $categories)
    {
        foreach ($categories as $cateogry_obj) {
            $this->register_deal_category($cNetwork, $cateogry_obj->id, $cateogry_obj->name);
            $this->register_deal_category_info($cNetwork, $deal_id, $cateogry_obj->name);
        }
    }

    public function register_deal_type_info($cNetwork, $nCouponID, $type_name)
    {
        $cTypeSlug = $this->get_cSlug($type_name);
        $strsql = sprintf("select count(*) cn from %s where cNetwork='$cNetwork' and nCouponID='$nCouponID' and cTypeSlug='$cTypeSlug'", $this->tbl_deal_type);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
        } else {
            $this->db->insert(substr($this->tbl_deal_type, 4), array("cNetwork" => $cNetwork, "nCouponID" => $nCouponID, "cTypeSlug" => $cTypeSlug));
        }
    }

    public function register_deal_type($cNetwork, $id, $cName)
    {
        $cSlug = $this->get_cSlug($cName);
        $strsql = sprintf("select count(*) cn from %s where cNetwork='$cNetwork' and cSlug='$cSlug'", $this->tbl_type);
        $result = $this->db->query($strsql)->result();
        if(count($result) && ($result[0]->cn > 0)){
        } else {
            $this->db->insert(substr($this->tbl_type, 4), array("cNetwork" => $cNetwork, "id" => $id, "cName" => $cName, "cSlug" => $cSlug));
        }
    }

    public function reigster_deal_types($cNetwork, $deal_id, $types)
    {
        foreach ($types as $type_obj) {
            $this->register_deal_type($cNetwork, $type_obj->id, $type_obj->name);
            $this->register_deal_type_info($cNetwork, $deal_id, $type_obj->name);
        }
    }

    public function synchronize_database()
    {
        $this->db->query(sprintf("delete from %s", $this->tbl_merchant_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_merchant_product_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_merchant_deal_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_category_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_deal_category_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_type_real));
        $this->db->query(sprintf("delete from %s", $this->tbl_deal_type_real));

        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_merchant_real, $this->tbl_merchant));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_merchant_product_real, $this->tbl_merchant_product));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_merchant_deal_real, $this->tbl_merchant_deal));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_category_real, $this->tbl_category));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_deal_category_real, $this->tbl_deal_category));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_type_real, $this->tbl_type));
        $this->db->query(sprintf("insert into %s select * from %s", $this->tbl_deal_type_real, $this->tbl_deal_type));

        $this->db->query(sprintf("delete from %s", $this->tbl_merchant));
        $this->db->query(sprintf("delete from %s", $this->tbl_merchant_product));
        $this->db->query(sprintf("delete from %s", $this->tbl_merchant_deal));
        $this->db->query(sprintf("delete from %s", $this->tbl_category));
        $this->db->query(sprintf("delete from %s", $this->tbl_deal_category));
        $this->db->query(sprintf("delete from %s", $this->tbl_type));
        $this->db->query(sprintf("delete from %s", $this->tbl_deal_type));
    }

    public function __get_parent_categories() {
        $strsql = sprintf("select * from %s where nParentID = 0 order by cName", $this->tbl_category_real);
        $result = $this->db->query($strsql)->result();
        $ret_array = array();
        for ($i = 0; $i < count($result); $i++) {
            $arr_merchants = $this->__get_total_merchants("ALL", $result[$i]->cSlug);
            if (count($arr_merchants) > 0)
                array_push($ret_array, $result[$i]);
        }
        return $ret_array;
    }

    public function __get_alpha_beta_merchants() {
        $ret_array = array();
        foreach (range('A', 'Z') as $char) {
            $ret_array[$char] = 0;
        }
        $ret_array["999"] = 0;
        $result = $this->__get_total_merchants();
        for ($i = 0; $i < count($result); $i++) {
            $first_char = strtoupper(substr($result[$i]->cName, 0, 1));
            if (is_numeric($first_char))
                $ret_array["999"] += 1;
            else
                $ret_array[$first_char] += 1;
        }
        return $ret_array;
    }

    public function __get_total_merchants($store_select = "ALL", $category_select = "exe-all-stores") {
        if ($category_select == "exe-all-stores") {
            $strsql = sprintf("select distinct nMerchantID from %s a inner join %s b on a.nCouponID = b.nCouponID", $this->tbl_merchant_deal_real, $this->tbl_deal_category_real);
            $result = $this->db->query($strsql)->result();
            $strMID = "0";
            for ($i = 0; $i < count($result); $i++) {
                $strMID .= sprintf(",%s", $result[$i]->nMerchantID);
            }

            $strsql = sprintf("select * from %s where nMerchantID in ($strMID) order by cName", $this->tbl_merchant_real);
            $result = $this->db->query($strsql)->result();
        } else {
            $strsql = sprintf("select distinct nMerchantID from %s a inner join %s b on a.nCouponID = b.nCouponID where b.cCategorySlug = '$category_select';", $this->tbl_merchant_deal_real, $this->tbl_deal_category_real);
            $result = $this->db->query($strsql)->result();
            $strMID = "0";
            for ($i = 0; $i < count($result); $i++) {
                $strMID .= sprintf(",%s", $result[$i]->nMerchantID);
            }

            $strsql = sprintf("select * from %s where nMerchantID in ($strMID) order by cName", $this->tbl_merchant_real);
            $result = $this->db->query($strsql)->result();
        }

        if ($store_select == "ALL")
            return $result;

        if ($store_select == "999") {
            $ret_array = array();
            for ($i = 0; $i < count($result); $i++) {
                if (is_numeric(substr($result[$i]->cName, 0, 1))) {
                    array_push($ret_array, $result[$i]);
                }
            }
        } else {
            $ret_array = array();
            for ($i = 0; $i < count($result); $i++) {
                if (strtoupper(substr($result[$i]->cName, 0, 1)) == trim($store_select)) {
                    array_push($ret_array, $result[$i]);
                }
            }
        }

        return $ret_array;
    }

}
