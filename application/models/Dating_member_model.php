<?php
class Dating_member_Model extends CI_Model {

	protected $datingdb;
    
    public function __construct() {
       // parent::__construct();
	   // $this->load->database();
    	$this->datingdb = $this->load->database('db_dating', true);
    }
    
	public function add_member($data){
  
            $return = $this->datingdb->insert('member', $data);
            if ((bool) $return === TRUE) {
                return $this->datingdb->insert_id();
            } else {
                return $return;
            }       
			
	}	
	
	public function update_member($id,$data){
		$this->datingdb->where('id', $id);
		$return=$this->datingdb->update('member', $data);
		return $return;
		
	}
	
	public function authenticate_member($user_name, $password) {
        $this->datingdb->select('*');
        $this->datingdb->from('member');
        $this->datingdb->where('username', $user_name);
		$this->datingdb->where('password', $password);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	public function authenticate_by_verification_code($vcode) {
        $this->datingdb->select('*');
        $this->datingdb->from('member');
        $this->datingdb->where('verification_code', $vcode);
		$this->datingdb->where('sts =', 'inactive');
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
    
    public function authenticate_by_verification_code2($vcode) {
        $this->datingdb->select('*');
        $this->datingdb->from('member');
        $this->datingdb->where('verification_code', $vcode);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	public function get_member_details_by_id($id){
		/*$this->datingdb->select('member.*, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge');
        $this->datingdb->from('member');
		$this->datingdb->where("id", $id);
        $Q = $this->datingdb->get();*/
		
		$Q = $this->datingdb->query("SELECT *, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge
							   FROM member
							   WHERE id = '".mysqli_real_escape_string($id)."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	public function record_count($tablename,$where=''){
	
		if($where!='')
			$this->datingdb->where($where);
		$this->datingdb->from($tablename);
		return $this->datingdb->count_all_results();
	}
	
	public function record_count_new($tablename,$where=''){
		$sql = "SELECT COUNT(*) AS totalrec FROM $tablename $where";
		$Q = $this->datingdb->query($sql);
        return $Q->row('totalrec');

	}
	
	public function get_all_member($limit, $start){
		$this->datingdb->limit($limit, $start);
		$this->datingdb->select('*');
		$this->datingdb->from('member');
		$this->datingdb->order_by("id", 'DESC');
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_all_member_front($limit, $start){
		$this->datingdb->limit($limit, $start);
		$this->datingdb->select('*');
		$this->datingdb->from('member');
		$this->datingdb->where('sts','active');
		$this->datingdb->order_by("photo", 'DESC');
		$this->datingdb->order_by("id", 'DESC');
		
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	
	public function is_username_already_exists($username){
		$this->datingdb->select('member.username');
        $this->datingdb->from('member');
		$this->datingdb->where("username", $username);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function authenticate_member_by($field, $user_name) {
        $this->datingdb->select('*');
        $this->datingdb->from('member');
        $this->datingdb->where($field, $user_name);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	public function get_member_by_username($username){
		/*$this->datingdb->select('*, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge');
		$this->datingdb->from('member');
		$this->datingdb->where("username", $username);
        $Q = $this->datingdb->get();*/
		
		$Q = $this->datingdb->query("SELECT *, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge
							   FROM member
							   WHERE username = '".$username."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_member_id_by_username($username){
		$this->datingdb->select('id');
		$this->datingdb->from('member');
		$this->datingdb->where("username", $username);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	
	public function get_member_details_by_ids_array($idArray){
		
		$ids = '';
		foreach($idArray as $id) {
			
			$ids .= $id.",";
			
		}
		
		$ids = rtrim(trim($ids),',');
		
		$Q = $this->datingdb->query("SELECT name, gender, city, dob, photo, username, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge
							   FROM member
							   WHERE id IN (".$ids.")
							   ORDER BY name ASC");
        
		if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function search_member($search) {
		//$this->datingdb->limit($limit, $start);
		
		$Q = $this->datingdb->query("SELECT *, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge FROM `member` WHERE TRIM(CONCAT(`name`,' ',username,' ',city,country)) LIKE '%".$search."%'");
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function search_member_advance($lookingFor, $age_frm, $age_to, $name, $email, $martial_status, $smoking, $country, $city) {
		//$this->datingdb->limit($limit, $start);
		$where = '';
		$final_where='';
		if($lookingFor)
			$where.=" gender = '".$lookingFor."' AND";
		if($age_frm && $age_to)
			$where.=" FLOOR(DATEDIFF (NOW(), dob)/365) between '".$age_frm."' AND '".$age_to."' AND";
		if($name)
			$where.=" name LIKE '%".$name."%' AND";
		if($email)
			$where.=" email LIKE '%".$email."%' AND";
		if($martial_status)
			$where.=" marital_status = '".$martial_status."' AND";
		if($smoking)
			$where.=" smoking = '".$smoking."' AND";
		if($city)
			$where.=" city = '".$city."'";
		
		$where = rtrim($where, ' AND');
		if($where!='')
			$final_where = "WHERE sts='Active' AND ".$where;
		$Q = $this->datingdb->query("SELECT *, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge  FROM `member` ".$final_where);

        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_member_username_by_id($id){
		$this->datingdb->select('username');
		$this->datingdb->from('member');
		$this->datingdb->where("id", $id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_all_profiles(){
		$this->datingdb->select('*');
		$this->datingdb->from('member');
		$this->datingdb->order_by("dated", 'DESC');
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function delete_member($id){
		$Q = $this->datingdb->query("Delete FROM `member` WHERE id = '".$id."'");
        $return = 1;
        return $return;
		
	}
	
	public function search_member_name($search) {
		//$this->datingdb->limit($limit, $start);
		
		$Q = $this->datingdb->query("SELECT * FROM `member` WHERE name LIKE '%".$search."%'");
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function search_member_email($search) {
		//$this->datingdb->limit($limit, $start);
		
		$Q = $this->datingdb->query("SELECT * FROM `member` WHERE email LIKE '%".$search."%'");
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function search_member_location($search) {
		//$this->datingdb->limit($limit, $start);
		
		$Q = $this->datingdb->query("SELECT * FROM `member` WHERE TRIM(CONCAT(country,' ',city)) LIKE '%".$search."%'");
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function get_member_name_by_id($id){
		$Q = $this->datingdb->query("SELECT name
							   FROM member
							   WHERE id = '".$id."'");
		
        if ($Q->num_rows() > 0) {
            $row = $Q->row();
			$return = $row->name;
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	public function update_member_privacy($id,$data){
		$this->datingdb->where('mem_id', $id);
		$return=$this->datingdb->update('privacy_settings', $data);
		return $return;
		
	}
	
	public function add_member_privacy($data) {
		
		$return = $this->datingdb->insert('privacy_settings', $data);
		if ((bool) $return === TRUE) {
			return $this->datingdb->insert_id();
		} else {
			return $return;
		}  
		
	}
	
	public function delete_member_privacy($id){
		$Q = $this->datingdb->query("Delete FROM `privacy_settings` WHERE mem_id = '".$id."'");
        $return = 1;
        return $return;
		
	}
	
	public function get_member_privacy_by_mem_id($id){
		
		$Q = $this->datingdb->query("SELECT *
							   FROM privacy_settings
							   WHERE mem_id = '".$id."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	
	}
	
	public function get_near_located_member($city){
		/*$this->datingdb->select('*, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge');
		$this->datingdb->from('member');
		$this->datingdb->where("username", $username);
        $Q = $this->datingdb->get();*/
		
		$Q = $this->datingdb->query("SELECT *, FLOOR(DATEDIFF (NOW(), dob)/365) AS mAge
							   FROM member
							   WHERE LOWER(city) = '".strtolower($city)."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
	
	public function get_member_by_email($email){
		$Q = $this->datingdb->query("SELECT verification_code FROM member WHERE email = '".$email."'");
		
        if ($Q->num_rows() > 0) {
            $return = $Q->row('verification_code');
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
	}
	
}
?>