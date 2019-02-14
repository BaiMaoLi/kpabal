<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Travel_model extends CI_Model {
	 function __construct(){
            parent::__construct();
            //load our second db and put in $db2
            $this->db2 = $this->load->database('db_travel', TRUE);
        }
  
	public function insertData($table,$data)
{ 
	$this->db2->insert($table, $data);
	return $this->db2->insert_id();
}

public function deleteData($table,$data)
{
	$this->db2->where($data);
	$this->db2->delete($table); 
}
public function updateData($table,$cond=array(),$data=array())
{
	$this->db2->where($cond);
	$this->db2->update($table, $data);
}
    
	 public function getData($table,$cond=array()){
	    $this->db2->select("*");
	    $this->db2->from($table);
	    $this->db2->where($cond);
	    $res=$this->db2->get();
	    //print_r($id);die;
        return $res->result_array();
	}
	

    
}
?>