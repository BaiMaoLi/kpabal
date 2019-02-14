<?php
class Contact_Model extends CI_Model {

	protected $datingdb;

    public function __construct() {
       // parent::__construct();
	   // $this->load->database();
    	$this->datingdb = $this->load->database('db_dating', TRUE);
    }
    
	public function add_contact($data){
  
            $return = $this->datingdb->insert('contact_us', $data);
            if ((bool) $return === TRUE) {
                return $this->datingdb->insert_id();
            } else {
                return $return;
            }       
			
	}
	
	public function getPageContent($id='') {
		
		$Q = $this->datingdb->query("SELECT * FROM page_content where page_id = '".$id."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
		
	}
	
	public function getAllPageContent() {
		
		$Q = $this->datingdb->query("SELECT * FROM page_content");
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
		
	}
	
	public function update_content($id,$data){
		$this->datingdb->where('page_id', $id);
		$return=$this->datingdb->update('page_content', $data);
		return $return;
		
	}
	
}
?>
