<?php
class Email_templates_model extends CI_Model 
{
	private $table_name = 'email_templates';
	private $primary_key = 'ID';
	
	 public function __construct()
     {
        parent::__construct();
		// $this->load->database();
        $this->datingdb = $this->load->database('db_dating', TRUE);
     }
	
	public function add($data)
	{
            $return = $this->datingdb->insert($this->table_name, $data);
            if ((bool) $return === TRUE) {
                return $this->datingdb->insert_id();
            } else {
                return $return;
            }   
	}	
	
	public function update($id, $data)
	{
		$this->datingdb->where('ID', $id);
		$return=$this->datingdb->update($this->table_name, $data);
		return $return;
	}
	
	public function delete($id)
	{
		$this->datingdb->where('ID', $id);
		$this->datingdb->delete($this->table_name);
	}

	public function all_records($per_page, $page) 
	{
        $this->datingdb->select('*');
        $this->datingdb->from($this->table_name);
		$this->datingdb->order_by($this->primary_key, "DESC"); 
		$this->datingdb->limit($per_page, $page);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	
	public function get_record_by_id($id) 
	{
        $this->datingdb->select('*');
        $this->datingdb->from($this->table_name);
		$this->datingdb->where($this->table_name.'.ID',$id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	public function record_by_slug($slug) 
	{
        $this->datingdb->select('*');
        $this->datingdb->from($this->table_name);
		$this->datingdb->where($this->table_name.'.slug',$slug);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->row();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	
	public function all_parent_records() 
	{
        $this->datingdb->select('ID, title_en');
        $this->datingdb->from($this->table_name);
		$this->datingdb->order_by('title_en', "ASC"); 
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = $Q->result();
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }
	
	public function record_count($table_name) 
	{
		return $this->datingdb->count_all($table_name);
    }
	
}
?>
