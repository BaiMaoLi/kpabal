<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * EMTS General Class
 *
 * We made common functions which are use general different part of the project
 *
 */
class General {

    protected $ci;

    private $tableMEMBERS = 'member';
    private $tableSETTING = 'site_setting';

    function __construct($config = array()) {
        $this->ci = & get_instance();

        $query = $this->ci->db->get($this->tableSETTING);
        $result = $query->result();
        foreach ($result as $setting_info) {
            $setting_code = $setting_info->setting_code;
            $setting_value = $setting_info->setting_value;
            defined($setting_code)  OR define($setting_code, $setting_value);
        }
    }

    public function admin_controlpanel_logged_in() {

        if ($this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION) && $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username')) {
            $admin_id = $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
            $username = $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username');            
        } else {
            return FALSE;
        }

        $query = $this->ci->db->get_where($this->tableMEMBERS, array('memberIdx' => $admin_id, 'user_id' => $username, 'is_admin' => 1, 'member_status' => 1), 1);        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function get_user_id() {
        return $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
    }

    public function __gen_aff_track_url_2($__base_url = ""){
        $user_id = ($this->get_user_id())?$this->get_user_id():0;
        $__base_url = str_replace("subid=", "subid=User".$user_id."&", $__base_url);
        $__past_track = sprintf("sub_id=User$user_id&uid=User$user_id&sid=User$user_id&u1=User$user_id&");
        if(strpos($__base_url, "t.cfjump.com") !== false) $__past_track = sprintf("UniqueId=User$user_id&");
        else if(strpos($__base_url, "www.shareasale.com") !== false) $__past_track = sprintf("afftrack=User$user_id&");

        if(strpos($__base_url, "?") !== false)
            return str_replace("?", "?".$__past_track, $__base_url);
            //return $__base_url."&".$__past_track;
        return $__base_url."?".$__past_track;
    }

	public function user_logged_in() {
		return $this->frontend_controlpanel_logged_in();
	}

    public function frontend_controlpanel_logged_in() {

        if ($this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION) && $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username')) {
            $customer_id = $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
            $username = $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');            
        } else {
            return FALSE;
        }

        $query = $this->ci->db->get_where($this->tableMEMBERS, array('memberIdx' => $customer_id, 'user_id' => $username, 'is_admin' => 0, 'member_status' => 1), 1);        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function clean_url($str, $replace = array(), $delimiter = '-') {
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = $str;
        //$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }
    
}

// END Template class

