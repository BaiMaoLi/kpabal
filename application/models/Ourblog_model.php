<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ourblog_model extends CI_Model {
		
	
	    public function save_data_blogs($row){
				
		
		$blog_info = [];
	
        foreach ($row as $key => $value) {
            if($key != "id") {
                $blog_info[$key] = $value;
            }
        }
		
		
		
        $blog_info['posted_date'] = date("Y-m-d");
		$this->db->insert('tbl_ourblog', $blog_info);
        return $this->db->insert_id();
        
			
		
	}
	
		public function get_blogs(){
		
		$this->db->select('*');
		$this->db->from('tbl_ourblog');
		$query = $this->db->get();
				
		return $query->result();
		 
		 
	}	 
	
	
	public function delte_blog($id){
										
		$this->db->where('id', $id);
		$query = $this->db->delete('tbl_ourblog');		
		
		return $query;
		 
		 
	}
	
	
	public function approved_blog($id){
										
		$this->db->set('status', 1);  //Set the column name and which value to set..

		$this->db->where('id', $id); //set column_name and value in which row need to update

		$query = $this->db->update('tbl_ourblog'); //Set your table n
		 
		return $query;
		 
	}
	
		public function disapproved_blog($id){
										
		$this->db->set('status', 0);  //Set the column name and which value to set..

		$this->db->where('id', $id); //set column_name and value in which row need to update

		$query = $this->db->update('tbl_ourblog'); //Set your table n
		 
		return $query;
		 
		}
	
	
		public function update_blog($getBlogInfo){
												
		$id = $getBlogInfo['blog_id'];
		$this->db->where('id', $id); 
		unset($getBlogInfo['blog_id']);
		$query = $this->db->update('tbl_ourblog',$getBlogInfo); //Set your table n
		 
		return $query;
		 
		}
	
	
	
	
	
	
}	