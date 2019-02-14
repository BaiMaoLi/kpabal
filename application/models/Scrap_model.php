
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scrap_model extends CI_Model {

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

    public function get_drama_data($limit = ''){//1
        $tv_db = $this->load->database('db_tv', TRUE);
    	$tv_db->select('*');
        $tv_db->from('tai_scrap');
        $tv_db->group_by('scrap_title'); 
        $tv_db->order_by("scrap_date", "DESC");
        if ($limit !== '') $tv_db->limit($limit);
        $drama = $tv_db->get()->result_array();
        return $drama;
    }

    public function get_newsfromdb($limit = '') {//1
        $tv_db = $this->load->database('db_tv', TRUE);
        $tv_db->select('news_id,news_name,news_channelID');
        $tv_db->from('tai_news');
        $temp1 =  $tv_db->get();
        $temp =array();
        $popular = array();
        $main_news = array();
        $main_news_temp = array();
    
        $count = 0;
        foreach ($temp1->result_array() as $one) {
           if (!empty($one['news_channelID'])){
            $temp[$count] = $one;
            $count++;
           }
        }

        $result = array();
        $count = 0;
        if(!empty($temp)) {
            foreach ($temp as $one) {
                $tv_db->select('*');
                $tv_db->where('news_id', $one['news_id']);
                $tv_db->order_by('create_date', 'desc');
                $tv_db->from('tai_information');
                if ($limit !== '') $tv_db->limit($limit);
                $query =  $tv_db->get();
                $temp_result = $query->result_array();
                foreach ($temp_result as $two) {
                    array_push($main_news_temp, $two);
                }
                $result[$one['news_name']] = $this->array_multi_subsort($temp_result, 'create_date');
                $temp_popular =  $this->array_multi_subsort($temp_result, 'create_date');
                array_push($popular, $temp_popular[0]);
            }
        }else {
            echo "no exist data";
        }
        
        $main_news = $this->array_multi_subsort($main_news_temp, 'create_date');
        $results['news'] = $result;
        $results['popular'] = $popular;
        $results['main'] = $main_news;
        return $results;
    }
}
?>