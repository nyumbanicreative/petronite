<?php

Class CustomerModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getPetroniteCustomers() {
          
        $res = $this->db->from('petronite_customers pc')
                ->join('users u','pc.pc_admin_id = u.user_id','LEFT OUTER')
                ->join('(SELECT station_admin_id, COUNT(station_admin_id) total_stations '
                        . 'FROM tbl_stations GROUP BY station_admin_id) ts','ts.station_admin_id = u.user_id','LEFT OUTER')
                ->order_by('pc.pc_name','ACS')
                ->get();
        
        return $res->result_array();
    }
    
    public function getCustomerDetails($admin_id) {
        
        $res = $this->db->where('pc_admin_id',$admin_id)->limit(1)->get('petronite_customers');
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    
    public function getStationCustomers($admin_id) {
        
        $res = $this->db
                ->from('credit_types ct')
                ->join("(SELECT "
                        . "c.credit_type_station_credit_type_id,  "
                        . "GROUP_CONCAT(DISTINCT s.station_name ORDER BY  s.station_name ASC SEPARATOR ', ') stations "
                        . "FROM ".$this->db->dbprefix."credit_type_stations c, ".$this->db->dbprefix."stations s "
                        . "WHERE c.credit_type_station_station_id = s.station_id "
                        . "GROUP BY credit_type_station_credit_type_id) cts",
                        "cts.credit_type_station_credit_type_id = ct.credit_type_id","LEFT OUTER")
                ->order_by('ct.credit_type_name')
                ->where('ct.credit_type_admin_id',$admin_id)
                ->get();
        
        return $res->result_array();
    }
    
    public function getStationSuppliers($admin_id) {
        
       
    }
    
   
}