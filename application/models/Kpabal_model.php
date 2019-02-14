
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kpabal_model extends CI_Model {
    //public $tv_db;
    function __construct() {
		parent::__construct();

        //$tv_db = $this->load->database('db_tv', TRUE);
	}
    
    public function array_multi_subsort($array, $subkey){
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

    public function get_news_totalCount() {
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('count(*) as allcount');
      	$tv_db->from('tai_information');
      	$tv_db->where('news_id !=', '0');
      	$query = $tv_db->get();
      	$result = $query->result_array();      
      	return $result[0]['allcount'];
    }
    
    public function get_news_pageData($start_offset,$recordPerPage){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('*');
		$tv_db->from('tai_information');
		$tv_db->where('news_id !=' ,'0');
		$tv_db->order_by('create_date','DESC');
        $tv_db->limit($recordPerPage, $start_offset);  
		$query = $tv_db->get();       	
		return $query->result_array();
    }
    
    public function get_sports_totalCount() {
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.vc_id');
      	$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'sport');
      	$result = $tv_db->get()->num_rows();
      	return $result;
    }
    
    public function get_sports_pageData($start_offset,$recordPerPage){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.*');
		$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'sport');
		$tv_db->order_by('create_date','DESC');
        $tv_db->limit($recordPerPage, $start_offset);  
		$query = $tv_db->get();       	
		return $query->result_array();
    }
    
    public function get_music_totalCount() {
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.vc_id');
      	$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'music');
      	$result = $tv_db->get()->num_rows();
      	return $result;
    }
    
    public function get_music_pageData($start_offset,$recordPerPage){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.*');
		$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'music');
		$tv_db->order_by('create_date','DESC');
        $tv_db->limit($recordPerPage, $start_offset);  
		$query = $tv_db->get();       	
		return $query->result_array();
    }
    
    public function get_trending_totalCount() {
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.vc_id');
      	$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'trending');
      	$result = $tv_db->get()->num_rows();
      	return $result;
    }
    
    public function get_trending_pageData($start_offset,$recordPerPage){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('tai_information.*');
		$tv_db->from('tai_category');
      	$tv_db->join('tai_information', 'tai_information.category_id = tai_category.cate_id');
      	$tv_db->where('tai_category.cate_name', 'trending');
		$tv_db->order_by('create_date','DESC');
        $tv_db->limit($recordPerPage, $start_offset);  
		$query = $tv_db->get();       	
		return $query->result_array();
    }
    
    public function get_drama_totalCount() {
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('scrap_id');
      	$tv_db->from('tai_scrap');
      	$result = $tv_db->get()->num_rows();
      	return $result;
    }
    
    public function get_drama_pageData($start_offset,$recordPerPage){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
    	$tv_db->select('*');
		$tv_db->from('tai_scrap');
		$tv_db->order_by('scrap_date','DESC');
        $tv_db->limit($recordPerPage, $start_offset);  
		$query = $tv_db->get();       	
		return $query->result_array();
    }
    
    public function get_category($id=""){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $tv_db->select("news_name");
        $tv_db->from("tai_news");
        $res=$tv_db->get();
        $result['news']=$res->result_array();

        $tv_db->select("country_name");
        $tv_db->from("tai_country");
        $res=$tv_db->get();
        $result['country']=$res->result_array();

        $tv_db->select("cate_name");
        $tv_db->from("tai_category");
        $res=$tv_db->get();
        $result['category']=$res->result_array();
        return $result;
    }
    
    public function get_videoinfo($id=""){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $tv_db->select("*");
        $tv_db->where("vc_id", $id);
        $tv_db->from("tai_information");
        $res=$tv_db->get();
        $result=$res->result_array();
        return $result[0];
    }
    
    public function get_drama_sublinks($id){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $tv_db->select("scrap_title");
        $tv_db->where("scrap_id", $id);
        $tv_db->from("tai_scrap");
        $title=$tv_db->get()->result_array();
        
        $tv_db->select("*");
        $tv_db->where("scrap_title", $title[0]['scrap_title']);
        $tv_db->from("tai_scrap");
        $query=$tv_db->get()->result_array();
        $result = [];
        foreach($query as $one){
            $result[$one['scrap_id']] = $one;
        }
        return $result;
    }
    
    public function get_drama_info($id){
        $CI = &get_instance();
        $tv_db = $CI->load->database('db_tv', TRUE);
        $tv_db->select("*");
        $tv_db->where("scrap_id", $id);
        $tv_db->from("tai_scrap");
        $result=$tv_db->get()->result_array();
        return $result[0];
    }
    
}
?>