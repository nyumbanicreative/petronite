<?php

Class MaintenanceModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getFuelTypes($station_id) {
          
        $res = $this->db->from('fuel_types ft')
                ->join('fuel_types_group ftg','ftg.fuel_type_group_id = ft.fuel_type_fuel_type_group_id','LEFT OUTER')
                ->where('ft.fuel_type_station_id',$station_id)
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
    
    public function getPumps($station_id) {
          
        $res = $this->db->from('pumps p')
                ->join('fuel_tanks t','t.fuel_tank_id = p.pump_fuel_tank_id','INNER')
                ->join('fuel_types f','f.fuel_type_id = t.fuel_tank_fuel_type_id','INNER')
                ->where('p.pump_station_id',$station_id)
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
    
    public function getStationAttendants($station_id) {
        
        $res = $this->db->from('users')
                ->where('user_role','attendant')
                ->where('user_station_id',$station_id)
                ->get();
        
        return $res->result_array();
    }
    
    
    public function getShifts($station_id) {
        
        $res = $this->db->from('shifts')
                ->where('shift_station_id',$station_id)
                ->get();
        
        return $res->result_array();
    }
    
   
}