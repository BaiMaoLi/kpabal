<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant_model extends CI_Model {
	
    public function save_restaurant($row){
				
		$tbl_name = "restaurant";
		
		$restaurant_info = [];
	
        foreach ($row as $key => $value) {
            if($key != "id") {
                $restaurant_info[$key] = $value;
            }
        }
		
		
		
        $restaurant_info['posted_date'] = date("Y-m-d H:i:s");
		$this->db->insert('tbl_restaurant', $restaurant_info);
        return $this->db->insert_id();
        
			
		
	}
	
	
	public function get_restaurant(){
		
		// $this->db->select('*');
		// $this->db->from('tbl_restaurant');
		// $query = $this->db->get();
				
		// return $query->result();
		
		$query = "SELECT * FROM tbl_restaurant order by review_count desc";
		

		$result = $this->db->query($query)->result();
				
        return $result;
		
		
		 
		 
	}
	
	public function getReviews(){
		
		$query = "SELECT * FROM tbl_restaurant_review order by id desc";
		
		$result = $this->db->query($query)->result();
				
        return $result;
	
	}
	
	
	public function get_restaurant_block_add(){
		
		$this->db->select('*');
		$this->db->from('tbl_restaurant_add_block');
		$query = $this->db->get();
				
		return $query->result();
		 
		 
	}	 
	
	public function get_restaurant_slide(){
		
		$this->db->select('*');
		$this->db->from('tbl_restaurant_ranking');
		$query = $this->db->get();
				
		return $query->result();
		 
		 
	}
	
	public function get_blogs(){
		
		$this->db->select('*');
		$this->db->from('tbl_ourblog');
		$this->db->where('status', 1);
		$query = $this->db->get();
				
		return $query->result();
		 
		 
	}
	
	
		public function get_restaurant_details($id) {
        $query = $this->db->get_where('tbl_restaurant', array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }
	
	
	public function get_blog_details($id) {
        $query = $this->db->get_where('tbl_ourblog', array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }
	
	
	
	
	
	
	public function get_restaurant_reviews($id) {
		
		
		
		$query = "SELECT * FROM tbl_restaurant_review WHERE restaurant_id='$id'";
						
		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	public function get_restaurant_rating($id) {
		
		
		
		//$query = "SELECT * FROM tbl_restaurant_review WHERE restaurant_id='$id'";
		$query = "SELECT AVG(rating) AS AverageRating FROM tbl_restaurant_review WHERE restaurant_id='$id'";

		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	public function fetch_restro_by_state($id) {
		
		
				
		$query = "SELECT * FROM tbl_restaurant WHERE restaurant_state='$id' order by review_count desc";
		

		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	
	public function fetch_ranking_restro_by_state($id) {
		$query = "SELECT * FROM tbl_restaurant_ranking WHERE state='$id'";
		$result = $this->db->query($query)->result();
				
        return $result;
	}	
	
	
	
	public function get_recent_restaurant_reviews() {
		
		
		
		$query = "SELECT * FROM tbl_restaurant_review order by id desc";
						
		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	
	
	 public function save_reviews($row){
				
				
		$restaurant_info = [];
		$restaurant_info['posted_date'] = date("Y-m-d");
        foreach ($row as $key => $value) {
            if($key != "id") {
                $restaurant_info[$key] = $value;
            }
        }
					
        
		$this->db->insert('tbl_restaurant_review', $restaurant_info);
		
		$res_id = $restaurant_info['restaurant_id'];
		
		$query = "SELECT COUNT(*) as count_review FROM tbl_restaurant_review WHERE restaurant_id = $res_id";
						
		$result = $this->db->query($query)->result();
		
		
		
		foreach($result as $res){
			
			$count_rev = $res->count_review;
		}
		
		
		
		$this->db->set('review_count', $count_rev);  
		$this->db->where('id', $res_id); 
		$true = $this->db->update('tbl_restaurant'); 
					
		
        return $true;
        
			
		
	}
	
	
	
	public function save_add_block($row){
	
	$restaurant_info = [];
	
        foreach ($row as $key => $value) {
            if($key != "id") {
                $restaurant_info[$key] = $value;
            }
        }
				
		
		$this->db->insert('tbl_restaurant_add_block', $restaurant_info);
        return $this->db->insert_id();
		
	}	
	
	
	
		public function save_slide($row){
	
		$restaurant_info = [];
	
        foreach ($row as $key => $value) {
            if($key != "id") {
                $restaurant_info[$key] = $value;
            }
        }
				
		
		$this->db->insert('tbl_restaurant_ranking', $restaurant_info);
        return $this->db->insert_id();
		
	}
	
	
	
	
	public function delete_restro($id){
										
		$this->db->where('id', $id);
		$query = $this->db->delete('tbl_restaurant');		
		
		return $query;
		 
		 
	}
	
	public function delete_review($id){
										
		$this->db->where('id', $id);
		$query = $this->db->delete('tbl_restaurant_review');		
		return $query;		 
		 
	}
	
	public function set_review_status($id){		


		$query = "SELECT status FROM tbl_restaurant_review WHERE id='$id'";
		
		$result = $this->db->query($query)->result();
				
      
		foreach($result as $status){
			$review_status = $status->status;
		}
			 
		 
		if($review_status == 0){			
			$this->db->set('status','1');
			$this->db->where('id', $id);
			$query = $this->db->update('tbl_restaurant_review');		
			return $query;
		}else{
			$this->db->set('status','0');
			$this->db->where('id', $id);
			$query = $this->db->update('tbl_restaurant_review');		
			return $query;
		}
	
				 
		 
	}
	
	public function update_review($data){
		$id = $data['id'];		
		$this->db->where('id', $id);
		unset($data['id']);
		$query = $this->db->update('tbl_restaurant_review',$data);		
		return $query;
	
	}
	
	public function delete_restro_block($id){
										
		$this->db->where('id', $id);
		$query = $this->db->delete('tbl_restaurant_add_block');		
		
		return $query;
		 
		 
	}
	
	
	public function delete_ranking_slide($id){
										
		$this->db->where('id', $id);
		$query = $this->db->delete('tbl_restaurant_ranking');		
		
		return $query;
		 
		 
	}
	
	
	
	
	public function get_restaurant_block_record($id) {							
		$query = "SELECT * FROM tbl_restaurant_add_block WHERE id='$id'";
		$result = $this->db->query($query)->result();				
        return $result;	       
		
    }
	
	
		public function get_ranking_slide_record($id) {
		
		
				
		$query = "SELECT * FROM tbl_restaurant_ranking WHERE id='$id'";
		

		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	public function get_restaurantby_id($id) {
		
		
				
		$query = "SELECT * FROM tbl_restaurant WHERE id='$id'";
		

		$result = $this->db->query($query)->result();
				
        return $result;
				       
		
    }
	
	
	public function update_restaurant_block($update_data) {
	//print_r($update_data);			
	$this->db->where('id', $update_data['post_id']);
	unset($update_data['post_id']);
	
	$target_dir = FCPATH."assets/restaurant_add_block/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$save_path = "assets/restaurant_add_block/";
	$final_path = $save_path . basename($_FILES["image"]["name"]);
				
	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
		$update_data['image'] = $final_path;
	}
		
	$true = $this->db->update('tbl_restaurant_add_block', $update_data);
		
	return $true;
		
		
	}	
	
	public function update_restaurant_slide($update_data) {
	//print_r($update_data);			
	$this->db->where('id', $update_data['post_id']);
	unset($update_data['post_id']);
	
	
			$target_dir = FCPATH."assets/restaurant_slide/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$save_path = "assets/restaurant_slide/";
			$final_path = $save_path . basename($_FILES["image"]["name"]);
				
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
			
				$update_data['image'] = $final_path;
			}
		
		
	$true = $this->db->update('tbl_restaurant_ranking', $update_data);
		
	return $true;
		
		
	}
	
	
	public function update_restaurant($update_data) {
		
	$this->db->where('id', $update_data['post_id']);
	unset($update_data['post_id']);			
	$true = $this->db->update('tbl_restaurant', $update_data);
		
	return $true;
	
	}
	
	public function get_relative_state() { 
	
		$query = "SELECT DISTINCT state FROM tbl_restaurant_ranking";
		
		$result = $this->db->query($query)->result();
				
        return $result;
	
	}
	
	public function update_restaurant_foodtype($update_data){			
								
		$true = $this->db->insert('tbl_foodtype', $update_data);
		
		return $true;
	}
	
	
	public function get_food_types(){			
								
		$query = "SELECT * FROM tbl_foodtype";
		
		$result = $this->db->query($query)->result();
				
        return $result;
	}
	
	
	public function remove_restaurant_foodtype($id){			
									

		$this->db->where('id', $id);
		$result = $this->db->delete('tbl_foodtype');		

		
        return $result;
	}
	
	public function save_banner($data){
		$this->db->insert('tbl_banner', $data);
        return $this->db->insert_id();
	
	}
	
	public function fetch_banner_info(){
		
		$query = "SELECT * FROM tbl_banner";
		
		$result = $this->db->query($query)->result();
				
        return $result;
	}	
	
	
}	