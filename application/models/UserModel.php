<?php

Class UserModel extends CI_Model {

    public function __construct() {
        
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

        $user_id = $this->db->insert_id();

        $this->db->where('user_id', $user_id)->update('users', ['user_admin_id' => $user_id]);

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
    

}
