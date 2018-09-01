<?php

Class UserModel extends CI_Model {

    // Initialize gloabal variables
    var $user_id = null;
    var $station_id = null;
    var $is_logged_in = false;
    var $customer = null;
    var $admin_id = null;
    var $station_new_credit_sales = false;
    var $station_first_day = null;
    var $auto_rtt = 0;
    var $user_system_role = null;
    
    public function __construct() {
        
        // Check if user has logged in using session
        if ($this->isLogedin()) {
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->station_id = $this->session->userdata['logged_in']['user_station_id'];
            $this->admin_id = $this->session->userdata['logged_in']['user_admin_id'];
            $this->auto_rtt = $this->session->userdata['logged_in']['user_station_auto_rtt'];
            $this->is_logged_in = TRUE;
            $this->user_system_role = $this->session->userdata['logged_in']['user_system_role'];
            $this->station_new_credit_sales = $this->session->userdata['logged_in']['user_station_station_new_credit_sales'] == '1'? TRUE:FALSE;
            $this->station_first_day = $this->session->userdata['logged_in']['user_station_first_day'];
        }
    }
    
    public function setSessMsg($msg, $type, $redirect_to = null) {
        $this->session->set_flashdata($type, $msg);
        if (null !== $redirect_to) {
            redirect($redirect_to);
        }
    }

    public function checkStatus($logged_in = null, $customer = null, $admin = null) {

        if (null !== $logged_in AND ! $this->is_logged_in) {
            // User session expired they must login to continue
            $this->setSessMsg('Loging in is required', 'error', 'user/index');
        }


        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            $this->setSessMsg('Select a valid customer', 'error', 'developer/customers');
        }
    }

    public function checkStatusJson($logged_in = null, $customer = null, $admin = null) {

        if (null !== $logged_in AND ! $this->is_logged_in) {
            // User session expired they must login to continue
            cus_json_error('Loging in is required, Please refresh the page');
        }


        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            cus_json_error('Select a valid customer');
        }
    }

    public function getUserInfo($var, $type = null) {


        if ($type == 'ID') {
            $this->db->where('u.user_id', $var);
        } else {
            $this->db->where('u.user_name', $var);
        }

        $this->db->from('users u');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row_array();
        } else {
            return FALSE;
        }
    }

    public function isLogedin() {

        if (isset($this->session->userdata['logged_in'])) {
            return true;
        } else {
            return false;
        }
    }

    public function isDeveloper() {

        if (isset($this->session->userdata['logged_in'])) {

            if ($this->session->userdata['logged_in']['user_system_role'] == 'developer') {
                return true;
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    }

    public function isStationAdmin($user_id, $station_id = null) {
        $res = $this->db->where('user_id', $user_id)->where('user_role', 'admin')->limit(1)->get('users');
        if ($res->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUsersList($cond = null) {


        if (!empty($cond)) {
            $this->db->where($cond);
        }
        $res = $this->db
                ->from('users u')
                ->order_by('u.user_name')
                ->get();

        return $res->result_array();
    }

    public function saveUserDetails($user_data) {

        $this->db->trans_start();
        $this->db->trans_strict(FALSE);

        $this->db->insert('users', $user_data);

        //$user_id = $this->db->insert_id();$this->db->where('user_id', $user_id)->update('users', ['user_admin_id' => $user_id]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function getUserComnissions($user_id) {


        $res = $this->db
                ->from('commission c')
                ->join('subscription subs', 'c.cm_subs_id = subs.subs_id', 'INNER')
                ->join('businesses b', 'subs.subs_business_id = b.business_id')
                ->where('c.cm_user_id', $user_id)
                ->order_by('cm_timestamp', 'DESC')
                ->get();

        return $res->result_array();
    }

    public function getStationsUsers($admin_id) {

        $this->db->select('u.*,st.stations');
        $res = $this->db
                ->from('users u')
                ->join("(SELECT u.user_id, GROUP_CONCAT(DISTINCT s.station_name ORDER BY  s.station_name ASC SEPARATOR ', ') stations "
                        . "FROM ".$this->db->dbprefix."stations s, ".$this->db->dbprefix."organize o, ".$this->db->dbprefix."users u "
                        . "WHERE o.organize_station_id = s.station_id AND o.organize_user_id = u.user_id "
                        . "GROUP BY u.user_id) st", "st.user_id = u.user_id", "LEFT OUTER")
                ->where("u.user_id <> u.user_admin_id AND (u.user_role ='manager' OR u.user_role = 'station_admin' OR u.user_role = 'admin' OR u.user_role = 'station_manager')")
                ->where(["u.user_admin_id" =>$admin_id])
                ->order_by('u.user_name')
                ->get();

        return $res->result_array();
    }
    
    
    public function saveEditUser($user_data, $user_id) {
        
        $this->db->where('user_id',$user_id)->update('users',$user_data);
        
        return $this->db->affected_rows();
        
    }

}
