<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    private $tableMEMBERS = 'member';

    public $validate_rules_login = array(
        array('field' => 'name', 'label' => 'Username', 'rules' => 'required|min_length[6]|max_length[12]'),
        array('field' => 'pass', 'label' => 'Password', 'rules' => 'required|min_length[8]')
    );

    public function check_login() {

        $password_tmp = $this->input->post('pass');
        $query = $this->db->get_where($this->tableMEMBERS, array('user_id' => $this->input->post('name'), 'is_admin' => 1));

        if ($query->num_rows() > 0) {            
            $data = $query->row();

            $secure_code = ADMIN_LOGIN_SECURE_CODE;

            $pwd_hash = hash('sha512', $password_tmp . $secure_code . $data->user_salt);
            //echo $pwd_hash; exit();

            if (strcmp($data->user_password, $pwd_hash) == 0) {                
                return $data;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    public function check_customer_login() {

        $password_tmp = $this->input->post('pass');
        $query = $this->db->get_where($this->tableMEMBERS, array('user_id' => $this->input->post('name'), 'is_admin' => 0));

        if ($query->num_rows() > 0) {            
            $data = $query->row();

            $secure_code = ADMIN_LOGIN_SECURE_CODE;

            $pwd_hash = hash('sha512', $password_tmp . $secure_code . $data->user_salt);
            //echo $pwd_hash; exit();

            if (strcmp($data->user_password, $pwd_hash) == 0) {                
                return $data;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    public function store_login($user) {

        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        $login_string = hash('sha512', $user->user_id . $user_browser); //Login String is used to differentiate the browser session

        /* Store Session */
        $newdata = array(
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION => $user->memberIdx,
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username' => $user->user_id,
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname' => $user->first_name,
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname' => $user->last_name,
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'regdate' => $user->register_date,
            SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'image' => $user->avatar,
        );

        $this->session->set_userdata($newdata);

        /* If remember Password  Save the cookies or delete the cokkies */

        if ($this->input->post('rememberme') == 'Y') {
            $this->load->helper('cookie');

            $cookie1 = array(
                'name' => SESSION_DOMAIN . ADMIN_LOGIN_SESSION,
                'value' => $user->memberIdx,
                'expire' => COOKIE_EXPIRE_TIME
            );

            $cookie2 = array(
                'name' => SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'email',
                'value' => $user->user_email,
                'expire' => COOKIE_EXPIRE_TIME
            );

            $this->input->set_cookie($cookie1);
            $this->input->set_cookie($cookie2);
        }
    }
    public function store_customer_login($user) {

        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        $login_string = hash('sha512', $user->user_id . $user_browser); //Login String is used to differentiate the browser session

        /* Store Session */
        $newdata = array(
            SESSION_DOMAIN . USER_LOGIN_SESSION => $user->memberIdx,
            SESSION_DOMAIN . USER_LOGIN_SESSION . 'username' => $user->user_id,
            SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname' => $user->first_name,
            SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname' => $user->last_name,
            SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate' => $user->register_date,
            SESSION_DOMAIN . USER_LOGIN_SESSION . 'image' => $user->avatar,
        );

        $this->session->set_userdata($newdata);

        /* If remember Password  Save the cookies or delete the cokkies */

        if ($this->input->post('rememberme') == 'Y') {
            $this->load->helper('cookie');

            $cookie1 = array(
                'name' => SESSION_DOMAIN . USER_LOGIN_SESSION,
                'value' => $user->memberIdx,
                'expire' => COOKIE_EXPIRE_TIME
            );

            $cookie2 = array(
                'name' => SESSION_DOMAIN . USER_LOGIN_SESSION . 'email',
                'value' => $user->user_email,
                'expire' => COOKIE_EXPIRE_TIME
            );

            $this->input->set_cookie($cookie1);
            $this->input->set_cookie($cookie2);
        }
    }

    public function user_logout() {
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate');
        $this->session->set_flashdata('login_message', '');

        $this->load->helper('cookie');
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION);
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION . 'email');
    }
}
