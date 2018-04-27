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
    
   
}