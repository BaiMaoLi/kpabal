<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shopping_model extends CI_Model {
    var $tbl_member = "tbl_member";
    var $tbl_name = "shopping_mall";
    var $tbl_category = "shopping_category";
    var $tbl_order = "shopping_order";
    var $tbl_cart = "shopping_cart";
    var $tbl_order_detail = "shopping_order_detail";
    var $tbl_order_history = "shopping_order_history";
    var $tbl_payment_history = "shopping_payment_history";
    var $tbl_product = "shopping_product";
    var $tbl_status = "shopping_order_status";

    public function get_item($mallIdx) {
        $query = $this->db->get_where($this->tbl_name, array("mallIdx" => $mallIdx));
        $result = $query->result();
        if($result) {
            return $result[0];
        }
        return false;
    }

    public function remove_data($mallIdx) {
        $this->db->delete($this->tbl_name, array("mallIdx" => $mallIdx));
    }

    public function save_data($row, $memberIdx = 0) {

        $mall_info = [];
        $mall_info["is_display"] = 0;

        foreach ($row as $key => $value) {
            if($key != "mallIdx") {
                if($key == "is_display")
                    $mall_info[$key] = (($value == "on")?1:0);
                else
                    $mall_info[$key] = $value;
            }
        }

        if($row['mallIdx']) {
            $this->db->update($this->tbl_name, $mall_info, array("mallIdx" => $row["mallIdx"]));
        } else {
            if($memberIdx)
                $mall_info["memberIdx"] = $memberIdx;
            $this->db->insert($this->tbl_name, $mall_info);
            return $this->db->insert_id();
        }

        return $row['mallIdx'];
    }

    public function save_product_data($row) {
        $product_info = [];
        $product_info["is_display"] = 0;

        foreach ($row as $key => $value) {
            if($key != "productIdx") {
                if(($key == "is_display") || ($key == "product_level") || ($key == "freeShipping"))
                    $product_info[$key] = (($value == "on")?1:0);
                else
                    $product_info[$key] = $value;
            }
        }

        if($row['productIdx']) {
            $this->db->update($this->tbl_product, $product_info, array("productIdx" => $row["productIdx"]));
        } else {
            $this->db->insert($this->tbl_product, $product_info);
            return $this->db->insert_id();
        }

        return $row['productIdx'];
    }

    public function get_items_count($category = "", $search="") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%'";
        if($search) $strsql .= " and (mall_title LIKE '%".$search."%' or mall_site_url LIKE '%".$search."%' or mall_address LIKE '%".$search."%')";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_items($category = "", $order_id="mall_title", $order_dir="desc", $offset=0, $limit=10, $search="") {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where categoryIdx LIKE '".$category."%'";
        if($search) $strsql .= " and (mall_title LIKE '%".$search."%' or mall_site_url LIKE '%".$search."%' or mall_address LIKE '%".$search."%')";
        $strsql .= " order by ".$order_id." ".$order_dir." limit ".$offset.", ".$limit;
        $result = $this->db->query($strsql)->result();
        return $result;
    }

    public function get_product_item($productIdx = 0) {
        $strsql = "select * from tbl_".($this->tbl_product)." where productIdx = '".$productIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result) > 0) return $result[0];
        return false;
    }

    public function get_recommended_products($mallIdx = 0, $productIdx = 0) {
        $strsql = "select *, (mallIdx = 1) mall_check from tbl_shopping_product where product_level = 1 and productIdx <> '".$productIdx."' order by mall_check desc, created_at desc limit 5";
        return $this->db->query($strsql)->result();
    }

    public function get_recent_products($mallIdx = 0, $productIdx = 0) {
        $strsql = "select *, (mallIdx = 1) mall_check from tbl_shopping_product where productIdx <> '".$productIdx."' order by mall_check desc, created_at desc limit 10";
        return $this->db->query($strsql)->result();
    }

    public function get_category_for_mall($mallIdx = 0) {
        $strsql = "select a.*, b.mall_title from tbl_".($this->tbl_category)." a inner join tbl_".($this->tbl_name)." b on a.categoryIdx = b.categoryIdx where b.mallIdx = '".$mallIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0];
        return false;
    }

    public function get_product_items_count($mallIdx = 0, $search = "") {
        
        $strsql = "select count(*) cn from tbl_".($this->tbl_product)." where (1=1)";
        if($mallIdx) $strsql .= " and mallIdx = '".$mallIdx."'";
        if($search) $strsql .= " and (product_title LIKE '%".$search."%')";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_product_items($mallIdx = 0, $order_id="product_title", $order_dir="desc", $offset=0, $limit=10, $search="") {
        
        $strsql = "select * from tbl_".($this->tbl_product)." where (1=1)";
        if($mallIdx) $strsql .= " and mallIdx = '".$mallIdx."'";
        if($search) $strsql .= " and (product_title LIKE '%".$search."%')";
        $strsql .= " order by ".$order_id." ".$order_dir." limit ".$offset.", ".$limit;
        $result = $this->db->query($strsql)->result();
        return $result;
    }

    public function get_order_items_count($mallIdx = 0, $statusIdx = 0, $search = "") {
        
        $strsql = "select count(a.orderIdx) cn from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx = b.mallIdx inner join tbl_member c ON a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_status)." d ON a.statusIdx = d.statusIdx where (1=1)";
        if($mallIdx) $strsql .= " and a.mallIdx = '".$mallIdx."'";
        if($statusIdx) $strsql .= " and a.statusIdx = '".$statusIdx."'";
        if($search) $strsql .= " and (c.user_id LIKE '%".$search."%' OR a.emailAddress LIKE '%".$search."%' OR a.phoneNumber LIKE '%".$search."%')";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_order_items($mallIdx = 0, $statusIdx = 0, $order_id="mall_title", $order_dir="desc", $offset=0, $limit=10, $search="") {
        
        $strsql = "select a.*, b.mall_title, c.user_id orderer_name, d.statusName from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx = b.mallIdx inner join tbl_member c ON a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_status)." d ON a.statusIdx = d.statusIdx where (1=1)";
        if($mallIdx) $strsql .= " and a.mallIdx = '".$mallIdx."'";
        if($statusIdx) $strsql .= " and a.statusIdx = '".$statusIdx."'";
        if($search) $strsql .= " and (c.user_id LIKE '%".$search."%' OR a.emailAddress LIKE '%".$search."%' OR a.phoneNumber LIKE '%".$search."%')";
        $strsql .= " order by ".$order_id." ".$order_dir." limit ".$offset.", ".$limit;
        $result = $this->db->query($strsql)->result();
        return $result;
    }

    public function get_payment_items_count($mallIdx = 0, $search = "") {
        
        $strsql = "select count(d.historyIdx) cn from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx = b.mallIdx inner join tbl_member c ON a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_payment_history)." d ON a.orderIdx = d.orderIdx where (1=1)";
        if($mallIdx) $strsql .= " and a.mallIdx = '".$mallIdx."'";
        if($search) $strsql .= " and (c.user_id LIKE '%".$search."%' OR d.paymentKind LIKE '%".$search."%' OR d.paymentNote LIKE '%".$search."%')";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function get_payment_items($mallIdx = 0, $order_id="mall_title", $order_dir="desc", $offset=0, $limit=10, $search="") {
        
        $strsql = "select d.*, b.mall_title, c.user_id orderer_name from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx = b.mallIdx inner join tbl_member c ON a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_payment_history)." d ON a.orderIdx = d.orderIdx where (1=1)";
        if($mallIdx) $strsql .= " and a.mallIdx = '".$mallIdx."'";
        if($search) $strsql .= " and (c.user_id LIKE '%".$search."%' OR d.paymentKind LIKE '%".$search."%' OR d.paymentNote LIKE '%".$search."%')";
        $strsql .= " order by ".$order_id." ".$order_dir." limit ".$offset.", ".$limit;
        $result = $this->db->query($strsql)->result();
        return $result;
    }

    public function get_statuses()
    {
        $strsql = "select * from tbl_".($this->tbl_status)." order by statusIdx";

        return $this->db->query($strsql)->result();
    }

    public function get_malles($categoryIdx = "", $is_all = true)
    {
        $strsql = "select * from tbl_".($this->tbl_name)." where left(categoryIdx, ".strlen($categoryIdx).") = '".$categoryIdx."' ".(($is_all)?"":" and is_display = 1")." order by mall_title";

        return $this->db->query($strsql)->result();
    }

    public function product_remove_data($productIdx)
    {
        $this->db->delete($this->tbl_product, array("productIdx" => $productIdx));
    }

    public function get_order_detail($orderIdx)
    {
        $order_info = new \stdClass();

        $strsql = "select a.*, b.mall_title, c.user_id orderer_name, d.statusName from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx = b.mallIdx inner join tbl_member c ON a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_status)." d ON a.statusIdx = d.statusIdx where a.orderIdx = '".$orderIdx."'";
        $result = $this->db->query($strsql)->result();

        if(count($result))
            $order_info->main = $result[0];
        else
            $order_info->main = false;

        $strsql = "select a.*, product_title from tbl_".($this->tbl_order_detail)." a inner join tbl_".($this->tbl_product)." b on a.productIdx = b.productIdx where a.orderIdx = '".$orderIdx."'";
        $order_info->detail = $this->db->query($strsql)->result();

        $strsql = "select a.*, statusName from tbl_".($this->tbl_order_history)." a inner join tbl_".($this->tbl_status)." b on a.statusIdx = b.statusIdx where a.orderIdx = '".$orderIdx."'";
        $order_info->history = $this->db->query($strsql)->result();

        return $order_info;
    }

    public function get_product_for_category($categoryIdx = '', $offset = 12) 
    {
        $strsql = "select a.* from tbl_".$this->tbl_product." a inner join tbl_".$this->tbl_name." b on a.mallIdx = b.mallIdx where left(b.categoryIdx, 2) = '".$categoryIdx."' and a.is_display=1 order by a.product_level desc, a.product_price desc limit ".$offset;

        return $this->db->query($strsql)->result();
    }

    public function get_product_for_mall($mallIdx = 0, $offset = 12)
    {
        $strsql = "select * from tbl_".$this->tbl_product." where mallIdx = '".$mallIdx."' and is_display=1 order by product_level desc, product_price desc limit ".$offset;

        return $this->db->query($strsql)->result();
    }

    public function search_my_malles_count($memberIdx = 0)
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_name)." where memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_my_malles($memberIdx = 0, $page_number = 0, $offset = 10, $order_fld = "created_at desc")
    {
        $strsql = "select a.*, b.categoryName from tbl_".($this->tbl_name)." a inner join tbl_".($this->tbl_category)." b on a.categoryIdx = b.categoryIdx where memberIdx='".$memberIdx."' order by ".$order_fld." limit ".($page_number * $offset).", ".$offset;
        return $this->db->query($strsql)->result();
    }

    public function search_my_mall_product_count($memberIdx = 0, $search_key = "")
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_product)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx=b.mallIdx where memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_my_mall_product($memberIdx = 0, $search_key = "", $page_number = 0, $offset = 10)
    {
        $strsql = "select a.*, b.mall_title from tbl_".($this->tbl_product)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx=b.mallIdx where memberIdx='".$memberIdx."' order by a.created_at desc limit ".($page_number * $offset).", ".$offset;
        return $this->db->query($strsql)->result();
    }

    public function search_mall_order_count($memberIdx = 0)
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx=b.mallIdx where b.memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }    

    public function get_order_detail_info($orderIdx)
    {
        $strsql = "select a.*, product_title from tbl_".($this->tbl_order_detail)." a inner join tbl_".($this->tbl_product)." b on a.productIdx = b.productIdx where a.orderIdx = '".$orderIdx."'";
        return $this->db->query($strsql)->result();
    }

    public function search_mall_order($memberIdx = 0, $page_number = 0, $offset = 10)
    {
        $strsql = "select a.*, b.mall_title, concat(c.first_name, ' ', c.last_name) as user_full_name, d.statusName from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx=b.mallIdx inner join ".($this->tbl_member)." c on a.memberIdx = c.memberIdx inner join tbl_".($this->tbl_status)." d on a.statusIdx = d.statusIdx where b.memberIdx='".$memberIdx."' order by a.orderDate desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->order_detail = $this->get_order_detail_info($result[$i]->orderIdx);
        }

        return $result;
    }

    public function search_mall_payment_count($memberIdx = 0)
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_payment_history)." a inner join tbl_".($this->tbl_order)." b on a.orderIdx=b.orderIdx inner join tbl_".($this->tbl_name)." c on b.mallIdx=c.mallIdx where c.memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_mall_payment($memberIdx = 0, $page_number = 0, $offset = 10)
    {
        $strsql = "select a.*, b.mallIdx, c.mall_title, concat(d.first_name, ' ', d.last_name) as user_full_name from tbl_".($this->tbl_payment_history)." a inner join tbl_".($this->tbl_order)." b on a.orderIdx = b.orderIdx inner join tbl_".($this->tbl_name)." c on b.mallIdx=c.mallIdx inner join ".($this->tbl_member)." d on b.memberIdx = d.memberIdx where c.memberIdx='".$memberIdx."' order by a.paymentDate desc limit ".($page_number * $offset).", ".$offset;
        return $this->db->query($strsql)->result();
    }

    public function add_cart($memberIdx, $productIdx, $add_amount = 1)
    {
        $strsql = "select * from tbl_".($this->tbl_cart)." where memberIdx = '".$memberIdx."' and productIdx = '".$productIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) {
            $this->db->update($this->tbl_cart, array("productAmount" => $result[0]->productAmount + $add_amount), array("memberIdx" => $memberIdx, "productIdx" => $productIdx));
        } else {
            $this->db->insert($this->tbl_cart, array("memberIdx" => $memberIdx, "productIdx" => $productIdx, "productAmount" => $add_amount));
        }
    }

    public function set_cart_amount($memberIdx, $productIdx, $set_amount = 0)
    {
        $strsql = "select * from tbl_".($this->tbl_cart)." where memberIdx = '".$memberIdx."' and productIdx = '".$productIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) {
            if($set_amount)
                $this->db->update($this->tbl_cart, array("productAmount" => $set_amount), array("memberIdx" => $memberIdx, "productIdx" => $productIdx));
            else
                $this->db->delete($this->tbl_cart, array("memberIdx" => $memberIdx, "productIdx" => $productIdx));
        } else {
            if($set_amount) {
                $this->db->insert($this->tbl_cart, array("memberIdx" => $memberIdx, "productIdx" => $productIdx, "productAmount" => $set_amount));
            }
        }
    }

    public function get_user_carts($memberIdx = 0)
    {
        $strsql = "select a.*, b.product_title, b.product_price, b.mallIdx from tbl_".($this->tbl_cart)." a inner join tbl_".($this->tbl_product)." b on a.productIdx = b.productIdx where memberIdx = '".$memberIdx."'";
        return $this->db->query($strsql)->result();
    }

    public function place_order($row, $memberIdx)
    {
        $carts = $this->get_user_carts($memberIdx);
        if(count($carts)) {
            $shippingAddress = $row['shippingAddress'];
            $emailAddress = $row['emailAddress'];
            $phoneNumber = $row['phoneNumber'];

            $malls = [];

            foreach ($carts as $product) {
                if(!isset($malls[$product->mallIdx])) $malls[$product->mallIdx] = [];
                array_push($malls[$product->mallIdx], $product);
            }

            foreach ($malls as $mallIdx => $mall) {
                $total_amount = 0;
                foreach ($mall as $product) {
                    $total_amount += $product->product_price * $product->productAmount;
                }
                if($total_amount) {
                    $this->db->insert($this->tbl_order, array("mallIdx" => $mallIdx, "memberIdx" => $memberIdx, "shippingAddress" => $shippingAddress, "emailAddress" => $emailAddress, "phoneNumber" => $phoneNumber, "totalAmount" => $total_amount, "statusIdx" => 1));
                    $orderIdx = $this->db->insert_id();

                    foreach ($mall as $product) {
                        $this->db->insert($this->tbl_order_detail, array("orderIdx" => $orderIdx, "productIdx" => $product->productIdx, "productOrderPrice" => $product->product_price, "productAmount" => $product->productAmount));
                    }

                    $this->db->insert($this->tbl_order_history, array("orderIdx" => $orderIdx, "historyContent" => "Order Placed", "statusIdx" => 1));

                    $this->db->delete($this->tbl_cart, array("memberIdx" => $memberIdx));
                }
            }
        }
    }

    public function search_my_order_count($memberIdx = 0)
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_order)." a where a.memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }   

    public function search_my_order($memberIdx = 0, $page_number = 0, $offset = 10)
    {
        $strsql = "select a.*, b.mall_title, d.statusName from tbl_".($this->tbl_order)." a inner join tbl_".($this->tbl_name)." b on a.mallIdx=b.mallIdx inner join tbl_".($this->tbl_status)." d on a.statusIdx = d.statusIdx where a.memberIdx='".$memberIdx."' order by a.orderDate desc limit ".($page_number * $offset).", ".$offset;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->order_detail = $this->get_order_detail_info($result[$i]->orderIdx);
        }

        return $result;
    }

    public function search_my_payment_count($memberIdx = 0)
    {
        $strsql = "select count(*) cn from tbl_".($this->tbl_payment_history)." a inner join tbl_".($this->tbl_order)." b on a.orderIdx=b.orderIdx where b.memberIdx='".$memberIdx."'";
        $result = $this->db->query($strsql)->result();
        if(count($result)) return $result[0]->cn;
        return 0;
    }

    public function search_my_payment($memberIdx = 0, $page_number = 0, $offset = 10)
    {
        $strsql = "select a.*, b.mallIdx, c.mall_title from tbl_".($this->tbl_payment_history)." a inner join tbl_".($this->tbl_order)." b on a.orderIdx = b.orderIdx inner join tbl_".($this->tbl_name)." c on b.mallIdx=c.mallIdx where b.memberIdx='".$memberIdx."' order by a.paymentDate desc limit ".($page_number * $offset).", ".$offset;
        return $this->db->query($strsql)->result();
    }

}
