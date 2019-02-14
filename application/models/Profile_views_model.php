<?php
class Profile_Views_Model extends CI_Model
{

    protected $datingdb;

    public function __construct()
    {
        // parent::__construct();
        // $this->load->database();
        $this->datingdb = $this->load->database('db_dating', true);
    }

    public function add_profile_viewer($data)
    {

        $this->datingdb->insert('profile_views', $data);

    }

    public function is_ip_already_viewed_profile($member_id)
    {

        $this->datingdb->select('id');
        $this->datingdb->from('profile_views');
        $this->datingdb->where("ip_address", $this->input->ip_address());
        $this->datingdb->where("member_id", $member_id);
        $Q = $this->datingdb->get();
        if ($Q->num_rows() > 0) {
            $return = 1;
        } else {
            $return = 0;
        }
        $Q->free_result();
        return $return;
    }

    public function count_profile_views($member_id)
    {

        $this->datingdb->where('member_id', $member_id);
        $this->datingdb->from('profile_views');
        return $this->datingdb->count_all_results();
    }

}
