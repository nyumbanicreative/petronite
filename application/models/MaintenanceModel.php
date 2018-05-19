<?php

Class MaintenanceModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getFuelTypes($station_id) {
          
        $res = $this->db->from('fuel_types f')
                ->where('fuel_type_station_id',$station_id)
                ->get();
        
        return $res->result_array();
    }
    
    public function getFuelTanks($station_id) {
          
        $res = $this->db->from('fuel_tanks t')
                ->join('fuel_types f','f.fuel_type_id = t.fuel_tank_fuel_type_id','INNER')
                ->where('fuel_tank_station_id',$station_id)
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