<?php
class Ads_Model extends CI_Model {

    protected $datingdb;
    public function __construct() {
       // $this->load->database();
        $this->datingdb = $this->load->database('db_dating', TRUE);
    }
        
    public function get_content() {
        $Q = $this->datingdb->query("SELECT * FROM ads where ID = '1'");
        if ($Q->num_rows > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
        
    }

    public function update_records($data){
        $this->datingdb->where('ID', 1);
        $return=$this->datingdb->update('ads', $data);
        return $return;
    }
    
}
?>
