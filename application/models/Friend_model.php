<?php
class Friend_Model extends CI_Model {

	protected $datingdb;

    public function __construct() {
	   // $this->load->database();
    	$this->datingdb = $this->load->database('db_dating', true);
    }
		
	public function get_all_frieds(){
		$this->datingdb->select('*');
		$this->datingdb->from('circle');
		$this->datingdb->order_by('id','DESC');
		
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
		
	}
	
	public function add_friend($data) {
		  return $this->datingdb->insert('circle', $data);		  
    }
	
	public function edit_friend($id, $data) {
		  $this->datingdb->where('member_id', $id);
		  $this->datingdb->where('friend_id', $this->session->userdata('member_id'));
		  $this->datingdb->update('circle', $data);
		  
    }
	
	public function edit_friend_statuses($id, $data) {
		  $this->datingdb->where('member_id', $this->session->userdata('member_id'));
		  $this->datingdb->where('friend_id', $id);
		  $this->datingdb->update('circle', $data);
		  
    }
	
	public function get_request_sent_friends_by_status($id,$status){
		$this->datingdb->select('member.id, member.username, member.gender, member.dob, member.name, member.photo, member.city, member.country, circle.status');
		$this->datingdb->from('member');
		$this->datingdb->join('circle', 'member.id = circle.friend_id', 'inner');
		$this->datingdb->where("circle.status", $status);
		$this->datingdb->where("circle.member_id", $id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_request_received_friends_by_status($id,$status){
		$this->datingdb->select('member.id, member.username, member.gender, member.dob, member.name, member.photo, member.city, member.country, circle.status');
		$this->datingdb->from('member');
		$this->datingdb->join('circle', 'member.id = circle.member_id', 'inner');
		$this->datingdb->where("circle.status", $status);
		$this->datingdb->where("circle.friend_id", $id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_all_approved_friends($id){
		/*$this->datingdb->select('member.*');
		$this->datingdb->from('member');
		$this->datingdb->join('circle', 'member.id = circle.friend_id', 'inner');
		$this->datingdb->where("circle.status", 'approved');
		$this->datingdb->where("circle.member_id", $id);
        $Q = $this->datingdb->get();*/
		
		$Q = $this->datingdb->query("SELECT member.*, FLOOR(DATEDIFF (NOW(), member.dob)/365) AS mAge
								FROM member
								INNER JOIN circle
								ON member.id = circle.friend_id
								WHERE circle.status = 'approved' AND circle.member_id = ".$id."
								ORDER BY circle.dated ASC");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function friendship_validations($id){
		$this->datingdb->select('*');
		$this->datingdb->from('circle');
		$this->datingdb->where("friend_id", $id);
		$this->datingdb->where("member_id", $this->session->userdata('member_id'));
		$this->datingdb->where("status !=", 'discard');
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_friends_by_status($id,$status){
		$this->datingdb->select('member.*');
		$this->datingdb->from('member');
		$this->datingdb->join('circle', 'member.id = circle.friend_id', 'inner');
		$this->datingdb->where("circle.status", $status);
		$this->datingdb->where("circle.member_id", $id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_favourite_friends($id){
		$this->datingdb->select('member.*');
		$this->datingdb->from('member');
		$this->datingdb->join('circle', 'member.id = circle.friend_id', 'inner');
		$this->datingdb->where("circle.is_favourite", 'yes');
		$this->datingdb->where("circle.member_id", $id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function friendship_favourite($id){
		$this->datingdb->select('*');
		$this->datingdb->from('circle');
		$this->datingdb->where("friend_id", $id);
		$this->datingdb->where("member_id", $this->session->userdata('member_id'));
		$this->datingdb->where("is_favourite", 'yes');
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function isfriends($mem_id, $mem_id2) {
		
		$Q = $this->datingdb->query("SELECT *
								FROM circle
								WHERE status = 'approved' AND member_id = ".$mem_id." AND friend_id = ".$mem_id2."
							 ");
		
        if ($Q->num_rows() > 0) {
            $row = $Q->row();
			$return = 1;
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
		
	}

}
?>
